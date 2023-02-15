<link rel="stylesheet" href="<?=base_url()?>assets/plugins/select2/select2.css" />
<div class="page" style="max-width: 1300px;">
	<div class="page-header">
    	<h1 class="page-title"><?=$title?></h1>
      	<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="<?= site_url('dashboard') ?>">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">User</li>
	  	</ol>
      	<div class="page-header-actions">
			<a type="button" class="btn btn-warning" href="<?= site_url('admin') ?>">
				<i class="icon wb-arrow-left" aria-hidden="true"></i> Back
			</a>
      </div>
    </div>

    <div class="page-content container-fluid">
      	<div class="row">
			<div class="col-lg-12">
			  	<div class="panel">
					<div class="panel-body">
						
						<div id="message"></div>
						<div class="col-lg-12">
							<?php if($title == 'Tambah User Operasional SOP'): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <i class="fa fa-info-circle"></i>&nbsp;
                  Anda tidak perlu menambahkan user Penyusun, Reviewer, dan Pengesah karena sudah diregistrasi otomatis dengan akun SSO
                </div>
							<form class="form-horizontal" id="form-user">
								<div class="form-group row">
    								<label for="nama_sop" class="col-sm-2 col-form-label">
    									NIP SSO <span style="color: red;">*</span>
    								</label>
    								<div class="col-sm-4">
      									<input type="text" name="niplama" id="niplama" class="form-control" />
    								</div>
  								</div>
  								<div class="form-group row">
    								<label for="tanggal_pembuatan_sop" class="col-sm-2 col-form-label">
    									Nama Pengguna
    								</label>
    								<div class="col-sm-8">
      									<input type="text" name="nama_pengguna" id="nama_pengguna" class="form-control" />
    								</div>
  								</div>	
  								<div class="form-group row">
    								<label for="catatan_review" class="col-sm-2 col-form-label">
    									Jabatan
    								</label>
    								<div class="col-sm-8">
      									<textarea name="jabatan" id="jabatan" class="form-control" rows="4"></textarea>
    								</div>
  								</div>
  								<div class="form-group row">
    								<label for="tanggal_pembuatan_sop" class="col-sm-2 col-form-label">
    									Role User <span style="color: red;">*</span>
    								</label>
    								<div class="col-sm-3">
      									<select class="form-control" name="grup" id="grup">
      										<option value="">-- Pilih --</option>
      										<?php foreach($grup->result() as $row): ?>
      											<option value="<?= $row->user_group_id ?>"><?= $row->user_group_name ?></option>
      										<?php endforeach; ?>
      									</select>
    								</div>
  								</div>
  								<div class="form-group row">
    								<div class="offset-md-2 col-md-10">
      									<button type="submit" class="btn btn-primary">Submit</button>
    								</div>
  								</div>
							
							</form>
							<?php elseif($title=='Edit User Operasional SOP'): ?>
								<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  					<i class="fa fa-info-circle"></i> &nbsp;
                  					Anda tidak perlu menambahkan user Penyusun, Reviewer, dan Pengesah karena sudah diregistrasi otomatis dengan akun SSO
                				</div>
								<form class="form-horizontal" id="form-user">
									<input type="hidden" name="idpengguna" id="idpengguna" value="<?= $pengguna->idpengguna ?>" />
								<div class="form-group row">
    								<label for="nama_sop" class="col-sm-2 col-form-label">
    									NIP SSO <span style="color: red;">*</span>
    								</label>
    								<div class="col-sm-4">
      									<input type="text" name="niplama" id="niplama" class="form-control" value="<?= $pengguna->niplama ?>" />
    								</div>
  								</div>
  								<div class="form-group row">
    								<label for="tanggal_pembuatan_sop" class="col-sm-2 col-form-label">
    									Nama Pengguna
    								</label>
    								<div class="col-sm-8">
      									<input type="text" name="nama_pengguna" id="nama_pengguna" class="form-control" value="<?= $pengguna->nama_pengguna ?>" />
    								</div>
  								</div>	
  								<div class="form-group row">
    								<label for="catatan_review" class="col-sm-2 col-form-label">
    									Jabatan
    								</label>
    								<div class="col-sm-8">
      									<textarea name="jabatan" id="jabatan" class="form-control" rows="4"><?= $pengguna->jabatan ?></textarea>
    								</div>
  								</div>
  								<div class="form-group row">
    								<label for="tanggal_pembuatan_sop" class="col-sm-2 col-form-label">
    									Role User <span style="color: red;">*</span>
    								</label>
    								<div class="col-sm-3">
      									<select class="form-control" name="grup" id="grup">
      										<option value="">-- Pilih --</option>
      										<?php foreach($grup->result() as $row): ?>
      											<option value="<?= $row->user_group_id ?>"><?= $row->user_group_name ?></option>
      										<?php endforeach; ?>
      									</select>
    								</div>
  								</div>
  								<div class="form-group row">
    								<div class="offset-md-2 col-md-10">
      									<button type="submit" class="btn btn-primary">Submit</button>
    								</div>
  								</div>
							
							</form>
							<?php endif; ?>
						</div>
					</div>
			  	</div>
			</div>
      	</div>
    </div>
</div>
<script src="<?= base_url(); ?>assets/plugins/select2/select2.js"></script>
<script>
	$(document).ready(function(){
		<?php if($title=='Edit User Operasional SOP'): ?>
			$('#grup').val('<?= $pengguna->idgroup; ?>');
		<?php endif;?>
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
		
		$('#form-user').submit(function(e){
			e.preventDefault();
			var data = $(this).serializeArray(); 
			data.push({name: "<?= $this->security->get_csrf_token_name(); ?>", value: token_csrf()});
			$.ajax({ 
				url: '<?= $link ?>',
				type: "POST",
				data: data,
				dataType: 'json',
				success: function(response){
					if(response.success == true)
						window.location = '<?= site_url('admin') ?>';
					else{
						$('#message').show().html(response.message);
						$('#message').fadeOut(4000);
					}
				}
			});
		});
	});
</script>