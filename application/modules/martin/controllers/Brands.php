<?php
/*Defines the base path for security*/
defined('BASEPATH') OR exit('No direct script access allowed');

/*MX_controller stands for Modular Extensions*/
class Brands extends MX_Controller
{
    function __construct() { 
        /*Makes the constructor in the child class to execute the parent constructor*/
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

    public function get_brands()
    {
        $all_brands = $this->brands_model->retrieve_brands();

        if($all_brands->num_rows() > 0)
        {
            $brands = $all_brands->result();
            $brands_encoded = json_encode($brands);
            echo $brands_encoded;
        }

        else {
            echo "No brands found";
        }
    }
    public function get_brands_and_models()
    {
        $all_brands_and_models = $this->brands_model->get_all_brands_and_models();

        if($all_brands_and_models->num_rows() > 0)
        {
            $brands_and_models = $all_brands_and_models->result();
            $brands_and_models_encoded = json_encode($brands_and_models);
            echo $brands_and_models_encoded;
        }

        else {
            echo "No brands and models found";
        }
    }
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