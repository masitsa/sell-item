<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaizala_model extends CI_Model
{
 private function get_access_code()
 {
$application_id="810ac010-0c49-47bd-bc53-9d0f8bbde326";
$application_secret="7ZLTB5H1VI";
$refresh_token="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MTAxNDE1OTlcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiNDczNzdjNmQtZjQxNC00NTNkLTg4MzYtNmU3ZmM4NGJkMGNlXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIlNhbXVlbE5hbnl1a2lhZkNvbm5lY3RvclxcXCJ9XCJ9IiwidWlkIjoiTW9iaWxlQXBwc1NlcnZpY2U6MmMwMDhiNzAtNjI1ZS00NzVkLThhNGMtMDNjOTJlODEyOTI3QDIiLCJ2ZXIiOiIyIiwibmJmIjoxNTQ1MzcwNjQ0LCJleHAiOjE1NzY5MDY2NDQsImlhdCI6MTU0NTM3MDY0NCwiaXNzIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8iLCJhdWQiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyJ9.XbwB-sl2-5xAoKuABvsOwMP3fC_Ek7OYIHaZzeIkWm0";

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
    $response_decoded=json_decode($response);
    return $response_decode->accessToken;
    }  
    public function send_announcement($title, $message,$receivers)
    {
    $group_id ="a0090dec-78b5-4914-b61b-241638e22862@2";
    $url="https://kms.kaiza.lav1/groups/".$group_id."/actions";
    $access_token =$this->get_access_token();
    $request_data = array(
            "id" => "com.nanyukiaf.samuel.announcement.2",
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
  $request_json= json_encode($request_data);
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