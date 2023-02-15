<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('tgl_indonesia','notif'));
		$this->load->model('Model_frontend','front');
		$this->load->model(array('Main'));		
		$this->load->library('menubackend');
		cek_aktif();
	}
	public function slide(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Slide';
		$this->load->view('templating/header',$data);
		$this->load->view('content/kelola_frontend/v_data_slide',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_data_slide(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$column_search = array('slide_judul');
		$column_order = array('slide_id','slide_gambar','slide_judul');
		$order = array('slide_id' => 'asc');

		$list = $this->front->get_daftar_slide($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = '<img src="'.base_url().'assets/media/slide/'.$field->slide_gambar.'" width="100" height="80">';
			$row[] = $field->slide_judul;
			$row[] = '<a href="'.site_url('front/edit_slide/'.$field->slide_id).'" title="Lihat">
						<span class="btn btn-xs btn-warning"><i class="icon wb-pencil" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>&nbsp;<a href="'.$field->slide_id.'" class="btn btn-danger btn-xs" id="btn-hapus"><i class="fa fa-remove"></i></a>';
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->front->total_record('slide'),
            "recordsFiltered" => $this->front->jumlah_filter_daftar_slide($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function add_slide(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Add Slide';
		$this->load->view('templating/header',$data);
		$this->load->view('content/kelola_frontend/v_input_slide',$data);
		$this->load->view('templating/footer',$data);
	}
	public function insert_slide(){
		if (!$this->input->is_ajax_request()) {
            echo '<h1 style="color:red">AKSES DITOLAK</h1>';
            exit();
        }
        $data_ajax['success'] = false;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('judul', 'Judul', 'required');
        if (empty($_FILES['fileupload']['name'])){
            $this->form_validation->set_rules('fileupload', 'Fileupload', 'required');
        }
        if($this->form_validation->run() == TRUE){
        	$config['upload_path'] = './assets/media/slide';
			$config['allowed_types'] = 'jpg|jpeg|png'; 
			$config['max_size'] = '2000';
			$config['file_name'] = 'slide_'.time();
            $this->load->library('upload', $config); 
			if ($this->upload->do_upload('fileupload')){
				$gbr = $this->upload->data();

				$data = array(
                    'slide_judul' => trim($this->input->post('judul', true)),
                    'slide_isi' => trim($this->input->post('isi', true)),
                    'slide_gambar' => $gbr['file_name'],
                );
                $insert = $this->front->insert_data($data, 'slide');
                if($insert){
                	$data_ajax['success'] = true;
                	$this->session->set_flashdata('message', 'Data slide berhasil ditambahkan');
                }else{
                	$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data slide gagal diinput, silahkan coba lagi</div>';
                }
			}else{
				$status_upload = $this->upload->display_errors();
                $status_upload = str_replace('<p>', '', $status_upload);
                $status_upload = str_replace('</p>', '', $status_upload);
                $data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data slide gagal diinput '.$status_upload.'</div>';
			}
        }else{
        	$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data slide gagal diinput, silahkan isi form dengan benar</div>';
        }
        echo json_encode($data_ajax);
	}
	public function edit_slide(){
		$id = $this->uri->segment(3);
		$slide = $this->front->get_data_id('slide_id', $id, 'slide');
		if($slide->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		$data['slide'] = $slide->row();
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Edit Slide';
		$this->load->view('templating/header',$data);
		$this->load->view('content/kelola_frontend/v_input_slide',$data);
		$this->load->view('templating/footer',$data);
	}
	public function update_slide(){
		if (!$this->input->is_ajax_request()) {
            echo '<h1 style="color:red">AKSES DITOLAK</h1>';
            exit();
        }
        $data_ajax['success'] = false;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('judul', 'Judul', 'required');
        $this->form_validation->set_rules('id', 'Id', 'required');
        if($this->form_validation->run() == TRUE){
        	$id = trim($this->input->post('id', true));
            $data = array(
                'slide_judul' => trim($this->input->post('judul', true)),
                'slide_isi' => trim($this->input->post('isi', true)),
            );
            $status_upload = '';
            $slide = $this->front->get_data_id('slide_id', $id, 'slide');
            if($slide->num_rows() == 0){
            	$config['upload_path'] = './assets/media/slide';
				$config['allowed_types'] = 'jpg|jpeg|png'; 
				$config['max_size'] = '2000';
				$config['file_name'] = 'slide_'.time();
            	$this->load->library('upload', $config); 
				if ($this->upload->do_upload('fileupload')){
					if(file_exists('./assets/media/slide/'.$slide->row()->slide_gambar))
						unlink('./assets/media/slide/'.$slide->row()->slide_gambar);

					$gbr = $this->upload->data();
					$data['slide_gambar'] = $gbr['file_name'];
				}else{
					$status_upload = ' (Status file gambar: '.$this->upload->display_errors().')';
                    $status_upload = str_replace('<p>', '', $status_upload);
                    $status_upload = str_replace('</p>', '', $status_upload);
				}
            }
            $update = $this->front->update_data('slide_id', $id, $data, 'slide');
            if($update){
                $data_ajax['success'] = true;

                $this->session->set_flashdata('message', 'Sukses! Anda berhasil mengedit slide'.$status_upload);
            }else{
                $data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data slide gagal diedit '.$status_upload.'</div>';
            }
        }else{
        	$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data slide gagal diedit, silahkan isi form dengan benar</div>';
        }
        echo json_encode($data_ajax);
	}
	public function delete_slide(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		
		$id = trim($this->input->post('id', true));
		$slide = $this->front->get_data_id('slide_id', $id, 'slide');
		if($slide->num_rows() == 0){
			if(file_exists('./assets/media/slide/'.$slide->row()->slide_gambar))
				unlink('./assets/media/slide/'.$slide->row()->slide_gambar);
		}

		$data_ajax['success'] = false;
		$hapus = $this->front->hapus_data('slide_id', $id, 'slide');
		if($hapus){
			$data_ajax['success'] = true;
			$data_ajax['message'] = '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data slide berhasil dihapus</div>';
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data slide gagal dihapus</div>';
		}
		echo json_encode($data_ajax);
	}

	public function tentang_kami(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Tentang Kami';
		$this->load->view('templating/header',$data);
		$this->load->view('content/kelola_frontend/v_tentang_kami',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_tentang_kami(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$column_search = array('content_nama');
		$column_order = array('content_id','content_nama');
		$order = array('content_id' => 'asc');

		$list = $this->front->get_daftar_tentangkami($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->content_nama;
			$row[] = '<a href="'.site_url('front/edit_tentangkami/'.$field->content_id).'" title="Lihat">
						<span class="btn btn-xs btn-warning"><i class="icon wb-pencil" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>&nbsp;<a href="'.$field->content_id.'" class="btn btn-danger btn-xs" id="btn-hapus"><i class="fa fa-remove"></i></a>';
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->front->total_record('vwtentang_kami'),
            "recordsFiltered" => $this->front->jumlah_filter_daftar_tentangkami($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function add_tentangkami(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Add Tentang Kami';
		$this->load->view('templating/header',$data);
		$this->load->view('content/kelola_frontend/v_input_tentangkami',$data);
		$this->load->view('templating/footer',$data);
	}
	public function insert_tentangkami(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|alpha_numeric_spaces|min_length[5]|required');
		if($this->form_validation->run() == TRUE){
			$menu = trim($this->input->post('nama', true));
			$menu = preg_replace("/[0-9]/", "", $menu);
			$menu = preg_replace('/\s+/', '_', $menu);

			$data = array(
				'content_nama' => trim($this->input->post('nama', true)),
				'content_isi' => trim($this->input->post('isi', true)),
				'content_menu' => 'tentang_kami',
				'content_alias' => $menu,
			);
			$insert = $this->front->insert_data($data, 'post_content');
			if($insert){
				$data_ajax['success'] = true;
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data berhasil ditambahkan</div>');
			}else{
				$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diinput, coba sekali lagi</div>';
			}
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diinput, pastikan data terisi dengan benar</div>';
		}
		echo json_encode($data_ajax);
	}
	public function edit_tentangkami(){
		$id = $this->uri->segment(3);
		$konten = $this->front->get_data_id('content_id', $id, 'post_content');
		if($konten->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		$data['konten'] = $konten->row();
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Edit Tentang Kami';
		$this->load->view('templating/header',$data);
		$this->load->view('content/kelola_frontend/v_input_tentangkami',$data);
		$this->load->view('templating/footer',$data);
	}
	public function update_tentang_kami(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'Id', 'trim|integer|required');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|alpha_numeric_spaces|min_length[5]|required');
		if($this->form_validation->run() == TRUE){
			$id = trim($this->input->post('id', true));
			$menu = trim($this->input->post('nama', true));
			$menu = preg_replace("/[0-9]/", "", $menu);
			$menu = preg_replace('/\s+/', '_', $menu);

			$data = array(
				'content_nama' => trim($this->input->post('nama', true)),
				'content_isi' => trim($this->input->post('isi', true)),
				'content_alias' => $menu,
			);
			$update = $this->front->update_data('content_id', $id, $data, 'post_content');
			if($update){
				$data_ajax['success'] = true;
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data berhasil diedit</div>');
			}else{
				$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diedit</div>';
			}
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diedit</div>';
		}
		echo json_encode($data_ajax);
	}
	public function delete_tentangkami(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		
		$id = trim($this->input->post('id', true));
		$data_ajax['success'] = false;
		$hapus = $this->front->hapus_data('content_id', $id, 'post_content');
		if($hapus){
			$data_ajax['success'] = true;
			$data_ajax['message'] = '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data berhasil dihapus</div>';
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal dihapus, silahkan coba lagi</div>';
		}
		echo json_encode($data_ajax);
	}

	public function agenda(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Agenda';
		$this->load->view('templating/header',$data);
		$this->load->view('content/kelola_frontend/v_agenda',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_data_agenda(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$column_search = array('content_nama');
		$column_order = array('content_id','content_nama');
		$order = array('content_id' => 'asc');

		$list = $this->front->get_daftar_agenda($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->content_nama;
			$row[] = '<a href="'.site_url('front/edit_agenda/'.$field->content_id).'" title="Lihat">
						<span class="btn btn-xs btn-warning"><i class="icon wb-pencil" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>&nbsp;<a href="'.$field->content_id.'" class="btn btn-danger btn-xs" id="btn-hapus"><i class="fa fa-remove"></i></a>';
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->front->total_record('vwagenda'),
            "recordsFiltered" => $this->front->jumlah_filter_daftar_agenda($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function add_agenda(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Add Agenda';
		$this->load->view('templating/header',$data);
		$this->load->view('content/kelola_frontend/v_input_agenda',$data);
		$this->load->view('templating/footer',$data);
	}
	public function insert_agenda(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|alpha_numeric_spaces|min_length[5]|required');
		if($this->form_validation->run() == TRUE){
			$menu = trim($this->input->post('nama', true));
			$menu = preg_replace("/[0-9]/", "", $menu);
			$menu = preg_replace('/\s+/', '_', $menu);

			$data = array(
				'content_nama' => trim($this->input->post('nama', true)),
				'content_isi' => trim($this->input->post('isi', true)),
				'content_menu' => 'agenda',
				'content_alias' => $menu,
			);
			$insert = $this->front->insert_data($data, 'post_content');
			if($insert){
				$data_ajax['success'] = true;
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data berhasil ditambahkan</div>');
			}else{
				$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diinput, coba sekali lagi</div>';
			}
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diinput, pastikan data terisi dengan benar</div>';
		}
		echo json_encode($data_ajax);
	}
	public function edit_agenda(){
		$id = $this->uri->segment(3);
		$konten = $this->front->get_data_id('content_id', $id, 'post_content');
		if($konten->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		$data['konten'] = $konten->row();
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Edit Agenda';
		$this->load->view('templating/header',$data);
		$this->load->view('content/kelola_frontend/v_input_agenda',$data);
		$this->load->view('templating/footer',$data);
	}

	public function pengumuman(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Berita';
		$this->load->view('templating/header',$data);
		$this->load->view('content/kelola_frontend/v_berita',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_data_berita(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$column_search = array('pengumuman_judul','pengumuman_tanggal');
		$column_order = array('pengumuman_id','pengumuman_gambar','pengumuman_judul','pengumuman_tanggal');
		$order = array('pengumuman_id' => 'asc');

		$list = $this->front->get_daftar_berita($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = '<img src="'.base_url().'assets/media/pengumuman/'.$field->pengumuman_gambar.'" width="100" height="100">';
			$row[] = $field->pengumuman_judul;
			$row[] = date('d-m-Y', strtotime($field->pengumuman_tanggal));
			$row[] = '<a href="'.site_url('front/edit_berita/'.$field->pengumuman_id).'" title="Lihat">
						<span class="btn btn-xs btn-warning"><i class="icon wb-pencil" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>&nbsp;<a href="'.$field->pengumuman_id.'" class="btn btn-danger btn-xs" id="btn-hapus"><i class="fa fa-remove"></i></a>';
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->front->total_record('pengumuman'),
            "recordsFiltered" => $this->front->jumlah_filter_daftar_berita($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function add_berita(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Add Berita';
		$this->load->view('templating/header',$data);
		$this->load->view('content/kelola_frontend/v_input_berita',$data);
		$this->load->view('templating/footer',$data);
	}
	public function insert_pengumuman(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('judul', 'Judul', 'trim|alpha_numeric_spaces|min_length[5]|required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
		$this->form_validation->set_rules('isi', 'Isi', 'trim|required');
		if (empty($_FILES['fileupload']['name'])){
    		$this->form_validation->set_rules('fileupload', 'Fileupload', 'required');
		}
		// dd($_POST);
		if($this->form_validation->run() == TRUE){
			$menu = trim($this->input->post('judul', true));
			$menu = preg_replace("/[0-9]/", "", $menu);
			$menu = preg_replace('/\s+/', '_', $menu);

			$data = array(
				'pengumuman_judul' => trim($this->input->post('judul', true)),
				'pengumuman_isi' => trim($this->input->post('isi', true)),
				'pengumuman_tanggal' => set_date_input(trim($this->input->post('tanggal', true))),
				'pengumuman_penulis' => $this->session->userdata('fullname'),
				'pengumuman_alias' => $menu,
			);

			$config['upload_path'] = './assets/media/pengumuman/';
			$config['allowed_types'] = 'jpg|png|jpeg'; 
			$config['max_size'] = '2000'; 
			$config['file_name'] = 'pengumuman_'.time();
			$this->load->library('upload', $config); 
			if ($this->upload->do_upload('fileupload')){
				$gbr = $this->upload->data();
				$data['pengumuman_gambar'] = $gbr['file_name'];
			}

			$insert = $this->front->insert_data($data, 'pengumuman');
			if($insert){
				$data_ajax['success'] = true;
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data berhasil ditambahkan</div>');
			}else{
				$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diinput, coba sekali lagi</div>';
			}
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diinput, pastikan data terisi dengan benar</div>';
		}
		echo json_encode($data_ajax);
	}
	public function edit_berita(){
		$id = $this->uri->segment(3);
		$berita = $this->front->get_data_id('pengumuman_id', $id, 'pengumuman');
		if($berita->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		$data['berita'] = $berita->row();
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Edit Berita';
		$this->load->view('templating/header',$data);
		$this->load->view('content/kelola_frontend/v_input_berita',$data);
		$this->load->view('templating/footer',$data);
	}
	public function update_pengumuman(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('judul', 'Judul', 'trim|alpha_numeric_spaces|min_length[5]|required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
		$this->form_validation->set_rules('isi', 'Isi', 'trim|required');
		$this->form_validation->set_rules('id', 'Id', 'trim|integer|required');
		if($this->form_validation->run() == TRUE){
			$id = trim($this->input->post('id', true));
			$data_peng = $this->front->get_data_id('pengumuman_id', $id, 'pengumuman');
			$menu = trim($this->input->post('judul', true));
			$menu = preg_replace("/[0-9]/", "", $menu);
			$menu = preg_replace('/\s+/', '_', $menu);

			$data = array(
				'pengumuman_judul' => trim($this->input->post('judul', true)),
				'pengumuman_isi' => trim($this->input->post('isi', true)),
				'pengumuman_tanggal' => set_date_input(trim($this->input->post('tanggal', true))),
				'pengumuman_penulis' => $this->session->userdata('fullname'),
				'pengumuman_alias' => $menu,
			);

			$config['upload_path'] = './assets/media/pengumuman/';
			$config['allowed_types'] = 'jpg|png|jpeg'; 
			$config['max_size'] = '2000'; 
			$config['file_name'] = 'pengumuman_'.time();
			$this->load->library('upload', $config); 
			if ($this->upload->do_upload('fileupload')){
				$gbr = $this->upload->data();
				$data['pengumuman_gambar'] = $gbr['file_name'];
				if($data_peng->num_rows() > 0){
					$gambar = './assets/media/pengumuman/'.$data_peng->row()->pengumuman_gambar;
					if(file_exists($gambar))
						unlink($gambar);
				}
			}

			$update = $this->front->update_data('pengumuman_id', $id, $data, 'pengumuman');
			if($update){
				$data_ajax['success'] = true;
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data berhasil diedit</div>');
			}else{
				$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diedit, coba sekali lagi</div>';
			}
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diedit, pastikan data terisi dengan benar</div>';
		}
		echo json_encode($data_ajax);
	}
	public function delete_berita(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		
		$id = trim($this->input->post('id', true));
		$berita = $this->front->get_data_id('pengumuman_id', $id, 'pengumuman');
		if($berita->num_rows() == 0){
			if(file_exists('./assets/media/pengumuman/'.$berita->row()->pengumuman_gambar))
				unlink('./assets/media/pengumuman/'.$berita->row()->pengumuman_gambar);
		}

		$data_ajax['success'] = false;
		$hapus = $this->front->hapus_data('pengumuman_id', $id, 'pengumuman');
		if($hapus){
			$data_ajax['success'] = true;
			$data_ajax['message'] = '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data pengumuman berhasil dihapus</div>';
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data pengumuman gagal dihapus</div>';
		}
		echo json_encode($data_ajax);
	}
	public function kegiatan(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Kegiatan';
		$this->load->view('templating/header',$data);
		$this->load->view('content/kelola_frontend/v_kegiatan',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_data_kegiatan(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$column_search = array('kegiatan_nama','kegiatan_tanggal');
		$column_order = array('kegiatan_id','kegiatan_gambar','kegiatan_nama','kegiatan_tanggal');
		$order = array('kegiatan_id' => 'asc');

		$list = $this->front->get_daftar_kegiatan($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = '<img src="'.base_url().'assets/media/kegiatan/'.$field->kegiatan_gambar.'" width="100" height="100">';
			$row[] = $field->kegiatan_nama;
			$row[] = date('d-m-Y', strtotime($field->kegiatan_tanggal));
			$row[] = '<a href="'.site_url('frontend/edit_kegiatan/'.$field->kegiatan_id).'" title="Lihat">
						<span class="btn btn-xs btn-warning"><i class="icon wb-pencil" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>&nbsp;<a href="'.$field->kegiatan_id.'" class="btn btn-danger btn-xs" id="btn-hapus"><i class="fa fa-remove"></i></a>';
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->front->total_record('kegiatan'),
            "recordsFiltered" => $this->front->jumlah_filter_daftar_kegiatan($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function add_kegiatan(){
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Add Kegiatan';
		$this->load->view('templating/header',$data);
		$this->load->view('content/kelola_frontend/v_input_kegiatan',$data);
		$this->load->view('templating/footer',$data);
	}
	public function insert_kegiatan(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|min_length[5]|required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
		$this->form_validation->set_rules('isi', 'Isi', 'trim|required');
		if (empty($_FILES['fileupload']['name'])){
    		$this->form_validation->set_rules('fileupload', 'Fileupload', 'required');
		}
		if($this->form_validation->run() == TRUE){
			$data = array(
				'kegiatan_kategori' => trim($this->input->post('kategori', true)),
				'kegiatan_nama' => trim($this->input->post('nama', true)),
				'kegiatan_desc' => trim($this->input->post('isi', true)),
				'kegiatan_tanggal' => set_date_input(trim($this->input->post('tanggal', true))),
			);

			$config['upload_path'] = './assets/media/kegiatan/';
			$config['allowed_types'] = 'jpg|png|jpeg'; 
			$config['max_size'] = '2000'; 
			$config['file_name'] = 'kegiatan_'.time();
			$this->load->library('upload', $config); 
			if ($this->upload->do_upload('fileupload')){
				$gbr = $this->upload->data();
				$data['kegiatan_gambar'] = $gbr['file_name'];
			}

			$insert = $this->front->insert_data($data, 'kegiatan');
			if($insert){
				$data_ajax['success'] = true;
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data berhasil ditambahkan</div>');
			}else{
				$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diinput, coba sekali lagi</div>';
			}
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diinput, silahkan isi form dengan benar</div>';
		}
		echo json_encode($data_ajax);
	}
	public function edit_kegiatan(){
		$id = $this->uri->segment(3);
		$kegiatan = $this->front->get_data_id('kegiatan_id', $id, 'kegiatan');
		if($kegiatan->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		$data['kegiatan'] = $kegiatan->row();
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['title'] = 'Edit Kegiatan';
		$this->load->view('templating/header',$data);
		$this->load->view('content/kelola_frontend/v_input_kegiatan',$data);
		$this->load->view('templating/footer',$data);
	}
	public function update_kegiatan(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|min_length[5]|required');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
		$this->form_validation->set_rules('isi', 'Isi', 'trim|required');
		$this->form_validation->set_rules('id', 'Id', 'trim|integer|required');
		if($this->form_validation->run() == TRUE){
			$id = trim($this->input->post('id', true));
			$data_keg = $this->front->get_data_id('kegiatan_id', $id, 'kegiatan');

			$data = array(
				'kegiatan_kategori' => trim($this->input->post('kategori', true)),
				'kegiatan_nama' => trim($this->input->post('nama', true)),
				'kegiatan_desc' => trim($this->input->post('isi', true)),
				'kegiatan_tanggal' => set_date_input(trim($this->input->post('tanggal', true))),
			);

			$config['upload_path'] = './assets/media/kegiatan/';
			$config['allowed_types'] = 'jpg|png|jpeg'; 
			$config['max_size'] = '2000'; 
			$config['file_name'] = 'kegiatan_'.time();
			$this->load->library('upload', $config); 
			if ($this->upload->do_upload('fileupload')){
				$gbr = $this->upload->data();
				$data['kegiatan_gambar'] = $gbr['file_name'];
				if($data_keg->num_rows() > 0){
					$gambar = './assets/media/kegiatan/'.$data_keg->row()->kegiatan_gambar;
					if(file_exists($gambar))
						unlink($gambar);
				}
			}

			$update = $this->front->update_data('kegiatan_id', $id, $data, 'kegiatan');
			if($update){
				$data_ajax['success'] = true;
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data berhasil diedit</div>');
			}else{
				$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diedit, coba sekali lagi</div>';
			}
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data gagal diedit, silahkan isi form dengan benar</div>';
		}
		echo json_encode($data_ajax);
	}
	public function delete_kegiatan(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		
		$id = trim($this->input->post('id', true));
		$kegiatan = $this->front->get_data_id('kegiatan_id', $id, 'kegiatan');
		if($kegiatan->num_rows() == 0){
			if(file_exists('./assets/media/kegiatan/'.$kegiatan->row()->pengumuman_gambar))
				unlink('./assets/media/kegiatan/'.$kegiatan->row()->pengumuman_gambar);
		}

		$data_ajax['success'] = false;
		$hapus = $this->front->hapus_data('kegiatan_id', $id, 'kegiatan');
		if($hapus){
			$data_ajax['success'] = true;
			$data_ajax['message'] = '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data kegiatan berhasil dihapus</div>';
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data kegiatan gagal dihapus</div>';
		}
		echo json_encode($data_ajax);
	}
}
