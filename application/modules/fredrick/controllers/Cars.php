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
	
	function create_car()
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
            $date_submitted = date("Y-m-d H:i:s");
			$data = array(
				"fredrick_car_year" => $row->car_year,
				"brand_model_id" => $row->brand_model,
				"date_created" => $date_submitted,
				"seller_name" => $row->name,
				"seller_phone" => $row->phone,
				"fredrick_car_price" => $row->car_price,
				"fredrick_car_transmission" => $row->transmission,
				"fredrick_car_image" => $row->picture,
				"response_time" => $row->time
			);
			
			//4. Request to submit
			$save_status = $this->cars_model->save_car($data);

			//Create announcement data
			$subscribers = array($row->phone);
            $brand_name = $this->cars_model->get_brand_name($row->brand_model);
            $brand_model_name = $this->cars_model->get_brand_model_name($row->brand_model);
            $year = $row->car_year;

            $message_fields = array(
                "brand" => $brand_name,
                "brand_model" => $brand_model_name,
                "image" => $row->picture,
                "price" => $row->car_price
            );
            
            $message_description = $brand_name." ".$brand_model_name." ".$year;

			if($save_status == TRUE)
			{
				$message_title = "Your post has been accepted";
                $status = "Status: Published";
			}
			else
			{
				$message_title = "Your post was not successful";
                $status = "Status: Error";
            }
            
            //Send the announcement
			$this->kaizala_model->send_announcement($message_title, $message_description, $status, $date_submitted, $message_fields, $subscribers);
		}

		else
		{
			//Send invalid data message
			echo "Invalid data provided";
		}
	}
}
?>