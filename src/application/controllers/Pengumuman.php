<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Pengumuman extends CI_Controller {

	public function __construct() {
		parent::__construct(); 
		$this->load->helper(array('form','url', 'text_helper','date','tgl_indonesia'));
		$this->load->database();
		$this->load->model(array('Main'));	
		$this->load->library(array('alias','Ajax_pagination'));
		$this->perPage = 2;		
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
		 
		 
		 $data['title'] = 'Berita';
		 $data['evaluasi'] = $this->Main->on_of_evaluasi();
		 $data['pengunjung'] = $this->Main->pengunjung_hariini($tanggal);
		 foreach ($this->Main->pengunjung_total()->result_array() as $row) 
		 {
			$data['totalpengunjung'] = $row['total'];
		 }
		 
		 // Paging Ajax
		//total rows count
		//$totalRec = count($this->main->getRows(array(),$ssss));
		$totalRec = count($this->Main->getRows());
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pengumuman/page';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		
		$this->ajax_pagination->initialize($config);
		
		//get the posts data
		$data['posts'] = $this->Main->getRows(array('limit'=>$this->perPage));
		// end Paging Ajax
					
					
					
		 $data['pengumuman_terbaru'] = $this->Main->pengumuman_terbaru(5);
		 //$data['pengumuman'] = $this->Main->select_table('pengumuman','pengumuman_id');
		 $data['tentangkami'] = $this->Main->edit_table('post_content','content_menu','tentang_kami');
		 $data['agenda'] = $this->Main->edit_table('post_content','content_menu','agenda');
		 $this->load->view('front/header',$data);
		 $this->load->view('front/pengumuman/index',$data);
		 $this->load->view('front/footer',$data);
	}
	
	function detail()
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
		 
		 $data['evaluasi'] = $this->Main->on_of_evaluasi();
		 $data['pengunjung'] = $this->Main->pengunjung_hariini($tanggal);
		 foreach ($this->Main->pengunjung_total()->result_array() as $row) 
		 {
			$data['totalpengunjung'] = $row['total'];
		 }
		 
		 $data['title'] = 'Berita';
		 
		 $link = $this->uri->segment(2);
		 $data['pengumuman_terbaru'] = $this->Main->pengumuman_terbaru(5);
		 $data['posts'] = $this->Main->edit_table('pengumuman','pengumuman_alias',$link);
		 $data['tentangkami'] = $this->Main->edit_table('post_content','content_menu','tentang_kami');
		 $data['agenda'] = $this->Main->edit_table('post_content','content_menu','agenda');
		 $this->load->view('front/header',$data);
		 $this->load->view('front/pengumuman/detail',$data);
		 $this->load->view('front/footer',$data);
	}
	
	
	function page()
    {
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //total rows count
        $totalRec = count($this->Main->getRows());
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'pengumuman/page';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['posts'] = $this->Main->getRows(array('start'=>$offset,'limit'=>$this->perPage));
        
        //load the view
        $this->load->view('front/pengumuman/pagination', $data, false);
    }
}
