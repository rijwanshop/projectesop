<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Settings_m extends CI_Model{

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
		
		/* ================================================================================================================================================================ */
		function usergroup()
		{
			$table = 'user_group';
			$column = array('user_group_id ','user_group_name','user_group_status');
			$order = array('user_group_id' => 'asc');
			
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
				
		function listmenu()
		{
			$q = $this->db->query("select a.menu_id, a.menu_name, a.menu_level, IFNULL(a.menu_parent, 100) AS parent from menu a order by a.menu_id");
			return $q;
		}
		function editgroup($id)
		{
			$q = $this->db->query("select * from user_group where user_group_id='".$this->db->escape_like_str($id)."'");
			return $q;
		}
		function listmenu_id($id)
		{
			$q = $this->db->query("select a.menu_id, a.menu_name, a.menu_level, IFNULL(a.menu_parent, 100) AS parent, 
							(select menu_id from access_menu where menu_id=a.menu_id and user_group_id='".$this->db->escape_like_str($id)."' limit 1) as checklist,
							(select access_menu_a from access_menu where menu_id=a.menu_id and user_group_id='".$this->db->escape_like_str($id)."' limit 1) as checkadd,
							(select access_menu_e from access_menu where menu_id=a.menu_id and user_group_id='".$this->db->escape_like_str($id)."' limit 1) as checkedit,
							(select access_menu_d from access_menu where menu_id=a.menu_id and user_group_id='".$this->db->escape_like_str($id)."' limit 1) as checkdelete
							from menu a order by a.menu_order");
			return $q;
		}
		function menu_listbackend()
		{
			$q = $this->db->query("select menu_id, menu_name, menu_level, menu_sts_child, menu_order, IFNULL(menu_parent, 100) AS parent from menu order by menu_order");
			return $q;
		}
		function last_menu_order($parent)
		{
			$q = $this->db->query("select menu_order from menu where menu_parent='".$this->db->escape_like_str($parent)."' order by menu_order desc limit 1");
			return $q;
		}
		
		function order_back_child($parent,$id)
		{
			$q = $this->db->query("SELECT menu_id FROM menu where menu_parent='".$this->db->escape_like_str($parent)."' and menu_order='".$this->db->escape_like_str($id)."'");
			return $q;
		}
		function order_back_parent($id)
		{
			$q = $this->db->query("SELECT menu_id FROM menu where menu_parent=0 and menu_order='".$this->db->escape_like_str($id)."'");
			return $q;
		}
		function order_back_id($order,$id)
		{
			$q = $this->db->query("UPDATE menu SET menu_order=$order where menu_id='".$this->db->escape_like_str($id)."'");
			return $q;
		}
}