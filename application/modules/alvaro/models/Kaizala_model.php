<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaizala_model extends CI_Model
{
    private function get_access_token()
    {
        $application_id = "c8e05d1f-9e90-4c67-b468-15d7278d16f3";
        $application_secret = "TVBARIQHVG";

        $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MjYxNDkzNTFcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiYzhlMDVkMWYtOWU5MC00YzY3LWI0NjgtMTVkNzI3OGQxNmYzXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIkthaXphbGEgRWNvbW1lcmNlXFxcIn1cIn0iLCJ1aWQiOiJNb2JpbGVBcHBzU2VydmljZTo4NmZlYjUyYy0xNGQ1LTRhN2QtOThkYS1iYTJhYjQ0MGYwOGYiLCJ2ZXIiOiIyIiwibmJmIjoxNTQ2OTM1MDU4LCJleHAiOjE1Nzg0NzEwNTgsImlhdCI6MTU0NjkzNTA1OCwiaXNzIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8iLCJhdWQiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyJ9.BDRUxM7bjq3GZl_HV7vFWo0vQAi74vIKfH_k195dfIs";

        $end_point = "https://kms.kaiza.la/v1/accessToken";

        $ch = curl_init($end_point);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
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
        $group_id = "c601e0e3-2d41-4a02-88a2-f7e4949dc706";
        $url = "https://kms.kaiza.la/v1/groups/".$group_id."/actions";
        $access_token = $this->get_access_token();

        $request_data = array(
            "id" => "com.nanyukiaf.alvaro.announcemnt.3",
            "sendToAllSubscribers" => false,
            "subscribers" => $receivers,
            "actionBody" => array(
                "properties" => array(
                    array(
                        "name" => "sellerTitle",
                        "value" => json_encode($title),
                        "type" => "Text"
                    ),
                    array(
                        "name" => "carDescription",
                        "value" => json_encode($description),
                        "type" => "Text"
                    ),
                    array(
                        "name" => "carStatus",
                        "value" => json_encode($status),
                        "type" => "Text"
                    ),
                    array(
                        "name" => "date",
                        "value" => json_encode($date),
                        "type" => "Text"
                    ),
                    array(
                        "name" => "carJson",
                        "value" =>json_encode($fields),
                        "type" => "Text"
                    )
                )
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