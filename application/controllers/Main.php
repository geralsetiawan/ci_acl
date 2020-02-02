<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		//echo $this->session->userdata('id_user_group');
		$this->template->load('layout/base', $this->router->fetch_class().'/list');
		verify_login_status();
	}

}

/* End of file Main.php */
/* Location: ./application/controllers/Main.php */