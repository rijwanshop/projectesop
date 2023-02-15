<style type="text/css">
	.head-column{
		border: 0.25pt solid #000;
		background-color: #ccc;
		text-align: center;
	}
	.row-kegiatan{
		border-left: 0.25pt solid #000;
		height: 100px;
		border-bottom: 0.25pt solid #000;
		text-align: justify;
	}
	
</style>
<table cellpadding="2" cellspacing="0" align="center" class="TableKeg" style="margin-top:20px; font-size:9px; font-family:arial; color:#000;">
	<tr bgcolor="#ddd" align="center">
		<th rowspan="2" class="head-column" style="width:30px;">No.</th>
		<th rowspan="2" class="head-column">Kegiatan</th>
		<th colspan="<?= $jmlpel ?>" class="head-column" >Pelaksana</th>
		<?= eksport_pelaksana_bawah($sop->row()->sop_alias); ?>
		<th colspan="3" class="head-column" style="width:290px;">Mutu Baku</th>
		<th rowspan="2" class="head-column" style="width:90px;">Keterangan</th>
	</tr>
	<tr bgcolor="#ddd" align="center">
		<?= eksport_pelaksana_atas($sop->row()->sop_alias); ?>
		<th class="head-column" style="width:110px;">Kelengkapan</th>
		<th class="head-column" style="width:80px;">Waktu</th>
		<th class="head-column" style="width:100px;">Output</th>
	</tr>
	<?php foreach ($sop->result_array() as $row): ?>
		<tr nobr="true">
			<td class="row-kegiatan" style="width:30px; text-align:center;"><?= $no++; ?></td>
			<td class="row-kegiatan">					
				<?= nl2br($row['sop_kegiatan']) ?>							
			</td>
			<?php for($j=0; $j<$sop->row()->sop_jml_pelaksana; $j++): ?>
				<td align="center" class="row-kegiatan" style="width:50px;"><?= $img_chart[$no-2][$j] ?></td>
			<?php endfor; ?>
			<td class="row-kegiatan" style="width:110px;">
				<?= nl2br($row['sop_kelengkapan']) ?>								
			</td>
			<td class="row-kegiatan" style="width:80px;">					
				<?=nl2br($row['sop_waktu'])?>						
			</td>
			<td class="row-kegiatan" style="width:100px;">						
				<?=nl2br($row['sop_hasil'])?>								
			</td>
			<td class="row-kegiatan" style="border-right: 0.25pt solid #000; width:90px;">								
				<?=nl2br($row['sop_keterangan'])?>
			</td>
		</tr>
	<?php endforeach; ?>

</table>