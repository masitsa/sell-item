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
            //eg $checkin_time = $row -> time_checkin; //repeat for all fields// never mind skipped

            //must match with database
            $data = array(
                "brand_name" => $row->brand_name,
                "brand_model" => $row->brand_model,
                "brand_model" => $row->brand_model_price,
                "purchase_date" => $row->date_posted,
                "name" => $row->name,
                "phone" => $row->phone,
                "location" => $row->location
            );


            //4. Request to submit
            $save_status = $this->transactions_model->save_transaction($data);

            //create announcement receivers
            $subscribers = array($row->phone);


            //5. send confirmation later wwe will send an announcement
            if($save_status == TRUE){
                $message_title = "Transaction Successful";
                $message_description = "Thank you ".$row->name." for transacting";
            }else{
                $message_title = "Transaction Failure";
                $message_description = "Pardon me ".$row->name." your transaction attempt was not successful. Please try again.";
            }

            $this->kaizala_model->send_announcement($message_title, $message_description, $subscribers);

        }else{
            // send invalid data message
            echo "invalid data provided: ";
        }
        
        
    }
}
?>