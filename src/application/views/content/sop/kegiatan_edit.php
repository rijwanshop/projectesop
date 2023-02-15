<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<style type="text/css">
	#TableKeg{
		margin-left:20px;
		font-size:9px; 
		font-family:arial; 
		color:#000;
	}
	#TableKeg th{
		text-align:center;
	}
	.resize{
		resize:none; 
		width:35px; 
		height:30px;
	}
</style>
<form id="FrmKegiatan" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id_kegiatan" id="id_kegiatan" value="<?= $sop->row()->sop_alias ?>" />

	<div style="margin-left: 20px;">
		<div class="form-check">
  			<input class="form-check-input" type="radio" name="sop_update_file" id="sop_update_file" value="auto" <?php if($sop->row()->sop_update_file == ''){echo 'checked';} ?>>
  			<label class="form-check-label" for="sop_update_file">
    			Auto
  			</label>
		</div>
	</div>

	<div id="content-kegiatan-auto">
		<div class="alert alert-warning" role="alert" style="margin-left:17px;">
			<ul>
  				<li>Kolom Pelaksana harus terisi sebelum menekan tombol Tambah Kegiatan</li>
  				<li>Kolom Pelaksana diisi singkatan Jabatan yang tertera di Daftar Singkatan</li>
  			</ul>
		</div>
		<table cellpadding="3" cellspacing="0" border="1" align="center" id="TableKeg">
			<tr bgcolor="#ddd">
				<th rowspan="2" width="20" align="left">&nbsp;</th>
				<th rowspan="2" width="40">No.</th>
				<th rowspan="2" width="130">Kegiatan</th>
				<th colspan="10">Pelaksana</th>
				<?php for($i=10; $i<15; $i++): ?>

					<th rowspan="2" width="35" valign="bottom">
						<textarea name="pelaksana[<?= $i ?>]" maxlength="25" class="resize autosave"><?= $arr_sop[0]['sop_nm_pel'.($i+1)] ?></textarea>
					</th>

				<?php endfor; ?>

				<th colspan="3">Mutu Baku</th>
				<th rowspan="2" width="120">Keterangan</th>
			</tr>
			<tr bgcolor="#ddd">
				<?php for($i=0; $i<10; $i++): ?>
					<th width="35">
						<textarea name="pelaksana[<?= $i ?>]" maxlength="25" class="resize autosave"><?= trim($arr_sop[0]['sop_nm_pel'.($i+1)]) ?></textarea>
					</th>
				<?php endfor; ?>

				<th width="70">Kelengkapan</th>
				<th width="60">Waktu</th>
				<th width="60">Output</th>
			</tr>
			<?php foreach($arr_sop as $row): ?>
				<tr>
					<td>
						<input type="checkbox" class="caseKeg H<?= $idx; ?>" style="display:none;"/>
					</td>
					<td>
						<input type="hidden" name="d[]" class="deci<?= $idx; ?>" value="<?= $row['sop_decision_perbaris'] ?>"/>
						<input type="hidden" name="a[]" class="trpel<?= $idx; ?>" value="<?= $row['sop_pelaksana_perbaris'] ?>"/>
						<span id="snum<?= ($idx+1) ?>"><?= ($idx+1) ?></span>
					</td>
					<td height="135" valign=bottom>
						<textarea type="text" class="form-control text-kegiatan" name="kegiatan[]" style="resize:none; height:135px;" maxlength="400"><?= $row['sop_kegiatan'] ?></textarea>
						<div id="charNum">karakter tersisa: <?= (400 - strlen($row['sop_kegiatan'])) ?></div>
					</td>

					<?php for($i=1; $i<16; $i++): ?>
						<?php 
							if($idx == 0 || $idx == $sop->num_rows()-1){ 
								$dc='style="display:none;"';
							}else{ 
								$dc='style="display:block;"';
							}
						?>
						
						<td bgcolor="<?php if($row['sop_pelaksana'.$i] == $i.'-Y'){ if($row['sop_decision_perbaris'] == $i.'-Y'){echo'#f00';} else {echo'#28de7b';}}else{echo'#fff';}?>" align="center" class="check<?= $i ?>_<?= $idx ?>">

							<label style="width:100%">
								<input type="checkbox" onclick="color('<?= $i 
									?>','<?=$idx ?>')" class="pel<?= ($idx+1) ?> pelaksana<?= $i ?>_<?= $idx ?>" name="check_pelaksana<?= $i ?>_<?= $idx ?>" value="<?= $i ?>-Y" <?php if($row['sop_pelaksana'.$i] == $i.'-Y'){echo 'checked';}?>/>
							</label><br><br>
							<div>
								<label class="dc<?= $idx ?>" <?=$dc?>>
									<div style="padding-top:6px">Decision</div> 
									<input type="checkbox" class="deci<?= $i ?>-<?= $idx ?>" name="deci<?= $i ?>_<?= $idx ?>" value="<?= $i ?>-Y" style="width:10px" onclick="deci('<?= $i ?>','<?= $idx ?>')" <?php if($row['sop_decision_perbaris'] == $i.'-Y'){echo 'checked';}?> />
								</label>
							</div>
						</td>
					<?php endfor; ?>

					<td valign=bottom>
						<textarea type="text" class="form-control text-kegiatan" name="kelengkapan[]" maxlength="110" style="resize:none; height:135px;"/><?= $row['sop_kelengkapan'] ?></textarea>
						<div id="charNum">karakter tersisa: <?= (110-strlen($row['sop_kelengkapan']))?></div>
					</td>
					<td valign=bottom>
						<textarea type="text" class="form-control text-kegiatan" name="waktu[]" maxlength="40" style="resize:none; height:135px;"/><?= $row['sop_waktu'] ?></textarea>
						<div id="charNum">karakter tersisa: <?= (40-strlen($row['sop_waktu']))?></div>
					</td>
					<td valign=bottom>
						<textarea type="text" class="form-control text-kegiatan" name="hasil[]" maxlength="110" style="resize:none; height:135px;"/><?= $row['sop_hasil'] ?></textarea>
						<div id="charNum">karakter tersisa: <?= (110-strlen($row['sop_hasil']))?></div>
					</td>
					<td valign=bottom>
						<textarea type="text" class="form-control text-kegiatan" name="keterangan[]" maxlength="150" style="resize:none; height:135px;"/><?= $row['sop_keterangan'] ?></textarea>
						<div id="charNum">karakter tersisa: <?= (150-strlen($row['sop_keterangan']))?></div>
					</td>
				</tr>
				<?php $idx++; ?>
			<?php endforeach; ?>
		</table>
		<br>
		<div class="form-group row" style="margin-left:5px;">
    		<div class="col-sm-6">
      			<button type="button" class="btn btn-danger btn-xs deleteKeg">
      				<i class="fa fa-minus"></i> Hapus
      			</button>&nbsp;
      			<button type="button" class="btn btn-success btn-xs addmoreKeg">
      				<i class="fa fa-plus"></i> Tambah Kegiatan
      			</button>      		
    		</div>
  		</div>
  		<div class="form-group row" style="margin-left:5px;">
  			<div class="col-sm-6">
  				<p class="font-weight-bold">Daftar Singkatan</p>
  				<div clas="table-responsive">

  					<table class="table table-bordered">
  						<thead>
    						<tr>
      							<th scope="col">No</th>
      							<th scope="col">Jabatan</th>
      							<th scope="col">Singkatan</th>
    						</tr>
  						</thead>
  						<tbody>
  							<?php foreach($dt_singkatan->result() as $row): ?>
  								<tr>
  									<th scope="row"><?= $idx++; ?></th>
  									<td><?= $row->nama_jabatan ?></td>
  									<td><?= $row->singkatan ?></td>
  								</tr>
  							<?php endforeach; ?>

  						</tbody>
					</table>

  				</div>
  			</div>
  		</div>
	</div>

	<div style="margin-left: 20px;">
		<div class="form-check">
  			<input class="form-check-input" type="radio" name="sop_update_file" id="sop_update_file" value="manual" <?php if($sop->row()->sop_update_file != ''){echo 'checked';} ?>>
  			<label class="form-check-label" for="sop_update_file">
    			Manual
  			</label>
		</div>
	</div>

	<div id="field-file" style="margin-left: 35px;">
		<?php if($sop->row()->sop_update_file != ''): ?>
		<div class="form-group row">
			<label class="col-md-2 form-control-label">File SOP</label>
			<div class="col-md-8">
				<label class="form-control-label">
					<?= $sop->row()->sop_update_file ?>&nbsp;&nbsp;
					<a href="<?= site_url('pengolahan_sop/lihat_filesop/'.enkripsi_id_url($sop->row()->sop_alias)) ?>" target="_blank">Preview</a>
				</label>			
			</div>		  
		</div>
		<?php endif; ?>
		<div class="form-group row">
			<label class="col-md-2 form-control-label">Edit File SOP</label>
			<div class="col-md-7">
				<input type="file" class="form-control" name="fileupload" style="border:1px solid #888;">
				<small class="form-text text-muted">Format .pdf max 3 MB</small>			
			</div>		  
		</div>
		<br>
		<div style="margin-left: 5px;">
			<div class="form-check">
  				<input class="form-check-input" type="radio" name="type_draft" id="type_draft" value="file" <?php if($sop->row()->link_draft_file == ''){echo 'checked';} ?>>
  				<label class="form-check-label" for="sop_update_file">
    				Upload File Draft SOP
  				</label>
			</div>
		</div>
		<br>

		<div id="field-upload">

			<?php if($sop->row()->sop_draft_file != ''): ?>
			<div class="form-group row">
				<label class="col-md-2 form-control-label">File Draft SOP</label>
				<div class="col-md-8">
					<label class="form-control-label">
						<?= $sop->row()->sop_draft_file ?>&nbsp;&nbsp;
						<a href="<?= site_url('pengolahan_sop/download_draftsop/'.enkripsi_id_url($sop->row()->sop_alias)) ?>" target="_blank">Download</a>
					</label>			
				</div>		  
			</div>
			<?php endif; ?>

			<div class="form-group row">
				<label class="col-md-2 form-control-label">Edit File Draft SOP</label>
				<div class="col-md-7">
					<input type="file" class="form-control" name="filedraft" style="border:1px solid #888;">
					<small class="form-text text-muted">Format .doc atau .docx max 3 MB</small>			
				</div>		  
			</div>
		</div>
		<br>
		<div style="margin-left: 5px;">
			<div class="form-check">
  				<input class="form-check-input" type="radio" name="type_draft" id="type_draft" value="link" <?php if($sop->row()->sop_draft_file == ''){echo 'checked';} ?>>
  				<label class="form-check-label" for="sop_update_file">
    				Input URL File Draft SOP
  				</label>
			</div>
		</div>
		<br>

		<div id="field-link">

			<?php if($sop->row()->link_draft_file != ''): ?>
			<div class="form-group row" style="margin-left: 2px;">
				<label class="col-md-2 form-control-label">Link File Draft</label>
				<div class="col-md-8">
					<label class="form-control-label">
						<a href="<?= $sop->row()->link_draft_file ?>" target="_blank"><?= $sop->row()->link_draft_file ?></a>
					</label>			
				</div>		  
			</div>
			<?php endif; ?>

			<div class="form-group row">
    			<label for="tanggal_pembuatan_sop" class="col-md-2 col-form-label">
    				Link Scloud baru
    			</label>
    			<div class="col-md-6">
      				<input type="text" name="link_draft" id="link_draft" class="form-control" placeholder="URL File Draft" style="border:1px solid #888;" />
      				<small class="form-text text-muted">Link harus diawali dengan https://scloud.setneg.go.id/</small>
    			</div>
  			</div>
  		</div>
  		<div class="form-group row">
			<label class="col-md-2 form-control-label"></label>
			<div class="col-md-8">
				<label class="col-md-12 form-control-label">
					<b>Catatan:</b> Jika Anda mengupload lampiran baru maka lampiran lama akan dihapus dan digantikan dengan lampiran yang baru
				</label>			
			</div>		  
		</div>

	</div>
	<div class="form-group row">
    	<div class="col-sm-12" style="text-align: right;">
    		<button type="button" class="btn btn-warning btn-back">
    			<i class="fa fa-arrow-left"></i> Kembali
    		</button>
      		<button type="submit" class="btn btn-info">
      			Simpan & Lanjut <i class="fa fa-arrow-right"></i>
      		</button>
    	</div>
  	</div>

</form>