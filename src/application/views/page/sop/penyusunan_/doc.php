<?php 
header("Content-type: application/vnd-ms-doc");
header("Content-Disposition: attachment; filename=".str_replace(' ','-',$this->uri->segment(5))."_".time().".doc");



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
		$disahkan_nama = $row['sop_disahkan_nama'];
		$gambar = $row['sop_pengesah_gambar'];
		$disahkan_nip = $row['sop_disahkan_nip'];
		$nama_sop = $row['sop_nama'];
		$dasar_hukum = $row['sop_dasar_hukum'];
		$kualifikasi_pelaksana = $row['sop_kualifikasi'];
		$keterkaitan = $row['sop_keterkaitan'];
		$peralatan = $row['sop_peralatan'];
		$peringatan = $row['sop_peringatan'];
		$pencatatan = $row['sop_pencatatan'];
		$jmlpelaksana = $row['sop_jml_pelaksana'];
		
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
	
	
	$jmlpel = 0;
	for($p=0;$p<$jmlpelaksana;$p++){
			$jmlpel++;
	}
	// batas 10
	$jmlpel = ($jmlpel <= 10 ? $jmlpel : 10);
	
	$link = ($row['sop_update_file'] == '' ? ''.base_url().'pdf/index.php?alias='.$row['sop_alias'].'' : ''.base_url().'assets/media/sop_update/'.$row['sop_update_file'].'');
?>
						
						

						<style>.TableDetail{margin-left:-20px} .TableKeg{line-height:11px; margin-left:-20px} .TableKeg th{text-align:center}</style>
						<table class="TableDetail" style="background:#000; width:29.6cm; font-size:7px; font-family:sans-serif; color:#000" cellspacing="1" cellpadding="3" border="0" align="center">
								<tbody><tr valign="top" style="background:#fff">
									<td width="50%" align="center" height="110">
										<br><img src="<?=base_url()?>assets/media/logo/sekneg.png" width="60" height="60"><br><br>
										<div style="text-transform: uppercase; font-weight:bold;">KEMENTERIAN SEKRETARIAT NEGARA<br>REPUBLIK INDONESIA</div><br>
										<b><?=$nm_satker?></b><br><br>
										<b style="text-transform: uppercase;"><?=$nm_unitkerja?></b>
									</td>
									<td width="50%" align="center">
										<div style="border-bottom:1px solid #000; text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px">
											<b>NOMOR SOP</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <?=$no_sop?>
										</div>
										<div style="border-bottom:1px solid #000; text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px">
											<b>TGL. PEMBUATAN</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <?=$tgl_sop?>
										</div>
										<div style="border-bottom:1px solid #000; text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px">
											<b>TGL. REVISI</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <?=$tgl_revisi?>
										</div>
										<div style="border-bottom:1px solid #000; text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px">
											<b>TGL. EFEKTIF</b><?=$tgl_efektif?>
										</div>
										<div style="border-bottom:1px solid #000; text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px;">
											<b>DISAHKAN OLEH</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : 
											<br>
												<?=$disahkan_jabatan?> <br><br>
												<?=($gambar != '' ? '<img src="'.site_url().'master/img_ttd/'.$gambar.'" height="25">' : '<br>')?><br><br>
												<?=$disahkan_nama?><?=$disahkan_nip?>
										</div>
										<div style="text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px">
											<b>NAMA SOP</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <?=$nama_sop?>
										</div>
									</td>
								</tr>
								<tr style="background:#fff">
									<td><b>DASAR HUKUM :</b></td>
									<td><b>KUALIFIKASI PELAKSANA :</b></td>
								</tr>
								<tr valign="top" style="background:#fff">
									<td height="140"><div style="height:140px; overflow:hidden">
										<?=$dasar_hukum?>
										</div>
									</td>
									<td><div style="height:140px; overflow:hidden">
										<?=$kualifikasi_pelaksana?>
										</div>
									</td>
								</tr>
								<tr style="background:#fff">
									<td><b>KETERKAITAN :</b></td>
									<td><b>PERALATAN/PERLENGKAPAN :</b></td>
								</tr>
								<tr valign="top" style="background:#fff">
									<td height="70">
										<div style="height:70px; overflow:hidden">
										<?=$keterkaitan?>
										</div>
									</td>
									<td>
										<div style="height:70px; overflow:hidden">
										<?=$peralatan?>
										</div>
									</td>
								</tr>
								<tr style="background:#fff">
									<td><b>PERINGATAN :</b></td>
									<td><b>PENCATATAN DAN PENDATAAN :</b></td>
								</tr>
								<tr valign="top" style="background:#fff">
									<td height="45">
										<div style="height:45px; overflow:hidden">
										<?=$peringatan?>
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
						<table cellpadding="2" cellspacing="1"  border="0" align="center" class="TableKeg" style="background:#000; margin-top:20px; width:29.6cm; font-size:7px; font-family:arial; color:#000">
								<tr style="background:#ddd" align="center">
										<th rowspan="2" width="20">No</th>
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
									<tr style="background:#ddd" align="center">
										<?php 
											$no=0;
											for($i=0;$i<$jmlpel;$i++){ 
											$no++;
										?>
											<th style="width:35px; height:35px;">
												<div style="height:135px; overflow:hidden;">
												<div style="width:35px; height:35px; word-wrap: break-word; overflow:hidden">
													<?=$Arr['pel'.$no.''][0]?>
												</div>
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
									<tr style="background:#fff">
										<td align="center"><?=$no?></td>
										<td height="135">
											<div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle">	
												<?=$Arr['kegiatan'][$i]?>
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
																		echo '<div style="background:url('.base_url().'assets/media/simbol/'; if($query){echo $query[0]['simbol_img'];} echo')no-repeat right top; width:100px; height:165px; position:absolute; '; if($query){echo $query[0]['simbol_margin'];} echo '">'; // untuk 1-2 margin-left:-96px untuk 1-3 margin-left:-151px
																	}
																}
															}
														}
														
													}
												?>
											</td>
										<?php } ?>	
										<td><div style="height:135px; overflow:hidden;"><div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle"><?=$Arr['kelengkapan'][$i]?></div></div></td>
										<td><div style="height:135px; overflow:hidden;"><div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle"><?=$Arr['waktu'][$i]?></div></div></td>
										<td><div style="height:135px; overflow:hidden;"><div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle"><?=$Arr['hasil'][$i]?></div></div></td>
										<td><div style="height:135px; overflow:hidden;"><div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle"><?=$Arr['keterangan'][$i]?></div></div></td>
									</tr>
									<?php } ?>	
						</table>
									