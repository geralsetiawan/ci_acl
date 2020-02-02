<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->router->fetch_class().'_model', 'current_model');
		verify_login_status();
	}

	public function index()
	{
		if(!$this->general->privilege_check(auth_id_menu(),"read")) {
		    exit('No direct script access allowed');
		}
		$this->template->load(template(), $this->router->fetch_class().'/list');
	}

	public function record()
	{	
		validation_ajax_request();
		$datatables  = $_POST;
		$this->current_model->get($datatables);
		return;
	}

	public function create()
	{
		validation_ajax_request();
		$data['form_open'] = form_open_multipart($this->router->fetch_class().'/create_process', array('id' => 'form'));
		$this->load->view($this->router->fetch_class().'/form', $data);
	}

	public function create_process()
	{
		validation_ajax_request();
		$this->form_validation->set_rules('name', 'Name', 'required');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array('st'=>0, 
				'name' => form_error('name'), 
				));
		} else {
			$field = array(
					'name' => strtoupper($this->input->post('name')),
					);
				$this->current_model->insert($field);
		
			echo json_encode(array('st'=>1));
		}
	}

	function edit($id)
	{
		validation_ajax_request();
		$data['form_open'] = form_open_multipart($this->router->fetch_class().'/edit_process', array('id' => 'form'));
		$edit = $this->current_model->get_by_id($id)->row();
		$this->session->set_userdata('primary_key', $edit->id_category);
		$data ['callback'] ['name'] = $edit->name;
		$this->load->view($this->router->fetch_class().'/form', $data);
	}

	public function edit_process()
	{
		validation_ajax_request();
		$this->form_validation->set_rules('name', 'Name', 'required');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array('st'=>0, 
				'name' => form_error('name'),
				));
		} else {
			$field['name'] = strtoupper($this->input->post('name'));
			$this->current_model->update($this->session->userdata('primary_key'), $field);
			echo json_encode(array('st'=>1));
		}
	}
		
	public function delete($id)
	{
		$this->current_model->del($id);
		redirect($this->router->fetch_class(),'refresh');
	}

}

/* End of file Category.php */
/* Location: ./application/controllers/Category.php */