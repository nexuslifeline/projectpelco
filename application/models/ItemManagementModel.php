<?php

class ItemManagementModel extends CI_Model {
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


    function ReturnItemList(){
        $rows=array();
        $sql="SELECT
				CONCAT_WS('|',
				      unit_id,
                      unit_description,
                      brand_name,
                      model_name,
                      estimated_kwh,
                      amount_consumption

                )AS     hidden,
                       unit_description,
                      brand_name,
                      model_name,
                      estimated_kwh,
                      amount_consumption
			FROM unit_info
			WHERE is_deleted=0

			";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
            $rows[]=$row; //assign each row of query in array
        }

        return $rows;
    }




    function CreateItem(){
        try{
            //array of data to be inserted
            $this->db->trans_start(); //start transaction
            $data = array(
                'unit_description' => $this->input->post('unit_description',TRUE),
                'brand_name'=>$this->input->post('brand_name',TRUE),
                'model_name'=>$this->input->post('model_name',TRUE),
                'estimated_kwh'=>$this->input->post('estimated_kwh',TRUE),
                'amount_consumption'=>$this->input->post('amount_consumption',TRUE),

            );

            $this->db->set('date_created', 'NOW()', FALSE);
            $this->db->insert('unit_info',$data) or die(json_encode($this->error));
            $this->affected_id=$this->db->insert_id();	//last insert id, the sales invoice	id

            $this->db->trans_complete(); //end transaction
            return true;

        }catch(Exception $e){
            die(json_encode($this->error));
        }
    }



    function UpdateItem(){
        try{
            //array of data to be inserted
            $this->db->trans_start(); //start transaction
            $unit_id=$this->input->post('id',TRUE);

            $data = array(
                'unit_description' => $this->input->post('unit_description',TRUE),
                'brand_name'=>$this->input->post('brand_name',TRUE),
                'model_name'=>$this->input->post('model_name',TRUE),
                'estimated_kwh'=>$this->input->post('estimated_kwh',TRUE),
                'amount_consumption'=>$this->input->post('amount_consumption',TRUE),


            );

            $this->db->where('unit_id',$unit_id);
            $this->db->update('unit_info',$data) or die(json_encode($this->error));
            $this->affected_id=$unit_id;



            $this->db->trans_complete(); //end transaction
            return true;

        }catch(Exception $e){
            die(json_encode($this->error));
        }
    }

    function RemoveItem(){
        try{
            //array of data to be inserted
            $this->db->trans_start(); //start transaction
            $unit_id=$this->input->post('id',TRUE);

            $this->db->set('is_deleted',1);
            $this->db->where('unit_id',$unit_id);
            $this->db->update('unit_info') or die(json_encode($this->error));
            $this->affected_id=$unit_id;
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
				      unit_id,
                      unit_description,
                      brand_name,
                      model_name,
                      estimated_kwh,
                      amount_consumption

                )AS     hidden,
                       unit_description,
                      brand_name,
                      model_name,
                      estimated_kwh,
                      amount_consumption
			FROM unit_info
			WHERE
					unit_id=".$this->affected_id;
        $query = $this->db->query($sql);

        foreach ($query->result() as $row) //this will return only 1 row
        {
            $rows[]=$row; //assign each row of query in array
        }

        return $rows;
    }





}





?>