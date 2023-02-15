<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('date.timezone', 'Asia/Jakarta');

class Datatable_front extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('url', 'text_helper','date','tgl_indonesia'));
		$this->load->database();
		$this->load->model(array('Main','Front_m','Settings_m','Master_m','Sop_m','Notif_m','Komunikasi_m'));	
	}
	
	

/* ====================================================================================================================================================== */	
	function front_pencariansop()
	{
		
		$result = $this->Sop_m->get_datatables('datasopfront'); //nama function
		$data = array();
		$i= ($_POST['start']== '' ? 0 : $_POST['start']);
		foreach ($result as $row) {
			$link = ($row->sop_update_file == '' ? ''.base_url().'pencarian_sop/lihat/'.$row->sop_alias.'' : ''.base_url().'front/pdf_sop/'.$row->sop_alias.'');
			//$link =  base_url().'pencarian_sop/lihat/'.$row->sop_alias.'';
			$i++;
			$rel = array();
			$rel[] = $i;
			$rel[] = $row->sop_no;
			$rel[] = $row->sop_nama;
			$rel[] = $row->unit_kerja_nama;
			$rel[] = $row->sop_tgl_efektif;
			$rel[] = '<a href="'.$link.'" target="_blank" title="Lihat">
						<span class="label label-success"><i class="fa fa-eye" aria-hidden="true"></i></span>
					  </a>';
			
			$data[] = $rel;
		}
		
		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Sop_m->count_all('(select a.*,u.unit_kerja_nama from vwsop a left join unit_kerja u on a.unit_kerja_id=u.unit_kerja_id where a.sop_tgl_efektif != "") as vwsop'), //nama tabel
				"recordsFiltered" => $this->Sop_m->count_filtered('datasopfront'), //nama function
				"data" => $data,
		);
		echo json_encode($output);
	}
/* ====================================================================================================================================================== */

/* ====================================================================================================================================================== */	
	function front_evaluasisop()
	{
		
		$result = $this->Sop_m->get_datatables('dataevaluasifront'); //nama function
		$data = array();
		$i= ($_POST['start']== '' ? 0 : $_POST['start']);
		foreach ($result as $row) {
			$link = ($row->sop_update_file == '' ? ''.base_url().'pdf/index.php?alias='.md5($row->sop_alias).'' : ''.base_url().'front/pdf_sop/'.$row->sop_alias.'');
			$i++;
			$rel = array();
			$rel[] = $i;
			$rel[] = $row->sop_no;
			$rel[] = $row->sop_nama;
			$rel[] = $row->sop_tgl_efektif;
			$rel[] = '<a href="'.base_url().'evaluasi_sop/nilai/'.md5($row->sop_alias).'" title="Lihat">
						<span class="label label-success"><i class="fa fa-eye" aria-hidden="true"></i></span>
					  </a>';
			
			$data[] = $rel;
		}
		
		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Sop_m->count_all('vwevaluasi'), //nama tabel
				"recordsFiltered" => $this->Sop_m->count_filtered('dataevaluasifront'), //nama function
				"data" => $data,
		);
		echo json_encode($output);
	}
/* ====================================================================================================================================================== */

/* ====================================================================================================================================================== */
	function notif()
	{
		
		$session_data = $this->session->userdata;
		$userid = $session_data['userid'];
		$groupid = $session_data['groupid'];
		
		$result = $this->Notif_m->get_datatables('semua'); //nama function
		$data = array();
		$i= ($_POST['start']== '' ? 0 : $_POST['start']);
		foreach ($result as $row) {
			$i++;
			$linkgrup = ($groupid == 11 ? 'periksa' : 'lihat');
			$user = ($groupid == 11 ? 'user_to' : 'user_from');
			$link = ($row->notif_jenis == 'reviu' ? '<a href="'.base_url().'sop/reviu/'.$linkgrup.'/'.$row->sop_alias.'/'.$row->notif_id.'/'.$row->reviu_id.'"><b>'.$row->notif_title.'</b></a>' : '<a href="'.base_url().'sop/revisi_sop/periksa/'.$row->sop_alias.'/'.$row->revisi_id.'"><b>'.$row->notif_title.'</b></a>');
			
			$rel = array();
			$rel[] = $i;
			$rel[] = $link;
			$rel[] = tgl_indo2($row->notif_date);
			$rel[] = ($row->notif_jenis == 'reviu' ? '<span class="badge badge-md badge-primary" style="color:#fff; font-size:11px">Reviu</span>' : '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">Revisi</span>');
			$rel[] = ($row->notif_action == 'sudah' ? '<span class="badge badge-md badge-info" style="color:#fff; font-size:11px">Sudah</span>' : ($row->notif_action == 'belum' ? '<span class="badge badge-md badge-danger" style="color:#fff; font-size:11px">Belum</span>' : ''));
			$rel[] = ($row->notif_status == 'R' ? '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">Read</span>' : '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">Delivered</span>');
			
			$data[] = $rel;
		}
		
		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Notif_m->count_all('(select * from notif where user_id='.$userid.') as notif'), //nama tabel
				"recordsFiltered" => $this->Notif_m->count_filtered('semua'), //nama function
				"data" => $data,
		);
		echo json_encode($output);
	}
/* ====================================================================================================================================================== */


}