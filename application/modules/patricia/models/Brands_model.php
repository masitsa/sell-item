<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brands_model extends CI_Model
{
         public function retrieve_brands()
    {
         $this->db->select("brand_name, brand_image_name");
        $query = $this->db->get("brand");

        return $query;
    }

    //public function get_brand_models($brand_id)
    //{
        //$this->db->where("brand_id = ".$brand_id);
        //$query = $this->db->get("brand_model");

        //return $query;
   // }

   // public function get_all_brands_and_models()
   // {
        // $this->db->where("brand.brand_id = brand_model.brand_id");
        // $this->db->order_by("brand_name", "ASC");
        // $this->db->order_by("brand_model_name", "DESC");
       // $query = $this->db->get("brand, brand_model");

        //$this->db->join("brand_model", "brand.brand_id = brand_model.brand_id", "INNER");
        //$this->db->order_by("brand_name", "ASC");
        //$this->db->order_by("brand_model_name", "DESC");
        //$query = $this->db->get("brand");

      //  return $query;
    //}
    public function retrieveMakeAndModel(){

        $result = $this->db->query("SELECT brand.brand_name, brand_model.brand_model_name from brand_model INNER JOIN brand ON brand.brand_id = brand_model.brand_id WHERE brand.brand_status=1");
        return $result;
    }
    public function retrieve_cars()
    {
        // $this->db->select("brand_name, brand_image_name");
        $query = $this->db->get("patricia_sell");

        return $query;
    }
}
?>
   