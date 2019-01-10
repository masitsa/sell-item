<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sells_model extends CI_Model
{
   function save_buy($save_data){
       if($this->db->insert("patricia_buy",$save_data)){
           return True;
       }else{
           return FALSE;
       }
   }     
    
}