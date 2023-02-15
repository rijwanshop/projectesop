<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review_sop extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('tgl_indonesia','notif','kegiatan'));
		$this->load->model('Model_sop','sop');
		$this->load->model('Model_notifikasi','notif');
		$this->load->model('Main');		
		$this->load->library('menubackend');
		date_default_timezone_set('Asia/Jakarta'); 
		cek_aktif();
	}
	public function index(){
		$data['title'] = 'Daftar Permohonan Review SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$this->load->view('templating/header',$data);
		$this->load->view('content/review_sop/data_review_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_data_review(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$column_search = array('a.sop_no','a.sop_nama','z.status_pengajuan','a.sop_step');
		$column_order = array('a.sop_alias','a.sop_no','a.sop_nama','z.tanggal_pengajuan','z.status_pengajuan','a.sop_step','a.sop_update_file');
		$order = array('z.tanggal_pengajuan' => 'desc');

		$list = $this->sop->get_daftar_review_sop($column_search, $column_order, $order);

		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->sop_no;
			$row[] = $field->sop_nama;
			$row[] = date('d-m-Y H:i:s', strtotime($field->tanggal_pengajuan));

			if($field->status_pengajuan == 'diajukan')
				$row[] = '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">Belum</span>';
			elseif ($field->status_pengajuan == 'Diterima') {
				$row[] = '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">Diterima</span>';
			}elseif ($field->status_pengajuan == 'Ditolak') {
				$row[] = '<span class="badge badge-md badge-danger" style="color:#fff; font-size:11px">Ditolak</span>';
			}

			if(in_array($field->sop_step, array('Reviewer','Admin','Sub Admin','Pengesah')))
				$row[] = '<span class="badge badge-md badge-info" style="color:#fff; font-size:11px">'.$field->sop_step.'</span>';
			else
				$row[] = '<span class="badge badge-md badge-danger" style="color:#fff; font-size:11px">Penyusun</span>';

			if($field->sop_update_file == '')
				$row[] = '<span class="badge badge-md badge-primary" style="color:#fff; font-size:11px">Auto</span>';
			else
				$row[] = '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">Manual</span>';
			
			
			$action = '<div class="btn-group">
							<button type="button" class="btn btn-icon btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false" aria-hidden="true">
								Pilih
							</button>
							<div class="dropdown-menu" role="menu" style="font-size:12px">
							<a class="dropdown-item" href="'.site_url('review_sop/detail_sop/'.enkripsi_id_url($field->sop_alias)).'" role="menuitem">
								<i class="icon wb-eye" aria-hidden="true"></i> Lihat
							</a>
							<a class="dropdown-item" href="'.site_url('review_sop/history_sop/'.enkripsi_id_url($field->sop_alias)).'" role="menuitem">
								<i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;History
							</a>';

			if($field->status_pengajuan == 'diajukan'){
				$action .= '<a class="dropdown-item" href="'.site_url('review_sop/edit_sop/'.enkripsi_id_url($field->sop_alias)).'" role="menuitem">
								<i class="icon wb-pencil" aria-hidden="true"></i> Edit
							</a></div>
							</div>&nbsp;
							<a href="'.site_url('review_sop/review_sop/'.enkripsi_id_url($field->idlist_review)).'" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Review</a>';
			}else{
				$action .= '<a class="dropdown-item" href="'.site_url('review_sop/display_catatan/'.enkripsi_id_url($field->idlist_review)).'" role="menuitem">
								<i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Review Saya
							</a></div></div>';
			}

			$row[] = $action;
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->sop->total_record('sop'),
            "recordsFiltered" => $this->sop->jumlah_filter_review_sop($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	private function cek_akses_sop($alias){
		$cek = $this->sop->cek_akses_review($alias);
		if($cek->num_rows() == 0){
			echo 'Akses telah dibatasi';
			exit();
		}
	}
	public function detail_sop(){
		$alias = dekripsi_id_url($this->uri->segment(3));
		if($alias == ''){
			echo 'Akses telah dibatasi';
			exit();
		}

		$data['title'] = 'Daftar SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}

		$this->cek_akses_sop($alias);

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
				$data['file_pdf'] = '<p style="font-size:11pt;">'.$dt_sop->row()->sop_update_file.'&nbsp;&nbsp;<a href="'.site_url('pengolahan_sop/lihat_filesop/'.enkripsi_id_detail($alias)).'"  target="_blank">Preview</a></p>';
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

		$data['back_link'] = site_url('review_sop');
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/detail_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function review_sop(){
		$idreview = dekripsi_id_url($this->uri->segment(3));
		if($idreview == ''){
			echo 'Akses telah dibatasi';
			exit();
		}
		$dt_reviu = $this->sop->get_review_sop($idreview);
		if($dt_reviu->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}

		if($dt_reviu->row()->nipbaru != $this->session->userdata['pegawainip']){
			echo 'Akses telah dibatasi';
			exit();
		}
		if($dt_reviu->row()->status_pengajuan != 'diajukan'){
			echo 'Akses telah dibatasi';
			exit();
		}

		$dt_sop = $this->sop->get_info_sop_review($dt_reviu->row()->sop_alias);
		if($dt_sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}

		$data['list_catatan'] = $this->sop->get_list_catatan_review($dt_reviu->row()->sop_alias, $idreview);
		$data['review'] = $dt_reviu->row();
		$data['sop'] = $dt_sop->row();
		$data['list_review'] = get_list_review($this->session->userdata['pegawainip']);
		$data['no'] = 1;

		if(in_array($dt_sop->row()->satuan_organisasi_id, array('01','02')))
			$data['next'] = 'Sub Admin';
		else
			$data['next'] = 'Admin';
		
		$data['title'] = 'Review SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$this->load->view('templating/header',$data);
		$this->load->view('content/review_sop/v_input_review',$data);
		$this->load->view('templating/footer',$data);
	}
	public function input_review(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'Id', 'trim|required');
		$this->form_validation->set_rules('alias', 'Alias', 'trim|required');
		$this->form_validation->set_rules('nama_sop', 'Nama_sop', 'trim|required');
		$this->form_validation->set_rules('status_pengajuan', 'Status_pengajuan', 'trim|required|in_list[Diterima,Ditolak]');
		$this->form_validation->set_rules('catatan_review', 'Catatan_review', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$validasi = $this->validate_input_review();
			if($validasi){

				//input review SOP
				$data_update = array(
					'status_pengajuan' => trim($this->input->post('status_pengajuan', true)),
					'catatan_review' => trim($this->input->post('catatan_review', true)),
					'tanggal_catatan' => date('Y-m-d H:i:s'),
				);
				$idreview = trim($this->input->post('id', true));
				$this->sop->update_data('idlist_review', $idreview, $data_update, 'list_review_sop');

				//mengembalikan SOP ke penyusun jika ditolak
				$alias = trim($this->input->post('alias', true));
				if($data_update['status_pengajuan'] == 'Ditolak'){
					$data_status = array(
						'sop_status' => 'Draft',
						'sop_step' => '',
					);
					$this->sop->update_data('sop_alias', $alias, $data_status, 'sop');
				}

				//mencatat history Review SOP
				$this->set_history_review_sop($idreview, $data_update['status_pengajuan']);
				$this->set_notifikasi_review_sop($idreview, $data_update['status_pengajuan']);

				if($data_update['status_pengajuan'] == 'Diterima'){

					$data_review = array(
						'sop_alias' => $alias,
						'tanggal_pengajuan' => date('Y-m-d H:i:s'),
						'status_pengajuan' => 'diajukan',
						'indikator' => 1,
					);

					$n_review = $this->sop->total_record('list_review_sop');
					if($n_review == 0){
						$data_review['idlist_review'] = 'RV0000000001';
					}else{
						$dt_rev = $this->sop->get_alias_review();
						$data_review['idlist_review'] = 'RV'.$dt_rev->row()->random_num;
					}

					$teruskan = trim($this->input->post('teruskan_ke', true));
					if(in_array($teruskan, array('Admin','Sub Admin'))){

						//update step SOP
						$this->sop->update_data('sop_alias', $alias, array('sop_step' => $teruskan), 'sop');

						//Pengajuan tinjau ke Admin atau Sub Admin
						$data_review['nama_pereview'] = $teruskan;
						$data_review['nipbaru'] = $teruskan;
						$data_review['jabatan'] = '-';
						$this->sop->insert_data($data_review, 'list_review_sop');

						$this->set_notif_terusan($teruskan, $idreview);
						$this->set_history_terusan($teruskan, $idreview);
					}else{

						//Pengajuan review ke Reviewer Berikutnya
						$data_review['nama_pereview'] = trim($this->input->post('nama_reviewer', true));
						$data_review['nipbaru'] = trim($this->input->post('nip_reviewer', true));
						$data_review['jabatan'] = trim($this->input->post('jabatan', true));
						$this->sop->insert_data($data_review, 'list_review_sop');

						$this->set_notif_terusan($teruskan, $data_review['idlist_review']);
						$this->set_history_terusan($teruskan, $data_review['idlist_review']);
					}

					//disable history review lama
					$this->sop->update_indikator_review($data_review['idlist_review'], $data_review['nipbaru'], $data_review['sop_alias']);
				}

				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data Review SOP anda berhasil disimpan</div>');
				$data_ajax['success'] = true;
			}else{
				$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Input tidak lengkap, silahkan isi semua field</div>';
			}
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Input tidak valid, silahkan isi form dengan benar</div>';
		}
		echo json_encode($data_ajax);
	}
	private function validate_input_review(){
		$status = trim($this->input->post('status_pengajuan', true));
		if($status == 'Ditolak')
			return true;

		if($status != 'Diterima')
			return false;

		$teruskan = trim($this->input->post('teruskan_ke', true));
		if(in_array($teruskan, array('Admin','Sub Admin')))
			return true;
		else if($teruskan == 'Reviewer Lain'){
			$reviewer = trim($this->input->post('nama_reviewer', true));
			$nip_reviewer = trim($this->input->post('nip_reviewer', true));
			$jabatan = trim($this->input->post('jabatan', true));

			if($reviewer != '' && $nip_reviewer != '' && $jabatan != '')
				return true;
			else
				return false;
		}else
			return false;
	}
	private function set_history_review_sop($id, $status){
		$dt_reviu = $this->sop->get_review_sop($id);
		if($dt_reviu->num_rows() > 0){
			$dt_reviu = $dt_reviu->row();
			$data_history = array(
				'judul' => 'Hasil Review SOP',
				'aktivitas' => '[ '.$dt_reviu->nama_pereview.' ][ '.$dt_reviu->nipbaru.' ] telah mereview SOP dengan status '.$status,
				'waktu' => date('Y-m-d H:i:s'),
				'alias_sop' => $dt_reviu->sop_alias,
				'id_data' => $id,
			);

			if($status == 'Diterima'){
				$data_history['icon'] = 'fa fa-check';
				$data_history['warna'] = 'success';
			}else{
				$data_history['icon'] = 'fa fa-remove';
				$data_history['warna'] = 'danger';
			}
			$this->sop->insert_data($data_history, 'history_sop');
		}
	}
	private function set_notifikasi_review_sop($id, $tatus){
		$dt_penyusun = $this->notif->get_info_sop($id);
		if($dt_penyusun->num_rows() > 0){

			$data_notif = array(
				'nama_pengirim' => $this->session->userdata('fullname'),
				'nip_pengirim' => $this->session->userdata('pegawainip'),
				'nama_penerima' => $dt_penyusun->row()->nama_penyusun,
				'nip_penerima'  => $dt_penyusun->row()->nip_penyusun,
				'status_baca' => 'Delivery',
				'status_action' => 0,
				'waktu' => date('Y-m-d H:i:s'),
				'jenis_notif' => 'Status Review',
				'alias_sop' => $dt_penyusun->row()->sop_alias,
			);

			if($tatus == 'Diterima'){
				$data_notif['aktivitas'] = 'Review SOP telah diterima: '.strtoupper($dt_penyusun->row()->sop_nama);
				$data_notif['icon'] = 'fa-check bg-green-600';
			}else if($tatus == 'Ditolak'){
				$data_notif['aktivitas'] = 'Review SOP telah ditolak: '.strtoupper($dt_penyusun->row()->sop_nama);
				$data_notif['icon'] = 'fa-remove bg-red-600';
			}
			$this->sop->insert_data($data_notif, 'notifikasi');

			$where = array(
				'jenis_notif' => 'Pengajuan Review',
				'alias_sop' => $dt_penyusun->row()->sop_alias,
				'nip_penerima' => $this->session->userdata('pegawainip'),
			);
			$this->notif->update_status_notif($where);
		}
	}
	private function set_history_terusan($teruskan, $id){
		$dt_penyusun = $this->notif->get_info_sop($id);
		$dt_reviu = $this->sop->get_review_sop($id);
		if($dt_penyusun->num_rows() > 0 && $dt_reviu->num_rows() > 0){
			$data_history = array(
				'icon' => 'fa fa-send',
				'warna' => 'info',
				'waktu' => date('Y-m-d H:i:s', (time()+3)),
				'alias_sop' => $dt_penyusun->row()->sop_alias,
			);
			if(in_array($teruskan, array('Admin','Sub Admin'))){
				$data_history['judul'] = 'SOP dikirim ke '.$teruskan;
				$data_history['aktivitas'] = '[ '.$this->session->userdata('fullname').' ] [ '.$this->session->userdata('pegawainip').'] telah mengirim SOP ke '.$teruskan;
			}else{
				$data_history['judul'] = 'SOP diteruskan ke Reviewer Lain';
				$data_history['aktivitas'] = '[ '.$this->session->userdata('fullname').' ] [ '.$this->session->userdata('pegawainip').'] telah meneruskan SOP ke Reviewer Lain [ '.$dt_reviu->row()->nama_pereview.' ] [ '.$dt_reviu->row()->nipbaru.' ]';
			}
			$this->sop->insert_data($data_history, 'history_sop');
		}
	}
	private function set_notif_terusan($teruskan, $id){
		$dt_penyusun = $this->notif->get_info_sop($id);
		$dt_reviu = $this->sop->get_review_sop($id);

		if($dt_penyusun->num_rows() > 0 && $dt_reviu->num_rows() > 0){

			$data_notif = array(
				'nama_pengirim' => $this->session->userdata('fullname'),
				'nip_pengirim' => $this->session->userdata('pegawainip'),
				'nama_penerima' => $dt_penyusun->row()->nama_penyusun,
				'nip_penerima' => $dt_penyusun->row()->nip_penyusun,
				'status_baca' => 'Delivery',
				'status_action' => 0,
				'waktu' => date('Y-m-d H:i:s', (time()+2)),
				'jenis_notif' => 'Informasi',
				'alias_sop' => $dt_penyusun->row()->sop_alias,
				'aktivitas' => 'SOP ('.$dt_penyusun->row()->sop_nama.') telah diteruskan ke '.$teruskan,
				'icon' => 'fa-info bg-green-600',
			);
			
			if(in_array($teruskan, array('Admin','Sub Admin'))){

				//notif ke penyusun
				$data_notif['aktivitas'] = 'SOP ('.$dt_penyusun->row()->sop_nama.') telah diteruskan ke '.$teruskan;
				$this->sop->insert_data($data_notif, 'notifikasi');

				//notif ke admin atau sub admin
				$data_notif['nama_penerima'] = lcfirst($teruskan);
				$data_notif['nip_penerima'] = lcfirst($teruskan);
				$data_notif['jenis_notif'] = 'Peninjauan SOP';
				$data_notif['aktivitas'] = 'Perlu ditanjau SOP: '.$dt_penyusun->row()->sop_nama;
				$data_notif['icon'] = 'wb-order bg-green-600';
				$this->sop->insert_data($data_notif, 'notifikasi');

			}else{

				//notif ke penyusun
				$data_notif['aktivitas'] = 'SOP ('.$dt_penyusun->row()->sop_nama.') telah diteruskan ke Reviewer lain ['.$dt_reviu->row()->nama_pereview.' - '.$dt_reviu->row()->nipbaru.']';
				$this->sop->insert_data($data_notif, 'notifikasi');

				//notif ke reviewer selanjutnya
				$data_notif['nama_penerima'] = $dt_reviu->row()->nama_pereview;
				$data_notif['nip_penerima'] = $dt_reviu->row()->nipbaru;
				$data_notif['jenis_notif'] = 'Pengajuan Review';
				$data_notif['aktivitas'] = 'Permohonan Review SOP: '.$dt_penyusun->row()->sop_nama;
				$data_notif['icon'] = 'wb-order bg-green-600';
				$this->sop->insert_data($data_notif, 'notifikasi');
			}
		}
		
	}
	public function edit_sop(){
		$alias = dekripsi_id_url($this->uri->segment(3));
		if($alias == ''){
			echo 'Akses telah dibatasi';
			exit();
		}

		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		$this->cek_akses_sop($alias);

		$arr_nomor = explode('/', $dt_sop->row()->sop_no);
		if(count($arr_nomor) == 2){
			$data['tahun_nomor'] = $arr_nomor[1]; 
		}else{
			$data['tahun_nomor'] = date('Y');
		}

		$data['keterkaitan'] = '';
		if($dt_sop->row()->sop_keterkaitan != ''){

			$list = explode('<br>', $dt_sop->row()->sop_keterkaitan);
			for($i=0; $i<count($list); $i++){
				if($list[$i] != ''){
					$a = str_replace(($i+1).'.', '', $list[$i]);
					$data['keterkaitan'] .= '<tr>';
					$data['keterkaitan'] .= '<td>'.($i+1).'</td>';
					$data['keterkaitan'] .= '<td>'.$a.'</td>';
					$data['keterkaitan'] .= '<td><a href="#" class="btn btn-icon btn-xs btn-danger" id="remove-terkait"><i class="fa fa-remove"></i></a></td>';
					$data['keterkaitan'] .= '<td style="display:none;"></td>';
					$data['keterkaitan'] .= '</tr>';

				}
			}
		}

		$data['title'] = 'Edit Daftar SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		
		
		$data['list_pengesah'] = get_list_pengesah();
		
		$data['sop'] = $this->sop->detail_sop($alias);
		$data['arr_sop'] = $this->sop->detail_sop($alias)->result_array();
		$data['idx'] = 0;
		$data['dt_singkatan'] = $this->sop->list_singkatan_jabatan();
		$data['back_link'] = site_url('review_sop');
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/v_edit_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function history_sop(){
		$alias = dekripsi_id_url($this->uri->segment(3));
		if($alias == ''){
			echo 'Akses telah dibatasi';
			exit();
		}

		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		$this->cek_akses_sop($alias);

		$data['sop'] = $dt_sop->row();
		$data['history'] = $this->sop->history_sop($alias);
		$data['list_catatan'] = $this->sop->get_list_catatan_review($alias);
		$data['no'] = 1;
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'History SOP';
		$data['back_link'] = site_url('review_sop');
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/v_history_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function display_catatan(){
		$idreview = dekripsi_id_url($this->uri->segment(3));
		if($idreview == ''){
			echo 'Akses telah dibatasi';
			exit();
		}
		$dt_reviu = $this->sop->get_data_id('idlist_review', $idreview, 'list_review_sop');
		if($dt_reviu->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		if($dt_reviu->row()->nipbaru != $this->session->userdata['pegawainip']){
			echo 'Akses telah dibatasi';
			exit();
		}
		$data['review'] = $dt_reviu->row();
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Review SOP';
		$this->load->view('templating/header',$data);
		$this->load->view('content/review_sop/v_review_saya',$data);
		$this->load->view('templating/footer',$data);
	}
}