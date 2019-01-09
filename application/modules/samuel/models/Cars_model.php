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

    public function get_brand_name($samuel_car_id)
    {
        $this->db->where("samuel_car_id", $samuel_car_id);
        $query = $this->db->get("samuel_car");
        
        $brand = "";

        if($query->num_rows() > 0)
        {
            $row = $query->row();
            $brand = $row->brand_name;
        }

        return $brand;
    }
    public function get_brand_model($samuel_car_id)
    {
        $this->db->where("samuel_car_id", $samuel_car_id);
        $query = $this->db->get("samuel_car");
        $model = "";

        if($query->num_rows() > 0)
        {
            $row = $query->row();
            $model = $row->brand_model;
        }

        return $model;
    }
}