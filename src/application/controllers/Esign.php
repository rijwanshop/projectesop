<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Esign extends CI_Controller {

	
	public function index(){
		$this->load->view('welcome_message');
	}
    



    public function api_EM_getPegawai($nip){
    	$this->config->load('esign');

        $result = array();
        //$token = $this->getSettingValue('token_esignmanager');
        $token = $this->config->item('token_esignmanager');

        //$url = $this->getSettingValue('api_esignmanager');
        $url = $this->config->item('api_esignmanager');
        $methode = 'api/spesimen/data-pegawai';
        $requestget = array(
            'nip' => $nip
        );

        // curl

        $curl = curl_init();

        $url_data = http_build_query($requestget);

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url.$methode.'?'.$url_data,
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          //CURLOPT_POST => 1,
          //CURLOPT_POSTFIELDS => $post_data,
          CURLOPT_SSL_VERIFYHOST => FALSE,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            //"Content-Length: " . strlen($post_data),
            "Authorization: Bearer ".$token
          ),


        ));

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        $resArray = json_decode($response, true);
        //echo "<pre>";
        print_r($resArray);
        die;
        if($resArray['status'] == true){
            if($resArray['message'] == 'Data tidak ditemukan'){
                $result['status'] = 0;
                $result['message'] = "Pegawai belum terdaftar Sertifikasi TTE";
                $result['user_nik'] = "";
                $result['user_status_tte'] = 0;
                $result['user_status_signature'] = 0;
                $dtupdate = array('user_nik' => null, 'user_status_tte' => 0, 'user_status_signature' => 0);
                $this->updateStatusTTEPegawai($nip, $dtupdate);
            }else{
                $resdata = $resArray['data'];
                foreach ($resdata as $k => $v) {
                    $statusttd = 0;
                    if($v['image_ttd'] != ""){
                        $statusttd = $this->updateImageTTDPegawai($v['nip'], $v['image_ttd'], $token);
                    }
                    if($v['status'] == 1){ // asumsi ok
                        $dtupdate = array('user_nik' => $v['nik'], 'user_status_tte' => 1, 'user_status_signature' => $statusttd);
                        $this->updateStatusTTEPegawai($v['nip'], $dtupdate);
                        $result['status'] = 1;
                        $result['message'] = "Data Sertifikasi TTE sudah diupdate dan sudah bisa melakukan proses TTE";
                        $result['user_nik'] = $v['nik'];
                        $result['user_status_tte'] = 1;
                        $result['user_status_signature'] = $statusttd;
                    }else{ // asumsi belum
                        $dtupdate = array('user_nik' => $v['nik'], 'user_status_tte' => 0, 'user_status_signature' => $statusttd);
                        //print_r($dtupdate);
                        $this->updateStatusTTEPegawai($v['nip'], $dtupdate);
                        $result['status'] = 0;
                        $result['message'] = "Pegawai masih dalam proses Sertifikasi TTE";
                        $result['user_nik'] = $v['nik'];
                        $result['user_status_tte'] = 0;
                        $result['user_status_signature'] = $statusttd;
                    }
                }
            }
        }else{
            $result['status'] = 9;
            $result['message'] = "Service tidak dapat di jangkau.";
            $result['user_nik'] = "";
            $result['user_status_tte'] = 0;
            $result['user_status_signature'] = 0;
        }
        //print_r($result); die;
        return $result;
    }

    function updateImageTTDPegawai($nip, $urlttd, $token){
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
            'http' => array(
                'header'  => "Authorization: Bearer ".$token
            )
        );
        $status = 0;
        if(file_put_contents("./assets/images/".$nip.".png",  file_get_contents($urlttd, false, stream_context_create($arrContextOptions)))){
            $status = 1;
        }
        return $status;
    }
    public function testing(){
        $this->config->load('esign');
        $url = $this->config->item('api_esign');
        $methode = 'api/sign/pdf';
        $requestget = array(
            'nik' => '30122019',
            'tampilan' => 'visible',
            'halaman' => 'pertama',
            'linkQR' => 'http://siktln.kemensetneg.go.id/doc',
            'xAxis' => 750,
            'width' => 565,
            'height' => 485,
            'yAxis' => 425,
            'text' => '',
            'passphrase' => '#1234qwer*',
        );

        $curl = curl_init();
        $url_data = http_build_query($requestget);
        
        $methode = 'api/sign/pdf';
        
        if (file_exists('C:/Users/radian/Downloads/sop_testing_progress.pdf')){
            echo 'File tersedia<br>';
        }else{
            echo 'File tidak tersedia<br>';
        }
        $file = new CURLFile('C:/Users/radian/Downloads/sop_testing_progress.pdf','application/pdf','MyFile');
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url.$methode.'?'.$url_data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('file'=> new CURLFILE('C:/Users/radian/Downloads/sop_testing_progress.pdf', 'application/pdf', 'tespict')),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic dWppY29iYTp1amljb2Jh",
                "Content-Type: multipart/form-data",
                "Cookie: JSESSIONID=63C5A17E9EC73708FEE7F909CB64FC2B"
            ),
        ));

        
        

        $response = curl_exec($curl);
        $info = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        //print_r($info);
        //echo $response;
        $this->load->helper('download');
        force_download('tesfile.pdf', $response);   

    }
}
