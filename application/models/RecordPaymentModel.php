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


            $datas = array();
            for($i=0;$i<=count($receiptno)-1;$i++){
                $datas[]=array(
                    'payment_id'=>$paymentid,
                    'item_id'=>$itemid[$i],
                    'payment_amount'=>$payment[$i],
                    'bill_item_account_id'=>$accountid.$itemid[$i],
                    'receipt_no'=>$receiptno[$i],
                    'item_description'=>'Billed @ '.$description[$i],
                    'date_paid'=>'0000-00-00'
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

}

?>