<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaizala_model extends CI_Model
{
    private function get_access_token()
    {
        $application_id = "19038f9a-a888-481e-8672-4b6b8f7ac9ea";
        $application_secret = "TQLZ5FNYF4";

        $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MjMyMzI1NjNcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiMTkwMzhmOWEtYTg4OC00ODFlLTg2NzItNGI2YjhmN2FjOWVhXCIsXCJwZXJtaXNzaW9uc1wiOlwiMi4zMDozLjMwOjQuMTA6Ni4yMjo1LjQ6OS4yOjE1LjMwOjE0LjMwOjE5LjMwOjI0LjMwXCIsXCJhcHBsaWNhdGlvblR5cGVcIjozLFwiZGF0YVwiOlwie1xcXCJBcHBOYW1lXFxcIjpcXFwiUGhpbGlwTmFueXVraWFmQ29ubmVjdG9yXFxcIn1cIn0iLCJ1aWQiOiJNb2JpbGVBcHBzU2VydmljZTphNTM4MTIzZC0xZGFmLTRlM2UtYmNlNC05NzYzODRiYjE1MWRAMiIsInZlciI6IjIiLCJuYmYiOjE1NDUyMzQzNjAsImV4cCI6MTU0NTMyMDc2MCwiaWF0IjoxNTQ1MjM0MzYwLCJpc3MiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyIsImF1ZCI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIn0.2_sNwG2BumsVsN4DhS1EifFrpYj_sumGc2T9vEWL4lg";

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
        // var_dump($response_decoded);die();
        return $response_decoded->accessToken;
    }

    public function send_announcement($title, $message, $receivers)
    {
        $group_id = "8f754b3d-6460-4be5-a9f2-d40142555483@2";
        $url = "https://kms.kaiza.la/v1/groups/".$group_id."/actions";
        $access_token = $this->get_access_token();

        $request_data = array(
            "id" => "com.nanyukiaf.philip.announcement.2",
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