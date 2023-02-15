<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Notif_m extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));") ;
	}
		
		function edit_table($table,$field,$id)
		{
			$q = $this->db->query("SELECT * FROM $table where $field=$id");
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
			$this->db->where($Coloum, $Where);
			return $this->db->count_all_results();
		}
		
		
		
		
		
		
		
		/* ================================================================================================================================================================ */
		function semua()
		{
			$session_data = $this->session->userdata;
			$userid = $session_data['userid'];
		
			$table = '(select * from notif where user_id='.$this->db->escape_like_str($userid).') as notif';
			$column = array('notif_id','notif_title','notif_type','notif_date','user_id');
			$order = array('notif_id' => 'desc');
			
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
			
		
		
		
		public function notification($limit,$id){
			$this->db->where('user_id', $this->db->escape_like_str($id));
			$this->db->where('notif_status','D');
			$this->db->order_by('notif_id','desc');
			$this->db->limit($limit);
			return $this->db->get('notif');
			
			//$q = $this->db->query("select * from notif  where user_id='$id' and notif_status='D' order by notif_id desc limit $limit ");
			//return $q;
		}
		function update_status($tabel,$field,$where,$id)
		{
			$q = $this->db->query("update $tabel set $field='R' where $where='$id'");
			return $q;
		}
		
		
	
	 
	
		
}