<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaizala_model extends CI_Model
{
    private function get_access_token() {
        $application_id = "f82445b2-9730-4728-849c-68762c6a4dfc";
        $application_secret = "2TVKMTHJRR";

        $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MTQyNzMzMDVcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiZjgyNDQ1YjItOTczMC00NzI4LTg0OWMtNjg3NjJjNmE0ZGZjXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIkthaXphbGEgRWNvbW1lcmNlXFxcIn1cIn0iLCJ1aWQiOiJNb2JpbGVBcHBzU2VydmljZTpiZTIwYzNlNi0zYzg2LTRjZTMtOTI5NC0xZTZiZTJkNzU4MDdAMiIsInZlciI6IjIiLCJuYmYiOjE1NDcwMTI3OTcsImV4cCI6MTU3ODU0ODc5NywiaWF0IjoxNTQ3MDEyNzk3LCJpc3MiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyIsImF1ZCI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIn0.VWddtcRlesShVijTt7ubhIASTv-pnpuCb-krLf9ESz8";

        $end_point = "https://kms2.kaiza.la/v1/accessToken";
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
        curl_close($ch);

        $response_decoded = json_decode($response);
        return $response_decoded->accessToken;
	}
    public function send_announcement($title, $description, $status, $date, $fields, $receivers)
    {
        $group_id = "a2648ba2-927d-4c95-a78b-a6dc473fe6f5@2";
        $url = "https://kms2.kaiza.la/v1/groups/".$group_id."/actions";
        $access_token = $this->get_access_token();

        $request_data = array(
            //"id" => "com.nanyukiaf.alvaro.announcemnt.2",
            "id" => "com.nanyuki.fredrick.car.announcement.2",
            "sendToAllSubscribers" => false,
            "subscribers" => $receivers,
            "actionBody" => array(
            "properties" => array(
            array(
            "name" => "sellerTitle",
            "value" => $title,
            "type" => "Text"
            ),
            array(
            "name" => "carDescription",
            "value" => $description,
            "type" => "Text"
            ),
            array(
            "name" => "carStatus",
            "value" => $status,
            "type" => "Text"
            ),
            array(
            "name" => "date",
            "value" => $date,
            "type" => "Text"
            ),
            array(
            "name" => "carJson",
            "value" => json_encode($fields),
            "type" => "Text")
            
            )//properties array ends here
            )
        );

        $request_json = json_encode($request_data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "accessToken: ".$access_token,
            "Content-Type: application/json",
            "Content-Length: ".strlen($request_json)
        ));

        $result = curl_exec($ch);
        curl_close($ch);

        $result_object = json_decode($result);
        return $result_object->actionId;
    }
}

?>