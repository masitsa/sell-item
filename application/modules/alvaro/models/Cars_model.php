<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cars_model extends CI_Model
{
    function save_car($save_data)
    {
        if($this->db->insert("alvaro_car", $save_data)){
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
        $brand_name = "";

        if($query->num_rows() > 0)
        {
            $row = $query->row();
            $brand_name = $row->brand_name;
        }

        return $brand_name;
    }

    public function get_brand_model_name($brand_model_id)
    {
        $this->db->where("brand_model_id", $brand_model_id);
        $query = $this->db->get("brand_model");
        $brand_model_name = "";

        if($query->num_rows() > 0)
        {
            $row = $query->row();
            $brand_model_name = $row->brand_model_name;
        }

        return $brand_model_name;
    }
}