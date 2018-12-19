<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Martin_card extends MX_Controller
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
        
		$this->load->model("martin_card_model");
		$this->load->model("kaizala_model");
	}
	function create_card() {
		//1. Receive JSON POST
		$json_string = file_get_contents("php://input");

		//2. Convert JSON to array
		$json_object = json_decode($json_string);

		
		//3. Validate
		if (is_array($json_object) && (count($json_object) > 0)) {
			//1. Retrieve the data
			$row = $json_object[0];
			$data = array(
				"responder_name" => $row->name,
				"responder_phone" => $row->phone,
				"responder_date" => $row->date
			);
			//2. Request to submit
			$save_status = $this->martin_card_model->save_card($data);
			// Create announcement receivers
			$subscribers = array($row->phone);
			//3. Request to save data
			if($save_status == TRUE) {
				//4. Send a confirmation
				$message_title = "Card submission successful";
				$message_description = "Thank you ".$row->name. "for using our platform";
			} else {
				$message_title = "Card submission failed. Please try again";
				$message_description = "The attempt was not successful. Please try again";
			}
			$this->kaizala_model->send_announcement($message_title, $message_description, $subscribers);
		}
		else {
			//5. Send invalid data message
			echo "Invalid data provided";
		}		
	}

	function getAccess(){
		$application_id = "810ac010-0c49-47bd-bc53-9d0f8bbde326";
		$application_secret = "7ZLTB5H1VI";
		echo 12;

        $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MjYxNDkzNTFcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiODEwYWMwMTAtMGM0OS00N2JkLWJjNTMtOWQwZjhiYmRlMzI2XCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIkFsdmFyb05hbnl1a2lhZkNvbm5lY3RvclxcXCJ9XCJ9IiwidWlkIjoiTW9iaWxlQXBwc1NlcnZpY2U6ODZmZWI1MmMtMTRkNS00YTdkLTk4ZGEtYmEyYWI0NDBmMDhmIiwidmVyIjoiMiIsIm5iZiI6MTU0NTIyNjY4NSwiZXhwIjoxNTc2NzYyNjg1LCJpYXQiOjE1NDUyMjY2ODUsImlzcyI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIiwiYXVkIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8ifQ.K0pacDSS8LT4UrQye0UCtV7uDvEGNhIne1j5VUKSqJ4";

        $end_point = "https://kms.kaiza.la/v1/accessToken";
        //Calls the endpoint
        $ch = curl_init($end_point);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "applicationId: ".$application_id,
            "applicationSecret: ".$application_secret,
            "refreshToken: ".$refresh_token,
            "Content-Type: application/json"
        ));
        $response = curl_exec($ch);
        $err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		echo "cURL Error #:" . $err;
		} else {
		echo $response;
		}
	}
}
?>