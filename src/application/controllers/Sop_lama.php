<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sop_lama extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('tgl_indonesia','notif','kegiatan'));
		$this->load->model('Model_sop','sop');
		$this->load->model('Main');		
		$this->load->library('menubackend');
		date_default_timezone_set('Asia/Jakarta'); 
		cek_aktif();
	}
	public function index(){
		$data['title'] = 'Daftar SOP Lama';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop_lama/data_sop_lama',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_data_sop(){
		if (!$this->input->is_ajax_request()){
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$column_search = array('sop_no','sop_nama','sop_status', 'sop_step');
		$column_order = array('sop_alias','sop_no','sop_nama','sop_tgl_pembuatan','sop_status','sop_step','sop_update_file');
		$order = array('sop_index' => 'desc');

		$list = $this->sop->get_daftar_sop_lama($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
		foreach ($list as $field){
			$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->sop_no;
			$row[] = $field->sop_nama;
			$row[] = $field->sop_tgl_pembuatan;

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
							<a class="dropdown-item" href="'.site_url('sop_lama/detail_sop/'.enkripsi_id_detail($field->sop_alias)).'" role="menuitem">
								<i class="icon wb-eye" aria-hidden="true"></i> Lihat
							</a>
							<a class="dropdown-item" href="'.site_url('sop_lama/history_sop/'.enkripsi_id_url($field->sop_alias)).'" role="menuitem">
								<i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;History
							</a>';

			if($field->sop_step == ''){
				$action .='<a class="dropdown-item" href="'.base_url().'sop_lama/edit_sop/'.enkripsi_id_url($field->sop_alias).'" role="menuitem">
								  <i class="icon wb-pencil" aria-hidden="true"></i> Edit
								</a>
								<a class="dropdown-item del'.$field->sop_alias.'" href="'.enkripsi_id_url($field->sop_alias).'" role="menuitem" id="btn-hapus">
								  <i class="icon wb-trash" aria-hidden="true"></i> Delete
								</a>';
			}
			if($field->sop_status == 'Disahkan'){
				$action .='<hr><a class="dropdown-item" href="'.base_url().'sop/revisi_sop/ajukan/'.$field->sop_alias.'" role="menuitem">
								  <i class="icon wb-refresh" aria-hidden="true"></i> Revisi
								</a>';
			}
			$action .= '</div>
						</div>';
			if($field->sop_step == ''){
				$action .='&nbsp;<a class="btn btn-icon btn-success btn-xs" href="'.enkripsi_id_url($field->sop_alias).'" id="btn-kirim">
								  <i class="fa fa-send" aria-hidden="true"></i> Pengesah
								</a>';
			}

			$row[] = $action;
			$data[] = $row;
		}
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->sop->total_record('sop'),
            "recordsFiltered" => $this->sop->jumlah_filter_sop_lama($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function pembuatan_sop(){
		$no = $this->sop->no_urut_sop($this->session->userdata('satkerid'), $this->session->userdata('iddeputi'), $this->session->userdata('unitkerjaid'), date('Y'));
		if($no->num_rows() > 0)
			$data['sop_no'] = ($no->row()->sop_nourut+1).'/'.date('Y');
		else
			$data['sop_no'] = '1/'.date('Y');

		$dtjabatan = get_list_pengesah();
		$data['list_pengesah'] = $dtjabatan;
		$data['title'] = 'Penyusunan SOP Lama';
		$data['dt_singkatan'] = $this->sop->list_singkatan_jabatan();
		$data['idx'] = 1;
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);

		if(count($dtjabatan) > 0){
			$data['nama_pengesah'] = $dtjabatan[0]['nama_pegawai'];
			$data['jabatan_pengesah'] = $dtjabatan[0]['jabatan'];
			$data['nip_pengesah'] = $dtjabatan[0]['nipbaru'];

			$data['nama_satorg'] = $dtjabatan[0]['satorg'];
			$data['nama_deputi'] = $dtjabatan[0]['deputi'];
			$data['nama_unit'] = $dtjabatan[0]['biro'];
		}else{
			$data['nama_pengesah'] = '-';
			$data['jabatan_pengesah'] = '-';
			$data['nip_pengesah'] = '-';

			$data['nama_satorg'] = $this->session->userdata('satkernm');
			$data['nama_deputi'] = $this->session->userdata('deputinm');
			$data['nama_unit'] = $this->session->userdata('unitkerjanm');
		}
		

		$this->load->view('templating/header',$data);
		$this->load->view('content/sop_lama/v_pembuatan_sop_lama',$data);
		$this->load->view('templating/footer',$data);
	}
	public function insert_header_sop(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('tgl_sop', 'Tgl_sop', 'trim|required');
		$this->form_validation->set_rules('nama_sop', 'Nama_sop', 'trim|required');
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
		$this->form_validation->set_rules('no_sop', 'No_sop', 'trim|required');
		if($this->form_validation->run() == TRUE){
			
			$dt_alias = $this->sop->get_alias_sop();
			$no_sop = trim($this->input->post('no_sop', true));
			$dt_no = explode('/', $no_sop);

			$data = array(
				'sop_no' => $no_sop,
				'sop_nourut' => $dt_no[0],
				'sop_index' => $dt_no[1].$dt_no[0],
				//satorg
				'sop_nama_satker' => strtoupper(trim($this->input->post('nm_satker', true))),
				//deputi
				'sop_deputi' => strtoupper(trim($this->input->post('nm_deputi', true))),
				//biro
				'sop_unit_kerja' => strtoupper(trim($this->input->post('nm_unitkerja', true))),
				'sop_tgl_pembuatan' => tgl_indo(trim($this->input->post('tgl_sop', true))),
				'sop_disahkan_jabatan' => trim($this->input->post('jabatan', true)),
				'sop_disahkan_nama' => trim($this->input->post('nama_pejabat', true)),
				'sop_disahkan_nip' => trim($this->input->post('nip_pejabat', true)),
				'sop_nama' => trim($this->input->post('nama_sop', true)),
				'sop_dasar_hukum' => trim($this->input->post('dasar_hukum', true)),
				'sop_kualifikasi' => trim($this->input->post('kualifikasi_pelaksana', true)),
				'sop_peralatan' => trim($this->input->post('peralatan', true)),
				'sop_peringatan' => trim($this->input->post('peringatan', true)),
				'sop_pencatatan' => trim($this->input->post('pencatatan', true)),
				'nip_user' => $this->session->userdata('pegawainip'),
				'satuan_organisasi_id' => $this->session->userdata('satkerid'),
				'satuan_organisasi_nama' => $this->session->userdata('satkernm'),
				'deputi_id' => $this->session->userdata('iddeputi'),
				'nama_deputi' => $this->session->userdata('deputinm'),
				'unit_kerja_id' => $this->session->userdata('unitkerjaid'),
				'nama_unit' => $this->session->userdata('unitkerjanm'),
				'bagian_id' => $this->session->userdata('bagianid'),
				'sop_status' => 'DRAFT',
				'sop_alias' => $dt_alias->row()->random_num,
				'sop_status_publish' => 'publish',
				'sop_label' => 'sop lama',
			);

			$list_terkaitan = $this->input->post('ls_terkait');
			$list_link = $this->input->post('link_terkait');
			$keterkaitan = '';
			$idx = 1;
			if(count((is_countable($list_terkaitan)?$list_terkaitan:[])) > 0){
				foreach($list_terkaitan as $i => $val){
					if($list_link[$i] != '')
						$keterkaitan .= $idx.'. <a href="'.site_url('pengolahan_sop/detail_sop/'.$list_link[$i]).'" target="_blank">'.$list_terkaitan[$i].'</a><br>';
					$idx++;
				}
			}
			$data['sop_keterkaitan'] = $keterkaitan;

			$data['sop_tgl_revisi'] = trim($this->input->post('tgl_revisi', true));
			if($data['sop_tgl_revisi'] != '')
				$data['sop_tgl_revisi'] = tgl_indo($data['sop_tgl_revisi']);


			$insert = $this->sop->insert_data($data, 'sop');
			if($insert){
				$data_insert = array(
					'nama_penyusun' => $this->session->userdata('pegawainm'),
					'nip_penyusun' => $this->session->userdata('pegawainip'),
					'sop_alias' => $data['sop_alias'],
					'waktu_penyusunan' => date('Y-m-d H:i:s'),
				);
				$this->sop->insert_data($data_insert, 'penyusun_sop');

				//create header PDF SOP
				$this->load->helper('eksport');
				eksport_header($data['sop_alias']);
				
				$data_ajax['success'] = true;
				$data_ajax['message'] = 'Data sop berhasil ditambahkan';
				$data_ajax['id'] = $data['sop_alias'];

				$data_view['sop'] = $this->sop->detail_sop($data['sop_alias'])->row();
				$data_ajax['content'] = $this->load->view('content/sop/header_create', $data_view, true);
			}else{
				$data_ajax['message'] = 'Data sop gagal ditambahkan';
			}
		}else{
			$data_ajax['message'] = 'Data sop gagal ditambahkan, silahkan isi form dengan benar';
		}
		echo json_encode($data_ajax);
	}
	private function cek_akses($dt_sop){
		if($dt_sop->row()->nip_user != $this->session->userdata('pegawainip')){
			echo 'Akses telah dibatasi';
			exit();
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
		$this->cek_akses($dt_sop);

		$data['sop'] = $dt_sop->row();
		$data['history'] = $this->sop->history_sop($alias);
		$data['list_catatan'] = $this->sop->get_list_catatan_review($alias);
		$data['no'] = 1;
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'History SOP';
		$data['back_link'] = site_url('sop_lama');
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/v_history_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function detail_sop(){
		$alias = dekripsi_id_detail($this->uri->segment(3));
		if($alias == false){
			echo 'Akses telah dibatasi';
			exit();
		}

		$data['title'] = 'Daftar SOP Lama';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}

		if($dt_sop->row()->sop_status != 'Disahkan')
			$this->cek_akses($dt_sop);

		//update notif jika ada
		if($dt_sop->row()->sop_status == 'Disahkan'){
			$this->load->model('Model_notifikasi','notif');
			$where = array(
				'nip_penerima' => $this->session->userdata['pegawainip'],
				'alias_sop' => $alias,
				'jenis_notif' => 'Informasi Pengesahan',
			);
			$this->notif->update_status_notif($where);
		}

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

		$data['back_link'] = site_url('sop_lama');
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
		$this->cek_akses($dt_sop);

		if($dt_sop->row()->sop_status != 'Draft'){
			echo 'Akses telah dibatasi';
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

		$data['title'] = 'Edit Daftar SOP Lama';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		
		
		$data['list_pengesah'] = get_list_pengesah();
		
		$data['sop'] = $this->sop->detail_sop($alias);
		$data['arr_sop'] = $this->sop->detail_sop($alias)->result_array();
		$data['idx'] = 0;

		$data['dt_singkatan'] = $this->sop->list_singkatan_jabatan();
		$data['back_link'] = site_url('sop_lama');
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/v_edit_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function kirim_sop(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;
		$alias = trim($this->input->post('id_kegiatan_hasil', true));
		$alias = dekripsi_id_url($alias);
		if($alias == ''){
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Akses telah dibatasi</div>';
			echo json_encode($data_ajax);
			exit();
		}

		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data tidak ditemukan</div>';
			echo json_encode($data_ajax);
			exit();
		}

		$data_update = array(
			'sop_step' => 'Pengesah',
			'sop_status' => 'Pending',
		);
		$update = $this->sop->update_data('sop_alias', $alias, $data_update, 'sop');
		if($update){
			$cek = $this->input_review($alias);
			if($cek == true){
				$this->set_history($alias);
				$this->set_notif($alias);
			}
			
			$data_ajax['success'] = true;
			$data_ajax['message'] = '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data SOP Lama berhasil dikrim ke Pengesah</div>';
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data SOP Lama gagal dikrim, silahkan coba kembali</div>';
		}
		echo json_encode($data_ajax);
	}
	private function set_history($alias){
		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			return '';
		}

		$data_history = array(
			'icon' => 'fa fa-send',
			'warna' => 'info',
			'judul' => 'Permohonan Pengesahan SOP Lama',
			'aktivitas' => '[ '.$this->session->userdata('fullname').' ] [ '.$this->session->userdata('pegawainip').' ] sebagai Penyusun mengajukan Pengesahan SOP Lama ke [ '.$dt_sop->row()->sop_disahkan_nama.' ] [ '.$dt_sop->row()->sop_disahkan_nip.' ]',
			'waktu' => date('Y-m-d H:i:s'),
			'alias_sop' => $alias,
		);
		$this->sop->insert_data($data_history, 'history_sop');
	}
	private function set_notif($alias){
		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			return '';
		}

		$data_notif = array(
			'nama_pengirim' => $this->session->userdata('fullname'),
			'nip_pengirim' => $this->session->userdata('pegawainip'),
			'nama_penerima' => $dt_sop->row()->sop_disahkan_nama,
			'nip_penerima' => $dt_sop->row()->sop_disahkan_nip,
			'status_baca' => 'Delivery',
			'status_action' => 0,
			'waktu' => date('Y-m-d H:i:s'),
			'jenis_notif' => 'Pengesahan SOP',
			'alias_sop' => $alias,
			'aktivitas' => 'Perlu disahkan SOP Lama: '.$dt_sop->row()->sop_nama,
			'icon' => 'wb-order bg-green-600',
		);
		$this->sop->insert_data($data_notif, 'notifikasi');
	}
	private function input_review($alias){
		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			return false;
		}

		$data_review = array(
			'sop_alias' => $alias,
			'nama_pereview' => $dt_sop->row()->sop_disahkan_nama,
			'nipbaru' => $dt_sop->row()->sop_disahkan_nip,
			'jabatan' => $dt_sop->row()->sop_disahkan_jabatan,
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
		$this->sop->insert_data($data_review, 'list_review_sop');

		//disable history review lama
		$this->sop->update_indikator_review($data_review['idlist_review'], $data_review['nipbaru'], $data_review['sop_alias']);

		return true;
	}
	public function pengajuan_revisi(){
		$alias = $this->uri->segment(3);
		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		if($dt_sop->row()->sop_jml_pelaksana >= 10)
			$data['jmlpel'] = 10;
		else
			$data['jmlpel'] = $dt_sop->row()->sop_jml_pelaksana;

		$list_pelaksana = get_list_pelaksana($dt_sop->row()->sop_alias);
		$data['list_singkatan'] = $this->sop->get_daftar_singkatan($list_pelaksana);
		$data['sop'] = $dt_sop;
		$data['img_chart'] = get_image_node($dt_sop->row()->sop_alias);
		$data['no'] = 1;
		$data['title'] = 'Revisi SOP';
		$data['notif'] = $this->Notif_m->notification(5,$this->session->userdata['userid']);
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['sop'] = $dt_sop;
		$data['back_link'] = site_url('sop_lama');
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop_lama/v_revisi',$data);
		$this->load->view('templating/footer',$data);
	}
}
