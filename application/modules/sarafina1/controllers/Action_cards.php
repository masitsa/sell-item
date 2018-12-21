<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Action_cards extends MX_Controller
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
                header("Access-Control-Allow-Headers:  
                      {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	
			exit(0);
        }
        
        $this->load->model("action_cards_model");
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
                $data = array(
                    "brand_name" => $row-> brand_name,
                    "brand_model" => $row-> brand_model,
                    "brand_image" => $row-> brand_image,
                    "Name" => $row-> Name,
                    "Phone" => $row-> Phone,                    
                    "Location" => $row-> Location,
                    "Response_Time" => $row-> Response_Time
                    
                );

            // 4. Request to submit
            $save_status = $this->action_cards_model ->save_action_card($data);

            //Create announcement receivers
            $subscribers  = array($row->Phone);

            if($save_status ==TRUE){
                $message_title = "Checking Successful";
                $message_description = "Thank you".$row->Name."for checking in.";
            }
            else{
                $message_title = "Checking UnSuccessful";
                $message_description = "Sorry".$row->Name."cant check in.";
            }
            $this->kaizala_model->send_announcement($message_title, $message_description, $subscribers);

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