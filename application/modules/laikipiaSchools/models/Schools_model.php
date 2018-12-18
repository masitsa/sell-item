<?php
class Schools_model extends CI_Model 
{
    function fetchschools()
    {
        $this->db->select('school_name, latitude, longitude, about,logo,boys,girls');
        $this->db->from('laikipia_schools');
        $query = $this->db->get();
        $ans = $query->result();
        echo (json_encode($ans));

        return $query->result();
    }
    function fetchAll()
    {
        $q = $this->db->get('laikipia_schools');;

        return($q->num_rows() > 0) ? $q->result_array() : FALSE;

   
    }
}
?>