<?php

class UserManagementController extends CI_Controller {

    function __construct(){ // gets called every time the controller is loaded (example: $unit=new Unit_controller()) or when called in url
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('UserManagementModel');

    }

    function index(){		// the default function that is called if no function is given in the uri
        $this->load->view('user_management');
    }

    function ActionGetUserList(){ //returns returns array of object of products
        echo json_encode($this->UserManagementModel->ReturnUserList());
    }



    function ActionSaveUserInfo(){
        if($this->UserManagementModel->CreateUser()){
            echo json_encode(
                array(
                    'stat'=>'success',
                    'msg'=>'User successfully created.',
                    'row'=>$this->UserManagementModel->ReturnLastAffectedRowDetails()
                )
            );

        }
    }




    function ActionUpdateUserInfo(){
        if($this->UserManagementModel->UpdateUser()){
            echo json_encode(
                array(
                    'stat'=>'success',
                    'msg'=>'User successfully updated.',
                    'row'=>$this->UserManagementModel->ReturnLastAffectedRowDetails()

                )
            );

        }
    }

    function ActionDeleteUserInfo(){
        if($this->UserManagementModel->RemoveUser()){
            echo json_encode(
                array(
                    'stat'=>'success',
                    'msg'=>'User successfully removed.',
                    'row'=>$this->UserManagementModel->ReturnLastAffectedRowDetails()

                )
            );

        }
    }


}

?>