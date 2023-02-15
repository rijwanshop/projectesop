<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="page">
	<div class="page-header">
    	<h1 class="page-title">Slide</h1>
      	<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
			<li class="breadcrumb-item active">Front End</li>
	  	</ol>
      	<div class="page-header-actions">
			<a type="button" class="btn btn-warning" href="<?= site_url('front/slide')?>">
				<i class="icon wb-arrow-left" aria-hidden="true"></i> Back
			</a>
      	</div>
    </div>
    <div class="page-content container-fluid">
      <div class="row">
			<div class="col-lg-12">
				<div class="panel">
					<div class="panel-heading">
				  		<h3 class="panel-title"><?=$title?></h3>
					</div>
					<div class="panel-body">

						<?php if($title == 'Add Slide'): ?>
							<form class="form-horizontal" id="form-input" action="<?= site_url('front/insert_slide') ?>" enctype="multipart/form-data">
								<div id="pesan"></div>
								<div class="form-group row">
					  				<label class="col-md-3 form-control-label">
					  					Judul <span style="color:red;">*</span>
					  				</label>
					  				<div class="col-md-6">
										<input type="text" class="form-control" name="judul" id="judul" />
					  				</div>
								</div>
								<div class="form-group row">
					  				<label class="col-md-3 form-control-label">Isi</label>
					  				<div class="col-md-6">
										<textarea class="form-control" name="isi"></textarea>
					  				</div>
								</div>
								<div class="form-group row">
					  				<label class="col-md-3 form-control-label">
					  					Gambar <span style="color:red;">*</span>
					  				</label>
					  				<div class="col-md-6">
										<input type="file" class="form-control" name="fileupload" id="fileupload"/>
										<small class="form-text text-muted">Format .jpg, .jpeg, atau .png (max 2 MB)</small>
					  				</div>
								</div>
								<div class="form-group row">
					  				<label class="col-md-3 form-control-label"></label>
					  				<div class="col-md-6">
										<img id="blah" src="#" alt="your image" width="100" height="100" style="display:none;" />   
					  				</div>
								</div>
								<div class="text-right">
					  				<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</form>

						<?php elseif($title == 'Edit Slide'): ?>
							<form class="form-horizontal" id="form-input" action="<?= site_url('front/update_slide') ?>" enctype="multipart/form-data">
								<div id="pesan"></div>
								<input type="hidden" name="id" value="<?= $slide->slide_id ?>">
								<div class="form-group row">
					  				<label class="col-md-3 form-control-label">
					  					Judul <span style="color:red;">*</span>
					  				</label>
					  				<div class="col-md-6">
										<input type="text" class="form-control" name="judul" id="judul" value="<?= $slide->slide_judul ?>" />
					  				</div>
								</div>
								<div class="form-group row">
					  				<label class="col-md-3 form-control-label">Isi</label>
					  				<div class="col-md-6">
										<textarea class="form-control" name="isi"><?= $slide->slide_isi ?></textarea>
					  				</div>
								</div>
								<div class="form-group row">
					  				<label class="col-md-3 form-control-label">
					  					Gambar
					  				</label>
					  				<div class="col-md-6">
										<input type="file" class="form-control" name="fileupload" id="fileupload"/>
										<small class="form-text text-muted">Format .jpg, .jpeg, atau .png (max 2 MB)</small>
					  				</div>
								</div>
								<div class="form-group row">
					  				<label class="col-md-3 form-control-label"></label>
					  				<div class="col-md-6">
					  					<?php if(file_exists('./assets/media/slide/'.$slide->slide_gambar)): ?>
                                            <img id="blah" src="<?= base_url().'assets/media/slide/'.$slide->slide_gambar ?>" alt="your image" width="150" height="150" />
                                        <?php else: ?>
                                            <img id="blah" src="#" alt="your image" width="100" height="100" style="display:none;" /> 
                                        <?php endif; ?>  
					  				</div>
								</div>
								<div class="text-right">
					  				<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</form>
						<?php endif;?>

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

		function readURL(input){
        	if (input.files && input.files[0]){
            	var reader = new FileReader();
            	reader.onload = function(e) {
                	$('#blah').show();
                	$('#blah').attr('src', e.target.result);
            	}
            	reader.readAsDataURL(input.files[0]);
        	}
    	}

    	$("#fileupload").change(function() {
        	readURL(this);
    	});

    	$('#form-input').submit(function(e){
    		e.preventDefault();

    		$("button[type='submit']").prop('disabled', true);
         	$("button[type='submit']").html('<i class="fa fa-spinner"></i> Proses');

    		var formData = new FormData(this);
    		formData.append('<?= $this->security->get_csrf_token_name(); ?>', token_csrf());

    		$.ajax({ 
            	url: $(this).attr('action'),
            	type: "POST",
            	data: formData,
            	contentType: false,
            	cache: false,
            	processData: false,
            	dataType: "JSON",
            	success: function(response){
               		if(response.success == true){
                  		window.location = '<?= site_url('front/slide'); ?>';
               		}else{
                  		$("button[type='submit']").prop('disabled', false);
                  		$("button[type='submit']").html('Submit');
                  		$('#pesan').show().html(response.message);
                  		$('#pesan').fadeOut(5000);
               		}  
            	}
         	});
    	});

	});
</script>