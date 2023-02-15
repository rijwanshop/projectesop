<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('cetak_pelaksana_atas')){
	function cetak_pelaksana_atas($pelaksana){
		$print = '';
		for($p=0; $p<10; $p++){
			if($pelaksana[$p] != ''){
				$print .= '<th style="width:35px; height:35px;">';
				$print .= '<div style="width:35px; height:35px; word-wrap: break-word; overflow:hidden">';
				$print .= $pelaksana[$p];
				$print .= '</div></th>';
			}
		}
		return $print;
	}
}
if (!function_exists('cetak_pelaksana_bawah')){
	function cetak_pelaksana_bawah($pelaksana){
		$print = '';
		for($p=10; $p<count($pelaksana); $p++){
			if($pelaksana[$p] != ''){
				$print .= '<th rowspan="2" style="width:35px; height:35px;">';
				$print .= '<div style="width:35px; height:35px; word-wrap: break-word; overflow:hidden;">';
				$print .= $pelaksana[$p];
				$print .= '</div></th>';
			}
		}
		return $print;
	}
}
if (!function_exists('print_pelaksana_bawah')){
	function print_pelaksana_bawah($alias){
		$CI = get_instance();
		$CI->load->model('Model_sop','sop');
		$dt_sop = $CI->sop->get_data_id('sop_alias', $alias, 'sop');
		$print = '';
		if($dt_sop->num_rows() > 0){
			$dt_sop = $dt_sop->result_array();
			for($p=10; $p<$dt_sop[0]['sop_jml_pelaksana']; $p++){
				if($dt_sop[0]['sop_nm_pel'.($p+1)] != ''){
					$print .= '<th rowspan="2" style="width:35px; height:35px;">';
					$print .= '<div style="width:35px; height:35px; word-wrap: break-word; overflow:hidden;">';
					$print .= $dt_sop[0]['sop_nm_pel'.($p+1)];
					$print .= '</div></th>';
				}
			}
		}
		return $print;
	}
}
if (!function_exists('print_pelaksana_atas')){
	function print_pelaksana_atas($alias){
		$CI = get_instance();
		$CI->load->model('Model_sop','sop');
		$dt_sop = $CI->sop->get_data_id('sop_alias', $alias, 'sop');
		$print = '';

		if($dt_sop->num_rows() > 0){

			$dt_sop = $dt_sop->result_array();
			for($p=0; $p<10; $p++){
				if($dt_sop[0]['sop_nm_pel'.($p+1)] != ''){
					$print .= '<th style="width:35px; height:35px;">';
					$print .= '<div style="width:35px; height:35px; word-wrap: break-word; overflow:hidden">';
					$print .= $dt_sop[0]['sop_nm_pel'.($p+1)];
					$print .= '</div></th>';
				}
			}
		}
		return $print;
	}
}
if (!function_exists('eksport_pelaksana_bawah')){
	function eksport_pelaksana_bawah($alias){
		$CI = get_instance();
		$CI->load->model('Model_sop','sop');
		$dt_sop = $CI->sop->get_data_id('sop_alias', $alias, 'sop');
		$print = '';
		if($dt_sop->num_rows() > 0){
			$dt_sop = $dt_sop->result_array();
			for($p=10; $p<$dt_sop[0]['sop_jml_pelaksana']; $p++){
				if($dt_sop[0]['sop_nm_pel'.($p+1)] != ''){
					$print .= '<th rowspan="2" class="head-column">';
					$print .= $dt_sop[0]['sop_nm_pel'.($p+1)];
					$print .= '</th>';
				}
			}
		}
		return $print;
	}
}
if (!function_exists('eksport_pelaksana_atas')){
	function eksport_pelaksana_atas($alias){
		$CI = get_instance();
		$CI->load->model('Model_sop','sop');
		$dt_sop = $CI->sop->get_data_id('sop_alias', $alias, 'sop');
		$print = '';

		if($dt_sop->num_rows() > 0){

			$dt_sop = $dt_sop->result_array();
			for($p=0; $p<10; $p++){
				if($dt_sop[0]['sop_nm_pel'.($p+1)] != ''){
					$print .= '<th class="head-column">';
					$print .= $dt_sop[0]['sop_nm_pel'.($p+1)];
					$print .= '</th>';
				}
			}
		}
		return $print;
	}
}
if (!function_exists('konversi_data_node')){
	function konversi_data_node($alias){
		$data_node = array();
		$CI = get_instance();
		$CI->load->model('Model_sop','sop');
		$dt_sop = $CI->sop->get_data_id('sop_alias', $alias, 'sop');

		$idx = 0;
		foreach($dt_sop->result_array() as $row){
			for($j=0; $j<$dt_sop->row()->sop_jml_pelaksana; $j++){
				$data_node[$idx][$j][0] = $row['sop_pelaksana'.($j+1)];
				$data_node[$idx][$j][1] = $row['sop_decision_perbaris'];
				$data_node[$idx][$j][2] = $row['sop_pelaksana_perbaris'];
			}
			$idx++;
		}
		return $data_node;
	}
}
if (!function_exists('get_node_connect_index')){
	function get_node_connect_index($index, $n_koneksi, $data_node){
		$connect = '';
		for($i=0; $i<$n_koneksi; $i++){
			$post = $data_node[$index+1][$i][0];
			if($post != '')
				$connect .= ($i+1).',';
		}
		if($connect != '')
			$connect = substr($connect, 0, strlen($connect)-1);
		return $connect;
	}
}
if (!function_exists('get_list_pelaksana')){
	function get_list_pelaksana($alias){
		$CI = get_instance();
		$CI->load->model('Model_sop','sop');
		$dt_sop = $CI->sop->get_data_id('sop_alias', $alias, 'sop');
		$dt_list = array();
		if($dt_sop->num_rows() > 0){
			$dt_sop = $dt_sop->result_array();
			for($i=0; $i<15; $i++){
				$pel = $dt_sop[0]['sop_nm_pel'.($i+1)];
				if($pel != '')
					$dt_list[] = $dt_sop[0]['sop_nm_pel'.($i+1)];
			}
		}
			
		if(count($dt_list) == 0)
			$dt_list[0] = 'not';

		return $dt_list;
	}
}
if (!function_exists('get_jumlah_pelaksana')){
	function get_jumlah_pelaksana($pelaksana){
		$n_pelaksana = 0;
		for($p=0;$p<count((array)$pelaksana); $p++){
			if($pelaksana[$p] != ''){
				$n_pelaksana++;
			}
		}
		return $n_pelaksana;
	}
}
if (!function_exists('get_connected_node')){
	function get_connected_node($index, $n_koneksi){
		$CI = get_instance();
		$connect = '';
		for($i=0; $i<$n_koneksi; $i++){
			$post = trim($CI->input->post('check_pelaksana'.($i+1).'_'.($index+1)));
			$dec = trim($CI->input->post('deci'.($i+1).'-'.($index+1)));
			if($post != ''){
				$connect .= ($i+1).',';
			}
		}
		if($connect != '')
			$connect = substr($connect, 0, strlen($connect)-1);
		return $connect;
	}
}
if (!function_exists('get_image_node')){
	function get_image_node($alias){
		$CI = get_instance();
		$CI->load->model('Model_sop','sop');
		$dt_sop = $CI->sop->detail_sop($alias);
		$dt_node = konversi_data_node($dt_sop->row()->sop_alias);
		$konektor = 1;
		$konektor_min = 0;
		$img = array();
		for($i=0; $i<$dt_sop->num_rows(); $i++){
			$z=0;
			$pel='';
			$disnama = '';
			for($j=0; $j<$dt_sop->row()->sop_jml_pelaksana; $j++){
				$pelaksana = $dt_node[$i][$j][0];
				$dec = $dt_node[$i][$j][1];
				if($pelaksana != ''){
					$z = $i-1;
					if($i == 0 || $i == $dt_sop->num_rows()-1)
						$img[$i][$j] = '<img src="'.base_url().'assets/media/simbol/awal-akhir.png">';
					else{
						if($dec != '')
							$img[$i][$j] = '<img src="'.base_url().'assets/media/simbol/decision.png">';
						else
							$img[$i][$j] = '<img src="'.base_url().'assets/media/simbol/proses.png">';
					}

					if($i == $konektor_min){
						$connect = get_node_connect_index($i, $dt_sop->row()->sop_jml_pelaksana, $dt_node);
						$dt_gambar = $CI->sop->get_data_id('simbol_nama', 'k-atas-'.($j+1).'-'.$connect, 'simbol');
						$img[$i][$j] .= '<img src="'.base_url().'assets/media/simbol/'; 
						if($dt_gambar->num_rows() > 0){
							$img[$i][$j] .= ''.$dt_gambar->row()->simbol_img.'';
						} 
						$img[$i][$j] .= '" style="position:absolute; '; 
						if($dt_gambar->num_rows() > 0){
							$img[$i][$j] .= ''.$dt_gambar->row()->simbol_margin.'';
						} 
						$img[$i][$j] .= '">'; 
					}

					if($i == $konektor){
						$img[$i][$j] .= '<img src="'.base_url().'assets/media/simbol/penghubung-bawah.png" style="position:absolute; margin-top:-35px; margin-left:-26px">'; 
					}else{
						if($i > 0){
							if($dec != ''){
								if(substr($dt_node[$z][$j][1], -1) == 'Y'){
									$dt_gambar = $CI->sop->get_data_id('simbol_nama', 'd-y-'.$dt_node[$z][$j][2].'-'.($j+1),'simbol');
									$img[$i][$j] .= '<img src="'.base_url().'assets/media/simbol/'; 
									if($dt_gambar->num_rows() > 0){
										$img[$i][$j] .= $dt_gambar->row()->simbol_img;
									} 
									$img[$i][$j] .= '" style="position:absolute; '; 
									if($dt_gambar->num_rows() > 0){
										$img[$i][$j] .= $dt_gambar->row()->simbol_margin;
									} 
									$img[$i][$j] .= '">';
								}else{
									$dt_gambar = $CI->sop->get_data_id('simbol_nama', $dt_node[$z][$j][2].'-'.($j+1), 'simbol');
									$img[$i][$j] .= '<img src="'.base_url().'assets/media/simbol/'; 
									if($dt_gambar->num_rows() > 0){
										$img[$i][$j] .= $dt_gambar->row()->simbol_img;
									} 
									$img[$i][$j] .= '" style="position:absolute; '; 
									if($dt_gambar->num_rows() > 0){
										$img[$i][$j] .= $dt_gambar->row()->simbol_margin;
									} 
									$img[$i][$j] .= '">'; 
								}
								$dt_gambar = $CI->sop->get_data_id('simbol_nama', 'd-t-'.$dt_node[$z][$j][2].'-'.($j+1), 'simbol');
								$img[$i][$j] .= '<img src="'.base_url().'assets/media/simbol/'; 
								if($dt_gambar->num_rows() > 0){
									$img[$i][$j] .= $dt_gambar->row()->simbol_img;
								} 
								$img[$i][$j] .= '" style="position:absolute; '; 
								if($dt_gambar->num_rows() > 0){
									$img[$i][$j] .= $dt_gambar->row()->simbol_margin;
								} 
								$img[$i][$j] .= '">'; 
							}else{
								if(substr($dt_node[$z][$j][1], -1) == 'Y'){
									$dt_gambar = $CI->sop->get_data_id('simbol_nama', 'd-y-'.$dt_node[$z][$j][2].'-'.($j+1), 'simbol');
									$img[$i][$j] .= '<img src="'.base_url().'assets/media/simbol/'; 
									if($dt_gambar->num_rows() > 0){
										$img[$i][$j] .= $dt_gambar->row()->simbol_img;
									} 
									$img[$i][$j] .= '" style="position:absolute; '; 
									if($dt_gambar->num_rows() > 0){
										$img[$i][$j] .= $dt_gambar->row()->simbol_margin;
									} 
									$img[$i][$j] .= '">';
								}else{
									if(count(explode(',',$dt_node[$i][$j][2])) > 1){
										if($disnama != $dt_node[$z][$j][1].'-'.$dt_node[$i][$j][1]){
											$disnama = $dt_node[$z][$j][1].'-'.$dt_node[$i][$j][1];
											$dt_gambar = $CI->sop->get_data_id('simbol_nama', $dt_node[$z][$j][1].'-'.$dt_node[$i][$j][1],'simbol');
											$img[$i][$j] .= '<img src="'.base_url().'assets/media/simbol/'; 
											if($dt_gambar->num_rows() > 0){
												$img[$i][$j] .= $dt_gambar->row()->simbol_img;
											} 
											$img[$i][$j] .= '" style="position:absolute; '; 
											if($dt_gambar->num_rows() > 0){
												$img[$i][$j] .= $dt_gambar->row()->simbol_margin;
											} 
											$img[$i][$j] .= '">'; 
										}
									}else{
										$dt_gambar = $CI->sop->get_data_id('simbol_nama', $dt_node[$z][$j][1].'-'.($j+1), 'simbol');
										$img[$i][$j] .= '<img src="'.base_url().'assets/media/simbol/';
										if($dt_gambar->num_rows() > 0){
											$img[$i][$j] .= $dt_gambar->row()->simbol_img;
										} 
										$img[$i][$j] .= '" style="position:absolute; '; 
										if($dt_gambar->num_rows() > 0){
											$img[$i][$j] .= $dt_gambar->row()->simbol_margin;
										} 
										$img[$i][$j] .= '">';
									}
								}
							}
						}
					}
				}else{
					$img[$i][$j] = '';
				}
			}
			if($i == $konektor){ 
				$konektor = $konektor+5; 
				$konektor_min = $konektor_min+5;
			}
		}
		return $img;
	}
}

