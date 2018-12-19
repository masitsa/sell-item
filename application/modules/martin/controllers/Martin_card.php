<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Martin_card extends MX_Controller
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
        
        $this->load->model("martin_card_model");
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
				"responder_name" => $row->name,
				"responder_phone" => $row->phone,
				"responder_date" => $row->date
			);
			//2. Request to submit
			$save_status = $this->martin_card_model->save_card($data);
			//3. Request to save data
			if($save_status == TRUE) {
				//4. Send a confirmation
				echo "Card saved";
			} else {
				echo "Unable to save";
			}
		}
		else {
			//5. Send invalid data message
			echo "Invalid data provided";
		}		
	}
}
?>