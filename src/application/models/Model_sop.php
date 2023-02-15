<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_sop extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));") ;
	}
	private function query_daftar_sop($column_search, $column_order, $order){
		$this->db->from('vwsop');
		$this->db->where('nip_user', $this->session->userdata['pegawainip']);
		$this->db->where('sop_label !=', 'sop lama');
		
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
	private function query_daftar_review_sop($column_search, $column_order, $order){
		$this->db->select('a.sop_alias, a.sop_no, a.sop_nama, z.tanggal_pengajuan, z.status_pengajuan, a.sop_step, a.sop_step, a.sop_update_file, z.idlist_review');
		$this->db->from('vwsop a');
		$this->db->join('list_review_sop z','a.sop_alias=z.sop_alias','inner');
		$this->db->where('z.nipbaru', $this->session->userdata['pegawainip']);
		$this->db->where('z.indikator',1);
		
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
			if(filter_var($_POST['order']['0']['column'], FILTER_VALIDATE_INT)) {
				$idx = $_POST['order']['0']['column'];
			} else {
				$idx = 0;
			}
			if($_POST['order']['0']['dir'] != 'acs' || $_POST['order']['0']['dir'] != 'desc'){
				$_POST['order']['0']['dir'] = 'acs';
			}
			
			$this->db->order_by($column_order[$idx], $_POST['order']['0']['dir']);
		}else{
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	public function get_daftar_review_sop($column_search, $column_order, $order){
		$this->query_daftar_review_sop($column_search, $column_order, $order);
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
	public function jumlah_filter_review_sop($column_search, $column_order, $order){
		$this->query_daftar_review_sop($column_search, $column_order, $order);
		return $this->db->get()->num_rows();
	}

	private function query_daftar_sop_lama($column_search, $column_order, $order){
		$this->db->from('vwsop');
		$this->db->where('nip_user', $this->session->userdata['pegawainip']);
		$this->db->where('sop_label', 'sop lama');
		
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
	public function get_daftar_sop_lama($column_search, $column_order, $order){
		$this->query_daftar_sop_lama($column_search, $column_order, $order);
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
	public function jumlah_filter_sop_lama($column_search, $column_order, $order){
		$this->query_daftar_sop_lama($column_search, $column_order, $order);
		return $this->db->get()->num_rows();
	}

	public function total_record($table){
        $this->db->from($table);
        return $this->db->count_all_results();
    }
    public function get_list_sop($search=''){
    	$this->db->select('sop_alias, sop_nama');
    	$this->db->from('vwsop');

    	$this->db->where('sop_status','Disahkan');

    	$satorg = trim($this->input->get('satorg', true));
    	if($this->input->get('satorg'))
    		$this->db->where('satuan_organisasi_id', $satorg);
    	else
			$this->db->where('satuan_organisasi_id', $this->session->userdata('satkerid'));

		$deputi = trim($this->input->get('deputi', true));
		if($this->input->get('deputi'))
			$this->db->where('deputi_id', $deputi);
		else
    		$this->db->where('deputi_id', $this->session->userdata('iddeputi'));

    	$biro = trim($this->input->get('biro', true));
    	if($this->input->get('biro'))
    		$this->db->where('unit_kerja_id', $biro);
    	else
    		$this->db->where('unit_kerja_id', $this->session->userdata('unitkerjaid'));
    	
		if($search != '')
			$this->db->like('sop_nama', $search);

		$this->db->order_by('sop_id','asc');

		if($search != '')
			$this->db->limit(5);
		
		return $this->db->get();
    }
	public function get_alias_sop(){
		$this->db->select('FLOOR(RAND() * 9999999999) AS random_num');
		$this->db->from('sop');
		$this->db->where(" 'random_num' NOT IN (SELECT sop_alias FROM sop)");
		$this->db->limit(1);
		return $this->db->get();
	}
	public function get_alias_review(){
		$this->db->select('FLOOR(RAND() * 9999999999) AS random_num');
		$this->db->from('list_review_sop');
		$this->db->where(" 'random_num' NOT IN (SELECT idlist_review FROM list_review_sop)");
		$this->db->limit(1);
		return $this->db->get();
	}
	public function get_next_auto_increment($table){
		return $this->db->query("SHOW TABLE STATUS WHERE name='$table'")->row()->Auto_increment;
	}
	public function no_urut_sop($idsatorg, $iddeputi, $unitkerjaid, $tahun){
		$this->db->where('satuan_organisasi_id', $this->db->escape_like_str($idsatorg));
		$this->db->where('deputi_id', $this->db->escape_like_str($iddeputi));
		$this->db->where('unit_kerja_id', $this->db->escape_like_str($unitkerjaid));
		$this->db->where('sop_status', 'Disahkan');
		$this->db->where('sop_label !=', 'berkas sop');
		$this->db->like('sop_tgl_pembuatan', $tahun, 'before');
		$this->db->order_by('sop_nourut', 'desc');
		$this->db->limit(1);
		return $this->db->get('vwsop');
	}
	public function get_pelaksana($search, $list_pelaksana){
		$this->db->group_start();
		$this->db->like('nama_jabatan', $search);
		$this->db->or_like('singkatan', $search);
		$this->db->group_end();

		$satorg = trim($this->input->get('satorg', true));
		if($this->input->get('satorg'))
			$this->db->where_in('id_unit',array('',$satorg));
		else
			$this->db->where_in('id_unit',array('',$this->session->userdata['satkerid']));

		$deputi = trim($this->input->get('deputi', true));
		if($this->input->get('deputi'))
			$this->db->where_in('id_deputi', array('',$deputi));
		else
			$this->db->where_in('id_deputi', array('',$this->session->userdata['iddeputi']));
		
		$biro = trim($this->input->get('biro', true));
    	if($this->input->get('biro'))
    		$this->db->where_in('id_biro', array('',$biro));
    	else
			$this->db->where_in('id_biro', array('',$this->session->userdata['unitkerjaid']));
		
		$this->db->where_not_in('singkatan', $list_pelaksana);
		$this->db->limit(10);
		return $this->db->get('m_singkatan_unit');
	}
	public function validate_singkatan($singkatan){
		$this->db->where('singkatan', $singkatan);
		$this->db->where('id_deputi', $this->session->userdata('iddeputi'));
		$this->db->where('id_biro', $this->session->userdata('unitkerjaid'));
		$this->db->where('id_satorg',$this->session->userdata('satkerid'));
		$result = $this->db->get('m_singkatan_unit');
		return ($result->num_rows() > 0);
	}
	public function get_data_id($column, $id_kategori, $table){
		$this->db->where($column, $id_kategori);
		return $this->db->get($table);
	}
	public function cek_jabatan($arr_where){
		$this->db->where($arr_where);
		return $this->db->get('m_singkatan_unit');
	}
	public function max_id($column, $table){
		$this->db->select_max($column);
		return $this->db->get($table);
	}
	public function insert_data($data, $table){
		$this->db->insert($table, $data);
		return $this->db->affected_rows() > 0;
	}
	public function detail_sop($alias){
		$this->db->select('k.kategori_nama, s.*, su.sop_update_file, su.sop_draft_file, su.link_draft_file');
		$this->db->from('sop s');
		$this->db->join('kategori_sop k','s.kategori_id=k.kategori_id','left');
		$this->db->join('sop_update su','su.sop_alias=s.sop_alias','left');
		$this->db->where('s.sop_alias', $this->db->escape_like_str($alias));
		return $this->db->get();
	}
	public function get_list_catatan_review($alias, $id=''){
		$this->db->where('sop_alias', $alias);
		$this->db->where('status_pengajuan !=', 'diajukan');
		if($id != '')
			$this->db->where('idlist_review !=', $id);
		
		$this->db->order_by('tanggal_catatan','desc');
		return $this->db->get('list_review_sop');
	}
	public function get_catatan_review($alias, $nip){
		$this->db->where('nipbaru', $nip);
		$this->db->where('sop_alias', $alias);
		return $this->db->get('list_review_sop');
	}
	public function get_daftar_singkatan($list_pelaksana){
		$this->db->distinct();
		$this->db->where_in('singkatan', $list_pelaksana);
		return $this->db->get('m_singkatan_unit');
	}
	public function update_data($column, $value, $data, $table){
		$this->db->where($column, $value);
		$result = $this->db->update($table, $data);
		return ($result >= 1);
	}
	public function hapus_sop($alias){
		$this->db->where('sop_kegiatan !=','');
		$this->db->where('sop_alias', $alias);
		$this->db->delete('sop');
		return $this->db->affected_rows() > 0;
	}
	public function hapus_data($column, $value, $table){
		$this->db->where($column, $value);
		$this->db->delete($table);
		return $this->db->affected_rows() > 0;
	}
	public function get_data($table){
		return $this->db->get($table);
	}
	public function get_status_catatan($alias){
		$this->db->where('status_pengajuan', 'Tolak');
		$this->db->where('sop_alias', $alias);
		$this->db->order_by('tanggal_catatan', 'asc');
		return $this->db->get('list_review_sop');
	}
	public function list_singkatan_jabatan(){
		$this->db->select('nama_jabatan, singkatan');
		$this->db->where_in('id_deputi', array('',$this->session->userdata['iddeputi']));
		$this->db->where_in('id_biro', array('',$this->session->userdata['unitkerjaid']));
		$this->db->where_in('id_unit',array('',$this->session->userdata['satkerid']));
		return $this->db->get('m_singkatan_unit');
	}
	public function get_review_sop($id){
		$this->db->select('idlist_review, sop_alias, nama_pereview, nipbaru, jabatan, status_pengajuan, catatan_review, indikator');
		$this->db->where('idlist_review', $id);
		return $this->db->get('list_review_sop');
	}
	public function get_info_sop_review($id){
		$this->db->select('sop_nama, sop_tgl_pembuatan, sop_alias, satuan_organisasi_id');
		$this->db->where('sop_alias',$id);
		return $this->db->get('sop');
	}
	public function history_sop($id){
		$this->db->where('alias_sop	',$id);
		$this->db->order_by('waktu','desc');
		return $this->db->get('history_sop');
	}
	public function update_indikator_review($id, $nip, $alias){
		$this->db->where('idlist_review !=', $id);
		$this->db->where('nipbaru', $nip);
		$this->db->where('sop_alias', $alias);
		$result = $this->db->update('list_review_sop', array('indikator' => 0));
		return ($result >= 1);
	}
	public function cek_akses_review($alias){
		$this->db->where('nipbaru', $this->session->userdata['pegawainip']);
		$this->db->where('sop_alias', $alias);
		return $this->db->get('list_review_sop');
	}
}