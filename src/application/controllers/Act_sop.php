<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('date.timezone', 'Asia/Jakarta');

class Act_sop extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url', 'text_helper','date','tgl_indonesia'));
		$this->load->model(array('Sop_m'));	
		 $this->load->library(array('alias','form_validation'));
		cek_aktif();
	}
	

/* ====================================================================================================================================================== */
	function add_sop()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				$unitkerjaid = $session_data['unitkerjaid'];
				$bagianid = $session_data['bagianid'];
				$satkerid = $session_data['satkerid'];
				$satkernm = $session_data['satkernm'];
				$pegawaiid = $session_data['pegawaiid'];
				 
				$Error = '';
				$data = '';
				$id = $this->input->post('id');
				$headerok = $this->input->post('headerok');
				$kat_sop = $this->input->post('kat_sop');
				$status = ($this->input->post('status') == 'DRAFT REVISI' ? 'DRAFT REVISI' : 'DRAFT');
				$nm_satker = strtoupper($this->input->post('nm_satker'));
				$nm_unitkerja = strtoupper($this->input->post('nm_unitkerja'));
				$no_sop = $this->input->post('no_sop');
				$sop_nourut = $this->input->post('sop_nourut');
				$tgl_sop = $this->input->post('tgl_sop');
				$tgl_revisi = $this->input->post('tgl_revisi');
				$tgl_efektif = $this->input->post('tgl_efektif');
				$jabatan = $this->input->post('jabatan');
				$nama_pejabat = $this->input->post('nama_pejabat');
				$nip_pejabat = $this->input->post('nip_pejabat');
				$nama_sop = $this->input->post('nama_sop');
				$dasar_hukum = $this->input->post('dasar_hukum');
				$kualifikasi_pelaksana = $this->input->post('kualifikasi_pelaksana');
				$keterkaitan = $this->input->post('keterkaitan');
				$peralatan = $this->input->post('peralatan');
				$peringatan = $this->input->post('peringatan');
				$pencatatan = $this->input->post('pencatatan');
				$pelaksana_perbaris = $this->input->post('pelaksana_perbaris');
				$decision_perbaris = $this->input->post('decision_perbaris');
				
				if($id == ''){
					if($this->Sop_m->cek_jml_sop() > 0){
						$query = $this->Sop_m->alias_sop1(); // random number
					}else{
						$query = $this->Sop_m->alias_sop2(); // random number
					}
					$alias = $query[0]['random_num'];
				}else{
					$alias = $id;
				}
				
				$pelaksana = $this->input->post('pelaksana');
				$kegiatan = $this->input->post('kegiatan');
				$kelengkapan = $this->input->post('kelengkapan');
				$waktu = $this->input->post('waktu');
				$hasil = $this->input->post('hasil');
				$keterangan = $this->input->post('keterangan');
				
				$nmpel1 = '';
				$nmpel2 =  '';
				$nmpel3 =  '';
				$nmpel4 =  '';
				$nmpel5 =  '';
				$nmpel6 =  '';
				$nmpel7 = '';
				$nmpel8 =  '';
				$nmpel9 =  '';
				$nmpel10 =  '';
				$nmpel11 =  '';
				$nmpel12 =  '';
				$nmpel13 =  '';
				$nmpel14 =  '';
				$nmpel15 =  '';
				
				
				// validasi null
				//if($kat_sop == '') $Error .='Pilih Kategori SOP';
				
				
				if($headerok == '' ){$Error .= 'Identitas Kosong';}
				
				if($Error == ''){
					if($id != ''){ //edit
						$q = "delete from sop where sop_alias='".$alias."'";
						$this->Sop_m->query_manual($q);
						
						$q = "delete from penyusun_sop where sop_alias='".$alias."'";
						$this->Sop_m->query_manual($q);
					}
					// nourut 
					$nourut = ($sop_nourut != '' ? $sop_nourut : $this->Sop_m->nourut($unitkerjaid) + 1);
						
						
						
						
						
						$r=0;
						$konektor=1;
						for($i=0;$i<count($kegiatan);$i++){
						$r++;
							$pel1 = $this->input->post('check_pelaksana1_'.$i.'');
							$pel2 = $this->input->post('check_pelaksana2_'.$i.'');
							$pel3 = $this->input->post('check_pelaksana3_'.$i.'');
							$pel4 = $this->input->post('check_pelaksana4_'.$i.'');
							$pel5 = $this->input->post('check_pelaksana5_'.$i.'');
							$pel6 = $this->input->post('check_pelaksana6_'.$i.'');
							$pel7 = $this->input->post('check_pelaksana7_'.$i.'');
							$pel8 = $this->input->post('check_pelaksana8_'.$i.'');
							$pel9 = $this->input->post('check_pelaksana9_'.$i.'');
							$pel10 = $this->input->post('check_pelaksana10_'.$i.'');
							$pel11 = $this->input->post('check_pelaksana11_'.$i.'');
							$pel12 = $this->input->post('check_pelaksana12_'.$i.'');
							$pel13 = $this->input->post('check_pelaksana13_'.$i.'');
							$pel14 = $this->input->post('check_pelaksana14_'.$i.'');
							$pel15 = $this->input->post('check_pelaksana15_'.$i.'');
							if($r <= count($pelaksana)){
								for($p=0;$p<count($pelaksana);$p++){
								if($pelaksana[$p] != ''){
									if($p == '0') {$nmpel1 = $pelaksana[$p];};
									if($p == '1') {$nmpel2 = $pelaksana[$p];};
									if($p == '2') {$nmpel3 = $pelaksana[$p];};
									if($p == '3') {$nmpel4 = $pelaksana[$p];};
									if($p == '4') {$nmpel5 = $pelaksana[$p];};
									if($p == '5') {$nmpel6 = $pelaksana[$p];};
									if($p == '6') {$nmpel7 = $pelaksana[$p];};
									if($p == '7') {$nmpel8 = $pelaksana[$p];};
									if($p == '8') {$nmpel9 = $pelaksana[$p];};
									if($p == '9') {$nmpel10 = $pelaksana[$p];};
									if($p == '10') {$nmpel11 = $pelaksana[$p];};
									if($p == '11') {$nmpel12 = $pelaksana[$p];};
									if($p == '12') {$nmpel13 = $pelaksana[$p];};
									if($p == '13') {$nmpel14 = $pelaksana[$p];};
									if($p == '14') {$nmpel15 = $pelaksana[$p];};
								}             
								}
							}
								$isi = '';
								if($i == $konektor){$konektor = $konektor+5; $isi='0';}
							
								$sopno = ($no_sop != '' ? $no_sop : $nourut.'/'.date('Y'));
								$q = "Insert into sop(sop_nourut,sop_no,sop_nama_satker,sop_unit_kerja,sop_tgl_pembuatan,sop_tgl_revisi,sop_disahkan_jabatan,sop_disahkan_nama,sop_disahkan_nip,sop_nama,sop_dasar_hukum,sop_kualifikasi,sop_keterkaitan,sop_peralatan,sop_peringatan,sop_pencatatan,
									  sop_kegiatan,sop_pelaksana1,sop_pelaksana2,sop_pelaksana3,sop_pelaksana4,sop_pelaksana5,sop_pelaksana6,sop_pelaksana7,sop_pelaksana8,sop_pelaksana9,sop_pelaksana10,sop_pelaksana11,sop_pelaksana12,sop_pelaksana13,sop_pelaksana14,sop_pelaksana15,
									  sop_nm_pel1,sop_nm_pel2,sop_nm_pel3,sop_nm_pel4,sop_nm_pel5,sop_nm_pel6,sop_nm_pel7,sop_nm_pel8,sop_nm_pel9,sop_nm_pel10,sop_nm_pel11,sop_nm_pel12,sop_nm_pel13,sop_nm_pel14,sop_nm_pel15,
									  sop_pelaksana_perbaris,sop_decision_perbaris,sop_jml_pelaksana,sop_kelengkapan,sop_waktu,sop_hasil,sop_keterangan,user_id,satuan_organisasi_id,satuan_organisasi_nama,unit_kerja_id,bagian_id,sop_status,sop_alias,sop_konektor) 
									values('".$nourut."','".$sopno."','".$nm_satker."','".$nm_unitkerja."','".$tgl_sop."','".$tgl_revisi."','".$jabatan."','".$nama_pejabat."','".$nip_pejabat."','".$nama_sop."','".$dasar_hukum."','".$kualifikasi_pelaksana."','".$keterkaitan."','".$peralatan."','".$peringatan."','".$pencatatan."','".$kegiatan[$i]."',
									'".$pel1."','".$pel2."','".$pel3."','".$pel4."','".$pel5."','".$pel6."','".$pel7."','".$pel8."','".$pel9."','".$pel10."','".$pel11."','".$pel12."','".$pel13."','".$pel14."','".$pel15."',
									'".$nmpel1."','".$nmpel2."','".$nmpel3."','".$nmpel4."','".$nmpel5."','".$nmpel6."','".$nmpel7."','".$nmpel8."','".$nmpel9."','".$nmpel10."','".$nmpel11."','".$nmpel12."','".$nmpel13."','".$nmpel14."','".$nmpel15."',
									'".$pelaksana_perbaris[$i]."','".$decision_perbaris[$i]."','".count($pelaksana)."','".$kelengkapan[$i]."','".$waktu[$i]."','".$hasil[$i]."','".$keterangan[$i]."','".$userid."','".$satkerid."','".$satkernm."','".$unitkerjaid."','".$bagianid."','".$status."','".$alias."','".$isi."')";
								$this->Sop_m->query_manual($q);
								
						}
						
						// pegawai penyusun sop
						$q = "Insert into penyusun_sop(pegawai_id,sop_alias,penyusun_tanggal) 
								values('".$pegawaiid."','".$alias."',NOW())";
						$this->Sop_m->query_manual($q);
						
						
						$id = $alias;
					
					
					$data .=$id;
				}
				
				
				if($Error == ''){
					echo die($data);
				}else{
					echo $Error;
				}
			
	}
	
	function upload_sopmanual()
	{
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error ='';
				$alias = $this->input->post('alias');
				$ori = $this->input->post('ori');
				
				//upload
				
				if($ori != $_FILES['fileupload']['name']){
					$this->load->library('upload');
					$nmfile = 'sop_'.$alias.'_'.time();
					$config['upload_path'] = $this->config->item('pathupload_pdf');
					$config['allowed_types'] = 'pdf'; 
					$config['max_size'] = '300072'; 
					$config['max_width']  = '50000'; 
					$config['max_height']  = '50000'; 
					$config['file_name'] = $nmfile;
			    
					$this->upload->initialize($config);
					if($_FILES['fileupload']['name'])
					{
						if ($this->upload->do_upload('fileupload')) {
							$gbr = $this->upload->data();
							$file = $gbr['file_name'];
							if($ori != ''){
								$path = $this->config->item('pathupload_pdf');
								unlink($path.$ori);
							}
						}else{
							$Error .='File Gagal di Upload';
						}
					}
				}
				// upload
				if($Error == ''){
					if($ori == ''){
						$q ="insert into sop_update(user_id,sop_alias,sop_update_file,sop_update_tanggal) 
							values('".$userid."','".$alias."','".$file."',NOW())";
						
					}else{
						$q ="update sop_update set sop_update_file='".$file."' where sop_alias='".$alias."'";
					}
					$this->Sop_m->query_manual($q);
					
					echo '1';
				}else{
					echo $Error;
				}
		
			
	}
	
	function upload_berkassop()
	{
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				
				$alias='';
				if($this->Sop_m->cek_jml_sop() > 0){
					$query = $this->Sop_m->alias_sop1(); // random number
				}else{
					$query = $this->Sop_m->alias_sop2(); // random number
				}
				$alias = $query[0]['random_num'];
						
						
				$Error ='';
				$satker = $this->input->post('satker');
				$s =  $this->Sop_m->field_sop('satuan_organisasi','satuan_organisasi_nama','satuan_organisasi_id',$satker);
				$satkernm =  $s['satuan_organisasi_nama'];
				$unitkerja = $this->input->post('unitkerja');
				$u =  $this->Sop_m->field_sop('unit_kerja','unit_kerja_nama','unit_kerja_id',$unitkerja);
				$unitkerjanm =  $u['unit_kerja_nama'];
				$bagian = $this->input->post('bagian');
				$namasop = strtoupper($this->input->post('namasop'));
				
				// validasi
				if($satker == '') $Error .='Satuan Organisasi Harus Diisi<br>';
				if($unitkerja == '') $Error .='Unit Kerja Harus Diisi<br>';
				if($bagian == '') $Error .='Bagian Harus Diisi<br>';
				if($namasop == '') $Error .='Nama SOP Harus Diisi<br>';
				
				//upload
				$this->load->library('upload');
				$nmfile = 'sop_'.$alias.'_'.time();
				$config['upload_path'] = $this->config->item('pathupload_pdf');
				$config['allowed_types'] = 'pdf'; 
				$config['max_size'] = '50072'; 
				$config['max_width']  = '50000'; 
				$config['max_height']  = '50000'; 
				$config['file_name'] = $nmfile;
			
				$this->upload->initialize($config);
				if($_FILES['fileupload']['name'])
				{
					if ($this->upload->do_upload('fileupload')) {
						$gbr = $this->upload->data();
						$file = $gbr['file_name'];
					}else{
						$Error .='File Gagal di Upload';
					}
				}
				// upload
				
				
				if($Error == ''){						
						
						// nourut
						$nourut = $this->Sop_m->nourut($unitkerja) + 1;
						$sopno = $nourut.'/'.date('Y');
						$tglpembuatan = tgl_indo2(date('Y-m-d'));
						$tglefektif = tgl_indo2(date('Y-m-d'));
						
						$q = "Insert into sop(sop_nourut,sop_no,sop_nama_satker,sop_unit_kerja,sop_nama,sop_tgl_pembuatan,sop_tgl_efektif,
							 user_id,satuan_organisasi_id,satuan_organisasi_nama,unit_kerja_id,bagian_id,sop_status,sop_alias) 
							values('".$nourut."','".$sopno."','".$satkernm."','".$unitkerjanm."','".$namasop."','".$tglpembuatan."','".$tglefektif."',
							'".$userid."','".$satker."','".$satkernm."','".$unitkerja."','".$bagian."','DISAHKAN','".$alias."')";
						$this->Sop_m->query_manual($q);
							
						$q ="insert into berkas_sop(user_id,file,tanggal,sop_nama,sop_alias) 
							values('".$userid."','".$file."',NOW(),'".$namasop."','".$alias."')";
						$this->Sop_m->query_manual($q);
						
						$q ="insert into sop_update(user_id,sop_alias,sop_update_file,sop_update_tanggal) 
							values('".$userid."','".$alias."','".$file."',NOW())";
						$this->Sop_m->query_manual($q);
					
					
					
					echo '1';
				}else{
					echo $Error;
				}
		
			
	}
	
	function delete_berkassop()
	{
		$id = $this->uri->segment(3);
		$query = "select file,sop_alias from berkas_sop where id='$id'";
		$result = $this->Sop_m->query_manual($query);
		$file = '';
		$path= $this->config->item('pathupload_pdf');
		   if($result)
		   {
			 $sess_array = array();
			 foreach($result->result_array() as $row)
			 { 
				$file = $row['file'];
				
				if($file != ''){
					unlink($path.$file);
				}
				$this->db->query("delete from berkas_sop where id='$id'");
				$this->db->query("delete from sop_update where sop_alias='".$row['sop_alias']."'");
				$this->db->query("delete from sop where sop_alias='".$row['sop_alias']."'");
				
			 }
		   }
	}
	function kirim_sop()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error ='';
				$alias = $this->uri->segment(3);
				
				$q ="update sop set sop_step='admin' where sop_alias='".$alias."'";
				$this->Sop_m->query_manual($q);
				
				$q ="insert into reviu(user_id,sop_alias,reviu_status,reviu_tanggal) 
					values('".$userid."','".$alias."','pending',NOW())";
				$this->Sop_m->query_manual($q);
				$reviuid = $this->db->insert_id();
				
				$sop = $this->Sop_m->field_sop('sop','sop_nama','sop_alias',$alias);
				$sts = $this->Sop_m->field_sop('sop','sop_status','sop_alias',$alias);
				$rev = $this->Sop_m->revisi_alias($alias);
				$user = $this->Sop_m->edit_table('user','user_group_id',11);
				foreach($user->result_array() as $row){
					if($sts['sop_status'] == 'DRAFT'){
						$q ="insert into notif(notif_title,notif_desc,notif_type,notif_jenis,reviu_id,notif_date,notif_icon,user_id,notif_status,sop_alias) 
							values('Reviu SOP : ".$sop['sop_nama']."','SOP ".$sop['sop_nama']." perlu direviu','in','reviu','".$reviuid."',NOW(),'wb-order bg-green-600','".$row['user_id']."','D','".$alias."')";
					}else{
						$q ="insert into notif(notif_title,notif_desc,notif_type,notif_jenis,revisi_id,notif_date,notif_icon,user_id,notif_status,sop_alias) 
						values('Revisi SOP : ".$sop['sop_nama']."','".$rev['revisi_catatan']."','in','revisi','".$rev['revisi_id']."',NOW(),'wb-order bg-green-600','".$row['user_id']."','D','".$alias."')";
					}
					$this->Sop_m->query_manual($q);
				}
					
				redirect('sop/penyusunan_sop', 'refresh');
			
			
	}
	
	function delete_sop()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error ='';
				$alias = $this->uri->segment(3);
				
				$q ="delete from sop  where sop_alias='".$alias."'";
				$this->Sop_m->query_manual($q);
				
				$q ="delete from penyusun_sop  where sop_alias='".$alias."'";
				$this->Sop_m->query_manual($q);
				
				if($this->uri->segment(4) == 'pencarian'){
					redirect('sop/pencarian_sop', 'refresh');
				}else{
					redirect('sop/penyusunan_sop', 'refresh');
				}
				
		
			
	}
