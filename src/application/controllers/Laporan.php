<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Laporan extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('tgl_indonesia','notif'));
		$this->load->model(array('Main','Model_laporan'));	
		$this->load->library('menubackend');
		cek_aktif();	
	}

	public function sop(){			
		$data['title'] = 'Laporan Daftar SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);

		$this->load->view('templating/header',$data);
		$this->load->view('content/laporan/v_daftar_sop',$data);
		$this->load->view('templating/footer',$data);	
	}
	public function laporan_sop(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$column_search = array('sop_no','sop_nama','sop_tgl_pembuatan','sop_update_file');
		$column_order = array('sop_index','sop_index','sop_nama','sop_tgl_pembuatan','sop_update_file');
		$order = array('sop_index' => 'desc');

		$list = $this->Model_laporan->get_daftar_sop($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->sop_no;
			$row[] = $field->sop_nama;
			$row[] = $field->sop_tgl_pembuatan;

			if($field->sop_update_file == '')
				$row[] = '<span class="badge badge-md badge-info" style="color:#fff; font-size:11px">Auto</span>';
			else
				$row[] = '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">Manual</span>';

			$row[] = '<a href="'.site_url('laporan/detail_sop/'.$field->sop_alias).'" title="Lihat">
						<span class="btn btn-xs btn-info"><i class="icon wb-eye" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>';
			$data[] = $row;
		}
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Model_laporan->total_record('sop'),
            "recordsFiltered" => $this->Model_laporan->jumlah_filter_daftar_sop($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function detail_sop(){
		$alias = $this->uri->segment(3);
		$this->load->model('Model_sop','sop');
		$this->load->helper('kegiatan');
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

		$data['back_link'] = site_url('laporan/sop');
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/detail_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function excel_sop(){		
		$satorg = $this->uri->segment(3);
		$deputi = $this->uri->segment(4);
		$biro = $this->uri->segment(5);

		$data['data'] = $this->Model_laporan->laporan_sop($satorg, $deputi, $biro);
		$this->load->view('content/laporan/lap_sop',$data);
	}
}