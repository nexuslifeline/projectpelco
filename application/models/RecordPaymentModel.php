<?php

class RecordPaymentModel extends CI_Model
{
    private $affected_id = 0;

    private $error = array(
        'stat' => 'error',
        'msg' => 'Sorry, error has occurred.'
    );


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }


    function ShowScheduleBalances($account_id){
        $rows=array();


        $sql="SELECT p.* FROM(SELECT o.*,(o.due_amount-o.PaidAmount)as Remaining
                FROM
                (SELECT n.*,IFNULL(m.payment_amount,0)as PaidAmount
                FROM
                (SELECT
                a.item_id,a.bill_item_account_id,
                DATE_FORMAT(a.sched_payment_date,'%M %d, %Y')as sched_payment_date,
                a.bill_description,a.due_amount
                FROM
                bill_payment_schedule as a WHERE a.bill_account_id=$account_id)as n


                LEFT JOIN

                (SELECT a.bill_item_account_id,SUM(a.payment_amount)as payment_amount
                FROM payment_item_list as a
                WHERE a.is_active=1
                GROUP BY a.bill_item_account_id
                ) as m

                ON n.bill_item_account_id=m.bill_item_account_id)as o)as p WHERE p.Remaining>0 ORDER BY p.item_id";


        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
            $rows[]=$row; //assign each row of query in array
        }

        return $rows;


    }




    function SaveNewPayment(){
        try{
            $accountid=$this->input->post('accountid');

            $data=array(
                'bill_account_id'=>$accountid
            );

            $this->db->set('date_created', 'NOW()', FALSE);
            $this->db->set('consumer_id', '(SELECT consumer_id FROM bill_account_info WHERE bill_account_id='.$accountid.')', FALSE);
            $this->db->insert('payment_info',$data) or die(json_encode($this->error));
            $paymentid=$this->db->insert_id();

            $payment=$this->input->post('payamount');
            $txndate=$this->input->post('txndate');
            $receiptno=$this->input->post('receiptno');
            $description=$this->input->post('description');
            $itemid=$this->input->post('itemid');
            $dueamount=$this->input->post('dueamount');


            $datas = array();
            for($i=0;$i<=count($receiptno)-1;$i++){

                if($dueamount[$i]==$payment[$i]){
                    $this->db->set('is_paid', '1', FALSE);
                    $this->db->where('bill_account_id='.$accountid.' AND item_id='.$itemid[$i]);
                    $this->db->update('bill_payment_schedule') or die(json_encode($this->error));
                }


                $datas[]=array(
                    'payment_id'=>$paymentid,
                    'item_id'=>$itemid[$i],
                    'payment_amount'=>$payment[$i],
                    'bill_item_account_id'=>$accountid.$itemid[$i],
                    'receipt_no'=>$receiptno[$i],
                    'item_description'=>'Billed @ '.$description[$i],
                    'date_paid'=>date('Y-m-d',strtotime($txndate[$i]))
                );
            }
            $this->db->insert_batch('payment_item_list', $datas);

            $this->affected_id=$paymentid;
            return true;

        }catch(Exception $e){
            die(json_encode($this->error));
        }







    }


    function ShowLastPaidList(){
        $rows=array();
        $sql="SELECT
                a.payment_id,a.date_paid,
                a.receipt_no,c.account_no,
                d.consumer_name,
                a.payment_amount,a.is_active,a.item_description
            FROM payment_item_list as a
            INNER JOIN ((payment_info as b
            LEFT JOIN customer_info as d ON b.consumer_id=d.consumer_id)
            LEFT JOIN bill_account_info as c
            ON b.bill_account_id=c.bill_account_id)
            ON a.payment_id=b.payment_id WHERE a.payment_id=".$this->affected_id;
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) //this will return only 1 row
        {
            $rows[]=$row; //assign each row of query in array
        }
        return $rows;
    }



    function ShowAllPaymentList(){
        $rows=array();
        $sql="SELECT
                a.payment_id,a.date_paid,
                a.receipt_no,c.account_no,
                d.consumer_name,
                a.payment_amount,a.is_active,a.item_description
            FROM payment_item_list as a
            INNER JOIN ((payment_info as b
            LEFT JOIN customer_info as d ON b.consumer_id=d.consumer_id)
            LEFT JOIN bill_account_info as c
            ON b.bill_account_id=c.bill_account_id)
            ON a.payment_id=b.payment_id";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) //this will return only 1 row
        {
            $rows[]=$row; //assign each row of query in array
        }
        return $rows;
    }



   function ReturnCancelReceipt(){
       try{
           $receipt_no = $this->input->post('receipt_no');
           $this -> db -> set('is_active',0);
           $this -> db -> update('payment_item_list');
           $this -> db -> where('receipt_no', $receipt_no);
           return true;
       }catch(Exception $e){
           die(json_encode($this->error));
       }
   }




    function ReturnCollectionList($start=NULL,$end=NULL,$param=""){

        $start=($start==NULL?date('Y-m-d'):date('Y-m-d',strtotime($start)));
        $end=($end==NULL?date('Y-m-d'):date('Y-m-d',strtotime($end)));

        $rows=array();
        $sql="SELECT m.* FROM
            (
                    SELECT a.down_payment_date as date_paid,a.down_payment_receipt_no as receipt_no,
                    a.account_no,b.consumer_name,
                    'Downpayment.' as description,a.down_payment as amount_paid, 'Active' as is_active
                    FROM bill_account_info as a
                    LEFT JOIN customer_info as b ON a.consumer_id=b.consumer_id
                    WHERE a.down_payment>0 AND a.down_payment_date BETWEEN '$start' AND '$end'
                    ".($param==""?"":" AND (a.down_payment_receipt_no LIKE '$param%' OR a.account_no LIKE '$param%' OR b.consumer_name LIKE '$param%')")."

                    UNION ALL


                    SELECT a.date_paid,a.receipt_no,c.account_no,d.consumer_name,
                    '' as description,SUM(a.payment_amount)as amount_paid,IF(a.is_active,'Active','Cancelled')as is_active
                    FROM payment_item_list as a
                    INNER JOIN (payment_info as b
                    LEFT JOIN (bill_account_info as c
                    LEFT JOIN customer_info as d ON c.consumer_id=d.consumer_id) ON
                    b.bill_account_id=c.bill_account_id) ON a.payment_id=b.payment_id
                    WHERE a.date_paid BETWEEN '$start' AND '$end'
                    ".($param==""?"":" AND (a.receipt_no LIKE '$param%' OR c.account_no LIKE '$param%' OR d.consumer_name LIKE '$param%')")."
                    GROUP BY a.receipt_no
          )as m ORDER BY m.date_paid,m.receipt_no ASC";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) //this will return only 1 row
        {
            $rows[]=$row; //assign each row of query in array
        }
        return $rows;

    }



}

?>