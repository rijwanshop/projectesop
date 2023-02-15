<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengolahan_sop extends CI_Controller {

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
		$this->sinkron_data_jabatan();
		$data['title'] = 'Daftar SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/data_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	private function sinkron_data_jabatan(){

		if($this->session->userdata['sinkron_data'] == false){
			$this->load->helper('string');
			if(!in_array($this->session->userdata('satkerid'), array('01','02'))){
				$form_data = array(
        			'satorg' => $this->session->userdata['satkerid'],
        			'deputi' => $this->session->userdata['unitkerjaid'],
    			);
			}else{
				$form_data = array(
        			'satorg' => $this->session->userdata['satkerid'],
        			'deputi' => $this->session->userdata['iddeputi'],
        			'biro' => $this->session->userdata['unitkerjaid'],
    			);
			}
        	$url_data = http_build_query($form_data);

        	$this->config->load('web_service');
			$curl = curl_init();
			curl_setopt_array($curl, array(
 	 			CURLOPT_URL => $this->config->item('api_pegawai').'esop/jabatan?'.$url_data,
  				CURLOPT_RETURNTRANSFER => true,
  				CURLOPT_ENCODING => '',
  				CURLOPT_MAXREDIRS => 10,
  				CURLOPT_TIMEOUT => 0,
  				CURLOPT_FOLLOWLOCATION => true,
  				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
  				CURLOPT_CUSTOMREQUEST => 'GET',
  				CURLOPT_HTTPHEADER => array(
    				'Authorization: Basic '.base64_encode($this->config->item('api_pegawai_username').':'.$this->config->item('api_pegawai_password'))
  				),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			$resArray = json_decode($response, true);
			if($resArray['status'] == 'OK' && $resArray['data'] != null){
				foreach ($resArray['data'] as $row){
					$arr_where = array(
						'nama_jabatan' => $row['jabatan'],
						'id_unit' => $row['id_unit'],
						'id_deputi' => $row['id_deputi'],
						'id_biro' => $row['id_biro'],
					);
					$cek = $this->sop->cek_jabatan($arr_where);
					if($cek->num_rows() == 0){
						$data = array(
							'nama_jabatan' => $arr_where['nama_jabatan'],
							'id_unit' => $arr_where['id_unit'],
							'id_deputi' => $arr_where['id_deputi'],
							'id_biro' => $arr_where['id_biro'],
						);
						$data['singkatan'] = strtoupper(random_string('alpha', 4));
						while(true){
							$cek_singkatan = $this->sop->get_data_id('singkatan', $data['singkatan'], 'm_singkatan_unit');
							if($cek_singkatan->num_rows() == 0)
								break;
						}

						$n_unsur = $this->sop->total_record('m_singkatan_unit');
						if($n_unsur == 0){
							$data['idsingkatan'] = 'SJ.000001';
						}else{
							$dt_id = $this->sop->max_id('idsingkatan', 'm_singkatan_unit');
							$dt_id = $dt_id->row()->idsingkatan;
							$next_id = ((int)str_replace('SJ.', '', $dt_id))+1;
							$data['idsingkatan'] = 'SJ.'.sprintf("%06s", $next_id);
						}

						$this->sop->insert_data($data, 'm_singkatan_unit');
					}
				}
			}
			$data = array();
			$this->session->set_userdata('sinkron_data', true);
		}

	}
	public function get_data_sop(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$column_search = array('sop_no','sop_nama','sop_status', 'sop_step');
		$column_order = array('sop_alias','sop_no','sop_nama','sop_tgl_pembuatan','sop_status','sop_step','sop_update_file');
		$order = array('sop_index' => 'desc');

		$list = $this->sop->get_daftar_sop($column_search, $column_order, $order);
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
							<a class="dropdown-item" href="'.site_url('pengolahan_sop/detail_sop/'.enkripsi_id_detail($field->sop_alias)).'" role="menuitem">
								<i class="icon wb-eye" aria-hidden="true"></i> Lihat
							</a>
							<a class="dropdown-item" href="'.site_url('pengolahan_sop/history_sop/'.enkripsi_id_url($field->sop_alias)).'" role="menuitem">
								<i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;History
							</a>';

			if($field->sop_step == ''){
				$action .='<a class="dropdown-item" href="'.base_url().'pengolahan_sop/edit_sop/'.enkripsi_id_url($field->sop_alias).'" role="menuitem">
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
				$action .='&nbsp;<a class="btn btn-icon btn-success btn-xs" href="'.site_url('pengolahan_sop/view_kirim_sop/'.enkripsi_id_url($field->sop_alias)).'">
								  <i class="fa fa-send" aria-hidden="true"></i> Reviewer
								</a>';
			}

			$row[] = $action;
			$data[] = $row;
		}
		$output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->sop->total_record('sop'),
            "recordsFiltered" => $this->sop->jumlah_filter_daftar_sop($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function get_csrf(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
        echo json_encode($this->security->get_csrf_hash());
    }
	public function pembuatan_sop(){
		$no = $this->sop->no_urut_sop($this->session->userdata('satkerid'), $this->session->userdata('iddeputi'), $this->session->userdata('unitkerjaid'), date('Y'));
		if($no->num_rows() > 0)
			$data['sop_no'] = ($no->row()->sop_nourut+1).'/'.date('Y');
		else
			$data['sop_no'] = '1/'.date('Y');

		$dtjabatan = get_list_pengesah();
		$data['list_pengesah'] = $dtjabatan;
		$data['title'] = 'Penyusunan SOP';
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
		$this->load->view('content/sop/v_pembuatan_sop_baru',$data);
		$this->load->view('templating/footer',$data);
	}
	public function booking_nomor(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$tahun = trim($this->input->get('tahun', true));

		$satorg = trim($this->input->get('satorg', true));
		$deputi = trim($this->input->get('deputi', true));
		$biro = trim($this->input->get('biro', true));

		if($satorg == '')
			$no = $this->sop->no_urut_sop($this->session->userdata('satkerid'), $this->session->userdata('iddeputi'), $this->session->userdata('unitkerjaid'), $tahun);
		else
			$no = $this->sop->no_urut_sop($satorg, $deputi, $biro, $tahun);

		if($no->num_rows() > 0)
			$data['sop_no'] = ($no->row()->sop_nourut+1).'/'.$tahun;
		else
			$data['sop_no'] = '1/'.$tahun;

		$alias = trim($this->input->get('alias', true));
		if($alias != ''){
			$dt_sop = $this->sop->detail_sop($alias);
			if($dt_sop->num_rows() > 0){
				if (strpos($dt_sop->row()->sop_no, $tahun) !== false) {
    				$data['sop_no'] = $dt_sop->row()->sop_no;
				}
			}
		}
		echo json_encode($data);
	}
	public function get_unit_pengesah(){
		$nip = trim($this->input->get('nip', true));
		$dtjabatan = get_list_pengesah();
		$data['success'] = false;
		foreach ($dtjabatan as $row){
			if($row['nipbaru'] == $nip){
				$data['success'] = true;
				$data['nama_pegawai'] = $row['nama_pegawai'];
				$data['nipbaru'] = $row['nipbaru'];
				$data['jabatan'] = $row['jabatan'];
				$data['satorg'] = $row['satorg'];
				$data['deputi'] = $row['deputi'];
				$data['biro'] = $row['biro'];
			}
		}
		echo json_encode($data);
	}
	public function get_list_sop_terkait(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$search = trim($this->input->get('search', true));
		$result = $this->sop->get_list_sop($search);
		$response = array();
		foreach($result->result() as $row){
            $response[] = array(
                'label' => $row->sop_nama,
                'link' => enkripsi_id_detail($row->sop_alias),
            );
        }
        echo json_encode($response);
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
				'sop_status' => 'Draft',
				'sop_status_publish' => 'publish',
			);

			if($dt_alias->num_rows() == 0)
				$data['sop_alias'] = 1;
			else
				$data['sop_alias'] = $dt_alias->row()->random_num;

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
	public function update_header_sop(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'Id', 'trim|required');
		$this->form_validation->set_rules('tgl_sop', 'Tgl_sop', 'trim|required');
		$this->form_validation->set_rules('nama_sop', 'Nama_sop', 'trim|required');
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
		$this->form_validation->set_rules('no_sop', 'No_sop', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$sop_alias = trim($this->input->post('id', true));
			$no_sop = trim($this->input->post('no_sop', true));
			$dt_no = explode('/', $no_sop);

			$data = array(
				'sop_no' => $no_sop,
				'sop_nourut' => $dt_no[0],
				'sop_index' => $dt_no[1].$dt_no[0],
				'sop_nama_satker' => strtoupper(trim($this->input->post('nm_satker', true))),
				'sop_deputi' => strtoupper(trim($this->input->post('nm_deputi', true))),
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

			$update = $this->sop->update_data('sop_alias', $sop_alias, $data, 'sop');
			if($update){
				//create header PDF SOP
				$this->load->helper('eksport');
				eksport_header($sop_alias);
				merge_pdf($sop_alias);

				$data_ajax['success'] = true;
				$data_ajax['message'] = 'Data sop berhasil diedit';
				$data_ajax['id'] = $sop_alias;

				$data_view['sop'] = $this->sop->detail_sop($sop_alias)->row();
				$data_ajax['content'] = $this->load->view('content/sop/header_create', $data_view, true);
			}else{
				$data_ajax['message'] = 'Data sop gagal diedit';
			}
		}else{
			$data_ajax['message'] = 'Data sop gagal diedit, silahkan isi form dengan benar';
		}
		echo json_encode($data_ajax);
	}
	public function save_pelaksana(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_kegiatan', 'Id_kegiatan', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$sop_alias = $this->input->post('id_kegiatan');
			$pelaksana = $this->input->post('pelaksana');

			$data_update = array();
			for($i=0; $i<count($pelaksana); $i++){
				if($this->sop->validate_singkatan($pelaksana[$i]) == true){
					$idx = $i+1;
					$data_update['sop_nm_pel'.$idx] = $pelaksana[$i];
				}else{
					$data_update['sop_nm_pel'.$idx] = '';
				}
			}
			$update = $this->sop->update_data('sop_alias', $sop_alias, $data_update, 'sop');
			if($update){
				$data_ajax['success'] = true;
				$data_ajax['message'] = 'Data pelaksana berhasil disimpan';
			}else{
				$data_ajax['message'] = 'Data pelaksana gagal disimpan';
			}
		}else{
			$data_ajax['message'] = 'Gagal melakukan penyimpanan pelaksana, data tidak lengkap';
		}
		echo json_encode($data_ajax);
	}
	public function get_pelaksana(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$pel = trim($this->input->get('search', true));
		$alias = trim($this->input->get('alias', true));
		$dt_sop = $this->sop->get_data_id('sop_alias', $alias, 'sop');
		$list_pelaksana = array();

		if($dt_sop->num_rows() > 0){
			$dt_sop = $dt_sop->result_array();
			for($i=1; $i<16; $i++){
				if($dt_sop[0]['sop_nm_pel'.$i] != ''){
					$list_pelaksana[] = $dt_sop[0]['sop_nm_pel'.$i];
				}
			}
		}
		if(count($list_pelaksana) == 0){
			$list_pelaksana[0] = 'not';
		}

		$result = $this->sop->get_pelaksana($pel, $list_pelaksana);
		$response = array();
		foreach($result->result() as $row){
            $response[] = array(
                'label' => $row->singkatan,
                'keterangan' => $row->nama_jabatan,
            );
        }
        echo json_encode($response);
	}
	public function save_kegiatan(){
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_kegiatan', 'Id_kegiatan', 'trim|required');
		if($this->form_validation->run() == TRUE){
			save_kegiatan();

			$data_ajax['success'] = true;
			$data_view['count'] = trim($this->input->post('count', true));
			$data_view['no'] = trim($this->input->post('no', true));
			$data_ajax['content'] = $this->load->view('content/sop/field_kegiatan', $data_view, true);
			$data_ajax['message'] = 'Data kegiatan SOP berhasil ditambahkan';
		}else{
			$data_ajax['message'] = 'Data kegiatan SOP gagal ditambahkan, input tidak valid';
		}
		echo json_encode($data_ajax);
	}
	public function update_field_kegiatan(){
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_kegiatan', 'Id_kegiatan', 'trim|required');
		$this->form_validation->set_rules('sop_update_file', 'Sop_update_file', 'trim|in_list[auto,manual]|required');
		$this->form_validation->set_rules('type_draft', 'Type_draft', 'trim|in_list[file,link]');
		$this->form_validation->set_rules('link_draft', 'Link_draft', 'trim|valid_url');
		if($this->form_validation->run() == TRUE){
			$jenis = trim($this->input->post('sop_update_file',true));
			$alias = trim($this->input->post('id_kegiatan', true));
			if($jenis == 'manual'){
				$cek = $this->sop->get_data_id('sop_alias', $alias, 'sop_update');
				if($cek->num_rows() == 0){ //insert

					$config['upload_path'] = $this->config->item('path_draftpdf');
					$config['allowed_types'] = 'pdf'; 
					$config['max_size'] = '3000'; 
					$config['file_name'] = 'manual_sop_'.$alias;
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('fileupload')){

						$data = array();
						$gbr = $this->upload->data();
						$data['sop_update_file'] = $gbr['file_name'];

						//set permisson file
						if(is_file($this->config->item('path_draftpdf').$gbr['file_name'])){
							chmod($this->config->item('path_draftpdf').$gbr['file_name'], 0777);
						}

						//input draft SOP
						$type_draft = trim($this->input->post('type_draft', true));
						$error = '';
						if($type_draft == 'file'){

							$config2['upload_path'] = $this->config->item('path_draftword');
                			$config2['allowed_types'] = 'doc|docx';
                			$config2['max_size'] = '3000';
                			$config2['file_name'] = 'draft_sop_'.$alias;
                			$this->upload->initialize($config2);
                			if($this->upload->do_upload('filedraft')){
                				$gbr = $this->upload->data();
                    			$data['sop_draft_file'] = $gbr['file_name'];

                    			//set permisson file
                    			if(is_file($this->config->item('path_draftword').$gbr['file_name'])){
									chmod($this->config->item('path_draftword').$gbr['file_name'], 0777);
								}
                			}else{
                				$error = 'File draft SOP gagal diupload: '.$this->replace_p($this->upload->display_errors()).' ]';
                			}

						}elseif($type_draft == 'link'){
							if($this->input->post('link_draft'))
								$data['link_draft_file'] = trim($this->input->post('link_draft', true));
							else
								$error = 'Link Draft SOP belum diisi';
						}

						//create data kegiatan SOP
						$data['sop_alias'] = $alias;
                		$data['sop_update_tanggal'] = date('Y-m-d');
                		$this->sop->insert_data($data, 'sop_update');

                		//merge file PDF dengan header
						$this->load->helper('eksport');
						merge_pdf($alias);

                		//setting output ajax
                		$data_ajax['alias'] = $alias;
						$data_ajax['content'] = '';
						if($error == ''){
							$data_ajax['success'] = true;
							$data_ajax['message'] = 'Data Kegiatan SOP berhasil disimpan';
						}else{
							$data_ajax['message'] = $error;
						}
					}else{
						$data_ajax['message'] = 'File PDF SOP gagal diupload ('.$this->replace_p($this->upload->display_errors()).')';
					}

				}else{ //update
					$message = '';
					$merge = false;
					$data = array();

					//upload file PDF jika ada
					$config['upload_path'] = $this->config->item('path_draftpdf');
					$config['allowed_types'] = 'pdf'; 
					$config['max_size'] = '3000'; 
					$config['file_name'] = 'manual_sop_'.$alias.'_'.time();
					$this->load->library('upload', $config); 
					if ($this->upload->do_upload('fileupload')){
						$gbr = $this->upload->data();
						$data['sop_update_file'] = $gbr['file_name'];

						//hapus file sebelumnya
						$file_cek = $this->config->item('path_draftpdf').$cek->row()->sop_update_file;
						if(file_exists($file_cek)){
							unlink($file_cek);
						}

                    	//set permisson file
						if(is_file($this->config->item('path_draftpdf').$gbr['file_name'])){
							chmod($this->config->item('path_draftpdf').$gbr['file_name'], 0777);
						}
						$merge = true;
					}else{
						if (!empty($_FILES['fileupload']['name'])) 
							$message = '[File PDF SOP gagal diupload: '.$this->replace_p($this->upload->display_errors()).'] ';

						$data['sop_update_file'] = $cek->row()->sop_update_file;
					}


					$type_draft = trim($this->input->post('type_draft', true));
					if($type_draft == 'file'){
						//upload file draft PDF jika ada
						$config2['upload_path'] = $this->config->item('path_draftword');
                		$config2['allowed_types'] = 'doc|docx';
                		$config2['max_size'] = '3000';
                		$config2['file_name'] = 'draft_sop_'.$alias.'_'.time();
                		$this->upload->initialize($config2);
                		if($this->upload->do_upload('filedraft')){
                			$gbr = $this->upload->data();
                    		$data['sop_draft_file'] = $gbr['file_name'];

                    		//kosongkan link
                    		$data['link_draft_file'] = '';

                    		//hapus file sebelumnya
							if($cek->row()->sop_draft_file != ''){
								$file_cek = $this->config->item('path_draftword').$cek->row()->sop_draft_file;
								if(file_exists($file_cek)){
									unlink($file_cek);
								}
							}

							//set permisson file
                    		if(is_file($this->config->item('path_draftword').$gbr['file_name'])){
								chmod($this->config->item('path_draftword').$gbr['file_name'], 0777);
							}
                		}else{
                			if (!empty($_FILES['filedraft']['name'])) 
                				$message .= '[File draft gagal diupload: '.$this->replace_p($this->upload->display_errors()).']';

                			$data['sop_draft_file'] = $cek->row()->sop_draft_file;
                		}
					}elseif($type_draft == 'link'){
						if($this->input->post('link_draft')){

							//hapus file sebelumnya jika ada
							if($cek->row()->sop_draft_file != ''){
								$file_cek = $this->config->item('path_draftword').$cek->row()->sop_draft_file;
								if(file_exists($file_cek)){
									unlink($file_cek);
								}
							}
							//kosongkan file draft dan input link
							$data['sop_draft_file'] = '';
							$data['link_draft_file'] = trim($this->input->post('link_draft', true));
						}else{
							$message .= '[Link tidak boleh kosong]';
						}
					}

					$this->sop->update_data('sop_alias', $alias, $data, 'sop_update');

                	if($merge == true){
                		//merge file PDF baru dengan header
						$this->load->helper('eksport');
						merge_pdf($alias);
                	}

                	$data_ajax['alias'] = $alias;
					$data_ajax['content'] = '';
                	if($message == ''){
                		$data_ajax['success'] = true;
                		$data_ajax['message'] = 'Data kegiatan SOP berhasil disimpan';
                	}else{
                		$data_ajax['message'] = 'Data Kegiatan SOP gagal diedit '.$message;
                	}
                	
				}

			}else{
				save_kegiatan();
				
				$dt_sop = $this->sop->detail_sop($alias);

				$data['sop'] = $dt_sop;
				$data['no'] = 1;
				$data['img_chart'] = get_image_node($dt_sop->row()->sop_alias);

				if($dt_sop->row()->sop_jml_pelaksana >= 10)
					$data['jmlpel'] = 10;
				else
					$data['jmlpel'] = $dt_sop->row()->sop_jml_pelaksana;

				$data_ajax['success'] = true;
				$data_ajax['alias'] = $dt_sop->row()->sop_alias;
				$data_ajax['message'] = 'Data Kegiatan SOP berhasil disimpan';
				$data_ajax['content'] = $this->load->view('content/sop/kegiatan_create', $data, true);
			}
		}else{
			$data_ajax['message'] = 'Input tidak valid';
		}
		echo json_encode($data_ajax);
	}
	private function replace_p($string){
		$string = str_replace('</p>', '', $string);
		return str_replace('<p>', '', $string);
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
		$data['back_link'] = site_url('pengolahan_sop');
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

		$data['title'] = 'Daftar SOP';
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

		$data['back_link'] = site_url('pengolahan_sop');
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/detail_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function lihat_filesop(){
		$alias = dekripsi_id_detail($this->uri->segment(3));
		if($alias == false){
			echo 'Akses telah dibatasi';
			exit();
		}
		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}

		$file_pdf = $this->config->item('path_draftpdf').$dt_sop->row()->sop_update_file;
		if(file_exists($file_pdf)){
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="'.$dt_sop->row()->sop_nama.'"');
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');
			@readfile($file_pdf);
		}else{
			echo 'File tidak ditemukan';
		}
	}
	public function download_draftsop(){
		$alias = dekripsi_id_detail($this->uri->segment(3));
		if($alias == false){
			echo 'Akses telah dibatasi';
			exit();
		}
		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		$file_draft = $this->config->item('path_draftword').$dt_sop->row()->sop_draft_file;
		if(file_exists($file_draft)){
			$this->load->helper('download');
			force_download($file_draft, NULL);
		}else{
			echo 'File tidak ditemukan';
		}
	}
	public function view_kirim_sop(){
		$alias = dekripsi_id_url($this->uri->segment(3));
		if($alias == ''){
			echo 'Akses telah dibatasi';
			exit();
		}
		$sop = $this->sop->detail_sop($alias);
		if($sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}
		$this->cek_akses($sop);

		$data['sop'] = $sop;
		$data['review'] = true;

		$data['list_review'] = get_list_review($this->session->userdata['pegawainip']);

		$data['title'] = 'Permohonan Review SOP';
		$data['back_link'] = site_url('pengolahan_sop');
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/v_review',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_jabatan_review(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$nip = trim($this->input->get('nipbaru', true));

		if(!in_array($this->session->userdata('satkerid'), array('01','02'))){
			$form_data = array(
        		'satorg' => $this->session->userdata('satkerid'),
        		'deputi' => $this->session->userdata('unitkerjaid'),
    		);
		}else{
			$form_data = array(
        		'satorg' => $this->session->userdata('satkerid'),
        		'deputi' => $this->session->userdata('iddeputi'),
        		'biro' => $this->session->userdata('unitkerjaid'),
    		);
		}

		$url_data = http_build_query($form_data);
		$this->config->load('web_service');
		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => $this->config->item('api_pegawai').'esop/reviewer?'.$url_data,
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => '',
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 0,
  			//CURLOPT_FOLLOWLOCATION => true,
  			//CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
  			CURLOPT_CUSTOMREQUEST => 'GET',
  			CURLOPT_HTTPHEADER => array(
    			'Authorization: Basic '.base64_encode($this->config->item('api_pegawai_username').':'.$this->config->item('api_pegawai_password'))
  			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$data_ajax = array();
		$resArray = json_decode($response, true);
		if($resArray['status'] == 'OK' && $resArray['data'] != null){
			foreach ($resArray['data'] as $row){
				if($nip == $row['nipbaru']){
					$data_ajax['jabatan'] = $row['jabatanakhir'];
					$data_ajax['nama'] = $row['nmpeg'];
					$data_ajax['nip'] = $row['nipbaru'];
					break;
				}
			}
		}
		echo json_encode($data_ajax);
	}
	public function insert_review(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('alias', 'Alias', 'trim|required');
		$this->form_validation->set_rules('nama_sop', 'Nama_sop', 'trim|required');
		$this->form_validation->set_rules('nama_reviewer', 'Nama_reviewer', 'trim|required');
		$this->form_validation->set_rules('nip_reviewer', 'Nip_reviewer', 'trim|required');
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
		if($this->form_validation->run() == TRUE){
			 
			$data_insert = array(
				'sop_alias' => trim($this->input->post('alias', true)),
				'nama_pereview' => trim($this->input->post('nama_reviewer', true)),
				'nipbaru' => trim($this->input->post('nip_reviewer', true)),
				'jabatan' => trim($this->input->post('jabatan', true)),
				'tanggal_pengajuan' => date('Y-m-d H:i:s'),
				'status_pengajuan' => 'diajukan',
				'indikator' => 1,
			);
			$n_review = $this->sop->total_record('list_review_sop');
			if($n_review == 0){
				$data_insert['idlist_review'] = 'RV0000000001';
			}else{
				$dt_rev = $this->sop->get_alias_review();
				$data_insert['idlist_review'] = 'RV'.$dt_rev->row()->random_num;
			}
			
			$insert = $this->sop->insert_data($data_insert, 'list_review_sop');
			if($insert){
				$data_status = array(
					'sop_status' => 'Pending',
					'sop_step' => 'Reviewer',
				);
				$this->sop->update_data('sop_alias', $data_insert['sop_alias'], $data_status, 'sop');

				//disable history review lama
				$this->sop->update_indikator_review($data_insert['idlist_review'], $data_insert['nipbaru'], $data_insert['sop_alias']);

				//notif ke Reviewer
				$nama_sop = trim($this->input->post('nama_sop', true));
				$data_notif = array(
					'nama_pengirim' => $this->session->userdata('fullname'),
					'nip_pengirim' => $this->session->userdata('pegawainip'),
					'nama_penerima' => $data_insert['nama_pereview'],
					'nip_penerima' => $data_insert['nipbaru'],
					'status_baca' => 'Delivery',
					'status_action' => 0,
					'waktu' => date('Y-m-d H:i:s'),
					'jenis_notif' => 'Pengajuan Review',
					'alias_sop' => $data_insert['sop_alias'],
					'aktivitas' => 'Permohonan Review SOP: '.$nama_sop,
					'icon' => 'wb-order bg-green-600',
				);
				$this->sop->insert_data($data_notif, 'notifikasi');

				//input ke history
				$data_history = array(
					'icon' => 'fa fa-send',
					'warna' => 'info',
					'judul' => 'Pengajuan Review SOP',
					'aktivitas' => '[ '.$this->session->userdata('fullname').' ] [ '.$this->session->userdata('pegawainip').' ] sebagai Penyusun mengajukan Review SOP ke [ '.$data_insert['nama_pereview'].' ] [ '.$data_insert['nipbaru'].' ]',
					'waktu' => $data_insert['tanggal_pengajuan'],
					'alias_sop' => $data_insert['sop_alias'],
				);
				$this->sop->insert_data($data_history, 'history_sop');

				$data_ajax['success'] = true;
			}else{
				$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Pengajuan review gagal, silahkan coba sekali lagi</div>';
			}
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Pengajuan review gagal, silahkan isi form dengan benar</div>';
		}
		echo json_encode($data_ajax);
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

		$data['title'] = 'Edit Daftar SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		
		
		$data['list_pengesah'] = get_list_pengesah();
		
		$data['sop'] = $this->sop->detail_sop($alias);
		$data['arr_sop'] = $this->sop->detail_sop($alias)->result_array();
		$data['idx'] = 0;
		
		$data['dt_singkatan'] = $this->sop->list_singkatan_jabatan();
		$data['back_link'] = site_url('pengolahan_sop');
		$this->load->view('templating/header',$data);
		$this->load->view('content/sop/v_edit_sop',$data);
		$this->load->view('templating/footer',$data);
	}
	public function hapus_sop(){
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

		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() > 0){

			//hapus file header SOP
			$file_header = $this->config->item('path_exportpdf').'header_sop_'.$alias.'.pdf';
			if(file_exists($file_header)){
				unlink($file_header);
			}

			//hapus file merge
			$file_merge = $this->config->item('path_exportpdf').'merger_'.$alias.'.pdf';
			if(file_exists($file_merge)){
				unlink($file_merge);
			}

			//hapus File PDF SOP
			if($dt_sop->row()->sop_update_file != ''){
				$file_cek = $this->config->item('path_draftpdf').$dt_sop->row()->sop_update_file;
				if(file_exists($file_cek)){
					unlink($file_cek);
				}
			}else{

				//hapus file kegiatan
				$field_kegiatan = $this->config->item('path_exportpdf').'kegiatan_sop_'.$alias.'.pdf';
				if(file_exists($field_kegiatan)){
					unlink($field_kegiatan);
				}
			}

			//hapus Draft SOP
			if($dt_sop->row()->sop_draft_file != ''){
				$file_cek = $this->config->item('path_draftword').$dt_sop->row()->sop_draft_file;
				if(file_exists($file_cek)){
					unlink($file_cek);
				}
			}
						
		}
		
		$this->sop->hapus_data('sop_alias', $alias, 'penyusun_sop');
		$this->sop->hapus_data('sop_alias', $alias, 'list_review_sop');
		$this->sop->hapus_data('alias_sop', $alias, 'notifikasi');
		$this->sop->hapus_data('alias_sop', $alias, 'history_sop');
		$this->sop->hapus_data('sop_alias', $alias, 'sop_update');
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
