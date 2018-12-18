<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Africa/Nairobi');
set_time_limit(0);

class Progress extends MX_Controller
{
    /**
     * Constructor for this controller.
     *
     * Tasks:
     *         Checks for an active advertiser login session
     *    - and -
     *         Loads models required
     */
    public function __construct()
    {
        parent::__construct();
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400'); // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            }

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }

            exit(0);
        }
    }

	public function save_progress()
	{
		$json_string = file_get_contents("php://input");
		
        // var_dump($json_string); die();
		$json_object = json_decode($json_string);
		// var_dump($json_object); die();
		foreach($json_object as $row){
			$data = array(
				"name" => $row->name,
				"phone" => $row->phone,
				"date" => $row->date,
				"page" => $row->page,
				"lessons" => $row->lessons,
				"problems" => $row->problems,
				"created" => date("Y-m-d H:i:s"),
				"formated_date" => $this->format_date($row->date)
			);

			if($this->db->insert("webdevprogress", $data)){
				echo "saved";
			}

			else{
				echo "error";
			}
		}
    }

    public function format_date($timestamp = "1544013178916"){
        $timestamp = preg_replace('/\s/', '', $timestamp);
        $timestamp_length = strlen($timestamp);
        $max_length = 10;
        if($timestamp_length > $max_length){
            $extra_length = $max_length - $timestamp_length;
            $timestamp = substr($timestamp, 0, $extra_length);
        }
        $timestamp = $timestamp * 1;
        $new_date = date("Y-m-d H:i:s", $timestamp);
        return $new_date;
    }

    function update_formatted_date(){
        $query = $this->db->get("webdevprogress");

        if($query->num_rows() > 0){
            foreach($query->result() as $res){
                $date = $res->date;
                $id = $res->id;
                $formatted_date = $this->format_date($date);
                $this->db->where("id", $id);
                $this->db->update("webdevprogress", array("formated_date" => $formatted_date));
            }
        }
    }

    function getAccessToken()
    {
        // Connector details (Connector ID and secret)
        $applicationId = 'b3bc8785-fec9-48ec-bde6-be7a24ff771b';
        $applicationSecret = 'HY84AMMSEV';

        // From Kaizala auth 1.1
        $refreshToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MTcwNjQ2MjRcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiYjNiYzg3ODUtZmVjOS00OGVjLWJkZTYtYmU3YTI0ZmY3NzFiXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIkthaXphbGEgVHJhaW5pbmcgQ29ubiAxMDFcXFwifVwifSIsInVpZCI6Ik1vYmlsZUFwcHNTZXJ2aWNlOmY2Y2ZiMzMwLTdlZjQtNGRjZC05YTRjLTlmZGEyMjcwYjMyYyIsInZlciI6IjIiLCJuYmYiOjE1NDMzOTY0NzQsImV4cCI6MTU3NDkzMjQ3NCwiaWF0IjoxNTQzMzk2NDc0LCJpc3MiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyIsImF1ZCI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIn0.rJFQlstT2QMNPIOE1SoO3HMtQJu_8x_2LVxHNXtHxIQ';

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

    public function get_region(){
        $this->db->select("DISTINCT(Region) as region");
        $query = $this->db->get("safaricom_regions");
        $date = date("Y-m-d");

        if($query->num_rows() > 0){
            foreach($query->result() as $res){
                $region = $res->region;
                $total_daily_registrations = $this->get_sso_daily_region_registrations($date, $region);
                $total_registrations = $this->get_sso_total_region_registrations($region);
                $this->send_reports($region, $date, $total_registrations, $total_daily_registrations);
            }
        }
    }
    
    public function send_reports($region, $send_date, $total_registrations, $total_daily_registrations){
        $group_id = "1e6b627f-9e9b-491d-a930-0bdbec9ff3c4";
        $url = "https://kms.kaiza.la/v1/groups/" . $group_id . "/actions";
        $date = date('jS M Y', strtotime($send_date));
        $headingMessage = $region." Region Report";
        $bodyMessage = $total_registrations." SSO registrations on ".$date;
        $date = $total_registrations." total SSO registrations";
        
        // echo $device.$sensor.$status.$date; die();
        $access_token = $this->getAccessToken();
        $request_data = array(
            "id" => "com.safaricom.ssoregistration.report",
            "sendToAllSubscribers" => true,
            // "subscribers" => array("+254726149351"),
            // "sendToAllSubscribers" => false,
            "actionBody" => array(
                "properties" => array(
                    array(
                        "name" => "headingMessage",
                        "value" => $headingMessage,
                        "type" => "Text",
                    ),
                    array(
                        "name" => "bodyMessage",
                        "value" => $bodyMessage,
                        "type" => "Text",
                    ),
                    array(
                        "name" => "date",
                        "value" => $date,
                        "type" => "Text",
                    ),
                ),
            ),
        );
        $data_string = json_encode($request_data);
        $ch = curl_init($url);
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
        return $response_json->actionId;
    }

    function get_sso_daily_region_registrations($date, $region){
        $this->db->where("created LIKE '".$date."%' AND region = '".$region."'");
        $query = $this->db->get("sso");
        return $query->num_rows();
    }

    function get_sso_total_region_registrations($region){
        $this->db->where("region = '".$region."'");
        $query = $this->db->get("sso");
        return $query->num_rows();
    }
}
