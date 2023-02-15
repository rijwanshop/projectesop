<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_master extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));") ;
	}
	private function query_daftar_singkatan($column_search, $column_order, $order){
		$this->db->from('m_singkatan_unit');
		
		$i = 0;
		foreach ($column_search as $emp){	
			if(isset($_POST['search']['value']) && !empty($_POST['search']['value'])){
				$_POST['search']['value'] = $_POST['search']['value'];
			}else{
				$_POST['search']['value'] = '';
			}
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like(($emp), $_POST['search']['value']);
				}else{
					$this->db->or_like(($emp), $_POST['search']['value']);
				}
				if(count($column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		
		if(isset($_POST['order'])){
			$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}else{
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	public function get_daftar_singkatan($column_search, $column_order, $order){
		$this->query_daftar_singkatan($column_search, $column_order, $order);
		if(isset($_POST['length']) && $_POST['length'] < 1) {
			$_POST['length']= '10';
		}else{
			$_POST['length']= $_POST['length'];
		}
		if(isset($_POST['start']) && $_POST['start'] > 1) {
			$_POST['start']= $_POST['start'];
		}
        $this->db->limit($_POST['length'], $_POST['start']);	
        $query = $this->db->get();
        return $query->result();
	}
	public function jumlah_filter_daftar_singkatan($column_search, $column_order, $order){
		$this->query_daftar_singkatan($column_search, $column_order, $order);
		return $this->db->get()->num_rows();
	}
	public function total_record($table){
        $this->db->from($table);
        return $this->db->count_all_results();
    }
	public function max_id($column, $table){
		$this->db->select_max($column);
		return $this->db->get($table);
	}
	public function get_next_auto_increment($table){
		return $this->db->query("SHOW TABLE STATUS WHERE name='$table'")->row()->Auto_increment;
	}
	public function nomor_urut($unitkerjaid){
		$this->db->where('unit_kerja_id', $this->db->escape_like_str($unitkerjaid));
		$this->db->order_by('sop_nourut', 'desc');
		$this->db->limit(1);
		return $this->db->get('vwsop');
	}
	public function get_data_id($column, $id_kategori, $table){
		$this->db->where($column, $id_kategori);
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
	public function validasi_singkatan_update($id, $singkatan){
		$this->db->where('singkatan', $singkatan);
		$this->db->where('idsingkatan !=', $id);
		return $this->db->get('m_singkatan_unit')->num_rows();
	}
	public function hapus_singkatan(){
		$this->db->where('id_unit','');
		$this->db->where('id_biro !=','');
		$this->db->delete('m_singkatan_unit');
		return $this->db->affected_rows() > 0;
	}
}