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

    // public function retrieve_brands_and_models()
    // {
    //     $all_brands = $this->brands_model->retrieve_brands();

    //     if($all_brands->num_rows() > 0)
    //     {
    //         $brands = $all_brands->result();
    //         $brands_encoded = json_encode($brands);
    //         echo $brands_encoded;
    //     }

    //     else{
    //         echo "No brands found";
    //     }
    // }
    public function retrieve_brands_and_models()
    {
        $queryResult = $this -> brands_model ->selectretrieve_brands_and_models();

        if($queryResult->num_rows() > 0)
        {
            $brands = $queryResult->result();
            $brands_encoded = json_encode($brands);
            echo $brands_encoded;
        }

        else{
            echo "No brands found";
        }
    }
}
?>