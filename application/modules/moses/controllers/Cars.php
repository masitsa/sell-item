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

    function create_cars(){
        //1. Recieve a JSON POST
        $json_string = file_get_contents("php://input");

        //2. Convert JSON to an array
        $json_object = json_decode($json_string);

        //3. Validate
        if(is_array($json_object) && (count($json_object) > 0)){

            // Retrive the data
            $row = $json_object[0];
            //eg $checkin_time = $row -> time_checkin; //repeat for all fields// never mind skipped

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

            //create announcement receivers
            $subscribers = array($row->phone);


            //5. send confirmation later we will send an announcement
            if($save_status == TRUE){
                $title = "your post was successful";
                $description = "Thank you ".$row->name." for posting";
                $status = "published";
                $date = null;
                $fields = null;
                $receivers = null;
            }else{
                $title = "error";
                $description = "Pardon me ".$row->name." your post attempt was not successful. Please try again.";
            }

            $this->kaizala_model->send_announcement($title, $description, $status, $date, $fields, $receivers);

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