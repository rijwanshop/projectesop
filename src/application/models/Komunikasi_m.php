<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Komunikasi_m extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));") ;
	}
		function select_table($table,$field)
		{
			$q = $this->db->query("SELECT * FROM $table order by $field");
			return $q;
		}
		function edit_table($table,$field,$id)
		{
			$q = $this->db->query("SELECT * FROM $table where $field='".$this->db->escape_like_str($id)."'");
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
		function cek_null_where($Table,$where='')
		{
			$this->db->from($Table);
			if($where) $this->db->where($where);
			return $this->db->count_all_results();
		}
		
		
		
		
		
		
		function topik_id($id)
		{
			$q = $this->db->query("select * from vwdiskusi where diskusi_id='".$this->db->escape_like_str($id)."'");
			return $q;
		}
		function topik_replay($id)
		{
			$q = $this->db->query("select r.*,u.user_foto from replay_diskusi r left join user u on r.user_id=u.user_id where r.diskusi_id='".$this->db->escape_like_str($id)."'");
			return $q;
		}
		
		/* ================================================================================================================================================================ */
		function listkategori()
		{
			$table = 'kategori_diskusi';
			$column = array('kategori_diskusi_id','kategori_diskusi_judul');
			$order = array('kategori_diskusi_id' => 'asc');
			
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
		function listtopik()
		{
			$table = 'kategori_diskusi';
			$column = array('kategori_diskusi_id','kategori_diskusi_judul');
			$order = array('kategori_diskusi_id' => 'asc');
			
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
		function kontak()
		{
			$table = 'kontak_kami';
			$column = array('kontak_kami_id','kontak_kami_nama','kontak_kami_telepon','kontak_kami_alamat','kontak_kami_email');
			$order = array('kontak_kami_id' => 'asc');
			
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
		function kritik_saran()
		{
			$table = 'kritik_saran';
			$column = array('kritik_saran_id','kritik_saran_nama','kritik_saran_judul','kritik_saran_tanggal');
			$order = array('kritik_saran_id' => 'asc');
			
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
			
		function update_status($tabel,$field,$where,$id)
		{
			$q = $this->db->query("update $tabel set $field='R' where $where='".$this->db->escape_like_str($id)."'");
			return $q;
		}
		function list_user($userid,$key)
		{
			$q = $this->db->query("select u.*, 
					(select c1.chating_date from chating c1 where c1.user_from=u.user_id order by chating_date desc limit 1) as chatdate,
					(select count(c1.user_from) from chating c1 where c1.user_from=u.user_id and c1.chating_status='D' limit 1) as jmlchat from user u 
					left join chating c on u.user_id=c.user_from
					where u.user_id!='".$this->db->escape_like_str($userid)."' and u.user_fullname like '%".$this->db->escape_like_str($key)."%' group by u.user_id order by chatdate desc");
			return $q;
		}
		function insert_chating($data){
			$this->db->insert('chating', $data);
		}
	
		
		function UpdateStatus($id,$userid)
		{
			$q = $this->db->query("update chating set chating_status='R' where (user_from='".$this->db->escape_like_str($userid)."' and user_to='".$this->db->escape_like_str($id)."') or (user_from='".$this->db->escape_like_str($id)."' and user_to='".$this->db->escape_like_str($userid)."')");
			return $q;
		}
		function getAllUser($where="")
		{
			//if($where) $this->db->where($where);
			return $this->db->get("user");
		}
		function getAll($where="")
		{
			if($where) $this->db->where($where);
			$this->db->order_by("chating_date","ASC");
			return $this->db->get("chating");
		}
		
		function getInsert($data){
			return $this->db->set($data)->insert("chating");
		}
		
		function getLastId($where){
			return $this->db->where($where)->order_by("chating_id","DESC")->limit(1)->get("chating")->row_array();
		}
		
		// forum
		function record_count($where="")
		{
		 if($where) $this->db->where($where);
		 $query = $this->db->get("vwdiskusi");
		 return $query->num_rows();
		}
		public function fetch_employees($limit, $start,$where="") {
			$data =array();
			if($where) $this->db->where($where);
			$this->db->order_by('diskusi_id', 'desc');
			$this->db->limit($limit, $start);
			$query = $this->db->get("vwdiskusi");
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
				return $data;
			}
			
			return false;
			//$q = $this->db->query("select d.*, (select count(replay_diskusi_id) from replay_diskusi where diskusi_id=d.diskusi_id) as post from diskusi d $where limit $start, $limit");
			//if ($q->num_rows() > 0) {
			//	foreach ($q->result() as $row) {
			//		$data[] = $row;
			//	}
			//	return $data;
			//}
			//return false;
		}
		
}