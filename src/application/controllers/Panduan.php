<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Panduan extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('notif');
		$this->load->model('Main');	
		$this->load->library(array('menubackend'));
		cek_aktif();
	}
	
	function pdf_juknis()
	{			
		$id = $this->uri->segment(3);
		$p = $this->db->query("select file_panduan from panduan_teknis where id='".$id."'")->row_array();
		
		$file = $this->config->item('pathupload_juknis').$p['file_panduan'];
		$filename = $p['file_panduan'];
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' . $filename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');
		@readfile($file);
		
	}
	
	function video_juknis()
	{			
		//$id = $this->uri->segment(3);
		//$p = $this->db->query("select file_panduan from panduan_teknis where id='".$id."'")->row_array();
		//
		$file = $this->config->item('pathupload_juknis_video').'Tutorial e-SOP.mp4';
		//$filename = 'Tutorial e-SOP.mp4';
		//header('Content-type: video/mp4');
		//header('Content-Disposition: inline; filename="' . $filename . '"');
		//header('Content-Transfer-Encoding: binary');
		//header('Accept-Ranges: bytes');
		//@readfile($file);
		header('Content-type: video/mp4');
		header('Content-Disposition: attachment; filename="videodownload.avi"');
		readfile(''.$file.'');
	}
	
	public function index(){		
		$data['title'] = 'Panduan Teknis Sistem';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['video'] = $this->Main->panduan('video');
		$data['doc'] = $this->Main->panduan('doc');
		$this->load->view('templating/header',$data);
		$this->load->view('content/dashboard/panduan',$data);
		$this->load->view('templating/footer',$data);
	}
}