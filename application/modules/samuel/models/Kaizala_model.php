<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaizala_model extends CI_Model
{
    private function get_access_token()
    {
        $application_id="5f0e58ed-98f4-4975-9bd7-626f5266b690";
        $application_secret="PODK4JB6YC";
        $refresh_token="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MTAxNDE1OTlcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiNWYwZTU4ZWQtOThmNC00OTc1LTliZDctNjI2ZjUyNjZiNjkwXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIkthaXphbGEgRWNvbW1lcmNlIFNhbVxcXCJ9XCJ9IiwidWlkIjoiTW9iaWxlQXBwc1NlcnZpY2U6MmMwMDhiNzAtNjI1ZS00NzVkLThhNGMtMDNjOTJlODEyOTI3QDIiLCJ2ZXIiOiIyIiwibmJmIjoxNTQ3MDE3MjIxLCJleHAiOjE1Nzg1NTMyMjEsImlhdCI6MTU0NzAxNzIyMSwiaXNzIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8iLCJhdWQiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyJ9.MFYUdrdTpEMJt9uHOjHYBqrQgOvZN8_T8sTABlmJ8UY";

        $end_point = "https://kms2.kaiza.la/v1/accessToken";

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
        // var_dump($response);
        $response_decoded=json_decode($response);
        return $response_decoded->accessToken;
    }  
    public function send_announcement($title, $description,$status,$date, $fields, $receivers)
    {
        $group_id ="a0090dec-78b5-4914-b61b-241638e22862@2";
        $url="https://kms2.kaiza.la/v1/groups/".$group_id."/actions";
        $access_token = $this->get_access_token();
        // echo $access_token."<br/>";
        $request_data = array(
            "id" => "com.nanyukiaf.samuel.car.announcement.19",
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
                        "type" => "Text"
                    )
                )
            )
        );
        // var_dump($request_data);
        $request_json= json_encode($request_data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "accessToken: ".$access_token,
            "content-Type: application/json",
            "content-Length: ".strlen($request_json)
        ));
        $result =curl_exec($ch);
        curl_close($ch);
        // var_dump($result);
        $result_object = json_decode($result);
        return $result_object->actionId;
    }
}