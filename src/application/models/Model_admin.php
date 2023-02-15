<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Model_admin extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));") ;
	}
	public function get_data_pengguna(){
		$this->db->select('a.idpengguna, a.niplama, a.nama_pengguna, a.jabatan, b.user_group_name');
		$this->db->from('pengguna a');
		$this->db->join('user_group b','a.idgroup=b.user_group_id','inner');
		return $this->db->get();
	}
	public function get_user_grup(){
		$this->db->select('user_group_id, user_group_name');
		$this->db->where_not_in('user_group_name', array('Penyusun','Pengesah'));
		return $this->db->get('user_group');
	}
	public function get_data_id($column, $id_kategori, $table){
		$this->db->where($column, $id_kategori);
		return $this->db->get($table);
	}	
	public function total_record($table){
        $this->db->from($table);
        return $this->db->count_all_results();
    }
	public function max_id($column, $table){
		$this->db->select_max($column);
		return $this->db->get($table);
	}
	public function insert_data($data, $table){
		$this->db->insert($table, $data);
		return $this->db->affected_rows() > 0;
	}
	public function update_data($column, $value, $data, $table){
		$this->db->where($column, $value);
		$result = $this->db->update($table, $data);
		return ($result >= 1);
	}
	public function hapus_data($column, $value, $table){
		$this->db->where($column, $value);
		$this->db->delete($table);
		return $this->db->affected_rows() > 0;
	}	
}