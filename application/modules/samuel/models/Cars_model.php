<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cars_model extends CI_Model
{
    function save_car($save_data)
    {
        if($this->db->insert("samuel_car", $save_data)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function get_brand_name($brand_id)
    {
        $this->db->where("brand_id", $brand_id);
        $query = $this->db->get("brand");
        $brand = "";

        if($query->num_rows() > 0)
        {
            $row = $query->row();
            $brand = $row->brand_name;
        }

        return $brand;
    }

    public function get_brand_model_name($brand_model_id)
    {
        $this->db->where("brand_model_id", $brand_model_id);
        $query = $this->db->get("brand_model");
        $model = "";

        if($query->num_rows() > 0)
        {
            $row = $query->row();
            $model = $row->brand_model_name;
        }

        return $model;
    }
}