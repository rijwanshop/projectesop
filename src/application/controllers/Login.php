<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/adldap/adLDAP.php';

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(array('Main'));
	}
	public function index(){
		if($this->session->userdata('login') == true){
			redirect('dashboard', 'refresh');
		}	
		$this->load->view('content/login/login');
	}

	public function logout(){
		$foto = $this->session->userdata('foto');
		if($foto != './assets/media/profile/icon_user2.png'){
			$foto = str_replace(base_url(), './', $foto);
			if (file_exists($foto)){
				unlink($foto);
			}
		}

		$this->session->sess_destroy();
		header('Location: '.site_url('login'));
	}
	
	private function set_session($nip){
		$this->config->load('web_service');

		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => $this->config->item('api_pegawai').'esop/pegawai?nip='.$nip,
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_ENCODING => '',
  			CURLOPT_MAXREDIRS => 10,
  			CURLOPT_TIMEOUT => 0,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
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
		if($resArray['status'] == 'OK' && $resArray['data'] != null){

			$sess_array = array(
				'userid' => md5('#@+setneg'.$resArray['data']['niplama']),
				'username' => $resArray['data']['niplama'],
				'foto' => $this->set_foto($nip),
				//'foto' => './assets/media/profile/icon_user2.png',
				'pegawainip' => $resArray['data']['nipbaru'],
				'pegawainm' => $resArray['data']['nmpeg'],
				'fullname' => $resArray['data']['nmpeg'],
				'satkerid' => $resArray['data']['idunit'],
				'satkernm' => $resArray['data']['satorg'],
				'deputinm' => $resArray['data']['deputi'],
				'iddeputi' => $resArray['data']['iddeputi'],
				'unitkerjaid' => $resArray['data']['idbiro'],
				'unitkerjanm' => $resArray['data']['biro'],
				'bagianid' => $resArray['data']['idbagian'],
				'bagiannm' => $resArray['data']['bagian'],
				'nik' => $resArray['data']['user_nik'],
				'status_tte' => $resArray['data']['user_status_tte'],
				'sinkron_data' => false,
				'login' => true,
			);

			$cek = $this->Main->cek_role_user($resArray['data']['niplama']);	
			if($cek->num_rows() > 0){
				$sess_array['groupid'] = $cek->row()->idgroup;
			}else{
				$sess_array['groupid'] = 9;
			}
			$this->session->set_userdata($sess_array);
			return true;
		}else{
			return false;
		}
	}
	private function set_foto($nip){
		$this->config->load('web_service');

		$curl = curl_init();

		curl_setopt_array($curl, array(
  			CURLOPT_URL => $this->config->item('api_pegawai_production').'main/foto?nip='.$nip,
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

		$path = './assets/temp_foto/'.$nip.'.jpeg';
		if (file_exists($path)){
			unlink($path);
		}

		file_put_contents($path, $response);
		if (file_exists($path))
			return str_replace('./', base_url(), $path);
		else
			return './assets/media/profile/icon_user2.png';
	}
	public function proses_login(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password_user', 'Password_user', 'trim|required');
		if($this->form_validation->run() == TRUE){
			$username = trim($this->input->post('username',true));
			$password = trim($this->input->post('password_user', true));

			/*
			try{
				$adldap = new adLDAP();
	                    
	            $inusernamepos = strpos($username, '.');
	            if($inusernamepos > 0)    
	                $username = substr($username, $inusernamepos+1, strlen($username));
	                                    
	            $username = @$adldap->user()->infoCollection($username, array('*'));
	            $username = @$username->distinguishedname;
	            if ($adldap->user()->authenticate($username, $password, TRUE)){
	            	$login = $this->set_session($username);

					if($login == true){
						header('Location: '.site_url('dashboard'));
					}else{
						$this->session->set_flashdata('message', 'Username atau password anda salah');
						header('Location: '.site_url('login'));
					}
	            }else{
	            	$this->session->set_flashdata('message', 'Username atau password anda salah');
					header('Location: '.site_url('login'));
	            }
			}catch(adLDAPException $e){
				$this->session->set_flashdata('message', 'Login SSO gagal. Silahkan coba lagi.');
				header('Location: '.site_url('login'));
			}
			*/
			
			
			$login = $this->set_session($username);

			if($login == true){
				header('Location: '.site_url('dashboard'));
			}else{
				$this->session->set_flashdata('message', 'Username atau password anda salah');
				header('Location: '.site_url('login'));
			}
	
		}else{
			$this->session->set_flashdata('message', 'Login SSO gagal. Silahkan coba lagi.');
			header('Location: '.site_url('login'));
		}
	}	
}