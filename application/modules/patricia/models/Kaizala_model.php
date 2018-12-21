<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Kaizala_model extends CI_Model

{

    private function get_access_token()

    {

        $application_id = "1d871bd2-277c-473e-bace-9240a60e5fea";

        $application_secret = "RG85PINOS1";



        $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MjkzMDIzNTdcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiMWQ4NzFiZDItMjc3Yy00NzNlLWJhY2UtOTI0MGE2MGU1ZmVhXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIlBhdHJpY2lhTmFueXVraWFmQ29ubmVjdG9yXFxcIn1cIn0iLCJ1aWQiOiJNb2JpbGVBcHBzU2VydmljZTo5YzZlMzc0Zi1jNzhkLTQ2ZTItOGM5Mi0wYjcxOTdjMTRmNGRAMiIsInZlciI6IjIiLCJuYmYiOjE1NDUzODI2NjYsImV4cCI6MTU3NjkxODY2NiwiaWF0IjoxNTQ1MzgyNjY2LCJpc3MiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyIsImF1ZCI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIn0.4ncsnO1bpYRnlgLBvSUVAzSZVdL_Vgq1jZ44-JJrx2k";
        


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



        $response_decoded = json_decode($response);

        return $response_decoded->accessToken;

    }



    public function send_announcement($title, $message, $receivers)

    {

        $group_id = "101e078a-089b-4351-b6a4-7f4df129eb3a@2";

        $url = "https://kms.kaiza.la/v1/groups/".$group_id."/actions";

        $access_token = $this->get_access_token();



        $request_data = array(

            "id" => "com.nanyukiaf.alvaro.announcemnt.2",

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