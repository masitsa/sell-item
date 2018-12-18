<?php
Class ActionCard extends CI_Model
{
	var $group_id;
    var $url;

    function __construct() {
		parent:: __construct();
		
		$this->group_id = "aa5e1c1f-b1aa-450e-b24e-4ed378f49704";
		$this->url = "https://kms.kaiza.la/v1/groups/" . $this->group_id . "/actions";
    }
    
    function getAccessToken()
    {
        // Connector details (Connector ID and secret)
        $applicationId = '1fa0cd53-a736-4476-94d1-7fd910812988';
        $applicationSecret = '1XJQ78AD0Q';

        // From Kaizala auth 1.1
        $refreshToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MjYxNDkzNTFcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiMWZhMGNkNTMtYTczNi00NDc2LTk0ZDEtN2ZkOTEwODEyOTg4XCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIkFwcEZhY3RvcnlcXFwifVwifSIsInVpZCI6Ik1vYmlsZUFwcHNTZXJ2aWNlOjg2ZmViNTJjLTE0ZDUtNGE3ZC05OGRhLWJhMmFiNDQwZjA4ZiIsInZlciI6IjIiLCJuYmYiOjE1NDM5MjE1MzksImV4cCI6MTU3NTQ1NzUzOSwiaWF0IjoxNTQzOTIxNTM5LCJpc3MiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyIsImF1ZCI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIn0.78CUp53EFcp3QZU_CGyfv8H__wsMt1_asv0QGSQnDp8';

        // URL to fetch
        $CURL_URL = "https://kms.kaiza.la/v1/accessToken";

        // Performing the HTTP request
        $ch = curl_init($CURL_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'applicationId: ' . $applicationId,
            'applicationSecret: ' . $applicationSecret,
            'refreshToken: ' . $refreshToken,
            'Content-Type: application/json',
        )
        );
        $response_body = curl_exec($ch);
        curl_close($ch);

        $response_json = json_decode($response_body);
        return $response_json->accessToken;
    }

    function sendannouncement($messageReceiver, $message, $from)
    {
        $date = date('jS M Y H:i a', strtotime(date("Y-m-d H:i:s")));
        $subscribers = array($messageReceiver);
        $access_token = $this->getAccessToken();
        $request_data = array(
            "id" => "com.airlines.getfilecontent.18",
            "sendToAllSubscribers" => false,
            "subscribers" => $subscribers,
            "actionBody" => array(
                "properties" => array(
                    // array(
                    //     "name" => "locationTitle",
                    //     "value" => $title,
                    //     "type" => "Text",
                    // ),
                    array(
                        "name" => "downDescription",
                        "value" => "FROM: ".$from,
                        "type" => "Text",
                    ),
                    array(
                        "name" => "upDescription",
                        "value" => $message,
                        "type" => "Text",
                    ),
                    array(
                        "name" => "date",
                        "value" => $date,
                        "type" => "Text",
                    ),
                    array(
                        "name" => "jsonString",
                        "value" => "sampletext",
                        "type" => "Text",
                    )
                ),
            ),
        );
        $data_string = json_encode($request_data);
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accessToken: ' . $access_token,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($ch);
        curl_close($ch);

        $response_json = json_decode($result);
        var_dump($response_json);
        return $response_json->actionId;
    }
}