<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
		$result = $this->db->get('user_group')->result_array();
		$data['option_group'][''] = '-- SELECT --';
		foreach($result as $row) {
			$data['option_group'][$row['id_user_group']] = $row['name'];
		}
		$this->template->load(template(), $this->router->fetch_class().'/list', $data);
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
		$data['group'] = $this->db->get('user_group')->result_array();
		$data['type'] = 'create';
		$this->load->view($this->router->fetch_class().'/form', $data);
	}

	public function create_process()
	{
		validation_ajax_request();
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
		$this->form_validation->set_rules('conf_password', 'Confirm password', 'required|matches[password]');
		if(empty($this->input->post('id_user_group'))) {
			$error = 'The Group is required';
		} else {
			$error = '';
		}
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array('st'=>0, 
				'name' => form_error('name'), 
				'id_user_group' => form_error('id_user_group'),
				'username' => form_error('username'), 
				'password' => form_error('password'),
				'conf_password' => form_error('conf_password'),
				'id_user_group' => $error
				));
		} else {
			$arr = array();
			foreach($this->input->post('id_user_group') as $row) {
				$arr[] = $row;
			}
			$id_user_group = implode (",", $arr);
			$field = array(
					'name' => strtoupper($this->input->post('name')),
					'id_user_group' => $id_user_group,
					'username' => $this->input->post('username'),
					'password' => md5($this->input->post('password')),
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
		$data['group'] = $this->db->get('user_group')->result_array();
		$edit = $this->current_model->get_by_id($id)->row();
		$this->session->set_userdata('primary_key', $edit->id_user);
		$arr['id_user_group'] = $edit->id_user_group;
		$group = get_lookup_table('user_group', $arr, 'name');
		$data ['callback'] ['group_name'] = $group;
		$data ['callback'] ['id_user_group'] = $edit->id_user_group;
		$data ['callback'] ['name'] = $edit->name;
		$data ['callback'] ['username'] = $edit->username;
		$data ['callback'] ['password'] = $edit->password;
		$data['type'] = 'edit';
		$this->load->view($this->router->fetch_class().'/form', $data);
	}

	function detail($id)
	{
		validation_ajax_request();
		$data['form_open'] = form_open_multipart($this->router->fetch_class().'/edit_process', array('id' => 'form'));
		$data['group'] = $this->db->get('user_group')->result_array();
		$edit = $this->current_model->get_by_id($id)->row();
		$this->session->set_userdata('primary_key', $edit->id_user);
		$arr['id_user_group'] = $edit->id_user_group;
		$group = get_lookup_table('user_group', $arr, 'name');
		$data ['callback'] ['group_name'] = $group;
		$data ['callback'] ['id_user_group'] = $edit->id_user_group;
		$data ['callback'] ['name'] = $edit->name;
		$data ['callback'] ['username'] = $edit->username;
		$data ['callback'] ['password'] = $edit->password;
		$data['type'] = 'detail';
		$this->load->view($this->router->fetch_class().'/form', $data);
	}

	public function edit_process()
	{
		validation_ajax_request();
		$this->form_validation->set_rules('name', 'Name', 'required');
		if(empty($this->input->post('id_user_group'))) {
			$error = 'The Group is required';
		} else {
			$error = '';
		}
		$this->form_validation->set_rules('username', 'username', 'required');
		if(!empty($this->input->post('status_password'))) {
			$this->form_validation->set_rules('password', 'password', 'required');
			$this->form_validation->set_rules('conf_password', 'Confirm password', 'required|matches[password]');
		}
		
	
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array('st'=>0, 
				'name' => form_error('name'), 
				'id_user_group' => $error,
				'username' => form_error('username'), 
				'password' => form_error('password'),
				'conf_password' => form_error('conf_password')
				));
		} else {
			$arr = array();
			foreach($this->input->post('id_user_group') as $row) {
				$arr[] = $row;
			}
			$id_user_group = implode (",", $arr);
			$field['name'] = strtoupper($this->input->post('name'));
			$field['id_user_group'] = $id_user_group;
			$field['username'] = $this->input->post('username');
			if(!empty($this->input->post('status_password'))) {
				$field['password'] = md5($this->input->post('password'));
			}
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

/* End of file User.php */
/* Location: ./application/controllers/User.php */