<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sellers_model extends CI_Model
{
   //function to be called in sellers control
function save_sellerdetails($save_data){
        if($this->db->insert("cecilia_seller", $save_data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
 
}
?>