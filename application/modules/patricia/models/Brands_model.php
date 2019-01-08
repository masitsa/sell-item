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
    //retrieves brands and brands model
    public function retrieveMakeAndModel(){

        $result = $this->db->query("SELECT brand.brand_name, brand_model.brand_model_name from brand_model INNER JOIN brand ON brand.brand_id = brand_model.brand_id WHERE brand.brand_status=1");

        return $result;
    }
    //retrieve brands_name only
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
    //retrieve brand_model_id
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

    public function retrieveSoldCars()
    {
        // $this->db->select("brand_name, brand_image_name");
        $query = $this->db->get("patricia_sell");

        return $query;
    }
}
?>
   