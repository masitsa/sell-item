<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cars_Model extends CI_Model
{
    function save_seller($save_data){
        if($this->db->insert("philip_car",$save_data)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    public function get_brand_name($sender_id)
    {
        $this->db->where("sender_id", $sender_id);
        $query = $this->db->get("philip_car");
        
        $brand_name = "";

        if($query->num_rows() > 0)
        {
            $row = $query->row();
            $brand_name = $row->brand_name;
        }

        return $brand_name;
    }
    public function get_brand_model($sender_id)
    {
        $this->db->where("sender_id", $sender_id);
        $query = $this->db->get("brand_model");
        $brand_model = "";

        if($query->num_rows() > 0)
        {
            $row = $query->row();
            $brand_model = $row->brand_model;
        }

        return $brand_model;
    }
}