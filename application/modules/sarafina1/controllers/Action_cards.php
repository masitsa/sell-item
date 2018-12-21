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
        
        $this->load->model("Action_cards_model");
    }

   function create_action_cards (){
//1. Receive JSON POST
$json_string= file_get_contents
("php://input");
//2. Convert JSON to array
$json_object= json_decode($json_string);
//3. Validate
if(is_array($json_object) && (count($json_object)>0)){
    //3.1retrieve the data
    $row=$json_object[0];
    $data = array (
        "brand_name"=>$row->brandName,        
        "brand_model"=>$row->transmission,
        "brand_image"=>$row->brandImage,

        "name"=>$row->name,
       "phone" =>$row->phone,
       "location"=>$row->location,
       "response_time"=>$row->responseTime
    );
    //3.2 request to submit
    $this->Action_cards_mmodel->save_action_card($data);
    if ($save_status==TRUE){
        echo "saved";
    }
    else{
        echo "unable to save";
    }
    //invalid data message
    echo "Invalid data provided";
}
//4.Send a confirmation
   }
    
    
}
?>