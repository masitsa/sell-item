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
                header("Access-Control-Allow-Headers:  
                      {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	
			exit(0);
        }
        
        $this->load->model("action_cards_model");
        $this->load->model("kaizala_model");
    }

    public function create_seller_action_card(){
        // 1. Receive json post
        $json_string = file_get_contents("php://input");
        // 2. convert json to array
        $json_object = json_decode($json_string);
        // 3. validate
        if(is_array($json_object) && (count($json_object) > 0)){
            // Retreive the data
                $row = $json_object[0];
                $time = date('Y/m/d H:i:s', $row->Response_Time);
                $data = array(
                    "brand_name" =>$row->brand_name,
                    "brand_model" =>$row->brand_model,
                    "brand_image" =>$row->brand_image,
                    "Name" =>$row->Name,
                    "Phone" =>$row->Phone,                    
                    "Location" =>$row->Location,
                    "Response_Time" =>$row->Response_Time,
                    "transmission_code" =>$row->transmission_code,
                    "engine_code" =>$row->engine_code,
                    "year" =>$row->year,
                    "price" =>$row->price,
                    
                );
                //4.Request to submit
               $save_status= $this->action_cards_model->save_action_card($data);
               
               $subcribers =array($row->Phone);
    
               if($save_status ==TRUE){
                 $message_title ="Your post has been accepted";
                 $message_description ="Thankyou ".$row->Name.".for checking in";
    
    
               }else{
                 
                $message_title="Sells Failure";
                $message_description="din't login".$row->Name.".try again";
               }
               
               $this->kaizala_model->send_announcement($message_title,
               $message_description,$subcribers,$time);
    
            }
            else{
                //send invalid data message
                echo"invalid data provided";
            }
            //4.Request to save data
            //5.send a confirmation
        }
        public function create_buyer_action_card(){
            // 1. Receive json post
            $json_strings = file_get_contents("php://input");
            // 2. convert json to array
            $json_objects = json_decode($json_strings);
            // 3. validate
            if(is_array($json_object) && (count($json_objects) > 0)){
                // Retreive the data
                    $row = $json_object[0];
                    $time = date('Y/m/d H:i:s', $row->Response_Time);
                    $data = array(
                        "brand_name" =>$row->brand_name,
                        "brand_model" =>$row->brand_model,
                        "brand_image" =>$row->brand_image,
                        "name" =>$row->Name,
                        "phone" =>$row->Phone,                    
                        "location" =>$row->Location,
                        "response_time" =>$row->Response_Time
                        
                    );
                    //4.Request to submit
                   $save_status= $this->action_cards_model->save_Buyer($data);
                   
                   $subcribers =array($row->Phone);
        
                   if($save_status ==TRUE){
                     $message_title ="Buy Successfull";
                     $message_description ="Thankyou ".$row->Name." for checking in";
        
        
                   }else{
                     
                    $message_title="Purchase Failure";
                    $message_description="din't login".$row->Name.".try again";
                   }
                   
                   $this->kaizala_model->send_announcement($message_title,
                   $message_description,$subcribers,$time);
        
                }
                else{
                    //send invalid data message
                    echo"invalid data provided ... for buyer";
                }
                //4.Request to save data
                //5.send a confirmation
            }
      
    }
        
    ?>