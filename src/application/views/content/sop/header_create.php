<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
?>

<table cellpadding="3" cellspacing="0" class="TableDetail" align="center" border="1" style="font-size:9px; font-family:arial; color:#000; width:100%;">
	<tr valign="top">
		<td rowspan="6" width="50%" align="center"><br>
			<img src="<?= base_url() ?>assets/media/logo/sekneg.png" width="60" height="60">
			<br><br>
			<div style="text-transform: uppercase; font-weight:bold;">
				KEMENTERIAN SEKRETARIAT NEGARA<br>REPUBLIK INDONESIA
			</div>
			<br>
			<b style="text-transform: uppercase; font-weight:bold;"><?= $sop->nama_unit; ?></b><br>
			<?php if($sop->nama_deputi != ''): ?>
				<b style="text-transform: uppercase; font-weight:bold;"><?= $sop->nama_deputi; ?></b><br>
			<?php endif; ?>
			<b style="text-transform: uppercase; font-weight:bold;"><?= $sop->satuan_organisasi_nama; ?></b><br>
			
			<br>	
		</td>
		<td colspan="2" width="50%">
			<div style="float:left; width:20%;"><b>NOMOR SOP</b></div>
			<div style="float:left; width:2%;">:</div>
			<div style="float:left; width:78%;"><?= $sop->sop_no; ?></div>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div style="float:left; width:20%;"><b>TGL. PEMBUATAN</b></div>
			<div style="float:left; width:2%;">:</div>
			<div style="float:left; width:78%;"><?= $sop->sop_tgl_pembuatan; ?></div>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div style="float:left; width:20%;"><b>TGL. REVISI</b></div>
			<div style="float:left; width:2%;">:</div>
			<div style="float:left; width:78%;"><?= $sop->sop_tgl_revisi; ?></div>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div style="float:left; width:20%;"><b>TGL. EFEKTIF</b></div>
			<div style="float:left; width:2%;">:</div>
			<div style="float:left; width:78%;"></div>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="2">
			<div style="float:left; width:20%;"><b>DISAHKAN OLEH</b></div>
			<div style="float:left; width:2%;">:</div>
			<div style="float:left; width:78%;">
				<?= $sop->sop_disahkan_jabatan; ?><br><br><br><br><br>
				<?= $sop->sop_disahkan_nama; ?><br>
				<?= $sop->sop_disahkan_nip; ?>
			</div>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="2">
			<div style="float:left; width:20%;"><b>NAMA SOP</b></div>
			<div style="float:left; width:2%;">:</div>
			<div style="float:left; width:78%;"><?= $sop->sop_nama; ?></div>
		</td>
	</tr>
	<tr>
		<td><b>DASAR HUKUM:</b></td>
		<td colspan="2"><b>KUALIFIKASI PELAKSANA:</b></td>
	</tr>
	<tr valign="top">
		<td>
			<div style="height:140px; overflow:hidden;">
				<?= nl2br($sop->sop_dasar_hukum); ?>
			</div>
		</td>
		<td colspan="2">
			<div style="height:140px; overflow:hidden;">
				<?= nl2br($sop->sop_kualifikasi); ?>
			</div>
		</td>
	</tr>
	<tr>
		<td><b>KETERKAITAN:</b></td>
		<td colspan="2"><b>PERALATAN/PERLENGKAPAN:</b></td>
	</tr>
	<tr valign="top">
		<td>
			<div style="height:70px; overflow:hidden;">
				<?= nl2br($sop->sop_keterkaitan); ?>
			</div>
		</td>
		<td colspan="2">
			<div style="height:70px; overflow:hidden;">
				<?= nl2br($sop->sop_peralatan); ?>		
			</div>
		</td>
	</tr>
	<tr>
		<td><b>PERINGATAN:</b></td>
		<td colspan="2"><b>PENCATATAN DAN PENDATAAN:</b></td>
	</tr>
	<tr valign="top">
		<td>
			<div style="height:45px; overflow:hidden;">
				<?= nl2br($sop->sop_peringatan); ?>
			</div>
		</td>
		<td colspan="2">
			<div style="height:45px; overflow:hidden;">
				<?= $sop->sop_pencatatan; ?>
			</div>
		</td>
	</tr>
</table>