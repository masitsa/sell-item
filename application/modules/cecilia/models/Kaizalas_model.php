<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaizalas_model extends CI_Model
{
  private function get_access_token(){
      $application_id = "887d2bb5-3865-42a4-a6a0-d66a7d3944a4";//from connector
      $application_secret = "5WFIVU07SU";               //       FROM COONNECTOR
                //FROM POSTMAN
      $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MDgxMDUzMjdcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiODg3ZDJiYjUtMzg2NS00MmE0LWE2YTAtZDY2YTdkMzk0NGE0XCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIkthaXphbGEgRWNvbW1lcmNlXFxcIn1cIn0iLCJ1aWQiOiJNb2JpbGVBcHBzU2VydmljZTpmMmYyZGNlMi0xYjZjLTQ2NTQtOWEwNC0yYWRmZDA0MjNjY2UiLCJ2ZXIiOiIyIiwibmJmIjoxNTQ2OTM1Mzk0LCJleHAiOjE1Nzg0NzEzOTQsImlhdCI6MTU0NjkzNTM5NCwiaXNzIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8iLCJhdWQiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyJ9.lY_VR8k_ddO48rD1sI-UkF418GP7ZqFcfNiSD6fQ8b4";
     
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
    //   var_dump($response_decoded); die();
      return $response_decoded->accessToken;
      }

      public function send_announcement($title, $description, $status, $date, $fields, $receivers){
          $group_id = "0a6e3c2c-93f3-43ed-bd69-b9267b5cf8c6";
          $url = "https://kms.kaiza.la/v1/groups/".$group_id."/actions";
          $access_token = $this->get_access_token();
          $request_data = array(        //SEND ANNOUNCEMENT WITH FOLLOWING DATA
              "id" => "com.nanyukiaf.cecilia.car.announcement.3",
              "sendToAllSubscribers" => false,
              "subscribers" => $receivers,
              "actionBody" =>array(
                "properties" => array(
                    array(
                       "name" => "sellerTitle",
                       "value"=> $title ,
                       "type" =>"Text"
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
                        "name" => "carjson",
                        "value" => json_encode($fields),
                        "type" => "Text"
                    )
                )
              )
          );
                //array TO string
          $request_json = json_encode($request_data);
          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");//send it 
          curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              "accessToken:" .$access_token ,
              "Content-Type: application/json",
              "content-length:".strlen($request_json) 
          ));
          $result = curl_exec($ch);
          curl_close($ch);
          //OBJECT TO STRING
          $result_object = json_decode($result);
       
          return $result_object->actionId;
        }
}
?>