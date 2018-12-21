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
            header('Access-Control-Max-Age: 86400'); // cache for 1 day
        }
    
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
            exit(0);
        }
        $this->load->model("brands_model");
}
//function to load the brands
public function get_brands(){
    //call function from brands model 
    $get_all = $this->brands_model->getmodelandname();
    if ($get_all->num_rows()> 0) {
        $all_brands = $get_all->result();
        $encoded_brands = json_encode($all_brands);
        echo $encoded_brands;
        
    }
}
}
?>