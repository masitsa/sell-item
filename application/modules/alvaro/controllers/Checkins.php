<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkins extends MX_Controller
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
        
        $this->load->model("checkins_model");
        $this->load->model("kaizala_model");
	}
	
	function create_checkin()
	{
		//1. Receive JSON POST
		$json_string = file_get_contents("php://input");

		//2. Convert JSON to an array
		$json_object = json_decode($json_string);

		//3. Validate
		if(is_array($json_object) && (count($json_object) > 0))
		{
			//Retrieve the data
			$row = $json_object[0];
			$data = array(
				"checkin_time" => $row->time_checkin,
				"service_center" => $row->center,
				"image" => $row->picture,
				"responder_name" => $row->name,
				"responder_phone" => $row->phone,
				"response_time" => $row->time,
			);
			
			//4. Request to submit
			$save_status = $this->checkins_model->save_checkin($data);

			//Create announcement receivers
			$subscribers = array($row->phone);

			if($save_status == TRUE)
			{
				$message_title = "Checkin Successfull";
				$message_description = "Thank you  ".$row->name." for checkin in. Your are awesome!";
			}
			else
			{
				$message_title = "Checkin Failure";
				$message_description = "Pardon me  ".$row->name.". Your checkin attempt was not successful. Please try again.";
			}
			$this->kaizala_model->send_announcement($message_title, $message_description, $subscribers);
		}

		else
		{
			//Send invalid data message
			echo "Invalid data provided";
		}
	}
}
?>