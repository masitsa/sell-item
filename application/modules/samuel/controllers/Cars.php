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
		}
		function create_cars()
		{
			//1. receive a JSON POST
			$json_string=file_get_contents("php://input");
			// $json_string = '[
			// {
			// 	"brand": "Fiat",
			// 	"model": "500 Abarth",
			// 	"image": "image_2014_05_18_08_10_02.png",
			// 	"transmission": "Automatic",
			// 	"price": "30000",
			// 	"name": "Samuel Muthana",
			// 	"phone": "+254710141599",
			// 	"date": "1546971556079"
			// }
			// ]';
			//2. conc=verte json to an 
			//create announcement receivers
			$json_object=json_decode($json_string);
			//3. validate
			if(is_array($json_object) &&(count ($json_object) > 0))
			{
			//retrieve date
			$row=$json_object[0];
			$dateCreated = date('Y-m-d H:i:s', intval($row->date));
			$data=array(
				"brand_name"=>$row->brand,
				"brand_model"=>$row->model,
				"samuel_car_image"=>$row->image,
				"samuel_car_transmission"=>$row->transmission,
				"samuel_car_price"=>$row->price,
				"seller_name"=>$row->name,
				"seller_phone"=>$row->phone,
				"date_created"=>$dateCreated,
			);
			$save_status= $this->cars_model->save_car
			($data);

			//Here we create the announcement data
			$subscribers = array($row->phone);
            $brand =$row->brand;
			$model = $row->model;
			
			
			$message_fields = array(
                "brand" => $brand,
                "model" => $model,
                "image" => $row->image,
                "price" => $row->price
			);
			
			$message_description = $brand." ".$model." ".$row->price;	
			if($save_status ==TRUE)
			{
			$message_title = "Your post has been accepted";
			$status ="Status: Published";

				}
			else
				{
				$message_title = "Your post was not successful";
                $status = "Status: Error";
			}
			//Send the announcement
			$this->kaizala_model->send_announcement($message_title, $message_description, $status, $row->date, $message_fields, $subscribers);
			
			}
			else
		{
			//Send invalid data message
			echo "Invalid data provided";
		}
	}
}
?>