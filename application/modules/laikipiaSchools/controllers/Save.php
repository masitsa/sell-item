<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Save extends MX_Controller {
	/**
	 * Constructor for this controller.
	 *
	 * Tasks:
	 * 		Checks for an active advertiser login session
	 *	- and -
	 * 		Loads models required
	 */
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
    }

    public function savetodb()
    {
        $json_string = file_get_contents("php://input");
        // $json_string = '[
        //     {
        //       "school_name": "Laikipia primary",
        //       "boys": "31",
        //       "girls": "28",
        //       "about": "Hdhxhd",
        //       "logo": "https://cdn.ins-000.kms.osi.office.net/att/e9b01398cccaa13f08c9e9a6b1a297d8433c08b04a9171266bc262ac67ffec39.jpg?sv=2015-12-11&sr=b&sig=IjnfwH6HJcUBQAmWMgXOVJE8wj725xBHnSh%2Fo7wyL7g%3D&st=2018-11-25T16:33:49Z&se=2292-09-09T17:33:49Z&sp=r",
        //       "location": "{\"lt\":-1.3158641,\"lg\":36.8221452,\"n\":\"-1.3158641, 36.8221452\",\"acc\":15.979999542236328}",
        //       "date": 1543167228585,
        //       "name": "Alvaro",
        //       "phone": "+254726149351"
        //     }
        //   ]';
        $pureresultString = array();
        $json_object = json_decode($json_string);
        $count =0;

        if(is_array($json_object))
        {
            if(count($json_object) > 0)
            {
                foreach($json_object as $row)
                {
                    // var_dump($row);die();
                    $location = json_decode($row->location);
                    // echo $row->date;
                    $date = $row->date;
                    $ts = $row->date;
                    $date = new DateTime("@$ts");
                    echo $date->format('U = Y-m-d H:i:s') . "\n";
                    $data = array(
                        "school_name" => $row->school_name,
                        "boys" => $row->boys,
                        "girls" => $row->girls,
                        "about" => $row->about,
                        "logo" => $row->logo,
                        "date" => $date->format('U = Y-m-d H:i:s'),
                        "name" => $row->name,
                        "phone" => $row->phone,
                        "latitude" => $location->lt,
                        "longitude" => $location->lg
                    );
                    if($this->db->insert("laikipia_schools", $data)){
                        $response["result"] = "true";
                        $response["message"] = "Request saved successfully";
                    }

                    else{
                        $response["result"] = "false";
                        $response["message"] = "Unable to save item";
                    }
                }
            }
            else{
                $response["result"] = "false";
                $response["message"] = "No results present in request object";
            }
        }
        else{
            $response["result"] = "false";
            $response["message"] = "Error in request object";
        }
        echo json_encode($response);
    }
}
