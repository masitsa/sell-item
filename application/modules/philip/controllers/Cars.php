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

    public function create_seller(){
        // 1. Receive json post
        // $json_string = file_get_contents("php://input");
        $json_string = '[
            {
              "brand": "BMW",
              "model": "328d",
              "transmission": "Semi-Automatic",
              "picture": "https://cdn.inc-000.kms.osi.office.net/att/80395189fa326df9941d3ea3d5193bfd436a6c431c499a0df5e5d3f6b1e5cc18.jpg?sv=2015-12-11&sr=b&sig=%2BOXFSUpUXDfkrXE%2BFgqOcu%2FwuQQNYic8R5XR40Rf%2FSE%3D&st=2019-01-08T11:51:16Z&se=2292-10-23T12:51:16Z&sp=r",
              "money": "20000000",
              "name": "Philip",
              "phone": "+254723232563",
              "location": "{\"lt\":0.018113094516997823,\"lg\":37.074078614575377,\"n\":\"0.018113094516997823, 37.07407861457538\"}",
              "time": "1546951875852"
            }
          ]';
        // 2. convert json to array
        $json_object = json_decode($json_string);
      
        // 3. validate
        if(is_array($json_object) && (count($json_object) > 0)){
            // Retreive the data
                $row = $json_object[0];
                $date_submitted = date("Y-m-d H:i:s");
                $data = array(
                    "responder_name" => $row-> name,
                    "responder_phone" => $row-> phone,
                    "response_time" => $row-> time,
                    "brand_name" => $row-> brand,
                    "brand_model" => $row-> model,
                    "transmission_type" => $row-> transmission,
                    "car_image" => $row-> picture,
                    "price" => $row-> money,
                );

            // 4. Request to submit
            $save_status = $this->cars_model ->save_seller($data);

            //Create announcement receivers
            $subscribers  = array($row->phone);
            $brand_name = $row->brand;
            // var_dump($brand_name);
            $brand_model = $row->model;

            $message_fields = array(
                "brand" => $brand_name,
                "brand_model" => $brand_model,
                "image" => $row->picture,
                "price" => $row->money
            );
            // var_dump($message_fields);
            $message_description = $brand_name." ".$brand_model;

            if($save_status ==TRUE){
                $message_title = "Your post has been accepted";
                $status = "Status: Published";
            }
            else{
                $message_title = "Checking UnSuccessful";
                $status= "Status: Error";
            }

            //send announcement
            $this->kaizala_model->send_announcement($message_title, $message_description, $subscribers, $status, $date_submitted, $message_fields);

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