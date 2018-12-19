<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brands_model extends CI_Model
{
   //function to be called in brands
 public function retrieve_brands()
 {
    //$this->db->get("brand");
   //getting brands from database
    $query = $this->db->get("brand");
    return $query;
 }
}
?>