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
			<li class="breadcrumb-item active">SOP</li>
	  	</ol>
      	<div class="page-header-actions">
			<a type="button" class="btn btn-warning" href="<?= site_url('review_sop') ?>">
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
      							<th scope="row" style="width: 19%;">Status Pengajuan</th>
      								<td style="width: 1%;">:</td>
      								<td style="width: 80%;"><?= $review->status_pengajuan ?></td>
    							</tr>
    							<tr>
      								<th scope="row">Waktu Pengajuan</th>
      								<td>:</td>
      								<td><?= date('d-m-Y H:i:s', strtotime($review->tanggal_pengajuan)); ?></td>
    							</tr>
    							<tr>
      								<th scope="row">Catatan</th>
      								<td>:</td>
      								<td><?= $review->catatan_review ?></td>
    							</tr>
    							<tr>
      								<th scope="row">Waktu Review</th>
      								<td>:</td>
      								<td><?= date('d-m-Y H:i:s', strtotime($review->tanggal_catatan)); ?></td>
    							</tr>
							</table>



					</div>
			  	</div>
			</div>
      	</div>
    </div>
</div>