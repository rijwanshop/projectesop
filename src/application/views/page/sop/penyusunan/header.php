<?php
$alamat ='';
$jabatan ='';
$jabatanid ='';
$nama ='';
$nip ='';
foreach($dtjabatan->result_array() as $row){
	$jabatan = $row['ttd_pengesah_jabatan'];
	$nama = $row['ttd_pengesah_nama'];
	$nip = $row['ttd_pengesah_nip'];
}
?>
<style>
	.form-control{font-size:9px; padding:3px; height:25px; border:none; border-bottom:1px dashed #000; color:#000}
</style>
<form id="FrmHeader" method="post" enctype="multipart/form-data">
		 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		 <input type="hidden" name="headerok" value="ok" />
		<table cellpadding="3" cellspacing="0" align="center" border="1" style="width:32cm; font-size:9px; font-family:arial; color:#000; margin-left:-20px">
			<tr>
				<td rowspan="6" width="50%" align="center" valign="top"><br>
					<img src="<?=base_url()?>assets/media/logo/sekneg.png" width="60" height="60">
					<div style="margin-top:10px; text-transform: uppercase;">KEMENTERIAN SEKRETARIAT NEGARA<BR>REPUBLIK INDONESIA</div><br>
					
					<input type="hidden" name="nm_satker" placeholder="Satuan Organisasi" style="text-transform: uppercase; text-align:center" value="<?=$satkernm?>">
						<span style="text-transform: uppercase; text-align:center"><?=($satkernm == '-' ? '' : $satkernm)?></span><br>
					<input type="hidden" name="nm_unitkerja" placeholder="Unit Kerja" style="text-align:center; text-transform: uppercase; width:100%;" value="<?=$unitkerjanm?>">
						<span style="text-transform: uppercase; text-align:center"><?=$unitkerjanm?></span>
				</td>
				<th colspan="2">
					<div style="float:left; width:114px;"><b>NOMOR SOP</b></div>
					<div style="float:left; width:10px;">:</div>
					<div style="float:left; width:450px"><input type="hidden" name="no_sop" placeholder="No SOP"></div>
				</th>
			</tr>
			<tr>
				<th colspan="2">
					<div style="float:left; width:114px;"><b>TGL. PEMBUATAN</b></div>
					<div style="float:left; width:10px;">:</div>
					<div style="float:left; width:450px"><input class="form-control datePicker" type="text" name="tgl_sop" style="width:100%;"></div>
				</th>
			</tr>
			<tr>
				<th colspan="2">
					<div style="float:left; width:114px;"><b>TGL. REVISI</b></div>
					<div style="float:left; width:10px;">:</div>
					<div style="float:left; width:450px"><input class="form-control datePicker" type="text" name="tgl_revisi" style="width:100%;"></div>
			</tr>
			<tr colspan="2">
				<th>
					<div style="float:left; width:114px;"><b>TGL. EFEKTIF</b></div>
					<div style="float:left; width:10px;">:</div>
					<div style="float:left; width:450px"><input type="hidden" name="tgl_efektif"></div>
				</th>
			</tr>
			<tr valign="top" colspan="2">
				<th>
					<div style="float:left; width:114px;"><b>DISAHKAN OLEH</b></div>
					<div style="float:left; width:10px;">:</div>
					<div style="float:left;">
						<input type="hidden" name="jabatan" value="<?=$jabatan?>" style="width:100%;"><?=$jabatan?>
						<br><br><br>
						<input type="hidden" name="jabatanid" value="<?=$jabatanid?>">
						<input type="hidden" placeholder="Nama Pejabat" name="nama_pejabat" value="<?=$nama?>"><?=$nama?> &nbsp;
						<input type="hidden" placeholder="NIP" name="nip_pejabat" value="<?=$nip?>"><br>NIP <?=$nip?>
					</div>
				</th>
			</tr>
			<tr valign="top" colspan="2">
				<th height="30">
					<div style="float:left; width:114px;"><b>NAMA SOP</b></div>
					<div style="float:left; width:10px;">:</div>
					<div style="float:left; width:450px;"><input type="text" class="form-control" placeholder="Nama SOP" name="nama_sop" style="text-transform: uppercase; width:100%;"></div>
				</th>
			</tr>
			<tr>
				<th><b>DASAR HUKUM:</b></th>
				<th colspan="2"><b>KUALIFIKASI PELAKSANA:</b></th>
			</tr>
			<tr valign="top">
				<td height="140">
					<textarea type='text' class='form-control' placeholder='Dasar Hukum' name='dasar_hukum' maxlength="1420"/></textarea>
					<!--<div id="editor1" contenteditable="true" style="border-bottom:1px dashed #000; height:90px; width:100%"></div>
					  <span>Maksimal Karakter: 150</span> | <span id="JmlChar"></span>
					  <fieldset>
						<button type="button" class="fontStyle" onclick="document.execCommand('italic',false,null);" title="Italicize Highlighted Text"><i>I</i>
						</button>
					  </fieldset>
					<SCRIPT>
						$('#editor1').on('keydown', function(event) {
						  $('#JmlChar').text('Total chars:' + $(this).text().length);
						  $('#dasar_hukum').val($(this).text());
						  if($(this).text().length === 150 && event.keyCode != 8) {
							event.preventDefault();
						  }
						});
					</SCRIPT>-->
				</td>
				<td colspan="2">
					<textarea type='text' class='form-control' placeholder='Kualifikasi Pelaksana' name='kualifikasi_pelaksana' maxlength="1420"/></textarea>
				</td>
			</tr>
			<tr>
				<th><b>KETERKAITAN:</b></th>
				<th colspan="2"><b>PERALATAN/PERLENGKAPAN:</b></th>
			</tr>
			<tr valign="top">
				<td height="70">
					<textarea type='text' class='form-control' placeholder='Keterkaitan' name='keterkaitan' maxlength="690"/></textarea>
				</td>
				<td colspan="2">
					<textarea type='text' class='form-control' placeholder='Peralatan / Perlengkapan' name='peralatan' maxlength="690"/></textarea>
				</td>
			</tr>
			<tr>
				<th><b>PERINGATAN:</b></th>
				<th colspan="2"><b>PENCATATAN DAN PENDATAAN:</b></th>
			</tr>
			<tr valign="top">
				<td height="45">
					<textarea type='text' class='form-control' placeholder='Peringatan' name='peringatan' maxlength="400"/></textarea>
				</td>
				<td colspan="2">
					<label style="margin-bottom:1px"><input type="radio" name="pencatatan" value="Disimpan sbg data manual" checked> Disimpan sbg data manual</label> <br>
					<label style="margin-bottom:1px"><input type="radio" name="pencatatan" value="Disimpan sbg data elektronik"> Disimpan sbg data elektronik</label> <br>
					<label style="margin-bottom:1px"><input type="radio" name="pencatatan" value="Disimpan sbg data manual dan elektronik"> Disimpan sbg data manual dan elektronik</label>
				</td>
			</tr>
		</table>
		<button type="submit" class="btn btn-success" style="float:right; margin:5px 0 20px 0; width:120px; height:40px">Lanjut</button>
</form>
		  
			<script>
				$(document).ready(function() {
					$('.datePicker')
						.datepicker({
							autoclose: true,
							format: 'dd-mm-yyyy'
						})
						
				});
			</script>