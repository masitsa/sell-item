<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brands_model extends CI_Model
{
    public function retrieve_brands()
    {
        // $this->db->select("brand_name, brand_image_name");
        $query = $this->db->get("brand");

        return $query;
    }

    public function get_brand_models($brand_id)
    {
        $this->db->where("brand_id = ".$brand_id);
        $query = $this->db->get("brand_model");

        return $query;
    }

    public function get_all_brands_and_models()
    {
        // $this->db->where("brand.brand_id = brand_model.brand_id");
        // $this->db->order_by("brand_name", "ASC");
        // $this->db->order_by("brand_model_name", "DESC");
        // $query = $this->db->get("brand, brand_model");

        // $this->db->join("brand_model", "brand.brand_id = brand_model.brand_id", "INNER");
        // $this->db->order_by("brand_name", "ASC");
        // $query = $this->db->get("brand");
        // $this->db->select('*');
        // $this->db->from('brand_model');
        // $query = $this->db->get();

        // return $query;

       
        $this->db->select('brand.brand_name, brand.brand_status,
        brand.brand_image_name,brand_model.brand_model_name,
        brand_model.engine_code,brand_model.transmission_code,
        brand_model.transmission_type,brand_model.drive_system_code,
        brand_model.drive_system,brand_model.gears_no');
        $this->db->from('brand')->join('brand_model', 'brand.brand_id = brand_model.brand_id');
        $this->db->where('brand_status=1');
       
        $query = $this->db->get();

        return $query;
        
       
    }
    public function get_Cars()
    {
       $query = $this->db->get("sarafina_action_card");

        return $query;
    }
    
}