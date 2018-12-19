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
       
        $this->db->select('*');
        $this->db->from('brand');
        $this->db->join('brand_model', 'brand.brand_id = brand_model.brand_id', 'inner');
        $this->db->where('brand_status=1');
        $query = $this->db->get("brand_name");

        return $query;
        
       
    }
}