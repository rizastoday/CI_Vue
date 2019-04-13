<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_models extends CI_Model{

	public function load_barang(){
		$this->db->order_by('nama_barang', 'ASC');
		return $this->db->get('barang');
	}

	// public function load_baru(){
	// 	$this->db->order_by('tanggal', 'ASC');
	// 	return $this->db->get('barang')
	// }


	public function barang_baru(){
		$this->db->order_by('tanggal_masuk', 'DESC');
		return $this->db->get('barang_baru', '10');
	}

	public function load_notes(){
		$this->db->order_by('id', 'DESC');
		return $this->db->get('catatan', '1');
	}

	public function load_logs(){
		$this->db->order_by('tanggal', 'DESC');
		return $this->db->get('log_barang');
	}

	public function first_logs(){
		$this->db->order_by('tanggal', 'DESC');
		return $this->db->get('log_barang', '1');
	}

	public function sukses(){
		$this->db->select('NISN');
		$this->db->select('Nama');
		$this->db->select('token');
		$this->db->select('tanggal');
		$this->db->select('sum(total) as total');
		$this->db->group_by('Nama');
		$this->db->order_by('tanggal', 'DESC');
		return $this->db->get('pesanan_sukses');
	}

	public function detail($par){
		$this->db->where('kode_pesanan', $par);
		return $this->db->get('detail_pesanan');
	}

	public function token($id){
		$this->db->where('id_user', $id);
		return $this->db->get('pesanan');
	}
	
 }
