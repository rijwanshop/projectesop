<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {

	public function __construct() {
		parent::__construct(); 
		/*
		$this->load->helper(array('form','url', 'text_helper','date','tgl_indonesia'));
		$this->load->model('Model_master_data','master');
		$this->load->model(array('Notif_m','Main'));	
		$this->load->library(array('alias','encrypt','menubackend'));
		*/

		$this->load->helper('notif');
		$this->load->model('Main');	
		$this->load->library(array('menubackend'));
		$this->load->model('Model_master_data','master');
		cek_aktif();	
	}
	public function jenis_sop(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Jenis SOP';
		$this->load->view('templating/header',$data);
		$this->load->view('content/master_data/v_jenis_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_jenis_sop(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$column_search = array('kategori_nama','kategori_status');
		$column_order = array('kategori_id','kategori_nama','kategori_status');
		$order = array('kategori_id' => 'asc');

		$list = $this->master->get_daftar_kategorisop($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->kategori_nama;
			$row[] = ($field->kategori_status == 'Y' ? '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">Aktif</span>' : '<span class="badge badge-md badge-danger" style="color:#fff; font-size:11px">Nonaktif</span>');
			$row[] = '<a href="'.site_url('master/edit_kategorisop/'.$field->kategori_id).'" title="Lihat">
						<span class="btn btn-xs btn-warning"><i class="icon wb-pencil" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>&nbsp;<a href="'.$field->kategori_id.'" class="btn btn-danger btn-xs" id="btn-hapus"><i class="fa fa-remove"></i></a>';
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->master->total_record('kategori_sop'),
            "recordsFiltered" => $this->master->jumlah_filter_kategorisop($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function add_kategorisop(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Add Jenis SOP';
		$this->load->view('templating/header',$data);
		$this->load->view('content/master_data/v_input_jenis_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function insert_kategorisop(){
		if (!$this->input->is_ajax_request()) {
            echo '<h1 style="color:red">AKSES DITOLAK</h1>';
            exit();
        }
        $data_ajax['success'] = false;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        if($this->form_validation->run() == TRUE){
        	$data = array(
                'kategori_nama' => trim($this->input->post('nama', true)),
                'kategori_status' => trim($this->input->post('status', true)),
            );
            $insert = $this->master->insert_data($data, 'kategori_sop');
            if($insert){
                $data_ajax['success'] = true;
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data kategori SOP berhasil ditambahkan</div>');
            }else{
                $data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data kategori SOP gagal diinput, silahkan coba lagi</div>';
            }
        }else{
        	$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data kategori SOP gagal diinput, silahkan isi form dengan benar</div>';
        }
        echo json_encode($data_ajax);
	}
	public function edit_kategorisop(){
		$id = $this->uri->segment(3);
		$kategori = $this->master->get_data_id('kategori_id', $id, 'kategori_sop');
		if($kategori->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		$data['kategori'] = $kategori->row();
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Edit Kategori SOP';
		$this->load->view('templating/header',$data);
		$this->load->view('content/master_data/v_input_jenis_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function update_kategorisop(){
		if (!$this->input->is_ajax_request()) {
            echo '<h1 style="color:red">AKSES DITOLAK</h1>';
            exit();
        }
        $data_ajax['success'] = false;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('id', 'Id', 'required');
        if($this->form_validation->run() == TRUE){
        	$id = trim($this->input->post('id', true));
        	$data = array(
                'kategori_nama' => trim($this->input->post('nama', true)),
                'kategori_status' => trim($this->input->post('status', true)),
            );
            $update = $this->master->update_data('kategori_id', $id, $data, 'kategori_sop');
            if($update){
                $data_ajax['success'] = true;
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data kategori SOP berhasil diedit</div>');
            }else{
                $data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data kategori SOP gagal diupdate, silahkan coba lagi</div>';
            }
        }else{
        	$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data kategori SOP gagal diupdate, silahkan isi form dengan benar</div>';
        }
        echo json_encode($data_ajax);
	}
	public function hapus_kategorisop(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		
		$id = trim($this->input->post('id', true));
		$data_ajax['success'] = false;
		$hapus = $this->master->hapus_data('kategori_id', $id, 'kategori_sop');
		if($hapus){
			$data_ajax['success'] = true;
			$data_ajax['message'] = '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data kategori SOP berhasil dihapus</div>';
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data kategori SOP gagal dihapus</div>';
		}
		echo json_encode($data_ajax);
	}

	public function simbol_panah(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Simbol Panah';
		$this->load->view('templating/header',$data);
		$this->load->view('content/master_data/v_simbol_panah',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_data_simbol(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$column_search = array('simbol_nama');
		$column_order = array('simbol_id','simbol_nama','simbol_img');
		$order = array('simbol_id' => 'asc');

		$list = $this->master->get_daftar_simbol($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->simbol_nama;
			$row[] = '<img src="'.base_url().'assets/media/simbol/'.$field->simbol_img.'" width="100" height="100">';
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->master->total_record('simbol'),
            "recordsFiltered" => $this->master->jumlah_filter_daftar_simbol($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}

	public function pertanyaan(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Pertanyaan Evaluasi';
		$this->load->view('templating/header',$data);
		$this->load->view('content/master_data/v_pertanyaan',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_data_pertanyaan(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$column_search = array('pertanyaan_isi');
		$column_order = array('pertanyaan_id','pertanyaan_isi','pertanyaan_status');
		$order = array('pertanyaan_id' => 'asc');

		$list = $this->master->get_daftar_pertanyaan($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->pertanyaan_isi;
			$row[] = ($field->pertanyaan_status == 'Y' ? '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">Aktif</span>' : '<span class="badge badge-md badge-danger" style="color:#fff; font-size:11px">Nonaktif</span>');
			$row[] = '<a href="'.site_url('master/edit_pertanyaan/'.$field->pertanyaan_id).'" title="Lihat">
						<span class="btn btn-xs btn-warning"><i class="icon wb-pencil" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>&nbsp;<a href="'.$field->pertanyaan_id.'" class="btn btn-danger btn-xs" id="btn-hapus"><i class="fa fa-remove"></i></a>';
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->master->total_record('pertanyaan'),
            "recordsFiltered" => $this->master->jumlah_filter_daftar_pertanyaan($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function add_pertanyaan(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Add Pertanyaan';
		$this->load->view('templating/header',$data);
		$this->load->view('content/master_data/v_input_pertanyaan',$data);
		$this->load->view('templating/footer',$data);
	}
	public function insert_pertanyaan(){
		if (!$this->input->is_ajax_request()) {
            echo '<h1 style="color:red">AKSES DITOLAK</h1>';
            exit();
        }
        $data_ajax['success'] = false;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'required');
        if($this->form_validation->run() == TRUE){
        	$data = array(
                'pertanyaan_isi' => trim($this->input->post('pertanyaan', true)),
                'pertanyaan_status' => trim($this->input->post('status', true)),
            );
            $insert = $this->master->insert_data($data, 'pertanyaan');
            if($insert){
                $data_ajax['success'] = true;
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data pertanyaan berhasil ditambahkan</div>');
            }else{
                $data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data pertanyaan gagal diinput, silahkan coba lagi</div>';
            }
        }else{
        	$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data pertanyaan gagal diinput, silahkan isi form dengan benar</div>';
        }
        echo json_encode($data_ajax);
	}
	public function edit_pertanyaan(){
		$id = $this->uri->segment(3);
		$pertanyaan = $this->master->get_data_id('pertanyaan_id', $id, 'pertanyaan');
		if($pertanyaan->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		$data['pertanyaan'] = $pertanyaan->row();
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Edit Pertanyaan';
		$this->load->view('templating/header',$data);
		$this->load->view('content/master_data/v_input_pertanyaan',$data);
		$this->load->view('templating/footer',$data);
	}
	public function update_pertanyaan(){
		if (!$this->input->is_ajax_request()) {
            echo '<h1 style="color:red">AKSES DITOLAK</h1>';
            exit();
        }
        $data_ajax['success'] = false;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pertanyaan', 'Pertanyaan', 'required');
        $this->form_validation->set_rules('id', 'Id', 'required');
        if($this->form_validation->run() == TRUE){
        	$id = trim($this->input->post('id', true));
        	$data = array(
                'pertanyaan_isi' => trim($this->input->post('pertanyaan', true)),
                'pertanyaan_status' => trim($this->input->post('status', true)),
            );
            $update = $this->master->update_data('pertanyaan_id', $id, $data, 'pertanyaan');
            if($update){
                $data_ajax['success'] = true;
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data pertanyaan berhasil diedit</div>');
            }else{
                $data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data pertanyaan gagal diedit, silahkan coba lagi</div>';
            }
        }else{
        	$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data pertanyaan gagal diedit, silahkan isi form dengan benar</div>';
        }
        echo json_encode($data_ajax);
	}
	public function hapus_pertanyaan(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		
		$id = trim($this->input->post('id', true));
		$data_ajax['success'] = false;
		$hapus = $this->master->hapus_data('pertanyaan_id', $id, 'pertanyaan');
		if($hapus){
			$data_ajax['success'] = true;
			$data_ajax['message'] = '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data pertanyaan berhasil dihapus</div>';
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data pertanyaan gagal dihapus</div>';
		}
		echo json_encode($data_ajax);
	}
	public function panduan_teknis(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Panduan Teknis Sistem';
		$this->load->view('templating/header',$data);
		$this->load->view('content/master_data/v_panduan_teknis',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_panduan_teknis(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$column_search = array('judul','tanggal','file_panduan');
		$column_order = array('id','judul','type','file_panduan','tanggal');
		$order = array('id' => 'asc');

		$list = $this->master->get_daftar_panduan($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->judul;
			$row[] = $field->type;
			$row[] = $field->file_panduan;
			$row[] = date('d-m-Y', strtotime($field->tanggal));
			$row[] = '<a href="'.site_url('master/edit_pertanyaan/'.$field->id).'" title="Lihat">
						<span class="btn btn-xs btn-warning"><i class="icon wb-pencil" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>&nbsp;<a href="'.$field->id.'" class="btn btn-danger btn-xs" id="btn-hapus"><i class="fa fa-remove"></i></a>';
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->master->total_record('panduan_teknis'),
            "recordsFiltered" => $this->master->jumlah_filter_daftar_panduan($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function add_panduan_teknis(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Add Panduan Teknis';
		$this->load->view('templating/header',$data);
		$this->load->view('content/master_data/v_input_panduan_teknis',$data);
		$this->load->view('templating/footer',$data);
	}
	public function insert_panduan_teknis(){
		if (!$this->input->is_ajax_request()) {
            echo '<h1 style="color:red">AKSES DITOLAK</h1>';
            exit();
        }
        $data_ajax['success'] = false;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('judul', 'Judul', 'required');
        if($this->form_validation->run() == TRUE){
        	$data = array(
                'judul' => trim($this->input->post('judul', true)),
                'tanggal' => date('Y-m-d'),
            );
            $link = trim($this->input->post('link', true));
            if($link == ''){
				$config['upload_path'] = $this->config->item('pathupload_juknis');
				$config['allowed_types'] = 'pdf'; 
				$config['max_size'] = '3000'; 
				$config['file_name'] = 'juknis_'.time();
				$this->load->library('upload', $config); 
				if ($this->upload->do_upload('fileupload')){
					$gbr = $this->upload->data();
					$data['file_panduan'] = $gbr['file_name'];
					$data['type'] = 'doc';
				}
            }else{
            	$data['type'] = 'video';
            	$data['link'] = $link;
            }
            $insert = $this->master->insert_data($data, 'panduan_teknis');
            if($insert){
                $data_ajax['success'] = true;
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data panduan teknis berhasil ditambahkan</div>');
            }else{
                $data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data panduan teknis gagal diinput, silahkan coba lagi</div>';
            }
        }else{
        	$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data panduan teknis gagal diinput, silahkan isi form dengan benar</div>';
        }
        echo json_encode($data_ajax);
	}
	public function edit_panduan_teknis(){
		
	}
	public function update_panduan_teknis(){
		
	}
	public function hapus_panduan_teknis(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		
		$id = trim($this->input->post('id', true));
		$data_ajax['success'] = false;
		$hapus = $this->master->hapus_data('id', $id, 'panduan_teknis');
		if($hapus){
			$data_ajax['success'] = true;
			$data_ajax['message'] = '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data panduan teknis berhasil dihapus</div>';
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data panduan teknis gagal dihapus</div>';
		}
		echo json_encode($data_ajax);
	}
}