<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cars_model extends CI_Model
{
    function save_car($save_data){
        if($this->db->insert("moses_car", $save_data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
}