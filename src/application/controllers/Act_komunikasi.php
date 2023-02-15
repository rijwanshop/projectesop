<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Act_komunikasi extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url', 'text_helper','date','tgl_indonesia'));
		$this->load->database();
		$this->load->model(array('Komunikasi_m'));	
		$this->load->library(array('alias','encrypt'));
		cek_aktif();	
	}
	

	/* ====================================================================================================================================================== */
	function add_kontak_kami()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				$fullname = $session_data['fullname'];
		
				$Error = '';
				$nama = $this->input->post('nama');
				$telepon = $this->input->post('telepon');
				$email = $this->input->post('email');
				$alamat = $this->input->post('alamat');
				$isi = $this->input->post('isi');
				
				
				// validasi null
				if($telepon == '') $Error .='Telepon Harus Di Isi<br>';
				if($email == '') $Error .='Email Harus Di Isi<br>';
				if($alamat == '') $Error .='Alamat Harus Di Isi<br>';
				if($isi == '') $Error .='Isi Pesan Harus Di Isi<br>';
				
				if($Error == ''){
					// query
					$q = "Insert into kontak_kami(kontak_kami_nama,kontak_kami_telepon,kontak_kami_email,kontak_kami_alamat,kontak_kami_isi,kontak_kami_tanggal,kontak_kami_status,user_id) 
						values('".$nama."','".$telepon."','".$email."','".$alamat."','".$isi."',NOW(),'D','".$userid."')";
					$this->Komunikasi_m->query_manual($q);
					
					echo '1';
					
				}else{
					
					echo $Error;
					
				}
			
	}
	
	function delete_kontak_kami()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				$fullname = $session_data['fullname'];
		
				$Error = '';
				$id = $this->uri->segment(3);
				
				// query
				$q = "delete from kontak_kami where kontak_kami_id=$id";
				$this->Komunikasi_m->query_manual($q);
				
				redirect('komunikasi/kontak_kami', 'refresh');
			
	}
	/* ====================================================================================================================================================== */	
	

	/* ====================================================================================================================================================== */
	function add_topik()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				$fullname = $session_data['fullname'];
		
				$Error = '';
				$topik = addslashes($this->input->post('topik'));
				$isi = addslashes($this->input->post('isi'));
				$kategori = $this->input->post('kategori');
				
				
				// validasi null
				if($topik == '') $Error .='Topik Harus Di Isi<br>';
				if($isi == '') $Error .='Isi Pesan Harus Di Isi';
				
				if($Error == ''){
					// query
					$q = "Insert into diskusi(user_id,kategori_diskusi_id,diskusi_topik,diskusi_isi,created_on,created_by) 
						values('".$userid."','".$kategori."','".$topik."','".$isi."',NOW(),'".$fullname."')";
					$this->Komunikasi_m->query_manual($q);
					
					echo '1';
					
				}else{
					
					echo $Error;
					
				}
			
	}
	function add_replay()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				$fullname = $session_data['fullname'];
		
				$Error = '';
				$diskusiid = $this->input->post('diskusiid');
				$kategori = $this->input->post('kategori');
				$replay = addslashes($this->input->post('replay'));
				$url = $this->input->post('replay');
				
				
				// query
				$q = "Insert into replay_diskusi(user_id,kategori_diskusi_id,diskusi_id,replay_diskusi_isi,created_on,created_by) 
					values('".$userid."','".$kategori."','".$diskusiid."','".$replay."',NOW(),'".$fullname."')";
				$this->Komunikasi_m->query_manual($q);
					
				redirect('komunikasi/forum/kategori/'.$kategori.'', 'refresh');
			
	}
	
	
	function delete_topik()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				$fullname = $session_data['fullname'];
		
				$Error = '';
				$id = $this->uri->segment(3);
				
				// query
				$q = "delete from kritik_saran where kritik_saran_id=$id";
				$this->Komunikasi_m->query_manual($q);
				
				redirect('komunikasi/kritik_saran', 'refresh');
			
	}
	/* ====================================================================================================================================================== */	
	

	/* ====================================================================================================================================================== */
	function add_kritik_saran()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				$fullname = $session_data['fullname'];
		
				$Error = '';
				$nama = $this->input->post('nama');
				$judul = addslashes($this->input->post('judul'));
				$isi = addslashes($this->input->post('isi'));
				
				
				// validasi null
				if($judul == '') $Error .='Judul Harus Di Isi';
				if($isi == '') $Error .='Isi Pesan Harus Di Isi';
				
				if($Error == ''){
					// query
					$q = "Insert into kritik_saran(kritik_saran_nama,kritik_saran_judul,kritik_saran_isi,kritik_saran_tanggal,kritik_saran_status,user_id) 
						values('".$nama."','".$judul."','".$isi."',NOW(),'D','".$userid."')";
					$this->Komunikasi_m->query_manual($q);
					
					echo '1';
					
				}else{
					
					echo $Error;
					
				}
			
	}
	
	
	function delete_kritik_saran()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				$fullname = $session_data['fullname'];
		
				$Error = '';
				$id = $this->uri->segment(3);
				
				// query
				$q = "delete from kritik_saran where kritik_saran_id=$id";
				$this->Komunikasi_m->query_manual($q);
				
				redirect('komunikasi/kritik_saran', 'refresh');
			
	}
	/* ====================================================================================================================================================== */	
	
}
