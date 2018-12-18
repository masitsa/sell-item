<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getSchools extends MX_Controller {
	/**
	 * Constructor for this controller.
	 *
	 * Tasks:
	 * 		Checks for an active advertiser login session
	 *	- and -
	 * 		Loads models required
	 */
    function __construct() {
		parent:: __construct();
		$this->load->database(); // load database
		$this->load->model('Schools_model'); // load model 
		$this->load->helper('url');
		// Allow from any origin
		$this->load->library('grocery_CRUD');
    }

	function _example_output($output = null)
	{
		$this->load->view('example.php',$output);    
	}

	public function allSchools()
	{
		// $crud = new grocery_CRUD();
 
		// $crud->set_table('laikipia_schools');
		// $output = $crud->render();
		
		// $this->_example_output($output);

		try{
			$crud = new grocery_CRUD();

			// $crud->set_theme('datatables');
			$crud->set_table('laikipia_schools');
			$crud->set_subject('Schools');
			$crud->required_fields('*');
			$crud->columns('school_name', 'boys', 'girls', 'about', 'logo', 'latitude', 'longitude', 'name', 'phone', 'created');
			$crud->display_as('school_name','School');
			$crud->display_as('boys','Boys');
			$crud->display_as('girls','Girls');
			$crud->display_as('about','About');
			$crud->display_as('logo','Logo URL');
			$crud->display_as('latitude','Latitude');
			$crud->display_as('longitude','Longitude');
			$crud->display_as('name','Created By');
			$crud->display_as('phone','Phone');
			$crud->display_as('created','Created On');
			$crud->unset_add();
			$crud->unset_edit();

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	function offices()
	{
		$output = $this->grocery_crud->render();
		
		$this->_example_output($output);
	}
}