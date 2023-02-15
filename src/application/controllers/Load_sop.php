<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('date.timezone', 'Asia/Jakarta');

class Load_sop extends CI_Controller {

	public function __construct() {
		parent::__construct(); 
		$this->load->helper(array('form','url', 'text_helper','date','tgl_indonesia'));
		$this->load->model(array('Sop_m'));	
		$this->load->library(array('combotree'));
		$this->load->library(array('session'));
		//cek_aktif();	
	}
	
	
	
/* ====================================================================================================================================================== */
	function add_header()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error = '';
				$data = '';
				$id = $this->input->post('id');
				$kategori = strtoupper($this->input->post('kategori'));
				$nm_satker = strtoupper($this->input->post('nm_satker'));
				$status = $this->input->post('status');
				$nm_unitkerja = $this->input->post('nm_unitkerja');
				$no_sop = $this->input->post('no_sop');
				$sop_nourut = $this->input->post('sop_nourut');
				$tgl_sop = $this->input->post('tgl_sop');
				$tgl_revisi = $this->input->post('tgl_revisi');
				$jabatan = $this->input->post('jabatan');
				$nama_pejabat = $this->input->post('nama_pejabat');
				$nip_pejabat = $this->input->post('nip_pejabat');
				$nama_sop = strtoupper($this->input->post('nama_sop'));
				$dasar_hukum = $this->input->post('dasar_hukum');
				$kualifikasi_pelaksana = $this->input->post('kualifikasi_pelaksana');
				$keterkaitan = $this->input->post('keterkaitan');
				$peralatan = $this->input->post('peralatan');
				$peringatan = $this->input->post('peringatan');
				$pencatatan = $this->input->post('pencatatan');
				$headerok = $this->input->post('headerok');
				
				
				
				// validasi null
				if($tgl_sop == '') $Error .='Tanggal SOP Harus Di Isi<br>';
				if($nama_sop == '') $Error .='Nama SOP Harus Di Isi<br>';
				if($jabatan == '') $Error .='Pilih Pengesah<br>';
				if($tgl_sop != '') $tgl_sop = tgl_indo($tgl_sop);
				if($tgl_revisi != ''){$tgl_revisi = tgl_indo($tgl_revisi);}else{$tgl_revisi = '-';};
				
				$data .= '<input type="hidden" name="id" value="'.$id.'">';
				$data .= '<input type="hidden" name="sop_nourut" value="'.$sop_nourut.'">';
				$data .= '<input type="hidden" name="status" value="'.$status.'">';
				$res = $this->Sop_m->kat_sop();
				//$data .= '<table cellpadding="2" cellspacing="0"  align="center" style="width:32cm;">
				//			<tr>
				//				<td width="100"><b>Jenis SOP : <b></td>
				//				<td>
				//					<select name="kat_sop">
				//						<option value="">Pilih Kategori SOP</option>';
				//						foreach($res->result_array() as $rows) {
				//							$tab = ($rows['kategori_level'] == 2 ? '&nbsp;&nbsp;&nbsp;' : '');
				//							$data .= '<option value="'.$rows['kategori_id'].'"'; if($rows['kategori_id'] == $kategori){$data .= ' selected';} $data .= '>'.$tab.$rows['kategori_nama'].'</option>';
				//						}
				//				$data .= '
				//					</select>
				//				</td>
				//			</tr>
				//		</table><br>';
						
