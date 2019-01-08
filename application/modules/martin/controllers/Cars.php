<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cars extends MX_Controller
{
    function __construct() { 
		parent:: __construct();

		// Allow from any origin
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true'); 
			header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}
	
		// Access-Control headers are received during OPTIONS requests
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
	
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	
			exit(0);
        }
        
		$this->load->model("cars_model");
		$this->load->model("kaizala_model");
	}
	function create_card() {
		//1. Receive JSON POST
		$json_string = file_get_contents("php://input");

		//2. Convert JSON to array
		$json_object = json_decode($json_string);

		
		//3. Validate
		if (is_array($json_object) && (count($json_object) > 0)) {
			//1. Retrieve the data
			$row = $json_object[0];
			$data = array(
				"name" => $row->name,
				"brand_name" => $row->brand_name,
				"brand_model" => $row->brand_model,
				"price" => $row->price,
				"phone" => $row->phone,
				"date" => $row->date,
				"transmission_type" => $row->transmission_type
			);

			$date_submitted = date('Y-m-d H:i:s');
			//2. Request to submit
			$save_status = $this->cars_model->save_card($data);

			// Create announcement receivers
			$subscribers = array($row->phone);
			$brand_name = $row->brand_name;
			$brand_model_name = $row->brand_model;
				
			$message_fields = array(
				"brand" => $brand_name,
                "brand_model" => $brand_model_name,
				"price" => $row->price,
				"transmission_type" => $row->transmission_type
			);

			$message_description = $brand_name." ".$brand_model_name;

			//3. Request to save data
			if($save_status == TRUE) {
				//4. Send a confirmation
				$message_title = "Your post has been accepted";
				$status = "Status: Sent successfully";
			} else {
				$message_title = "Card submission failed. Please try again";
				$status = "Status: Error";
			}
			$this->kaizala_model->send_announcement($message_title, $message_description, $status, $date_submitted, $message_fields, $subscribers);
		}
		else {
			//5. Send invalid data message
			echo "Invalid data provided";
		}		
	}	
}
?>