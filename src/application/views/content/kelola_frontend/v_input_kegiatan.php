<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datepicker/datepicker3.css"/>
<div class="page">
	<div class="page-header">
    	<h1 class="page-title">Kegiatan</h1>
      	<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
			<li class="breadcrumb-item active">Front End</li>
	  	</ol>
      	<div class="page-header-actions">
			<a type="button" class="btn btn-warning" href="<?= site_url('front/kegiatan')?>">
				<i class="icon wb-arrow-left" aria-hidden="true"></i> Back
			</a>
      	</div>
    </div>
    <div class="page-content container-fluid">
    	<div class="row">
    		<div class="col-lg-12">
    			<div class="panel">

    				<div class="panel-heading">
				  		<h3 class="panel-title">
				  			<?=$title?>
				  		</h3>
					</div>
					<div class="panel-body">
						<div class="alert alert-warning" role="alert">
							<i class="fa fa-info"></i> Tanda <span style="color:red;">*</span> wajib diisi
						</div>
						<br>
						<div id="pesan"></div>
						<?php if($title == 'Add Kegiatan'): ?>

						<form class="form-horizontal" id="FrmAjax" action="<?= site_url('front/insert_kegiatan') ?>" enctype="multipart/form-data">
							<div class="form-group row">
					  			<label class="col-md-3 form-control-label">Kategori</label>
					  			<div class="col-md-9">
									<select class="form-control" name="kategori">
										<option value="Kat1">Kat1</option>
										<option value="Kat2">Kat2</option>
									</select>
					  			</div>
							</div>
							<div class="form-group row">
					  			<label class="col-md-3 form-control-label">
					  				Nama <span style="color:red;">*</span>
					  			</label>
					  			<div class="col-md-6">
									<input type="text" class="form-control" name="nama"/>
									<small class="form-text text-muted">Minimal 5 karakter</small>
					  			</div>
					  			<div class="col-md-3">
					  				<input type="text" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" autocomplete="off">
					  			</div>
							</div>
							<div class="form-group row">
					  			<label class="col-md-3 form-control-label">
					  				Isi <span style="color:red;">*</span>
					  			</label>
					  			<div class="col-md-9">
									<textarea id="editor" class="ckeditor" name="isi"></textarea> 
					  			</div>
							</div>
							<div class="form-group row">
					  			<label class="col-md-3 form-control-label">
					  				Gambar <span style="color:red;">*</span>
					  			</label>
					  			<div class="col-md-6">
									<input type="file" class="form-control" name="fileupload" id="imgInp"/>
									<small class="form-text text-muted">Format .jpg, .jpeg, atau .png (max 2 MB)</small>
					  			</div>		
							</div>
							<div class="form-group row">
								<label class="col-md-3 form-control-label"></label>
								<div class="col-md-5">
									<img src="#" style="display: none;" width="200" height="200" id="blah" alt="preview">
					  			</div>
							</div>
							<div class="text-right">
					  			<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</form>

						<?php elseif($title == 'Edit Kegiatan'): ?>

						<form class="form-horizontal" id="FrmAjax" action="<?= site_url('front/update_kegiatan') ?>" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?= $kegiatan->kegiatan_id ?>"/>
							<div class="form-group row">
					  			<label class="col-md-3 form-control-label">Kategori</label>
					  			<div class="col-md-9">
									<select class="form-control" name="kategori" id="kategori">
										<option value="Kat1">Kat1</option>
										<option value="Kat2">Kat2</option>
									</select>
					  			</div>
							</div>
							<div class="form-group row">
					  			<label class="col-md-3 form-control-label">
					  				Nama <span style="color:red;">*</span>
					  			</label>
					  			<div class="col-md-6">
									<input type="text" class="form-control" name="nama" value="<?= $kegiatan->kegiatan_nama ?>" />
									<small class="form-text text-muted">Minimal 5 karakter</small>
					  			</div>
					  			<div class="col-md-3">
					  				<input type="text" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" autocomplete="off"  value="<?= set_date_value($kegiatan->kegiatan_tanggal) ?>">
					  			</div>
							</div>
							<div class="form-group row">
					  			<label class="col-md-3 form-control-label">
					  				Isi <span style="color:red;">*</span>
					  			</label>
					  			<div class="col-md-9">
									<textarea id="editor" class="ckeditor" name="isi"><?= $kegiatan->kegiatan_desc ?></textarea> 
					  			</div>
							</div>
							<div class="form-group row">
					  			<label class="col-md-3 form-control-label">
					  				Gambar
					  			</label>
					  			<div class="col-md-6">
									<input type="file" class="form-control" name="fileupload" id="imgInp"/>
									<small class="form-text text-muted">Format .jpg, .jpeg, atau .png (max 2 MB)</small>
					  			</div>		
							</div>
							<div class="form-group row">
								<label class="col-md-3 form-control-label"></label>
								<div class="col-md-5">
									<?php if($kegiatan->kegiatan_gambar != ''): ?>
										<img src="<?= base_url().'assets/media/kegiatan/'.$kegiatan->kegiatan_gambar ?>" width="200" height="200" id="blah" alt="preview">
									<?php else: ?>
										<img src="#" style="display: none;" width="200" height="200" id="blah" alt="preview">
									<?php endif;?>
					  			</div>
							</div>
							<div class="text-right">
					  			<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</form>

						<?php endif; ?>
					</div>
    			</div>
    		</div>
      	</div>
  	</div>
</div>
<script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<script src="<?= base_url();?>assets/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript">  
	$(document).ready(function(){ 
		CKEDITOR.replace('editor');

		$('#tanggal').datepicker({
			format: 'dd-mm-yyyy',
			 autoclose: true
		});

		<?php if($title == 'Edit Kegiatan'): ?>
			$('#kategori').val('<?= $kegiatan->kegiatan_kategori ?>');
		<?php endif; ?>	

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

      	function readURL(input) {
  			if (input.files && input.files[0]){
    			var reader = new FileReader();
    
    			reader.onload = function(e){
    				$('#blah').show();
      				$('#blah').attr('src', e.target.result);
    			}
    			reader.readAsDataURL(input.files[0]); // convert to base64 string
  			}
		}
		$("#imgInp").change(function() {
  			readURL(this);
		});

		$('#FrmAjax').submit(function(e){ 
      		e.preventDefault();
      		for ( instance in CKEDITOR.instances ) {
				CKEDITOR.instances[instance].updateElement();
			}
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
						location.href = '<?= site_url('front/kegiatan'); ?>';
					}else{
						$('#pesan').show().html(response.message);
						$('#pesan').fadeOut(5000);
					}	
				}
			});
      	});
	});
</script>