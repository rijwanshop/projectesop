<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_pencarian extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));") ;
	}
	private function query_daftar_sop($column_search, $column_order, $order){
		$this->db->distinct();
		$this->db->select('sop_alias, sop_no, sop_nama, satuan_organisasi_nama, nama_deputi, nama_unit, sop_tgl_efektif, sop_label');
		$this->db->from('sop');
		$this->db->where('sop_tgl_efektif !=','');
		$this->db->where('sop_status_publish','publish');

		//filter satorg
		$satorg = trim($this->input->post('satorg', true));
		if($satorg != '')
			$this->db->where('satuan_organisasi_id', $satorg);

		//filter deputi
		$deputi = trim($this->input->post('deputi', true));
		if($deputi != ''){
			if(in_array($satorg, array('01','02')))
				$this->db->where('deputi_id', $deputi);
			else
				$this->db->where('unit_kerja_id', $deputi);
		}

		//filter biro (khusus setpres dan setwapres)
		$biro = trim($this->input->post('biro', true));
		if($biro != '')
			if(in_array($satorg, array('01','02')))
				$this->db->where('unit_kerja_id', $biro);

		//filter nomor SOP
		$no_sop = trim($this->input->post('no_sop', true));
		if($no_sop != '')
			$this->db->like('sop_no', $no_sop);

		//filter nama SOP
		$nama_sop = trim($this->input->post('nama_sop', true));
		if($nama_sop != '')
			$this->db->like('sop_nama', $nama_sop);

		//filter tahun SOP
		$tahun = trim($this->input->post('tahun', true));
		if($tahun != '')
			$this->db->like('sop_tgl_efektif', $tahun);

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
	public function get_daftar_sop($column_search, $column_order, $order){
		$this->query_daftar_sop($column_search, $column_order, $order);
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
	public function jumlah_filter_daftar_sop($column_search, $column_order, $order){
		$this->query_daftar_sop($column_search, $column_order, $order);
		return $this->db->get()->num_rows();
	}
	public function total_record($table){
        $this->db->from($table);
        return $this->db->count_all_results();
    }
	public function get_list_tanggal_sop(){
		$this->db->distinct();
		$this->db->select('sop_tgl_efektif');
		$this->db->where('sop_tgl_efektif !=', '');
		return $this->db->get('sop');
	}
	public function get_data_id($column, $id_kategori, $table){
		$this->db->where($column, $id_kategori);
		return $this->db->get($table);
	}
	public function get_filter_unit($satorg, $deputi, $biro){
		$this->db->distinct();
		$this->db->select('sop_nama, sop_alias, sop_label');
		$this->db->where('satuan_organisasi_id', $satorg);

		if($deputi != ''){
			if(in_array($satorg, array('01','02')))
				$this->db->where('deputi_id', $deputi);
			else
				$this->db->where('unit_kerja_id', $deputi);
		}

		if($biro != '')
			if(in_array($satorg, array('01','02')))
				$this->db->where('unit_kerja_id', $biro);

		return $this->db->get('sop');
	}
	public function get_last_year(){
		$this->db->where('sop_index !=', 0);
		$this->db->where('sop_tgl_efektif !=','');
		$this->db->order_by('sop_index', 'desc');
		$this->db->limit(1);
		return $this->db->get('vwsop');
	}
}