/* ====================================================================================================================================================== */



/* ====================================================================================================================================================== */
	function add_revisi()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				$unitkerjaid = $session_data['unitkerjaid'];
				$satkerid = $session_data['satkerid'];
				$satkernm = $session_data['satkernm'];
				$pegawaiid = $session_data['pegawaiid'];
				 
				$Error = '';
				$alias = $this->input->post('alias');
				$catatan = $this->input->post('catatan');
				
				// validasi
				if($catatan == '') $Error .='Catatan Revisi Harus Diisi<br>';
				
				
				if($Error == ''){
						
						// revisi
						if($this->Sop_m->cek_jml_sop() > 0){
							$query = $this->Sop_m->alias_sop1(); // random number
						}else{
							$query = $this->Sop_m->alias_sop2(); // random number
						}
						$aliasrevisi = $query[0]['random_num'];
						$q ="INSERT INTO sop_revisi(sop_id, sop_nourut, kategori_id, sop_nama_satker, sop_unit_kerja, sop_no, sop_tgl_pembuatan, sop_tgl_revisi, sop_tgl_efektif, sop_disahkan_jabatan, sop_disahkan_nama, sop_disahkan_nip, sop_nama, sop_dasar_hukum, sop_kualifikasi, sop_keterkaitan, sop_peralatan, sop_peringatan, sop_pencatatan, sop_kegiatan, sop_pelaksana1, sop_pelaksana2, sop_pelaksana3, sop_pelaksana4, sop_pelaksana5, sop_pelaksana6, sop_pelaksana7, sop_pelaksana8, sop_pelaksana9, sop_pelaksana10, sop_pelaksana11, sop_pelaksana12, sop_pelaksana13, sop_pelaksana14, sop_pelaksana15, sop_nm_pel1, sop_nm_pel2, sop_nm_pel3, sop_nm_pel4, sop_nm_pel5, sop_nm_pel6, sop_nm_pel7, sop_nm_pel8, sop_nm_pel9, sop_nm_pel10, sop_nm_pel11, sop_nm_pel12, sop_nm_pel13, sop_nm_pel14, sop_nm_pel15, sop_pelaksana_perbaris, sop_decision_perbaris, sop_jml_pelaksana, sop_kelengkapan, sop_waktu, sop_hasil, sop_keterangan, sop_konektor, user_id, satker_kode, satuan_organisasi_id, satuan_organisasi_nama, unit_kerja_id, bagian_id, sop_status, sop_step, sop_pengesah_nama, sop_pengesah_gambar, sop_pengesah_user, sop_alias, sop_revisi_alias)
							SELECT sop_id, sop_nourut, kategori_id, sop_nama_satker, sop_unit_kerja, sop_no, sop_tgl_pembuatan, sop_tgl_revisi, sop_tgl_efektif, sop_disahkan_jabatan, sop_disahkan_nama, sop_disahkan_nip, sop_nama, sop_dasar_hukum, sop_kualifikasi, sop_keterkaitan, sop_peralatan, sop_peringatan, sop_pencatatan, sop_kegiatan, sop_pelaksana1, sop_pelaksana2, sop_pelaksana3, sop_pelaksana4, sop_pelaksana5, sop_pelaksana6, sop_pelaksana7, sop_pelaksana8, sop_pelaksana9, sop_pelaksana10, sop_pelaksana11, sop_pelaksana12, sop_pelaksana13, sop_pelaksana14, sop_pelaksana15, sop_nm_pel1, sop_nm_pel2, sop_nm_pel3, sop_nm_pel4, sop_nm_pel5, sop_nm_pel6, sop_nm_pel7, sop_nm_pel8, sop_nm_pel9, sop_nm_pel10, sop_nm_pel11, sop_nm_pel12, sop_nm_pel13, sop_nm_pel14, sop_nm_pel15, sop_pelaksana_perbaris, sop_decision_perbaris, sop_jml_pelaksana, sop_kelengkapan, sop_waktu, sop_hasil, sop_keterangan, sop_konektor, user_id, satker_kode, satuan_organisasi_id, satuan_organisasi_nama, unit_kerja_id, bagian_id, sop_status, sop_step, sop_pengesah_nama, sop_pengesah_gambar, sop_pengesah_user, sop_alias,'".$aliasrevisi."' FROM sop WHERE sop_alias='".$alias."'";
						$this->Sop_m->query_manual($q);
						
						$q ="Insert into revisi (user_id,sop_alias,sop_revisi_alias,revisi_catatan,revisi_status,revisi_tanggal) 
						values('".$userid."','".$alias."','".$aliasrevisi."','".$catatan."','pending',NOW())";
						$this->Sop_m->query_manual($q);
						
						
						//update sop
						$q ="update sop set sop_step='', sop_status='DRAFT REVISI', sop_pengesah_gambar='', sop_pengesah_nama='' where sop_alias='".$alias."'";
						$this->Sop_m->query_manual($q);
						
						//$revisiid = $this->db->insert_id();
						//
						//$sop = $this->Sop_m->field_sop('sop','sop_nama','sop_alias',$alias);
						//$user = $this->Sop_m->edit_table('user','user_group_id',11);
						//foreach($user->result_array() as $row){
						//	$q ="insert into notif(notif_title,notif_desc,notif_type,notif_jenis,revisi_id,notif_date,notif_icon,user_id,notif_status,sop_alias) 
						//		values('Revisi SOP : ".$sop['sop_nama']."','".$catatan."','in','revisi','".$revisiid."',NOW(),'wb-order bg-green-600','".$row['user_id']."','D','".$alias."')";
						//	$this->Sop_m->query_manual($q);
						//}		
					
					echo '1';
				}else{
					
					echo $Error;
					
				}
				
			
	}
	
	function tindakan_revisi()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				$unitkerjaid = $session_data['unitkerjaid'];
				$satkerid = $session_data['satkerid'];
				$satkernm = $session_data['satkernm'];
				$pegawaiid = $session_data['pegawaiid'];
				 
				$Error = '';
				$alias = $this->input->post('alias');
				$id = $this->input->post('id');
				$tindakan = $this->input->post('tindakan');
				$catatan = $this->input->post('catatan');
				
				// validasi
				if($catatan == '') $Error .='Catatan Harus Diisi<br>';
				
				
				if($Error == ''){
					
						$q ="update revisi set revisi_catatan_admin='".$catatan."', revisi_status='".$tindakan."', revisi_tanggal_tindakan=NOW(), revisi_selesai='selesai' where revisi_id='".$id."'";
						$this->Sop_m->query_manual($q);
						
						$q ="update notif set notif_action='sudah' where revisi_id='".$id."'";
						$this->Sop_m->query_manual($q);
						
						
						$q ="update sop set sop_step='pengesah' where sop_alias='".$alias."'";
						$this->Sop_m->query_manual($q);
			
						$sop = $this->Sop_m->field_sop('sop','sop_nama','sop_alias',$alias);
						$sopuser = $this->Sop_m->field_sop('sop','user_id','sop_alias',$alias);
						$so = $this->Sop_m->field_sop('sop','satuan_organisasi_id','sop_alias',$alias);
						$uk = $this->Sop_m->field_sop('sop','unit_kerja_id','sop_alias',$alias);
						$soppengesah = $this->Sop_m->get_jabatan($so['satuan_organisasi_id'],$uk['unit_kerja_id']);
						$user = $this->Sop_m->edit_table('user','user_id',$sopuser['user_id']);
						// notif ke user
						$q ="insert into notif(notif_title,notif_desc,notif_type,notif_jenis,revisi_id,notif_date,notif_icon,user_id,notif_status,notif_action,sop_alias) 
							values('Revisi SOP : ".$sop['sop_nama']."','SOP ".$sop['sop_nama']." sudah di kirim ke pengesah','in','revisi','".$id."',NOW(),'wb-chat bg-green-600','".$sopuser['user_id']."','D','sudah','".$alias."')";
						$this->Sop_m->query_manual($q);
						
						
						// notif ke pengesah
						$q ="insert into notif(notif_title,notif_desc,notif_type,notif_jenis,revisi_id,notif_date,notif_icon,user_id,notif_status,notif_action,sop_alias) 
							values('Perlu disahkan SOP : ".$sop['sop_nama']."','SOP ".$sop['sop_nama']." perlu disahkan','in','revisi','".$id."',NOW(),'wb-chat bg-green-600','".$soppengesah['user_id']."','D','sudah','".$alias."')";
						$this->Sop_m->query_manual($q);
					
					echo '1';
				}else{
					
					echo $Error;
					
				}
				
				
			
	}


