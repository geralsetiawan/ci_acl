<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->router->fetch_class().'_model', 'current_model');
	}

	public function index()
	{
		
		$data['form_open'] = form_open_multipart($this->router->fetch_class().'/auth', array('id' => 'form'));
		$this->load->view($this->router->fetch_class().'/form', $data);
	}

	public function auth()
	{
		validation_ajax_request();
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array('st'=>0, 
				'username' => form_error('username'),
				'password' => form_error('password'),
				));
		} else {
			$check = $this->current_model->auth($username, $password);
			if($check->num_rows() > 0) {
				$row = $check->row_array();
				if (strpos($row['id_user_group'], ',') !== false) {
					$array = array(
								'id_user' => $row['id_user']
								);
					$this->session->set_userdata($array);
				    echo json_encode(array('st'=>3, 'id' => $row['id_user_group']));
				} else {
					$array = array( 'logged_in' => 1,
								'id_user_group' => $row['id_user_group'],
								'id_user' => $row['id_user']
								);
					$this->session->set_userdata($array);
					echo json_encode(array('st'=>1));
				}
			} else {
				echo json_encode(array('st'=>2, 
					'error' => 'Username and password do not match ',
					));
			}
		}
		
	}

	public function check_role()
	{
		validation_ajax_request();
		$id = $this->input->post('id');
		$data['group'] = $this->db->query("SELECT * from user_group WHERE id_user_group IN(".$id.")")->result_array();
		$this->load->view($this->router->fetch_class().'/check_role', $data);
	}

	public function select_group($id = NULL) {
		if(empty($this->session->userdata('id_user'))) {
			exit('No direct script access allowed');
		}
		$array = array( 'logged_in' => 1,
								'id_user_group' => $id,
								'id_user' => $this->session->userdata('id_user')
								);
		$this->session->set_userdata($array);
		redirect('main');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect($this->router->fetch_class());
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */