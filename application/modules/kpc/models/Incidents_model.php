<?php
class Advertiser_model extends CI_Model 
{
    function create_advertiser()
    {
        $data = array
        (
            "advertiser_name" => $this->input->post('name'),
            "advertiser_email" => $this->input->post('email'),
            "advertiser_phone" => $this->input->post('phone'),
            "advertiser_password" => md5($this->input->post('password')),
            "advertiser_is_company" => $this->input->post('is_company'),
        );
		$is_company = $this->input->post("is_company");
		if($is_company == 1)
		{
			$data["advertiser_company_name"] = $this->input->post('company_name');
			$data["advertiser_company_phone"] = $this->input->post('company_phone');
			$data["advertiser_company_email"] = $this->input->post('company_email');
			$data["advertiser_company_location"] = $this->input->post('company_location');
			$data["advertiser_company_kra_pin"] = $this->input->post('company_kra_pin');
        }
        
        if($this->db->insert("advertiser", $data))
        {
            return TRUE;
        }

        else
        {
            return FALSE;
        }
    }

    function login_advertiser()
    {
        $data = array
        (
            "advertiser_email" => $this->input->post('email'),
            "advertiser_password" => md5($this->input->post('password')),
        );
        
        $this->db->where($data);
        $advertiser = $this->db->get("advertiser");

        if($advertiser->num_rows())
        {
            $this->set_advertiser_login($advertiser);
            return TRUE;
        }

        else
        {
            return FALSE;
        }
    }

    public function set_advertiser_login($advertiser)
    {
        $row = $advertiser->row();
        $advertiser_id = $row->advertiser_id;
        $advertiser_name = $row->advertiser_name;
        
        $newdata = array(
            'advertiser_id'  => $row->advertiser_id,
            'advertiser_name'     => $row->advertiser_name,
            'advertiser_login_status' => TRUE
        );
        
        $this->session->set_userdata($newdata);
    }
}