<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Model_notifikasi extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));") ;
	}
	private function query_daftar_notifikasi($column_search, $column_order, $order){
		$this->db->from('notifikasi');

		$nip = $this->session->userdata('pegawainip');
		$grup = $this->session->userdata('groupid');

		if(in_array($grup, array(1,11))){
			$this->db->where_in('nip_penerima', array('admin', $nip));
		}else if($grup == 12){
			$this->db->where_in('nip_penerima', array('sub admin', $nip));
		}else{
			$this->db->where('nip_penerima', $nip);
		}

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
	public function get_daftar_notifikasi($column_search, $column_order, $order){
		$this->query_daftar_notifikasi($column_search, $column_order, $order);
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
	public function jumlah_filter_notifikasi($column_search, $column_order, $order){
		$this->query_daftar_notifikasi($column_search, $column_order, $order);
		return $this->db->get()->num_rows();
	}

	private function query_daftar_notif_admin($column_search, $column_order, $order){
		$this->db->from('notifikasi');

		$nama = trim($this->input->post('nama', true));
		if($nama != '')
			$this->db->like('nama_penerima', $nama);

		$nip = trim($this->input->post('nip', true));
		if($nip != '')
			$this->db->like('nip_penerima', $nip);

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
	public function get_daftar_notifikasi_admin($column_search, $column_order, $order){
		$this->query_daftar_notif_admin($column_search, $column_order, $order);
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
	public function jumlah_filter_notifikasi_admin($column_search, $column_order, $order){
		$this->query_daftar_notif_admin($column_search, $column_order, $order);
		return $this->db->get()->num_rows();
	}

	public function total_record($table){
        $this->db->from($table);
        return $this->db->count_all_results();
    }

	public function get_notif_user($grup_akses, $nip){
		if(in_array($grup_akses, array(1,11))){
			$this->db->where_in('nip_penerima', array('admin', $nip));
		}else if($grup_akses == 12){
			$this->db->where_in('nip_penerima', array('sub admin', $nip));
		}else{
			$this->db->where('nip_penerima', $nip);
		}
		$this->db->where('status_action', 0);
		$this->db->order_by('waktu','desc');
		return $this->db->get('notifikasi');
	}
	public function get_info_sop($id_review){
		$this->db->select('a.sop_nama, a.sop_alias, b.nama_penyusun, b.nip_penyusun');
		$this->db->from('sop a');
		$this->db->join('penyusun_sop b', 'a.sop_alias=b.sop_alias','inner');
		$this->db->join('list_review_sop c','a.sop_alias=c.sop_alias','inner');
		$this->db->where('c.idlist_review', $id_review);
		$this->db->limit(1);
		return $this->db->get();
	}
	public function update_status_notif($where){
		$data = array(
			'status_action' => 1,
			'status_baca' => 'Dibaca',
		);
		$this->db->where($where);
		$result = $this->db->update('notifikasi', $data);
		return ($result >= 1);
	}
	public function get_data_id($column, $id_kategori, $table){
		$this->db->where($column, $id_kategori);
		return $this->db->get($table);
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
	
}