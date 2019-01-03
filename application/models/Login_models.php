<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_models extends CI_Model{
	function login_check($table, $where){
		return $this->db->get_where($table, $where);
	}
}