/* ====================================================================================================================================================== */


/* ====================================================================================================================================================== */
	function add_disahkan()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error ='';
				$disahkan = $this->input->post('disahkan');
				$no_alias = $this->input->post('no_alias');
				$nama = $this->input->post('nama');
				$jabatan = $this->input->post('jabatan');
				$nip = $this->input->post('nip');
				$gambar = $this->input->post('gambar');
				
				// validasi
				if($disahkan == '') $Error .='Checklis Pengesah<br>';
				if($nama == '') $Error .='Nama Pengesah Belum Terpilih<br>';
				
				
				if($Error == ''){
						$q ="UPDATE sop SET sop_status='".$disahkan."', sop_tgl_efektif='".tgl_indo(date('d-m-Y'))."', sop_pengesah_user='".$userid."', sop_pengesah_nama='".$nama."', sop_pengesah_gambar='".$gambar."', sop_disahkan_jabatan='".$jabatan."', sop_disahkan_nama='".$nama."', sop_disahkan_nip='".$nip."' where sop_alias='".$no_alias."'";
						$this->Sop_m->query_manual($q);
					
					echo '1';
				}else{
					
					echo $Error;
					
				}
				
			
	}


/* ====================================================================================================================================================== */


/* ====================================================================================================================================================== */
	function add_dinomorkan()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error ='';
				$no_urut = $this->input->post('no_urut');
				$no_sop = $no_urut.$this->input->post('no_sop');
				$alias = $this->input->post('no_alias');
				
				// validasi
				if($no_sop == '') {
						$Error .='Nomor SOP Harus Diisi';
				}else{
						$count = $this->Sop_m->cek_null('sop','sop_no',$no_sop);
						if($count >= 1) $Error .='Nomor SOP Double';
				}
				
				if($Error == ''){
						$q ="UPDATE sop SET sop_no='".$no_sop."' where sop_alias='".$alias."'";
						$this->Sop_m->query_manual($q);
					
					echo '1';
				}else{
					
					echo $Error;
					
				}
				
			
	}


