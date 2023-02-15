<?php if($this->uri->segment(3) != ''){
	$Arr = array();
	$t = 0;
	foreach($sop->result_array() as $row){
		$kategori = $row['kategori_nama'];
		$nm_satker = strtoupper($row['sop_nama_satker']);
		$nm_unitkerja =$row['sop_unit_kerja'];
		$no_sop =$row['sop_no'];
		$tgl_sop = $row['sop_tgl_pembuatan'];
		$tgl_revisi = $row['sop_tgl_revisi'];
		$tgl_efektif = $row['sop_tgl_efektif'];
		$disahkan_jabatan = $row['sop_disahkan_jabatan'];
		$gambar = $row['sop_pengesah_gambar'];
		$disahkan_nama = $row['sop_disahkan_nama'];
		$disahkan_nip = $row['sop_disahkan_nip'];
		$userpengesah = $row['sop_pengesah_user'];
		$nama_sop = $row['sop_nama'];
		$dasar_hukum = $row['sop_dasar_hukum'];
		$kualifikasi_pelaksana = $row['sop_kualifikasi'];
		$keterkaitan = $row['sop_keterkaitan'];
		$peralatan = $row['sop_peralatan'];
		$peringatan = $row['sop_peringatan'];
		$pencatatan = $row['sop_pencatatan'];
		$jmlpelaksana = $row['sop_jml_pelaksana'];
		$alias = $row['sop_alias'];
		
		$Arr['konektor'][$t] = $row['sop_konektor'];
		$Arr['kegiatan'][$t] = $row['sop_kegiatan'];
		$Arr['kelengkapan'][$t] = $row['sop_kelengkapan'];
		$Arr['waktu'][$t] = $row['sop_waktu'];
		$Arr['hasil'][$t] = $row['sop_hasil'];
		$Arr['keterangan'][$t] = $row['sop_keterangan'];
		$Arr['pelaksana1'][$t] = $row['sop_pelaksana1'];
		$Arr['pelaksana2'][$t] = $row['sop_pelaksana2'];
		$Arr['pelaksana3'][$t] = $row['sop_pelaksana3'];
		$Arr['pelaksana4'][$t] = $row['sop_pelaksana4'];
		$Arr['pelaksana5'][$t] = $row['sop_pelaksana5'];
		$Arr['pelaksana6'][$t] = $row['sop_pelaksana6'];
		$Arr['pelaksana7'][$t] = $row['sop_pelaksana7'];
		$Arr['pelaksana8'][$t] = $row['sop_pelaksana8'];
		$Arr['pelaksana9'][$t] = $row['sop_pelaksana9'];
		$Arr['pelaksana10'][$t] = $row['sop_pelaksana10'];
		$Arr['pelaksana11'][$t] = $row['sop_pelaksana11'];
		$Arr['pelaksana12'][$t] = $row['sop_pelaksana12'];
		$Arr['pelaksana13'][$t] = $row['sop_pelaksana13'];
		$Arr['pelaksana14'][$t] = $row['sop_pelaksana14'];
		$Arr['pelaksana15'][$t] = $row['sop_pelaksana15'];
		$Arr['pel1'][$t] = $row['sop_nm_pel1'];
		$Arr['pel2'][$t] = $row['sop_nm_pel2'];
		$Arr['pel3'][$t] = $row['sop_nm_pel3'];
		$Arr['pel4'][$t] = $row['sop_nm_pel4'];
		$Arr['pel5'][$t] = $row['sop_nm_pel5'];
		$Arr['pel6'][$t] = $row['sop_nm_pel6'];
		$Arr['pel7'][$t] = $row['sop_nm_pel7'];
		$Arr['pel8'][$t] = $row['sop_nm_pel8'];
		$Arr['pel9'][$t] = $row['sop_nm_pel9'];
		$Arr['pel10'][$t] = $row['sop_nm_pel10'];
		$Arr['pel11'][$t] = $row['sop_nm_pel11'];
		$Arr['pel12'][$t] = $row['sop_nm_pel12'];
		$Arr['pel13'][$t] = $row['sop_nm_pel13'];
		$Arr['pel14'][$t] = $row['sop_nm_pel14'];
		$Arr['pel15'][$t] = $row['sop_nm_pel15'];
		$Arr['decision'][$t] = $row['sop_decision_perbaris'];
		$Arr['pelaksana_perbaris'][$t] = $row['sop_pelaksana_perbaris'];
		
		$t++;
	}
	
	// gambar ttd
	$g = $this->db->query("select ttd_pengesah_gambar from ttd_pengesah where user_id='".$userpengesah."'")->row_array();;
	$gambar = $g['ttd_pengesah_gambar'];
	
	
	$jmlpel = 0;
	for($p=0;$p<$jmlpelaksana;$p++){
			$jmlpel++;
	}
	// batas 10
	$jmlpel = ($jmlpel <= 10 ? $jmlpel : 10);
	
	$link = ($row['sop_update_file'] == '' ? ''.base_url().'pdf/index.php?alias='.$row['sop_alias'].'' : ''.base_url().'assets/media/sop_update/'.$row['sop_update_file'].'');

	// update notif
	$this->Notif_m->update_status('notif','notif_status','revisi_id',$this->uri->segment(5));
	
	// catatan revisi
	$revisi = $this->Sop_m->revisi_detail($alias,$this->uri->segment(5));
	if($revisi->num_rows() > 0){ 
		foreach($revisi->result_array() as $row){
			$revisitanggal = $row['revisi_tanggal_tindakan'];
			$msg = ($row['revisi_status'] == 'ditolak' ? 'danger' : 'success');
			$id = $row['revisi_id'];
			$alias = $row['sop_alias'];
			$revisistatus = $row['revisi_status'];
			$revisicatatan = $row['revisi_catatan'];
			$revisicatatanadmin = $row['revisi_catatan_admin'];
		}
	}
?>
						
										
<div class="page" style="max-width: 1300px;">
	<div class="page-header">
      <h1 class="page-title"><?=$title?></h1>
      <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
		<li class="breadcrumb-item active">SOP</li>
	  </ol>
    </div>
	
	
    <div class="page-content container-fluid">
      <div class="row">
		
			<div class="col-lg-12">
			  <!-- Panel Summary Mode -->
			  
			  
			  <div class="panel">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
							<?php if($revisi->num_rows() > 0){ 
										echo'<a href="'.base_url().'sop/revisi_sop/sebelumnya/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'" target="_blank" class="badge badge-warning" style="float:right; font-size:12px">Lihat Sop Sebelumnya</a>';
										if($revisistatus == 'pending'){
							?>				<div class="errors alert alert-info alert-dismissible"><?=$revisicatatan?></div>
											<form class="form-horizontal" id="FrmAjax">
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
											<input type="hidden" name="id" value="<?=$id?>"/>
											<input type="hidden" name="alias" value="<?=$alias?>"/>
												<div class="Errors"></div>
												<div class="form-group row">
												  <label class="col-md-3 form-control-label">Tindakan</label>
												  <div class="col-md-6">
													  <div class="radio-custom radio-default radio-inline">
														<input type="radio" id="a" name="tindakan" value="diterima" checked/>
														<label for="a">Terima</label>
													  </div>
													  <div class="radio-custom radio-default radio-inline">
														<input type="radio" id="n" name="tindakan" value="ditolak"/>
														<label for="n">Tolak</label>
													  </div>
												  </div>
												</div>
												<div class="form-group row">
												  <label class="col-md-3 form-control-label">Catatan</label>
												  <div class="col-md-6">
													<textarea type="text" class="form-control" name="catatan"></textarea>
												  </div>
												</div>
												<div class="text-right col-md-9">
												  <button type="submit" class="btn btn-primary">Submit</button>
												</div>
											</form>
							<?php 
										}else{
											echo'<div class="errors alert alert-'.$msg.' alert-dismissible">
												Tanggal : '.tgl_indo2($revisitanggal).'<br>
												Status : '.$revisistatus.'<br>
												Catatan dilakukan revisi: '.$revisicatatan.'<br>
												Catatan admin: '.$revisicatatanadmin.'
											</div>';
										}
										
							} ?>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<style>.TableDetail{margin-left:-20px} .TableKeg{line-height:11px; margin-left:-20px} .TableKeg th{text-align:center}</style>
						<table class="TableDetail" style="width:32cm; font-size:9px;; font-family:sans-serif; color:#000" cellspacing="0" cellpadding="3" border="1" align="center">
								<tbody><tr valign="top">
									<td width="50%" align="center" height="110">
										<br><img src="<?=base_url()?>assets/media/logo/sekneg.png" width="60" height="60"><br><br>
										<div style="text-transform: uppercase; font-weight:bold;">KEMENTERIAN SEKRETARIAT NEGARA<br>REPUBLIK INDONESIA</div><br>
										<b><?=($nm_satker == '-' ? '' : $nm_satker)?></b><br><br>
										<b style="text-transform: uppercase;"><?=$nm_unitkerja?></b>
									</td>
									<td width="50%" align="center">
										<div style="border-bottom:1px solid #000; text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px">
											<div style="float:left; width:114px;"><b>NOMOR SOP</b></div>
											<div style="float:left; width:10px;">:</div>
											<div style="float:left; width:450px;"><?=$no_sop?></div>
											<div style="clear:both"></div>
										</div>
										<div style="border-bottom:1px solid #000; text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px">
											<div style="float:left; width:114px;"><b>TGL. PEMBUATAN</b></div>
											<div style="float:left; width:10px;">:</div>
											<div style="float:left; width:450px"><?=$tgl_sop?></div>
											<div style="clear:both"></div>
										</div>
										<div style="border-bottom:1px solid #000; text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px">
											<div style="float:left; width:114px;"><b>TGL. REVISI</b></div>
											<div style="float:left; width:10px;">:</div>
											<div style="float:left; width:450px"><?=$tgl_revisi?></div>
											<div style="clear:both"></div>
										</div>
										<div style="border-bottom:1px solid #000; text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px">
											<div style="float:left; width:114px;"><b>TGL. EFEKTIF</b></div>
											<div style="float:left; width:10px;">:</div>
											<div style="float:left; width:450px"><?=$tgl_efektif?></div>
											<div style="clear:both"></div>
										</div>
										<div style="border-bottom:1px solid #000; text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px;">
											<div style="float:left; width:114px;"><b>DISAHKAN OLEH</b></div>
											<div style="float:left; width:10px;">:</div>
											<div style="float:left; width:450px"><?=$disahkan_jabatan?> <br><br>
												<?=($gambar != '' ? '<img src="'.site_url().'master/img_ttd/'.$gambar.'" height="25">' : '<br>')?><br><br>
												<?=$disahkan_nama?> <br><?=$disahkan_nip?>
											</div>
											<div style="clear:both"></div>
										</div>
										<div style="text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px">
											<div style="float:left; width:114px;"><b>NAMA SOP</b></div>
											<div style="float:left; width:10px;">:</div>
											<div style="float:left; width:450px"><?=$nama_sop?></div>
											<div style="clear:both"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td><b>DASAR HUKUM:</b></td>
									<td><b>KUALIFIKASI PELAKSANA:</b></td>
								</tr>
								<tr valign="top">
									<td><div style="height:140px; overflow:hidden">
										<?=nl2br($dasar_hukum)?>
										</div>
									</td>
									<td><div style="height:140px; overflow:hidden">
										<?=nl2br($kualifikasi_pelaksana)?>
										</div>
									</td>
								</tr>
								<tr>
									<td><b>KETERKAITAN:</b></td>
									<td><b>PERALATAN/PERLENGKAPAN:</b></td>
								</tr>
								<tr valign="top">
									<td>
										<div style="height:70px; overflow:hidden">
										<?=nl2br($keterkaitan)?>
										</div>
									</td>
									<td>
										<div style="height:45px; overflow:hidden">
										<?=nl2br($peralatan)?>
										</div>
									</td>
								</tr>
								<tr>
									<td><b>PERINGATAN:</b></td>
									<td><b>PENCATATAN DAN PENDATAAN:</b></td>
								</tr>
								<tr valign="top">
									<td>
										<div style="height:45px; overflow:hidden">
										<?=nl2br($peringatan)?>
										</div>
									</td>
									<td>
										<div style="height:45px; overflow:hidden">
										<?=$pencatatan?>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<table cellpadding="2" cellspacing="0"  border="1" align="center" class="TableKeg" style="margin-top:20px; width:32cm; font-size:9px;; font-family:arial; color:#000">
								<tr bgcolor="#ddd" align="center">
										<th rowspan="2" width="20">No.</th>
										<th rowspan="2">Kegiatan</th>
										<th colspan="<?=$jmlpel?>">Pelaksana</th>
										<?php 
										if($jmlpelaksana > 10){
											$no=10;
											for($p=10;$p<$jmlpelaksana;$p++){
												$no++;
													echo '<th rowspan="2" style="width:35px; height:35px;">
														<div style="width:35px; height:35px; word-wrap: break-word; overflow:hidden">
															'.$Arr['pel'.$no.''][0].'
														</div></th>';
											}
										} ?>
										<th colspan="3">Mutu Baku</th>
										<th rowspan="2" width="100">Keterangan</th>
									</tr>
									<tr bgcolor="#ddd" align="center">
										<?php 
											$no=0;
											for($i=0;$i<$jmlpel;$i++){ 
											$no++;
										?>
											<th style="width:35px; height:35px;">
												<div style="width:35px; height:35px; word-wrap: break-word; overflow:hidden">
													<?=$Arr['pel'.$no.''][0]?>
												</div>
											</th>
										<?php } ?>
										<th width="70">Kelengkapan</th>
										<th width="50">Waktu</th>
										<th width="70">Output</th>
									</tr>
									<?php 
										$no=0;
										for($i=0;$i<$t;$i++){ 
										$no++;
									?>
									<tr>
										<td align="center"><?=$no?></td>
										<td height="135">
											<div style="height:135px; overflow:hidden; word-wrap: break-word; display: table-cell; vertical-align: middle">	
												<?=nl2br($Arr['kegiatan'][$i])?>
											</div>
										</td>
										<?php 
											$q=0;
											$z=0;
											$pel='';
											$disnama = '';
											for($p=0;$p<$jmlpelaksana;$p++){
												$z = $i-1;
												$q++;
										?>
											<td align="center">
												<?php
													if(substr($Arr['pelaksana'.$q.''][$i], -1) == 'Y'){
														if(($i==0) or ($no == $t)){echo '<img src="'.base_url().'assets/media/simbol/awal-akhir.png">';} 			// simbol akhir
														else{                                                                                                   // simbol proses atau decision
															if(substr($Arr['decision'][$i],-1) == 'Y'){
																echo '<img src="'.base_url().'assets/media/simbol/decision.png">';
															}else{
																echo '<img src="'.base_url().'assets/media/simbol/proses.png">';
															}
														}
														// ngilangin error
														error_reporting(0);

														

														if($Arr['konektor'][$no] != ''){
															$query = $this->Sop_m->img_simbol('k-atas-'.$Arr['pelaksana_perbaris'][$i].'-'.$Arr['pelaksana_perbaris'][$no].'');
															echo '<img src="'.base_url().'assets/media/simbol/'; if($query){echo $query[0]['simbol_img'];} echo '" style="position:absolute; '; if($query){echo $query[0]['simbol_margin'];} echo '">'; 
															
														}

														if($Arr['konektor'][$i] != ''){
															echo '<img src="'.base_url().'assets/media/simbol/penghubung-bawah.png" style="position:absolute; margin-top:-35px; margin-left:-26px">'; 
														}else{
															if($i > 0){
																if(substr($Arr['decision'][$i],-1) == 'Y'){
																	if(substr($Arr['decision'][$z],-1) == 'Y'){
																		$query = $this->Sop_m->img_simbol('d-y-'.$Arr['pelaksana_perbaris'][$z].'-'.$q.'');
																		echo '<img src="'.base_url().'assets/media/simbol/'; if($query){echo $query[0]['simbol_img'];} echo '" style="position:absolute; '; if($query){echo $query[0]['simbol_margin'];} echo '">'; // untuk 1-2 margin-left:-96px untuk 1-3 margin-left:-151px
																	}else{
																		$query = $this->Sop_m->img_simbol(''.$Arr['pelaksana_perbaris'][$z].'-'.$q.'');
																		echo '<img src="'.base_url().'assets/media/simbol/'; if($query){echo $query[0]['simbol_img'];} echo '" style="position:absolute; '; if($query){echo $query[0]['simbol_margin'];} echo '">'; // untuk 1-2 margin-left:-96px untuk 1-3 margin-left:-151px
																	}
																	$query1 = $this->Sop_m->img_simbol('d-t-'.$Arr['pelaksana_perbaris'][$z].'-'.$q.'');
																	echo '<img src="'.base_url().'assets/media/simbol/'; if($query1){echo $query1[0]['simbol_img'];} echo '" style="position:absolute; '; if($query1){echo $query1[0]['simbol_margin'];} echo '">'; // untuk 1-2 margin-left:-96px untuk 1-3 margin-left:-151px
																}else{
																	if(substr($Arr['decision'][$z],-1) == 'Y'){
																		$query = $this->Sop_m->img_simbol('d-y-'.$Arr['pelaksana_perbaris'][$z].'-'.$q.'');
																		echo '<img src="'.base_url().'assets/media/simbol/'; if($query){echo $query[0]['simbol_img'];} echo '" style="position:absolute; '; if($query){echo $query[0]['simbol_margin'];} echo '">'; // untuk 1-2 margin-left:-96px untuk 1-3 margin-left:-151px
																	}else{
																		if(count(explode(',',$Arr['pelaksana_perbaris'][$i])) > 1){
																			if($disnama != $Arr['pelaksana_perbaris'][$z].'-'.$Arr['pelaksana_perbaris'][$i]){
																				$disnama = $Arr['pelaksana_perbaris'][$z].'-'.$Arr['pelaksana_perbaris'][$i];
																				$query = $this->Sop_m->img_simbol(''.$Arr['pelaksana_perbaris'][$z].'-'.$Arr['pelaksana_perbaris'][$i].'');
																				echo '<img src="'.base_url().'assets/media/simbol/'; if($query){echo $query[0]['simbol_img'];} echo '" style="position:absolute; '; if($query){echo $query[0]['simbol_margin'];} echo '">'; // untuk 1-2 margin-left:-96px untuk 1-3 margin-left:-151px
																			}
																		}else{
																			$query = $this->Sop_m->img_simbol(''.$Arr['pelaksana_perbaris'][$z].'-'.$q.'');
																			echo '<img src="'.base_url().'assets/media/simbol/'; if($query){echo $query[0]['simbol_img'];} echo '" style="position:absolute; '; if($query){echo $query[0]['simbol_margin'];} echo '">'; // untuk 1-2 margin-left:-96px untuk 1-3 margin-left:-151px
																		}
																	}
																}
															}
														}
													}
												?>
											</td>
										<?php } ?>	
										<td><div style="height:135px; overflow:hidden; word-wrap: break-word; display: table-cell; vertical-align: middle"><?=nl2br($Arr['kelengkapan'][$i])?></div></td>
										<td><div style="height:135px; overflow:hidden; word-wrap: break-word; display: table-cell; vertical-align: middle"><?=nl2br($Arr['waktu'][$i])?></div></td>
										<td><div style="height:135px; overflow:hidden; word-wrap: break-word; display: table-cell; vertical-align: middle"><?=nl2br($Arr['hasil'][$i])?></div></td>
										<td><div style="height:135px; overflow:hidden; word-wrap: break-word; display: table-cell; vertical-align: middle"><?=nl2br($Arr['keterangan'][$i])?></div></td>
									</tr>
									<?php } ?>	
						</table>
												
												
												
						<?php } ?>
							
					  
				</div>
			  </div>
			  
			  <!-- End Panel Summary Mode -->
			</div>
		
      </div>
    </div>
	
	
  </div>
  



<script>
			// action save
			$("#FrmAjax").on('submit',(function(e) {
				e.preventDefault();
				$.ajax({
				url: "<?=base_url()?>act_sop/tindakan_revisi", 
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					if(data == '1'){
						alert('Data Berhasil Disimpan');
						location.href="<?=base_url()?>notification/semua"
					}else{
						  $('.Errors').html('<div class="errors alert alert-danger alert-dismissible"><button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button><p>Errors : </p>'+data+'</div>');
					}
				}
				});
			}));
</script>