<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<div class="page" style="max-width: 1300px;">
	<div class="page-header">
    	<h1 class="page-title"><?=$title?></h1>
      	<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
			<li class="breadcrumb-item active">SOPpp</li>
	  	</ol>
      	<div class="page-header-actions">
			<a type="button" class="btn btn-warning" href="<?= $back_link; ?>">
				<i class="icon wb-arrow-left" aria-hidden="true"></i> Back
			</a>
      	</div>
    </div>	
    <div class="page-content container-fluid">
    	<div class="row">
			<div class="col-lg-12">
			  
				<div class="panel">
					<div class="panel-heading">
				  		<div style="float:right; padding:10px">
							<a type="button" class="btn btn-danger" href="<?= site_url('exportpdf/print_sop/'.enkripsi_id_url($sop->row()->sop_alias)) ?>" target="_blank">
								<i class="fa fa-file-text"></i> Print PDF
							</a>
				  		</div>
				  		<div style="float:right; padding:10px">
							<a type="button" class="btn btn-primary" href="<?= site_url('exportword/cetak_sop/'.enkripsi_id_url($sop->row()->sop_alias)) ?>" target="_blank">
								<i class="fa fa-file"></i> Print Doc
							</a>
				  		</div>
				  		<div style="clear:both"></div>
					</div>
					<div class="panel-body">
						
						<?php $this->load->view('content/sop/header_detail'); ?>

						<?php if($sop->row()->sop_update_file == ''): ?>
							<?php $this->load->view('content/sop/kegiatan_detail'); ?>
							
							<?php if($list_singkatan->num_rows() > 0): ?>
								<br><br>
								<table class="table table-striped">
									<thead>
										<tr>
											<th colspan="3">Keterangan</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($list_singkatan->result() as $row): ?>
											<tr>
												<td><?= $row->singkatan; ?></td>
												<td>:</td>
												<td><?= $row->nama_jabatan; ?>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							<?php endif; ?>
						<?php else: ?>
							<br><br>
							<h4>Lampiran: </h4>
							<?php if($file_draft != ''): ?>
								<ul>
									<li><?= $file_pdf ?></li>
									<li><?= $file_draft ?></li>
								</ul>

							<?php else: ?>
								<?= $file_pdf ?>
							<?php endif; ?>

						<?php endif;?>

					</div>
			  	</div>
			</div>
      	</div>
    </div>
</div>
