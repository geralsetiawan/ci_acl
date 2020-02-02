<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
	Class privilege ,generate all request linked to the access controll
----------------------------------------------------------------------*/

class General {

	private $obj = NULL;
    function General(){
		
		$this->obj= & get_instance();
	}
	
	function privilege_check($page_id, $do = null){
	
		$sql = "SELECT * FROM user a, user_role b , menu c
				WHERE 
					a.id_user_group = b.id_user_group
					AND b.id_menu = '%s' 
					AND c.id_menu = b.id_menu  
					AND b.%s = '1' 
					AND a.id_user_group = '%s'";
		$sqlf 	= sprintf($sql,	$page_id, $do,$this->obj->session->userdata('id_user_group')); 		
		$q 		= $this->obj->db->query($sqlf);
		if ($q->num_rows() > 0)
			return true;
		else 
			return false; 
	}
	
	public function no_access(){   
	    redirect('no_access');
	}	
}
