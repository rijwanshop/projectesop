<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page">
	<div class="page-header">
      <h1 class="page-title">Panduan Teknis Sistem</h1>
      <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
		<li class="breadcrumb-item active">Master</li>
	  </ol>
      <div class="page-header-actions">
		<a type="button" class="btn btn-warning" href="<?= site_url('master/panduan_teknis')?>">
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
					<?php if($title == 'Add Panduan Teknis'): ?>
						<form class="form-horizontal" id="FrmAjax" action="<?= site_url('master/insert_panduan_teknis') ?>" enctype="multipart/form-data">
							<div class="form-group row">
					  			<label class="col-md-3 form-control-label">
					  				Judul <span style="color:red;">*</span>
					  			</label>
					  			<div class="col-md-6">
									<input type="text" class="form-control" name="judul" />
					  			</div>
							</div>
							<div class="form-group row">
					  			<label class="col-md-3 form-control-label">File</label>
					  			<div class="col-md-6">
									<input type="file" class="form-control" name="file"/>
									<small class="form-text text-muted">Format file .pdf max 3 MB</small>
					  			</div>
							</div>
							<div class="form-group row">
					  			<label class="col-md-3 form-control-label">Link Youtube</label>
					  			<div class="col-md-6">
									<input type="text" class="form-control" name="link"/>
									<small class="form-text text-muted">Contoh link yang benar https://www.youtube.com/embed/6RdqnSXekb0</small>
					  			</div>
							</div>
							<div class="form-group row">
					  			<small style="color:red">- Jika yang diupload file .pdf maka kosongkan Link Youtube<br>
					  			- Jika ingin menampilkan Video Youtube maka isi Link Youtube</small>
							</div>
							<div class="text-right">
					  			<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</form>
					<?php elseif($title == 'Edit Pertanyaan'): ?>

					<?php endif; ?>





				</div>
			  </div>
			  
			  
			  <!-- End Panel Summary Mode -->
			</div>
		
      </div>
    </div>
	
	
  </div>
 <script type="text/javascript">  
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
						location.href = '<?= site_url('master/panduan_teknis'); ?>';
					}else{
						$('#pesan').show().html(response.message);
						$('#pesan').fadeOut(5000);
					}	
				}
			});
      	});
	});
</script>