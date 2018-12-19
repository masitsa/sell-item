<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrations_model extends CI_Model
{
    function save_registration($save_data){
        if($this->db->insert("samuel_registration",
        $save_data)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
}