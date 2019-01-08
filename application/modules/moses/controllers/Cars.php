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

    function create_car(){
        //1. Recieve a JSON POST
        $json_string = file_get_contents("php://input");

        //2. Convert JSON to an array
        $json_object = json_decode($json_string);

        //3. Validate
        if(is_array($json_object) && (count($json_object) > 0)){

            // Retrive the data
            $row = $json_object[0];

            //show the data thene comment out and update
           // echo print_r($arr, true); 
  
            
            
            $date_created= date("Y-m-d H:i:s");

            //must match with database
            $data = array(
                "brand_model_id" => $row->brand_model_id,
                "date_created" => $row->date_created,
                "seller_name" => $row->seller_name,
                "seller_phone" => $row->seller_phone,
                "moses_car_price" => $row->moses_car_price,
                "moses_car_transmission" => $row->moses_car_transmission,
                "moses_car_image" => $row->moses_car_image          

            );


            //4. Request to submit
            $save_status = $this->cars_model->save_car($data);

            //Create announcement data
			$subscribers = array($row->seller_phone);
            $brand_name = $this->cars_model->get_brand_name($row->brand_name);
            $brand_model_name = $this->cars_model->get_brand_model_name($row->brand_model_id);
            $year = $row->car_year;

            $message_fields = array(
                "brand" => $brand_name,
                "brand_model" => $brand_model_name,
                "image" => $row->moses_car_image,
                "price" => $row->moses_car_price
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

            $this->kaizala_model->send_announcement($message_title, $message_description, $status, $date_submitted, $message_fields, $subscribers);

        }else{
            // send invalid data message
            echo "invalid data provided: ";
            $error = $this->db->error();
           
            if (isset($error['message'])) {
                return $error['message'];
            }
            
            
        }
        
        
    }
}
?>