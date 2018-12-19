<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaizalas_model extends CI_Model
{
  private function get_access_token(){
      $application_id = "45c3294a-9473-4897-9cc9-e33873bf0eb2";
      $application_secret = "STCFQHG6JB";

      $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MDgxMDUzMjdcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiNDVjMzI5NGEtOTQ3My00ODk3LTljYzktZTMzODczYmYwZWIyXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIkNlY2lsaWFuYW55dWtpYWZjb25uZWN0b3JcXFwifVwifSIsInVpZCI6Ik1vYmlsZUFwcHNTZXJ2aWNlOmYyZjJkY2UyLTFiNmMtNDY1NC05YTA0LTJhZGZkMDQyM2NjZSIsInZlciI6IjIiLCJuYmYiOjE1NDUyMjY3MTQsImV4cCI6MTU3Njc2MjcxNCwiaWF0IjoxNTQ1MjI2NzE0LCJpc3MiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyIsImF1ZCI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIn0.QaVjy6x83FKre42lRsQCTePaN3B-6tu2kjgp1fP7olY";

      $end_point = "https://kms.kaiza.la/v1/accessToken";
      $ch = curl_init($end_point);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "applicationId: " .$application_id,
          "applicationSecret: " .$application_secret,
          "refreshToken: " .$refresh_token,
          "Content-Type: application/json"
      ));
      //CAPTUREFROM API
      $response = curl_exec($ch);
      curl_close($ch);
      $response_decoded = json_decode($response);
      return $response_decoded->accesstoken;
      }

      public function send_announcement($title, $message, $receivers){
          $group_id = "0a6e3c2c-93f3-43ed-bd69-b9267b5cf8c6";
          $url = "https://kms.kaiza.la/v1/groups".$group_id."/actions";
          $accesstokens = $this->get_access_token();
          $request_data = array(
              "id" => "com.nanyukiaf.cecilia.announcement.2",
              "sendToAllSubscribers" => false,
              "subscribers" => $receivers,
              "actionBody" =>array(
                "properties" => aray(
                    array(
                       "name" => "messageTitle",
                       "value"=> $title ,
                       "type" =>"Text"
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
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST);
          curl_setopt($ch, CURLOPT_POSTFIELDS);
          curl_setopt($ch,CURLOPT_RETURNTRANSFER);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              "accessToken:" .$access_token ,
              "Content-Type: applicatin/json",
              "content-length:".strlen($request_json) 
          ));
          $result = curl_exec($ch);
          curl_close($ch);
          $result_object = json_decode($result);
          return $result_object->actionId;
        }
}
?>