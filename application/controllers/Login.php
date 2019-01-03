<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('Login_models');
	}
	function index(){
		redirect(base_url());
	}
	function login_process(){
		$uname = $this->input->post('username');
		$upass = $this->input->post('password');
		$where = array('user'=>$uname, 'pass'=>md5($upass));
		$check = $this->Login_models->login_check("user", $where)->num_rows();
		if ($check > 0) {
			$data_session = array('nama'=>$uname, 'status'=>"login");
			$this->session->set_userdata($data_session);
			redirect(base_url("admin"));
		}else {
			redirect(base_url());
		}
	}
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url("login"));
	}
}