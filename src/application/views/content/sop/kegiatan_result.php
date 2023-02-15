<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<style>
	.TableKeg{
		line-height:11px
	} 
	.TableKeg th{
		text-align:center
	}
</style>
<table cellpadding="2" cellspacing="0"  border="1" align="center" class="TableKeg" style="margin-top:20px; width:32cm; font-size:9px; font-family:arial; color:#000;">
	<tr bgcolor="#ddd" align="center">
		<th rowspan="2" width="20">No.</th>
		<th rowspan="2">Kegiatan</th>
		<th colspan="<?= $jmlpel; ?>">Pelaksana</th>
		<?= cetak_pelaksana_bawah($pelaksana); ?>
		<th colspan="3">Mutu Baku</th>
		<th rowspan="2" width="100">Keterangan</th>
	</tr>
	<tr bgcolor="#ddd" align="center">
		<?= cetak_pelaksana_atas($pelaksana); ?>
		<th width="70">Kelengkapan</th>
		<th width="50">Waktu</th>
		<th width="70">Output</th>
	</tr>

	<?php for($i=0; $i<count($kegiatan); $i++): ?>
		<tr>
			<td><?= $no++; ?></td>
			<td height="135">
				<div style="height:135px; overflow:hidden;">
					<div style="height:135px; word-wrap: break-word; align-self: center; display: table-cell; vertical-align: middle">
						<?= nl2br($kegiatan[$i]) ?>
					</div>
				</div>
			</td>
			<?php for($j=0; $j<$n_koneksi; $j++): ?>
				<td align="center"><?= $img_chart[$i][$j] ?></td>
			<?php endfor; ?>
			<td>
				<div style="height:135px; overflow:hidden;">
					<div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle">
						<input type="hidden" name="tr[]" value="">
						<input type="hidden" name="kelengkapan[]" value="<?= $kelengkapan[$i] ?>">
						<?= nl2br($kelengkapan[$i]) ?>
					</div>
				</div>
			</td>
			<td>
				<div style="height:135px; overflow:hidden;">
					<div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle">
						<input type="hidden" name="waktu[]" value="<?= $waktu[$i] ?>">
						<?= $waktu[$i] ?>
					</div>
				</div>
			</td>
			<td>
				<div style="height:135px; overflow:hidden;">
					<div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle">
						<input type="hidden" name="hasil[]" value="<?= $hasil[$i] ?>">
						<?= nl2br($hasil[$i]) ?>
					</div>
				</div>
			</td>
			<td>
				<div style="height:135px; overflow:hidden;">
					<div style="height:135px; word-wrap: break-word; display: table-cell; vertical-align: middle">
						<input type="hidden" name="keterangan[]" value="<?= $keterangan[$i] ?>">
						<?= nl2br($keterangan[$i]) ?>
					</div>
				</div>
			</td>
		</tr>
	<?php endfor; ?>

</table>
<br/>
<table width="100%">
	<tr>
		<td>
			<!--<button type="reset" class="easyui-linkbutton" data-options="iconCls:\'icon-save\'" style="float:left; margin:5px 0 20px 0; width:120px; height:40px">Hapus</button>-->
			<button type="button" class="btn btn-warning btn-back">
				<i class="fa fa-arrow-left"></i> Kembali
			</button>

		</td>
	</tr>
</table>
<div style="clear:both"></div>		
	