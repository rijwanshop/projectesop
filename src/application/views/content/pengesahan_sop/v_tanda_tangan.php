<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css" />
<div class="page" style="max-width: 1300px;">
	<div class="page-header">
    	<h1 class="page-title"><?=$title?></h1>
      <ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="<?=base_url()?>dashboard">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">SOP</li>
	  	</ol>
   </div>
   <div class="page-content container-fluid">
      <div class="row">
			<div class="col-lg-12">
			  	<div class="panel">
					<div class="panel-body">
						<div id="message"></div>

						<div class="col-lg-12">

							<a href="#" id="preview" class="btn btn-primary">
								Preview PDF SOP
							</a>
							<br>
							<br>
							<form class="form-horizontal" method="post" id="form-review">

								<input type="hidden" name="id" id="id" value="<?= $id ?>">
								<input type="hidden" name="alias" id="alias" value="<?= $sop->row()->sop_alias; ?>">
								<div class="form-group row">
    								<label for="nama_sop" class="col-sm-2 col-form-label">
    									Nama SOP
    								</label>
    								<div class="col-sm-8">
      								<input type="text" class="form-control" value="<?= strtoupper($sop->row()->sop_nama) ?>" readonly />
    								</div>
  								</div>
  								<div class="form-group row">
    								<label for="tanggal_pembuatan_sop" class="col-sm-2 col-form-label">
    									Tanggal Penyusunan
    								</label>
    								<div class="col-sm-4">
      								<input type="text" class="form-control" value="<?= $sop->row()->sop_tgl_pembuatan ?>" readonly />
    								</div>
  								</div>
  								<div class="form-group row">
    								<label for="tanggal_pembuatan_sop" class="col-sm-2 col-form-label">
    									Nama Pengesah
    								</label>
    								<div class="col-sm-5">
      								<input type="text" class="form-control" value="<?= $sop->row()->sop_disahkan_nama ?>" readonly />
    								</div>
  								</div>
  								<div class="form-group row">
    								<label for="tanggal_pembuatan_sop" class="col-sm-2 col-form-label">
    									NIP Pengesah
    								</label>
    								<div class="col-sm-4">
      								<input type="text" class="form-control" value="<?= $sop->row()->sop_disahkan_nip ?>" readonly />
    								</div>
  								</div>	
  								<div class="form-group row">
    								<label for="tanggal_pembuatan_sop" class="col-sm-2 col-form-label">
    									NIK Pengesah
    								</label>
    								<div class="col-sm-4">
      								<input type="text" name="nik" id="nik" class="form-control" value="<?= $this->session->userdata('nik') ?>" readonly />
    								</div>
  								</div>
  								<div class="form-group row">
    								<label for="tanggal_pembuatan_sop" class="col-sm-2 col-form-label">
    									Pass phrase TTE <span style="color: red;">*</span>
    								</label>
    								<div class="col-sm-4">
      								<input type="password" name="passphrase" id="passphrase" class="form-control" placeholder="Pass phrase TTE" />
    								</div>
  								</div>

                        <?php if($sop->row()->sop_label == 'sop lama'): ?>
                        <div class="form-group row">
                           <label for="tanggal_pembuatan_sop" class="col-sm-2 col-form-label">
                              Tanggal Penerbitan <span style="color: red;">*</span>
                           </label>
                           <div class="col-sm-2">
                              <input type="text" name="tanggal_penerbitan" id="tanggal_penerbitan" class="form-control datePicker" placeholder="Tanggal Penerbitan" autocomplete="off" />
                           </div>
                        </div>
                        <?php endif; ?>
  								
  								<div class="form-group row">
    								<div class="offset-md-2 col-md-10">
      								<button type="submit" class="btn btn-primary">Submit</button>
      								&nbsp;
      								<a type="button" class="btn btn-warning" href="<?= site_url('pengesah_sop') ?>">
											<i class="icon wb-arrow-left" aria-hidden="true"></i> Kembali
										</a>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 9999;">
   <div class="modal-dialog modal-lg" role="document" style="width:850px;">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Preview PDF SOP</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <embed src="<?= site_url('pengesah_sop/preview_pdf/'.enkripsi_id_url($sop->row()->sop_alias)) ?>#zoom=70&toolbar=0" frameborder="0" width="100%" height="400px">
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>

<script src="<?=base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
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

      $('.datePicker').datepicker({
         autoclose: true,
         format: 'dd-mm-yyyy'
      }); 

		$(document).on('click', 'a#preview', function(e){ 
			e.preventDefault();
         $('#exampleModal').modal('show');
		});
		
		$('#form-review').submit(function(e){
			e.preventDefault();
			var data = $(this).serializeArray(); 
			data.push({name: "<?= $this->security->get_csrf_token_name(); ?>", value: token_csrf()});
			$.ajax({ 
				url: '<?= site_url('pengesah_sop/pengesahan_sop') ?>',
				type: "POST",
				data: data,
				dataType: 'json',
				success: function(response){
					if(response.success == true)
						window.location = '<?= site_url('pengesah_sop') ?>';
					else{
						$("html, body").animate({
        					scrollTop: 0
    					}, 1000);   
						$('#message').show().html(response.message);
						$('#message').fadeOut(4000);
					}
				}
			});
		});
	});
</script>