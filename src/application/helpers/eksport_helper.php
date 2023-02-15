<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('print_pelaksana_bawah')){
	function eksport_pelaksana_bawah($alias){
		$CI = get_instance();
		$CI->load->model('Model_sop','sop');
		$dt_sop = $CI->sop->get_data_id('sop_alias', $alias, 'sop');
		$print = '';
		if($dt_sop->num_rows() > 0){
			$dt_sop = $dt_sop->result_array();
			for($p=10; $p<$dt_sop[0]['sop_jml_pelaksana']; $p++){
				if($dt_sop[0]['sop_nm_pel'.($p+1)] != ''){
					$print .= '<th rowspan="2">';
					$print .= $dt_sop[0]['sop_nm_pel'.($p+1)];
					$print .= '</th>';
				}
			}
		}
		return $print;
	}
}
if (!function_exists('print_pelaksana_atas')){
	function eksport_pelaksana_atas($alias){
		$CI = get_instance();
		$CI->load->model('Model_sop','sop');
		$dt_sop = $CI->sop->get_data_id('sop_alias', $alias, 'sop');
		$print = '';

		if($dt_sop->num_rows() > 0){

			$dt_sop = $dt_sop->result_array();
			for($p=0; $p<10; $p++){
				if($dt_sop[0]['sop_nm_pel'.($p+1)] != ''){
					$print .= '<th>';
					$print .= $dt_sop[0]['sop_nm_pel'.($p+1)];
					$print .= '</th>';
				}
			}
		}
		return $print;
	}
}
if (!function_exists('load_library')){
	function load_library($alias){
		ini_set('max_execution_time', 0);
		$CI = get_instance();
		$CI->load->library('Pdf');

		$CI->load->model('Model_sop','sop');
		$dt_sop = $CI->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			return '';
		}

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Kementerian Sekretariat Negara');
		$pdf->SetTitle($dt_sop->row()->sop_nama);
		$pdf->SetSubject('Print SOP');
		$pdf->SetKeywords('Uraian SOP');
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10, 10);
		$pdf->AddPage('L', 'F4');
		return $pdf;
	}
}
if (!function_exists('eksport_header')){
	function eksport_header($alias){
		$CI = get_instance();
		$CI->load->model('Model_sop','sop');
		$dt_sop = $CI->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			return '';
		}
		$file = $CI->config->item('path_exportpdf').'header_sop_'.$alias.'.pdf';
		if(file_exists($file)){
			unlink($file);
		}
		
		$pdf = load_library($alias);
		
		$keterkaitan = '';
		if($dt_sop->row()->sop_keterkaitan != ''){
			$a = str_replace('</a>', '', $dt_sop->row()->sop_keterkaitan);
			$ls_terkait = $CI->sop->get_list_sop();
			foreach ($ls_terkait->result() as $row){
				$link = '<a href="'.site_url('pengolahan_sop/detail_sop/'.enkripsi_id_detail($row->sop_alias)).'" target="_blank">';
				$a = str_replace($link, '', $a);
			}
			$keterkaitan = $a;
		}

		$header_sop = $CI->load->view('content/sop/header_eksport', array('sop' => $dt_sop,'keterkaitan' => $keterkaitan), true);
		$pdf->writeHTML($header_sop, true, false, true, false, '');
		$pdf->Output($file, 'F');
		return $file;
	}
}
if(!function_exists('eksport_kegiatan')){
	function eksport_kegiatan($alias){
		$CI = get_instance();
		$CI->load->model('Model_sop','sop');
		$dt_sop = $CI->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			return '';
		}
		$pdf = load_library($alias);
		
		if($dt_sop->row()->sop_update_file == ''){
			$data_view = array();
      		$data_view['sop'] = $dt_sop;

      		if($dt_sop->row()->sop_jml_pelaksana >= 10)
        		$data_view['jmlpel'] = 10;
      		else
        		$data_view['jmlpel'] = $dt_sop->row()->sop_jml_pelaksana;

      		$data_view['no'] = 1;
      		$data_view['img_chart'] = get_image_node($dt_sop->row()->sop_alias);
      		$kegiatan_sop = $CI->load->view('content/sop/kegiatan_eksport', $data_view, true);
      		$pdf->writeHTML($kegiatan_sop, true, false, true, false, '');

      		$file = $CI->config->item('path_exportpdf').'kegiatan_sop_'.$alias.'.pdf';
			if(file_exists($file)){
				unlink($file);
			}

			$pdf->Output($file, 'F');
			return $file;
		}else{
			return '';
		}
	}
}
if(!function_exists('hapus_file_kegiatan')){
	function hapus_file_kegiatan($alias){
		$CI = get_instance();
		$file = $CI->config->item('path_exportpdf').'kegiatan_sop_'.$alias.'.pdf';
		if(file_exists($file)){
			unlink($file);
		}
		return true;
	}
}
if(!function_exists('merge_pdf')){
	function merge_pdf($alias){
		$CI = get_instance();
		$CI->load->model('Model_sop','sop');
		$dt_sop = $CI->sop->detail_sop($alias);
		if($dt_sop->num_rows() == 0){
			return '';
		}
		hapus_file_kegiatan($alias);
		$file_manual = $CI->config->item('path_draftpdf').$dt_sop->row()->sop_update_file;
		if(empty($dt_sop->row()->sop_update_file) || !file_exists($file_manual)){
			return '';
		}
		$file_header = $CI->config->item('path_exportpdf').'header_sop_'.$alias.'.pdf';
		if(!file_exists($file_header)){
			eksport_header($alias);
		}
		$file_merge = $CI->config->item('path_exportpdf').'merger_'.$alias.'.pdf';
		if(file_exists($file_merge)){
			unlink($file_merge);
		}
		$pdf = new \Clegginabox\PDFMerger\PDFMerger;
		$pdf->addPDF($file_header, 'all');
		$pdf->addPDF($file_manual, 'all');
		$pdf->merge('file', $file_merge, 'L');
		return $file_merge;
	}
}
if(!function_exists('hapus_file_merge')){
	function hapus_file_merge($alias){
		$CI = get_instance();
		$file_merge = $CI->config->item('path_exportpdf').'merger_'.$alias.'.pdf';
		if(file_exists($file_merge)){
			unlink($file_merge);
		}
		return true;
	}
}