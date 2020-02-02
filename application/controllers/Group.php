<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {

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
					'description' => $this->input->post('description'),
					'created_date' => date('Y-m-d H:i:s')
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
		$this->session->set_userdata('primary_key', $edit->id_user_group);
		$data ['callback'] ['name'] = $edit->name;
		$data ['callback'] ['description'] = $edit->description;
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
			$field['description'] = $this->input->post('description');
			$field['updated_date'] = date('Y-m-d H:i:s');
			$this->current_model->update($this->session->userdata('primary_key'), $field);
			echo json_encode(array('st'=>1));
		}
	}
		
	public function delete($id)
	{
		$this->current_model->del($id);
		redirect($this->router->fetch_class(),'refresh');
	}

	public function get_group()
	{
		$datatables  = $_POST;
		$this->current_model->get_group($datatables);
		return;
	}

}

/* End of file Group.php */
/* Location: ./application/controllers/Group.php */