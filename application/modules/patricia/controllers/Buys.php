<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buys extends MX_Controller
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
        
        $this->load->model("sells_model");
        $this->load->model("kaizala_model");
        $this->load->model("brands_model");
        $this->load->model("buys_model");
    }
// save seller
    function create_buy(){
        //receive JSON POST
        $json_string = file_get_contents("php://input");
        //2.convert JSON to an array
        $json_object =json_decode($json_string);   
        //3.validate
        if(is_array($json_object) && (count($json_object)>0)){
            //retrieve data
            $row=$json_object[0];
            $date_submitted = date("Y-m-d H:i:s");
            $data =array(
                "Brand_name" =>$row->Brand,
                "Brand_model_name"=>$row->model,
                "price"=>$row->price,
                "color"=>$row->color,
                "profile_image"=>$row->picture,
                "responder_phone"=>$row->phone,
                "responder_name"=>$row->name,
                "response_time"=>$row->time
            );
            //4.Request to submit
           $save_status= $this->buys_model->save_buy($data);
           //create announcement data
          /* $subscribers = array($row->phone);
           $brand_name = $row->Brand;
           $brand_model_name = $row->model;
     
    
           $message_fields = array(
            "brand" => $brand_name,
            "brand_model" => $brand_model_name,
            "image" => $row->picture,
            "price" => $row->price
        );
          /* $subcribers =array($row->phone);

           if($save_status ==TRUE){
             $message_title ="Sells Successfull";
             $message_description ="Thankyou ".$row->name.".for your car.";


           }else{
             
            $message_title="Sells Failure";
            $message_description="dint login".$row->name.".try again";
           }
           
           $this->kaizala_model->send_announcement($title,$description,$status,$date,$fields,$receivers);
           //($message_title, $message_description,$subcribers)

        }
        else{
            //send invalid data message
            echo"invalid data provided";
        }
        //4.Request to save data
        //5.send a confirmation
        $message_description = $brand_name." ".$brand_model_name;

        if($save_status == TRUE)
        {
            $message_title = "Your post has been accepted";
            $status = "Status: Published";
        }
        else
        {
            $message_title = "Your post was not successful";
            $status = "Status: Error";
        }
        
        //Send the announcement
        $this->kaizala_model->send_announcement($message_title, $message_description, $subscribers, $status, $date_submitted, $message_fields);*/
    }

    else
    {
        //Send invalid data message
        echo "Invalid data provided";
    }
    }
}
    
?>