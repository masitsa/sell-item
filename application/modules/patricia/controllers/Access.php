<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends MX_Controller
{
    function __construct() {
		parent:: __construct();

		// Allow from any origin
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}
	
		// Access-Control headers are received during OPTIONS requests
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
	
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	
			exit(0);
        }
        
        $this->load->model("brands_model");
    }

    public function getAccess()

    {

        $application_id = "1d871bd2-277c-473e-bace-9240a60e5fea";

        $application_secret = "RG85PINOS1";

        $refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MjkzMDIzNTdcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiMWQ4NzFiZDItMjc3Yy00NzNlLWJhY2UtOTI0MGE2MGU1ZmVhXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIlBhdHJpY2lhTmFueXVraWFmQ29ubmVjdG9yXFxcIn1cIn0iLCJ1aWQiOiJNb2JpbGVBcHBzU2VydmljZTo5YzZlMzc0Zi1jNzhkLTQ2ZTItOGM5Mi0wYjcxOTdjMTRmNGRAMiIsInZlciI6IjIiLCJuYmYiOjE1NDUzODUxODIsImV4cCI6MTU3NjkyMTE4MiwiaWF0IjoxNTQ1Mzg1MTgyLCJpc3MiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyIsImF1ZCI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIn0.dJJ7ZgDNUBfQ4-j3vFVK73e_dQGociT8sGjKkttCx5w";
        


        $end_point = "https://kms2.kaiza.la/v1/accessToken";



        $ch = curl_init($end_point);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(

            "applicationId: .$application_id ",

            "applicationSecret: .$application_secret",

            "refreshToken: .$refresh_token",

            "Content-Type: application/json"

        ));

        $response = curl_exec($ch);
        curl_close($ch);
        echo 12;
        return $response;

        $response_decoded = json_decode($response);

        return $response_decoded->accessToken;

    }
}
?>
