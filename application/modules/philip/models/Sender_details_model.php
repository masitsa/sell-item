<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sender_Details_Model extends CI_Model
{
    function save_seller($save_data){
        if($this->db->insert("philip_sender_detail",$save_data)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
}
?>