<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exportword extends CI_Controller {
	
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
	public function cetak_sop(){
		$alias = dekripsi_id_url($this->uri->segment(3));
        if($alias == ''){
            echo 'Akses telah dibatasi';
            exit();
        }
		$sop = $this->sop->detail_sop($alias);
		if($sop->num_rows() == 0){
			echo 'Data tidak ditemukan';
			exit();
		}

		ini_set('max_execution_time', 0);
		
		$this->load->library('word');

		$phpWord = new PHPWord();
        $template = $phpWord->loadTemplate('./assets/media/upload/template_sop.docx');
        $template->setValue('nomor_sop', $sop->row()->sop_no);
        $template->setValue('nama_unit', strtoupper($sop->row()->sop_unit_kerja));
        $template->setValue('nama_satker', strtoupper($sop->row()->sop_nama_satker));
        $template->setValue('tgl_pembuatan', $sop->row()->sop_tgl_pembuatan);
        $template->setValue('tgl_revisi', $sop->row()->sop_tgl_revisi);
        $template->setValue('tgl_efektif', $sop->row()->sop_tgl_efektif);
        $template->setValue('jabatan_pengesah', $sop->row()->sop_disahkan_jabatan);
        $template->setValue('nama_pengesah', $sop->row()->sop_disahkan_nama);
        $template->setValue('nip_pengesah', $sop->row()->sop_disahkan_nip);
        $template->setValue('nama_sop', $sop->row()->sop_nama);
        $template->setValue('sop_dasar_hukum', $sop->row()->sop_dasar_hukum);
        $template->setValue('kualifikasi_pelaksana', $sop->row()->sop_kualifikasi);

        $keterkaitan = '';
        if($sop->row()->sop_keterkaitan != ''){
            $a = str_replace('</a>', '', $sop->row()->sop_keterkaitan);
            $a = str_replace('<br>', '<w:br/>', $a);
            $ls_terkait = $this->sop->get_list_sop();
            foreach ($ls_terkait->result() as $row){
                $link = '<a href="'.site_url('pengolahan_sop/detail_sop/'.$row->sop_alias).'" target="_blank">';
                $a = str_replace($link, '', $a);
            }
            $keterkaitan = $a;
        }


        $template->setValue('keterkaitan', $keterkaitan);
        $template->setValue('peralatan', $sop->row()->sop_peralatan);
        $template->setValue('peringatan', $sop->row()->sop_peringatan);
        $template->setValue('pencatatan', $sop->row()->sop_pencatatan);

        $var = 'Some text';
		$xml = "<w:p><w:r><w:rPr><w:strike/></w:rPr><w:t>". $var."</w:t></w:r></w:p>";
        $template->setValue('tabel_kegiatan', $xml);


        $template->save($sop->row()->sop_nama.'.docx');
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$sop->row()->sop_nama.'.docx');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: '.filesize($sop->row()->sop_nama.'.docx'));
        flush();
        readfile($sop->row()->sop_nama.'.docx');
        unlink($sop->row()->sop_nama.'.docx');
        exit;        
	}
}
