<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_admin_sop extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));") ;
	}
	private function query_daftar_sop($column_search, $column_order, $order){
		$this->db->select('a.sop_alias, b.idlist_review, a.sop_no, a.sop_nama, a.sop_step, b.tanggal_pengajuan, b.status_pengajuan, a.sop_update_file');
		$this->db->from('vwsop a');
		$this->db->join('list_review_sop b','a.sop_alias=b.sop_alias','inner');
		$this->db->where('b.indikator',1);
		
		//admin dan super admin
		if(in_array($this->session->userdata['groupid'], array(1, 11))) 
			$this->db->where('b.nipbaru','Admin');
		else if($this->session->userdata['groupid'] == 12){
			$this->db->where('b.nipbaru','Sub Admin');
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

	private function query_daftar_pengesahan_sop($column_search, $column_order, $order){
		$this->db->select('a.sop_alias, b.idlist_review, a.sop_no, a.sop_nama, a.sop_step, a.sop_tgl_pembuatan, a.sop_status, a.sop_update_file, a.sop_label, b.tanggal_pengajuan');
		$this->db->from('vwsop a');
		$this->db->join('list_review_sop b','a.sop_alias=b.sop_alias','inner');
		$this->db->where('b.indikator',1);
		$this->db->where('b.nipbaru', $this->session->userdata['pegawainip']);
		$this->db->where('a.sop_disahkan_nip', $this->session->userdata['pegawainip']);

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
	public function get_daftar_pengesah_sop($column_search, $column_order, $order){
		$this->query_daftar_pengesahan_sop($column_search, $column_order, $order);
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
	public function jumlah_filter_daftar_pengesah_sop($column_search, $column_order, $order){
		$this->query_daftar_pengesahan_sop($column_search, $column_order, $order);
		return $this->db->get()->num_rows();
	}

	private function query_daftar_sop_unpublish($column_search, $column_order, $order){
		$this->db->distinct();
		$this->db->select('sop_alias, sop_no, sop_nama, satuan_organisasi_nama, nama_deputi, nama_unit, sop_tgl_efektif, sop_label');
		$this->db->from('sop');
		$this->db->where('sop_tgl_efektif !=','');
		$this->db->where('sop_status_publish','unpublish');

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
	public function get_daftar_sop_unpublish($column_search, $column_order, $order){
		$this->query_daftar_sop_unpublish($column_search, $column_order, $order);
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
	public function jumlah_filter_daftar_sop_unpublish($column_search, $column_order, $order){
		$this->query_daftar_sop_unpublish($column_search, $column_order, $order);
		return $this->db->get()->num_rows();
	}

	private function query_pencarian_sop($column_search, $column_order, $order){
		$this->db->select('a.*, b.nama_penyusun');
		$this->db->from('vwsop a');
		$this->db->join('penyusun_sop b','a.sop_alias=b.sop_alias','inner');

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
	public function get_pencarian_sop($column_search, $column_order, $order){
		$this->query_pencarian_sop($column_search, $column_order, $order);
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
	public function jumlah_filter_pencarian_sop($column_search, $column_order, $order){
		$this->query_pencarian_sop($column_search, $column_order, $order);
		return $this->db->get()->num_rows();
	}
	private function query_upload_sop($column_search, $column_order, $order){
		$this->db->from('berkas_sop');
		
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
	public function get_upload_sop($column_search, $column_order, $order){
		$this->query_upload_sop($column_search, $column_order, $order);
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
	public function jumlah_filter_upload_sop($column_search, $column_order, $order){
		$this->query_upload_sop($column_search, $column_order, $order);
		return $this->db->get()->num_rows();
	}

	public function total_record($table){
        $this->db->from($table);
        return $this->db->count_all_results();
    }

    public function get_singkatan_jabatan($idsatorg, $id_deputi, $id_biro){
    	$this->db->select('nama_jabatan, singkatan');
		$this->db->where_in('id_deputi', array('',$id_deputi));
		$this->db->where_in('id_biro', array('',$id_biro));
		$this->db->where_in('id_unit',array('',$idsatorg));
		return $this->db->get('m_singkatan_unit');
    }
    public function get_list_sop($search='', $unit_kerja){
    	$this->db->select('sop_alias, sop_nama');
    	$this->db->from('vwsop');
    	$this->db->where('unit_kerja_id', $unit_kerja);

		if($search != '')
			$this->db->like('sop_nama', $search);

		$this->db->order_by('sop_id','asc');

		if($search != '')
			$this->db->limit(5);
		
		return $this->db->get();
    }
    public function get_penyusun_sop($alias){
    	$this->db->where('sop_alias', $alias);
    	return $this->db->get('penyusun_sop');
    }
    public function cek_pengesah($alias){
    	$this->db->where('sop_alias', $alias);
    	$this->db->where('sop_disahkan_nip', $this->session->userdata['pegawainip']);
    	return $this->db->get('sop');
    }
}
