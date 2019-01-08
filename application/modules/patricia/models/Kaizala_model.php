<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Kaizala_model extends CI_Model

{

    public function get_access_token()
    // private function get_access_token()

    {

        $application_id = "6ad59200-d579-4291-9e45-c14c6c2f1380";

        $application_secret = "UP9WM4YJS2 ";



        $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MjkzMDIzNTdcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiMWQ4NzFiZDItMjc3Yy00NzNlLWJhY2UtOTI0MGE2MGU1ZmVhXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIlBhdHJpY2lhTmFueXVraWFmQ29ubmVjdG9yXFxcIn1cIn0iLCJ1aWQiOiJNb2JpbGVBcHBzU2VydmljZTo5YzZlMzc0Zi1jNzhkLTQ2ZTItOGM5Mi0wYjcxOTdjMTRmNGRAMiIsInZlciI6IjIiLCJuYmYiOjE1NDY5MzUwNjYsImV4cCI6MTU3ODQ3MTA2NiwiaWF0IjoxNTQ2OTM1MDY2LCJpc3MiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyIsImF1ZCI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIn0.ZtcK1xfKnpSeHvPi53pa-1el_uY19ELeC6EVc_6Uns8";
        


        $end_point = "https://kms2.kaiza.la/v1/accessToken";

//webservice to query above server end point

        $ch = curl_init($end_point);
        //curl sending data in headers

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(

            "applicationId: ".$application_id,

            "applicationSecret: ".$application_secret,

            "refreshToken: ".$refresh_token,

            "Content-Type: application/json"

        ));



        $response = curl_exec($ch);
        //security feature

        curl_close($ch);


//change to array  from json
        $response_decoded = json_decode($response);

        return $response_decoded->accessToken;

    }


//use 4 filds title,descri in your new file you will create
public function send_announcement($title, $description, $status,  $fields, $receivers)
   // ($title, $message, $receivers)

    {

        $group_id = "101e078a-089b-4351-b6a4-7f4df129eb3a@2";

        $url = "https://kms2.kaiza.la/v1/groups/".$group_id."/actions";

        $access_token = $this->get_access_token();



        $request_data = array(

            "id" => "com.nanyukiaf.patricia.car.announcement",

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

                        "name" => "carStatusDescription",

                        "value" =>$status,

                        "type" => "Text"

                    ),
                    array(

                        "name" => "date",

                        "value" =>$date,

                        "type" => "Text"

                    ),
                    array(

                        "name" => "carJson",

                        "value" =>json_encode($fields),

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