<?php 
class Admin extends CI_Controller {

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
		$this->form_validation->set_rules($this->_config);
			if($this->form_validation->run() == FALSE){
				$res['error'] = TRUE;
				$res['msg'] = array(
					'kode'=>form_error('kode'),
					'nama_barang'=>form_error('nama_barang'),
					'harga'=>form_error('harga'),
					'stok'=>form_error('stok')
				);
			}else {
				$res['error'] = FALSE;
				$data = array(
					'kode' => $this->input->post('kode'),
					'nama_barang' => $this->input->post('nama_barang'),
					'harga' => $this->input->post('harga'),
					'stok' => $this->input->post('stok')
				);

				// if(!empty($_FILES['photo']['name'])){
				// 	$upload = $this->_do_upload();
				// 	$data['photo'] = $upload;
				// }

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
		$conf['upload_path']		= 'upload/';
		$conf['allowed_types']		= '*';
		$conf['max_size']			= 1200;
		$conf['max_width']			= 1000;
		$conf['max_height']			= 1000;
		$conf['file_name']			= round(microtime(true) * 1000);

		$this->load->library('upload', $conf);


        if(!$this->upload->do_upload('photo'))
        {
			$res['msg'] = array('error_upload' => $this->upload->display_errors('',''));
			$res['error'] = TRUE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}
}
