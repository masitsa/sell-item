<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Telesales extends MX_Controller {
	/**
	 * Constructor for this controller.
	 *
	 * Tasks:
	 * 		Checks for an active advertiser login session
	 *	- and -
	 * 		Loads models required
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
                header("Access-Control-Allow-Headers: token, Content-Type");
                header('Content-Type: text/plain');
            }

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
	function get_customers(){

		$json_string = file_get_contents("php://input");
        $json_object = json_decode($json_string);
		$response = array();
		
		if (is_array($json_object)) {
            if (count($json_object) > 0) {
                // foreach ($json_object as $row) {
				$row = $json_object[0];
				$username = $row->username;
				$this->db->select('*');
				$this->db->from('customers');
				$this->db->where('username', $username);
				$customers = $this->db->get();

				echo json_encode($customers->result());

                // }
            } else {
                $response["result"] = "false";
                $response["message"] = "No results present in request object";
            }
        } else {
            $response["result"] = "false";
            $response["message"] = "Error in request object";
        }
    }
    function searched_customers(){

		$json_string = file_get_contents("php://input");
        $json_object = json_decode($json_string);
		$response = array();
		
		if (is_array($json_object)) {
            if (count($json_object) > 0) {
                // foreach ($json_object as $row) {
				$row = $json_object[0];
				$username = $row->username;
				$this->db->select('*');
				$this->db->from('searched_customers');
				$this->db->where('username', $username);
				$customers = $this->db->get();

				echo json_encode($customers->result());

                // }
            } else {
                $response["result"] = "false";
                $response["message"] = "No results present in request object";
            }
        } else {
            $response["result"] = "false";
            $response["message"] = "Error in request object";
        }
	}
}
