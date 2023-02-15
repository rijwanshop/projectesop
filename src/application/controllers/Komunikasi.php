<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set("Asia/Bangkok");
class Komunikasi extends CI_Controller {

	public function __construct() {
		parent::__construct(); 
		$this->load->helper(array('form','url', 'text_helper','date','tgl_indonesia'));
		$this->load->database();
		$this->load->model(array('Sop_m','Notif_m','Main','Komunikasi_m'));	
		$this->load->library(array('alias','encrypt','menubackend','pagination'));
		cek_aktif();
	}
	
	  

	function chatting()
	{			
		
		$data=array();
		$data['title'] = 'Chating';
		
		$session_data = $this->session->userdata;
		$data['userid'] = $session_data['userid'];
		$data['groupid'] = $session_data['groupid'];
		$data['fullname'] = $session_data['fullname'];
		$data['foto'] = $session_data['foto'];
		$data['satkernm'] = $session_data['satkernm'];
		$data['unitkerjanm'] = $session_data['unitkerjanm'];
		$userid = $session_data['userid'];
		$data['notif'] = $this->Notif_m->notification(5,$userid);
		$data['menu'] = $this->Main->menu_backend($session_data['groupid']);
		
		$act = $this->uri->segment(3);
		
		
		$this->load->view('page/komunikasi/chating/index',$data);
		
	}
	
	function searchKontak()
	{			
		
		$session_data = $this->session->userdata;
		$userid = $session_data['userid'];
		$key	= $this->input->post("key");
		$data['listuser'] = $this->Komunikasi_m->list_user($userid,$key);
		
		$this->load->view("page/komunikasi/chating/kontak",$data);
		
	}
	function getChat_all()
	{			
		
		$session_data = $this->session->userdata;
		$data['userid'] = $session_data['userid'];
		$id_user	= $this->input->post("id_user",true); //tujuan
		$id			= $session_data['userid']; //dari
		$id_max		= $this->input->post('id_max'); //dari
		//update status
		$this->Komunikasi_m->UpdateStatus($id,$id_user);
		
		$where	= "(((user_from = '$id_user' AND user_to = '$id') OR (user_to = '$id_user' AND user_from = '$id')))";
		$chat	= $this->Komunikasi_m->getAll($where);
		
		$where2	= "(((user_from = '$id_user' AND user_to = '$id') OR (user_to = '$id_user' AND user_from = '$id')) AND chating_id > '$id_max')";
		$get_id = $this->Komunikasi_m->getLastId($where2);
		
		$data['id_max']		= (!isset($get_id['chating_id']) ? 0 : $get_id['chating_id']);
		$data['id_user']	= $id_user;
		$data['chat'] 		= $chat;
		
		$act = $this->uri->segment(3);
		
		$this->load->view("page/komunikasi/chating/vwchatbox",$data);
		
	}
	function getLastId()
	{			
		
		$session_data = $this->session->userdata;
		$data['userid'] = $session_data['userid'];
		$id_user	= $this->input->post("id_user",true); //tujuan
		$id			= $session_data['userid']; //dari
		$id_max		= $this->input->post('id_max'); //dari
		
		$where	= "(((user_from = '$id_user' AND user_to = '$id') OR (user_to = '$id_user' AND user_from = '$id')) AND chating_id > '$id_max')";
		$get_id = $this->Komunikasi_m->getLastId($where);
		
		echo json_encode(array("id" => $get_id['chating_id'] != '' ?  $get_id['chating_id'] : $id_max ));
			
		
	}
	function getChat()
	{			
		
		$session_data = $this->session->userdata;
		$data['userid'] = $session_data['userid'];
		$id_user	= $this->input->post("id_user",true); //tujuan
		$id			= $session_data['userid']; //dari
		$id_max		= $this->input->post('id_max'); //dari

		$where	= "(((user_from = '$id_user' AND user_to = '$id') OR (user_to = '$id_user' AND user_from = '$id')) AND chating_id > '$id_max')";
		$chat	= $this->Komunikasi_m->getAll($where);
		$data['id_max']		= $id_max;
		$data['id_user']	= $id_user;
		$data['chat'] 		= $chat;
		
		$this->load->view("page/komunikasi/chating/vwchatbox",$data);
		
	}
	function sendMessage()
	{			
		
		$session_data = $this->session->userdata;
		$data['userid'] = $session_data['userid'];
		$id_user	= $this->input->post("id_user",true); //tujuan
		$id			= $session_data['userid']; //dari
		$pesan		= addslashes($this->input->post("pesan",true));
		
		$data	= array(
			'user_from' => $id,
			'user_to' => $id_user,
			'chating_message' => $pesan,
			'chating_date' => date('Y-m-d H:i:s')
		);
		
		$query	=	$this->Komunikasi_m->getInsert($data);
		
		if($query){
			$rs = 1;
		}else{
			$rs	= 2;
		}
		
		echo json_encode(array("result"=>$rs));
			
		
	}

/* ========================================================================================================================================== */
    function forum()
	{			
		$data=array();
		$data['title'] = 'Forum Diskusi';
		
		$session_data = $this->session->userdata;
		$data['userid'] = $session_data['userid'];
		$data['groupid'] = $session_data['groupid'];
		$data['fullname'] = $session_data['fullname'];
		$data['foto'] = $session_data['foto'];
		$data['satkernm'] = $session_data['satkernm'];
		$data['unitkerjanm'] = $session_data['unitkerjanm'];
		$userid = $session_data['userid'];
		$data['notif'] = $this->Notif_m->notification(5,$userid);
		$data['menu'] = $this->Main->menu_backend($session_data['groupid']);
		
		$act = $this->uri->segment(3);
		$where	= ($this->uri->segment(4) != '' ? ' kategori_diskusi_id ='.$this->uri->segment(4).'' : '');
		$url	= ($this->uri->segment(4) != '' ? '/kategori/'.$this->uri->segment(4).'' : '');
		$data['kategori'] = $this->Komunikasi_m->select_table('kategori_diskusi','kategori_diskusi_id');
		$data['cek'] = $this->Komunikasi_m->cek_null_where('diskusi',$where);
		
		//page
		$config = array();
        $config["base_url"] = base_url() . "komunikasi/forum".$url."";
        $config["total_rows"] = $this->Komunikasi_m->record_count($where);
        $config["per_page"] = 10;
        $config["uri_segment"] = ($this->uri->segment(4) != '' ? 5 : 3);
        $config['use_page_numbers'] = TRUE;
        $config['cur_tag_open'] = ' ';
        $config['cur_tag_close'] = '';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $this->pagination->initialize($config);
		$page = 1;
		if($this->uri->segment(3) == 'kategori'){
			if($this->uri->segment(5) != ''){
				$page = $this->uri->segment(5);
			}
		}else{
			if($this->uri->segment(3) != ''){
				$page = $this->uri->segment(3);
			}
		}
		$lwhere = ($where == '' ? '' : 'where '.$where);
		$pagelimit = ($page-1) * $config["per_page"];
        $data["results"] = $this->db->query("SELECT * FROM vwdiskusi ".$lwhere." ORDER BY diskusi_id DESC LIMIT ".$pagelimit.", ".$config["per_page"]."")->result_array();
		$data["links"] = $this->pagination->create_links();
		//page
        if($this->input->post('ajax')) {
			$this->load->view('page/komunikasi/forum/terbaru',$data);
        }else if($this->input->post('ajax1')) {
			$this->load->view('page/komunikasi/forum/jawaban',$data);
        }else {
			$this->load->view('page/komunikasi/forum/index',$data);
		}
		
	}
	
