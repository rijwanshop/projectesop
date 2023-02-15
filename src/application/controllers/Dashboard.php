<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('notif');
		$this->load->model('Main');	
		$this->load->library(array('menubackend'));
		cek_aktif();
	}
	public function index(){		
		$data['title'] = 'Dashboard';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['video'] = $this->Main->panduan('video');
		$this->load->view('templating/header',$data);
		$this->load->view('content/dashboard/dashboard',$data);
		$this->load->view('templating/footer',$data);
	}
}