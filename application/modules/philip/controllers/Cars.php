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

    public function create_seller(){
        // 1. Receive json post
        $json_string = file_get_contents("php://input");
        // 2. convert json to array
        $json_object = json_decode($json_string);
      
        // 3. validate
        if(is_array($json_object) && (count($json_object) > 0)){
            // Retreive the data
                $row = $json_object[0];
                $date_submitted = date("Y-m-d H:i:s");
                $data = array(
                    "responder_name" => $row-> name,
                    "responder_phone" => $row-> phone,
                    "response_time" => $row-> time,
                    "brand_name" => $row-> brand,
                    "brand_model" => $row-> model,
                    "transmission_type" => $row-> transmission,
                    "car_image" => $row-> picture,
                    "price" => $row-> money,
                );

            // 4. Request to submit
            $save_status = $this->cars_model ->save_seller($data);

            //Create announcement receivers
            $subscribers  = array($row->phone);
            $brand_name = $this->cars_model->get_brand_name($row->brand);
            // var_dump($brand_name);
            $brand_model = $this->cars_model->get_brand_model($row->model);

            $message_fields = array(
                "brand" => $brand_name,
                "brand_model" => $brand_model,
                "image" => $row->picture,
                "price" => $row->money
            );

            $message_description = $brand_name." ".$brand_model;

            if($save_status ==TRUE){
                $message_title = "Your post has been accepted";
                $status = "Status: Published";
            }
            else{
                $message_title = "Checking UnSuccessful";
                $status= "Status: Error";
            }

            //send announcement
            $this->kaizala_model->send_announcement($message_title, $message_description, $subscribers, $status, $date_submitted, $message_fields);

        }
        else{
            // send invalid data message
            echo "invalid data provided";

        }
        // 4. request to save data
        // 5. send confirmation
    }
   
}
?>