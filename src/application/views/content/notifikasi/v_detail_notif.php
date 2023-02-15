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
			<li class="breadcrumb-item active">Pemberitahuan</li>
	  	</ol>
      	<div class="page-header-actions">
			<a type="button" class="btn btn-warning" href="<?= site_url('notifikasi') ?>">
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
      							<th scope="row" style="width: 19%;">Nama Pengirim</th>
      								<td style="width: 1%;">:</td>
      								<td style="width: 80%;"><?= $notif->nama_pengirim ?></td>
    							</tr>
                  <tr>
                      <th scope="row">NIP Pengirim</th>
                      <td>:</td>
                      <td><?= $notif->nip_pengirim ?></td>
                  </tr>
                  <tr>
                      <th scope="row">Nama Penerima</th>
                      <td>:</td>
                      <td><?= $notif->nama_penerima ?></td>
                  </tr>
                  <tr>
                      <th scope="row">NIP Penerima</th>
                      <td>:</td>
                      <td><?= $notif->nip_penerima ?></td>
                  </tr>
    							<tr>
      								<th scope="row">Waktu</th>
      								<td>:</td>
      								<td><?= date('d-m-Y H:i:s', strtotime($notif->waktu)); ?></td>
    							</tr>
                  <tr>
                      <th scope="row">Perihal</th>
                      <td>:</td>
                      <td><?= $notif->jenis_notif ?></td>
                  </tr>
                  <tr>
                      <th scope="row">Aktivitas</th>
                      <td>:</td>
                      <td><?= $notif->aktivitas ?></td>
                  </tr>
                  <tr>
                      <th scope="row">Status</th>
                      <td>:</td>
                      <td><?= $notif->status_baca ?></td>
                  </tr>
							</table>



					</div>
			  	</div>
			</div>
      	</div>
    </div>
</div>