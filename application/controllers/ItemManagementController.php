<?php

class ItemManagementController extends CI_Controller {	
	
	function __construct(){ // gets called every time the controller is loaded (example: $unit=new Unit_controller()) or when called in url
        // Call the Model constructor
        parent::__construct();
		$this->load->helper('url');
        $this->load->model('ItemManagementModel');
		
    }
	
	function index(){		// the default function that is called if no function is given in the uri		
		$this->load->view('item_management');
	}


    function ActionGetItemList(){ //returns returns array of object of products
        echo json_encode($this->ItemManagementModel->ReturnItemList());
    }



    function ActionSaveItemInfo(){
        if($this->ItemManagementModel->CreateItem()){
            echo json_encode(
                array(
                    'stat'=>'success',
                    'msg'=>'Item successfully created.',
                    'row'=>$this->ItemManagementModel->ReturnLastAffectedRowDetails()
                )
            );

        }
    }




    function ActionUpdateItemInfo(){
        if($this->ItemManagementModel->UpdateItem()){
            echo json_encode(
                array(
                    'stat'=>'success',
                    'msg'=>'Item successfully updated.',
                    'row'=>$this->ItemManagementModel->ReturnLastAffectedRowDetails()

                )
            );

        }
    }

    function ActionDeleteItemInfo(){
        if($this->ItemManagementModel->RemoveItem()){
            echo json_encode(
                array(
                    'stat'=>'success',
                    'msg'=>'Item successfully removed.',
                    'row'=>$this->ItemManagementModel->ReturnLastAffectedRowDetails()

                )
            );

        }
    }


}

?>