if (!function_exists('save_kegiatan')){
	function save_kegiatan(){
		$CI = get_instance();
		$CI->load->model('Model_sop','sop');
		$alias = trim($CI->input->post('id_kegiatan',true));
		$dt_sop = $CI->sop->get_data_id('sop_alias', $alias, 'sop');

		//simpan singkatan pelaksana
		$data_pelaksana = array();
		$data_pelaksana[0] = '';
		$data_pelaksana[1] = '';
		$data_pelaksana[2] = '';
		$data_pelaksana[3] = '';
		$data_pelaksana[4] = '';
		$data_pelaksana[5] = '';
		$data_pelaksana[6] = '';
		$data_pelaksana[7] = '';
		$data_pelaksana[8] = '';
		$data_pelaksana[9] = '';
		$data_pelaksana[10] = '';
		$data_pelaksana[11] = '';
		$data_pelaksana[12] = '';
		$data_pelaksana[13] = '';
		$data_pelaksana[14] = '';
		
		$pelaksana = $CI->input->post('pelaksana');
		for($i=0; $i<count((array)$pelaksana); $i++){
			$cek = $CI->sop->get_data_id('singkatan', $pelaksana[$i], 'm_singkatan_unit');
			if($cek->num_rows() > 0){
				$data_pelaksana[$i] = $pelaksana[$i];
			}
		}

		$kegiatan = $CI->input->post('kegiatan');

		//hapus kegiatan untuk menghinadri duplikasi data
		$n_kegiatan = get_jumlah_pelaksana($kegiatan);
		if($n_kegiatan != 0){
			$CI->sop->hapus_data('sop_alias', $dt_sop->row()->sop_alias, 'sop');
		}

		$n_koneksi = get_jumlah_pelaksana($pelaksana);
		$pelaksana_perbaris = $CI->input->post('a');
		$decision_perbaris = $CI->input->post('d');
		$kelengkapan = $CI->input->post('kelengkapan');
		$waktu = $CI->input->post('waktu');
		$hasil = $CI->input->post('hasil');
		$keterangan = $CI->input->post('keterangan');

		$konektor=1;
		for($i=0; $i<count((array)$kegiatan); $i++){
			if($kegiatan[$i] != ''){
				$pel = array();
				for($j=0; $j<15; $j++){
					$post_a = $CI->input->post('check_pelaksana'.($j+1).'_'.$i.'');
					if($post_a != '')
						$pel[$j] = $post_a;
					else
						$pel[$j] = '';
				}

				$isi = '';
				if($i == $konektor){
					$konektor = $konektor+5; 
					$isi='0';
				}

				$data_field = array(
					'sop_nourut' => $dt_sop->row()->sop_nourut,
					'sop_no'  => $dt_sop->row()->sop_no,
					'sop_index' => $dt_sop->row()->sop_index,
					'sop_nama_satker'  => $dt_sop->row()->sop_nama_satker,
					'sop_deputi' => $dt_sop->row()->sop_deputi,
					'sop_unit_kerja'  => $dt_sop->row()->sop_unit_kerja,
					'sop_tgl_pembuatan'  => $dt_sop->row()->sop_tgl_pembuatan,
					'sop_tgl_revisi'  => $dt_sop->row()->sop_tgl_revisi,
					'sop_disahkan_jabatan'  => $dt_sop->row()->sop_disahkan_jabatan,
					'sop_disahkan_nama'  => $dt_sop->row()->sop_disahkan_nama,
					'sop_disahkan_nip'  => $dt_sop->row()->sop_disahkan_nip,
					'sop_nama'  => $dt_sop->row()->sop_nama,
					'sop_dasar_hukum'  => $dt_sop->row()->sop_dasar_hukum,
					'sop_kualifikasi'  => $dt_sop->row()->sop_kualifikasi,
					'sop_keterkaitan'  => $dt_sop->row()->sop_keterkaitan,
					'sop_peralatan'  => $dt_sop->row()->sop_peralatan,
					'sop_peringatan'  => $dt_sop->row()->sop_peringatan,
					'sop_pencatatan'  => $dt_sop->row()->sop_pencatatan,
					'sop_jml_pelaksana' => $n_koneksi,

					'sop_kegiatan' => $kegiatan[$i],
					'sop_pelaksana1' => $pel[0],
					'sop_pelaksana2' => $pel[1],
					'sop_pelaksana3' => $pel[2],
					'sop_pelaksana4' => $pel[3],
					'sop_pelaksana5' => $pel[4],
					'sop_pelaksana6' => $pel[5],
					'sop_pelaksana7' => $pel[6],
					'sop_pelaksana8' => $pel[7],
					'sop_pelaksana9' => $pel[8],
					'sop_pelaksana10' => $pel[9],
					'sop_pelaksana11' => $pel[10],
					'sop_pelaksana12' => $pel[11],
					'sop_pelaksana13' => $pel[12],
					'sop_pelaksana14' => $pel[13],
					'sop_pelaksana15' => $pel[14],

					'sop_nm_pel1'  => $data_pelaksana[0],
					'sop_nm_pel2'  => $data_pelaksana[1],
					'sop_nm_pel3'  => $data_pelaksana[2],
					'sop_nm_pel4'  => $data_pelaksana[3],
					'sop_nm_pel5'  => $data_pelaksana[4],
					'sop_nm_pel6'  => $data_pelaksana[5],
					'sop_nm_pel7'  => $data_pelaksana[6],
					'sop_nm_pel8'  => $data_pelaksana[7],
					'sop_nm_pel9'  => $data_pelaksana[8],
					'sop_nm_pel10'  => $data_pelaksana[9],
					'sop_nm_pel11'  => $data_pelaksana[10],
					'sop_nm_pel12'  => $data_pelaksana[11],
					'sop_nm_pel13'  => $data_pelaksana[12],
					'sop_nm_pel14'  => $data_pelaksana[13],
					'sop_nm_pel15'  => $data_pelaksana[14],
					'sop_pelaksana_perbaris' => $pelaksana_perbaris[$i],
					'sop_decision_perbaris' => $decision_perbaris[$i],
					'sop_jml_pelaksana' => $n_koneksi,
					'sop_kelengkapan' => $kelengkapan[$i],
					'sop_waktu' => $waktu[$i],
					'sop_hasil' => $hasil[$i],
					'sop_keterangan' => $keterangan[$i],
					'nip_user'   => $dt_sop->row()->nip_user,
					'satuan_organisasi_id' => $dt_sop->row()->satuan_organisasi_id,
					'satuan_organisasi_nama' => $dt_sop->row()->satuan_organisasi_nama,
					'deputi_id' => $dt_sop->row()->deputi_id,
					'nama_deputi' => $dt_sop->row()->nama_deputi,
					'unit_kerja_id' => $dt_sop->row()->unit_kerja_id,
					'nama_unit' => $dt_sop->row()->nama_unit,
					'bagian_id' => $dt_sop->row()->bagian_id,
					'sop_status' => $dt_sop->row()->sop_status,
					'sop_alias' => $dt_sop->row()->sop_alias,
					'sop_konektor' => $isi,
					'sop_status_publish' => $dt_sop->row()->sop_status_publish,
					'sop_label' => $dt_sop->row()->sop_label,
					'sop_step' => $dt_sop->row()->sop_step,
					'sop_tgl_efektif' => $dt_sop->row()->sop_tgl_efektif,
				);
				$CI->sop->insert_data($data_field, 'sop');
			}
		}

	}
}