/* ====================================================================================================================================================== */


/* ====================================================================================================================================================== */
	function add_cover()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				$satkerkode = $session_data['satkerkode'];
		
				$Error ='';
				$tmp_img = $this->input->post('tmp_img');
				$tmp_background = $this->input->post('tmp_img2');
				$satker1 = $this->input->post('satker1');
				$alamat = $this->input->post('alamat');
				$warna = $this->input->post('warna');
				
				// validasi
				
				if($Error == ''){
						$q ="insert into cover(cover_logo,cover_nama_satker,cover_alamat,cover_tahun,cover_warna,cover_background,satker_kode) 
							values('".$tmp_img."','".$satker1."','".$alamat."','".date('Y')."','".$warna."','".$tmp_background."','".$satkerkode."')";
						$this->Sop_m->query_manual($q);
					
					echo '1';
				}else{
					
					echo $Error;
					
				}
				
			
	}

	function edit_cover()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				$satkerkode = $session_data['satkerkode'];
		
				$Error ='';
				$id = $this->input->post('id');
				$tmp_img = $this->input->post('tmp_img');
				$tmp_background = $this->input->post('tmp_img2');
				$satker1 = $this->input->post('satker1');
				$satker2 = $this->input->post('satker2');
				$alamat = $this->input->post('alamat');
				$warna = $this->input->post('warna');
				// validasi
				
				if($Error == ''){
						$q ="UPDATE cover SET cover_logo='".$tmp_img."', cover_nama_satker='".$satker1."', cover_nama_satker2='".$satker2."', cover_warna='".$warna."', cover_background='".$tmp_background."', cover_alamat='".$alamat."' where cover_id='".$id."'";
						$this->Sop_m->query_manual($q);
					
					echo '1';
				}else{
					
					echo $Error;
					
				}
				
				
			
	}


