<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    function auth($username, $password) {
        $where['username'] = $username;
        $where['password'] = $password;
        return $this->db->get_where('user', $where);
    }

}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */