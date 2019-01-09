<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaizala_model extends CI_Model
{
    private function get_access_token(){

        
        $application_id = "ba50a817-76fc-4e2f-8c01-01b9397b35f3";
        $application_secret = "OOHZOGTMXT";
        $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MTU1MjcxMjBcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiYmE1MGE4MTctNzZmYy00ZTJmLThjMDEtMDFiOTM5N2IzNWYzXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIkVfY29tbWVyY2VcXFwifVwifSIsInVpZCI6Ik1vYmlsZUFwcHNTZXJ2aWNlOmY0NzFkNzc5LTA4NjktNDg3Zi05MjYzLTdkZDRjZGU5YzI3MEAyIiwidmVyIjoiMiIsIm5iZiI6MTU0NzAxOTMzNCwiZXhwIjoxNTc4NTU1MzM0LCJpYXQiOjE1NDcwMTkzMzQsImlzcyI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIiwiYXVkIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8ifQ.nQuGx5YiS42t2ZPUBZGBZAmiJAwUwIfZLCxX_yFVQck";


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

    public function send_announcement($title, $description, $status, $date, $fields, $receivers){
        $group_id = "44e43039-2ad9-4b29-ae95-4684ff45a91e@2";

        $url = "https://kms2.kaiza.la/v1/groups/".$group_id."/actions";
        $accessToken =$this->get_access_token();

        $request_data = array(
            "id"=>"com.nanyukiaf.sarafina.car.announcement.10",
            "sendToAllSubscribers"=>false,
            "subscribers"=>$receivers,
            "actionBody"=>array(
                "properties"=>array(
                    array(
                        "name"=>"sellerTitle",
                        "value"=>$title,
                        "type"=>"Text"
                    ),
                    array(
                        "name"=>"carDescription",
                        "value"=>$description,
                        "type"=>"Text"
                    ),
                    array(
                        "name"=>"carStatus",
                        "value"=>$status,
                        "type"=>"Text"
                    ),
                    array(
                        "name"=>"date",
                        "value"=>$date,
                        "type"=>"Text"
                    ),
                    array(
                        "name"=>"carJson",
                        "value"=>json_encode($fields),
                        "type"=>"Text"
                    )

                )//properties array ends here
            )


        );

        $request_json = json_encode($request_data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "accessToken: ".$accessToken,
            "Content-Type: application/json",
            "Content-Length: ".strlen($request_json)
        ));

        $result = curl_exec($ch);
        curl_close($ch);
        // var_dump($result);
        $result_object = json_decode($result);
        return $result_object->actionId;
    }

    public function format_date($timestamp = "1544013178916"){
        $timestamp = preg_replace('/\s/', '', $timestamp);
        $timestamp_length = strlen($timestamp);
        $max_length = 10;
        if($timestamp_length > $max_length){
            $extra_length = $max_length - $timestamp_length;
            $timestamp = substr($timestamp, 0, $extra_length);
        }
        $timestamp = $timestamp * 1;
        $new_date = date("Y-m-d H:i:s", $timestamp);
        return $new_date;
    }
}