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
			
			$this->load->model("registrations_model");
            $this->load->model("kaizala_model");
            $this->load->model("cars_model");
            $this->load->model("orders_model");
		}
		function create_cars()
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
			$dateCreated = date('Y/m/d H:i:s', $row->date);
			$data=array(
            "order_date"=>$row->date,
			"customer_name"=>$row->name,
			"customer_phone"=>$row->phone,
			"customer_location"=>$row->location,
			"car_brand"=>$row->brand,
			"car_model"=>$row->model,
			"car_image"=>$row->image,
			"car_price "=>$row->price,
			);
			$save_status= $this->orders_model->save_order
			($data);

			$subscriber = array($row->phone);

			if($save_status ==TRUE)
			{
			$message_title = "save successful";
			$message_description ="you can now send order";

				}
			else{
				$message_title ="Hello ".$row->name.". your order failed.";
				$message_description ="Please try again";
			}
			//request to submit
			}
			else{
				$message_description ="your order was successfully sent";
			}
			//4. request save data
			//5. send a confirmation
		}

    }
?>