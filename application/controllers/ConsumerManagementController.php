<?php

class ConsumerManagementController extends CI_Controller {

    function __construct(){ // gets called every time the controller is loaded (example: $unit=new Unit_controller()) or when called in url
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('ConsumerManagementModel');

    }

    function index(){		// the default function that is called if no function is given in the uri
        $this->load->view('consumer_management');
    }

    function ActionGetConsumerList(){ //returns returns array of object of products
        echo json_encode($this->ConsumerManagementModel->ReturnConsumerList());
    }



    function ActionSaveConsumerInfo(){
        if($this->ConsumerManagementModel->CreateConsumer()){
            echo json_encode(
                array(
                    'stat'=>'success',
                    'msg'=>'Consumer successfully created.',
                    'row'=>$this->ConsumerManagementModel->ReturnLastAffectedRowDetails()
                )
            );

        }
    }




    function ActionUpdateConsumerInfo(){
        if($this->ConsumerManagementModel->UpdateConsumer()){
            echo json_encode(
                array(
                    'stat'=>'success',
                    'msg'=>'Consumer successfully updated.',
                    'row'=>$this->ConsumerManagementModel->ReturnLastAffectedRowDetails()

                )
            );

        }
    }

    function ActionDeleteConsumerInfo(){
        if($this->ConsumerManagementModel->RemoveConsumer()){
            echo json_encode(
                array(
                    'stat'=>'success',
                    'msg'=>'Consumer successfully removed.',
                    'row'=>$this->ConsumerManagementModel->ReturnLastAffectedRowDetails()

                )
            );

        }
    }


}

?>