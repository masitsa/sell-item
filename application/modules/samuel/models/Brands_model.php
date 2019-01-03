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

    public function get_brands_and_models() {


        //  $this->db->select('brand.brand_name, brand.brand_status,
        // brand.brand_image_name,brand_model.brand_model_name,
        // brand_model.engine_code,brand_model.transmission_code,
        // brand_model.transmission_type,brand_model.drive_system_code,
        // brand_model.drive_system,brand_model.gears_no');
        // $this->db->from('brand')->join('brand_model', 'brand.brand_id = brand_model.brand_id');
        // $this->db->where('brand_status=1');

        $result = $this->db->query("select brand.brand_name, brand.brand_image_name,brand_model.engine_code, brand_model.brand_model_name, brand_model.transmission_type from `brand_model` 
        INNER JOIN `brand` ON brand.brand_id = brand_model.brand_id WHERE brand.brand_status=1");  
             

        return $result;
        }
        public function getPostedCars(){
            $result=$this->db->query("select brand.brand_name, brand.brand_model_name, brand.brand_image_name");
            return $result;
        }
}
?>