<style type="text/css">
	.last-column{
		border-right: 0.25px solid #000;
		border-bottom: 0.25px solid #000;
		text-align: left;
	}
	.middle-column{
		border-bottom: 0.25px solid #000;
		text-align: left;
	}
	.first-column-bottom{
		border-left: 0.25px solid #000;
		border-right: 0.25px solid #000;
		border-bottom: 0.25px solid #000;
		text-align: left;
	}
	.second-column-bottom{
		border-right: 0.25px solid #000;
		border-bottom: 0.25px solid #000;
		text-align: left;
	}
</style>
<table style="font-size:9px; font-family:sans-serif; color:#000;" cellspacing="0" cellpadding="5">
	<tr>
		<td width="50%" align="center" rowspan="8" style="text-align:center; border:0.25px solid #000;">
			<br><br>
			<img src="./assets/media/logo/sekneg.png" width="60" height="60">
			<br><br>
			<b>KEMENTERIAN SEKRETARIAT NEGARA<br>REPUBLIK INDONESIA</b>
			<br><br>
			<b><?= strtoupper($sop->row()->sop_unit_kerja); ?></b>
			<br>
			<?php if($sop->row()->sop_deputi != ''): ?>
				<b><?= strtoupper($sop->row()->sop_deputi) ?></b><br>
			<?php endif; ?>
			<b><?= strtoupper($sop->row()->sop_nama_satker) ?></b>
			<br><br>
			
			<br>
		</td>
		<td width="10%" class="middle-column" style="border-top:0.25px solid #000;">
			NOMOR SOP
		</td>
		<td width="40%" class="last-column" style="border-top:0.25px solid #000;" colspan="2">
			<?= ' : '.$sop->row()->sop_no ?>
		</td>
	</tr>
	<tr>
		<td width="10%" class="middle-column">
			TGL. PEMBUATAN
		</td>
		<td width="40%" class="last-column">
			<?= ' : '.$sop->row()->sop_tgl_pembuatan ?>
		</td>
	</tr>
	<tr>
		<td width="10%" class="middle-column">
			TGL. REVISI
		</td>
		<td width="40%" class="last-column">
			<?= ' : '.$sop->row()->sop_tgl_revisi ?>
		</td>
	</tr>
	<tr>
		<td width="10%" class="middle-column">
			TGL. EFEKTIF
		</td>
		<td width="40%" class="last-column">
			<?= ' : '.$sop->row()->sop_tgl_efektif ?>	
		</td>
	</tr>
	<tr>
		<td width="10%" style="text-align: left;">
			DISAHKAN OLEH
		</td>
		<td width="40%" style="text-align: left; border-right:0.25px solid #000;">
			<?= ' : '.$sop->row()->sop_disahkan_jabatan ?>	
		</td>
	</tr>
	<tr>
		<td width="10%">
				
		</td>
		<td width="40%" style="border-right:0.25px solid #000;">
			<br><br><br><br><br>
		</td>
	</tr>
	<tr>
		<td width="10%">
				
		</td>
		<td width="40%" style="text-indent:8px; text-align: left; border-right: 0.25px solid #000;">
			<?= $sop->row()->sop_disahkan_nama ?><br>
			&nbsp;&nbsp;&nbsp;<?= $sop->row()->sop_disahkan_nip ?>
		</td>
	</tr>
	
	<tr>
		<td width="10%" class="middle-column" style="border-top: 0.25px solid #000;">
			NAMA SOP
		</td>
		<td width="40%" class="last-column" style="border-top: 0.25px solid #000;">
			<?= ' : '.strtoupper($sop->row()->sop_nama) ?>	
		</td>
	</tr>
	<tr>
		<td width="50%" class="first-column-bottom">
			DASAR HUKUM:
		</td>
		<td width="50%" colspan="2" class="second-column-bottom">
			KUALIFIKASI PELAKSANA:
		</td>
	</tr>
	<tr>
		<td width="50%" class="first-column-bottom" style="height:100px;">
			<?= $sop->row()->sop_dasar_hukum ?>
		</td>
		<td width="50%" colspan="2" class="second-column-bottom" style="height:100px;">
			<?= $sop->row()->sop_kualifikasi ?>
		</td>
	</tr>
	<tr>
		<td width="50%" class="first-column-bottom">
			KETERKAITAN:
		</td>
		<td width="50%" colspan="2" class="second-column-bottom">
			PERALATAN/PERLENGKAPAN:
		</td>
	</tr>
		<tr>
			<td width="50%" class="first-column-bottom" style="height:90px;">
				<?= $keterkaitan ?>
			</td>
			<td width="50%" colspan="2" class="second-column-bottom" style="height:90px;">
				<?= $sop->row()->sop_peralatan ?>
			</td>
		</tr>
		<tr>
			<td width="50%" class="first-column-bottom">
				PERINGATAN:
			</td>
			<td width="50%" colspan="2" class="second-column-bottom">
				PENCATATAN DAN PENDATAAN:
			</td>
		</tr>
		<tr>
			<td width="50%" class="first-column-bottom" style="height:110px;">
				<?= $sop->row()->sop_peringatan ?>
			</td>
			<td width="50%" colspan="2" class="second-column-bottom" style="height:110px;">
				<?= $sop->row()->sop_pencatatan ?>
			</td>
		</tr>
	
</table>
<p style="font-size:9pt; font-family:sans-serif; color:#000;">Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat elektronik yang diterbitkan oleh Balai Sertifikasi Elektronik (BSrE).</p>