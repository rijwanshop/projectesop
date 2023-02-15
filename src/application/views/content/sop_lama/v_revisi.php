<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
?>			
<div class="page" style="max-width: 1300px;">
	<div class="page-header">
    	<h1 class="page-title"><?=$title?></h1>
      	<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= site_url('dashboard')?>">Dashboard</a></li>
			<li class="breadcrumb-item active">SOP</li>
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
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form class="form-horizontal" id="FrmAjax">
									<input type="hidden" name="alias" value="<?= $sop->row()->sop_alias; ?>"/>
									<div class="Errors"></div>
									<div class="form-group row">
										<label class="col-md-2 form-control-label">
											Catatan dilakukan revisi
										</label>
									  	<div class="col-md-6">
											<textarea type="text" class="form-control" name="catatan" rows="3"></textarea>
									  	</div>
									</div>
									<div class="text-right col-md-8">
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<?php $this->load->view('content/sop/header_detail'); ?>

						<?php if($sop->row()->sop_update_file == ''): ?>
							<?php $this->load->view('content/sop/kegiatan_detail'); ?>
						<?php endif; ?>

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
					</div>
			  	</div>
			</div>
      	</div>
    </div>
</div>

<script>
	$(document).ready(function(){
		$.extend({
			xResponse: function(url, data) {
			var theResponse = null;
			$.ajax({
				url: url,
				type: 'GET',
				dataType: "JSON",
				async: false,
				success: function(respText) {
					theResponse = respText;
				}
			});
			return theResponse;
			}
		});
		function token_csrf(){
			var csrf = $.xResponse('<?= site_url('pengolahan_sop/get_csrf') ?>', {issession: 1,selector: true});
			return csrf;
		}

		$("#FrmAjax").on('submit',(function(e){
			e.preventDefault();
			var data = $(this).serializeArray(); 
    		data.push({name: "<?= $this->security->get_csrf_token_name(); ?>", value: token_csrf()});

			$.ajax({
				url: "<?= site_url('act_sop/add_revisi') ?>", 
				type: "POST",             
				data: data, 
				success: function(data){
					if(data == '1'){
						location.href="<?= $back_link; ?>"
					}else{
						  $('.Errors').html('<div class="errors alert alert-danger alert-dismissible"><button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button><p>Errors : </p>'+data+'</div>');
					}
				}
				});
			}));

	});
</script>