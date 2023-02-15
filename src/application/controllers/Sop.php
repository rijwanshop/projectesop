 <?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Sop extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url', 'text_helper','date','tgl_indonesia'));
		$this->load->database();
		$this->load->model(array('Sop_m','Notif_m','Main'));	
		$this->load->library(array('alias','encrypt','menubackend'));
		//cek_aktif();
	}
	
	function pdf_sop()
	{			
		$alias = $this->uri->segment(3);
		$p = $this->db->query("select sop_update_file from sop_update where sop_alias='".$alias."'")->row_array();
		
		$file = $this->config->item('pathupload_pdf').$p['sop_update_file'];
		$filename = $p['sop_update_file'];
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' . $filename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');
		@readfile($file);
		
	}
	
	function penyusunan_sop()
	{			
		
			$data=array();
			$data['title'] = 'Penyusunan SOP';
			
			$session_data = $this->session->userdata;
			$data['userid'] = $session_data['userid'];
			$data['groupid'] = $session_data['groupid'];
			$data['fullname'] = $session_data['fullname'];
			$data['foto'] = $session_data['foto'];
			$data['satkernm'] = $session_data['satkernm'];
			$data['unitkerjanm'] = $session_data['unitkerjanm'];
			$userid = $session_data['userid'];
			$data['notif'] = $this->Notif_m->notification(5,$userid);
			$data['menu'] = $this->Main->menu_backend($session_data['groupid']);
			
			$act = $this->uri->segment(3);
			$data['dtjabatan'] = $this->Sop_m->jabatan($session_data['satkerid'],$session_data['unitkerjaid']);
			$data['sop'] = $this->Sop_m->sop_detail($this->uri->segment(4));
			
			
			if($act == 'doc'){
				$this->load->view('page/sop/penyusunan_/doc',$data);
			}elseif($act == 'print'){
				$this->load->view('page/sop/penyusunan_/print',$data);
			}else{
				$this->load->view('template/header',$data);
				if($act == ''){
					$this->load->view('page/sop/semua/index',$data);
				}elseif($act == 'lihat'){
					$this->load->view('page/sop/penyusunan_/lihat',$data);
				}elseif($act == 'cekadmin'){
					$this->load->view('page/sop/penyusunan_/lihat',$data);
				}elseif($act == 'upload'){
					$this->load->view('page/sop/penyusunan_/upload',$data);
				}elseif($act == 'edit'){
					$this->load->view('page/sop/penyusunan_/action_edit',$data);
				}else{
					$this->load->view('page/sop/penyusunan_/action',$data);
				}
				$this->load->view('template/footer',$data);
			}
		
	}
	  

	function revisi_sop()
	{			
		
			$data=array();
			$data['title'] = 'Revisi SOP';
			
			$session_data = $this->session->userdata;
			$data['userid'] = $session_data['userid'];
			$data['groupid'] = $session_data['groupid'];
			$data['fullname'] = $session_data['fullname'];
			$data['foto'] = $session_data['foto'];
			$data['satkernm'] = $session_data['satkernm'];
			$data['unitkerjanm'] = $session_data['unitkerjanm'];
			$userid = $session_data['userid'];
			$data['notif'] = $this->Notif_m->notification(5,$userid);
			$data['menu'] = $this->Main->menu_backend($session_data['groupid']);
			
			$act = $this->uri->segment(3);
			$data['action'] = $this->Sop_m->cek_notif($this->uri->segment(5));
			$data['sop'] = $this->Sop_m->sop_detail($this->uri->segment(4));
			$data['pesan'] = $this->Sop_m->field_sop('notif','notif_desc','notif_id',$this->uri->segment(5));
			
			
				$this->load->view('template/header',$data);
				if($act == ''){
					$this->load->view('page/sop/revisi/index',$data);
				}elseif($act == 'periksa'){
					$this->load->view('page/sop/revisi/periksa',$data);
				}elseif($act == 'lihat'){
					$this->load->view('page/sop/revisi/lihat',$data);
				}elseif($act == 'sebelumnya'){
					$data['title'] = 'Revisi SOP [SOP sebelum direvisi]';
					$this->load->view('page/sop/revisi/sebelumnya',$data);
				}else{
					$this->load->view('page/sop/revisi/ajukan',$data);
				}
				$this->load->view('template/footer',$data);
		
	}
	function get_revisi_sop()
	{
		
		$session_data = $this->session->userdata;
		$groupid = $session_data['groupid'];
		$userid = $session_data['userid'];
		$unitkerjaid = $session_data['unitkerjaid'];
		
		$where = ($groupid == 9 ? 'where user_id='.$userid.'' : ($groupid == 10 ? 'where unit_kerja_id='.$unitkerjaid.'' : ''));
		$result = $this->Sop_m->get_datatables('revisisop'); //nama function
		$data = array();
		$i= ($_POST['start']== '' ? 0 : $_POST['start']);
		foreach ($result as $row) {
			$i++;
			$rel = array();
			$rel[] = $i;
			$rel[] = $row->sop_no;
			$rel[] = $row->sop_nama;
			$rel[] = tgl_indo2($row->revisi_tanggal);
			$rel[] = ($row->revisi_status == 'pending' ? '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">Pending</span>' : ( $row->revisi_status == 'diterima' ? '<span class="badge badge-md badge-success" style="color:#fff; font-size:11px">Diterima</span>' : ($row->revisi_status == 'ditolak'  ? '<span class="badge badge-md badge-danger" style="color:#fff; font-size:11px">Ditolak</span>' : '')));
			$rel[] = '<a href="'.base_url().'sop/revisi_sop/lihat/'.$row->sop_alias.'/'.$row->revisi_id.'" title="Lihat">
						<span class="btn btn-xs btn-info"><i class="icon wb-eye" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>';
			
			$data[] = $rel;
		}
		
		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Sop_m->count_all('(select * from vwrevisi '.$where.') as vwrevisi'), //nama tabel
				"recordsFiltered" => $this->Sop_m->count_filtered('revisisop'), //nama function
				"data" => $data,
		);
		echo json_encode($output);
	}
	  

	function reviu()
	{			
		
			$data=array();
			$data['title'] = 'Reviu SOP';
			
			$session_data = $this->session->userdata;
			$data['userid'] = $session_data['userid'];
			$data['groupid'] = $session_data['groupid'];
			$data['fullname'] = $session_data['fullname'];
			$data['foto'] = $session_data['foto'];
			$data['satkernm'] = $session_data['satkernm'];
			$data['unitkerjanm'] = $session_data['unitkerjanm'];
			$userid = $session_data['userid'];
			$data['notif'] = $this->Notif_m->notification(5,$userid);
			$data['menu'] = $this->Main->menu_backend($session_data['groupid']);
			
			$act = $this->uri->segment(3);
			$data['action'] = $this->Sop_m->cek_notif($this->uri->segment(5));
			$data['sop'] = $this->Sop_m->sop_detail($this->uri->segment(4));
			$data['pesan'] = $this->Sop_m->field_sop('notif','notif_desc','notif_id',$this->uri->segment(5));
			$this->Notif_m->update_status('notif','notif_status','notif_id',$this->uri->segment(5));
			
				$this->load->view('template/header',$data);
				if($act == 'periksa'){
					$this->load->view('page/sop/reviu/periksa',$data);
				}else{
					$this->load->view('page/sop/reviu/lihat',$data);
				}
				$this->load->view('template/footer',$data);
		
	}
	  

	function pengesahan_sop()
	{			
		
			$data=array();
			$data['title'] = 'Pengesahan SOP';
			
			$session_data = $this->session->userdata;
			$data['userid'] = $session_data['userid'];
			$data['groupid'] = $session_data['groupid'];
			$data['fullname'] = $session_data['fullname'];
			$data['foto'] = $session_data['foto'];
			$data['satkernm'] = $session_data['satkernm'];
			$data['unitkerjanm'] = $session_data['unitkerjanm'];
			$userid = $session_data['userid'];
			$data['notif'] = $this->Notif_m->notification(5,$userid);
			$data['menu'] = $this->Main->menu_backend($session_data['groupid']);
			
			$act = $this->uri->segment(3);
			$data['dtjabatan'] = $this->Sop_m->jabatan($session_data['satkerid'],$session_data['unitkerjaid']);
			$data['sop'] = $this->Sop_m->sop_detail($this->uri->segment(4));
			// ttd image
			$data['ttd_nama'] = '';
			$data['ttd_img'] = '';
			$ttdpengesah= $this->Sop_m->ttd_pengesah($userid);
			foreach($ttdpengesah->result_array() as $row){
				$data['ttd_nama'] = $row['ttd_pengesah_nama'];
				$data['ttd_img'] = $row['ttd_pengesah_gambar'];
			}
			
				$this->load->view('template/header',$data);
				if($act == ''){
					$this->load->view('page/sop/pengesahan/index',$data);
				}else{
					$this->load->view('page/sop/pengesahan/lihat',$data);
				}
				$this->load->view('template/footer',$data);
		
	}

	function pencarian_sop()
	{			
		
			$data=array();
			$data['title'] = 'Pencarian SOP';
			
			$session_data = $this->session->userdata;
			$data['userid'] = $session_data['userid'];
			$data['groupid'] = $session_data['groupid'];
			$data['fullname'] = $session_data['fullname'];
			$data['foto'] = $session_data['foto'];
			$data['satkernm'] = $session_data['satkernm'];
			$data['unitkerjanm'] = $session_data['unitkerjanm'];
			$userid = $session_data['userid'];
			$data['notif'] = $this->Notif_m->notification(5,$userid);
			$data['menu'] = $this->Main->menu_backend($session_data['groupid']);
			
			
			$act = $this->uri->segment(3);
			//$data['dtjabatan'] = $this->Sop_m->jabatan($session_data['satkerid'],$session_data['unitkerjaid']);
			$data['sop'] = $this->Sop_m->sop_detail($this->uri->segment(4));
			
			
				$this->load->view('template/header',$data);
				if($act == ''){
					$this->load->view('page/sop/pencarian/index',$data);
				}else{
					$this->load->view('page/sop/pencarian/lihat',$data);
				}
				$this->load->view('template/footer',$data);
		
	}

	function get_pencarian_sop()
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
			$rel[] = $row->penyusun;
			$rel[] = ($row->sop_update_file == '' ? '<span class="badge badge-md badge-info" style="color:#fff; font-size:11px">Auto</span>' : '<span class="badge badge-md badge-warning" style="color:#fff; font-size:11px">Manual</span>');
			$rel[] = '<a href="'.base_url().'sop/pencarian_sop/lihat/'.$row->sop_alias.'" title="Lihat">
						<span class="btn btn-xs btn-info"><i class="icon wb-eye" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>';
			$rel[] = '<a href="'.base_url().'act_sop/delete_sop/'.$row->sop_alias.'/pencarian" class="del'.$row->sop_alias.'" title="Delete">
						<span class="btn btn-xs btn-danger"><i class="icon wb-trash" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>
					  
					  <script type="text/javascript">
						var elems = document.getElementsByClassName(\'del'.$row->sop_alias.'\');
						var confirmIt = function (e) {
							if (!confirm(\'Yakin Akan Dihapus ?\')) e.preventDefault();
						};
						for (var i = 0, l = elems.length; i < l; i++) {
							elems[i].addEventListener(\'click\', confirmIt, false);
						}
					</script>';
			
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
	  

	function evaluasi_sop()
	{			
		
			
			$data=array();
			$data['title'] = 'Evaluasi SOP';
			
			$session_data = $this->session->userdata;
			$data['userid'] = $session_data['userid'];
			$data['groupid'] = $session_data['groupid'];
			$data['fullname'] = $session_data['fullname'];
			$data['foto'] = $session_data['foto'];
			$data['satkernm'] = $session_data['satkernm'];
			$data['unitkerjanm'] = $session_data['unitkerjanm'];
			$userid = $session_data['userid'];
			$data['notif'] = $this->Notif_m->notification(5,$userid);
			$data['menu'] = $this->Main->menu_backend($session_data['groupid']);
			
			$act = $this->uri->segment(3);
			$data['dtjabatan'] = $this->Sop_m->jabatan($session_data['satkerid'],$session_data['unitkerjaid']);
			$data['sop'] = $this->Sop_m->sop_detail($this->uri->segment(4));
			
			
			$this->load->view('template/header',$data);
			if($act == ''){
				$this->load->view('page/sop/evaluasi/index',$data);
			}elseif($act == 'lihat'){
				$this->load->view('page/sop/evaluasi/lihat',$data);
			}else{
				$this->load->view('page/sop/evaluasi/action',$data);
			}
			$this->load->view('template/footer',$data);
			
		
	}
	
	function get_evaluasi_sop()
	{
		
		$result = $this->Sop_m->get_datatables('evaluasisop'); //nama function
		$data = array();
		$i= ($_POST['start']== '' ? 0 : $_POST['start']);
		foreach ($result as $row) {
			$i++;
			$rel = array();
			$rel[] = $i;
			$rel[] = $row->sop_no;
			$rel[] = $row->sop_nama;
			$rel[] = $row->sop_tgl_pembuatan;
			$rel[] = '<a href="'.base_url().'sop/evaluasi_sop/lihat/'.$row->sop_alias.'" title="Lihat SOP">
						<span class="btn btn-xs btn-info"><i class="icon wb-eye" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>';
			$rel[] = '<a href="'.base_url().'act_sop/delete_evaluasi/'.$row->sop_alias.'" class="del'.$row->sop_alias.'" title="Delete SOP">
						<span class="btn btn-xs btn-danger"><i class="icon wb-trash" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>
					  
					  
					  <script type="text/javascript">
						var elems = document.getElementsByClassName(\'del'.$row->sop_alias.'\');
						var confirmIt = function (e) {
							if (!confirm(\'Yakin Akan Dihapus ?\')) e.preventDefault();
						};
						for (var i = 0, l = elems.length; i < l; i++) {
							elems[i].addEventListener(\'click\', confirmIt, false);
						}
					</script>';
			
			$data[] = $rel;
		}
		
		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Sop_m->count_all('evaluasi'), //nama tabel
				"recordsFiltered" => $this->Sop_m->count_filtered('evaluasisop'), //nama function
				"data" => $data,
		);
		echo json_encode($output);
	}

	function upload()
	{			
		
			
			$data=array();
			$data['title'] = 'Upload Berkas SOP';
			
			$session_data = $this->session->userdata;
			$data['userid'] = $session_data['userid'];
			$data['groupid'] = $session_data['groupid'];
			$data['fullname'] = $session_data['fullname'];
			$data['foto'] = $session_data['foto'];
			$data['satkernm'] = $session_data['satkernm'];
			$data['unitkerjanm'] = $session_data['unitkerjanm'];
			$userid = $session_data['userid'];
			$data['notif'] = $this->Notif_m->notification(5,$userid);
			$data['menu'] = $this->Main->menu_backend($session_data['groupid']);
			
			$act = $this->uri->segment(3);
			$data['dtjabatan'] = $this->Sop_m->jabatan($session_data['satkerid'],$session_data['unitkerjaid']);
			$data['dtsatker'] = $this->Sop_m->select_table('satuan_organisasi','satuan_organisasi_id');
			$data['sop'] = $this->Sop_m->sop_detail($this->uri->segment(4));
			$data['editsop'] = $this->db->query("select s.satuan_organisasi_id,s.unit_kerja_id,s.bagian_id,b.* from berkas_sop b left join sop s on b.sop_alias=s.sop_alias where b.id='".$this->uri->segment(4)."'");
			
			
			$this->load->view('template/header',$data);
			if($act == ''){
				$this->load->view('page/sop/upload/index',$data);
			}else{
				$this->load->view('page/sop/upload/action',$data);
			}
			$this->load->view('template/footer',$data);
			
		
	}
	function get_upload_sop(){
		
		$result = $this->Sop_m->get_datatables('uploadsop'); //nama function
		$data = array();
		$i= ($_POST['start']== '' ? 0 : $_POST['start']);
		foreach ($result as $row) {
			$i++;
			$rel = array();
			$rel[] = $i;
			$rel[] = $row->tanggal;
			$rel[] = $row->sop_nama;
			$rel[] = '<a href="'.base_url().'sop/pdf_sop/'.$row->sop_alias.'" title="Lihat" target="_blank">
						<span class="btn btn-xs btn-info"><i class="icon wb-eye" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>';
			$rel[] = '<a href="'.base_url().'sop/upload/edit/'.$row->id.'" title="Edit">
						<span class="btn btn-xs btn-warning"><i class="icon wb-pencil" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>
					  <a href="'.base_url().'act_sop/delete_berkassop/'.$row->id.'" class="del'.$row->sop_alias.'" title="Delete">
						<span class="btn btn-xs btn-danger"><i class="icon wb-trash" aria-hidden="true" style="color:#fff; font-size:12px"></i></span>
					  </a>
					  
					  
					  <script type="text/javascript">
						var elems = document.getElementsByClassName(\'del'.$row->sop_alias.'\');
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
				"recordsTotal" => $this->Sop_m->count_all('berkas_sop'), //nama tabel
				"recordsFiltered" => $this->Sop_m->count_filtered('uploadsop'), //nama function
				"data" => $data,
		);
		echo json_encode($output);
	}

	
}
