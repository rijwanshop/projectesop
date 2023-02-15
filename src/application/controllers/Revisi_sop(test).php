<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Revisi_sop extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('tgl_indonesia','notif','kegiatan'));
		$this->load->model('Model_sop','sop');
		$this->load->model('Model_notifikasi','notif');
		$this->load->model(array('Sop_m','Notif_m','Main'));
		$this->load->model('Main');		
		$this->load->library('menubackend');
		date_default_timezone_set('Asia/Jakarta'); 
		cek_aktif();
	}
	public function index(){
		$data['title'] = 'Daftar Permohonan Revisi SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$this->load->view('templating/header',$data);
		$this->load->view('page/sop/revisi_sop/index',$data);
		$this->load->view('templating/footer',$data);
	}
}
