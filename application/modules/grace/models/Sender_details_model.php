<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sender_details_model extends CI_Model
{
    public function save_checkins($save_data)
    {
      if ($this->db->insert("grace_sender_details", $save_data)){
          return TRUE;
      }
        else {
            return FALSE;
        }
    }
}