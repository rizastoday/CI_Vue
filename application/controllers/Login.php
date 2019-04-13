
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{

	public $_identity;
	public $_result = array(
		'type' => '',
		'error' => '',
		'message' => array(
			'uname' => '',
			'upass' => '',
			'utype' => ''
		)
	);
	private $_config = array(
		array(
			'field' => 'username',
			'label' => 'Nama Pengguna',
			'rules' => 'required|alpha_numeric|trim',
			'errors' => array(
				'required' 		=> 'Nama Pengguna Wajib Diisi!',
				'alpha_numeric'	=> 'Hanya diperbolehkan huruf dan angka!',
				'trim'			=> 'Tidak boleh ada spasi'
			)
		),
		array(
			'field' => 'password',
			'label' => 'Nama Pengguna',
			'rules' => 'required|trim',
			'errors' => array(
				'required' 		=> 'Password Wajib Diisi!',
				'trim'			=> 'Tidak boleh ada spasi'
			)
		),
		array(
			'field' => 'types',
			'label' => 'Nama Pengguna',
			'rules' => 'required',
			'errors' => array(
				'required' 		=> 'Jenis Pengguna wajib dipilih!'
			)
		),
	);

	function __construct(){
		parent::__construct();
		$this->load->model('Login_models');
	}
	function index(){
		redirect(base_url());
	}
	function login_process(){
		$this->form_validation->set_rules($this->_config);
		if($this->form_validation->run() == FALSE){
			$this->_result['error'] = TRUE;
			$this->_result['message'] = array(
				'username' => form_error('username'),
				'password' => form_error('password'),
				'types' => form_error('types')
			);
		}else{
			$uname = $this->input->post('username');
			$upass = $this->input->post('password');
			$utype = $this->input->post('types');
			$where = array('user'=>$uname, 'pass'=>md5($upass), 'type'=>$utype);
			$check = $this->Login_models->login_check("user", $where)->num_rows(); //account checking
			$type = $this->Login_models->check_user_identity($utype)->row_array(); //user check, admin or student
				if ($check > 0) {
					$this->_result['error'] = FALSE;
					if($type['type'] == 'admin'){
						$data_session = array('nama'=>$uname, 'status'=>"admin");
						$this->session->set_userdata($data_session);
						$this->_result['type'] = 'admin';
					}
					else if($type['type'] == 'student'){
						$data_session1 = array('nama'=>$uname, 'status'=>"student");
						$this->session->set_userdata($data_session1);
						$this->_result['type'] = 'siswa';
					}
				}else{
					$this->_result['error'] = TRUE;
					$this->_result['message'] = array(
						'no_account' => 'Akun tidak cocok'
					);
				}
		}
		echo json_encode($this->_result);
	}
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url("login"));
	}
}