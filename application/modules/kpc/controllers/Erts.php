<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Erts extends MX_Controller {
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

	public function save_ert()
	{
		$json_string = file_get_contents("php://input");
		
		$json_object = json_decode($json_string);
		
		foreach($json_object as $row){
            $data = 
            array(
                'corrective_action' => $row->corrective_action, 
                'obstacles_faced' => $row->obstacles_faced,
                'preliminary_results' => $row->preliminary_results, 
                'incident_id' => $row->incident_id
			);
			
			if($this->db->insert("kpc_ert", $data)){
				$this->get_incident_ert($row->incident_id);
			}

			else{
				echo "error";
			}
		}
	}

	private function get_incident_ert($incident_id){
		$this->db->select('*');
		$this->db->from('incidents');
		$this->db->join('kpc_ert', 'incidents.id=kpc_ert.incident_id');
		$this->db->where('incidents.id', $incident_id);
		$incidents = $this->db->get();
		$incidents_str =  json_encode($incidents->result());
		$response = json_decode($incidents_str);

		$response = json_encode($response);

		// set post fields
		$post = ['response' => $response];

		$url = 'https://prod-05.westeurope.logic.azure.com:443/workflows/71ef5fbcbe9f4da2a705327a7fd3ea54/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=AoB2nsTtxjqZls06r9dpVN7I5MXsWM8DROfXXd34XkM';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
			)
		);
		// execute!
		$response = curl_exec($ch);

		// close the connection, release resources used
		curl_close($ch);

		echo "saved";
	}

	public function get_ert(){
		$json_string = file_get_contents("php://input");
		
		$json_object = json_decode($json_string);
		$response = [];
		foreach($json_object as $row){
			$this->db->select('*');
			$this->db->from('kpc_ert');
			$this->db->where('incident_id', $row->incident_id);
			$incidents = $this->db->get();
			$incidents_str =  json_encode($incidents->result());
			$response = json_decode($incidents_str);
		}

		echo json_encode($response);
	}

	public function save_sos()
	{
		$json_string = file_get_contents("php://input");
		
		$json_object = json_decode($json_string);
		
		foreach($json_object as $row){
            $data = 
            array(
                'results_investigation' => $row->results_investigation, 
                'action_taken' => $row->action_taken,
				'root_cause_analysis' => $row->root_cause_analysis, 
				'long_term_solution' => $row->long_term_solution, 
                'incident_id' => $row->incident_id
			);
			
			if($this->db->insert("kpc_sos", $data)){
				$this->sendToAdmin($row->incident_id);
			}

			else{
				echo "error";
			}
		}
	}

	public function get_sos(){
		$json_string = file_get_contents("php://input");
		
		$json_object = json_decode($json_string);
		$response = [];
		foreach($json_object as $row){
			$this->db->select('*');
			$this->db->from('kpc_sos');
			$this->db->where('incident_id', $row->incident_id);
			$incidents = $this->db->get();
			$incidents_str =  json_encode($incidents->result());
			$response = json_decode($incidents_str);
		}

		echo json_encode($response);
	}

	private function sendToAdmin($incident_id){
		$this->db->select('*');
		$this->db->from('incidents');
		$this->db->join('kpc_ert', 'incidents.id=kpc_ert.incident_id');
		$this->db->join('kpc_sos', 'incidents.id=kpc_sos.incident_id');
		$this->db->where('incidents.id', $incident_id);
		$incidents = $this->db->get();
		$incidents_str =  json_encode($incidents->result());
		$response = json_decode($incidents_str);

		$response = json_encode($response);

		// set post fields
		$post = ['response' => $response];

		$url = 'https://prod-64.westeurope.logic.azure.com:443/workflows/a25e0fbebc6640158771f56836b5b6fd/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=ILBV7RFglNcvfXKD9REXD0_tCo2VgNFPuVR7iuAMX8U';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
			)
		);
		// execute!
		$response = curl_exec($ch);

		// close the connection, release resources used
		curl_close($ch);
		
		echo "saved";
	}

	
}
