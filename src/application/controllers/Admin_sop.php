<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_sop extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('tgl_indonesia','notif','kegiatan'));
		$this->load->model('Main');
		$this->load->library('menubackend');
		$this->load->model('Model_admin_sop','admin');
		$this->load->model('Model_sop','sop');
		$this->load->model('Model_pencarian','pencarian');	
		$this->load->model('Model_notifikasi','notif');
		date_default_timezone_set('Asia/Jakarta'); 
		cek_aktif(); 
		cek_admin();
	}
	public function index(){
		$data['title'] = 'Daftar SOP Masuk';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$this->load->view('templating/header',$data);
		$this->load->view('content/admin_sop/daftar_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_daftar_sop(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$column_search = array('a.sop_no','a.sop_nama','b.status_pengajuan','a.sop_step');
		$column_order = array('a.sop_alias','a.sop_no','a.sop_nama','b.tanggal_pengajuan','b.status_pengajuan','a.sop_step','a.sop_update_file');
		$order = array('b.tanggal_pengajuan' => 'desc');

		$list = $this->admin->get_daftar_sop($column_search, $column_order, $order);
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
							<a class="dropdown-item" href="'.site_url('admin_sop/detail_sop/'.enkripsi_id_url($field->sop_alias)).'" role="menuitem">
								<i class="icon wb-eye" aria-hidden="true"></i> Lihat
							</a>
							<a class="dropdown-item" href="'.site_url('admin_sop/history_sop/'.enkripsi_id_url($field->sop_alias)).'" role="menuitem">
								<i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;History
							</a>';

			if($field->status_pengajuan == 'diajukan'){
				$action .= '<a class="dropdown-item" href="'.site_url('admin_sop/edit_sop/'.enkripsi_id_url($field->sop_alias)).'" role="menuitem">
								<i class="icon wb-pencil" aria-hidden="true"></i> Edit
							</a>
							</div>
							</div>&nbsp;
							<a href="'.enkripsi_id_url($field->idlist_review).'" class="btn btn-xs btn-success" id="btn-terima">
						<i class="fa fa-check"></i>Sudah Benar
					</a>&nbsp;
					<a href="'.site_url('admin_sop/tolak/'.enkripsi_id_url($field->idlist_review)).'" class="btn btn-xs btn-danger">
						<i class="fa fa-remove"></i>Tolak
					</a>';
			}else{
				$action .= '</div></div>';
			}

			$row[] = $action;
			$data[] = $row;
		}
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->admin->total_record('sop'),
            "recordsFiltered" => $this->admin->jumlah_filter_daftar_sop($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
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

		$data['back_link'] = site_url('admin_sop');
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
		$data['back_link'] = site_url('admin_sop');
		$this->load->view('templating/header',$data);
		$this->load->view('content/admin_sop/v_edit_admin',$data);
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

		$data['sop'] = $dt_sop->row();
		$data['history'] = $this->sop->history_sop($alias);
		$data['list_catatan'] = $this->sop->get_list_catatan_review($alias);
		$data['no'] = 1;
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'History SOP';
		$data['back_link'] = site_url('admin_sop');
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/v_history_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_list_sop_terkait(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$search = trim($this->input->get('search', true));
		$unit_kerja = trim($this->input->get('unit_kerja', true));
		$result = $this->admin->get_list_sop($search, $unit_kerja);
		$response = array();
		foreach($result->result() as $row){
            $response[] = array(
                'label' => $row->sop_nama,
                'link' => $row->sop_alias,
            );
        }
        echo json_encode($response);
	}
	public function get_pengesah(){
		$data_option = array();
		$satorg = trim($this->input->get('satorg', true));
		$deputi = trim($this->input->get('deputi', true));
		$biro = trim($this->input->get('biro', true));

		if(!in_array($satorg, array('01','02'))){
			$form_data = array(
        		'satorg' => $satorg,
        		'deputi' => $biro,
    		);
		}else{
			$form_data = array(
        		'satorg' => $satorg,
        		'deputi' => $deputi,
        		'biro' => $biro,
    		);
		}

		$url_data = http_build_query($form_data);
		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => 'https://api-dev.setneg.go.id/pegawai/esop/pengesah?'.$url_data,
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => "",
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 0,
  			//CURLOPT_FOLLOWLOCATION => true,
  			//CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => "GET",
  			CURLOPT_SSL_VERIFYHOST => FALSE,
          	CURLOPT_SSL_VERIFYPEER => false,
  			CURLOPT_HTTPHEADER => array(
    			'Authorization: Basic b3ByX2Vzb3A6b3ByX2Vzb3BAMjAyMA=='
  			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$resArray = json_decode($response, true);
		if($resArray['status'] == 'OK' && $resArray['data'] != null){
			foreach ($resArray['data'] as $row){ 
				$data_option[] = array(
					'nipbaru' => $row['nipbaru'],
					'nama_pegawai' => $row['nmpeg'],
					'jabatan' => $row['jabatanakhir'],
					'satorg' => $row['satorg'],
					'deputi' => $row['deputi'],
					'biro' => $row['biro'],
				);
			}
		}
		echo json_encode($data_option);
	}
	
	private function get_user_group(){
		$grup = '';
		if(in_array($this->session->userdata['groupid'], array(11,1)))
			$grup = 'admin';
		else if($this->session->userdata['groupid'] == 12)
			$grup = 'sub admin';

		return $grup;
	}
	public function terima(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$idreview = trim($this->input->post('id', true));
		$idreview = dekripsi_id_url($idreview);
		if($idreview == ''){
			$data_ajax['message'] = 'Akses telah dibatasi';
			echo json_encode($data_ajax);
			exit();
		}

		$dt_reviu = $this->sop->get_review_sop($idreview);
		if($dt_reviu->num_rows() == 0){
			$data_ajax['message'] = 'Data SOP tidak ditemukan';
			echo json_encode($data_ajax);
			exit();
		}
		$sop = $this->sop->detail_sop($dt_reviu->row()->sop_alias);
		if($sop->num_rows() == 0){
			$data_ajax['message'] = 'Data SOP tidak ditemukan';
			echo json_encode($data_ajax);
			exit();
		}

		//input Review Admin atau Sub Admin
		$data_update = array(
			'status_pengajuan' => 'Diterima',
			'catatan_review' => '-',
			'tanggal_catatan' => date('Y-m-d H:i:s'),
		);	
		$this->sop->update_data('idlist_review', $idreview, $data_update, 'list_review_sop');

		//buat history dan notif
		$this->set_history_sop($idreview, 'Diterima');
		$this->set_notifikasi_admin($idreview, 'Diterima');

		//teruskan SOP ke Admin atau Pengesah
		if($sop->row()->sop_step == 'Sub Admin'){
			$terusan = 'Admin';
		}elseif($sop->row()->sop_step == 'Admin'){
			$terusan = 'Pengesah';
		}else{
			$terusan = '';
		}
		$this->sop->update_data('sop_alias', $dt_reviu->row()->sop_alias, array('sop_step' => $terusan), 'sop');

		//buat Pengajuan Review Baru
		$data_review = array(
			'sop_alias' => $dt_reviu->row()->sop_alias,
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

		if($sop->row()->sop_step == 'Sub Admin'){
			$data_review['nama_pereview'] = 'Admin';
			$data_review['nipbaru'] = 'Admin';
			$data_review['jabatan'] = '-';
		}elseif($sop->row()->sop_step == 'Admin'){
			$data_review['nama_pereview'] = $sop->row()->sop_disahkan_nama;
			$data_review['nipbaru'] = $sop->row()->sop_disahkan_nip;
			$data_review['jabatan'] = $sop->row()->sop_disahkan_jabatan;
		}
		$this->sop->insert_data($data_review, 'list_review_sop');

		//disable history review lama
		$this->sop->update_indikator_review($data_review['idlist_review'], $data_review['nipbaru'], $data_review['sop_alias']);

		//buat history dan notif
		$this->set_history_terusan($terusan, $data_review['idlist_review']);
		$this->set_notif_terusan($terusan, $data_review['idlist_review']);

		$data_ajax['success'] = true;
		$data_ajax['message'] = '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data sop berhasil diteruskan ke '.$terusan.'</div>';
		echo json_encode($data_ajax);
	}
	public function tolak(){
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
		$dt_sop = $this->sop->get_info_sop_review($dt_reviu->row()->sop_alias);
		if($dt_sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}

		$data['input_post'] = site_url('admin_sop/input_tolak');
		$data['back_link'] = site_url('admin_sop');
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

			//input Review Admin atau Sub Admin
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

			//buat history dan notif
			$this->set_history_sop($idreview, 'Ditolak');
			$this->set_notifikasi_admin($idreview, 'Ditolak');

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data Peninjauan SOP anda berhasil disimpan</div>');
			$data_ajax['success'] = true;
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Penolakan SOP gagal, silahkan isi catatan terlebih dahulu</div>';
		}
		echo json_encode($data_ajax);
	}
	private function set_history_sop($id, $status){
		$dt_reviu = $this->sop->get_review_sop($id);
		if($dt_reviu->num_rows() > 0){
			$dt_reviu = $dt_reviu->row();
			$data_history = array(
				'judul' => 'Hasil Peninjauan SOP',
				'aktivitas' => $dt_reviu->nama_pereview.' telah meninjau SOP dengan status '.$status,
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
	private function set_notifikasi_admin($id, $tatus){
		$dt_penyusun = $this->notif->get_info_sop($id);
		$dt_reviu = $this->sop->get_review_sop($id);
		if($dt_penyusun->num_rows() > 0 && $dt_reviu->num_rows() > 0){

			$data_notif = array(
				'nama_pengirim' => $this->get_user_group(),
				'nip_pengirim' => $this->get_user_group(),
				'nama_penerima' => $dt_penyusun->row()->nama_penyusun,
				'nip_penerima'  => $dt_penyusun->row()->nip_penyusun,
				'status_baca' => 'Delivery',
				'status_action' => 0,
				'waktu' => date('Y-m-d H:i:s'),
				'jenis_notif' => 'Informasi',
				'alias_sop' => $dt_penyusun->row()->sop_alias,
			);

			if($tatus == 'Diterima'){
				$data_notif['aktivitas'] = $dt_reviu->row()->nama_pereview.' telah menerima peninjauan SOP: '.strtoupper($dt_penyusun->row()->sop_nama);
				$data_notif['icon'] = 'fa-check bg-green-600';
			}else if($tatus == 'Ditolak'){
				$data_notif['aktivitas'] = $dt_reviu->row()->nama_pereview.' telah menolak peninjauan SOP: '.strtoupper($dt_penyusun->row()->sop_nama);
				$data_notif['icon'] = 'fa-remove bg-red-600';
			}
			$this->sop->insert_data($data_notif, 'notifikasi');

			$where = array(
				'jenis_notif' => 'Peninjauan SOP',
				'alias_sop' => $dt_penyusun->row()->sop_alias,
				'nip_penerima' => $this->get_user_group(),
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
				'judul' => 'SOP dikirim ke '.$teruskan,
			);
			if($teruskan == 'Admin'){
				$data_history['aktivitas'] = 'Sub Admin telah mengirim SOP ke Admin';
			}elseif($teruskan == 'Pengesah'){
				$data_history['aktivitas'] = 'Admin telah mengirim SOP ke Pengesah [ '.$dt_reviu->row()->nama_pereview.' ][ '.$dt_reviu->row()->nipbaru.' ]';
			}
			$this->sop->insert_data($data_history, 'history_sop');
		}
	}
	private function set_notif_terusan($teruskan, $id){
		$dt_penyusun = $this->notif->get_info_sop($id);
		$dt_reviu = $this->sop->get_review_sop($id);
		if($dt_penyusun->num_rows() > 0 && $dt_reviu->num_rows() > 0){

			$data_notif = array(
				'nama_pengirim' => $this->get_user_group(),
				'nip_pengirim' => $this->get_user_group(),
				'status_baca' => 'Delivery',
				'status_action' => 0,
				'waktu' => date('Y-m-d H:i:s', (time()+2)),
				'alias_sop' => $dt_penyusun->row()->sop_alias,
				'icon' => 'wb-order bg-green-600',
			);
			if($teruskan == 'Admin'){
				//buat notif ke admin
				$data_notif['nama_penerima'] = 'admin';
				$data_notif['nip_penerima'] = 'admin';
				$data_notif['jenis_notif'] = 'Peninjauan SOP';
				$data_notif['aktivitas'] = 'Perlu ditanjau SOP: '.$dt_penyusun->row()->sop_nama;
				$this->sop->insert_data($data_notif, 'notifikasi');

			}elseif($teruskan == 'Pengesah'){
				//buat notif ke Pengesah
				$data_notif['nama_penerima'] = $dt_reviu->row()->nama_pereview;
				$data_notif['nip_penerima'] = $dt_reviu->row()->nipbaru;
				$data_notif['jenis_notif'] = 'Pengesahan SOP';
				$data_notif['aktivitas'] = 'Perlu disahkan SOP: '.$dt_penyusun->row()->sop_nama;
				$this->sop->insert_data($data_notif, 'notifikasi');
			}
			
			//notif ke Penyusun
			$data_notif['nama_penerima'] = $dt_penyusun->row()->nama_penyusun;
			$data_notif['nip_penerima'] = $dt_penyusun->row()->nip_penyusun;
			$data_notif['jenis_notif'] = 'Informasi';
			$data_notif['aktivitas'] = 'SOP ('.$dt_penyusun->row()->sop_nama.') telah diteruskan ke '.$teruskan;
			$data_notif['icon'] = 'fa-info bg-green-600';
			$this->sop->insert_data($data_notif, 'notifikasi');
		}
	}


	//-- Publush dan Unpublish SOP -- //
	public function pencabutan_sop(){
		$dt_tgl = $this->pencarian->get_list_tanggal_sop();
		$dt_tahun = array();
		foreach ($dt_tgl->result() as $row) {
		 	$arr_tanggal = explode(' ', $row->sop_tgl_efektif);
		 	if(isset($arr_tanggal[2])){
		 		if(!in_array($arr_tanggal[2], $dt_tahun)){
		 			array_push($dt_tahun, $arr_tanggal[2]);
		 		}
		 	}
		}

		$data['list_tahun'] = $dt_tahun;
		
		$last_year = $this->pencarian->get_last_year();
		$data['last_year'] = date('Y');
		if($last_year->num_rows() == 1){
		 	$pecah = explode('/', $last_year->row()->sop_no);
		 	if(isset($pecah[1]))
		 		$data['last_year'] = $pecah[1];
		}
		$data['title'] = 'Pencabutan SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$this->load->view('templating/header',$data);
		$this->load->view('content/admin_sop/daftar_publish_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_sop_publish(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$column_search = array('sop_no','sop_nama','nama_unit','sop_tgl_efektif');
		$column_order = array('sop_index','sop_index','sop_nama','satuan_organisasi_nama','nama_deputi', 'nama_unit','sop_tgl_efektif');
		$order = array('sop_tgl_efektif' => 'desc');

		$list = $this->pencarian->get_daftar_sop($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->sop_no;
			$row[] = $field->sop_nama;
			$row[] = $field->satuan_organisasi_nama;
			$row[] = $field->nama_deputi;
			$row[] = $field->nama_unit;
			$row[] = $field->sop_tgl_efektif;

			$action = '';
			if($field->sop_label == 'berkas sop')
				$file = $this->config->item('path_draftpdf').'berkas_sop_'.$field->sop_alias.'.pdf';
			else
				$file = $this->config->item('path_exportpdf').'sop_tte_'.$field->sop_alias.'.pdf';

			if (file_exists($file)){
				$action .= '<a href="'.site_url('pencarian_sop/lihat_sop/'.enkripsi_id_url($field->sop_alias)).'" target="_blank" class="btn btn-primary btn-xs" title="lihat">
							<i class="fa fa-eye"></i>
							</a>&nbsp;';
			}
			$action .= '<a href="'.enkripsi_id_url($field->sop_alias).'" class="btn btn-danger btn-xs" title="unpublish" id="btn-unpublish">
							<i class="fa fa-remove"></i>
							</a>';
			$row[] = $action;
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pencarian->total_record('vwsop'),
            "recordsFiltered" => $this->pencarian->jumlah_filter_daftar_sop($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function get_sop_unpublish(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$column_search = array('sop_no','sop_nama','nama_unit','sop_tgl_efektif');
		$column_order = array('sop_index','sop_index','sop_nama','satuan_organisasi_nama','nama_deputi', 'nama_unit','sop_tgl_efektif');
		$order = array('sop_tgl_efektif' => 'desc');

		$list = $this->admin->get_daftar_sop_unpublish($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->sop_no;
			$row[] = $field->sop_nama;
			$row[] = $field->satuan_organisasi_nama;
			$row[] = $field->nama_deputi;
			$row[] = $field->nama_unit;
			$row[] = $field->sop_tgl_efektif;

			$action = '';
			if($field->sop_label == 'berkas sop')
				$file = $this->config->item('path_draftpdf').'berkas_sop_'.$field->sop_alias.'.pdf';
			else
				$file = $this->config->item('path_exportpdf').'sop_tte_'.$field->sop_alias.'.pdf';
			
			if (file_exists($file)){
				$action .= '<a href="'.site_url('pencarian_sop/lihat_sop/'.enkripsi_id_url($field->sop_alias)).'" target="_blank" class="btn btn-primary btn-xs" title="lihat">
							<i class="fa fa-eye"></i>
							</a>&nbsp;';
			}
			$action .= '<a href="'.enkripsi_id_url($field->sop_alias).'" class="btn btn-warning btn-xs" title="publish" id="btn-publish">
							<i class="fa fa-share"></i>
							</a>';
			$row[] = $action;
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->admin->total_record('vwsop'),
            "recordsFiltered" => $this->admin->jumlah_filter_daftar_sop_unpublish($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function unpublish_sop(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$data_ajax['success'] = false;
		$alias = trim($this->input->post('id', true));
		$alias = dekripsi_id_url($alias);
		if($alias == ''){
			$data_ajax['message'] = 'Akses telah dibatasi';
			echo json_encode($data_ajax);
			exit();
		}

		$sop = $this->sop->detail_sop($alias);
		if($sop->num_rows() == 0){
			$data_ajax['message'] = 'Data SOP tidak ditemukan';
			echo json_encode($data_ajax);
			exit();
		} 

		$update = $this->sop->update_data('sop_alias', $alias, array('sop_status_publish' => 'unpublish'), 'sop');
		if($update){	
			$data_ajax['success'] = true;
			$data_ajax['message'] = '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data sop berhasil diunpublish</div>';
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data sop gagal diunpublish</div>';
		}
		echo json_encode($data_ajax);
	}
	public function publish_sop(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$data_ajax['success'] = false;
		$alias = trim($this->input->post('id', true));
		$alias = dekripsi_id_url($alias);
		if($alias == ''){
			$data_ajax['message'] = 'Akses telah dibatasi';
			echo json_encode($data_ajax);
			exit();
		}

		$sop = $this->sop->detail_sop($alias);
		if($sop->num_rows() == 0){
			$data_ajax['message'] = 'Data SOP tidak ditemukan';
			echo json_encode($data_ajax);
			exit();
		} 

		$update = $this->sop->update_data('sop_alias', $alias, array('sop_status_publish' => 'publish'), 'sop');
		if($update){	
			$data_ajax['success'] = true;
			$data_ajax['message'] = '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data sop berhasil dipublikasi</div>';
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data sop gagal dipublikasi</div>';
		}
		echo json_encode($data_ajax);
	}
}
