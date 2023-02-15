<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<style>
	input.form-control{
		font-size:9px; 
		padding:3px; 
		height:25px; 
		border:none; 
		border-bottom:1px dashed #000; 
		color:#000;
	}
	textarea.form-control{
		font-size:9px;
		color:#000;
		border:none; 
		border-bottom:1px dashed #000; 
	}
	table#headersop{
		width: 100%;
		font-size:9px; 
		font-family:arial; 
		color:#000; 
		margin-left: 3px;
		margin-right: 15px;
	}
</style>
<form id="FrmHeader" method="post">
	<input type="hidden" name="id" id="id" />
	<input type="hidden" name="method" id="method" value="insert" />
	<div class="alert alert-warning" role="alert">
  		Tanda <span style="color:red;">*</span> Wajib diisi
	</div>
	<table id="headersop" cellpadding="3" cellspacing="0" align="center" border="1">
		<tr>
			<td width="50%" rowspan="6" align="center" valign="top">
				<br>
				<img src="<?=base_url()?>assets/media/logo/sekneg.png" width="60" height="60" />
				<br>
				<br>
				<span style="text-transform: uppercase; text-align:center; font-weight:bold;">
					KEMENTERIAN SEKRETARIAT NEGARA
				</span>
				<br>
				<span style="text-transform: uppercase; text-align:center; font-weight:bold;">
					REPUBLIK INDONESIA
				</span>

				<div style="margin-top:10px; text-transform: uppercase; font-weight:bold;">
					<div id="unit_kerja"><?= $nama_unit ?></div>
					<div id="deputi"><?= $nama_deputi ?></div>
					<div id="satuan_kerja"><?= $nama_satorg ?></div>
				</div>
				<input type="hidden" name="nm_satker" value="<?= $nama_satorg ?>">
				<input type="hidden" name="nm_deputi" value="<?= $nama_deputi ?>">
				<input type="hidden" name="nm_unitkerja" value="<?= $nama_unit ?>">

			</td>
			<td width="50%">
				<div style="float:left; width:20%;">
					<label for="no_sop" class="col-form-label">NOMOR SOP</label>
				</div>
				<div style="float:left; width:2%;">
					<label for="no_sop" class="col-form-label">:</label>
				</div>
				<div style="float:left; width:78%;">

					<div class="form-group row">
    					<div class="col-sm-9">
      						<input class="form-control" type="text" name="no_sop" placeholder="No SOP" value="<?= $sop_no ?>" readonly />
    					</div>
    					<div class="col-sm-3">
    						<input class="form-control" id="select-year" type="text" autocomplete="off" value="<?= date('Y') ?>" />
    					</div>
  					</div>
				</div>
			</td>
		</tr>
		<tr>
			<th colspan="2">
				<div style="float:left; width:20%;">
					<label for="tgl_sop" class="col-form-label">
						TGL. PEMBUATAN <span style="color:red;">*</span>
					</label>
				</div>
				<div style="float:left; width:2%;">
					<label for="tgl_sop" class="col-form-label">:</label>
				</div>
				<div style="float:left; width:78%;">
					<input class="form-control datePicker" type="text" name="tgl_sop" style="width:100%;" autocomplete="off" />
				</div>
			</th>
		</tr>
		<tr>
			<th colspan="2">
				<div style="float:left; width:20%;">
					<label for="tgl_revisi" class="col-form-label">
						TGL. REVISI
					</label>
				</div>
				<div style="float:left; width:2%;">
					<label for="tgl_revisi" class="col-form-label">:</label>
				</div>
				<div style="float:left; width:78%;">
					<input class="form-control datePicker" type="text" name="tgl_revisi" style="width:100%;" autocomplete="off" />
				</div>
			</th>
		</tr>
		<tr>
			<th colspan="2">
				<div style="float:left; width:20%;">
					<label for="tgl_efektif" class="col-form-label">
						TGL. EFEKTIF
					</label>
				</div>
				<div style="float:left; width:2%;">
					<label for="tgl_efektif" class="col-form-label">:</label>
				</div>
				<div style="float:left; width:78%;">
					<input type="hidden" name="tgl_efektif">
				</div>
			</th>
		</tr>
		<tr>
			<th colspan="2">
				<div style="float:left; width:20%;">
					<label for="nama_pejabat" class="col-form-label">
						DISAHKAN OLEH
					</label>
				</div>
				<div style="float:left; width:2%;">
					<label for="nama_pejabat" class="col-form-label">:</label>
				</div>
				<div style="float:left; width:78%;">
					<select class="select2 form-control" style="width:100%;">
						<option value="">--Pilih --</option>
						<?php foreach($list_pengesah as $row): ?>
							<option value="<?= $row['nipbaru'] ?>"><?= $row['nama_pegawai']; ?></option>
						<?php endforeach; ?>
					</select>
					<input type="hidden" name="jabatan" value="<?= $jabatan_pengesah ?>">
					<div id="nama-jabatan"><?= $jabatan_pengesah ?></div>
					<br><br><br><br>
					
					<input type="hidden" placeholder="Nama Pejabat" name="nama_pejabat" value="<?= $nama_pengesah ?>">
					<div id="nama-pengesah"><?= $nama_pengesah ?></div>
					<input type="hidden" placeholder="NIP" name="nip_pejabat" value="<?= $nip_pengesah ?>">
					<div id="nip-pengesah"><?= $nip_pengesah ?></div>
				</div>
			</th>
		</tr>
		<tr>
			<th colspan="2">
				<div style="float:left; width:20%;">
					<label for="nama_sop" class="col-form-label">
						NAMA SOP <span style="color:red;">*</span>
					</label>
				</div>
				<div style="float:left; width:2%;">
					<label for="nama_sop" class="col-form-label">
						:
					</label>
				</div>
				<div style="float:left; width:78%;">
					<input type="text" class="form-control" placeholder="Nama SOP" name="nama_sop" style="text-transform: uppercase; width:100%;">
				</div>
			</th>
		</tr>
		<tr>
			<th><b>DASAR HUKUM:</b></th>
			<th colspan="2"><b>KUALIFIKASI PELAKSANA:</b></th>
		</tr>
		<tr valign="top">
			<td height="120">
				<textarea class="form-control" placeholder="Dasar Hukum" name="dasar_hukum" maxlength="1420" rows="6"></textarea>
			</td>
			<td colspan="2">
				<textarea class="form-control" placeholder="Kualifikasi Pelaksana" name="kualifikasi_pelaksana" maxlength="1420" rows="6"></textarea>
			</td>
		</tr>
		<tr>
			<th><b>KETERKAITAN:</b></th>
			<th colspan="2"><b>PERALATAN/PERLENGKAPAN:</b></th>
		</tr>
		<tr valign="top">
			<th height="70">
				<div class="form-group row">
    				<div class="col-sm-11">
      					<input type="text" class="form-control" id="sop_terkait" placeholder="Keterkaitan">
      					<input type="hidden" id="type_link">
    				</div>
    				<div class="col-sm-1">
    					<button class="btn btn-xs btn-icon btn-success" type="button" id="tambah-terkait">
    						+
    					</button>
    				</div>
  				</div>
  				<div class="form-group row d-none" id="field_terkait">
  					<div class="col-sm-11">
  						<table class="table table-striped" id="list_sop_terkait">
  							<thead>
  								<tr>
  									<th width="8%">No</th>
  									<th width="84%">Nama</th>
  									<th width="8%">Action</th>
  								</tr>
  							</thead>
  							<tbody></tbody>
  						</table>
  					</div>
  				</div>
  				
			</th>
			<th colspan="2">
				<textarea class="form-control" placeholder="Peralatan / Perlengkapan" name="peralatan" maxlength="690" rows="3"></textarea>
			</th>
		</tr>
		<tr>
			<th><b>PERINGATAN:</b></th>
			<th colspan="2"><b>PENCATATAN DAN PENDATAAN:</b></th>
		</tr>
		<tr valign="top">
			<th height="45">
				<textarea class="form-control" placeholder="Peringatan" name="peringatan" maxlength="400"/></textarea>
			</th>
			<td colspan="2">
				<label style="margin-bottom:1px">
					<input type="radio" name="pencatatan" value="Disimpan sbg data manual" checked> Disimpan sbg data manual
				</label>
				<br>
				<label style="margin-bottom:1px">
					<input type="radio" name="pencatatan" value="Disimpan sbg data elektronik"> Disimpan sbg data elektronik
				</label>
				<br>
				<label style="margin-bottom:1px">
					<input type="radio" name="pencatatan" value="Disimpan sbg data manual dan elektronik"> Disimpan sbg data manual dan elektronik
				</label>
			</td>
		</tr>
	</table>
	<br>
	<div class="form-group row">
  		<div class="col-sm-12" style="text-align: right;">
  			<button type="submit" class="btn btn-primary">
        		Simpan & Lanjut&nbsp;&nbsp;<i class="fa fa-arrow-right"></i>
    		</button>
  		</div>
  	</div>
</form>