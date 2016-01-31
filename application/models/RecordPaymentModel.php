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

        $sql="SELECT
                  a.item_id,DATE_FORMAT(a.sched_payment_date,'%M %d, %Y')as sched_payment_date,a.bill_description,a.due_amount
              FROM
                  bill_payment_schedule
              /**
              add payment query here
              */
              as a WHERE a.bill_account_id=$account_id
        ";

        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
            $rows[]=$row; //assign each row of query in array
        }

        return $rows;


    }








}

?>