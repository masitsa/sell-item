<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brands extends MX_Controller
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

    public function get_brands_and_models()
    {
        $queryResult = $this -> brands_model ->get_brands_and_models();

        if($queryResult->num_rows() > 0)
        {
            $brands = $queryResult->result();
            $brands_encoded = json_encode($brands);
            echo $brands_encoded;
        }

        else{
            echo "No brands found";
        }}
        public function get_posted_cars() {
        $all_get_cars = $this->brands_model->get_cars();

        if($all_get_cars->num_rows() > 0)
        {
            $get_cars_brands = $all_get_cars->result();
            $get_cars_brands_encoded = json_encode($get_cars_brands);
            echo $get_cars_brands_encoded;
        }

        else {
            echo "No cars found";
        }
    }
}
?>