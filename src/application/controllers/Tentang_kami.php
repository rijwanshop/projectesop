<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Tentang_kami extends CI_Controller {

	public function __construct() {
		parent::__construct(); 
		$this->load->helper(array('form','url', 'text_helper','date','tgl_indonesia'));
		$this->load->database();
		$this->load->model(array('Main'));	
		$this->load->library(array('alias'));
		
	}
	public function latar_belakang(){
		$ip      = $_SERVER['REMOTE_ADDR'];
		$tanggal = date("Y-m-d");
		$waktu   = time();
		$cek = $this->Main->cek_pengunjung($ip,$tanggal);
		if($cek == 0){
			$this->Main->insert_pengunjung($ip,$tanggal);
		}else{
			$this->Main->update_pengunjung($ip,$tanggal);
		}
		 
		$data['title'] = 'Tentang Kami';
		$data['evaluasi'] = $this->Main->on_of_evaluasi();
		$data['pengunjung'] = $this->Main->pengunjung_hariini($tanggal);
		$data['totalpengunjung'] = $this->Main->pengunjung_total()->row()->total;

		$link = $this->uri->segment(2);
		$data['content'] = $this->Main->edit_table('post_content','content_alias',$link);
		$data['tentangkami'] = $this->Main->edit_table('post_content','content_menu','tentang_kami');
		$data['agenda'] = $this->Main->edit_table('post_content','content_menu','agenda');
		$data['link'] = site_url('tentang_kami/latar_belakang');
		$this->load->view('front/header',$data);
		$this->load->view('front/content',$data);
		$this->load->view('front/footer',$data);
	}
	public function maksud_dan_tujuan(){
		$ip      = $_SERVER['REMOTE_ADDR'];
		$tanggal = date("Y-m-d");
		$waktu   = time();
		$cek = $this->Main->cek_pengunjung($ip,$tanggal);
		if($cek == 0){
			$this->Main->insert_pengunjung($ip,$tanggal);
		}else{
			$this->Main->update_pengunjung($ip,$tanggal);
		}
		 
		$data['title'] = 'Tentang Kami';
		$data['evaluasi'] = $this->Main->on_of_evaluasi();
		$data['pengunjung'] = $this->Main->pengunjung_hariini($tanggal);
		$data['totalpengunjung'] = $this->Main->pengunjung_total()->row()->total;

		$link = $this->uri->segment(2);
		$data['content'] = $this->Main->edit_table('post_content','content_alias',$link);
		$data['tentangkami'] = $this->Main->edit_table('post_content','content_menu','tentang_kami');
		$data['agenda'] = $this->Main->edit_table('post_content','content_menu','agenda');
		$data['link'] = site_url('tentang_kami/maksud_dan_tujuan');
		$this->load->view('front/header',$data);
		$this->load->view('front/content',$data);
		$this->load->view('front/footer',$data);
	}
}
