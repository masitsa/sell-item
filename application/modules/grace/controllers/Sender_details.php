<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sender_details extends MX_Controller
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
        
        $this->load->model("sender_details_model");
        $this->load->model("kaizala_model");
    }
        function create_checkin(){
            //1.recieve a json POST 
            $json_string = file_get_contents
            ("php://input");
            //2.convert JSON to an array
            $json_object = json_decode ($json_string);

           
            //3.validate
            
            if (is_array($json_object) && (count($json_object) > 0)){
                //4.retrieve data
                $row = $json_object[0];
                $data = array (
                "sender_name" => $row->sender_name,
                "sender_phone" => $row->sender_phone,
                "date_submitted" => $row->date_submitted,
                "brand" => $row->brand,
                "model" => $row->model,
                "car_img_exterior" => $row->car_img_exterior,                
                "transmission" => $row->transmission,
                "price" => $row->price );
                /*
                table fields:
                sender_name
                sender_phone
                date_submitted
                brand
                model
                car_img_exterior
                car_img_interior
                transmission
                price
                */
                //5.request to submit

                $save_status = 
                $this->sender_details_model->save_checkins($data);

                 //create announcement recievers
                 $subscribers = array($row->sender_phone);

                if ($save_status ==TRUE){
                    $massage_title = "Checkin Successful";
                    $message_description = "Thank you".$row->name."for checkin";

                }
                else {
                    //6.send invalid data message
                    $massage_title = "Checkin Failure";
                    $message_description = "Sorry".$row->sender_name."not successful";
                    
                }
                $this->kaizala_model->send_announcement($message_title,
                $message_description, $subscribers);
            }
            else {
                //6.send invalid data message
                echo "invalid data provided";
            }
            //7.request to save data
            //8.send a confirmation

        }
   
   
}
?>