/* ====================================================================================================================================================== */



/* ====================================================================================================================================================== */
	function add_penetapan()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				$satkerkode = $session_data['satkerkode'];
		
				$Error ='';
				$jabatan = $this->input->post('jabatan');
				$nama_pejabat = $this->input->post('nama_pejabat');
				$no_sk = $this->input->post('no_sk');
				$alias_sop = $this->input->post('alias_sop');
				$no_sop = $this->input->post('no_sop');
				
				// validasi
				if($no_sk == '') {
						$Error .='No SK Harus diisi<br>';
				}else{
						$count = $this->Sop_m->cek_null('penetapan','penetapan_no',$no_sk);
						if($count >= 1) $Error .='No SK Double';
				}
				if($_FILES['fileupload']['tmp_name'] != ''){
							$ext = pathinfo($_FILES['fileupload']['name'], PATHINFO_EXTENSION);
							$size = $_FILES['fileupload']['size'];
							if(strtolower($ext) != 'pdf'){
								$Error .= 'File Harus .pdf<br>';
							}
							if($size > 5000000){
								$Error .= 'File Harus Kurang 5Mb<br>';
							}
				}else{
					$Error .= 'File Keputusan Harus Diisi<br>';
				}
				if($jabatan == '') $Error .='Jabatan Harus diisi<br>';
				if($nama_pejabat == '') $Error .='Nama Pejabat Harus diisi<br>';
				
				if($Error == ''){
						// upload
						$file = '';
						if($_FILES['fileupload']['tmp_name'] != ''){
								$ext = pathinfo($_FILES['fileupload']['name'], PATHINFO_EXTENSION);
								
								if(strtolower($ext) == 'pdf'){
									$path = "assets/media/surat_keputusan/";
									
									$ori_src = $path.strtolower( str_replace(' ','_',$_FILES['fileupload']['name']));
									if(move_uploaded_file ($_FILES['fileupload']['tmp_name'],$ori_src))
									{
										chmod("$ori_src",0777);
									}
									//else{
									//	echo "Gagal melakukan proses upload file.";
									//	exit;
									//}
									
									$file = strtolower( str_replace(' ','_',$_FILES['fileupload']['name']) );
									
								}
						}
						
						
						$q ="insert into penetapan(penetapan_no,penetapan_file,penetapan_jabatan,penetapan_nama_pejabat,penetapan_tanggal,satker_kode,penetapan_status_reviu) 
							values('".$no_sk."','".$file."','".$jabatan."','".$nama_pejabat."','".tgl_indo(date('d-m-Y'))."','".$satkerkode."','Belum')";
						$this->Sop_m->query_manual($q);
						$id = $this->db->insert_id();
						
						for($i=0;$i<count($alias_sop);$i++){
							$q ="insert into penetapan_detail(penetapan_id,no_sop,sop_alias) 
								values('".$id."','".$no_sop[$i]."','".$alias_sop[$i]."')";
							$this->Sop_m->query_manual($q);
						}
					
					echo '1';
				}else{
					
					echo $Error;
					
				}
				
				
	}


