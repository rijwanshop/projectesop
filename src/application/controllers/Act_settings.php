<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('date.timezone', 'Asia/Jakarta');

class Act_settings extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url', 'text_helper','date','tgl_indonesia','string'));
		$this->load->model(array('Settings_m'));	
		$this->load->library(array('alias','encrypt'));
		cek_aktif();	
	}
	
	/* ====================================================================================================================================================== */
	function add_usergroup()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error ='';
				$GroupName = $this->input->post('GroupName');
				$StatusGroup = $this->input->post('StatusGroup');
				
				// validasi
				if($GroupName == '') $Error .='Group Name Harus Di Isi';
				
				if($Error == ''){
						$q ="INSERT INTO user_group(user_group_name,user_group_status) 
						value('".$GroupName."','".$StatusGroup."')";
						$this->Settings_m->query_manual($q);
						$groupid = $this->db->insert_id();
						
						$check = $this->input->post('check');
						for($i=0;$i<count($check); $i++){
							$add = $this->input->post('add_'.$check[$i].'');	
							$edit = $this->input->post('edit_'.$check[$i].'');	
							$delete = $this->input->post('delete_'.$check[$i].'');	
							$q ="INSERT INTO access_menu(menu_id,access_menu_a,access_menu_e,access_menu_d,user_group_id) 
							value('".$check[$i]."','".$add."','".$edit."','".$delete."','".$groupid."')";
							$this->Settings_m->query_manual($q);
						}
					
					echo '1';
				}else{
					
					echo $Error;
					
				}
				
				
	}
	
	
	function edit_usergroup()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error ='';
				$GroupId = $this->input->post('id');
				$GroupName = $this->input->post('GroupName');
				$StatusGroup = $this->input->post('StatusGroup');
				
				// validasi
				if($GroupName == '') $Error .='Group Name Harus Di Isi';
				
				if($Error == ''){
						$q ="UPDATE user_group SET user_group_name='".$GroupName."',user_group_status='".$StatusGroup."' where user_group_id='".$GroupId."'";
						$this->Settings_m->query_manual($q);
						
						$q ="DELETE from access_menu where user_group_id='".$GroupId."'";
						$this->Settings_m->query_manual($q);
						
						
						$check = $this->input->post('check');	
						for($i=0;$i<count($check); $i++){
							$add = $this->input->post('add_'.$check[$i].'');	
							$edit = $this->input->post('edit_'.$check[$i].'');	
							$delete = $this->input->post('delete_'.$check[$i].'');	
							$q ="INSERT INTO access_menu(menu_id,access_menu_a,access_menu_e,access_menu_d,user_group_id) 
							value('".$check[$i]."','".$add."','".$edit."','".$delete."','".$GroupId."')";
							$this->Settings_m->query_manual($q);
						}
					
					echo '1';
				}else{
					
					echo $Error;
					
				}
				
	}
	
	function delete_usergroup()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error = '';
				$id = $this->uri->segment(3);
				
				// query
				$q = "delete from user_group where user_group_id=$id";
				$this->Settings_m->query_manual($q);
				
				$q = "delete from access_menu where user_group_id=$id";
				$this->Settings_m->query_manual($q);
					
				redirect('settings/user_group', 'refresh');
		
			
	}
/* ====================================================================================================================================================== */

/* ====================================================================================================================================================== */
	function add_menu()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error = '';
				$parent = $this->input->post('parent');
				$nama = $this->input->post('nama');
				$link = $this->input->post('link');
				$order = $this->input->post('order');
				$level = $this->input->post('level');
				
				// validasi null
				if($nama == '') $Error .='Nama Menu Harus diisi<br>';
				if($link == '') $Error .='Link Menu Harus diisi';
				
				if($Error == ''){
					
					// query
					$q = "Insert into menu(menu_parent,menu_order,menu_name,menu_level,menu_link,menu_sts_child,created_on,created_by) 
						values('".$parent."','".$order."','".$nama."','".$level."','".$link."','T',NOW(),'".$username."')";
					$this->Settings_m->query_manual($q);
					$id = $this->db->insert_id();
					if($parent != 0){
						$q = "update menu set menu_sts_child='Y' where menu_id=$parent";
						$this->Settings_m->query_manual($q);
					}
						
					echo '1';
					
				}else{
					
					echo $Error;
					
				}
	}
	
	function edit_menu()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error = '';
				$id = $this->input->post('id');
				$nama = $this->input->post('nama');
				$link = $this->input->post('link');
				
				// validasi null
				if($nama == '') $Error .='Nama Menu Harus diisi<br>';
				if($link == '') $Error .='Link Menu Harus diisi';
				
				if($Error == ''){
					
					// query
					$q = "update menu set menu_name='".$nama."', menu_link='".$link."' where menu_id=$id";
					$this->Settings_m->query_manual($q);
					
					echo '1';
					
				}else{
					
					echo $Error;
					
				}
	}
	
	function order_parent_backend(){
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$id = $this->uri->segment(3);
				$order = $this->uri->segment(4);
				$updown = $this->uri->segment(5);
				
				// find id
				$result = $this->Settings_m->order_back_parent($updown);
				foreach($result->result_array() as $row){
					$menuid = $row['menu_id'];
				}
				
				// edit
				$this->Settings_m->order_back_id($updown,$id);
				$this->Settings_m->order_back_id($order,$menuid);
				
				redirect('settings/menu_manager', 'refresh');
		
	}
	
	function order_child_backend(){
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$id = $this->uri->segment(3);
				$order = $this->uri->segment(4);
				$updown = $this->uri->segment(5);
				$parent = $this->uri->segment(6);
				
				// find id
				$result = $this->Settings_m->order_back_child($parent,$updown);
				foreach($result->result_array() as $row){
					$menuid = $row['menu_id'];
				}
				
				// edit
				$this->Settings_m->order_back_id($updown,$id);
				$this->Settings_m->order_back_id($order,$menuid);
				
				redirect('settings/menu_manager', 'refresh');
	}
	
	function delete_menu()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error = '';
				$id = $this->uri->segment(3);
				
				// query
				$q = "delete from menu where menu_id=$id";
				$this->Settings_m->query_manual($q);
				
				$q = "delete from menu where menu_parent=$id";
				$this->Settings_m->query_manual($q);
					
				redirect('settings/menu_manager', 'refresh');
			
	}
/* ====================================================================================================================================================== */

}
