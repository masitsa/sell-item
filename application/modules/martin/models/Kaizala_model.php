<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaizala_model extends CI_Model
{
    private function get_access_token() {
        $application_id = "810ac010-0c49-47bd-bc53-9d0f8bbde326";
		$application_secret = "7ZLTB5H1VI";

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
        $err = curl_error($ch);

		curl_close($ch);

		if ($err) {
		echo "cURL Error #:" . $err;
		} else {
		return (json_decode($response))->accessToken;
		}
	}
    }
    public function send_announcement($title, $message, $receivers) {
        $group_id = "a2648ba2-927d-4c95-a78b-a6dc473fe6f5@2";
        $url = "https://kms.kaiza.la/v1/groups".$group_id."/actions";
        $access_token = $this->get_access_token();

        $request_data = array(
            "id" => "com.nanyukiaf.martin.announcement.2",
            "sendToAllSubscribers" => false,
            "subscribers" => $receivers,
            "actionBody" => array(
                "properties" => array(
                    array(
                        "name" => "messageTitle",
                        "value" => $title,
                        "type" => "Text"
                    ),
                    array(
                        "name" => "responseMessage",
                        "value" => $message,
                        "type" => "Text"
                    )
                )
            )
        );

        $request_json = json_encode($request_data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "accessToken: ".$accessToken,
            "Content-Type: application/json",
            "Content-Length: ".strlen($request_json),
        ));
        $result = curl_exec($ch);
        curl_close($ch);

        $result_object = json_decode($result);
        return $result_object->action_id;
        
    }
}

?>