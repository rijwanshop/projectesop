<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Kelola_sop extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('tgl_indonesia','notif','kegiatan'));
		$this->load->model('Main');	
		$this->load->library('menubackend');
		$this->load->model('Model_admin_sop','admin');
		$this->load->model('Model_sop','sop');
		$this->load->model('Model_pencarian','pencarian');	
		date_default_timezone_set('Asia/Jakarta'); 
		cek_aktif();
		cek_administrator();
	}
	public function index(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Pencarian SOP';
		$this->load->view('templating/header',$data);
		$this->load->view('content/pencarian_sop/daftar_pencarian_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_daftar_pencarian(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$column_search = array('sop_no','sop_nama','sop_tgl_pembuatan','nama_penyusun');
		$column_order = array('sop_alias','sop_no','sop_nama','sop_tgl_pembuatan', 'nama_penyusun','sop_update_file');
		$order = array('sop_index' => 'desc');

		$list = $this->admin->get_pencarian_sop($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->sop_no;
			$row[] = $field->sop_nama;
			$row[] = $field->sop_tgl_pembuatan;
			$row[] = $field->nama_penyusun;

			if($field->sop_status == 'Draft')
				$row[] = '<span class="badge badge-md badge-danger" style="color:#fff; font-size:11px">'.$field->sop_status.'</span>';
			else if($field->sop_status == 'Draft Revisi' || $field->sop_status == 'Pending')
				$row[] = '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">'.$field->sop_status.'</span>';
			else
				$row[] = '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">'.$field->sop_status.'</span>';

			if($field->sop_update_file == '')
				$row[] = '<span class="badge badge-md badge-primary" style="color:#fff; font-size:11px">Auto</span>';
			else
				$row[] = '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">Manual</span>';

			$row[] = '<a href="'.site_url('kelola_sop/detail_sop/'.enkripsi_id_url($field->sop_alias)).'" title="Lihat">
						<span class="btn btn-xs btn-info"><i class="icon wb-eye" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>';
			$row[] = '<a href="'.enkripsi_id_url($field->sop_alias).'" title="Delete" role="menuitem" id="btn-hapus">
						<span class="btn btn-xs btn-danger"><i class="icon wb-trash" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>';
			
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->admin->total_record('sop'),
            "recordsFiltered" => $this->admin->jumlah_filter_pencarian_sop($column_search, $column_order, $order),
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
		
		$data['title'] = 'Daftar SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
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

		$data['back_link'] = site_url('kelola_sop');
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/detail_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function upload_berkas(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Upload Berkas SOP';
		$this->load->view('templating/header',$data);
		$this->load->view('content/upload_berkas/daftar_sop_upload',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_upload_sop(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$column_search = array('no_sop','sop_nama');
		$column_order = array('id','no_sop','sop_nama','tanggal');
		$order = array('tanggal' => 'desc');

		$list = $this->admin->get_upload_sop($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->no_sop;
			$row[] = $field->sop_nama;
			$row[] = date('d-m-Y H:i:s', strtotime($field->tanggal));
			$row[] = '<a href="'.site_url('kelola_sop/lihat_berkas/'.enkripsi_id_url($field->sop_alias)).'" title="Lihat PDF" target="_blank">
						<span class="btn btn-xs btn-success"><i class="fa fa-file-text" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>';
			$row[] = '<a href="'.site_url('kelola_sop/detail_berkas/'.enkripsi_id_url($field->sop_alias)).'" title="Detail berkas">
						<span class="btn btn-xs btn-info"><i class="icon wb-eye" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>&nbsp;<a href="'.site_url('kelola_sop/edit_berkas/'.enkripsi_id_url($field->sop_alias)).'" title="Edit berkas">
						<span class="btn btn-xs btn-warning"><i class="icon wb-pencil" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>&nbsp;<a href="'.enkripsi_id_url($field->sop_alias).'" title="Delete" role="menuitem" id="btn-hapus">
						<span class="btn btn-xs btn-danger"><i class="icon wb-trash" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>';
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->admin->total_record('sop'),
            "recordsFiltered" => $this->admin->jumlah_filter_upload_sop($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function lihat_berkas(){
		$alias = dekripsi_id_url($this->uri->segment(3));
		if($alias == ''){
			echo 'Akses telah dibatasi';
			exit();
		}
		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			echo 'data tidak ditemukan';
			exit();
		}
		$file = $this->config->item('path_draftpdf').$dt_sop->row()->sop_update_file;
		if (file_exists($file)){
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="'.$dt_sop->row()->sop_nama.'"');
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');
			@readfile($file);
		}else{
			echo 'File tidak ditemukan';
		}
	}
	public function input_sop_upload(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Input Berkas SOP';
		$this->load->view('templating/header',$data);
		$this->load->view('content/upload_berkas/input_sop_upload',$data);
		$this->load->view('templating/footer',$data);
	}
	public function insert_sop_upload(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('satker', 'Satker', 'required');
		$this->form_validation->set_rules('nm_satker', 'Nm_satker', 'required');
		$this->form_validation->set_rules('tanggal_penerbitan', 'Tanggal_penerbitan', 'required');
		$this->form_validation->set_rules('no_sop', 'No_sop', 'required|callback_validate_nomor');
		$this->form_validation->set_rules('namasop', 'Namasop', 'required');
		if (empty($_FILES['fileupload']['name'])){
    		$this->form_validation->set_rules('fileupload', 'Document', 'required');
		}
		if($this->form_validation->run() == TRUE){
			//generate alias SOP
			$dt_alias = $this->sop->get_alias_sop();
			if($dt_alias->num_rows() == 0)
				$alias = 1;
			else
				$alias = $dt_alias->row()->random_num;

			$this->load->library('upload');
			$config['upload_path'] = $this->config->item('path_draftpdf');
			$config['allowed_types'] = 'pdf'; 
			$config['max_size'] = '5000'; 
			$config['file_name'] = 'berkas_sop_'.$alias;
			$this->upload->initialize($config);
			if ($this->upload->do_upload('fileupload')){

				//data SOP
				$namasop = trim($this->input->post('namasop', true));
				$no = trim($this->input->post('no_sop', true));
				$dt_no = explode('/', $no);
				$tanggal_terbit = trim($this->input->post('tanggal_penerbitan', true));
				$tanggal_terbit = date('Y-m-d', strtotime($tanggal_terbit));
				$data_sop = array(
					'sop_nourut' => $dt_no[0],
					'sop_no' => $no,
					'sop_index' => $dt_no[1].$dt_no[0],
					'sop_tgl_efektif' => tgl_indo2($tanggal_terbit),
					'tgl_efektif' => date($tanggal_terbit),
					'sop_nama' => strtoupper($namasop),
					'nip_user' => $this->session->userdata('pegawainip'),
					'satuan_organisasi_id' => trim($this->input->post('satker', true)),
					'satuan_organisasi_nama' => trim($this->input->post('nm_satker', true)),
					'sop_status' => 'Disahkan',
					'sop_label' => 'berkas sop',
					'sop_alias' => $alias,
					'sop_status_publish' => 'publish',
				);

				if(in_array($data_sop['satuan_organisasi_id'], array('01','02'))){
					$data_sop['deputi_id'] = trim($this->input->post('unitkerja', true));
					$data_sop['nama_deputi'] = trim($this->input->post('nm_unit', true));
					$data_sop['unit_kerja_id'] = trim($this->input->post('bagian', true));
					$data_sop['nama_unit'] = trim($this->input->post('nm_bagian', true));
				}else{
					$data_sop['unit_kerja_id'] = trim($this->input->post('unitkerja', true));
					$data_sop['nama_unit'] = trim($this->input->post('nm_unit', true));
				}

				$this->sop->insert_data($data_sop, 'sop');

				//Data File SOP
				$file = $this->upload->data();
				$sop_update = array(
					'sop_alias' => $alias,
					'sop_update_file' => $file['file_name'],
					'sop_update_tanggal	' => date('Y-m-d'),
				);
				$this->sop->insert_data($sop_update, 'sop_update');

				//berkas SOP
				$data_berkas = array(
					'nip_penyusun' => $this->session->userdata('pegawainip'),
					'nama_penyusun' => $this->session->userdata('fullname'),
					'file' => $file['file_name'],
					'tanggal' => date('Y-m-d H:i:s'),
					'no_sop' => $no,
					'sop_nama' => strtoupper($namasop),
					'sop_alias' => $alias,
				);
				$insert = $this->sop->insert_data($data_berkas, 'berkas_sop');
				if($insert){
					$data_ajax['success'] = true;
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data berhasil ditambahkan</div>');
				}else{
					$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diinput, coba sekali lagi</div>';
				}

			}else{
				$error = $this->upload->display_errors();
				$error = str_replace('<p>', '', $error);
				$error = str_replace('</p>', '', $error);
				$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Gagal upload file: '.$error.'</div>';
			}
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diinput, pastikan data terisi dengan benar</div>';
		}
		echo json_encode($data_ajax);
	}
	public function validate_nomor($nomor){
		if (strpos($nomor, '/') !== false) {
    		$pos = strpos($nomor, '/');
    		if($pos == 0)
    			return false;
    		if($pos == (strlen($nomor)-1))
    			return false;
    		
    		$list = explode('/', $nomor);
    		if(count($list) != 2)
    			return false;

    		return true;
		}
		return false;
	}
	public function detail_berkas(){
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
		$dt_berkas = $this->sop->get_data_id('sop_alias', $alias, 'berkas_sop');
		if($dt_berkas->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}

		$data['berkas'] = $dt_berkas->row();
		$data['sop'] = $dt_sop->row();
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Detail Berkas SOP';
		$this->load->view('templating/header',$data);
		$this->load->view('content/upload_berkas/v_detail_berkas',$data);
		$this->load->view('templating/footer',$data);
	}
	public function edit_berkas(){
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
		$dt_berkas = $this->sop->get_data_id('sop_alias', $alias, 'berkas_sop');
		if($dt_berkas->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		$data['sop'] = $dt_sop->row();
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Edit Berkas SOP';
		$this->load->view('templating/header',$data);
		$this->load->view('content/upload_berkas/input_sop_upload',$data);
		$this->load->view('templating/footer',$data);
	}
	public function update_sop_upload(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('satker', 'Satker', 'required');
		$this->form_validation->set_rules('nm_satker', 'Nm_satker', 'required');
		$this->form_validation->set_rules('tanggal_penerbitan', 'Tanggal_penerbitan', 'required');
		$this->form_validation->set_rules('no_sop', 'No_sop', 'required|callback_validate_nomor');
		$this->form_validation->set_rules('namasop', 'Namasop', 'required');
		if($this->form_validation->run() == TRUE){
			$alias = trim($this->input->post('alias', true));

			//update data SOP
			$namasop = trim($this->input->post('namasop', true));
			$no = trim($this->input->post('no_sop', true));
			$dt_no = explode('/', $no);
			$tanggal_terbit = trim($this->input->post('tanggal_penerbitan', true));
			$tanggal_terbit = date('Y-m-d', strtotime($tanggal_terbit));
			$data_sop = array(
				'sop_nourut' => $dt_no[0],
				'sop_no' => $no,
				'sop_index' => $dt_no[1].$dt_no[0],
				'sop_tgl_efektif' => tgl_indo2($tanggal_terbit),
				'tgl_efektif' => $tanggal_terbit,
				'sop_nama' => strtoupper($namasop),
				'nip_user' => $this->session->userdata('pegawainip'),
				'satuan_organisasi_id' => trim($this->input->post('satker', true)),
				'satuan_organisasi_nama' => trim($this->input->post('nm_satker', true)),
			);

			if(in_array($data_sop['satuan_organisasi_id'], array('01','02'))){
				$data_sop['deputi_id'] = trim($this->input->post('unitkerja', true));
				$data_sop['nama_deputi'] = trim($this->input->post('nm_unit', true));
				$data_sop['unit_kerja_id'] = trim($this->input->post('bagian', true));
				$data_sop['nama_unit'] = trim($this->input->post('nm_bagian', true));
			}else{
				$data_sop['unit_kerja_id'] = trim($this->input->post('unitkerja', true));
				$data_sop['nama_unit'] = trim($this->input->post('nm_unit', true));
			}
			$this->sop->update_data('sop_alias', $alias, $data_sop, 'sop');

			//update berkas SOP
			$dt_berkas = $this->sop->get_data_id('sop_alias', $alias, 'sop_update');
			$this->load->library('upload');
			$config['upload_path'] = $this->config->item('path_draftpdf');
			$config['allowed_types'] = 'pdf'; 
			$config['max_size'] = '5000'; 
			$config['file_name'] = 'berkas_sop_'.$alias;
			$this->upload->initialize($config);
			if ($this->upload->do_upload('fileupload')){

				//hapus file sebelumnya
				if($dt_berkas->num_rows() > 0){
					$file_lama = $this->config->item('path_draftpdf').$dt_berkas->row()->sop_update_file;
					if(file_exists($file_lama)){
						unlink($file_lama);
					}
				}

				//update file SOP
				$file = $this->upload->data();
				$sop_update = array(
					'sop_update_file' => $file['file_name'],
					'sop_update_tanggal	' => date('Y-m-d'),
				);
				$this->sop->update_data('sop_alias', $alias, $sop_update, 'sop_update');

				$data_berkas = array(
					'nip_penyusun' => $this->session->userdata('pegawainip'),
					'nama_penyusun' => $this->session->userdata('fullname'),
					'file' => $file['file_name'],
					'tanggal' => date('Y-m-d H:i:s'),
					'no_sop' => $no,
					'sop_nama' => strtoupper($namasop),
				);
				$this->sop->update_data('sop_alias', $alias, $data_berkas, 'berkas_sop');
				$data_ajax['success'] = true;
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data berhasil diedit</div>');
			}else{
				if (!empty($_FILES['fileupload']['name'])){
					$error = $this->upload->display_errors();
					$error = str_replace('<p>', '', $error);
					$error = str_replace('</p>', '', $error);
					$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Gagal upload file: '.$error.'</div>';
				}else{
					$data_ajax['success'] = true;
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data berhasil diedit</div>');
				}
			}
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diedit, pastikan data terisi dengan benar</div>';
		}
		echo json_encode($data_ajax);
	}
	public function hapus_berkas(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;

		$alias = trim($this->input->post('id', true));
		$alias = dekripsi_id_url($alias);
		if($alias == ''){
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Akses anda telah dibatasi</div>';
			echo json_encode($data_ajax);
			exit();
		}

		//hapus File PDF SOP
		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() > 0){
			if($dt_sop->row()->sop_update_file != ''){
				$file_cek = $this->config->item('path_draftpdf').$dt_sop->row()->sop_update_file;
				if(file_exists($file_cek)){
					unlink($file_cek);
				}
			}
		}

		$this->sop->hapus_data('sop_alias', $alias, 'sop_update');
		$this->sop->hapus_data('sop_alias', $alias, 'berkas_sop');
		$hapus = $this->sop->hapus_data('sop_alias', $alias, 'sop');
		if($hapus){
			$data_ajax['success'] = true;
			$data_ajax['message'] = '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data sop berhasil dihapus</div>';
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data sop gagal dihapus</div>';
		}
		echo json_encode($data_ajax);
	}
}
