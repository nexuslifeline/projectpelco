<?php

class ApprehendedConsumerController extends CI_Controller {

    function __construct(){ // gets called every time the controller is loaded (example: $unit=new Unit_controller()) or when called in url
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('ApprehendedConsumerModel');
    }

    function index(){		// the default function that is called if no function is given in the uri
        $this->load->view('record_back_billing_account');
    }

    function ActionGetUnitItemList(){
        echo json_encode(
            $this->ApprehendedConsumerModel->ReturnUnitItemList()
        );
    }

    function ActionGetApprehendedConsumerList(){
        echo json_encode(
            $this->ApprehendedConsumerModel->ReturnApprehendedConsumerList()
        );
    }


    function ActionSaveApprehendedConsumerInfo(){
        if($this->ApprehendedConsumerModel->CreateApprehendedAccount()){

            echo json_encode(
                array(
                    'stat'=>'success',
                    'msg'=>'Apprehended Consumer Account successfully created.',
                    'row'=>$this->ApprehendedConsumerModel->ReturnLastAffectedRowDetails()
                )
            );

        }
    }

    function ActionUpdateApprehendedAccountInfo(){
        if($this->ApprehendedConsumerModel->UpdateApprehendAccount()){
            echo json_encode(
                array(
                    'stat'=>'success',
                    'msg'=>'Apprehended Consumer Account successfully updated.',
                    'row'=>$this->ApprehendedConsumerModel->ReturnLastAffectedRowDetails()

                )
            );

        }
    }

    function ActionGetAccountCartItems(){
        $id=$this->input->get('id',TRUE);
        echo json_encode(
            $this->ApprehendedConsumerModel->ReturnAccountCartItems($id)
        );
    }


    function ActionGetPaymentScheduleItem(){
        $id=$this->input->get('id',TRUE);
        echo json_encode(
            $this->ApprehendedConsumerModel->ReturnPaymentScheduleItems($id)
        );
    }

    function ActionGetCurrentAccountSchedule(){
        $id=$this->input->get('id',TRUE);
        echo json_encode(
            $this->ApprehendedConsumerModel->ShowCurrentAccountSchedule($id)
        );
    }




}

?>