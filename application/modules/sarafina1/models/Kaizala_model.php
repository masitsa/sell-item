<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
     class Kaizala_model extends CI_Model 
     {
         private function get_access_token(){
             $application_id = "9851e0ed-e774-414b-acd9-4f64cef369f8";
             $application_secret = "QSG1WATUWH";
              
             $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MTU1MjcxMjBcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiOTg1MWUwZWQtZTc3NC00MTRiLWFjZDktNGY2NGNlZjM2OWY4XCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIlNhcmFmaW5hTmFueXVraUNvbm5lY3RvclxcXCJ9XCJ9IiwidWlkIjoiTW9iaWxlQXBwc1NlcnZpY2U6ZjQ3MWQ3NzktMDg2OS00ODdmLTkyNjMtN2RkNGNkZTljMjcwQDIiLCJ2ZXIiOiIyIiwibmJmIjoxNTQ1MzI4MzE4LCJleHAiOjE1NzY4NjQzMTgsImlhdCI6MTU0NTMyODMxOCwiaXNzIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8iLCJhdWQiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyJ9.gsuB0qfQgooUuWrKwfHCJakFrVw5E4tCV0r6DWpVQYQ";
             $endpoint = "https://kms.kaiza.la/v1/accessToken";


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
     
         public function send_announcement($title, $message, $receivers)
         {
             $group_id = "d498658f-2362-46f5-85e6-7f8d8a3e6b75@2";
             $url = "https://kms.kaiza.la/v1/groups/".$group_id."/actions";
             $access_token = $this->get_access_token();
     
             $request_data = array(
                 "id" => "com.nanyukiaf.sarafina.announcement.2",
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