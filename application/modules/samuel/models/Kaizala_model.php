<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaizala_model extends CI_Model
{
 private function get_access_code()
 {
$application_id="0252de3e-8862-407b-b53d-b4b0d72ce491";
$application_secret="5QQWX9004W ";
$refresh_token="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MTAxNDE1OTlcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiMDI1MmRlM2UtODg2Mi00MDdiLWI1M2QtYjRiMGQ3MmNlNDkxXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIkthaXphbGEgRWNvbW1lcmNlXFxcIn1cIn0iLCJ1aWQiOiJNb2JpbGVBcHBzU2VydmljZToyYzAwOGI3MC02MjVlLTQ3NWQtOGE0Yy0wM2M5MmU4MTI5MjdAMiIsInZlciI6IjIiLCJuYmYiOjE1NDY5MzUyMzQsImV4cCI6MTU3ODQ3MTIzNCwiaWF0IjoxNTQ2OTM1MjM0LCJpc3MiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyIsImF1ZCI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIn0.8oTlOznM6LVswhoXqVYCjXKulZcxI0izHomcF7Gq5NU";

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
    $response_decoded=json_decode($response);
    return $response_decode->accessToken;
    }  
    public function send_announcement($title, $description,$status,$date,  $message,$receivers)
    {
    $group_id ="a0090dec-78b5-4914-b61b-241638e22862@2";
    $url="https://kms2.kaiza.lav1/groups/".$group_id."/actions";
    $access_token =$this->get_access_token();
    $request_data = array(
            "id" => "com.nanyukiaf.samuel.announcement.3",
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
                        "value" => $fields,
                        "type" => "Text"
                    )
                )
            )
        );
  $request_data= json_encode($request_data);
  $$ch = curl_init($url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST,
  "POST");
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
  cur_setopt($ch, CURLOPT_HTTPHEADER, array(
      "accessToken:".$access_token,
      "content_Type:application/json",
      "content_Length:".strlen($request_json)
  ));
  $result =curl_exec($ch);
  curl_close($ch);
  $result_object = json_encode($result);
  return $result_object->actionId;
 }
}