if (!function_exists('get_list_review')){
	function get_list_review($nip_ignore=''){
		$CI = get_instance();
		$CI->config->load('web_service');
		if(!in_array($CI->session->userdata('satkerid'), array('01','02'))){
			$form_data = array(
        		'satorg' => $CI->session->userdata('satkerid'),
        		'deputi' => $CI->session->userdata('unitkerjaid'),
    		);
		}else{
			$form_data = array(
        		'satorg' => $CI->session->userdata('satkerid'),
        		'deputi' => $CI->session->userdata('iddeputi'),
        		'biro' => $CI->session->userdata('unitkerjaid'),
    		);
		}

        $url_data = http_build_query($form_data);

		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => $CI->config->item('api_pegawai').'esop/reviewer?'.$url_data,
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
    			'Authorization: Basic '.base64_encode($CI->config->item('api_pegawai_username').':'.$CI->config->item('api_pegawai_password'))
  			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$data_option = array();
		$resArray = json_decode($response, true);
		if($resArray['status'] == 'OK' && $resArray['data'] != null){
			foreach ($resArray['data'] as $row){
				$nip = $row['nipbaru'];
				if($nip_ignore == ''){
					$data_option[] = array(
						'nipbaru' => $nip,
						'nama_pegawai' => $row['nmpeg'],
					);
				}else{
					if($nip != $nip_ignore){
						$data_option[] = array(
							'nipbaru' => $nip,
							'nama_pegawai' => $row['nmpeg'],
						);
					}
				}
			}
		}
		return $data_option;
	}
}
if (!function_exists('get_list_pengesah')){
	function get_list_pengesah(){
		$CI = get_instance();
		$CI->config->load('web_service');
		if(!in_array($CI->session->userdata('satkerid'), array('01','02'))){
			$form_data = array(
        		'satorg' => $CI->session->userdata('satkerid'),
        		'deputi' => $CI->session->userdata('unitkerjaid'),
    		);
		}else{
			$form_data = array(
        		'satorg' => $CI->session->userdata('satkerid'),
        		'deputi' => $CI->session->userdata('iddeputi'),
        		'biro' => $CI->session->userdata('unitkerjaid'),
    		);
		}
		
    	$url_data = http_build_query($form_data);
		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => $CI->config->item('api_pegawai').'esop/pengesah?'.$url_data,
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
    			'Authorization: Basic '.base64_encode($CI->config->item('api_pegawai_username').':'.$CI->config->item('api_pegawai_password'))
  			),
		));

		$data_option = array();
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
		return $data_option;
	}
}
if (!function_exists('print_catatan_sop')){
	function print_catatan_sop($alias){
		$CI = get_instance();
		$CI->load->model('Model_sop','sop');
		$dt_sop = $CI->sop->detail_sop($alias);
		$data['status'] = $dt_sop->row()->sop_step;
		$data['no'] = 1;
		$data['catatan'] = $CI->sop->get_status_catatan($alias);
		$tabel = $CI->load->view('content/sop/tabel_catatan', $data, true);
		return $tabel;
	}
}
if (!function_exists('display_catatan')){
	function display_catatan($id){
		$CI = get_instance();
		$CI->load->model('Model_sop','sop');
		$catatan = $CI->sop->get_review_sop($id);
		$display = '';
		if($catatan->num_rows() > 0){
			$display = '<p><b>Catatan: </b>'.$catatan->row()->catatan_review.'</p>';
		}
		return $display;
	}
}
