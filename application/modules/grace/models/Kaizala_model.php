<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaizala_model extends CI_Model
{
   private function get_access_token(){
       $application_id = "8c522b66-ff1b-4d48-8c77-22b70c13ae18";
       $application_secret = "T2XQMKT9Q5";
       $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MDg4MDc0MDNcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiOGM1MjJiNjYtZmYxYi00ZDQ4LThjNzctMjJiNzBjMTNhZTE4XCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIkdyYWNlTmFueXVraUFmQ29ubmVjdG9yXFxcIn1cIn0iLCJ1aWQiOiJNb2JpbGVBcHBzU2VydmljZTozYzNiNzU0Yi0zNjE3LTQwZjUtODQ5Ni03ZDJlYTdmZDU0ZjBAMiIsInZlciI6IjIiLCJuYmYiOjE1NDY5MzUyMzQsImV4cCI6MTU3ODQ3MTIzNCwiaWF0IjoxNTQ2OTM1MjM0LCJpc3MiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyIsImF1ZCI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIn0.HSulP_GNpE6Z03nMMANjMT2REaxym3-KnZV5PKo8wEo";

       $end_point = "https://kms2.kaiza.la/v1/accessToken";

       $ch = curl_init($end_point);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array("applicationId: ".$application_id, "applicationSecret: ".$application_secret,
       "refreshToken: ".$refresh_token, "Content-Type: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $response_decoded = json_decode($response);
        return $response_decoded->accessToken;
   }

        public function send_announcement ($title, $description, $status, $fields, $receivers){
            
            $group_id = "57a34ceb-a66e-4140-affc-db6267d308bf@2";
            $url = "https://kms2.kaiza.la/v1/groups/".$group_id."/actions";
            $access_token = $this->get_access_token();

            $request_data = array (
            "id"=>"com.nanyukiaf.grace.car.announcement.6",
            "sendToAllSubscribers"=>false, "subscribers"=>$receivers,
            "actionBody"=>array(
            "properties"=>array(
            array(
                "name"=>"sellerTitle",
                "value"=>$title,
                "type" =>"Text"),
            array (
               "name"=>"carDescription",
               "value"=>$description,
               "type"=>"Text"
             ),
           array (
            "name"=>"carStatus",
            "value"=> $status,
            "type"=>"Text"
           ),
           array(
            "name" => "carJson",
            "value" => json_encode($fields),
            "type" => "Text"
        )
           
        

        )));

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