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
            //eg $checkin_time = $row -> time_checkin; //repeat for all fields// never mind skipped

            $data = array(
                "brand_name" => $row->brand_name,
                "brand_model" => $row->brand_model,
                "brand_name" => $row->brand_name,
                "transmission_type" => $row->transmission_type,
                "car_image" => $row->car_image,
                "purchase_date" => $row->purchase_date,
                "drive_system" => $row->drive_system
            );


            //4. Request to submit
            $save_status = $this->transactions_model->save_transaction($data);

            //5. send confirmation later wwe will send an announcement
            if($save_status == TRUE){
                echo "saved successfully";
            }else{
                echo "failed to save";
            }

        }else{
            // send invalid data message
            echo "invalid data provided";
        }
        
        
    }
}
?>