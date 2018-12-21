<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brands_model extends CI_Model
{
   //function to be called in brands
 /*public function retrieve_brands()
 {
    //$this->db->get("brand");
   //getting brands from database
    $query = $this->db->get("brand");
    return $query;
 }*/
 public function getmodelandname()
 {
   $getboth = $this->db->query("SELECT brand.brand_name, brand_model.brand_model_name from brand_model INNER JOIN brand ON brand.brand_id = brand_model.brand_id WHERE brand.brand_status=1 ");
   return $getboth;
 }
}
?>