<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(array('Sop_m','Notif_m','Main','Model_forum'));	
		$this->load->helper(array('form','url', 'text_helper','date','tgl_indonesia'));
		$this->load->library(array('alias','encrypt','menubackend','pagination'));
		date_default_timezone_set('Asia/Jakarta');
		cek_aktif();
	}
	public function index(){
		$data['notif'] = $this->Notif_m->notification(5,$this->session->userdata['userid']);
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Kontak Kami';
		$this->load->view('templating/header',$data);
		if(in_array($this->session->userdata['groupid'], array(1,11)))
			$this->load->view('content/kontak_kami/v_pesan_masuk',$data);
		else
			$this->load->view('content/kontak_kami/v_input_kontak_kami',$data);
		$this->load->view('templating/footer',$data);
	}
}
