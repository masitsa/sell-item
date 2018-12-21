<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller_card_model extends CI_Model
{
    function save_card($save_data) {
        if($this->db->insert("seller_card", $save_data)) {
            return true;
        } else {
            return false;
        }
    }
}