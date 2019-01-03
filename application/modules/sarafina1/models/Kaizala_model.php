<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
     class Kaizala_model extends CI_Model 
     {
         private function get_access_token(){
            //  $application_id = "9851e0ed-e774-414b-acd9-4f64cef369f8";
            //  $application_secret = "QSG1WATUWH";
              
            //  $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MTU1MjcxMjBcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiOTg1MWUwZWQtZTc3NC00MTRiLWFjZDktNGY2NGNlZjM2OWY4XCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIlNhcmFmaW5hTmFueXVraUNvbm5lY3RvclxcXCJ9XCJ9IiwidWlkIjoiTW9iaWxlQXBwc1NlcnZpY2U6ZjQ3MWQ3NzktMDg2OS00ODdmLTkyNjMtN2RkNGNkZTljMjcwQDIiLCJ2ZXIiOiIyIiwibmJmIjoxNTQ2NTI5MTYwLCJleHAiOjE1NzgwNjUxNjAsImlhdCI6MTU0NjUyOTE2MCwiaXNzIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8iLCJhdWQiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyJ9.H_GbZNNu276pZFooc8yxgfF1hRK3ceohvVFMYue4giE";
            //  $end_point = "https://kms.kaiza.la/v1/accessToken";


            //  $ch = curl_init($end_point);
             
            //  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            //  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            //  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            //      "applicationId: ".$application_id,
            //      "applicationSecret: ".$application_secret,
            //      "refreshToken: ".$refresh_token,
            //      "Content-Type: application/json"
            //  ));
     
            //  $response = curl_exec($ch);
            //  curl_close($ch);
     
            //  $response_decoded = json_decode($response);
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kms2.kaiza.la/v1/accessToken",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "applicationId: 9851e0ed-e774-414b-acd9-4f64cef369f8",
                "applicationSecret: QSG1WATUWH",
                "refreshToken: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MTU1MjcxMjBcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiOTg1MWUwZWQtZTc3NC00MTRiLWFjZDktNGY2NGNlZjM2OWY4XCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIlNhcmFmaW5hTmFueXVraUNvbm5lY3RvclxcXCJ9XCJ9IiwidWlkIjoiTW9iaWxlQXBwc1NlcnZpY2U6ZjQ3MWQ3NzktMDg2OS00ODdmLTkyNjMtN2RkNGNkZTljMjcwQDIiLCJ2ZXIiOiIyIiwibmJmIjoxNTQ2NTI5MTYwLCJleHAiOjE1NzgwNjUxNjAsImlhdCI6MTU0NjUyOTE2MCwiaXNzIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8iLCJhdWQiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyJ9.H_GbZNNu276pZFooc8yxgfF1hRK3ceohvVFMYue4giE"
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $response_decoded = json_decode($response);
             return $response_decoded->accessToken;
         }
     
         public function send_announcement($title, $message, $receivers, $time)
         {
            //  $group_id = "d498658f-2362-46f5-85e6-7f8d8a3e6b75@2";
            //  $url = "https://kms.kaiza.la/v1/groups/".$group_id."/actions";
            //  $access_token = $this->get_access_token();
     
             $request_data = array(
                 "id" => "com.nanyukiaf.sarafina.announcement.2",
                 "sendToAllSubscribers" => false,
                 "subscribers" => $receivers,
                 "actionBody" => array(
                     "properties" => array(
                         array(
                             "name" => "downDescription",
                             "value" => $title,
                             "type" => "Text"
                         ),
                         array(
                             "name" => "upDescription",
                             "value" => $message,
                             "type" => "Text"
                         ),
                         array(
                            "name" => "date",
                            "value" => $time,
                            "type" => "Text"
                        )
                     )
                 )
             );
     
             $request_json = json_encode($request_data);
     
            //  $ch = curl_init($url);
            //  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            //  curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
            //  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            //      "accessToken: ".$access_token,
            //      "Content-Type: application/json"
            //  ));
     
            //  $result = curl_exec($ch);
            //  curl_close($ch);

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kms2.kaiza.la/v1/groups/d498658f-2362-46f5-85e6-7f8d8a3e6b75@2/actions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $request_json,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Postman-Token: 97a07a55-a741-486b-bdd6-6d192d01cd7d",
                "accessToken: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MTU1MjcxMjBcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiOTg1MWUwZWQtZTc3NC00MTRiLWFjZDktNGY2NGNlZjM2OWY4XCIsXCJwZXJtaXNzaW9uc1wiOlwiMi4zMDozLjMwOjQuMTA6Ni4yMjo1LjQ6OS4yOjE1LjMwOjE0LjMwOjE5LjMwOjI0LjMwXCIsXCJhcHBsaWNhdGlvblR5cGVcIjozLFwiZGF0YVwiOlwie1xcXCJBcHBOYW1lXFxcIjpcXFwiU2FyYWZpbmFOYW55dWtpQ29ubmVjdG9yXFxcIn1cIn0iLCJ1aWQiOiJNb2JpbGVBcHBzU2VydmljZTpmNDcxZDc3OS0wODY5LTQ4N2YtOTI2My03ZGQ0Y2RlOWMyNzBAMiIsInZlciI6IjIiLCJuYmYiOjE1NDY1MjkxNjksImV4cCI6MTU0NjYxNTU2OSwiaWF0IjoxNTQ2NTI5MTY5LCJpc3MiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyIsImF1ZCI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIn0.xbiTayf4gRJRMrrgVM-PbhzO4vnR7n3fuGh1FSz_RDo"
            ),
            ));

            $response = curl_exec($curl);

            $err = curl_error($curl);

            curl_close($curl);
            var_dump($response );die();
            if ($err) {
            echo "cURL Error #:" . $err;
            } else {
                $result_object = json_decode($response);
                return $result_object->actionId;
            }
     
             
         }
     }
         
?>