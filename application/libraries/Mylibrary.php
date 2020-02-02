<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mylibrary
{
	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();
	}

	function menu()
	{
		$this->ci->load->view('layout/menu');
	}
	

}

/* End of file Mylibrary.php */
/* Location: ./application/libraries/Mylibrary.php */
