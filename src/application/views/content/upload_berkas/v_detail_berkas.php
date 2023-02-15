<style type="text/css">
	.borderless td, .borderless th{
    	border: none;
	}
</style>
<div class="page" style="max-width: 1300px;">
	<div class="page-header">
    	<h1 class="page-title"><?=$title?></h1>
      	<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="<?=base_url()?>dashboard">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Upload Berkas SOP</li>
	  	</ol>
      	<div class="page-header-actions">
			<a type="button" class="btn btn-warning" href="<?= site_url('kelola_sop/upload_berkas') ?>">
				<i class="icon wb-arrow-left" aria-hidden="true"></i> Back
			</a>
      </div>
   </div>
	
   <div class="page-content container-fluid">
      <div class="row">
			<div class="col-lg-12">
			  	<div class="panel">
					<div class="panel-body">
					
						<table class="table borderless">
                     <tr>
                        <td colspan="3">
                           <b>Data SOP</b>
                        </td>
                     </tr>
    						<tr>
      						<td scope="row" style="width: 19%;">No SOP</td>
      						<td style="width: 1%;">:</td>
      						<td style="width: 80%;"><?= $sop->sop_no ?></td>
    						</tr>
                     <tr>
                        <td scope="row">Nama SOP</td>
                        <td>:</td>
                        <td><?= $sop->sop_nama ?></td>
                     </tr>
                     <tr>
                        <td scope="row">Tanggal Penerbitan</td>
                        <td>:</td>
                        <td><?= $sop->sop_tgl_efektif ?></td>
                     </tr>
                     <tr>
                        <td scope="row">Nama Pengupload</td>
                        <td>:</td>
                        <td><?= $berkas->nama_penyusun ?></td>
                     </tr>
                     <tr>
                        <td scope="row">NIP Pengupload</td>
                        <td>:</td>
                        <td><?= $berkas->nip_penyusun ?></td>
                     </tr>
    						<tr>
      						<td scope="row">Waktu Upload</td>
      						<td>:</td>
      						<td><?= date('d-m-Y H:i:s', strtotime($berkas->tanggal)); ?></td>
    						</tr>
                     <tr>
                        <td scope="row">Satuan Organisasi</td>
                        <td>:</td>
                        <td><?= $sop->satuan_organisasi_nama ?></td>
                     </tr>
                     <tr>
                        <td scope="row">Deputi</td>
                        <td>:</td>
                        <td><?= $sop->nama_deputi ?></td>
                     </tr>
                     <tr>
                        <td scope="row">Biro</td>
                        <td>:</td>
                        <td><?= $sop->nama_unit ?></td>
                     </tr>
                     <tr>
                        <td scope="row">File SOP</td>
                        <td>:</td>
                        <td><?= $berkas->file ?> <a href="<?= site_url('kelola_sop/lihat_berkas/'.enkripsi_id_url($sop->sop_alias)) ?>" target="_blank">Preview</a></td>
                     </tr>

						</table>
					</div>
			  	</div>
			</div>
      </div>
   </div>
</div>