/* ====================================================================================================================================================== */



/* ====================================================================================================================================================== */
	function add_penjelasan()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				$satkerkode = $session_data['satkerkode'];
		
				$Error ='';
				$penjelasan = $this->input->post('penjelasan');
				
				// validasi
				if($penjelasan == '') $Error .='Penjelasan Harus diisi';
				
				
				if($Error == ''){
						$q ="insert into penjelasan_singkat(penjelasan_singkat_isi,satker_kode) 
							values('".$penjelasan."','".$satkerkode."')";
						$this->Sop_m->query_manual($q);
					
					echo '1';
				}else{
					
					echo $Error;
					
				}
				
				
			
	}
	
	function edit_penjelasan()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
				$satkerkode = $session_data['satkerkode'];
		
				$Error ='';
				$id = $this->input->post('id');
				$penjelasan = $this->input->post('penjelasan');
				
				// validasi
				if($penjelasan == '') $Error .='Penjelasan Harus diisi';
				
				if($Error == ''){
						$q ="update penjelasan_singkat set penjelasan_singkat_isi='".$penjelasan."' where satker_kode='".$satkerkode."' and penjelasan_singkat_id='".$id."'";
						$this->Sop_m->query_manual($q);
					
					echo '1';
				}else{
					
					echo $Error;
					
				}
				
				
			
	}


