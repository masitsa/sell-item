<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cars_Model extends CI_Model
{
    function save_seller($save_data){
        if($this->db->insert("philip_car",$save_data)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
}