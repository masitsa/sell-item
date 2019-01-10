<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers_Model extends CI_Model
{
    function save_customer($save_data){
        if($this->db->insert("philip_customer_detail",$save_data)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
}