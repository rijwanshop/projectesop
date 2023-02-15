<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengesah_sop extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('tgl_indonesia','notif','kegiatan'));
		$this->load->model('Main');
		$this->load->library('menubackend');
		$this->load->model('Model_admin_sop','admin');
		$this->load->model('Model_sop','sop');
		$this->load->model('Model_notifikasi','notif');
		date_default_timezone_set('Asia/Jakarta'); 
		cek_aktif(); 
	}
	public function index(){
		$data['title'] = 'Pengesahan SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$this->load->view('templating/header',$data);
		$this->load->view('content/admin_sop/daftar_pengesahan_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_daftar_pengesahan(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$column_search = array('sop_no','sop_nama','sop_tgl_pembuatan');
		$column_order = array('b.tanggal_pengajuan','a.sop_no','a.sop_nama','a.sop_tgl_pembuatan','a.sop_status','a.sop_step','a.sop_update_file');
		$order = array('b.tanggal_pengajuan' => 'desc');

		$list = $this->admin->get_daftar_pengesah_sop($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
		foreach ($list as $field){
			$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->sop_no;
			$row[] = $field->sop_nama;
			$row[] = date('d-m-Y H:i:s', strtotime($field->tanggal_pengajuan));

			if($field->sop_status == 'Draft')
				$row[] = '<span class="badge badge-md badge-danger" style="color:#fff; font-size:11px">'.$field->sop_status.'</span>';
			else if($field->sop_status == 'Draft Revisi' || $field->sop_status == 'Pending')
				$row[] = '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">'.$field->sop_status.'</span>';
			else
				$row[] = '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">'.$field->sop_status.'</span>';

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
							<a class="dropdown-item" href="'.site_url('pengesah_sop/detail_sop/'.enkripsi_id_url($field->sop_alias)).'" role="menuitem">
								<i class="icon wb-eye" aria-hidden="true"></i> Lihat
							</a>
							<a class="dropdown-item" href="'.site_url('pengesah_sop/history_sop/'.enkripsi_id_url($field->sop_alias)).'" role="menuitem">
								<i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;History
							</a>';

			if($field->sop_status == 'Disahkan'){
				$action .= '</div></div>&nbsp;<a href="'.site_url('pengesah_sop/view_file/'.enkripsi_id_url($field->sop_alias)).'" class="btn btn-xs btn-success" target="_blank">
						<i class="fa fa-file-text"></i> File SOP
					</a>';

			}else{
				if($field->sop_step == 'Pengesah'){
					$action .= '<a class="dropdown-item" href="'.site_url('pengesah_sop/edit_sop/'.enkripsi_id_url($field->sop_alias)).'" role="menuitem">
								<i class="icon wb-pencil" aria-hidden="true"></i> Edit
							</a>
							<a class="dropdown-item" href="'.site_url('pengesah_sop/tolak_sop/'.enkripsi_id_url($field->idlist_review)).'" role="menuitem">
								<i class="fa fa-remove" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Tolak SOP
							</a>
						</div>
					</div>&nbsp;<a href="'.site_url('pengesah_sop/tanda_tangan_sop/'.enkripsi_id_url($field->idlist_review)).'" class="btn btn-xs btn-warning">
						<i class="fa fa-edit"></i> TTE
					</a>';
				}else{
					$action .= '</div></div>';
				}
				
			}

			$row[] = $action;
			$row[] = $field->sop_label;

			$data[] = $row;
		}
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->admin->total_record('sop'),
            "recordsFiltered" => $this->admin->jumlah_filter_daftar_pengesah_sop($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	private function cek_akses_sop($alias){
		$cek = $this->admin->cek_pengesah($alias);
		if($cek->num_rows() == 0){
			echo 'Akses telah dibatasi';
			exit();
		}
	}
	public function tolak_sop(){
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
		$dt_sop = $this->sop->get_info_sop_review($dt_reviu->row()->sop_alias);
		if($dt_sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}

		$data['input_post'] = site_url('pengesah_sop/input_tolak');
		$data['back_link'] = site_url('pengesah_sop');
		$data['list_catatan'] = $this->sop->get_list_catatan_review($dt_reviu->row()->sop_alias);
		$data['no'] = 1;
		$data['sop'] = $dt_sop->row();
		$data['review'] = $dt_reviu->row();
		$data['title'] = 'Penolakan Daftar SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$this->load->view('templating/header',$data);
		$this->load->view('content/admin_sop/v_tolak_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function input_tolak(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('alias', 'Alias', 'trim|required');
		$this->form_validation->set_rules('id', 'Id', 'trim|required');
		$this->form_validation->set_rules('nama_sop', 'Nama_sop', 'trim|required');
		$this->form_validation->set_rules('catatan_review', 'Catatan_review', 'trim|required');
		if($this->form_validation->run() == TRUE){

			//input Review Pengesah
			$data_update = array(
				'status_pengajuan' => 'Ditolak',
				'catatan_review' => trim($this->input->post('catatan_review', true)),
				'tanggal_catatan' => date('Y-m-d H:i:s'),
			);
			$idreview = trim($this->input->post('id', true));
			$this->sop->update_data('idlist_review', $idreview, $data_update, 'list_review_sop');

			//mengembalikan SOP ke Penyusun
			$alias = trim($this->input->post('alias', true));
			$data_status = array(
				'sop_status' => 'Draft',
				'sop_step' => '',
			);
			$this->sop->update_data('sop_alias', $alias, $data_status, 'sop');

			//buat history dan Notifikasi
			$this->set_history_pengesah($idreview, 'Ditolak');
			$this->set_notif_pengesah($idreview, 'Ditolak');

			$data_ajax['success'] = true;
			$this->session->set_flashdata('message', 'Anda berhasil menolak Pengesahan SOP');
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Penolakan SOP gagal, silahkan isi catatan terlebih dahulu</div>';
		}
		echo json_encode($data_ajax);
	}
	public function set_history_pengesah($id, $status){
		$dt_reviu = $this->sop->get_review_sop($id);
		$dt_penyusun = $this->notif->get_info_sop($id);
		if($dt_reviu->num_rows() > 0 && $dt_penyusun->num_rows() > 0){
			$dt_reviu = $dt_reviu->row();
			$data_history = array(
				'judul' => 'Pengesahan SOP',
				'waktu' => date('Y-m-d H:i:s'),
				'alias_sop' => $dt_reviu->sop_alias,
				'id_data' => $id,
			);

			if($status == 'Ditolak'){
				$data_history['icon'] = 'fa fa-remove';
				$data_history['warna'] = 'danger';
				$data_history['aktivitas'] = 'Pengesah [ '.$dt_reviu->nama_pereview.' ][ '.$dt_reviu->nipbaru.' ] telah menolak dan mengembalikan SOP ke Penyusun [ '.$dt_penyusun->row()->nama_penyusun.' ] [ '.$dt_penyusun->row()->nip_penyusun.' ]';
			}elseif($status == 'Disahkan'){
				$data_history['icon'] = 'fa fa-check';
				$data_history['warna'] = 'success';
				$data_history['aktivitas'] = 'Pengesah [ '.$dt_reviu->nama_pereview.' ][ '.$dt_reviu->nipbaru.' ] telah menandatangani SOP';
			}
			$this->sop->insert_data($data_history, 'history_sop');
		}
	}
	public function set_notif_pengesah($id, $tatus){
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
				'alias_sop' => $dt_penyusun->row()->sop_alias,
			);

			if($tatus == 'Disahkan'){
				$data_notif['jenis_notif'] = 'Informasi Pengesahan';
				$data_notif['aktivitas'] = 'SOP ( '.strtoupper($dt_penyusun->row()->sop_nama).') telah disahkan';
				$data_notif['icon'] = 'fa-check bg-green-600';

				//update notif pengesah
				$where = array(
					'jenis_notif' => 'Pengesahan SOP',
					'alias_sop' => $dt_penyusun->row()->sop_alias,
					'nip_penerima' => $this->session->userdata('pegawainip'),
				);
				$this->notif->update_status_notif($where);

			}else if($tatus == 'Ditolak'){
				$data_notif['jenis_notif'] = 'Informasi';
				$data_notif['aktivitas'] = 'Pengesahan SOP telah ditolak: '.strtoupper($dt_penyusun->row()->sop_nama);
				$data_notif['icon'] = 'fa-remove bg-red-600';
			}
			$this->sop->insert_data($data_notif, 'notifikasi');

			$where = array(
				'jenis_notif' => 'Pengesahan SOP',
				'alias_sop' => $dt_penyusun->row()->sop_alias,
				'nip_penerima' => $this->session->userdata('pegawainip'),
			);
			$this->notif->update_status_notif($where);
		}
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
		$data['back_link'] = site_url('pengesah_sop');
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/v_history_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function detail_sop(){
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

		$data['back_link'] = site_url('pengesah_sop');
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/detail_sop',$data);
		$this->load->view('templating/footer',$data);
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
		
		$data['satorg_id'] = $dt_sop->row()->satuan_organisasi_id;
		$data['deputi_id'] = $dt_sop->row()->deputi_id;
		$data['biro_id'] = $dt_sop->row()->unit_kerja_id;
		
		$data['sop'] = $this->sop->detail_sop($alias);
		$data['arr_sop'] = $this->sop->detail_sop($alias)->result_array();
		$data['idx'] = 0;
		$data['dt_singkatan'] = $this->admin->get_singkatan_jabatan($dt_sop->row()->satuan_organisasi_id, $dt_sop->row()->deputi_id, $dt_sop->row()->unit_kerja_id);
		$data['back_link'] = site_url('pengesah_sop');
		$this->load->view('templating/header',$data);
		$this->load->view('content/admin_sop/v_edit_admin',$data);
		$this->load->view('templating/footer',$data);
	}
	public function tanda_tangan_sop(){
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
		$sop = $this->sop->detail_sop($dt_reviu->row()->sop_alias);
		if($sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		$this->cek_akses_sop($dt_reviu->row()->sop_alias);

		$file_merge = $this->config->item('path_exportpdf').'merger_'.$dt_reviu->row()->sop_alias.'.pdf';
		if(!file_exists($file_merge)){
			echo 'File PDF tidak ditemukan';
			exit();
		}

		$data['id'] = $idreview;
		$data['sop'] = $sop;
		$data['title'] = 'Pengesahan SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$this->load->view('templating/header',$data);
		$this->load->view('content/pengesahan_sop/v_tanda_tangan',$data);
		$this->load->view('templating/footer',$data);
	}
	public function preview_pdf(){
		$alias = dekripsi_id_url($this->uri->segment(3));
		$sop = $this->sop->detail_sop($alias);
		if($sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		$file_merge = $this->config->item('path_exportpdf').'merger_'.$alias.'.pdf';
		if(file_exists($file_merge)){
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="'.$file_merge.'"');
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');
			@readfile($file_merge);
		}else{
			echo 'File tidak ditemukan';
			exit();
		}
	}
	public function pengesahan_sop(){
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('alias', 'Alias', 'trim|required');
		$this->form_validation->set_rules('id', 'Id', 'trim|required');
		$this->form_validation->set_rules('nik', 'Nik', 'trim|required');
		$this->form_validation->set_rules('passphrase', 'Passphrase', 'trim|required');
		if($this->form_validation->run() == TRUE){

			$alias = trim($this->input->post('alias', true));
			$sop = $this->sop->detail_sop($alias);
			if($sop->num_rows() == 0){
				$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data SOP tidak ditemukan</div>';
				echo json_encode($data_ajax);
				exit();
			}

			//indexing ulang nomor SOP
			$this->set_nomor($alias);

			//generate ulang file PDF
			$this->load->helper('eksport');
			eksport_header($alias);
			merge_pdf($alias);

			$nik = trim($this->input->post('nik', true));
			$passphrase = trim($this->input->post('passphrase', true));
			$file_merge = $this->config->item('path_exportpdf').'merger_'.$alias.'.pdf';

			if(file_exists($file_merge)){
				$tte = $this->tte_pdf($file_merge, $nik, $passphrase, $alias);
				if($tte){
					

					//update status SOP
					$data_update = array(
						'sop_status' => 'Disahkan',
						'sop_tgl_efektif' => tgl_indo(date('d-m-Y')),
						'tgl_efektif' => date('Y-m-d'),
						'sop_pengesah_nama' => $this->session->userdata('fullname'),
					);

					if($sop->row()->sop_label == 'sop lama'){
						$tanggal = trim($this->input->post('tanggal_penerbitan', true));
						$data_update['sop_tgl_efektif'] = tgl_indo($tanggal);
						$data_update['tgl_efektif'] = date('Y-m-d', strtotime($tanggal));
					}
		
					$this->sop->update_data('sop_alias', $alias, $data_update, 'sop');

					//update status Review SOP
					$data_review = array(
						'status_pengajuan' => 'Disahkan',
						'catatan_review' => 'SOP telah disahkan',
						'tanggal_catatan' => date('Y-m-d H:i:s'),
					);
					$idreview = trim($this->input->post('id', true));
					$this->sop->update_data('idlist_review', $idreview, $data_review, 'list_review_sop');

					//buat history dan Notifikasi
					$this->set_history_pengesah($idreview, 'Disahkan');
					$this->set_notif_pengesah($idreview, 'Disahkan');

					$this->session->set_flashdata('message', 'SOP berhasil disahkan');
					$data_ajax['success'] = true;
				}else{
					$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Proses TTE gagal, silahkan coba lagi</div>';
				}
			}else{
				$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Proses TTE gagal, Silahkan lakukan eksport PDF terlebih dahulu</div>';
			}

		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Silahkan melengkapi form</div>';
		}
		echo json_encode($data_ajax);
	}
	private function tte_pdf($file_pdf, $nik, $passphrase, $alias){
		$this->config->load('esign');

		if($this->config->item('switch_production') == false){
			$nik = $this->config->item('nik');
			$passphrase = $this->config->item('passphrase');
		}

		$curl = curl_init();

		$link_qr =  'https://verifikasitte.setneg.go.id/sop/kode/'.enkripsi_id_detail($alias);
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->config->item('api_esign').'api/sign/pdf',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_SSL_VERIFYHOST => FALSE,
        	CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($file_pdf, 'application/pdf', 'tespict'),'nik' => $nik,'passphrase' => $passphrase,'tampilan' => 'visible','halaman' => 'pertama','image' => 'false','linkQR' => $link_qr,'xAxis' => '645','yAxis' => '425','width' => '530','height' => '485'),
			CURLOPT_HTTPHEADER => array(
				'Authorization: Basic '.base64_encode($this->config->item('api_esign_username').':'.$this->config->item('api_esign_password'))
			),
		));

		$response = curl_exec($curl);
		$info = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		if($info == 200){
			unlink($file_pdf);
			$file_pdf = $this->config->item('path_exportpdf').'sop_tte_'.$alias.'.pdf';
			if(file_exists($file_pdf)){
				unlink($file_pdf);
			}
			file_put_contents($file_pdf, $response);
			return true;		
		}
		return false;
	}
	private function set_nomor($alias){
		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			return false;
		}

		$satorg = $dt_sop->row()->satuan_organisasi_id;
		$deputi = $dt_sop->row()->deputi_id;
		$biro = $dt_sop->row()->unit_kerja_id;
		$dt_tahun = $dt_sop->row()->sop_tgl_pembuatan;
		$pecah = explode(' ', $dt_tahun);
		$tahun = $pecah[2];
		$cek = $this->sop->no_urut_sop($satorg, $deputi, $biro, $tahun);
		if($cek->num_rows() == 0){
			$data_update = array(
				'sop_no' => '1/'.$tahun,
				'sop_nourut' => 1,
				'sop_index' => $tahun.'1',
			);
			$this->sop->update_data('sop_alias', $alias, $data_update, 'sop');
		}else{
			$data_update = array(
				'sop_no' => ($cek->row()->sop_nourut+1).'/'.$tahun,
				'sop_nourut' => ($cek->row()->sop_nourut+1),
				'sop_index' => $tahun.($cek->row()->sop_nourut+1),
			);
			$this->sop->update_data('sop_alias', $alias, $data_update, 'sop');
		}
		return true;
	}
	
	public function view_file(){
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

		$file_pdf = $this->config->item('path_exportpdf').'sop_tte_'.$alias.'.pdf';
		if (!file_exists($file_pdf)){
			echo 'File PDF yang di TTE tidak ditemukan';
			exit();
		}
		header('Content-type: application/pdf'); 
		header('Content-Disposition: inline; filename="SOP '.$alias.'"'); 
		header('Content-Transfer-Encoding: binary'); 
		header('Accept-Ranges: bytes');  
		@readfile($file_pdf); 
	}
	
	/*
	public function tes(){
		$alias = '6915847329';
		$nik = '0803202100007062';
		$passphrase = '!Bsre1234*';
		$this->load->helper('eksport');
		merge_pdf($alias);
		$file_merge = $this->config->item('path_exportpdf').'merger_'.$alias.'.pdf';
		if(file_exists($file_merge)){
			echo 'File PDF '.$file_merge.'<br>';
		}
		$this->tte_pdf($file_merge, $nik, $passphrase, $alias);
	}
	*/
	
	
	

	//hanya untuk pengecekan TTE
	public function tes_tte(){
		$alias = $this->uri->segment(3);
		$sop = $this->sop->detail_sop($alias);
		if($sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}

		$file = $this->config->item('path_exportpdf').'merger_'.$alias.'.pdf';
		if(!file_exists($file)){
			$this->generate_file_pdf($alias);
		}
		echo 'PDF File: '.$file.'<br><br>';

		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://esign2-dev.setneg.go.id/api/sign/pdf',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_SSL_VERIFYHOST => FALSE,
        CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($file),'nik' => '0803202100007062','passphrase' => '#1234Qwer*','tampilan' => 'visible','halaman' => 'pertama','image' => 'false','linkQR' => 'https://google.com','xAxis' => '100','yAxis' => '100','width' => '200','height' => '100'),
		CURLOPT_HTTPHEADER => array(
			'Authorization: Basic bGF0aWhhbjpsYXRpaGFuQDIwMjA='
		),
		));


		if(curl_exec($curl) === false)
		{
			echo 'Curl error: ' . curl_error($curl);
		}
		else
		{
			echo 'Operation completed without any errors';
		}

		// Close handle
		curl_close($curl);



	}
}
