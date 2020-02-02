<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
	function active_class_link($controller) {
		$CI = get_instance();
		$class = $CI->router->fetch_class();
		$style = "active";
		return ($class == $controller) ? $style : '';
	}

	function active_display_block($controller) {
		$CI = get_instance();
		$class = $CI->router->fetch_class();
		$stylex = "style='display: block;'";
		return ($class == $controller) ? $stylex : '';
	}

	function get_identity_user($field) {
		$CI = get_instance();
		$where['id_user'] = $CI->session->userdata('id_user');
		$row = $CI->db->get_where('user', $where)->row_array();
		return strtoupper($row[$field]);
	}

	function auth_id_menu() {
		$CI =& get_instance();
		$row = $CI->db->get_where('menu', array('url' => $CI->uri->segment(1)))->row_array();
		return $row['id_menu'];
	}


	function get_identity_group($field) {
		$CI = get_instance();
		$where['id_user_group'] = $CI->session->userdata('id_user_group');
		$row = $CI->db->get_where('user_group', $where)->row_array();
		return strtoupper($row[$field]);
	}

	function menu() {
		$CI = get_instance();
		return $CI->load->view('layout/menu');
	}

	function template() {
		return 'layout/base';
	}

	function page_title() {
		$CI = get_instance();
		$title = ucwords($CI->router->fetch_class());
		return $title;
	}

	function debug($params) {
		die(print_r($params, TRUE));
	}

	function get_lookup_table($table, $arr = array(), $name) {
		$CI =& get_instance();
		$row = $CI->db->get_where($table, $arr)->row_array();
		return $row[$name];
	}

	function verify_login_status(){
		$CI = get_instance();
		if($CI->session->userdata('logged_in') == FALSE) {
			$CI->session->set_flashdata('msg','You must login first');
			redirect('login');
		}
	}

	function validation_ajax_request() {
		$CI = get_instance();
		if (!$CI->input->is_ajax_request()) {
   			exit('No direct script access allowed');
		}
	}