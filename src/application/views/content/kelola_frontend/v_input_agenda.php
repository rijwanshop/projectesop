<div class="page">
	<div class="page-header">
    	<h1 class="page-title">Agenda</h1>
      	<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
			<li class="breadcrumb-item active">Front End</li>
	  	</ol>
      	<div class="page-header-actions">
			<a type="button" class="btn btn-warning" href="<?=site_url('front/agenda')?>">
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
							<i class="fa fa-info"></i> Tanda <span style="color:red;">*</span> Wajib diisi
						</div>
						<br>
						<div id="pesan"></div>
						<?php if($title == 'Add Agenda'): ?>
							<form class="form-horizontal" id="FrmAjax" action="<?= site_url('front/insert_agenda') ?>">
								<div class="form-group row">
					  				<label class="col-md-3 form-control-label">Nama</label>
					  				<div class="col-md-9">
										<input type="text" class="form-control" name="nama"/>
										<small class="form-text text-muted">Hanya boleh menggunakan huruf dan spasi (min. 5 karakter)</small>
					  				</div>
								</div>
								<div class="form-group row">
					  				<label class="col-md-3 form-control-label">Isi</label>
					  				<div class="col-md-9">
										<textarea id="editor" class="ckeditor" name="isi"></textarea>
					  				</div>
								</div>
								<div class="text-right">
					  				<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</form>
						<?php elseif($title == 'Edit Agenda'): ?>
							<form class="form-horizontal" id="FrmAjax" method="post" action="<?= site_url('front/update_tentang_kami') ?>">
				  			<input type="hidden" name="id" value="<?= $konten->content_id ?>"/>
				  			<div class="form-group row">
					  			<label class="col-md-3 form-control-label">
					  				Nama <span style="color:red;">*</span>
					  			</label>
					  			<div class="col-md-9">
									<input type="text" class="form-control" name="nama" value="<?= $konten->content_nama ?>"/>
									<small class="form-text text-muted">Hanya boleh menggunakan huruf dan spasi (min. 5 karakter)</small>
					  			</div>
							</div>
							<div class="form-group row">
					  			<label class="col-md-3 form-control-label">Isi</label>
					  			<div class="col-md-9">
									<textarea id="editor" class="ckeditor" name="isi"><?= $konten->content_isi ?></textarea> 
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
<script type="text/javascript">
	$(document).ready(function(){ 
		CKEDITOR.replace( 'editor' );  

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
      		for ( instance in CKEDITOR.instances ) {
				CKEDITOR.instances[instance].updateElement();
			}
      		$.ajax({ 
				url: $(this).attr('action'),
				type: "POST",
				data: $(this).serialize() + "&<?= $this->security->get_csrf_token_name(); ?>=" + token_csrf(),
                dataType: "JSON",
				success: function(response){
					if(response.success == true){
						location.href = '<?= site_url('front/agenda'); ?>';
					}else{
						$('#pesan').show().html(response.message);
						$('#pesan').fadeOut(5000);
					}	
				}
			});
      	});
	});
</script>