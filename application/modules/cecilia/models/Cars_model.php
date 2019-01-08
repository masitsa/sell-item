<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cars_model extends CI_Model
{
    //FUNCTION SAVES DETAILS
   //function to be called in cars control
function save_cardetails($save_data){
        if($this->db->insert("cecilia_car", $save_data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
 
}
?>