<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('notif');
		$this->load->model('Main');	
		$this->load->model('Model_notifikasi','notif');	
		$this->load->library(array('menubackend'));
		cek_aktif();
	}
	public function index(){		
		$data['title'] = 'Pemberitahuan';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		
		$this->load->view('templating/header',$data);
		if(in_array($this->session->userdata('groupid'), array(1,11))){
			$this->load->view('content/notifikasi/notif_admin',$data);
		}else{
			$this->load->view('content/notifikasi/notifikasi_user',$data);
		}
		$this->load->view('templating/footer',$data);
	}
	public function get_notif_user(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$column_search = array('nama_pengirim','nip_pengirim','aktivitas','waktu','status_baca');
		$column_order = array('idnotifikasi','nama_pengirim','nip_pengirim','aktivitas','waktu','status_baca');
		$order = array('waktu' => 'desc');

		$list = $this->notif->get_daftar_notifikasi($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
		foreach ($list as $field){
			$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->nama_pengirim;
			$row[] = $field->nip_pengirim;
			$row[] = $field->aktivitas;
			$row[] = date('d-m-Y H:i', strtotime($field->waktu));

			if($field->status_action == 0)
				$row[] = '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">Belum dibaca</span>';
			else
				$row[] = '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">Sudah dibaca</span>';

			$row[] = '<a href="'.set_link_notif($field->idnotifikasi).'" class="btn btn-primary btn-xs">
						<span class="label label-success">
							<i class="fa fa-eye"></i>
							</span></a>';
			$data[] = $row;
		}
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->notif->total_record('notifikasi'),
            "recordsFiltered" => $this->notif->jumlah_filter_notifikasi($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function get_notifikasi_admin(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$column_search = array('nama_penerima','nip_penerima','aktivitas','waktu','status_baca');
		$column_order = array('idnotifikasi','nama_penerima','nip_penerima','aktivitas','waktu','status_baca');
		$order = array('waktu' => 'desc');

		$list = $this->notif->get_daftar_notifikasi_admin($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
		foreach ($list as $field){
			$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->nama_penerima;
			$row[] = $field->nip_penerima;
			$row[] = $field->aktivitas;
			$row[] = date('d-m-Y H:i', strtotime($field->waktu));

			if($field->status_action == 0)
				$row[] = '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">Belum dibaca</span>';
			else
				$row[] = '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">Sudah dibaca</span>';

			$row[] = '<a href="'.site_url('notifikasi/lihat_sop/'.$field->alias_sop).'" class="btn btn-success btn-xs">
						<span class="label label-success">
							<i class="fa fa-file-text"></i> Lihat SOP
							</span></a>&nbsp;<a href="'.site_url('notifikasi/detail_notif/'.$field->idnotifikasi).'" class="btn btn-primary btn-xs">
						<span class="label label-success">
							<i class="fa fa-eye"></i>
							</span></a>';
			$data[] = $row;
		}
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->notif->total_record('notifikasi'),
            "recordsFiltered" => $this->notif->jumlah_filter_notifikasi_admin($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function history_sop(){
		$id = $this->uri->segment(3);
		$dt_notif = $this->notif->get_data_id('idnotifikasi', $id, 'notifikasi');
		if($dt_notif->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}

		//update notif
		$where['idnotifikasi'] = $id;
		$this->notif->update_status_notif($where);

		//load page history
		$this->load->model('Model_sop','sop');
		$this->load->helper('kegiatan');
		$dt_sop = $this->sop->detail_sop($dt_notif->row()->alias_sop);
		if($dt_sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}

		$data['sop'] = $dt_sop->row();
		$data['history'] = $this->sop->history_sop($dt_notif->row()->alias_sop);
		$data['list_catatan'] = $this->sop->get_list_catatan_review($dt_notif->row()->alias_sop);
		$data['no'] = 1;
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'History SOP';
		$data['back_link'] = site_url('pengolahan_sop');
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/v_history_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function lihat_sop(){
		$alias = $this->uri->segment(3);
		$this->load->model('Model_sop','sop');
		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}

		$data['title'] = 'Daftar SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);

		$data['sop'] = $dt_sop;
		if($dt_sop->row()->sop_update_file == ''){
			if($dt_sop->row()->sop_jml_pelaksana >= 10)
				$data['jmlpel'] = 10;
			else
				$data['jmlpel'] = $dt_sop->row()->sop_jml_pelaksana;

			
			$data['img_chart'] = get_image_node($dt_sop->row()->sop_alias);
			$data['no'] = 1;
			$list_pelaksana = get_list_pelaksana($dt_sop->row()->sop_alias);
			$data['list_singkatan'] = $this->sop->get_daftar_singkatan($list_pelaksana);
		}else{
			$file_pdf = $this->config->item('path_draftpdf').$dt_sop->row()->sop_update_file;
			if(file_exists($file_pdf)){
				$data['file_pdf'] = '<p style="font-size:11pt;">'.$dt_sop->row()->sop_update_file.'&nbsp;&nbsp;<a href="'.site_url('pengolahan_sop/lihat_filesop/'.$alias).'"  target="_blank">Preview</a></p>';
			}else{
				$data['file_pdf'] = '';
			}

			$data['file_draft'] = '';
			if($dt_sop->row()->link_draft_file != ''){
				$data['file_draft'] = '<p style="font-size:11pt;">Link File Draft SOP:&nbsp;<a href="'.$dt_sop->row()->link_draft_file.'" target="_blank">'.$dt_sop->row()->link_draft_file.'</a></p>';
			}else{
				$file_draft = $this->config->item('path_draftword').$dt_sop->row()->sop_draft_file;
				if(file_exists($file_draft) && $dt_sop->row()->sop_draft_file != ''){
					$data['file_draft'] = '<p style="font-size:11pt;">'.$dt_sop->row()->sop_draft_file.'&nbsp;&nbsp;<a href="'.site_url('pengolahan_sop/download_draftsop/'.enkripsi_id_detail($alias)).'">Download</a></p>';
				}
			}
		}

		$data['back_link'] = site_url('notifikasi');
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/detail_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function detail_notif(){
		$id = $this->uri->segment(3);
		$dt_notif = $this->notif->get_data_id('idnotifikasi', $id, 'notifikasi');
		if($dt_notif->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Detail Notifikasi';
		$data['notif'] = $dt_notif->row();
		$this->load->view('templating/header',$data);
		$this->load->view('content/notifikasi/v_detail_notif',$data);
		$this->load->view('templating/footer',$data);
	}
}