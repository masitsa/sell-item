<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Action_Cards_Model extends CI_Model{

    function save_action_card($save_data){
        if ($this->db->insert("sarafina_action_card", $save_data)){
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    public function retrieveSoldCars()
    {
        // $this->db->select("brand_name, brand_image_name");
        $query = $this->db->get("sarafina_action_card");

        return $query;
    }
}
?>