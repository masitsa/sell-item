<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Favouritelistings extends MX_Controller
{
    /**
     * Constructor for this controller.
     *
     * Tasks:
     * 		Checks for an active advertiser login session
     *	- and -
     * 		Loads models required
     */
    function __construct()
    {
        parent::__construct();
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
    }
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function favorite_listings()
    {
        $company = array();
        $count = 0;
        //nearme url
        // $url = "http://infomoby-api.azurewebsites.net/index.php/ke/search_redesign/nearmeredesign/8.957046/38.763025/10/0/10";
        //recommended url
        $url = "http://infomoby-api.azurewebsites.net/index.php/ke/search_redesign/recommendedredesign//8.957046/38.763025/2000/0/10";
        // $url = "https://infomoby-api.azurewebsites.net/index.php/ke/search_redesign/getfavouriteresults/user_id/-1.28333/36.81667/0/300";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:0c9e64ab66a28f5576e24c3b21614e88 '
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        // foreach ($result as $oneresult) {
        //     $company_name = $oneresult["company_name"];
        //     var_dump($company_name);
        // }
        // var_dump($result);
        // echo $result;
        // echo "Serena Hotel";
        // $result2 = preg_replace('/\s+/', '', $result);
        // $result = str_replace('&quot;', '"', $result);
        $json_object = json_decode($result);
        $error = json_last_error();
        // var_dump($json_object);
        $companies = $json_object->companies;
        $allCompanies = [];
        // var_dump($companies);
        for ($i = 0; $i < count($companies); $i++) {
            // $comp = $companies[0]->company_name;
            $categoryname = $companies[$i]->category_name;
            $companyname = $companies[$i]->company_name_en;
            $companyaddress = $companies[$i]->city_name_en;
            $contacts = $companies[$i]->bphone;
            $logo = $companies[$i]->logo;

            $company['categoryName'] = $categoryname;
            $company['companyName'] = $companyname;
            $company['companyAddress'] = $companyaddress;
            $company['companyContact'] = $contacts;
            $company['companyLogo'] = $logo;

            array_push($allCompanies, $company);
        }
        echo (json_encode($allCompanies));
        // //list the company name and contact
        // echo "<table border='2px' border-color='blue'>";
        // echo "<tr>";
        // echo "<th>Count</th><th>Companies Near Me</th>";
        // echo "</tr>";
        // for ($i = 0; $i < count($company_name); $i++) {
        //     $count++;
        //     $card = $company_name[$i];
        //     echo "<tr>";
        //     echo "<td>" . $count . "</td>";
        //     echo "<td>" . $card . "</td>";
        //     echo "</tr>";
        // }
        // echo "</table>";

    }
    function companyLength()
    {
        $company = array();
        //nearme url
        // $url = "http://infomoby-api.azurewebsites.net/index.php/ke/search_redesign/nearmeredesign/8.957046/38.763025/10/0/10";
        //recommended url
        $url = "http://infomoby-api.azurewebsites.net/index.php/ke/search_redesign/recommendedredesign//8.957046/38.763025/2000/0/10";
        // $url = "https://infomoby-api.azurewebsites.net/index.php/ke/search_redesign/getfavouriteresults/user_id/-1.28333/36.81667/0/300";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:0c9e64ab66a28f5576e24c3b21614e88 '
        ));
        $result = curl_exec($ch);
        curl_close($ch);

        $json_object = json_decode($result);
        $error = json_last_error();
        // var_dump($json_object);
        $companies = $json_object->companies;
        $count = count($companies);
        echo $count;
    }
    function send_actioncard()
    {
        $json_str = file_get_contents('php://input');
        $json_obj = json_decode($json_str, true);
        var_dump($json_obj);
        if ((is_array($json_obj)) && (count($json_obj) > 0)) {
            // var_dump( $json_obj[0]);die();
            $membermobilenumber = $json_obj[0]["membermobilenumber"];
            // $senderName = $json_obj[0]["sender"];
            // $warning = stripos($message, "bomb");

            $group_id = "34043c6a-30f2-490f-ac98-6a2be2927210";

            $url = "https://kms.kaiza.la/v1/groups/" . $group_id . "/actions";
            echo "whaat";
            var_dump($this->generateAccessToken());
        }

    }
    private function generateAccessToken()
    {
        echo "hello world";
        // to generate an access token you need refresh token, applicationid, applicationsecret
        $applicationId = "3b740b9e-3b64-4edc-bbf5-141064003042";
        $applicationSecret = "DN55O331CO";
        $refreshToken = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3NTMwMjgwOThcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiM2I3NDBiOWUtM2I2NC00ZWRjLWJiZjUtMTQxMDY0MDAzMDQyXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcIlRoZXVyaSBDb25uZWN0b3JcXFwifVwifSIsInVpZCI6Ik1vYmlsZUFwcHNTZXJ2aWNlOmNiZDRjOTYxLWY2YTEtNDZmMS1iNWZhLTZmZjYyOGZiZTRlYyIsInZlciI6IjIiLCJuYmYiOjE1NDE0ODYxNzUsImV4cCI6MTU3MzAyMjE3NSwiaWF0IjoxNTQxNDg2MTc1LCJpc3MiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyIsImF1ZCI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIn0.LZLve3O4C_85pdsLJ7Wuhr9bigYIAeQkgZrUASaSNoo";
        $curl_url = "https://kms.kaiza.la/v1/accessToken";
        $ch = curl_init($curl_url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'applicationId: ' . $applicationId,
            'applicationSecret: ' . $applicationSecret,
            'refreshToken: ' . $refreshToken,
            'Content-Type: application/json',
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        $responseobj = json_decode($response);
        return $responseobj;
        // var_dump($responseobj);
    }



}
