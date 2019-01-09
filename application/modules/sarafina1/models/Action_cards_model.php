<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Action_Cards_Model extends CI_Model{


    

    function save_action_card($data){
        if ($this->db->insert("sarafina_action_card", $data)){
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

// function save_Buyer ($save_data){
//     if ($this->db->insert("sarafina_buyer", $save_data)){
//         return TRUE;
//     }
//     else {
//         return FALSE;
//     }
// }
   

}
?>