<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkins_model extends CI_Model
{
    function save_checkin($save_data)
    {
        if($this->db->insert("alvaro_checkin", $save_data)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
}