	function topik()
	{	
		$data=array();
	
		$idtopik = $this->uri->segment(3);
		$data['topik'] = $this->Komunikasi_m->topik_id($idtopik);
		
		$this->load->view('page/komunikasi/forum/topik_detail',$data);
		
	}
	
/* ========================================================================================================================================== */

	

	function kritik_saran()
	{			
		
		$data=array();
		$data['title'] = 'Kritik dan Saran';
		
		$session_data = $this->session->userdata;
		$data['userid'] = $session_data['userid'];
		$data['groupid'] = $session_data['groupid'];
		$groupid = $session_data['groupid'];
		$data['fullname'] = $session_data['fullname'];
		$data['foto'] = $session_data['foto'];
		$data['satkernm'] = $session_data['satkernm'];
		$data['unitkerjanm'] = $session_data['unitkerjanm'];
		$userid = $session_data['userid'];
		$data['notif'] = $this->Notif_m->notification(5,$userid);
		$data['menu'] = $this->Main->menu_backend($session_data['groupid']);
		
		$act = $this->uri->segment(3);
		$id = ($this->uri->segment(4) ? $this->uri->segment(4) : 0);
		$data['edit'] = $this->Komunikasi_m->edit_table('kritik_saran','kritik_saran_id',$id);
		
		
		$this->load->view('template/header',$data);
		if(($groupid == 9) or ($groupid == 10)){
			$this->load->view('page/komunikasi/kritik_saran/add',$data);
		}else{
			if($act == ''){
				$this->load->view('page/komunikasi/kritik_saran/index',$data);
			}else{
				$this->load->view('page/komunikasi/kritik_saran/action',$data);
			}
		}
		$this->load->view('template/footer');
		
	}
	function get_kritik_saran()
	{
		
		$result = $this->Komunikasi_m->get_datatables('kritik_saran'); //nama function
		$data = array();
		$i= ($_POST['start']== '' ? 0 : $_POST['start']);
		foreach ($result as $row) {
			$i++;
			$rel = array();
			$rel[] = $i;
			$rel[] = $row->kritik_saran_nama;
			$rel[] = $row->kritik_saran_judul;
			$rel[] = tgl_indo2($row->kritik_saran_tanggal);
			$rel[] = ($row->kritik_saran_status == 'R' ? '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">Read</span>' : '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">Delivered</span>');
			$rel[] = '<a href="'.base_url().'komunikasi/kritik_saran/lihat/'.$row->kritik_saran_id.'" title="Lihat">
						<span class="btn btn-xs btn-info"><i class="icon wb-eye" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>
					  <a href="'.base_url().'act_komunikasi/delete_kritik_saran/'.$row->kritik_saran_id.'" class="del'.$row->kritik_saran_id.'" title="Delete">
						<span class="btn btn-xs btn-danger"><i class="icon wb-trash" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>
					  
					  
					  <script type="text/javascript">
						 
						var elems = document.getElementsByClassName(\'del'.$row->kritik_saran_id.'\');
						var confirmIt = function (e) {
							if (!confirm(\'Yakin Akan Dihapus ?\')) e.preventDefault();
						};
						for (var i = 0, l = elems.length; i < l; i++) {
							elems[i].addEventListener(\'click\', confirmIt, false);
						}
					</script>';
			
			$data[] = $rel;
		}
		
		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Komunikasi_m->count_all('kritik_saran'), //nama tabel
				"recordsFiltered" => $this->Komunikasi_m->count_filtered('kritik_saran'), //nama function
				"data" => $data,
		);
		echo json_encode($output);
	}

	function kontak_kami()
	{			
		
		$data=array();
		$data['title'] = 'Kontak Kami';
		
		$session_data = $this->session->userdata;
		$data['userid'] = $session_data['userid'];
		$data['groupid'] = $session_data['groupid'];
		$groupid = $session_data['groupid'];
		$data['fullname'] = $session_data['fullname'];
		$data['foto'] = $session_data['foto'];
		$data['satkernm'] = $session_data['satkernm'];
		$data['unitkerjanm'] = $session_data['unitkerjanm'];
		$userid = $session_data['userid'];
		$data['notif'] = $this->Notif_m->notification(5,$userid);
		$data['menu'] = $this->Main->menu_backend($session_data['groupid']);
		
		$act = $this->uri->segment(3);
		$id = ($this->uri->segment(4) ? $this->uri->segment(4) : 0);
		$data['edit'] = $this->Komunikasi_m->edit_table('kontak_kami','kontak_kami_id',$id);
		
		
		$this->load->view('template/header',$data);
		if(($groupid == 9) or ($groupid == 10)){
			$this->load->view('page/komunikasi/kontak/add',$data);
		}else{
			if($act == ''){
				$this->load->view('page/komunikasi/kontak/index',$data);
			}else{
				$this->load->view('page/komunikasi/kontak/action',$data);
			}
		}
		$this->load->view('template/footer');
		
	}
	public function data_kontak(){
		
		$session_data = $this->session->userdata;
		$userid = $session_data['userid'];
		
		$result = $this->Komunikasi_m->get_datatables('kontak'); //nama function
		$data = array();
		$i= ($_POST['start']== '' ? 0 : $_POST['start']);
		foreach ($result as $row) {
			$i++;
			$rel = array();
			$rel[] = $i;
			$rel[] = $row->kontak_kami_nama;
			$rel[] = $row->kontak_kami_telepon;
			$rel[] = $row->kontak_kami_email;
			$rel[] = tgl_indo2($row->kontak_kami_tanggal);
			$rel[] = ($row->kontak_kami_status == 'R' ? '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">Read</span>' : '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">Delivered</span>');
			$rel[] = '<a href="'.base_url().'komunikasi/kontak_kami/lihat/'.$row->kontak_kami_id.'" title="Lihat">
						<span class="btn btn-xs btn-info"><i class="icon wb-eye" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>
					  <a href="'.base_url().'act_komunikasi/delete_kontak_kami/'.$row->kontak_kami_id.'" class="del'.$row->kontak_kami_id.'" title="Delete">
						<span class="btn btn-xs btn-danger"><i class="icon wb-trash" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>
					  
					  
					  <script type="text/javascript">
						 
						var elems = document.getElementsByClassName(\'del'.$row->kontak_kami_id.'\');
						var confirmIt = function (e) {
							if (!confirm(\'Yakin Akan Dihapus ?\')) e.preventDefault();
						};
						for (var i = 0, l = elems.length; i < l; i++) {
							elems[i].addEventListener(\'click\', confirmIt, false);
						}
					</script>';
			
			$data[] = $rel;
		}
		
		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Komunikasi_m->count_all('kontak_kami'), //nama tabel
				"recordsFiltered" => $this->Komunikasi_m->count_filtered('kontak'), //nama function
				"data" => $data,
		);
		echo json_encode($output);
	}
	  
}
