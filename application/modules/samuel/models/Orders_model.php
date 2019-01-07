<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model
{
    function save_order($save_data){
        if($this->db->insert("car_orders",
        $save_data)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
}