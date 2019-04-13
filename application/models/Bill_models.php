<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Bill_models extends CI_Model{
	private $_table = 'pesanan';

	function update($kode){
		// $stok = $this->db->query('SELECT stok FROM barang WHERE id_barang = ?', $id);
		$this->db->where('kode_pesanan', $kode);
		$data = array(
			'status' => 'passed'
		);
		$this->db->update('pesanan', $data);
		return $this->db->affected_rows();
	}

	function save($data){
		$this->db->insert('pesanan_sukses', $data);
	}

	function delete($kode){
		$this->db->where('kode_pesanan', $kode);
		$this->db->delete($this->_table);
	}

	function check($kode){
		$this->db->having('kode_pesanan', $kode);
		$this->db->having('status', 'queue');
		return $this->db->get($this->_table);
	}

	function truncate(){
		$sql = $this->db->query("DELETE FROM log_barang");
		return $sql;

	}

	function getName($id){
		$this->db->where('id_user', $id);
		return $this->db->get('user');
	}

 }
