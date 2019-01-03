<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buyers_model extends CI_Model
{
    //FUNCTION SAVES DETAILS
   //function to be called in sellers control
function save_buyerdetails($save_data){
        if($this->db->insert("cecilia_buyer", $save_data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
 
}
?>