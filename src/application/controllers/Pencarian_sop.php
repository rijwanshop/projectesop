<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class pencarian_sop extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url', 'text_helper','date','tgl_indonesia'));
		$this->load->model(array('Main','Sop_m'));	
		$this->load->library(array('alias'));
		$this->load->model('Model_pencarian','pencarian');		
	}
	public function index(){			
		 $ip      = $_SERVER['REMOTE_ADDR'];
		 $tanggal = date("Y-m-d");
		 $waktu   = time();
		 $cek = $this->Main->cek_pengunjung($ip,$tanggal);
		 if($cek == 0){
			 $this->Main->insert_pengunjung($ip,$tanggal);
		 }else{
			 $this->Main->update_pengunjung($ip,$tanggal);
		 }
		 
		 
		 $data['title'] = 'Pencarian SOP';
		 $data['evaluasi'] = $this->Main->on_of_evaluasi();
		 $data['pengunjung'] = $this->Main->pengunjung_hariini($tanggal);
		 foreach ($this->Main->pengunjung_total()->result_array() as $row) 
		 {
			$data['totalpengunjung'] = $row['total'];
		 }
		 
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

		 $last_year = $this->pencarian->get_last_year();
		 $data['last_year'] = date('Y');
		 if($last_year->num_rows() == 1){
		 	$pecah = explode('/', $last_year->row()->sop_no);
		 	if(isset($pecah[1]))
		 		$data['last_year'] = $pecah[1];
		 }

		 $data['list_tahun'] = $dt_tahun;
		 
		 $data['tentangkami'] = $this->Main->edit_table('post_content','content_menu','tentang_kami');
		 $data['agenda'] = $this->Main->edit_table('post_content','content_menu','agenda');
		 $this->load->view('front/header',$data);
		 $this->load->view('front/pencarian',$data);
		 $this->load->view('front/footer',$data);
	}
	public function get_list_satorg(){
		$this->config->load('web_service');
		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => $this->config->item('api_pegawai').'esop/satorg',
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => '',
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 0,
  			//CURLOPT_FOLLOWLOCATION => true,
  			//CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => 'GET',
  			CURLOPT_HTTPHEADER => array(
    			'Authorization: Basic '.base64_encode($this->config->item('api_pegawai_username').':'.$this->config->item('api_pegawai_password'))
  			),
		));
		$response = curl_exec($curl);

		curl_close($curl);
		$resArray = json_decode($response, true);
		$data_option = array();
		if($resArray['status'] == 'OK' && $resArray['data'] != null){
			foreach ($resArray['data'] as $row){
				$data_option[] = array(
					'idsatorg' => $row['idunit'],
					'satorg' => $row['unit'],
				);
			}
		}
		echo json_encode($data_option);
	}
	public function get_list_deputi(){
		$this->config->load('web_service');
		$satorg = trim($this->input->post('satorg', true));
		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => $this->config->item('api_pegawai').'esop/deputi?satorg='.$satorg,
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => '',
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 0,
  			//CURLOPT_FOLLOWLOCATION => true,
  			//CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => 'GET',
  			CURLOPT_HTTPHEADER => array(
    			'Authorization: Basic '.base64_encode($this->config->item('api_pegawai_username').':'.$this->config->item('api_pegawai_password'))
  			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$resArray = json_decode($response, true);
		$data_option = array();
		if($resArray['status'] == 'OK' && $resArray['data'] != null){
			foreach ($resArray['data'] as $row){
				$data_option[] = array(
					'iddeputi' => $row['iddeputi'],
					'deputi' => $row['deputi'],
				);
			}
		}
		echo json_encode($data_option);
	}
	public function get_list_biro(){
		$this->config->load('web_service');
		$deputi = trim($this->input->post('deputi', true));
		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => $this->config->item('api_pegawai').'esop/biro?deputi='.$deputi,
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => '',
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 0,
  			//CURLOPT_FOLLOWLOCATION => true,
  			//CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => 'GET',
  			CURLOPT_HTTPHEADER => array(
    			'Authorization: Basic '.base64_encode($this->config->item('api_pegawai_username').':'.$this->config->item('api_pegawai_password'))
  			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$resArray = json_decode($response, true);
		$data_option = array();
		if($resArray['status'] == 'OK' && $resArray['data'] != null){
			foreach ($resArray['data'] as $row){
				$data_option[] = array(
					'idbiro' => $row['idbiro'],
					'biro' => $row['biro'],
				);
			}
		}
		echo json_encode($data_option);
	}
	public function get_data_sop(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$column_search = array('sop_no','sop_nama','nama_unit','sop_tgl_efektif');
		$column_order = array('sop_index','sop_index','sop_nama','satuan_organisasi_nama','nama_deputi', 'nama_unit','sop_tgl_efektif');
		$order = array('tgl_efektif' => 'desc');

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

			if($field->sop_label == 'berkas sop')
				$file = $this->config->item('path_draftpdf').'berkas_sop_'.$field->sop_alias.'.pdf';
			else
				$file = $this->config->item('path_exportpdf').'sop_tte_'.$field->sop_alias.'.pdf';

			if (file_exists($file)){
				$row[] = '<a href="'.site_url('pencarian_sop/lihat_sop/'.enkripsi_id_url($field->sop_alias)).'" target="_blank" title="lihat SOP">
						<span class="label label-success">
							<i class="fa fa-eye"></i>
							</span></a>&nbsp;<a href="'.site_url('pencarian_sop/download_sop/'.enkripsi_id_url($field->sop_alias)).'" target="_blank" title="Download SOP">
							<span class="label label-primary">
							<i class="fa fa-download"></i>
							</span></a>';
			}else{
				$row[] = '-';
			}
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pencarian->total_record('sop'),
            "recordsFiltered" => $this->pencarian->jumlah_filter_daftar_sop($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);

	}
	public function lihat_sop(){
		$alias = dekripsi_id_url($this->uri->segment(3));
		if($alias == ''){
			echo 'Akses telah dibatasi';
			exit();
		}
		$dt_sop = $this->pencarian->get_data_id('sop_alias', $alias, 'sop');
		if($dt_sop->num_rows() == 0){
			echo 'data tidak ditemukan';
			exit();
		}
		if($dt_sop->row()->sop_label == 'berkas sop')
			$file = $this->config->item('path_draftpdf').'berkas_sop_'.$alias.'.pdf';
		else
			$file = $this->config->item('path_exportpdf').'sop_tte_'.$alias.'.pdf';

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
	public function download_sop(){
		$alias = dekripsi_id_url($this->uri->segment(3));
		if($alias == ''){
			echo 'Akses telah dibatasi';
			exit();
		}
		$dt_sop = $this->pencarian->get_data_id('sop_alias', $alias, 'sop');
		if($dt_sop->num_rows() == 0){
			echo 'data tidak ditemukan';
			exit();
		}
		if($dt_sop->row()->sop_label == 'berkas sop')
			$file = $this->config->item('path_draftpdf').'berkas_sop_'.$alias.'.pdf';
		else
			$file = $this->config->item('path_exportpdf').'sop_tte_'.$alias.'.pdf';
		
		if (file_exists($file)){
			$this->load->helper('download');
			force_download($file, NULL);
		}else{
			echo 'File tidak ditemukan';
		}
	}
	public function download_filter_sop(){
		$satorg = $this->uri->segment(3);
		$deputi = $this->uri->segment(4);
		$biro = $this->uri->segment(5);
		$dt_file = $this->pencarian->get_filter_unit($satorg, $deputi, $biro);

		$this->load->library('zip');
		$count = 0;
		foreach ($dt_file->result() as $row){
			if($row->sop_label == 'berkas sop')
				$file = $this->config->item('path_draftpdf').'berkas_sop_'.$row->sop_alias.'.pdf';
			else
				$file = $this->config->item('path_exportpdf').'sop_tte_'.$row->sop_alias.'.pdf';
			if (file_exists($file)){
				$this->zip->read_file($file);
				$count++;
			}
		}
		if($count != 0)
			$this->zip->download('daftar sop '.time().'.zip');
		else
			echo 'Tidak ada file';
	}
	public function download_tte(){
		$alias = dekripsi_id_detail($this->uri->segment(3));
		if($alias == false){
			echo 'Kode salah';
			exit();
		}

		$this->load->model('Model_sop','sop');
		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}

		if($dt_sop->row()->sop_status != 'Disahkan'){
			echo 'SOP Belum disahkan';
			exit();
		}

		$file_pdf = $this->config->item('path_exportpdf').'sop_tte_'.$alias.'.pdf';
		if (file_exists($file_pdf)){
			$this->load->helper('download');
			force_download($file_pdf, NULL);
		}else{
			echo 'File tidak ditemukan';
		}
	}

}
