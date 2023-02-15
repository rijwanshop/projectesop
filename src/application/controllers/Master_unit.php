<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_unit extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('notif');
		$this->load->model('Main');	
		$this->load->library(array('menubackend'));
		$this->load->model('Model_master','master');
		cek_aktif();
	}
	public function index(){
		$data['title'] = 'Daftar Singkatan Jabatan';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$this->load->view('templating/header',$data);
		$this->load->view('content/master_unit/data_master_singkatan',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_data_singkatan(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$column_search = array('nama_jabatan','singkatan');
		$column_order = array('idsingkatan','nama_jabatan','singkatan');
		$order = array('idsingkatan' => 'desc');

		$list = $this->master->get_daftar_singkatan($column_search, $column_order, $order);
		$data = array();
        $no = $_POST['start'];
        foreach ($list as $field){
        	$no++;
            $row = array();
			$row[] = $no;
			$row[] = $field->nama_jabatan;
			$row[] = $field->singkatan;
			$row[] = '<a href="'.site_url('master_unit/view_edit_singkatan/'.$field->idsingkatan).'" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>&nbsp;
					<a href="'.$field->idsingkatan.'" class="btn btn-danger btn-xs" id="btn-hapus"><i class="fa fa-remove"></i></a>';
			$data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->master->total_record('m_singkatan_unit'),
            "recordsFiltered" => $this->master->jumlah_filter_daftar_singkatan($column_search, $column_order, $order),
            "data" => $data,
        );
        echo json_encode($output);
	}
	public function tarik_data_singkatan(){
		ini_set('max_execution_time', 0);
		$this->load->helper('string');

		//ambil data satorg
		$curl = curl_init();
		curl_setopt_array($curl, array(
  			CURLOPT_URL => 'https://api-dev.setneg.go.id/pegawai/esop/satorg',
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => '',
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 0,
  			//CURLOPT_FOLLOWLOCATION => true,
  			//CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  			CURLOPT_CUSTOMREQUEST => 'GET',
  			CURLOPT_HTTPHEADER => array(
    			'Authorization: Basic b3ByX2Vzb3A6b3ByX2Vzb3BAMjAyMA==',
    			'Cookie: ci_session=pqt9rmvfuahctnnkep4jcqqoqcrmbfc6'
  			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$resArray = json_decode($response, true);
		$arr_satorg = array();
		if($resArray['status'] == 'OK' && $resArray['data'] != null){
			foreach ($resArray['data'] as $row){
				$arr_satorg[] = $row['idunit'];
			}
		}

		foreach ($arr_satorg as $satorg){
			$resArr = array();

			//ambil list jabatan per satorg
			$curl = curl_init();
			curl_setopt_array($curl, array(
  				CURLOPT_URL => 'https://api-dev.setneg.go.id/pegawai/esop/daftar_jabatan?satorg='.$satorg,
  				CURLOPT_RETURNTRANSFER => true,
  				CURLOPT_ENCODING => '',
  				CURLOPT_MAXREDIRS => 10,
  				CURLOPT_TIMEOUT => 0,
  				//CURLOPT_FOLLOWLOCATION => true,
  				//CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  				CURLOPT_CUSTOMREQUEST => 'GET',
  				CURLOPT_HTTPHEADER => array(
    				'Authorization: Basic b3ByX2Vzb3A6b3ByX2Vzb3BAMjAyMA==',
    				'Cookie: ci_session=6r97bnoigs40ott401g30mrsmqg6st43'
  				),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			$resArr = json_decode($response, true);
			if($resArr['status'] == 'OK' && $resArr['data'] != null){
				foreach ($resArr['data'] as $row){
					$cek_jabatan = $this->master->get_data_id('nama_jabatan', $row['jabatan'], 'm_singkatan_unit');

					$data = array();
					$data = array(
						'id_unit' => $row['id_unit'],
						'id_deputi' => $row['id_deputi'],
						'id_biro' => $row['id_biro'],
					);
					if($cek_jabatan->num_rows() > 0){
						//edit data jabatan
						$this->master->update_data('idsingkatan', $cek_jabatan->row()->idsingkatan, $data, 'm_singkatan_unit');
					}else{
						//insert data jabatan
						$data['nama_jabatan'] = $row['jabatan'];

						$data['singkatan'] = strtoupper(random_string('alpha', 4));
						while(true){
							$cek_singkatan = $this->master->get_data_id('singkatan', $data['singkatan'], 'm_singkatan_unit');
							if($cek_singkatan->num_rows() == 0)
								break;
						}

						$n_unsur = $this->master->total_record('m_singkatan_unit');
						if($n_unsur == 0){
							$data['idsingkatan'] = 'SJ.000001';
						}else{
							$dt_id = $this->master->max_id('idsingkatan', 'm_singkatan_unit');
							$dt_id = $dt_id->row()->idsingkatan;
							$next_id = ((int)str_replace('SJ.', '', $dt_id))+1;
							$data['idsingkatan'] = 'SJ.'.sprintf("%06s", $next_id);
						}

						$this->master->insert_data($data, 'm_singkatan_unit');
					}

				}
			}
		}
		$this->master->hapus_singkatan();
		echo "<script>window.close();</script>";
	}
	public function view_edit_singkatan(){
		$id = $this->uri->segment(3);
		$data['dt_singkatan'] = $this->master->get_data_id('idsingkatan', $id, 'm_singkatan_unit');
		if($data['dt_singkatan']->num_rows() == 0){
			echo '404';
			exit();
		}

		$data['title'] = 'Edit Singkatan';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$this->load->view('templating/header',$data);
		$this->load->view('content/master_unit/v_input_singkatan',$data);
		$this->load->view('templating/footer',$data);
	}
	public function update_singkatan(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}

		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'Id', 'trim|required');
		$this->form_validation->set_rules('nama_jabatan', 'Nama_jabatan', 'trim|required');
		$this->form_validation->set_rules('singkatan', 'Singkatan', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$id = trim($this->input->post('id', true));
			$singkatan = trim($this->input->post('singkatan', true));
			$cek_data = $this->master->validasi_singkatan_update($id, $singkatan);
			if($cek_data == 0){
				$data['singkatan'] = trim($this->input->post('singkatan', true));
				$update = $this->master->update_data('idsingkatan', $id, $data, 'm_singkatan_unit');
				if($update){
					$data_ajax['success'] = true;
					$this->session->set_flashdata('message', 'Data singkatan berhasil diedit');
				}else{
					$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data singkatan gagal diedit</div>';
				}
			}else{
				$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data singkatan gagal diedit, ada duplikasi singkatan</div>';
			}

		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data singkatan gagal diedit, input tidak valid</div>';
		}
		echo json_encode($data_ajax);
	}
	public function hapus_singkatan(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		
		$idsingkatan = trim($this->input->post('id', true));
		$data_ajax['success'] = false;
		$hapus = $this->master->hapus_data('idsingkatan', $idsingkatan, 'm_singkatan_unit');
		if($hapus){
			$data_ajax['success'] = true;
			$data_ajax['message'] = '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data singkatan berhasil dihapus</div>';
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data singkatan gagal dihapus</div>';
		}
		echo json_encode($data_ajax);
	}
}
