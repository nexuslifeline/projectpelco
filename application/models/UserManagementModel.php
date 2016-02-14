<?php

class UserManagementModel extends CI_Model {
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


    function ReturnUserList(){
        $rows=array();
        $sql="SELECT
				CONCAT_WS('|',
				      user_id,
                      username,
                      password,
                      email,
                      firstname,
                      middlename,
                      lastname,
                      address,
                      birthdate,
                      mobile,
                      landline

                )AS     hidden,

            CONCAT_WS(' ',
                      firstname,
                      middlename,
                      lastname

                )AS     name,
                      address,
                      mobile,
                      email,
                      birthdate

			FROM user
			WHERE is_deleted=0

			";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row)
        {
            $rows[]=$row; //assign each row of query in array
        }

        return $rows;
    }




    function CreateUser(){
        try{
            //array of data to be inserted
            $this->db->trans_start(); //start transaction
            $data = array(
                'firstname' => $this->input->post('firstname',TRUE),
                'middlename'=>$this->input->post('middlename',TRUE),
                'lastname'=>$this->input->post('lastname',TRUE),
                'birthdate' => date('Y-m-d',strtotime($this->input->post('birthdate',TRUE))),
                'address'=>$this->input->post('address',TRUE),
                'mobile'=>$this->input->post('mobile',TRUE),
                'landline'=>$this->input->post('landline',TRUE),
                'username'=>$this->input->post('username',TRUE),
                'password'=>md5($this->input->post('password',TRUE)),
                'email'=>$this->input->post('email',TRUE),
            );

            $this->db->set('date_created', 'NOW()', FALSE);
            $this->db->insert('user',$data) or die(json_encode($this->error));
            $this->affected_id=$this->db->insert_id();	//last insert id, the sales invoice	id

            $this->db->trans_complete(); //end transaction
            return true;

        }catch(Exception $e){
            die(json_encode($this->error));
        }
    }



    function UpdateUser(){
        try{
            //array of data to be inserted
            $this->db->trans_start(); //start transaction
            $user_id=$this->input->post('id',TRUE);

            $data = array(
                'firstname' => $this->input->post('firstname',TRUE),
                'middlename'=>$this->input->post('middlename',TRUE),
                'lastname'=>$this->input->post('lastname',TRUE),
                'birthdate' => date('Y-m-d',strtotime($this->input->post('birthdate',TRUE))),
                'address'=>$this->input->post('address',TRUE),
                'mobile'=>$this->input->post('mobile',TRUE),
                'landline'=>$this->input->post('landline',TRUE),
                'username'=>$this->input->post('username',TRUE),
                'password'=>md5($this->input->post('password',TRUE)),
                'email'=>$this->input->post('email',TRUE),
            );

            $this->db->where('user_id',$user_id);
            $this->db->update('user',$data) or die(json_encode($this->error));
            $this->affected_id=$user_id;


            $this->db->trans_complete(); //end transaction
            return true;

        }catch(Exception $e){
            die(json_encode($this->error));
        }
    }

    function RemoveUser(){
        try{
            //array of data to be inserted
            $this->db->trans_start(); //start transaction
            $user_id=$this->input->post('id',TRUE);

            $this->db->set('is_deleted',1);
            $this->db->where('user_id',$user_id);
            $this->db->update('user') or die(json_encode($this->error));
            $this->affected_id=$user_id;
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
				      user_id,
                      username,
                      password,
                      email,
                      firstname,
                      middlename,
                      lastname,
                      address,
                      birthdate,
                      mobile,
                      landline

                )AS     hidden,

            CONCAT_WS('|',
                      firstname,
                      middlename,
                      lastname

                )AS     name,
                      address,
                      mobile,
                      email,
                      birthdate

			FROM user
			WHERE
					user_id=".$this->affected_id;
        $query = $this->db->query($sql);

        foreach ($query->result() as $row) //this will return only 1 row
        {
            $rows[]=$row; //assign each row of query in array
        }

        return $rows;
    }





}





?>