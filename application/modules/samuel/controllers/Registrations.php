<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrations extends MX_Controller
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
			
			$this->load->model("registrations_model");
			$this->load->model("kaizala_model");
		}
		function create_registrations()
		{
			//1. receive a JSON POST
			$json_string=file_get_contents
			("php://input");
			//2. conc=verte json to an 
			//create announcement receivers
			$json_object=json_decode($json_string);
			//3. validate
			if(is_array($json_object) &&(count ($json_object) > 0))
			{
			//retrieve date
			$row=$json_object[0];
			$data=array(
			"responder_name"=>$row->responder_name,
			"responder_phone"=>$row->phone,
			"responder_time"=>$row->time,
			"Age"=>$row->Age,
			"Email"=>$row->email,
			"Profile_image"=>$row->image,
			"Gender"=>$row->gender,
			"Region"=>$row->region,
			"Sales_Area"=>$row->area,
			"Cluster"=>$row->cluster,
			);
			$save_status= $this->registrations_model->save_registration
			($data);

			$subscriber = array($row->phone);

			if($save_status ==TRUE)
			{
			$message_title = "registartion successful";
			$message_description ="thanks for registration";

				}
			else{
				$message_title ="registration failure ".$row->name.". Your registration failed.";
				$message_description ="thanks for registration";
			}
			//request to submit
			}
			else{
				$message_description ="thanks for registration";
			}
			//4. request save data
			//5. send a confirmation
		}

    }
?>