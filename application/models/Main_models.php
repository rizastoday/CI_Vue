<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_models extends CI_Model{

	public function load_barang(){
		$this->db->order_by('nama_barang', 'ASC');
		return $this->db->get('barang');
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
 }
