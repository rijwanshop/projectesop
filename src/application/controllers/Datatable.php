<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('date.timezone', 'Asia/Jakarta');

class Datatable extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('url', 'text_helper','date','tgl_indonesia'));
		$this->load->database();
		$this->load->model(array('Main','Front_m','Settings_m','Master_m','Sop_m','Notif_m','Komunikasi_m'));	
		cek_aktif();
	}
	
/* ====================================================================================================================================================== */	
	function data_usergroup()
	{
		
		$result = $this->Settings_m->get_datatables('usergroup'); //nama function
		$data = array();
		$i= ($_POST['start']== '' ? 0 : $_POST['start']);
		foreach ($result as $row) {
			$i++;
			$rel = array();
			$rel[] = $i;
			$rel[] = $row->user_group_name;
			$rel[] = ($row->user_group_status == 'Y' ? '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">Aktif</span>' : '<span class="badge badge-md badge-danger" style="color:#fff; font-size:11px">Nonaktif</span>');
			$rel[] = '<a href="'.base_url().'settings/user_group/edit/'.$row->user_group_id.'" title="Edit">
						<span class="btn btn-xs btn-warning"><i class="icon wb-pencil" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>
					  <!--<a href="'.base_url().'act_settings/delete_usergroup/'.$row->user_group_id.'" class="del'.$row->user_group_id.'" title="Delete">
						<span class="btn btn-xs btn-danger"><i class="icon wb-trash" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>-->
					  
					  
					  <script type="text/javascript">
						var elems = document.getElementsByClassName(\'del'.$row->user_group_id.'\');
						var confirmIt = function (e) {
							if (!confirm(\'Yakin Akan Dihapus ?\')) e.preventDefault();
						};
						for (var i = 0, l = elems.length; i < l; i++) {
							elems[i].addEventListener(\'click\', confirmIt, false);
						}
					</script>
					  ';
			
			$data[] = $rel;
		}
		
		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Settings_m->count_all('user_group'), //nama tabel
				"recordsFiltered" => $this->Settings_m->count_filtered('usergroup'), //nama function
				"data" => $data,
		);
		echo json_encode($output);
	}

/* ====================================================================================================================================================== */	
	function data_sop()
	{
		
		$session_data = $this->session->userdata;
		$groupid = $session_data['groupid'];
		$userid = $session_data['userid'];
		$unitkerjaid = $session_data['unitkerjaid'];
		
		$where = ($groupid == 9 ? 'where user_id='.$userid.'' : ($groupid == 10 ? 'where unit_kerja_id='.$unitkerjaid.'' : ''));
		$result = $this->Sop_m->get_datatables('datasop'); //nama function
		$data = array();
		$i= ($_POST['start']== '' ? 0 : $_POST['start']);
		foreach ($result as $row) {
			$i++;
			$rel = array();
			$rel[] = $i;
			$rel[] = $row->sop_no;
			$rel[] = $row->sop_nama;
			$rel[] = $row->sop_tgl_pembuatan;
			$rel[] = ($row->sop_status == 'DRAFT' ? '<span class="badge badge-md badge-danger" style="color:#fff; font-size:11px">'.$row->sop_status.'</span>' : ($row->sop_status == 'DRAFT REVISI' ? '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">'.$row->sop_status.'</span>' : '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">'.$row->sop_status.'</span>'));
			
			$rel[] = ($row->sop_step == 'admin' ? '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">'.$row->sop_step.'</span>' : ($row->sop_step == 'pengesah' ? '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">'.$row->sop_step.'</span>' : '<span class="badge badge-md badge-danger" style="color:#fff; font-size:11px">Penyusun</span>'));
			
			$rel[] = ($row->sop_update_file == '' ? '<span class="badge badge-md badge-info" style="color:#fff; font-size:11px">Auto</span>' : '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">Manual</span>');
					$action ='<div class="btn-group">
						  <button type="button" class="btn btn-icon btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"
						  aria-expanded="false" aria-hidden="true">
							Action
						  </button>
						  <div class="dropdown-menu" role="menu" style="font-size:12px">
							<a class="dropdown-item" href="'.base_url().'sop/penyusunan_sop/lihat/'.$row->sop_alias.'" role="menuitem">
							  <i class="icon wb-eye" aria-hidden="true"></i> Lihat
							</a>';
							if($row->sop_step == ''){
								$action .='<a class="dropdown-item" href="'.base_url().'sop/penyusunan_sop/edit/'.$row->sop_alias.'" role="menuitem">
								  <i class="icon wb-pencil" aria-hidden="true"></i> Edit
								</a>
								<a class="dropdown-item" href="'.base_url().'sop/penyusunan_sop/upload/'.$row->sop_alias.'" role="menuitem">
								  <i class="icon wb-upload" aria-hidden="true"></i> Upload
								</a>
								<a class="dropdown-item del'.$row->sop_alias.'" href="'.base_url().'act_sop/delete_sop/'.$row->sop_alias.'" role="menuitem">
								  <i class="icon wb-trash" aria-hidden="true"></i> Delete
								</a>';
							}
							$action .='<hr>';
							if($row->sop_status == 'DISAHKAN'){
								$action .='<a class="dropdown-item" href="'.base_url().'sop/revisi_sop/ajukan/'.$row->sop_alias.'" role="menuitem">
								  <i class="icon wb-refresh" aria-hidden="true"></i> Revisi
								</a>';
							}
							if($row->sop_step == ''){
								$action .='<a class="dropdown-item kirim'.$row->sop_alias.'" href="'.base_url().'act_sop/kirim_sop/'.$row->sop_alias.'" role="menuitem">
								  <i class="icon wb-check" aria-hidden="true"></i> Kirim
								</a>';
							}
						  $action .='</div>
						</div>
					  
					  <script type="text/javascript">
						var elem = document.getElementsByClassName(\'kirim'.$row->sop_alias.'\');
						var confirmIt = function (e) {
							if (!confirm(\'Yakin Akan Dikirim ?\')) e.preventDefault();
						};
						for (var i = 0, l = elem.length; i < l; i++) {
							elem[i].addEventListener(\'click\', confirmIt, false);
						}
						
						var elems = document.getElementsByClassName(\'del'.$row->sop_alias.'\');
						var confirmIt = function (e) {
							if (!confirm(\'Yakin Akan Dihapus ?\')) e.preventDefault();
						};
						for (var i = 0, l = elems.length; i < l; i++) {
							elems[i].addEventListener(\'click\', confirmIt, false);
						}
					</script>';
			
			$rel[] = $action;		
			
			
			$data[] = $rel;
		}
		
		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Sop_m->count_all('(select * from vwsop '.$where.') as vwsop'), //nama tabel
				"recordsFiltered" => $this->Sop_m->count_filtered('datasop'), //nama function
				"data" => $data,
		);
		echo json_encode($output);
	}
/* ====================================================================================================================================================== */
	
	function pengesahan_sop()
	{
		
		$session_data = $this->session->userdata;
		$groupid = $session_data['groupid'];
		$userid = $session_data['userid'];
		$unitkerjaid = $session_data['unitkerjaid'];
		
		$where = ($groupid == 9 ? 'and user_id='.$userid.'' : ($groupid == 10 ? 'and unit_kerja_id='.$unitkerjaid.'' : ''));
		$result = $this->Sop_m->get_datatables('pengesahsop'); //nama function
		$data = array();
		$i= ($_POST['start']== '' ? 0 : $_POST['start']);
		foreach ($result as $row) {
			$i++;
			$rel = array();
			$rel[] = $i;
			$rel[] = $row->sop_no;
			$rel[] = $row->sop_nama;
			$rel[] = $row->sop_tgl_pembuatan;
			$rel[] = '<a href="'.base_url().'sop/pengesahan_sop/lihat/'.$row->sop_alias.'" title="Lihat">
						<span class="btn btn-xs btn-info"><i class="icon wb-eye" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>';
			
			$data[] = $rel;
		}
		 
		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Sop_m->count_all('(select * from vwsop where sop_step="pengesah" and sop_status!="DISAHKAN" '.$where.') as vwsop'), //nama tabel
				"recordsFiltered" => $this->Sop_m->count_filtered('pengesahsop'), //nama function
				"data" => $data,
		);
		echo json_encode($output);
	}
/* ====================================================================================================================================================== */
	
	function pilih_sop()
	{
		
		$result = $this->Sop_m->get_datatables('pilihsop'); //nama function
		$data = array();
		$i= ($_POST['start']== '' ? 0 : $_POST['start']);
		foreach ($result as $row) {
			$i++;
			$rel = array();
			$rel[] = $i;
			$rel[] = $row->sop_nama;
			$rel[] = '<a href="'.base_url().'sop/evaluasi_sop/lihat/'.$row->sop_alias.'" title="Lihat" target="_blank">
						<span class="btn btn-xs btn-info"><i class="icon wb-eye" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>
					  <a href="#" class="Pilih'.$row->sop_alias.'" title="Pilih">
						<span class="btn btn-xs btn-success"><i class="icon wb-check" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>
					  
					  <script type="text/javascript">
						$(".Pilih'.$row->sop_alias.'").click(function(){
							var key = "'.$row->sop_alias.'";
							var value = "'.$row->sop_nama.'"; 
							$("#DaftarSOP").append($("<option selected></option>").attr("value",key).text(value)); 
						});
					  </script>';
			
			$data[] = $rel;
		}
		
		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Sop_m->count_all('(select * from vwsop where sop_status="DISAHKAN") as vwsop'), //nama tabel
				"recordsFiltered" => $this->Sop_m->count_filtered('pilihsop'), //nama function
				"data" => $data,
		);
		echo json_encode($output);
	}
/* ====================================================================================================================================================== */
	function list_kategori()
	{
		
		$result = $this->Komunikasi_m->get_datatables('listkategori'); //nama function
		$data = array();
		$i= ($_POST['start']== '' ? 0 : $_POST['start']);
		foreach ($result as $row) {
			$i++;
			$rel = array();
			$rel[] = $i;
			$rel[] = '<a href="'.base_url().'komunikasi/forum/topik"><b>'.$row->kategori_diskusi_judul.'</b><br><span style="margin-left:20px; font-size:10px">'.$row->kategori_diskusi_ket."</span></a>";
			$rel[] = $row->kategori_diskusi_id;
			$rel[] = $row->kategori_diskusi_id;
			$rel[] = $row->kategori_diskusi_id;
			
			$data[] = $rel;
		}
		
		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Komunikasi_m->count_all('kategori_diskusi'), //nama tabel
				"recordsFiltered" => $this->Komunikasi_m->count_filtered('listkategori'), //nama function
				"data" => $data,
		);
		echo json_encode($output);
	}
/* ====================================================================================================================================================== */

	function list_topik()
	{
		
		$result = $this->Komunikasi_m->get_datatables('listtopik'); //nama function
		$data = array();
		$i= ($_POST['start']== '' ? 0 : $_POST['start']);
		foreach ($result as $row) {
			$i++;
			$rel = array();
			$rel[] = $i;
			$rel[] = '<a href="#"><b>'.$row->kategori_diskusi_judul.'</b><br><span style="margin-left:20px; font-size:10px">'.$row->kategori_diskusi_ket."</span></a>";
			$rel[] = $row->kategori_diskusi_id;
			$rel[] = $row->kategori_diskusi_id;
			$rel[] = $row->kategori_diskusi_id;
			
			$data[] = $rel;
		}
		
		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Komunikasi_m->count_all('kategori_diskusi'), //nama tabel
				"recordsFiltered" => $this->Komunikasi_m->count_filtered('listtopik'), //nama function
				"data" => $data,
		);
		echo json_encode($output);
	}
/* ====================================================================================================================================================== */
	function notif()
	{
		$session_data = $this->session->userdata;
		$userid = $session_data['userid'];
			
		$session_data = $this->session->userdata;
		$userid = $session_data['userid'];
		$groupid = $session_data['groupid'];
		
		$result = $this->Notif_m->get_datatables('semua'); //nama function
		$data = array();
		$i= ($_POST['start']== '' ? 0 : $_POST['start']);
		foreach ($result as $row) {
			$i++;
			$rel = array();
			$linkgrup = ($groupid == 11 ? 'periksa' : 'lihat');
			$link = ($row->notif_jenis == 'reviu' ? ''.base_url().'sop/reviu/'.$linkgrup.'/'.$row->sop_alias.'/'.$row->notif_id.'/'.$row->reviu_id.'' : ''.base_url().'sop/revisi_sop/periksa/'.$row->sop_alias.'/'.$row->revisi_id.'');
						
			$rel[] = $i;
			$rel[] = '<a href="'.$link.'">'.$row->notif_title.'</a>';
			$rel[] = tgl_indo2($row->notif_date);
			$rel[] = ($row->notif_jenis == 'reviu' ? '<span class="badge badge-md badge-info" style="color:#fff; font-size:11px">Reviu</span>' : '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">Revisi</span>');
			$rel[] = ($row->notif_action == 'sudah' ? '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">Sudah</span>' : '<span class="badge badge-md badge-danger" style="color:#fff; font-size:11px">Belum</span>');
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