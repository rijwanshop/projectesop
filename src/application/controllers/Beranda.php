<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Beranda extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url', 'text_helper','date','tgl_indonesia','text'));
		$this->load->database();
		$this->load->model(array('Main'));	
		$this->load->library(array('alias'));
	}
	
	
	function index()
	{			
		 $ip      = $_SERVER['REMOTE_ADDR'];
		 $tanggal = date("Y-m-d");
		 $waktu   = time();
		 $cek = $this->Main->cek_pengunjung($ip,$tanggal);
		 if($cek == 0){
			 $this->Main->insert_pengunjung($ip,$tanggal);
		 }else{
			 $this->Main->update_pengunjung($ip,$tanggal);
		 }
		 
		 $data['title'] = 'Beranda';
		 $data['evaluasi'] = $this->Main->on_of_evaluasi();
		 $data['pengunjung'] = $this->Main->pengunjung_hariini($tanggal);
		 foreach ($this->Main->pengunjung_total()->result_array() as $row) 
		 {
			$data['totalpengunjung'] = $row['total'];
		 }
		 //$bataswaktu       = time() - 300;
		 //$pengunjungonline = mysql_num_rows(mysql_query("SELECT * FROM tstatistika WHERE online > '$bataswaktu'")); // hitung pengunjung online
		
		$data['slide'] = $this->Main->select_table('slide','slide_id');
		$data['kegiatan'] = $this->Main->select_table('kegiatan','kegiatan_id');
		$data['pengumuman'] = $this->Main->select_table('pengumuman','pengumuman_id');
		$data['tentangkami'] = $this->Main->edit_table('post_content','content_menu','tentang_kami');
		$data['agenda'] = $this->Main->edit_table('post_content','content_menu','agenda');
		
		$this->load->view('front/header',$data);
		$this->load->view('front/beranda',$data);
		$this->load->view('front/footer',$data);
	}
	
	function update_simbolpdf()
	{			
		$d = $this->db->query("SELECT simbol_id,simbol_margin from simbol where simbol_img like 'k-atas%'")->result_array();
		foreach ($d as $s) {
			$ex = explode(' ',$s['simbol_margin']);
			$top = 'margin-top:75px; ';
			$left = ' margin-left:-5px';
			echo '<br>'.$ex[0].'-'.$ex[1];
			$this->db->query("UPDATE simbol SET simbol_margin_pdf = '".$top.' '.$left."' WHERE simbol_id = '".$s['simbol_id']."'");
		}
	}
			
	
			
	public function upload_file()
	{
		$this->load->helper(array('form', 'url'));
		// setting konfigurasi upload
        $config['upload_path'] = 'E:/file/';
        $config['allowed_types'] = 'gif|jpg|png';
        // load library upload
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('gambar')) {
            $error = $this->upload->display_errors();
            // menampilkan pesan error
            print_r($error);
        } else {
            $result = $this->upload->data();
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        }
	}	
	public function f_upload_file()
	{
		$file = 'E:\file\jukop.pdf';
		$filename = 'filename.pdf';
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' . $filename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');
		@readfile($file);
		
	}
			
	public function forjs()
	{
		echo '
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<table border="1">
		  <tr>
			<th>sl</th>
			<th>TA</th>
			<th>DA</th>
			<th>HA</th>
			<th>Total</th>
		  </tr>
		  <tr>
			<td>1</td>
			<td><input class="expenses"></td>
			<td><input class="expenses"></td>
			<td><input class="expenses"></td>
			<td><input class="expenses_sum"></td>
		  </tr>
		  <tr>
			<td>2</td>
			<td><input class="expenses"></td>
			<td><input class="expenses"></td>
			<td><input class="expenses"></td>
			<td><input class="expenses_sum"></td>
		  </tr>
		  <tr>
			<td>3</td>
			<td><input class="expenses"></td>
			<td><input class="expenses"></td>
			<td><input class="expenses"></td>
			<td><input class="expenses_sum"></td>
		  </tr>
		</table>
		<script>
					$(document).ready(function() {
					  $(".expenses").on("keyup change", calculateSum);
					});

					function calculateSum() {
					  var $input = $(this);
					  var $row = $input.closest("tr");
					  var sum = 0;

					  $row.find(".expenses").each(function() {
						sum += parseFloat(this.value) || 0;
					  });

					  $row.find(".expenses_sum").val(sum.toFixed(2));
					}
					</script>
		';
	}
	
}