				$data .= '<table cellpadding="3" cellspacing="0" class="TableDetail" align="center" border="1" style="width:32cm; font-size:9px; font-family:arial; color:#000">
							<tr valign="top">
								<td rowspan="6" width="50%" align="center"><br>';
									$data .= '<img src="'.base_url().'assets/media/logo/sekneg.png" width="60" height="60">
									<br><br>
									<div style="text-transform: uppercase; font-weight:bold">KEMENTERIAN SEKRETARIAT NEGARA<BR>REPUBLIK INDONESIA</div><br>
									<input type="hidden" name="headerok" value="'.$headerok.'">
									<input type="hidden" name="nm_satker" value="'.$nm_satker.'"><b>'.$nm_satker.'</b><br>
									<input type="hidden" name="nm_unitkerja" value="'.$nm_unitkerja.'"><b style="text-transform: uppercase;">'.$nm_unitkerja.'</b>
								</td>
								<td colspan="2">
									<div style="float:left; width:114px;"><b>NOMOR SOP</b></div>
									<div style="float:left; width:10px">:</div>
									<div style="float:left; width:450px;"><input type="hidden" name="no_sop" value="'.$no_sop.'">'.$no_sop.'</div>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div style="float:left; width:114px;"><b>TGL. PEMBUATAN</b></div>
									<div style="float:left; width:10px">:</div>
									<div style="float:left; width:450px;"><input type="hidden" name="tgl_sop" value="'.$tgl_sop.'">'.$tgl_sop.'</div>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div style="float:left; width:114px;"><b>TGL. REVISI</b></div>
									<div style="float:left; width:10px">:</div>
									<div style="float:left; width:450px;"><input type="hidden" name="tgl_revisi" value="'.$tgl_revisi.'">'.$tgl_revisi.'</div>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div style="float:left; width:114px;"><b>TGL. EFEKTIF</b></div>
									<div style="float:left; width:10px">:</div>
									<div style="float:left; width:450px;"><input type="hidden" name="tgl_efektif" value=""></div>
								</td>
							</tr>
							<tr valign="top">
								<td colspan="2">
									<div style="float:left; width:114px;"><b>DISAHKAN OLEH</b></div>
									<div style="float:left; width:10px">:</div>
									<div style="float:left; width:450px;">
										<input type="hidden" name="jabatan" value="'.$jabatan.'">'.$jabatan.'<br><br><br><br>
										<input type="hidden" name="nama_pejabat" value="'.$nama_pejabat.'">'.$nama_pejabat.' &nbsp;
										<input type="hidden" name="nip_pejabat" value="'.$nip_pejabat.'">NIP '.$nip_pejabat.'
									</div>
								</td>
							</tr>
							<tr valign="top">
								<td colspan="2">
									<div style="float:left; width:114px;"><b>NAMA SOP</b></div>
									<div style="float:left; width:10px;">:</div>
									<div style="float:left; width:450px;"><input type="hidden" name="nama_sop" value="'.$nama_sop.'">'.$nama_sop.'</div>
								</td>
							</tr>
							<tr>
								<td><b>DASAR HUKUM:</b></td>
								<td colspan="2"><b>KUALIFIKASI PELAKSANA:</b></td>
							</tr>
							<tr valign="top">
								<td><div style="height:140px; overflow:hidden"><input type="hidden" name="dasar_hukum" value="'.$dasar_hukum.'">'.nl2br($dasar_hukum).'</div></td>
								<td colspan="2"><div style="height:140px; overflow:hidden"><input type="hidden" name="kualifikasi_pelaksana" value="'.$kualifikasi_pelaksana.'">'.nl2br($kualifikasi_pelaksana).'</div></td>
							</tr>
							<tr>
								<td><b>KETERKAITAN:</b></td>
								<td colspan="2"><b>PERALATAN/PERLENGKAPAN:</b></td>
							</tr>
							<tr valign="top">
								<td><div style="height:70px; overflow:hidden"><input type="hidden" name="keterkaitan" value="'.$keterkaitan.'">'.nl2br($keterkaitan).'</div></td>
								<td colspan="2"><div style="height:70px; overflow:hidden"><input type="hidden" name="peralatan" value="'.$peralatan.'">'.nl2br($peralatan).'</div></td>
							</tr>
							<tr>
								<td><b>PERINGATAN:</b></td>
								<td colspan="2"><b>PENCATATAN DAN PENDATAAN:</b></td>
							</tr>
							<tr valign="top">
								<td><div style="height:45px; overflow:hidden"><input type="hidden" name="peringatan" value="'.$peringatan.'">'.nl2br($peringatan).'</div></td>
								<td colspan="2"><div style="height:45px; overflow:hidden"><input type="hidden" name="pencatatan" value="'.$pencatatan.'">'.$pencatatan.'</div></td>
							</tr>
						</table>';
						
					
				if($Error == ''){
					echo die($data);
				}else{
					echo die($Error);
				}	
			
	}
