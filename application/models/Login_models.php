<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_models extends CI_Model{
	function login_check($table, $where){
		return $this->db->get_where($table, $where);
	}
	function check_user_identity($types){
		$u = 'SELECT type FROM user WHERE type = ?';
		return $this->db->query($u, array($types));

	}
}