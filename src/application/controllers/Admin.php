<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('notif');
		$this->load->model('Main');
		$this->load->library('menubackend');
		$this->load->model('Model_admin','admin');
		cek_aktif();
	}
	public function index(){
		$data['title'] = 'Daftar User Operasional SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['pengguna'] = $this->admin->get_data_pengguna();
		$data['no'] = 1;
		$this->load->view('templating/header',$data);
		$this->load->view('content/admin/daftar_admin',$data);
		$this->load->view('templating/footer',$data);
	}
	public function get_group_user(){
		$this->load->model('Settings_m');
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
	public function tambah_pengguna(){
		$data['title'] = 'Tambah User Operasional SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['grup'] = $this->admin->get_user_grup();
		$data['link'] = site_url('admin/insert_pengguna');
		$this->load->view('templating/header',$data);
		$this->load->view('content/admin/v_input_admin',$data);
		$this->load->view('templating/footer',$data);
	}
	public function insert_pengguna(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('niplama', 'Niplama', 'trim|required');
		$this->form_validation->set_rules('grup', 'grup', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$data = array(
				'niplama' => trim($this->input->post('niplama', true)),
				'nama_pengguna' => trim($this->input->post('nama_pengguna', true)),
				'jabatan' => trim($this->input->post('jabatan', true)),
				'idgroup' => trim($this->input->post('grup', true)),
			);

			$n_user = $this->admin->total_record('pengguna');
			if($n_user == 0){
				$data['idpengguna'] = 'UO.00001';
			}else{
				$dt_id = $this->admin->max_id('idpengguna', 'pengguna');
				$dt_id = $dt_id->row()->idpengguna;
				$next_id = ((int)str_replace('UO.', '', $dt_id))+1;
				$data['idpengguna'] = 'UO.'.sprintf("%05s", $next_id);
			}

			$insert = $this->admin->insert_data($data, 'pengguna');
			if($insert){
				$data_ajax['success'] = true;
				$this->session->set_flashdata('message', 'Data pengguna berhasil diinput');
			}else{
				$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data pengguna gagal diinput, silahkan coba lagi</div>';
			}
		}else{
			$data_ajax['message'] = 'Data user gagal ditambahkan, silahkan isi form dengan benar';
		}
		echo json_encode($data_ajax);
	}
	public function edit_pengguna(){
		$iduser = $this->uri->segment(3);
		$dt_user = $this->admin->get_data_id('idpengguna', $iduser, 'pengguna');
		if($dt_user->num_rows() == 0){
			echo 'Hidden access';
			exit();
		}
		$data['pengguna'] = $dt_user->row();
		$data['title'] = 'Edit User Operasional SOP';
		$data['menu'] = $this->Main->menu_backend($this->session->userdata['groupid']);
		$data['grup'] = $this->admin->get_user_grup();
		$data['link'] = site_url('admin/update_pengguna');
		$this->load->view('templating/header',$data);
		$this->load->view('content/admin/v_input_admin',$data);
		$this->load->view('templating/footer',$data);
	}
	public function update_pengguna(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		$data_ajax['success'] = false;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('idpengguna', 'Idpengguna', 'trim|required');
		$this->form_validation->set_rules('niplama', 'Niplama', 'trim|required');
		$this->form_validation->set_rules('grup', 'grup', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$idpengguna = trim($this->input->post('idpengguna',true));
			$data = array(
				'niplama' => trim($this->input->post('niplama', true)),
				'nama_pengguna' => trim($this->input->post('nama_pengguna', true)),
				'jabatan' => trim($this->input->post('jabatan', true)),
				'idgroup' => trim($this->input->post('grup', true)),
			);
			$update = $this->admin->update_data('idpengguna', $idpengguna, $data, 'pengguna');
			if($update){
				$data_ajax['success'] = true;
				$this->session->set_flashdata('message', 'Data pengguna berhasil diedit');
			}else{
				$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data pengguna gagal diedit, silahkan coba lagi</div>';
			}
		}else{
			$data_ajax['message'] = 'Data user gagal diedit, silahkan isi form dengan benar';
		}
		echo json_encode($data_ajax);
	}
	public function hapus_pengguna(){
		if (!$this->input->is_ajax_request()) {
			echo '<h1 style="color:red">AKSES DITOLAK</h1>';
   			exit();
		}
		
		$idpengguna = trim($this->input->post('id', true));
		$data_ajax['success'] = false;
		$hapus = $this->admin->hapus_data('idpengguna', $idpengguna, 'pengguna');
		if($hapus){
			$data_ajax['success'] = true;
			$data_ajax['message'] = '<div class="alert alert-success" role="alert"><strong>Sukses!</strong> Data pengguna berhasil dihapus</div>';
		}else{
			$data_ajax['message'] = '<div class="alert alert-danger" role="alert"><strong>Warning!</strong> Data pengguna gagal dihapus</div>';
		}
		echo json_encode($data_ajax);
	}
}
