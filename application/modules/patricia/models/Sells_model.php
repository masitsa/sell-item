<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sells_model extends CI_Model
{
   function save_sell($save_data){
       if($this->db->insert("patricia_sell",$save_data)){
           return True;
       }else{
           return FALSE;
       }
   }     
    
}