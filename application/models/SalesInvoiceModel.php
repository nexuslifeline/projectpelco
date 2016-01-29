<?php

class SalesInvoiceModel extends CI_Model {
	

	function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->database(); 
    }
	
	
	function ReturnProductList(){
		$rows=array();
		$sql="SELECT 
				prod_id as id,
				CONCAT(prod_code,'  ',prod_description) as name,
				prod_description as description,
				prod_code,prod_srp as srp,0 as discount
			FROM product_info";		
		$query = $this->db->query($sql);
		foreach ($query->result() as $row)
		{
			$rows[]=$row; //assign each row of query in array
		}
		
		return $rows;
	}
	
	
}



?>