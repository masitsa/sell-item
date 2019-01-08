<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaizala_model extends CI_Model
{
    private function get_access_token() {
        $application_id = "38da0c13-0961-4c7f-bcea-e0b6fdeac222";
        $application_secret = "3WGAV7FX7Y";

        $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MTE1ODEwMDlcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiMzhkYTBjMTMtMDk2MS00YzdmLWJjZWEtZTBiNmZkZWFjMjIyXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcImthaXphbGEgY29tbWVyY2VcXFwifVwifSIsInVpZCI6Ik1vYmlsZUFwcHNTZXJ2aWNlOmE5NzAxNjEyLTExYjAtNGQxMi05NTgzLTA2OWFlNTY1NDQ3OUAyIiwidmVyIjoiMiIsIm5iZiI6MTU0NjkzNTUyMiwiZXhwIjoxNTc4NDcxNTIyLCJpYXQiOjE1NDY5MzU1MjIsImlzcyI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIiwiYXVkIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8ifQ.tqQ3Tf1_ArUJjzMtdP_zhy7FOAGvySF3MC5-CXte-GA";

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
            "id" => "com.nanyuki.martin.announcement.3",
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