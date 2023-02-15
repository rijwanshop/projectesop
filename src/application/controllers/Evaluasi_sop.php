<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class evaluasi_sop extends CI_Controller {

	public function __construct() {
		parent::__construct(); 
		$this->load->helper(array('form','url', 'text_helper','date','tgl_indonesia'));
		$this->load->database();
		$this->load->model(array('Main','Sop_m'));	
		$this->load->library(array('alias'));
	}
	
	
	function index()
	{			
		 $ip      = $_SERVER['REMOTE_ADDR'];
		 $tanggal = date("Y-m-d");
		 $waktu   = time();
		 $cek = $this->Main->cek_pengunjung($ip,$tanggal);
		 if($cek == 0){
			 $this->Main->insert_pengunjung($ip,$tanggal);
		 }else{
			 $this->Main->update_pengunjung($ip,$tanggal);
		 }
		 
		 
		 $data['title'] = 'Evaluasi SOP';
		 $data['evaluasi'] = $this->Main->on_of_evaluasi();
		 $data['pengunjung'] = $this->Main->pengunjung_hariini($tanggal);
		 foreach ($this->Main->pengunjung_total()->result_array() as $row) 
		 {
			$data['totalpengunjung'] = $row['total'];
		 }
		 
		 $data['tentangkami'] = $this->Main->edit_table('post_content','content_menu','tentang_kami');
		 $data['agenda'] = $this->Main->edit_table('post_content','content_menu','agenda');
		 $this->load->view('front/header',$data);
		 $this->load->view('front/evaluasi',$data);
		 $this->load->view('front/footer',$data);
	}
	
	function nilai()
	{			
		 $ip      = $_SERVER['REMOTE_ADDR'];
		 $tanggal = date("Y-m-d");
		 $waktu   = time();
		 $cek = $this->Main->cek_pengunjung($ip,$tanggal);
		 if($cek == 0){
			 $this->Main->insert_pengunjung($ip,$tanggal);
		 }else{
			 $this->Main->update_pengunjung($ip,$tanggal);
		 }
		 
		 $data['title'] = 'Evaluasi SOP';
		 $alias = $this->uri->segment(3);
		 $data['evaluasi'] = $this->Main->on_of_evaluasi();
		 $data['pengunjung'] = $this->Main->pengunjung_hariini($tanggal);
		 $data['pertanyaan'] = $this->Main->select_table('pertanyaan','pertanyaan_id');
		 $data['cekpenilaian'] = $this->Main->cekpenilaian();
		 foreach ($this->Main->pengunjung_total()->result_array() as $row) 
		 {
			$data['totalpengunjung'] = $row['total'];
		 }
		 
		 $data['tentangkami'] = $this->Main->edit_table('post_content','content_menu','tentang_kami');
		 $data['agenda'] = $this->Main->edit_table('post_content','content_menu','agenda');
		 $this->load->view('front/header',$data);
		 $this->load->view('front/evaluasi_nilai',$data);
		 $this->load->view('front/footer',$data);
	}
	
}
