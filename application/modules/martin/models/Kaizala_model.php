<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kaizala_model extends CI_Model
{
    private function get_access_token() {
        $application_id = "3f86086c-aafd-4d7f-a611-289192051dcc";
        $application_secret = "HDJNX2MYNK";
        $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisy
        NTQ3MTE1ODEwMDlcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2Fpem
        FsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiM2Y4NjA4NmMtYWFmZC00ZDdmLWE2MTEtMjg5MTkyMDUxZGNjXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIs
        XCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIk1hcnRpbk5hbnl1a2lhZkNvbm5lY3RvclxcXCJ9XCJ9IiwidW
        lkIjoiTW9iaWxlQXBwc1NlcnZpY2U6YTk3MDE2MTItMTFiMC00ZDEyLTk1ODMtMDY5YWU1NjU0NDc5QDIiLCJ2ZXIiOiIyIiwibmJmIjoxNTQ1MjI2ODU3LCJl
        eHAiOjE1NzY3NjI4NTcsImlhdCI6MTU0NTIyNjg1NywiaXNzIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8iLCJhdWQiOiJ1cm46bWljcm9zb2
        Z0OndpbmRvd3MtYXp1cmU6enVtbyJ9.xubUdWvXs68jaXCybKXuVyTK4PAx9-fFdVomjUri3-A";
        $end_point = "https://kms.kaiza.la/v1/accessToken";
        //Calls the endpoint
        $ch = curl_init($end_point);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "application_id: ".$application_id,
            "application_secret: ".$application_secret,
            "refreshToken: ".$refresh_token,
            "Content-Type: application/json"
        ));
        $response = curl_exec($ch);
        curl_close($ch);

        $response_decoded = json_decode($response);
        return $response_decoded->$accessToken;
    }
    public function send_announcement($title, $message, $receivers) {
        $group_id = "a2648ba2-927d-4c95-a78b-a6dc473fe6f5@2";
        $url = "https://kms.kaiza.la/v1/groups".$group_id."/actions";
        $access_token = $this->get_access_token();

        $request_data = array(
            "id" => "com.nanyukiaf.martin.announcement.2",
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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "accessToken: ".$accessToken,
            "Content-Type: application/json",
            "Content-Length: ".strlen($request_json),
        ));
        $result = curl_exec($ch);
        curl_close($ch);

        $result_object = json_decode($result);
        return $result_object->action_id;
        
    }
}

?>