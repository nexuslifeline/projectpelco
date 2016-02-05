<?php

class RecordPaymentController extends CI_Controller {

    function __construct(){ // gets called every time the controller is loaded (example: $unit=new Unit_controller()) or when called in url
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('ApprehendedConsumerModel');
        $this->load->model('RecordPaymentModel');
    }

    function index(){		// the default function that is called if no function is given in the uri
        $data['consumers']=$this->ApprehendedConsumerModel->ReturnConsumerActiveList();
        $this->load->view('record_payment',$data);
    }


    function ActionShowScheduleBalances(){
        echo json_encode(

            $this->RecordPaymentModel->ShowScheduleBalances($this->input->get('id'))

        );

    }



    function ActionShowPaymentList(){
        echo json_encode(
            $this->RecordPaymentModel->ShowAllPaymentList()
        );
    }


    function ActionSaveNewPayment(){
       if($this->RecordPaymentModel->SaveNewPayment()){
           echo json_encode(array(
               'stat'=>'success',
               'msg'=>'Payment successfully recorded.',
               'rows'=>$this->RecordPaymentModel->ShowLastPaidList()
           ));
       }
    }

    function ShowLastPaidList(){
        echo json_encode($this->RecordPaymentModel->ShowLastPaidList());
    }




}

?>