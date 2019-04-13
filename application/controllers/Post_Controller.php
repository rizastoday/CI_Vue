<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_Controller extends CI_Controller{

	public $photos;
	private $_post = array();
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
	private $where;
	private $tanggal;

	function __construct(){
		parent::__construct();
		$this->load->model('Admin_models');
		$this->load->model('Bill_models', 'bill');

		if ($this->session->userdata('status') != "admin") {
			redirect(base_url(login));
		}
	}


	public function business_center_save_models(){

		// var_dump($_FILES['photo']['name']);
		if(is_null(isset($_FILES['photo']['name']))){
			$this->photos = 'Harap pilih foto';
		}else{
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
		$crud = $this->Admin_models->get_by_id($kode);
		if (file_exists('./upload/'.$crud->photo) && $crud->photo) {
			unlink('./upload/'.$crud->photo);
		}
		$this->Admin_models->delete($kode);
	}
	public function business_center_update_models(){

		if($this->input->post('remove')){ //jika ceklis hapus di pilih, file lama dihapus
			if(file_exists('./upload/' . $this->input->post('cur_photo')) && $this->input->post('remove')){
				unlink('./upload/'.$this->input->post('cur_photo'));
			}
				if(is_null(isset($_FILES['photo']['name']))){ //upload file baru
					$this->photos = 'Harap pilih foto';
				}else{
					$upload = $this->_do_upload();
					$this->photos = $upload; //diambil dari nilai return fungsi
				}
		}else{

			$this->photos = $this->input->post('cur_photo'); //jika tidak, biarkan file lama
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
		}else{
			$res['error'] = FALSE;
			$kode = $this->input->post('kode');
			$data = array(
				'kode' => $this->input->post('kode'),
				'nama_barang' => $this->input->post('nama_barang'),
				'harga' => $this->input->post('harga'),
				'stok' => $this->input->post('stok'),
				'photo' => $this->photos
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
		$config['file_name']			= uniqid(rand()).date('mdYhis', time());

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
        if(!$this->upload->do_upload('photo')){
			return $this->upload->display_errors();
		}else{
			$img = $this->upload->data();

            $config['image_library']='gd2';
            $config['source_image']='./upload/'.$img['file_name'];
            $config['create_thumb']= FALSE;
            $config['maintain_ratio']= FALSE;
            $config['quality']= '75%';
            $config['width']= 640;
            $config['height']= 480;
            $config['new_image']= './upload/'.$img['file_name'];

            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
			return $this->upload->data('file_name'); //me-return nama file dan di callback ke methods
		}
	}

	public function business_center_save_bill_models(){

		$getName = $this->bill->getName($this->input->post('id'))->row_array();
		$name = $getName['user'];
		$data = array(
			'NISN' => $this->input->post('id'),
			'Nama' => $name,
			'token' => $this->input->post('kode'),
			'tanggal' => $this->input->post('tanggal'),
			'total' => $this->input->post('total')
		);

		$this->bill->update($this->input->post('kode'));
		$this->bill->save($data);
		$res['error'] = FALSE;

		echo json_encode($res);
	}

	public function business_center_truncate_log(){
		if($this->input->post('delete')){
			$this->bill->truncate();
			$res["error"] = FALSE;
		}else{
			$res["error"] = TRUE;
		}
		echo json_encode($res);
	}

}
