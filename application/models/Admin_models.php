<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_models extends CI_Model{
	private $_table = 'barang';
	private $_catatan = 'catatan';

	function get_by_id($id){
		$this->db->from($this->_table);
		$this->db->where('kode',$id);
		$query = $this->db->get();

		return $query->row();
	}

	function save($data){
		$this->db->insert($this->_table, $data);
	}

	function delete($kode){
		$this->db->where('kode', $kode);
		$this->db->delete($this->_table);
	}
	function update($where, $data){
		$this->db->where('kode', $where);
		$this->db->update($this->_table, $data);
		return $this->db->affected_rows();
	}
	function saveCatatan($data){
		$this->db->insert($this->_catatan, $data);
	}
}