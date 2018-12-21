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
		echo 232;
		$application_id = "810ac010-0c49-47bd-bc53-9d0f8bbde326";
		$application_secret = "7ZLTB5H1VI";

        $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MTE1ODEwMDlcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiM2Y4NjA4NmMtYWFmZC00ZDdmLWE2MTEtMjg5MTkyMDUxZGNjXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIk1hcnRpbk5hbnl1a2lhZkNvbm5lY3RvclxcXCJ9XCJ9IiwidWlkIjoiTW9iaWxlQXBwc1NlcnZpY2U6YTk3MDE2MTItMTFiMC00ZDEyLTk1ODMtMDY5YWU1NjU0NDc5QDIiLCJ2ZXIiOiIyIiwibmJmIjoxNTQ1MjI2ODU3LCJleHAiOjE1NzY3NjI4NTcsImlhdCI6MTU0NTIyNjg1NywiaXNzIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8iLCJhdWQiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyJ9.xubUdWvXs68jaXCybKXuVyTK4PAx9-fFdVomjUri3-A";

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
        $err = curl_error($ch);

		curl_close($ch);

		if ($err) {
		echo "cURL Error #:" . $err;
		} else {
		return (json_decode($response))->accessToken;
		}
	}
}
?>