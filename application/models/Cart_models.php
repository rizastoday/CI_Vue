<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_models extends CI_Model{

	public function get_barang(){
		$this->db->order_by('nama_barang', 'ASC');
		return $this->db->get('barang');
	}

	public function check_id($table, $where){
		return $this->db->get_where($table, $where);
	}

	public function insert_bill($data){
		$q = $this->db->query('INSERT INTO pesanan VALUES ' . implode(',', $data));
		return $q;
	}
	public function get_bill(){
		$this->db->where('status', 'queue');
		return $this->db->get('pesanan');
	}
 }