/* ====================================================================================================================================================== */


/* ====================================================================================================================================================== */
	
	
	function review_semua_sop()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error ='';
				$id = $this->uri->segment(3);
				$nosk = $this->uri->segment(4);
				$judul = 'Pemberitahuan Reviu Sop dengan No SK '.$nosk.'';
				$isi = 'Kepada Penyusun SOP agar segera di lakukan reviu SOP';
				// validasi
				
				if($Error == ''){
						$q ="UPDATE penetapan SET penetapan_status_reviu='Sudah' where penetapan_id='".$id."'";
						$this->Sop_m->query_manual($q);
						
						// kirim notif
						$q ="SELECT * FROM user where satker_kode='".$session_data['satkerkode']."' and user_group_id!=6";
						$res = $this->Sop_m->query_manual($q);
						foreach($res->result_array() as $row){
							$q ="INSERT INTO pemberitahuan(user_id,satker_kode,pemberitahuan_judul,pemberitahuan_isi,pemberitahuan_status,created_on,created_by) 
							value('".$row['user_id']."','".$row['satker_kode']."','".$judul."','".$isi."','D',NOW(),'".$username."')";
							$this->Sop_m->query_manual($q);
						}
						
						// tmp list reviu sop
						$q ="SELECT * FROM penetapan_detail where penetapan_id='".$id."'";
						$res = $this->Sop_m->query_manual($q);
						foreach($res->result_array() as $row){
							$q ="INSERT INTO tmp_reviu_sop(sop_no,sop_alias) 
							value('".$row['no_sop']."','".$row['sop_alias']."')";
							$this->Sop_m->query_manual($q);
						}
						
						redirect('sop/review_sop', 'refresh');
				}else{
					
					echo $Error;
					
				}
				
	}


