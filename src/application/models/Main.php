<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Model{
     	
	public function __construct(){
		parent::__construct();
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));") ;
	}	
		public function cek_role_user($nip){
			//$this->db->where('user_name',$nip);
			//return $this->db->get('vwuser');
			$this->db->where('niplama', $nip);
			return $this->db->get('pengguna');
		}
		
		
		function select_table($table,$field)
		{
			$q = $this->db->query("SELECT * FROM $table order by $field");
			return $q;
		}
		function edit_table($table,$field,$id)
		{
			$q = $this->db->query("SELECT * FROM $table where $field='".$id."'");
			return $q;
		}
		function query_manual_select($datainput)
		{
			$q = $this->db->query($datainput);
			return $q;
		}
		
		function query_manual($datainput)
		{
			$q = $this->db->query($datainput);
			return $q;
		}
		
		function get_datatables($Function)
		{
			$this->$Function();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}
		public function count_all($Table)
		{
			$this->db->from($Table);
			return $this->db->count_all_results();
		}
		function count_filtered($Function)
		{
			$this->$Function();
			$query = $this->db->get();
			return $query->num_rows();
		}
		public function cek_null($Table,$Coloum,$Where)
		{
			$this->db->from($Table);
			$this->db->where($Coloum, $this->db->escape_like_str($Where));
			return $this->db->count_all_results();
		}
		
		
		
		
		
		
		
		
		
		
		
		function pengunjung_hariini($tgl)
		{
			$this->db->from('pengunjung');
			$this->db->where('pengunjung_tanggal', $this->db->escape_like_str($tgl));
			//$this->db->group_by('pengunjung_ip');
			$query = $this->db->get();
			return $query->num_rows();
		}
		function pengunjung_total()
		{
			$q = $this->db->query("select count(pengunjung_hits) as total from pengunjung");
			return $q;
		}
		function cek_pengunjung($ip,$tgl)
		{
			$this->db->from('pengunjung');
			$this->db->where('pengunjung_ip', $this->db->escape_like_str($ip));
			$this->db->where('pengunjung_tanggal', $this->db->escape_like_str($tgl));
			$query = $this->db->get();
			return $query->num_rows();
		}
		function insert_pengunjung($ip,$tgl)
		{
			$q = $this->db->query("insert into pengunjung(pengunjung_ip,pengunjung_tanggal,pengunjung_hits)values('".$this->db->escape_like_str($ip)."','".$this->db->escape_like_str($tgl)."','1')");
			return $q;
		}
		function update_pengunjung($ip,$tgl)
		{
			$q = $this->db->query("update pengunjung SET pengunjung_hits=pengunjung_hits+1 where pengunjung_ip='$ip' and pengunjung_tanggal='$tgl'");
			return $q;
		}
		function pengumuman_terbaru($limit)
		{
			$q = $this->db->query("select * from pengumuman order by pengumuman_id desc limit $limit");
			return $q;
		}
		function panduan($type)
		{
			$q = $this->db->query("select * from panduan_teknis where type='".$type."' order by id");
			return $q;
		}
		function on_of_evaluasi()
		{
			$this->db->from('evaluasi');
			$this->db->where('evaluasi_status', 'Y');
			$query = $this->db->get();
			return $query->num_rows();
		}
		function cekpenilaian()
		{	
			$this->db->from('jawaban');
			//$this->db->where('jawaban_ip', ''.$this->db->escape_like_str($ip).'');
			//$this->db->where('jawaban_tanggal', ''.$this->db->escape_like_str($tanggal).'');
			//$this->db->where('md5(sop_alias)', ''.$this->db->escape_like_str($alias).'');
			$query = $this->db->get();
			return $query->num_rows();
		}
		function menu_backend($group)
		{
			$q = $this->db->query("select a.menu_id, a.menu_name, a.menu_icon, a.menu_level, a.menu_sts_child, a.menu_order, a.menu_link, IFNULL(a.menu_parent, 100) AS parent from access_menu m left join menu a 
								on m.menu_id=a.menu_id where m.user_group_id='".$this->db->escape_like_str($group)."' order by a.menu_order");
			return $q;
		}
		/* ================================================================================================================================================================ */
		function mahasiswa()
		{
			$table = 'mahasiswa';
			$column = array('mahasiswa_id ','mahasiswa_nim','mahasiswa_nama','mahasiswa_jkel');
			$order = array('mahasiswa_nim' => 'asc');
			
			$this->db->from($table);
			$i = 0;
			foreach ($column as $item) 
			{
				if(isset($_POST['search']['value'])){
					($i===0) ? $this->db->like($item, $this->db->escape_like_str($_POST['search']['value'])) : $this->db->or_like($item, $this->db->escape_like_str($_POST['search']['value']));
				}
				$column[$i] = $item;
				$i++;
			}
			
			if(isset($_POST['order']))
			{
				$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($order))
			{
				$order = $order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
		/* ================================================================================================================================================================ */
			
		
		/* ================================================================================================================================================================ */
		function dosen()
		{
			$table = 'dosen';
			$column = array('dosen_id ','dosen_nik','dosen_nama','dosen_jkel');
			$order = array('dosen_nik' => 'asc');
			
			$this->db->from($table);
			$i = 0;
			foreach ($column as $item) 
			{
				if(isset($_POST['search']['value'])){
					($i===0) ? $this->db->like($item, $this->db->escape_like_str($_POST['search']['value'])) : $this->db->or_like($item, $this->db->escape_like_str($_POST['search']['value']));
				}
				$column[$i] = $item;
				$i++;
			}
			
			if(isset($_POST['order']))
			{
				$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($order))
			{
				$order = $order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
		/* ================================================================================================================================================================ */
			
		function list_usergroup()
		{
			$q = $this->db->query("select * from user_group order by user_group_name");
			return $q;
		}
		

		function getRows($params = array())
		{
			$this->db->select('*');
			$this->db->from('pengumuman');
			$this->db->order_by('pengumuman_tanggal','desc');
			
			if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
				$this->db->limit($params['limit'],$params['start']);
			}elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
				$this->db->limit($params['limit']);
			}
			
			$query = $this->db->get();
			
			return ($query->num_rows() > 0)?$query->result_array():FALSE;
		}
		
		
		
		
		
		
	
	 
	
		
}