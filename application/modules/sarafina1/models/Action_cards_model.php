<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Action_cards_model extends CI_Model{

    function save_action_card($save_data){
        if ($this->db->insert("sarafina_action_card", $save_data)){
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

}
?>