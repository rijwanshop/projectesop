<?php
foreach($edit->result_array() as $row){
	$nama = $row['kontak_kami_nama'];
	$telepon = $row['kontak_kami_telepon'];
	$email = $row['kontak_kami_email'];
	$alamat = $row['kontak_kami_alamat'];
	$isi = $row['kontak_kami_isi'];
	// update
	$this->Komunikasi_m->update_status('kontak_kami','kontak_kami_status','kontak_kami_id',$row['kontak_kami_id']);
}
?>
<div class="page">
	<div class="page-header">
      <h1 class="page-title"><?=$title?></h1>
      <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
		<li class="breadcrumb-item active">Komunikasi</li>
	  </ol>
      <div class="page-header-actions">
		<a type="button" class="btn btn-warning" href="<?=base_url()?>komunikasi/kontak_kami">
			<i class="icon wb-arrow-left" aria-hidden="true"></i> Back
		</a>
      </div>
    </div>
	
	
    <div class="page-content container-fluid">
      <div class="row">
	  
			<div class="col-lg-12">
			  <!-- Panel Summary Mode -->
			  <div class="panel">
				<div class="panel-heading">
				  <h3 class="panel-title">Lihat <?=$title?></h3>
				</div>
				<div class="panel-body">
				  <form class="form-horizontal" id="FrmAjax">
					<div class="Errors"></div>
					<div class="form-group row">
					  <label class="col-md-3 form-control-label">Namadd</label>
					  <div class="col-md-6" style="padding-top:7px">
						<?=$nama?>
					  </div>
					</div>
					<div class="form-group row">
					  <label class="col-md-3 form-control-label">No Telepon</label>
					  <div class="col-md-6" style="padding-top:7px">
						<?=$telepon?>
					  </div>
					</div>
					<div class="form-group row">
					  <label class="col-md-3 form-control-label">Email</label>
					  <div class="col-md-6" style="padding-top:7px">
						<?=$email?>
					  </div>
					</div>
					<div class="form-group row">
					  <label class="col-md-3 form-control-label">Alamat</label>
					  <div class="col-md-6" style="padding-top:7px">
						<?=$alamat?>
					  </div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 form-control-label">Isi</label>
						<div class="col-md-6" style="padding-top:7px">
							<?=$isi?>
						</div>
                    </div>
				  </form>
				</div>
			  </div>
			  
			  
			  <!-- End Panel Summary Mode -->
			</div>
		
      </div>
    </div>
	
	
  </div>
