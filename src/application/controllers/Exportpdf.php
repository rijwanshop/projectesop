 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exportpdf extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->output->set_header('X-Content-Type-Options: nosniff');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate;');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('X-Frame-Options: DENY');
        $this->output->set_header('X-XSS-Protection: 1; mode=block');

		$this->load->model('Model_sop','sop');
		$this->load->helper('kegiatan');
		date_default_timezone_set('Asia/Jakarta'); 
	}
	public function print_sop(){
		$alias = dekripsi_id_url($this->uri->segment(3));
		if($alias == ''){
			echo 'Akses telah dibatasi';
			exit();
		}

		$dt_sop = $this->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}

		if($dt_sop->row()->sop_status == 'Disahkan'){
			$file_pdf = $this->config->item('path_exportpdf').'sop_tte_'.$alias.'.pdf';
			if (!file_exists($file_pdf)){
				echo 'File yang sudah di TTE tidak ditemukan';
				exit();
			}

			//tampilkan file
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="'.$dt_sop->row()->sop_nama.'"');
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');
			@readfile($file_pdf);
		}else{
			$this->load->helper('eksport');

			if($dt_sop->row()->sop_update_file != ''){
				$file_merge = $this->config->item('path_exportpdf').'merger_'.$alias.'.pdf';
				if(file_exists($file_merge)){

					//tampilkan file
					header('Content-type: application/pdf');
					header('Content-Disposition: inline; filename="'.$dt_sop->row()->sop_nama.'"');
					header('Content-Transfer-Encoding: binary');
					header('Accept-Ranges: bytes');
					@readfile($file_merge);
				}else{
					$file_header = $this->config->item('path_exportpdf').'header_sop_'.$alias.'.pdf';
					if(!file_exists($file_header)){
						eksport_header($alias);
					}
					$file_manual = $this->config->item('path_draftpdf').$dt_sop->row()->sop_update_file;

					//merge PDF
					$pdf = new \Clegginabox\PDFMerger\PDFMerger;
					$pdf->addPDF($file_header, 'all');
					$pdf->addPDF($file_manual, 'all');
					$pdf->merge('file', $file_merge, 'L');

					if(file_exists($file_merge)){
						//tampilkan file
						header('Content-type: application/pdf');
						header('Content-Disposition: inline; filename="'.$dt_sop->row()->sop_nama.'"');
						header('Content-Transfer-Encoding: binary');
						header('Accept-Ranges: bytes');
						@readfile($file_merge);
					}else{
						echo 'Gagal melakukan merge file PDF, silahkan muat ulang halaman ini';
						exit();
					}
				}
				
			}else{
				hapus_file_merge($alias);
				$file_kegiatan = eksport_kegiatan($alias);
				if($file_kegiatan == ''){
					echo 'Gagal melakukan generate file PDF, silahkan muat ulang halaman ini';
					exit();
				}else{
					$file_merge = $this->config->item('path_exportpdf').'merger_'.$alias.'.pdf';
					$file_header = $this->config->item('path_exportpdf').'header_sop_'.$alias.'.pdf';
					if(!file_exists($file_header)){
						eksport_header($alias);
					}

					//merge PDF
					$pdf = new \Clegginabox\PDFMerger\PDFMerger;
					$pdf->addPDF($file_header, 'all');
					$pdf->addPDF($file_kegiatan, 'all');
					$pdf->merge('file', $file_merge, 'L');

					if(file_exists($file_merge)){
						//tampilkan file
						header('Content-type: application/pdf');
						header('Content-Disposition: inline; filename="'.$dt_sop->row()->sop_nama.'"');
						header('Content-Transfer-Encoding: binary');
						header('Accept-Ranges: bytes');
						@readfile($file_merge);
					}else{
						echo 'Gagal melakukan merge file PDF, silahkan muat ulang halaman ini';
						exit();
					}
				}
			}
		}
	}
	//hanya untuk pengecekan library
	public function tes_case(){
		$pdf = new \Clegginabox\PDFMerger\PDFMerger;
		echo 'library Oke';
	}
}