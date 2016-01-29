<?php

class SalesInvoiceController extends CI_Controller {	
	
	function __construct(){ // gets called every time the controller is loaded (example: $unit=new Unit_controller()) or when called in url
        // Call the Model constructor
        parent::__construct();
		$this->load->helper('url');
		$this->load->model('SalesInvoiceModel');
		$this->load->model('CustomerManagementModel');
    }
	
	function index(){		// the default function that is called if no function is given in the uri
		$data['customers']=$this->CustomerManagementModel->ReturnCustomerList();
		$this->load->view('sales_invoice',$data);	
	}
	
	function ActionGetProductList(){ //returns returns array of object of products
		echo json_encode($this->SalesInvoiceModel->ReturnProductList());
	}
	
	
	
}
	
?>