<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

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

	public function update()
	{	
		validation_ajax_request();
		$checked = $this->input->post('checked');
		$name = $this->input->post('name');
		$id_menu = $this->input->post('id_menu');
		$id_user_group = $this->input->post('id_user_group');
		$where['id_menu'] = $id_menu;
		$where['id_user_group'] = $id_user_group;
		$role = $this->db->get_where('user_role', $where)->num_rows();
		if($role > 0){
			$val[$name] = $checked;
			$this->db->update('user_role', $val, $where);
		} else {
			$val['id_user_group'] = $id_user_group;
			$val['id_menu'] = $id_menu;
			$val[$name] = $checked;
			$this->db->insert('user_role', $val);
		}
		echo json_encode(array('st' => 1));
	}

}

/* End of file Role.php */
/* Location: ./application/controllers/Role.php */