<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaizala_model extends CI_Model
{
  private function get_access_token(){
    //   $application_id = "19038f9a-a888-481e-8672-4b6b8f7ac9ea";
    //   $application_secret = "TQLZ5FNYF4";

    //   $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MjMyMzI1NjNcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiMTkwMzhmOWEtYTg4OC00ODFlLTg2NzItNGI2YjhmN2FjOWVhXCIsXCJwZXJtaXNzaW9uc1wiOlwiMi4zMDozLjMwOjQuMTA6Ni4yMjo1LjQ6OS4yOjE1LjMwOjE0LjMwOjE5LjMwOjI0LjMwXCIsXCJhcHBsaWNhdGlvblR5cGVcIjozLFwiZGF0YVwiOlwie1xcXCJBcHBOYW1lXFxcIjpcXFwiUGhpbGlwTmFueXVraWFmQ29ubmVjdG9yXFxcIn1cIn0iLCJ1aWQiOiJNb2JpbGVBcHBzU2VydmljZTphNTM4MTIzZC0xZGFmLTRlM2UtYmNlNC05NzYzODRiYjE1MWRAMiIsInZlciI6IjIiLCJuYmYiOjE1NDUyMzQzNjAsImV4cCI6MTU0NTMyMDc2MCwiaWF0IjoxNTQ1MjM0MzYwLCJpc3MiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyIsImF1ZCI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIn0.2_sNwG2BumsVsN4DhS1EifFrpYj_sumGc2T9vEWL4lg";

    //   $end_point = "https://kms.kaiza.la/v1/accessToken";
    //   $ch = curl_init($end_point);
    //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    //   curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //       "applicationId: " .$application_id,
    //       "applicationSecret: " .$application_secret,
    //       "refreshToken: " .$refresh_token,
    //       "Content-Type: application/json"
    //   ));
    //   //CAPTUREFROM API
    //   $response = curl_exec($ch);
    //   curl_close($ch);

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
        "applicationId: 19038f9a-a888-481e-8672-4b6b8f7ac9ea",
        "applicationSecret: TQLZ5FNYF4",
        "refreshToken: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MjMyMzI1NjNcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiMTkwMzhmOWEtYTg4OC00ODFlLTg2NzItNGI2YjhmN2FjOWVhXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIlBoaWxpcE5hbnl1a2lhZkNvbm5lY3RvclxcXCJ9XCJ9IiwidWlkIjoiTW9iaWxlQXBwc1NlcnZpY2U6YTUzODEyM2QtMWRhZi00ZTNlLWJjZTQtOTc2Mzg0YmIxNTFkQDIiLCJ2ZXIiOiIyIiwibmJmIjoxNTQ1Mzk3NDI2LCJleHAiOjE1NzY5MzM0MjYsImlhdCI6MTU0NTM5NzQyNiwiaXNzIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8iLCJhdWQiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyJ9.RGRgPmgFdstKJZgcaEuA0LVh5pTZn0WwaRON9wHI748"
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
      $response_decoded = json_decode($response);
    //   var_dump($response_decoded); die();
      return $response_decoded->accessToken;
      }

      public function send_announcement($title, $message, $receivers){
          $group_id = "8f754b3d-6460-4be5-a9f2-d40142555483@2";
          $url = "https://kms.kaiza.la/v1/groups/".$group_id."/actions";
          $access_token = $this->get_access_token();
          $request_data = array(
              "id" => "com.nanyukiaf.cecilia.announcement.2",
              "sendToAllSubscribers" => false,
              "subscribers" => $receivers,
              "actionBody" =>array(
                "properties" => array(
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
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
          curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              "accessToken:" .$access_token ,
              "Content-Type: application/json",
              "content-length:".strlen($request_json) 
          ));
          $result = curl_exec($ch);
          curl_close($ch);
          $result_object = json_decode($result);
        //   var_dump($result_object); die();
          return $result_object->actionId;
        }
}
?>