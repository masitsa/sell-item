<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Action_cards extends CI_Model{

    function save_action_card($save_data){
        if ($this->db->insert("sarafina_car", $save_data)){
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

function save_Buyer ($save_data){
    if ($this->db->insert("sarafina_buyer", $save_data)){
        return TRUE;
    }
    else {
        return FALSE;
    }
}
}
?>