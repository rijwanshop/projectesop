<link rel="stylesheet" href="<?=base_url()?>assets/plugins/select2/select2.css" />
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
			<a type="button" class="btn btn-warning" href="<?= $back_link ?>">
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
						<?php if($review == false): ?>
							<div class="alert alert-danger" role="alert">
  								Anda harus memberikan catatan terlebih dahulu sebelum mengajukan review lanjutan 
							</div>
						<?php else: ?>
							<div class="alert alert-warning" role="alert">
  								Field Jabatan harus terisi sebelum melakukan submit
							</div>

						<?php endif; ?>
						<div class="col-lg-12">
							<form class="form-horizontal" id="form-review">
							
								<input type="hidden" name="alias" value="<?= $sop->row()->sop_alias ?>">
								<div class="form-group row">
    								<label for="nama_sop" class="col-sm-2 col-form-label">
    									Nama SOP
    								</label>
    								<div class="col-sm-8">
      									<input type="text" name="nama_sop" class="form-control" value="<?= strtoupper($sop->row()->sop_nama) ?>" readonly />
    								</div>
  								</div>
  								<div class="form-group row">
    								<label for="nama_sop" class="col-sm-2 col-form-label">
    									Tanggal Penyusunan
    								</label>
    								<div class="col-sm-4">
      									<input type="text" class="form-control" value="<?= $sop->row()->sop_tgl_pembuatan ?>" readonly />
    								</div>
  								</div>
								<div class="form-group row">
    								<label for="preview" class="col-sm-2 col-form-label">
    									Reviewer <span style="color: red;">*</span>
    								</label>
    								<div class="col-sm-5">
      									<select class="form-control select2" id="preview">
      										<option value="">-- Pilih --</option>
      										<?php foreach($list_review as $row): ?>
      											<option value="<?= $row['nipbaru'] ?>">
      												<?= $row['nama_pegawai'].' - '.$row['nipbaru'] ?>		
      											</option>
      										<?php endforeach; ?>
      									</select>
    								</div>
  								</div>
  								<input type="hidden" name="nama_reviewer" id="nama_reviewer" />
  								<input type="hidden" name="nip_reviewer" id="nip_reviewer" />
  								<div class="form-group row">
    								<label for="nama_sop" class="col-sm-2 col-form-label">
    									Jabatan <span style="color: red;">*</span>
    								</label>
    								<div class="col-sm-8">
      									<textarea name="jabatan" id="jabatan" class="form-control" row="2" readonly></textarea>
      									<small class="form-text text-muted">Terisi otomatis setelah anda memilih Reviewer</small>
    								</div>
  								</div>
  								<div class="form-group row">
    								<div class="offset-md-2 col-md-10">
      									<button type="submit" class="btn btn-primary">Submit</button>
    								</div>
  								</div>
							
							</form>
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

		$('.select2').select2();
		$('.select2').on("select2:select", function(e){ 
			var value = $(this).find('option:selected').val();
			if(value != ''){
				$.ajax({ 
					url: '<?= site_url('pengolahan_sop/get_jabatan_review') ?>',
     				data: {'nipbaru':value},
     				dataType: 'json',
     				type: 'GET',
     				success: function(response){
     					$('#nama_reviewer').val(response.nama);
     					$('#nip_reviewer').val(response.nip);
     					$('#jabatan').val(response.jabatan);
     				}
				});
			}else{
				$('#nama_reviewer').val('');
     			$('#nip_reviewer').val('');
     			$('#jabatan').val('');
			}
		});

		<?php if($review == false): ?>
			$("#preview").prop('disabled',true);
		<?php endif; ?>


		$('#form-review').submit(function(e){
			e.preventDefault();
			var data = $(this).serializeArray(); 
			data.push({name: "<?= $this->security->get_csrf_token_name(); ?>", value: token_csrf()});
			$.ajax({ 
				url: '<?= site_url('pengolahan_sop/insert_review') ?>',
				type: "POST",
				data: data,
				dataType: 'json',
				success: function(response){
					if(response.success == true)
						window.location = '<?= $back_link ?>';
					else{
						$('#message').show().html(response.message);
						$('#message').fadeOut(4000);
					}
				}
			});
		});
	});
</script>