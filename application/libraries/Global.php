<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Global
{
	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();
	}

	function menu()
	{
       	echo 1;
	}

	

}

/* End of file Global.php */
/* Location: ./application/libraries/Global.php */
