<?php

class ConsumerManagementModel extends CI_Model {
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


    function ReturnConsumerList(){
        $rows=array();
        $sql="SELECT
				CONCAT_WS('|',
				      consumer_id,
                      contact_no,
                      email,
                      second_address,
                      meter_no,
                      house_no,
                      street_no,
                      barangay,
                      municipality,
                      zip_code,
                      province

                )AS     hidden,
                        consumer_name,
                CONCAT_WS(' ',
                      house_no,
                      street_no,
                      barangay,
                      municipality,
                      zip_code,
                      province

                )AS     address
			FROM customer_info
			WHERE is_deleted=0

			";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
            $rows[]=$row; //assign each row of query in array
        }

        return $rows;
    }




    function CreateConsumer(){
        try{
            //array of data to be inserted
            $this->db->trans_start(); //start transaction
            $data = array(
                'consumer_name' => $this->input->post('consumer_name',TRUE),
                'house_no'=>$this->input->post('house_no',TRUE),
                'street_no'=>$this->input->post('street',TRUE),
                'barangay'=>$this->input->post('barangay',TRUE),
                'municipality'=>$this->input->post('municipality',TRUE),
                'zip_code'=>$this->input->post('zipcode',TRUE),
                'province'=>$this->input->post('province',TRUE),
                'house_no'=>$this->input->post('house_no',TRUE),
                'contact_no'=>$this->input->post('contact_no',TRUE),
                'email'=>$this->input->post('email',TRUE),
                'second_address'=>$this->input->post('second_address',TRUE),
                'meter_no'=>$this->input->post('meter_no',TRUE),
            );

            $this->db->set('date_created', 'NOW()', FALSE);
            $this->db->insert('customer_info',$data) or die(json_encode($this->error));
            $this->affected_id=$this->db->insert_id();	//last insert id, the sales invoice	id

            $this->db->trans_complete(); //end transaction
            return true;

        }catch(Exception $e){
            die(json_encode($this->error));
        }
    }



    function UpdateConsumer(){
        try{
            //array of data to be inserted
            $this->db->trans_start(); //start transaction
            $consumer_id=$this->input->post('id',TRUE);

            $data = array(
                'consumer_name' => $this->input->post('consumer_name',TRUE),
                'house_no'=>$this->input->post('house_no',TRUE),
                'street_no'=>$this->input->post('street',TRUE),
                'barangay'=>$this->input->post('barangay',TRUE),
                'municipality'=>$this->input->post('municipality',TRUE),
                'zip_code'=>$this->input->post('zipcode',TRUE),
                'province'=>$this->input->post('province',TRUE),
                'house_no'=>$this->input->post('house_no',TRUE),
                'contact_no'=>$this->input->post('contact_no',TRUE),
                'email'=>$this->input->post('email',TRUE),
                'second_address'=>$this->input->post('second_address',TRUE),
                'meter_no'=>$this->input->post('meter_no',TRUE),
            );

            $this->db->where('consumer_id',$consumer_id);
            $this->db->update('customer_info',$data) or die(json_encode($this->error));
            $this->affected_id=$consumer_id;



            $this->db->trans_complete(); //end transaction
            return true;

        }catch(Exception $e){
            die(json_encode($this->error));
        }
    }

    function RemoveConsumer(){
        try{
            //array of data to be inserted
            $this->db->trans_start(); //start transaction
            $consumer_id=$this->input->post('id',TRUE);

            $this->db->set('is_deleted',1);
            $this->db->where('consumer_id',$consumer_id);
            $this->db->update('customer_info') or die(json_encode($this->error));
            $this->affected_id=$consumer_id;
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
				      consumer_id,
                      contact_no,
                      email,
                      second_address,
                      meter_no,
                      house_no,
                      street_no,
                      barangay,
                      municipality,
                      zip_code,
                      province

                )AS     hidden,
                        consumer_name,
                CONCAT_WS(' ',
                      house_no,
                      street_no,
                      barangay,
                      municipality,
                      zip_code,
                      province

                )AS     address
			FROM customer_info
			WHERE
					consumer_id=".$this->affected_id;
        $query = $this->db->query($sql);

        foreach ($query->result() as $row) //this will return only 1 row
        {
            $rows[]=$row; //assign each row of query in array
        }

        return $rows;
    }





}





?>