<?php


class ApprehendedConsumerModel extends CI_Model {

    private $affected_id=0;

    private $error=array(
        'stat'=>'error',
        'msg'=>'Sorry, error has occurred.'
    );

    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }


    function ReturnApprehendedConsumerList($account_id=0){
        $rows=array();
        $sql="SELECT
					CONCAT_WS('|',
                        a.bill_account_id,
						a.consumer_id,
						b.house_no,
						b.street_no,
						b.barangay,
						b.municipality,
						b.zip_code,
						b.province,
						b.email,
						a.down_payment,
						a.no_of_days,
						DATE_FORMAT(a.payment_start_date,'%m/%d/%Y'),
						a.duration,
						a.payment_schedule_remarks,
						a.amount_kwh,
						a.total_back_bill_amount,
						a.account_total_kwh
					)as record_info,
					a.reference_no,
                    a.account_no,
					CONCAT_WS('|',
							a.consumer_id,
							b.consumer_name
					)as consumer,
					CONCAT_WS(', ',b.house_no,
						b.street_no,
						b.barangay,
						b.municipality,
						b.province)as consumer_address,
					b.consumer_name,
					b.contact_no,
                    a.total_back_bill_amount,o.TotalPayment,
                    (a.total_back_bill_amount-IFNULL(o.TotalPayment,0)) as TotalBalance,
                    n.period
                                           FROM
					bill_account_info as a
				LEFT JOIN
					customer_info as b ON a.consumer_id=b.consumer_id

                LEFT JOIN

                (
                SELECT a.bill_account_id,SUM(b.payment_amount)as TotalPayment FROM payment_info as a
                    INNER JOIN payment_item_list as b ON a.payment_id=b.payment_id
                    WHERE b.is_active=1
                    GROUP BY a.bill_account_id
                )as o ON a.bill_account_id=o.bill_account_id

                LEFT JOIN

                (SELECT a.bill_account_id,
                      CONCAT(
                          DATE_FORMAT(MIN(a.sched_payment_date),'%m/%d/%Y')
                          ,' to ',
                          DATE_FORMAT(MAX(a.sched_payment_date),'%m/%d/%Y')) as Period
                      FROM bill_payment_schedule as a
                      GROUP BY a.bill_account_id
                )as n
                    ON a.bill_account_id=n.bill_account_id

				WHERE
					a.is_deleted=FALSE
					".($account_id!=0?" AND a.bill_account_id=$account_id":"");

        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
            $rows[]=$row; //assign each row of query in array
        }

        return $rows;
    }


    function ReturnConsumerActiveList(){
        $rows=array();
        $sql="SELECT
                    a.bill_account_id,
					a.account_no,
					b.consumer_id,
                    b.consumer_name as consumer
                FROM
					bill_account_info as a
				LEFT JOIN
					customer_info as b ON a.consumer_id=b.consumer_id

                LEFT JOIN

                (SELECT a.bill_account_id,
                      CONCAT(
                          DATE_FORMAT(MIN(a.sched_payment_date),'%m/%d/%Y')
                          ,' to ',
                          DATE_FORMAT(MAX(a.sched_payment_date),'%m/%d/%Y')) as Period
                      FROM bill_payment_schedule as a
                      GROUP BY a.bill_account_id
                )as n
                    ON a.bill_account_id=n.bill_account_id

				WHERE
					a.is_deleted=FALSE
					";

        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
            $rows[]=$row; //assign each row of query in array
        }

        return $rows;
    }



    function ReturnAccountCartItems($id){
        /***
         * LOGICAL ERROR! line kwh must the field to be return not the estimated
         */


        $rows=array();
        $sql="SELECT
				CONCAT_WS('|',a.unit_id,b.unit_description)as item,
				/*b.estimated_kwh,*/
				a.line_kwh as estimated_kwh,
				a.line_total,
				a.unit_qty,
				a.hours
				FROM bill_unit_list as a
				LEFT JOIN unit_info as b
				ON a.unit_id=b.unit_id
			WHERE a.bill_account_id=$id";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
            $rows[]=$row; //assign each row of query in array
        }

        return $rows;
    }



    function ReturnPaymentScheduleItems($id){
        $rows=array();
        $sql="SELECT
				DATE_FORMAT(b.sched_payment_date,'%m/%d/%Y') as sched_payment_date,
				b.due_amount,
				b.bill_description
				FROM bill_account_info as a
				LEFT JOIN bill_payment_schedule as b
				ON a.bill_account_id=b.bill_account_id
			WHERE a.bill_account_id=$id";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
            $rows[]=$row; //assign each row of query in array
        }

        return $rows;
    }


    //Reminder : move this to Unit Item Model if already created
    function ReturnUnitItemList(){
        $rows=array();
        $sql="SELECT
                unit_id as id,
				CONCAT_WS('  ',unit_description,brand_name,model_name) as name,
				unit_description as description,
				estimated_kwh as kwh
			FROM
			  unit_info";

        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
            $rows[]=$row; //assign each row of query in array
        }

        return $rows;
    }



    function UpdateApprehendAccount(){
        try{

            /**
             * CONSUMER INFO UPDATE
             */
            //array of data to be inserted
            $this->db->trans_start(); //start transaction

            $bill_account_id=$this->input->post('id',TRUE);
            $consumer_id = $this->input->post('consumer_id',TRUE);

            $data = array(
                'consumer_name' => $this->input->post('consumer_name',TRUE),
                'house_no'=>$this->input->post('house_no',TRUE),
                'street_no'=>$this->input->post('street_no',TRUE),
                /* post data name is different*/

                'barangay'=>$this->input->post('barangay',TRUE),
                'municipality'=>$this->input->post('municipality',TRUE),
               /*
                    ******************No Post Data Found********************
                    'province'=>$this->input->post('province',TRUE),

               */
                'house_no'=>$this->input->post('house_no',TRUE),
                'contact_no'=>$this->input->post('contact_no',TRUE),
                'email'=>$this->input->post('email',TRUE),

            );
            $this->db->set('date_modified', 'NOW()', FALSE);
            $this->db->where('consumer_id',$consumer_id);
            $this->db->update('customer_info',$data) or die(json_encode($this->error));


            /**
             * Apprehended Consumer Account update
             */
            $data = array(
                'reference_no' => $this->input->post('reference_no',TRUE),
                'account_no'=>$this->input->post('account_no',TRUE),
                'consumer_id'=>$consumer_id,
                'is_active'=>1,

                /*** ERROR FOUND! Post Data Name is different!
                'payment_start_date' => date('Y-m-d',strtotime($this->input->post('payment_start_date',TRUE))),
                **/
                'payment_start_date' => date('Y-m-d',strtotime($this->input->post('payment_start',TRUE))),
                'duration' => $this->input->post('duration',TRUE),
                'payment_schedule_remarks' => $this->input->post('payment_schedule_remarks',TRUE),
                'down_payment' => $this->input->post('down_payment',TRUE),
                'no_of_days' => $this->input->post('no_of_days',TRUE),
                'amount_kwh' => $this->input->post('amount_kwh',TRUE),
                'total_back_bill_amount' => $this->input->post('total_back_bill_amount',TRUE)


            );

            $this->db->set('date_modified', 'NOW()', FALSE);
            $this->db->where('bill_account_id',$bill_account_id);
            $this->db->update('bill_account_info',$data) or die(json_encode($this->error));


            /***
             * LIST OF APPLIANCES
             */
            $this->db->where('bill_account_id',$bill_account_id);
            $this->db->delete('bill_unit_list') or die(json_encode($this->error));

            $unit_id=$this->input->post('unit_id',TRUE);
            $line_kwh=$this->input->post('line_kwh',TRUE);
            //$line_total=$this->input->post('line_total',TRUE);
            $unit_qty=$this->input->post('unit_qty',TRUE);
            $hours=$this->input->post('hours',TRUE);
            $datas = array();

            /**
             *MISSING FIELD!
             *
             */
            for($i=0;$i<=count($unit_id)-1;$i++){
                $datas[]=array(
                    'bill_account_id'=>$bill_account_id,
                    'unit_id'=>$unit_id[$i],
                    'unit_qty'=>$unit_qty[$i],
                    'hours'=>$hours[$i],
                    'line_total'=>$line_kwh[$i]*$hours[$i]*$unit_qty[$i],
                    'line_kwh'=>$line_kwh[$i]
                );
            }

            $this->db->insert_batch('bill_unit_list', $datas);

            /**
             * LIST OF PAYMENT SCHEDULE
             */
            $this->db->where('bill_account_id',$bill_account_id);
            $this->db->delete('bill_payment_schedule') or die(json_encode($this->error));

            $sched_payment_date = $this->input->post('sched_payment_date',TRUE);
            $due_amount=$this->input->post('due_amount',TRUE);
            $bill_description=$this->input->post('bill_description',TRUE);
            $datas = array();

            for($i=0;$i<=count($due_amount)-1;$i++){
                $datas[]=array(
                    'item_id'=>$i,
                    'bill_item_account_id'=>$bill_account_id.$i,
                    'bill_account_id'=>$bill_account_id,
                    'sched_payment_date'=>date('Y-m-d',strtotime($sched_payment_date[$i])),
                    'due_amount'=>$due_amount[$i],
                    'bill_description'=>$bill_description[$i],
                );
            }

            $this->db->insert_batch('bill_payment_schedule', $datas);







            $this->affected_id=$bill_account_id;	//last insert id, the sales invoice	id

            $this->db->trans_complete(); //end transaction
            return true;
        }catch(Exception $e){
            die(json_encode($this->error));
        }


    }



    function CreateApprehendedAccount(){
        try{
            //array of data to be inserted
            $this->db->trans_start(); //start transaction
            $data = array(
                'consumer_name' => $this->input->post('consumer_name',TRUE),
                'house_no'=>$this->input->post('house_no',TRUE),
                'street_no'=>$this->input->post('street_no',TRUE),
                'barangay'=>$this->input->post('barangay',TRUE),
                'municipality'=>$this->input->post('municipality',TRUE),
                'house_no'=>$this->input->post('house_no',TRUE),
                'contact_no'=>$this->input->post('contact_no',TRUE),
                'email'=>$this->input->post('email',TRUE),

            );
            $this->db->set('date_created', 'NOW()', FALSE);
            $this->db->insert('customer_info',$data) or die(json_encode($this->error));

            $consumer_id=$this->db->insert_id();

            $data = array(
                'reference_no' => $this->input->post('reference_no',TRUE),
                'account_no'=>$this->input->post('account_no',TRUE),
                'consumer_id'=>$consumer_id,
                'is_active'=>1,

                /***ERROR FOUND! Post Data Name is different!***/
                /*'payment_start_date' => date('Y-m-d',strtotime($this->input->post('payment_start_date',TRUE))),*/

                'payment_start_date' => date('Y-m-d',strtotime($this->input->post('payment_start',TRUE))),

                'duration' => $this->input->post('duration',TRUE),
                'payment_schedule_remarks' => $this->input->post('payment_schedule_remarks',TRUE),
                'down_payment' => $this->input->post('down_payment',TRUE),
                'down_payment_date' => date('Y-m-d',strtotime($this->input->post('date_paid',TRUE))),
                'down_payment_receipt_no' => $this->input->post('receipt_no',TRUE),
                'no_of_days' => $this->input->post('no_of_days',TRUE),
                'amount_kwh' => $this->input->post('amount_kwh',TRUE),
                'total_back_bill_amount' => $this->input->post('total_back_bill_amount',TRUE),
                'account_total_kwh' => $this->input->post('total_kwh',TRUE)


            );

            $this->db->set('date_created', 'NOW()', FALSE);
            $this->db->insert('bill_account_info',$data) or die(json_encode($this->error));
            $bill_account_id=$this->db->insert_id();

            $unit_id=$this->input->post('unit_id',TRUE);
            $line_kwh=$this->input->post('line_kwh',TRUE);
            //$line_total=$this->input->post('line_total',TRUE);
            $unit_qty=$this->input->post('unit_qty',TRUE);
            $hours=$this->input->post('hours',TRUE);
            $datas = array();

            /**
             *MISSING FIELD!
             *
             */
            for($i=0;$i<=count($unit_id)-1;$i++){
                $datas[]=array(
                    'bill_account_id'=>$bill_account_id,
                    'unit_id'=>$unit_id[$i],
                    'unit_qty'=>$unit_qty[$i],
                    'hours'=>$hours[$i],
                    'line_total'=>$line_kwh[$i]*$hours[$i]*$unit_qty[$i],
                    'line_kwh'=>$line_kwh[$i]
                );
            }

            $this->db->insert_batch('bill_unit_list', $datas);

            //array of data sent by js

            $sched_payment_date = $this->input->post('sched_payment_date',TRUE);
            $due_amount=$this->input->post('due_amount',TRUE);
            $bill_description=$this->input->post('bill_description',TRUE);
            $datas = array();

            for($i=0;$i<=count($due_amount)-1;$i++){
                $datas[]=array(
                    'item_id'=>$i,
                    'bill_item_account_id'=>$bill_account_id.$i,
                    'bill_account_id'=>$bill_account_id,
                    'sched_payment_date'=>date('Y-m-d',strtotime($sched_payment_date[$i])),
                    'due_amount'=>$due_amount[$i],
                    'bill_description'=>$bill_description[$i],
                );
            }

            $this->db->insert_batch('bill_payment_schedule', $datas);
            $this->affected_id=$bill_account_id;	//last insert id, the sales invoice	id
            $this->db->trans_complete(); //end transaction
            return true;
        }catch(Exception $e){
            die(json_encode($this->error));
        }
    }



    function ReturnLastAffectedRowDetails(){
        $rows=array();
        $sql="SELECT
    					CONCAT_WS('|',
                        a.bill_account_id,
						a.consumer_id,
						b.house_no,
						b.street_no,
						b.barangay,
						b.municipality,
						b.zip_code,
						b.province,
						b.email,
						a.down_payment,
						a.no_of_days,
						DATE_FORMAT(a.payment_start_date,'%m/%d/%Y'),
						a.duration,
						a.payment_schedule_remarks,
						a.amount_kwh,
						a.total_back_bill_amount,
						a.account_total_kwh

					)as record_info,
					a.reference_no,
                    a.account_no,
					CONCAT_WS('|',
							a.consumer_id,
							b.consumer_name
					)as consumer,
					b.contact_no,
					(a.total_back_bill_amount-IFNULL(o.TotalPayment,0)) as TotalBalance,
                    a.total_back_bill_amount,
                    n.period
                                           FROM
					bill_account_info as a
			LEFT JOIN
					customer_info as b ON a.consumer_id=b.consumer_id
					
					
			LEFT JOIN
                (SELECT a.bill_account_id,SUM(b.payment_amount)as TotalPayment FROM payment_info as a
                    INNER JOIN payment_item_list as b ON a.payment_id=b.payment_id
                    WHERE b.is_active=1
                    GROUP BY a.bill_account_id
                )as o ON a.bill_account_id=o.bill_account_id

                

            LEFT JOIN

                (SELECT a.bill_account_id,
                      CONCAT(
                          DATE_FORMAT(MIN(a.sched_payment_date),'%m/%d/%Y')
                          ,' to ',
                          DATE_FORMAT(MAX(a.sched_payment_date),'%m/%d/%Y')) as Period
                      FROM bill_payment_schedule as a
                      GROUP BY a.bill_account_id
                )as n
                    ON a.bill_account_id=n.bill_account_id

            WHERE
                    a.bill_account_id=".$this->affected_id;
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) //this will return only 1 row
        {
            $rows[]=$row; //assign each row of query in array
        }
        return $rows;
    }



    function ShowCurrentAccountSchedule($id){
        $rows=array();
        $sql="SELECT
                  a.item_id,DATE_FORMAT(a.sched_payment_date,'%m/%d/%Y')as sched_payment_date,a.bill_description,a.due_amount
              FROM
                  bill_payment_schedule as a
              WHERE
                a.bill_account_id=$id";

        $query = $this->db->query($sql);
        foreach ($query->result() as $row) //this will return only 1 row
        {
            $rows[]=$row; //assign each row of query in array
        }
        return $rows;

    }



    function GetConsumerLedger($id){
        $rows=array();
        $sql="SET @vRunningBalance:=0.00;";
        $this->db->query($sql);

        $sql="SELECT
              n.*,@vRunningBalance:=(@vRunningBalance+(n.Debit-n.Credit))as Balance,DATE_FORMAT(n.txnDate,'%M %d, %Y')as TransDate
          FROM
                (SELECT m.*
                FROM
                (SELECT b.bill_account_id,b.account_no,'' as receipt_no,
                a.sched_payment_date as TxnDate,
                CONCAT('Due @ ',DATE_FORMAT(a.sched_payment_date,'%M %d, %Y'))as Description,
                a.due_amount as Debit,0 as Credit
                FROM bill_payment_schedule as a
                INNER JOIN bill_account_info as b ON
                a.bill_account_id=b.bill_account_id WHERE b.is_active=1
                AND b.is_deleted=0 AND b.bill_account_id=$id


                UNION ALL


                SELECT a.bill_account_id,'' as account_no,b.receipt_no,b.date_paid as TxnDate,
                ('Payment')as Description,0 as Debit,b.payment_amount as Credit
                FROM payment_info as a
                INNER JOIN payment_item_list as b ON a.payment_id=b.payment_id
                WHERE b.is_active=1 AND a.bill_account_id=$id)as m ORDER BY m.TxnDate ASC)as n";
        $query = $this->db->query($sql);

        foreach ($query->result() as $row) //this will return only 1 row
        {
            $rows[]=$row; //assign each row of query in array
        }

        return $rows;
    }



    function GetDelinquentList(){
        $rows=array();
                $sql="SELECT g.*
        FROM
        (SELECT cs.*,
        IFNULL(cs.tp.TotalPayment,0)as TotalPayment,
        (cs.ApprehendedAmount-IFNULL(tp.TotalPayment,0))as TotalBalance,
        IFNULL(pm.PaymentsMade,0)as PaymentsMade,
        IFNULL(del.DelayedMonths,0)as DelayedMonths,
        (IFNULL(accum.AccumulatedBalance,0)-IFNULL(tp.TotalPayment,0))As PreviousBalance

        FROM

        (SELECT a.bill_account_id,a.account_no,b.consumer_name,
        a.total_back_bill_amount as ApprehendedAmount
        FROM bill_account_info as a
        LEFT JOIN customer_info as b ON a.consumer_id=b.consumer_id
        WHERE a.is_active=1 AND a.is_deleted=0)As cs


        LEFT JOIN


        (SELECT a.bill_account_id,SUM(b.payment_amount)as TotalPayment FROM payment_info as a
        INNER JOIN payment_item_list as b ON a.payment_id=b.payment_id WHERE b.is_active=1
        GROUP BY a.bill_account_id)as tp

        ON cs.bill_account_id=tp.bill_account_id


        LEFT JOIN


        (SELECT a.bill_account_id,COUNT(a.sched_payment_date)as DelayedMonths FROM bill_payment_schedule as a
        WHERE a.is_paid=0 AND a.sched_payment_date<=NOW()
        GROUP BY a.bill_account_id)as del


        ON cs.bill_account_id=del.bill_account_id


        LEFT JOIN


        (SELECT a.bill_account_id,SUM(a.due_amount)As AccumulatedBalance FROM bill_payment_schedule as a
        WHERE a.sched_payment_date<=NOW()
        GROUP BY a.bill_account_id)as accum

        ON cs.bill_account_id=accum.bill_account_id



        LEFT JOIN


        (SELECT m.bill_account_id,COUNT(m.receipt_no)as PaymentsMade
        FROM
        (SELECT a.bill_account_id,b.receipt_no FROM payment_info as a
        INNER JOIN payment_item_list as b ON a.payment_id=b.payment_id
        WHERE b.is_active=1
        GROUP BY a.bill_account_id,b.receipt_no)as m
        GROUP BY m.bill_account_id)as pm


        ON cs.bill_account_id=pm.bill_account_id)as g
        WHERE g.DelayedMonths>0 ORDER By g.DelayedMonths DESC,g.consumer_name ASC";

        $query = $this->db->query($sql);
        foreach ($query->result() as $row) //this will return only 1 row
        {
            $rows[]=$row; //assign each row of query in array
        }
        return $rows;
    }


}






