<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions extends MX_Controller
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
        
        $this->load->model("transactions_model");
        $this->load->model("kaizala_model");
    }

    function create_transaction(){
        //1. Recieve a JSON POST
        $json_string = file_get_contents("php://input");

        //2. Convert JSON to an array
        $json_object = json_decode($json_string);

        //3. Validate
        if(is_array($json_object) && (count($json_object) > 0)){

            // Retrive the data
            $row = $json_object[0];
           

            //must match with database
            $data = array(
                "brand_name" => $row->brand_name,
                "brand_model" => $row->brand_model,
                "brand_model_transmission_type" => $row->brand_model_transmission_type,
                "brand_model_price" => $row->brand_model_price,
                "brand_model_image" => $row->brand_model_image,
                "date_posted" => $row->date_posted,
                "name" => $row->name,
                "phone" => $row->phone,
                "location" => $row->location
            );


            //4. Request to submit
            $save_status = $this->transactions_model->save_transaction($data);

            //Create announcement data
			$subscribers = array($row->phone);
            $brand_name = $row->brand_name;
            $brand_model_name = $row->brand_model;
            //$year = $row->moses_car_year;
            $year = 2019;

            $message_fields = array(
                "brand" => $brand_name,
                "brand_model" => $brand_model_name,
                "image" => $row->brand_model_image,
                "price" => $row->brand_model_price
            );
            
            $message_description = $brand_name." ".$brand_model_name." ".$year;


            //5. send confirmation later we will send an announcement
            if($save_status == TRUE){
                $message_title = "Your post has been accepted";
                $status = "Status: Published";
            }else{
                $message_title = "Your post was not successful";
                $status = "Status: Error";
            }

            $this->kaizala_model->send_announcement($message_title, $message_description, $status, $date_posted, $message_fields, $subscribers);

        }else{
            // send invalid data message
            echo "invalid data provided: ";

            echo "<br>". $row->brand_name;
            echo "<br>". $row->brand_model;
            echo "<br>".$row->brand_model_transmission_type;
            echo "<br>". $row->brand_model_price;
            echo "<br>". $row->brand_model_image;
            echo "<br>". $row->date_posted;
            echo "<br>". $row->name;
            echo "<br>". $row->phone;
            echo "<br>". $row->location;
            $error = $this->db->error();
            if($error['message']){
                echo $error["message"];
            }
            
            
        }
        
        
    }
}
?>