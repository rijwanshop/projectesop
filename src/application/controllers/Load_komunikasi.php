<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Load_komunikasi extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url', 'text_helper','date','tgl_indonesia'));
		$this->load->database();
		$this->load->model(array('Sop_m','Notif_m','Main','Komunikasi_m'));	
		$this->load->library(array('alias','encrypt','menubackend'));
		cek_aktif();
	}
	
	
	
	
	
/* ====================================================================================================================================================== */
	function send()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error = '';
				$data = '';
				$userto = $this->input->post('userto');
				$tulis = $this->input->post('tulis');
				
				if($tulis == '') $Error .='Isi Pesan';
				
				if($Error == ''){
					$isi = array(
						'user_id' => $userid,
						'user_to' => $userto,
						'chating_message' => $tulis,
						'chating_date' => date("Y-m-d H:i:s")
					);
					$this->Komunikasi_m->insert_chating($isi);
					
					$chat = $this->Komunikasi_m->chating($session_data['userid'],$userto);
					foreach($chat->result_array() as $row){
						$left = ($userid != $row['user_id'] ? 'chat-left' : '');
						$data .= '<div class="chat '.$left.'">
							<div class="chat-avatar">
							  <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title="June Lane">
								<img src="'.base_url().'assets/global/portraits/5.jpg" alt="June Lane">
							  </a>
							</div>
							<div class="chat-body">
							  <div class="chat-content">
								<p>'.$row['chating_message'].'</p>
								<time class="chat-time" datetime="2017-06-01T08:30">'.$row['chating_date'].'</time>
							  </div>
							</div>
						  </div>';
					}
					
					echo die($data);
				}else{
					echo die($Error);
				}
			
	}
/* ====================================================================================================================================================== */
	
	
/* ====================================================================================================================================================== */
	function chat()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error = '';
				$data = '';
				$userto = $this->input->post('userto');
				$tulis = $this->input->post('tulis');
				$to = $this->uri->segment(3);
				
				
				$chat = $this->Komunikasi_m->chating($session_data['userid'],$to);
				if($chat->num_rows() > 0){
				foreach($chat->result_array() as $row){
						$left = ($userid != $row['user_id'] ? 'chat-left' : '');
						$data .= '<div class="chat '.$left.'">
							<div class="chat-avatar">
							  <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title="June Lane">
								<img src="'.base_url().'assets/global/portraits/5.jpg" alt="June Lane">
							  </a>
							</div>
							<div class="chat-body">
							  <div class="chat-content">
								<p>'.$row['chating_message'].'</p>
								<time class="chat-time" datetime="2017-06-01T08:30">'.$row['chating_date'].'</time>
							  </div>
							</div>
						  </div>';
				}}else{
					$data .='<div style="text-align:center;">Belum ada data</div>';
				}
					
				if($Error == ''){
					echo die($data);
				}else{
					echo die($Error);
				}
			
	}
/* ====================================================================================================================================================== */
	
	
	
	
	
	
	  
}