/* ====================================================================================================================================================== */
	
/* ====================================================================================================================================================== */
	function add_kegiatan()
	{
		
				$session_data = $this->session->userdata;
				$userid = $session_data['userid'];		
				$username = $session_data['username'];
		
				$Error = '';
				$data = '';
				$pelaksana = $this->input->post('pelaksana');
				$kegiatan = $this->input->post('kegiatan');
				$kelengkapan = $this->input->post('kelengkapan');
				$waktu = $this->input->post('waktu');
				$hasil = $this->input->post('hasil');
				$keterangan = $this->input->post('keterangan');
				$jmlkegiatan = count($kegiatan) - 1;
				$pelaksana_perbaris = $this->input->post('a');
				$decision_perbaris = $this->input->post('d');
				
				$jmlpel = 0;
				for($p=0;$p<count($pelaksana);$p++){
					if($pelaksana[$p] != ''){
						$jmlpel++;
					}
				}
				// batas 10
				$jmlpel = ($jmlpel <= 10 ? $jmlpel : 10);
				
				// validasi null
				if(count($kegiatan) < 3)$Error .= 'Kegiatan harus lebih dari 3<br>';
				if($pelaksana[0] == '')$Error .= 'Pelaksana belum diisi<br>';
				$z=0;
				$no=0;
				for($i=0;$i<count($kegiatan);$i++){
				$no++;
					$z = $i-1;
					if($pelaksana_perbaris[$i] == ''){
						$Error .= 'Error di keagiatan '.$no.' : checklist simbol yang akan digunakan<br>';
					}
					if((count(explode(',',$pelaksana_perbaris[$i])) > 1) and ($decision_perbaris[$i] != '')){
						$Error .= 'Error di keagiatan '.$no.' : tidak diperbolehkan menggunakan simbol decision dan proses dalam 1 baris<br>';
					}
					if($kegiatan[$i] == '')$Error .= 'Error di keagiatan '.$no.' : Kegiatan belum diisi<br>';
				}
				
				
				
				
				$data .= '<style>.TableKeg{line-height:11px} .TableKeg th{text-align:center}</style>
							
							<table cellpadding="2" cellspacing="0"  border="1" align="center" class="TableKeg" style="margin-top:20px; width:32cm; font-size:9px; font-family:arial; color:#000">
								<tr bgcolor="#ddd" align="center">
									<th rowspan="2" width="20">No.</th>
									<th rowspan="2">Kegiatan</th>
									<th colspan="'.$jmlpel.'">Pelaksana</th>';
									if(count($pelaksana) > 10){
										for($p=10;$p<count($pelaksana);$p++){
											if($pelaksana[$p] != ''){
												$data .= '<th rowspan="2" style="width:35px; height:35px;">
													<div style="width:35px; height:35px; word-wrap: break-word; overflow:hidden">
														<input type="hidden" name="pelaksana['.$p.']" value="'.$pelaksana[$p].'">'.$pelaksana[$p].'
													</div></th>';
											}
										}
									}
									$data .= '<th colspan="3">Mutu Baku</th>
									<th rowspan="2" width="100">Keterangan</th>
								</tr>
								<tr bgcolor="#ddd" align="center">';
									for($p=0;$p<$jmlpel;$p++){
										if($pelaksana[$p] != ''){
											$data .= '<th style="width:35px; height:35px;">
													<div style="width:35px; height:35px; word-wrap: break-word; overflow:hidden">
														<input type="hidden" name="pelaksana['.$p.']" value="'.$pelaksana[$p].'">'.$pelaksana[$p].'
													</div>
													</th>';
										}
									}
									$data .= '<th width="70">Kelengkapan</th>
									<th width="50">Waktu</th>
									<th width="70">Output</th>
								</tr>';
								$no=0;
								$konektor=1;
								$konektor_nim=0;
								for($i=0;$i<count($kegiatan);$i++){
												
									$no++;
									$data .= '<tr>
										<td>'.$no.'</td>
										<td height="135">
											<div style="height:135px; overflow:hidden;">
											<div style="height:135px; word-wrap: break-word; align-self: center; display: table-cell; vertical-align: middle">
												<input type="hidden" name="kegiatan[]" value="'.$kegiatan[$i].'">
												'.nl2br($kegiatan[$i]).'
												<input type="hidden" name="pelaksana_perbaris[]" value="'.$pelaksana_perbaris[$i].'">
												<input type="hidden" name="decision_perbaris[]" value="'.$decision_perbaris[$i].'">
											</div>
											</div>
										</td>';
										
											// pelaksana
											$q=0;
											$z=0;
											$pel='';
											$disnama = '';
											for($p=0;$p<count($pelaksana);$p++){
												
												
												
												
												if($pelaksana[$p] != ''){
													$z = $i-1;
													$q++;
													$data .= '<td align="center">';
													$data .= '<input type="hidden" name="check_pelaksana'.$q.'_'.$i.'" value="'.$this->input->post('check_pelaksana'.$q.'_'.$i.'').'">';
													
													
													
													
													if(substr($this->input->post('check_pelaksana'.$q.'_'.$i.''), -1) == 'Y'){
														if($i==0){
															if($q != 1){
																$Error .= 'Error di keagiatan '.$no.' : awal kegiatan dimulai dari pelaksana 1<br>';
															}else{
																$data .= '<img src="'.base_url().'assets/media/simbol/awal-akhir.png">';
															}
														}else if($i == $jmlkegiatan){
															$data .= '<img src="'.base_url().'assets/media/simbol/awal-akhir.png">';
														}else{                                                              
															if(substr($this->input->post('deci'.$q.'_'.$i.''), -1) == 'Y'){
																$data .= '<img src="'.base_url().'assets/media/simbol/decision.png">';
															}else{
																$data .= '<img src="'.base_url().'assets/media/simbol/proses.png">';
															}
														}
														
														error_reporting(0);
														
														if($i == $konektor_min){
														$query = $this->Sop_m->img_simbol('k-atas-'.$pelaksana_perbaris[$i].'-'.$pelaksana_perbaris[$no].'');
															$data .= '<img src="'.base_url().'assets/media/simbol/'; if($query){$data .= ''.$query[0]['simbol_img'].'';} $data .= '" style="position:absolute; '; if($query){$data .= ''.$query[0]['simbol_margin'].'';} $data .= '">'; 
															
														}

														if($i == $konektor){
															$data .= '<img src="'.base_url().'assets/media/simbol/penghubung-bawah.png" style="position:absolute; margin-top:-35px; margin-left:-26px">'; 
														}else{
															if($i > 0){ // jika ada kegiatan
																if(substr($this->input->post('deci'.$q.'_'.$i.''), -1) == 'Y'){ // jika ada decision
																	if(substr($decision_perbaris[$z], -1) == 'Y'){ // jika sebelumnya ada decision
																		$query = $this->Sop_m->img_simbol('d-y-'.$pelaksana_perbaris[$z].'-'.$q.'');
																		$data .= '<img src="'.base_url().'assets/media/simbol/'; if($query){$data .= $query[0]['simbol_img'];} $data .= '" style="position:absolute; '; if($query){$data .= $query[0]['simbol_margin'];} $data .= '">';
																	}else{
																		$query1 = $this->Sop_m->img_simbol(''.$pelaksana_perbaris[$z].'-'.$q.'');
																		$data .= '<img src="'.base_url().'assets/media/simbol/'; if($query1){$data .= $query1[0]['simbol_img'];} $data .= '" style="position:absolute; '; if($query1){$data .= $query1[0]['simbol_margin'];} $data .= '">'; 
																	}
																	$query = $this->Sop_m->img_simbol('d-t-'.$pelaksana_perbaris[$z].'-'.$q.'');
																	$data .= '<img src="'.base_url().'assets/media/simbol/'; if($query){$data .= $query[0]['simbol_img'];} $data .= '" style="position:absolute; '; if($query){$data .= $query[0]['simbol_margin'];} $data .= '">';
																	
																}else{
																	if(substr($decision_perbaris[$z], -1) == 'Y'){
																		$query = $this->Sop_m->img_simbol('d-y-'.$pelaksana_perbaris[$z].'-'.$q.'');
																		$data .= '<img src="'.base_url().'assets/media/simbol/'; if($query){$data .= $query[0]['simbol_img'];} $data .= '" style="position:absolute; '; if($query){$data .= $query[0]['simbol_margin'];} $data .= '">';
																	}else{
																		if(count(explode(',',$pelaksana_perbaris[$i])) > 1){
																			if($disnama != $pelaksana_perbaris[$z].'-'.$pelaksana_perbaris[$i]){
																				$disnama = $pelaksana_perbaris[$z].'-'.$pelaksana_perbaris[$i];
																				$query = $this->Sop_m->img_simbol(''.$pelaksana_perbaris[$z].'-'.$pelaksana_perbaris[$i].'');
																				$data .= '<img src="'.base_url().'assets/media/simbol/'; if($query){$data .= $query[0]['simbol_img'];} $data .= '" style="position:absolute; '; if($query){$data .= $query[0]['simbol_margin'];} $data .= '">'; // untuk 1-2 margin-left:-96px untuk 1-3 margin-left:-151px
																			}
																		}else{
																			$query = $this->Sop_m->img_simbol(''.$pelaksana_perbaris[$z].'-'.$q.'');
																			$data .= '<img src="'.base_url().'assets/media/simbol/'; if($query){$data .= $query[0]['simbol_img'];} $data .= '" style="position:absolute; '; if($query){$data .= $query[0]['simbol_margin'];} $data .= '">';
																		}
																	}
																}
															}
														}
														
													}
													
													$data .= '</td>';
												}
											}
										$data .= '
										<td>
											<div style="height:135px; overflow:hidden;">
											<div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle">
												<input type="hidden" name="tr[]" value=""><input type="hidden" name="kelengkapan[]" value="'.$kelengkapan[$i].'">'.nl2br($kelengkapan[$i]).'
											</div>
											</div>
										</td>
										<td>
											<div style="height:135px; overflow:hidden;">
											<div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle">
												<input type="hidden" name="waktu[]" value="'.$waktu[$i].'">'.$waktu[$i].'
											</div>
											</div>
										</td>
										<td>
											<div style="height:135px; overflow:hidden;">
											<div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle">
												<input type="hidden" name="hasil[]" value="'.$hasil[$i].'">'.nl2br($hasil[$i]).'
											</div>
											</div>
										</td>
										<td>
											<div style="height:135px; overflow:hidden;">
											<div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle">
												<input type="hidden" name="keterangan[]" value="'.$keterangan[$i].'">'.nl2br($keterangan[$i]).'
											</div>
											</div>
										</td>
									</tr>';
														
									//konektor
									if($i == $konektor){ $konektor = $konektor+5; $konektor_min = $konektor_min+5;}
								}
				$data .= '</table>';
				$data .= '<table width="100%"><tr><td>
								<!--<button type="reset" class="easyui-linkbutton" data-options="iconCls:\'icon-save\'" style="float:left; margin:5px 0 20px 0; width:120px; height:40px">Hapus</button>-->
								<button type="submit" class="ConfSave easyui-linkbutton" data-options="iconCls:\'icon-save\'" style="float:right; margin:5px 0 20px 0; width:120px; height:40px">Simpan</button>
								</td></tr>
						   </table>';
				
				$data .= '<div style="clear:both"></div>';		
				$data .= '<script type="text/javascript">
							var elems = document.getElementsByClassName(\'ConfSave\');
							var confirmIt = function (e) {
								if (!confirm(\'Yakin Akan Disimpan ?\')) e.preventDefault();
							};
							for (var i = 0, l = elems.length; i < l; i++) {
								elems[i].addEventListener(\'click\', confirmIt, false);
							}
						</script>';		
				
				if($Error == ''){
					echo die($data);
				}else{
					echo $Error;
				}	
			
	}
/* ====================================================================================================================================================== */
	
}