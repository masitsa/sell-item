<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller_car_model extends CI_Model
{
    function save_card($save_data) {
        if($this->db->insert("martin_car", $save_data)) {
            return true;
        } else {
            return false;
        }
    }
}