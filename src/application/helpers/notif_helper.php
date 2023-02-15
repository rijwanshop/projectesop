<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_notif_user')){
	function get_notif_user(){
		$CI = get_instance();
		$CI->load->model('Model_notifikasi','notif');
		$nip = $CI->session->userdata('pegawainip');
		$grup = $CI->session->userdata('groupid');
		$data_notif = $CI->notif->get_notif_user($grup, $nip);

		$text = '';
		if($data_notif->num_rows() > 0){
			$limit = 1;
			foreach ($data_notif->result() as $row) {
				$text .= '<a class="list-group-item" href="'.set_link_notif($row->idnotifikasi).'" role="menuitem">
							<div class="media">
								<div class="pr-10"> 
									<i class="icon '.$row->icon.' white icon-circle" aria-hidden="true">
									</i>
              					</div>
              					<div class="media-body">
              						<h6 class="media-heading">'.$row->aktivitas.'</h6>
              						<time class="media-meta">'.date('d-m-Y H:i', strtotime($row->waktu)).'</time>
              					</div>
              				</div>
            			</a>';
            	$limit++;
            	if($limit == 3)
            		break;
			}
		}else{
			$text = '<a class="list-group-item" href="#" role="menuitem">
                      	<div class="media">
                        	<div class="media-body">
                          		<h6 class="media-heading">Tidak ada pemberitahuan</h6>
                        	</div>
                      	</div>
                    </a>';
		}
		return $text;
	}
}
if (!function_exists('get_total_notif_user')){
	function get_total_notif_user(){
		$CI = get_instance();
		$CI->load->model('Model_notifikasi','notif');
		$nip = $CI->session->userdata('pegawainip');
		$grup = $CI->session->userdata('groupid');
		$data_notif = $CI->notif->get_notif_user($grup, $nip);

		$display = '';
		if($data_notif->num_rows() > 0){
			$display = '<span class="badge badge-round badge-danger">New '.$data_notif->num_rows().'</span>';
		}
		return $display;
	}
}
if (!function_exists('get_jumlah_notif_user')){
	function get_jumlah_notif_user(){
		$CI = get_instance();
		$CI->load->model('Model_notifikasi','notif');
		$nip = $CI->session->userdata('pegawainip');
		$grup = $CI->session->userdata('groupid');
		$data_notif = $CI->notif->get_notif_user($grup, $nip);

		$display = '';
		if($data_notif->num_rows() > 0){
			$display = '<span class="badge badge-pill badge-danger up">'.$data_notif->num_rows().'</span>';
		}
		return $display;
	}
}
if (!function_exists('set_link_notif')){
	function set_link_notif($id){
		$CI = get_instance();
		$CI->load->model('Model_notifikasi','notif');
		$dt_notif = $CI->notif->get_data_id('idnotifikasi', $id, 'notifikasi');
		if($dt_notif->num_rows() == 0){
			return '#';
		}

		$jenis = $dt_notif->row()->jenis_notif;
		if(in_array($jenis, array('Informasi','Status Review')))
			return site_url('notifikasi/history_sop/'.$dt_notif->row()->idnotifikasi);
		elseif($jenis == 'Pengajuan Review')
			return site_url('review_sop/detail_sop/'.enkripsi_id_url($dt_notif->row()->alias_sop));
		elseif($jenis == 'Peninjauan SOP')
			return site_url('admin_sop/detail_sop/'.enkripsi_id_url($dt_notif->row()->alias_sop));
		elseif($jenis == 'Pengesahan SOP')
			return site_url('pengesah_sop/detail_sop/'.enkripsi_id_url($dt_notif->row()->alias_sop));
		elseif($jenis == 'Informasi Pengesahan')
			return site_url('pengolahan_sop/detail_sop/'.enkripsi_id_detail($dt_notif->row()->alias_sop));
		else
			return '#';
	}
}