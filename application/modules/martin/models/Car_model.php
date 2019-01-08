<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Car_model extends CI_Model
{
    function save_card($save_data) {
        if($this->db->insert("martin_car", $save_data)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_brand_name() {
        $this->db->where("brand_id", $brand_id);
        $query = $this->db->get("brand");
        $brand_name = "";

        if($query->num_rows() > 0) {
            $row = $query->row();
            $brand_name = $row->brand_name;
        }
        return $brand_name;
    }

    public function get_brand_model_name($brand_model_id) {
        $this->db->where("brand_model_id", $brand_model_id);
        $query = $this->get("brand_model");
        $brand_model_name = "";

        if($query->num->rows() > 0) {
            $row = $query->row();
            $brand_model_name = $row->brand_model_name;
        }
        return $brand_model_name;
    }
}