/* ====================================================================================================================================================== */


/* ====================================================================================================================================================== */
	
	
	function tidak_revisi()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error ='';
				$alias = $this->uri->segment(3);
				
				$q ="delete from tmp_reviu_sop where sop_alias='".$alias."'";
				$this->Sop_m->query_manual($q);
					
				redirect('sop/revisi_sop', 'refresh');				
		
			
	}


/* ====================================================================================================================================================== */



/* ====================================================================================================================================================== */
	
	
	function add_evaluasi()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error ='';
				$daftar = $this->input->post('daftarsop');
				$status = $this->input->post('status');
				
				// validasi
				if($daftar[0] == '')$Error .='Pilih SOP';
				
				if($Error == ''){
					$q ="INSERT INTO evaluasi(evaluasi_status) 
					value('".$status."')";
					$this->Sop_m->query_manual($q);
					$sopid = $this->db->insert_id();
					
					for($i=0;$i<count($daftar);$i++){
						$q ="INSERT INTO evaluasi_detail(evaluasi_id,sop_alias) 
						value('".$sopid."','".$daftar[$i]."')";
						$this->Sop_m->query_manual($q);
					}
					
					echo '1';
				}else{
					
					echo $Error;
					
				}
				
			
	}
	function delete_evaluasi()
	{
		$id = $this->uri->segment(3);
		$this->db->query("delete from evaluasi_detail where sop_alias='$id'");
		
		redirect('sop/evaluasi_sop');
	}
	
	function add_jawaban()
	{
		$Error ='';
		$alias = $this->input->post('alias');
		$jawaban = $this->input->post('jawaban');
		$ip      = $_SERVER['REMOTE_ADDR'];
		
		// validasi
		if($jawaban == '')$Error .='Pilih Jawaban';
		
		if($Error == ''){
			$q ="INSERT INTO jawaban(sop_alias,jawaban_ip,jawaban_tanggal,jawaban_pilihan) 
			value('".$alias."','".$ip."',NOW(),'".$jawaban."')";
			$this->Sop_m->query_manual($q);
			
			echo '1';
		}else{
			
			echo $Error;
			
		}	
	}


/* ====================================================================================================================================================== */

}