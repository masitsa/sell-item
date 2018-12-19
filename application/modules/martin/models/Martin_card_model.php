<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Martin_card_model extends CI_Model
{
    function save_card($save_data) {
        if($this->db->insert("Martin_card", $save_data)) {
            return true;
        } else {
            return false;
        }
    }
}