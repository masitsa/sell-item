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
                "brand" => $row->brand,
                "model" => $row->model,
                "car_img_exterior" => $row->car_img_exterior, 
                "transmission" => $row->transmission,
                "price" => $row->price,                
                "sender_name" => $row->sender_name,
                "sender_phone" => $row->sender_phone,
                "date_submitted" => $row->date_submitted
                
            );
                               
                
                /*
                table fields:
                sender_name
                sender_phone
                date_submitted
                brand
                model
                car_img_exterior               
                transmission
                price
                */
                //5.request to submit

                $save_status = 
                $this->sender_details_model->save_checkins($data);

                 //create announcement recievers
                 $subscribers = array($row->sender_phone);
                 $brand_name = $this->sender_details_model->get_brand_name($row->brand);
                $brand_model_name = $this->sender_details_model->get_brand_model_name($row->brand_model);
                $year = $row->car_year;
                
                $message_fields = array(
                    "brand" => $brand_name,
                    "brand_model" => $brand_model_name,
                    "image" => $row->car_img_exterior,
                    "price" => $row->price
                );
                 
                $message_description = $brand_name." ".$brand_model_name." ".$year;

                if ($save_status ==TRUE){
                    $message_title = "Saved Successful";
                    $message_description = "Thank you".$row->sender_name."for checkin";
                    $status = "Status: Published";

                }
                else {
                    //6.send invalid data message
                    $message_title = "Your details were not saved successful";
                    $message_description = "Sorry".$row->sender_name."not successful";
                    $statu = "Status: Error";
                    
                }

                //Send the announcement
                $this->kaizala_model->send_announcement($message_title, $message_description, $status, $date_submitted, $message_fields, $subscribers);
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