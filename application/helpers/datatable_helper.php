<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	function is_not_null($params) {
		$CI = get_instance();
		return ' WHERE '.$params.' IS NOT NULL ';
	}

	function search_like($field, $search) {
		return 'AND '.$field.' LIKE "%' . $search . '%" ';
	}

	function search_where($field, $search) {
		return 'AND '.$field.' = "' . $search . '" ';
	}

	function row_count($params) {
		$CI = get_instance();
		return count($CI->db->query($params)->result());
		//return 'AND '.$field.' = "' . $search . '" ';
	}

