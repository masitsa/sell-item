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

    public function retrieve_brands_and_models() {

        $result = $this->db->query("select brand.brand_name, brand_model.brand_model_name, brand_model.transmission_type from `brand_model` 
        INNER JOIN `brand` ON brand.brand_id = brand_model.brand_id WHERE brand.brand_status=1");  
             

        return $result;

        }

        public function retrieve_cars()
    {
        // $this->db->select("brand_name, brand_image_name");
        $query = $this->db->get("philip_sender_detail");

        return $query;
    }
}
?>