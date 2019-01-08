<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaizala_model extends CI_Model
{
    private function get_access_token()
    {
        $application_id = "ba50a817-76fc-4e2f-8c01-01b9397b35f3";
        $application_secret = "OOHZOGTMXT";

        $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MTU1MjcxMjBcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiYmE1MGE4MTctNzZmYy00ZTJmLThjMDEtMDFiOTM5N2IzNWYzXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIkVfY29tbWVyY2VcXFwifVwifSIsInVpZCI6Ik1vYmlsZUFwcHNTZXJ2aWNlOmY0NzFkNzc5LTA4NjktNDg3Zi05MjYzLTdkZDRjZGU5YzI3MEAyIiwidmVyIjoiMiIsIm5iZiI6MTU0NjkzNTcwNSwiZXhwIjoxNTc4NDcxNzA1LCJpYXQiOjE1NDY5MzU3MDUsImlzcyI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIiwiYXVkIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8ifQ.waOJ_LsA6XDjecb10t93nGikCItLMknqZLg_EhLxswM";

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

        $response_decoded = json_decode($response);
        return $response_decoded->accessToken;
    }

    public function send_announcement($receivers, $title, $description, $status, $date, $Fields)
    {
        $group_id = "d498658f-2362-46f5-85e6-7f8d8a3e6b75@2";
        $url = "https://kms2.kaiza.la/v1/groups/".$group_id."/actions";
        $access_token = $this->get_access_token();

        $request_data = array(
            "id" => "com.nanyukiaf.sarafina.announcement.2",
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
                        "name" => "responseMessage",
                        "value" => $Fields,
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