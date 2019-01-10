<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions_model extends CI_Model
{
    function save_transaction($save_data){
        if($this->db->insert("moses_transaction", $save_data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    
    
}