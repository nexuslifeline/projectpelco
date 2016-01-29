<?php

class CustomerManagementModel extends CI_Model {
	

	function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->database(); 
    }
	
	
	function ReturnCustomerList(){
		$rows=array();
		$sql="SELECT 
				consumer_id,
				consumer_name
			FROM customer_info";
		$query = $this->db->query($sql);
		foreach ($query->result() as $row)
		{
			$rows[]=$row; //assign each row of query in array
		}
		
		return $rows;
	}
	
	
}



?>