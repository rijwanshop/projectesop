<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Settings extends CI_Controller {

	public function __construct() {
		parent::__construct(); 
		$this->load->helper('notif');
		$this->load->model(array('Main','Settings_m'));	
		$this->load->library(array('menuchecklist','menuchecklistedit','menuchecklistview','listmenubackend','liststruktur_organisasi','checkparent','menubackend'));
		cek_aktif();
	}
	
	public function user_group(){			
		$data['title'] = 'User Group';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);

		$act = $this->uri->segment(3);
		$id =($this->uri->segment(4) == '' ? 0 : $this->uri->segment(4));
		$data['edit'] = $this->Settings_m->edit_table('user_group','user_group_id',$id);
		
		$this->load->view('templating/header',$data);
		if($act == ''){
			$this->load->view('page/settings/usergroup/index',$data);
		}else{
			$data['editgroup'] = $this->Settings_m->editgroup($id);
			if($act == 'add'){
				$data['listmenu'] = $this->Settings_m->listmenu();
			}else{
				$data['listmenu'] = $this->Settings_m->listmenu_id($id);
			}
				
			$this->load->view('page/settings/usergroup/action',$data);
		}
		$this->load->view('templating/footer',$data);
	}
	public function menu_manager(){	
		$data['title'] = 'Menu Manager';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);

		$act = $this->uri->segment(3);
		$data['listmenuback'] = $this->Settings_m->menu_listbackend();
		$parent = ($this->uri->segment(4) == '' ? 0 : $this->uri->segment(4));
		$last_order = $this->Settings_m->last_menu_order($parent);
		$data['order'] = 1;
		foreach($last_order->result_array() as $row){
			$data['order'] = $row['menu_order'] + 1;
		}
		$id = ($this->uri->segment(3) == 'add' ? 0 : $this->uri->segment(4));

		$this->load->view('templating/header',$data);
		if($act == ''){
			$this->load->view('page/settings/menu/index',$data);
		}else{
			$data['edit'] = $this->Settings_m->edit_table('menu','menu_id',$id);		
			$this->load->view('page/settings/menu/action',$data);
		}
		$this->load->view('templating/footer',$data);
	}
	
	
}
