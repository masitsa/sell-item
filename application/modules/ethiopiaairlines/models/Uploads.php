<?php
class Uploads extends CI_Model{
    public function upload_xml($upload_path)
	{
		$response = $this->upload_xml_file($upload_path, 'xmlfile');
		
		if($response['check'])
		{
			$file_name = $response['file_name'];
			
			return $file_name;
		}
		
		else
		{
			$this->session->set_userdata('error_message', $response['error']);
			return FALSE;
		}
    }
    
    public function upload_xml_file($upload_path, $field_name)
	{
		$config = array(
				'allowed_types' => '*',
				'upload_path' => $upload_path,
				'file_name' => md5(date('Y-m-d H:i:s'))
			);
			
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload($field_name))
		{
			// if upload fail, grab error
			$upload_data = $this->upload->data();
			$response['check'] = FALSE;
			$response['error'] =  $this->upload->display_errors().'<br/>'.$upload_data['file_ext'].'<br/>'.$upload_data['file_path'];
		}
		
		else
		{
			$file_upload_data = $this->upload->data();
			$file_name = $file_upload_data['file_name'];
			
			$response['check'] = TRUE;
			$response['file_name'] =  $file_name;
		}
		$upload_data = $this->upload->data();
		$file_name = $upload_data['file_name'];
		
        unset($_FILES[$field_name]);
		return $response;
	}
}