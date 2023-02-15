<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<style>
	.TableDetail{
		margin-left:-20px
	} 
	.TableKeg{
		line-height:11px; 
		margin-left:-20px
	} 
	.TableKeg th{
		text-align:center
	}
</style>
<table class="TableDetail" style="width:32cm; font-size:9px;; font-family:sans-serif; color:#000" cellspacing="0" cellpadding="3" border="1" align="center">
	<tbody>
		<tr valign="top">
			<td width="50%" align="center" height="110">
				<br>
				<img src="<?=base_url()?>assets/media/logo/sekneg.png" width="60" height="60">
				<br><br>
				<div style="text-transform: uppercase; font-weight:bold;">
					KEMENTERIAN SEKRETARIAT NEGARA<br>REPUBLIK INDONESIA
				</div><br>
				<b style="text-transform: uppercase; font-weight:bold;">
					<?= $sop->row()->sop_unit_kerja ?>
				</b><br>
				<?php if($sop->row()->sop_deputi != ''): ?>
					<b style="text-transform: uppercase; font-weight:bold;">
						<?= strtoupper($sop->row()->sop_deputi) ?>
					</b><br>
				<?php endif; ?>
				<b style="text-transform: uppercase; font-weight:bold;">
					<?= strtoupper($sop->row()->sop_nama_satker) ?>
				</b><br><br>						
			</td>
			<td width="50%" align="center">
				<div style="border-bottom:1px solid #000; text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px">
					<div style="float:left; width:114px;"><b>NOMOR SOP</b></div>
					<div style="float:left; width:10px;">:</div>
					<div style="float:left; width:450px;">
						<?= $sop->row()->sop_no ?>		
					</div>
					<div style="clear:both"></div>
				</div>
				<div style="border-bottom:1px solid #000; text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px">
					<div style="float:left; width:114px;"><b>TGL. PEMBUATAN</b></div>
					<div style="float:left; width:10px;">:</div>
					<div style="float:left; width:450px">
						<?= $sop->row()->sop_tgl_pembuatan ?>
					</div>
					<div style="clear:both"></div>
				</div>
				<div style="border-bottom:1px solid #000; text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px">
					<div style="float:left; width:114px;"><b>TGL. REVISI</b></div>
					<div style="float:left; width:10px;">:</div>
					<div style="float:left; width:450px">
						<?= $sop->row()->sop_tgl_revisi ?>		
					</div>
					<div style="clear:both"></div>
				</div>
				<div style="border-bottom:1px solid #000; text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px">
					<div style="float:left; width:114px;"><b>TGL. EFEKTIF</b></div>
					<div style="float:left; width:10px;">:</div>
					<div style="float:left; width:450px">
						<?= $sop->row()->sop_tgl_efektif ?>		
					</div>
					<div style="clear:both"></div>
				</div>
				<div style="border-bottom:1px solid #000; text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px;">
					<div style="float:left; width:114px;"><b>DISAHKAN OLEH</b></div>
					<div style="float:left; width:10px;">:</div>
					<div style="float:left; width:450px">
						<?= $sop->row()->sop_disahkan_jabatan?> 
						<br><br>
						<br><br>
						<?= $sop->row()->sop_disahkan_nama ?><br> 
						<?= $sop->row()->sop_disahkan_nip ?>
					</div>
					<div style="clear:both"></div>
				</div>
				<div style="text-align:left; margin-left:-2px; margin-right:-2px; padding:2px 0px">
					<div style="float:left; width:114px;"><b>NAMA SOP</b></div>
					<div style="float:left; width:10px;">:</div>
					<div style="float:left; width:450px">
						<?= $sop->row()->sop_nama ?>		
					</div>
					<div style="clear:both"></div>
				</div>
			</td>
		</tr>
		<tr>
			<td><b>DASAR HUKUM:</b></td>
			<td><b>KUALIFIKASI PELAKSANA:</b></td>
		</tr>
		<tr valign="top">
			<td>
				<div style="height:140px; overflow:hidden">
					<?= nl2br($sop->row()->sop_dasar_hukum)?>
				</div>
			</td>
			<td>
				<div style="height:140px; overflow:hidden">
					<?= nl2br($sop->row()->sop_kualifikasi) ?>
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
					<?= nl2br($sop->row()->sop_keterkaitan) ?>
				</div>
			</td>
			<td>
				<div style="height:70px; overflow:hidden">
					<?= nl2br($sop->row()->sop_peralatan) ?>
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
					<?= nl2br($sop->row()->sop_peringatan) ?>
				</div>
			</td>
			<td>
				<div style="height:45px; overflow:hidden">
					<?= $sop->row()->sop_pencatatan ?>
				</div>
			</td>
		</tr>
	</tbody>
</table>