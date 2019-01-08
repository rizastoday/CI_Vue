<?php 
class Admin extends CI_Controller {

	public $photos;
	private $_config = array(
		array(
			'field' => 'kode',
			'label' => 'Kode Barang',
			'rules' => 'required|alpha_numeric|trim',
			'errors' => array(
				'required' 				=> 'Kode wajib diisi',
				'alpha_numeric'			=> 'Tidak boleh mengandung karakter khusus (termasuk space)',
				'trim'					=>	'Tidak boleh ada spasi',
			)
		),
		array(
			'field' => 'nama_barang',
			'label' => 'Nama Barang',
			'rules' => 'required|alpha_numeric_spaces',
			'errors' => array(
				'required' 				=> 'Nama barang wajib diisi',
				'alpha_numeric_spaces'	=> 'Tidak boleh mengandung karakter khusus'
			)
		),
		array(
			'field' => 'harga',
			'label' => 'Harga',
			'rules' => 'trim|required|numeric|greater_than_equal_to[0]|min_length[3]',
			'errors' => array(
				'trim'						=>	'Tidak boleh ada spasi',
				'required'					=>	'Form Harga harus diisi',
				'numeric'					=>	'Harga hanya boleh angka',
				'greater_than_equal_to'		=>	'Nilai tidak boleh kurang dari 0',
				'min_length'			=>	'Nilai harus lebih dari 3 digit'
			)
		),
		array(
			'field' => 'stok',
			'label' => 'Stok',
			'rules' => 'trim|required|numeric|greater_than_equal_to[0]|min_length[2]',
			'errors' => array(
				'trim'						=>	'Tidak boleh ada spasi',
				'required'					=>	'Form stok harus diisi',
				'numeric'					=>	'Stok hanya boleh angka',
				'greater_than_equal_to'		=>	'Nilai tidak boleh kurang dari 0',
				'min_length'				=>	'Setidaknya harus lebih dari 10'
			)
		)
	);
	private $_notes = array(
		array(
			'field' => 'message',
			'label' => 'Catatan',
			'rules' => 'required',
			'errors' => array(
				'required' => '**Form Catatan tidak boleh dikirim dalam keadaan kosong!'
			)
		)
	);

	function __construct(){
		parent::__construct();
		$this->load->model('Admin_models');

		if ($this->session->userdata('status') != "login") {
			redirect(base_url(login));
		}
	}

	function index(){
		$this->load->view('Admin/index');
	}

	public function business_center_save_models(){

		// var_dump($_FILES['photo']['name']);
		if($_FILES['photo']['name']){
			$upload = $this->_do_upload();
			$this->photos = $upload;
		}

		$this->form_validation->set_rules($this->_config);
			if($this->form_validation->run() == FALSE){
				$res['error'] = TRUE;
				$res['msg'] = array(
					'kode'=>form_error('kode'),
					'nama_barang'=>form_error('nama_barang'),
					'harga'=>form_error('harga'),
					'stok'=>form_error('stok'),
					'photo' => $this->photos
				);
			}else {
				$res['error'] = FALSE;
				$data = array(
					'kode' => $this->input->post('kode'),
					'nama_barang' => $this->input->post('nama_barang'),
					'harga' => $this->input->post('harga'),
					'stok' => $this->input->post('stok'),
					'photo' => $this->photos
				);

				$this->Admin_models->save($data);
			}

			echo json_encode($res);
	}
	public function business_center_delete_models($kode){
		// $crud = $this->Admin_models->get_by_id($kode);
		$this->Admin_models->delete($kode);
	}
	public function business_center_update_models(){
		$this->form_validation->set_rules($this->_config);
		if($this->form_validation->run() == FALSE){
			$res['error'] = TRUE;
			$res['msg'] = array(
				'kode'=>form_error('kode'),
				'nama_barang'=>form_error('nama_barang'),
				'harga'=>form_error('harga'),
				'stok'=>form_error('stok')
			);
		}else{
			$kode = $this->input->post('kode');
			$data = array(
				'kode' => $this->input->post('kode'),
				'nama_barang' => $this->input->post('nama_barang'),
				'harga' => $this->input->post('harga'),
				'stok' => $this->input->post('stok')
			);
			
			$this->Admin_models->update($kode, $data);
		}

			echo json_encode($res);
	}
	public function business_center_save_notes_models(){
		$this->form_validation->set_rules($this->_notes);
		if($this->form_validation->run() == FALSE){
			$res['error'] = TRUE;
			$res['msg'] = array(
				'message' => form_error('message')
			);
		}else {
			$res['error'] = FALSE;
			$data = array(
				'catatan' => $this->input->post('message')
			);
			$this->Admin_models->saveCatatan($data);
		}
		echo json_encode($res);
	}
	public function _do_upload(){
		$config['upload_path']			= './upload/';
		$config['allowed_types']		= '*';
		$config['max_size']				= 200;
		$config['max_width']			= 1024;
		$config['max_height']			= 768;
		$config['file_name']			= uniqid(rand()).date('mdYhis', time());

		$this->load->library('upload', $config);


        if(!$this->upload->do_upload('photo')){

			return $this->upload->display_errors();

		}else{
			return $this->upload->data('file_name');
		}
	}
}
