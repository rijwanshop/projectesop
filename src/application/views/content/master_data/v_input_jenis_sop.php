<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="page">
	<div class="page-header">
    	<h1 class="page-title">Jenis SOP</h1>
      	<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
			<li class="breadcrumb-item active">Master</li>
	  	</ol>
      	<div class="page-header-actions">
			<a type="button" class="btn btn-warning" href="<?= site_url('master/jenis_sop') ?>">
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
				  		<h3 class="panel-title"><?=$title?></h3>
					</div>
					<div class="panel-body">
						<div class="alert alert-warning" role="alert">
							<i class="fa fa-info"></i> Tanda <span style="color:red;">*</span> Wajib diisi
						</div>
						<br>
						<div id="pesan"></div>

						<?php if($title == 'Add Jenis SOP'): ?>
							<form class="form-horizontal" id="FrmAjax" action="<?= site_url('master/insert_kategorisop') ?>">
								<div class="form-group row">
					  				<label class="col-md-3 form-control-label">
					  					Nama <span style="color:red;">*</span>
					  				</label>
					  				<div class="col-md-9">
										<input type="text" class="form-control" name="nama"/>
					  				</div>
								</div>
								<div class="form-group row">
					  				<label class="col-md-3 form-control-label">
					  					Status
					  				</label>
					  				<div class="col-md-9">
						  				<div class="radio-custom radio-default radio-inline">
											<input type="radio" id="a" name="status" value="Y" checked />
											<label for="a">Aktif</label>
						  				</div>
						  				<div class="radio-custom radio-default radio-inline">
											<input type="radio" id="n" name="status" value="N"/>
											<label for="n">Nonaktif</label>
						  				</div>
					  				</div>
                    			</div>
								<div class="text-right">
					  				<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</form>
						<?php elseif($title == 'Edit Kategori SOP'): ?>
							<form class="form-horizontal" id="FrmAjax" action="<?= site_url('master/update_kategorisop') ?>">
								<input type="hidden" name="id" value="<?= $kategori->kategori_id ?>"/>
								<div class="form-group row">
					  				<label class="col-md-3 form-control-label">
					  					Nama <span style="color:red;">*</span>
					  				</label>
					  				<div class="col-md-9">
										<input type="text" class="form-control" name="nama" value="<?= $kategori->kategori_nama ?>" />
					  				</div>
								</div>
								<div class="form-group row">
					  				<label class="col-md-3 form-control-label">
					  					Status
					  				</label>
					  				<div class="col-md-9">
						  				<div class="radio-custom radio-default radio-inline">
											<input type="radio" id="a" name="status" value="Y" <?=($kategori->kategori_status == 'Y' ? 'checked' : '')?> />
											<label for="a">Aktif</label>
						  				</div>
						  				<div class="radio-custom radio-default radio-inline">
											<input type="radio" id="n" name="status" value="N" <?=($kategori->kategori_status == 'N' ? 'checked' : '')?>/>
											<label for="n">Nonaktif</label>
						  				</div>
					  				</div>
                    			</div>
								<div class="text-right">
					  				<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</form>
						<?php endif; ?>

					</div>
			  	</div>
			  	<!-- End Panel Summary Mode -->
			</div>
      	</div>
    </div>	
</div>
<script>
	$(document).ready(function(){ 
		$.extend({
        	xResponse: function(url, data){
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

      	$('#FrmAjax').submit(function(e){ 
      		e.preventDefault();
      		$.ajax({ 
				url: $(this).attr('action'),
				type: "POST",
				data: $(this).serialize() + "&<?= $this->security->get_csrf_token_name(); ?>=" + token_csrf(),
                dataType: "JSON",
				success: function(response){
					if(response.success == true){
						location.href = '<?= site_url('master/jenis_sop'); ?>';
					}else{
						$('#pesan').show().html(response.message);
						$('#pesan').fadeOut(5000);
					}	
				}
			});
      	});
	});
</script>