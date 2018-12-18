<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mkopa extends MX_Controller {
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

	public function save_checkin()
	{
		$json_string = file_get_contents("php://input");
		$json_object = json_decode($json_string);
		$count = 0;
		$checkin_time = $job_title = $responser_name = $responder_phone = $response_time = "";

		if (is_array($json_object)) {
			if (count($json_object) > 0) {
				$row = $json_object[0];
				$checkin_time = $row->checkingtime;
				$job_title = $row->jobtitle;
				$responser_name = $row->responderName;
				$responder_phone = $row->responderPhone;
				// $response_time = $row->responseTime;
				$response_time = date('Y-m-d H:i:s');

				//Save to SQL Server
				$host = 'kaizalamkopa.database.windows.net';
				$username = 'm0318363';
				$password = 'Mkopa@123';
				$db_name = 'KaizalaMkopa';
				$authentication = 'SQL Server';
				$port = 3306;
	
				$serverName = $host; // update me
				$connectionOptions = array(
					"Database" => $db_name, // update me
					"Uid" => $username, // update me
					"PWD" => $password // update me
				);
				//Establishes the connection
				$conn = sqlsrv_connect($serverName, $connectionOptions);
				if( $conn === false ) {
					die( print_r( sqlsrv_errors(), true));
				}
	
				//Get max primary key
				$response_id = 0;
				// $tsql = "SELECT max(response_id) AS resp_id FROM response";
				$tsql = "SELECT IDENT_CURRENT('response_id') AS CurrId";
				$getResults = sqlsrv_query($conn, $tsql);
				
				if ($getResults == FALSE){
					var_dump (sqlsrv_errors());
				}
				else{
					$next_response_id = 1;
					if($getResults != NULL){
						while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
							$response_id = $row['CurrId'];
							if(empty($response_id)){
								$next_response_id = 1;
							}
							else{
								$next_response_id = $response_id++;
							}
						}
					}
					
					
					sqlsrv_free_stmt($getResults);
					
					//Save to database
					$sql = "INSERT INTO response (response_id, response_answer, response_name, response_phone, created_on, question_id) VALUES (?, ?, ?, ?, ?, ?)";
					$params = array($next_response_id, $checkin_time, $responser_name, $responder_phone, $response_time, 1);
					
					$stmt = sqlsrv_query( $conn, $sql, $params);
					if( $stmt === false ) {
						die( print_r( sqlsrv_errors(), true));
					}
				
					sqlsrv_free_stmt($stmt);
					
					$next_response_id++;
					$sql = "INSERT INTO response (response_id, response_answer, response_name, response_phone, created_on, question_id) VALUES (?, ?, ?, ?, ?, ?)";
					$params = array($next_response_id, $job_title, $responser_name, $responder_phone, $response_time, 2);
					
					$stmt = sqlsrv_query( $conn, $sql, $params);
					if( $stmt === false ) {
						die( print_r( sqlsrv_errors(), true));
					}
				
					sqlsrv_free_stmt($stmt);
				}
			}
		}
	}
}