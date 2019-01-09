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
        $this->load->model("brands_model");
        $this->load->model("kaizala_model");
    }

    public function create_seller_action_card(){
        // 1. Receive json post
         $json_string = file_get_contents("php://input");
        // $json_string = '[
        //     {
        //       "brand_name": "Fiat",
        //       "brand_model": "A6",
        //       "transmission_code": "CEUB",
        //       "brand_image": "https://cdn.inc-000.kms.osi.office.net/att/c350557a5c1d321a09ca5a6000df0d45b77bc3ff04c7f2b947c41e781febc6ff.jpg?sv=2015-12-11&sr=b&sig=WbwzK9%2FAGyBqHEw9PwyC33jxsMfs7V5JqtPMMrF5q9k%3D&st=2019-01-09T09:13:47Z&se=2292-10-24T10:13:47Z&sp=r",
        //       "year": "2019",
        //       "price": "1200000",
        //       "Name": "Sarafina",
        //       "Phone": "+254715527120",
        //       "Location": "{\"lt\":0.018223,\"lg\":37.0740386,\"n\":\"0.018223, 37.0740386\",\"acc\":14.663999557495117}",
        //       "Response_Time": "1547028826565"
        //     }
        //   ]';
        // 2. convert json to array
        $json_object = json_decode($json_string);
        // 3. validate
        if(is_array($json_object) && (count($json_object) > 0)){
            // Retreive the data
                $row = $json_object[0];
                $time = $this->kaizala_model->format_date($row->Response_Time);
                $data = array(
                    "brand_name" =>$row->brand_name,
                    "brand_model" =>$row->brand_model,
                    "brand_image" =>$row->brand_image,
                    "Name" =>$row->Name,
                    "Phone" =>$row->Phone,                    
                    "Location" =>$row->Location,
                    "Response_Time" =>$time,
                    "transmission_code" =>$row->transmission_code,
                    "year" =>$row->year,
                    "price" =>$row->price
                );
                //4.Request to submit
               $save_status= $this->action_cards_model->save_action_card($data);
               //Create announcement data
               $brand_name =$row->brand_name;
               $brand_model_name =$row->brand_model;
               $year =$row->year;

               $message_fields = array(
                "brand_name"=>$brand_name,
                "brand_model"=>$brand_model_name,
                "brand_image"=>$row->brand_image,
                "price"=>$row->price,
                "year"=>$row->year
            );
                $message_description = $brand_name." ".$brand_model_name." ".$year;
                
               $subscribers =array($row->Phone);
    
               if($save_status ==TRUE){
                 $message_title ="Your post has been accepted";
                 $status = "Status: Published";
                
    
               }else{
                 
                $message_title="Error";
                $message_description= "Sorry".$row->Name. "you couldn't login, try again";
                $status = "Status: Error";
               }
               
               $this->kaizala_model->send_announcement($message_title, $message_description, $status, $time, $message_fields, $subscribers);
            }
            else{
                //send invalid data message
                echo"invalid data provided";
            }
            //4.Request to save data
            //5.send a confirmation
        }
        // public function create_buyer_action_card(){
        //     // 1. Receive json post
        //     $json_strings = file_get_contents("php://input");
        //     // 2. convert json to array
        //     $json_objects = json_decode($json_strings);
        //     // 3. validate
        //     if(is_array($json_object) && (count($json_objects) > 0)){
        //         // Retreive the data
        //             $row = $json_object[0];
        //             $time = date('Y/m/d H:i:s', $row->Response_Time);
        //             $data = array(
        //                 "brand_name" =>$row->brand_name,
        //                 "brand_model" =>$row->brand_model,
        //                 "brand_image" =>$row->brand_image,
        //                 "name" =>$row->Name,
        //                 "phone" =>$row->Phone,                    
        //                 "location" =>$row->Location,
        //                 "response_time" =>$row->Response_Time
                        
        //             );
        //             //4.Request to submit
        //            $save_status= $this->action_cards_model->save_Buyer($data);
                   
        //            $subcribers =array($row->Phone);
        
        //            if($save_status ==TRUE){
        //              $message_title ="Buy Successfull";
        //              $message_description ="Thankyou ".$row->Name." for checking in";
        
        
        //            }else{
                     
        //             $message_title="Purchase Failure";
        //             $message_description="din't login".$row->Name.".try again";
        //            }
                   
        //            $this->kaizala_model->send_announcement($message_title,
        //            $message_description,$subcribers,$time);
        
        //         }
        //         else{
        //             //send invalid data message
        //             echo"invalid data provided ... for buyer";
        //         }
        //         //4.Request to save data
        //         //5.send a confirmation
        //     }
      
    }
        
    ?>