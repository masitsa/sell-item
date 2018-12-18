<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filecontents extends MX_Controller {
	var $uploads_path;
	var $uploads_location;
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
		
		$this->uploads_path = realpath(APPPATH . '../uploadedfiles');
		$this->uploads_location = base_url().'uploadedfiles/';

		$this->load->model("uploads");
		$this->load->model("actioncard");
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


	public function get_saved_files(){
		$query = $this->db->get('files');
		echo json_encode($query->result());
	}
	private function curl_get_file_contents($CURL_URL)
	{
		$c = curl_init();
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($c, CURLOPT_URL, $CURL_URL);
		$contents = curl_exec($c);
		curl_close($c);
		return $contents;
	}
	
	public function readFile(){
		$file_id = 7;
				
		//get File name
		$this->db->where("id", $file_id);
		$query = $this->db->get("files");

		if($query->num_rows() > 0){
			$row = $query->row();
			$xmlfile = $row->name;
			$xmlString = $this->curl_get_file_contents($this->uploads_location.$xmlfile);
			$xml = simplexml_load_string($xmlString);
			$json = json_encode($xml);
			$array = json_decode($json, true);
			// var_dump($array); die();

			$from = $array["MessageId"]["Sender"];
			$receiver = $array["PhoneNumber"];
			$message = $array["MessageText"];
			$title = $array["Header"];
			if(empty($title)){
				$title = "Announcement";
			}

			$this->actioncard->sendannouncement($title, $receiver, $message, $from);
		}

		else{
			echo "Subscriber not found";
		}
	}

    public function getSelectedFile(){

        $json_string = file_get_contents("php://input");
        $json_object = json_decode($json_string);
        
        if(count($json_object) > 0){
            foreach($json_object as $row){

				$file_id = $row->file_id;
				
				//get File name
				$this->db->where("id", $file_id);
				$query = $this->db->get("files");

				if($query->num_rows() > 0){
					$row = $query->row();
					$xmlfile = $row->name;
					$xmlString = $this->curl_get_file_contents($this->uploads_location.$xmlfile);
					$xml = simplexml_load_string($xmlString);
					$json = json_encode($xml);
					$array = json_decode($json, true);
					// var_dump($array); die();
		
					$from = $array["MessageId"]["Sender"];
					$receiver = $array["PhoneNumber"];
					$message = $array["MessageText"];
					$title = $array["Header"];
					if(empty($title)){
						$title = "ANNOUNCEMENT";
					}
		
					$this->actioncard->sendannouncement($receiver, $message, $from);
				}
		
				else{
					echo "Subscriber not found";
				}
            }
            // echo  $xmlfile;
        }
	}
	
	function index()
	{
		$v_data = array();
		if(isset($_FILES['xmlfile']))
		{
			if(is_uploaded_file($_FILES['xmlfile']['tmp_name']))
			{
				//import products from excel 
				$response = $this->uploads->upload_xml($this->uploads_path);
				
				if($response == FALSE)
				{
					$v_data['error'] = 'Something went wrong with uploading. Please try again.';
				}
				
				else
				{
					$file_name = $response;

					$save_data = array(
						"file_name" => $this->input->post("file_name"),
						"name" => $file_name,
						"created_at" => date("Y-m-d H:i:s")
					);
					if($this->db->insert("files", $save_data)){
						$this->session->set_userdata("success_message", "File uploaded successfully");
					}

					else{
						$v_data['error'] = 'Unable to save file. Please try again';
					}
				}
			}
			
			else
			{
				$v_data['error'] = 'Please select a file to import.';
			}
		}
		
		$this->load->view('uploadfiles', $v_data);
	}
}