<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css" />
<div class="page">
	<div class="page-header">
      <h1 class="page-title">Upload Berkas SOP</h1>
      <ol class="breadcrumb">
		   <li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
		   <li class="breadcrumb-item active">SOP</li>
	   </ol>
      <div class="page-header-actions">
		   <a type="button" class="btn btn-warning" href="<?= site_url('kelola_sop/upload_berkas') ?>">
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
                     Silahkan isi semua field sesuai yang tercantum di berkas
                  </div><br>
                  <div id="pesan"></div>

						<?php if($title == 'Input Berkas SOP'): ?>
							<form class="form-horizontal" action="<?= site_url('kelola_sop/insert_sop_upload') ?>" enctype="multipart/form-data">
								<div class="form-group row">
									<div class="form-group col-md-4">
                        		<label class="form-control-label">
                        			Satuan Organisasi <span style="color:red;">*</span>
                        		</label>
                        		<select class="form-control" id="satker" name="satker">
											<option value="">-- Pilih --</option>
										</select>
										<input type="hidden" name="nm_satker" id="nm_satker" />
                      		</div>
                      		<div class="form-group col-md-4">
                        		<label class="form-control-label">
                        			Unit Kerja
                        		</label>
                        		<select class="form-control" id="unitkerja" name="unitkerja">
										    <option value="">-- Pilih --</option>
										</select>
										<input type="hidden" name="nm_unit" id="nm_unit" />
                      		</div>
					  				<div class="form-group col-md-4">
                        		<label class="form-control-label">
                        			Unit Kerja 2
                        		</label>
                        		<select class="form-control" id="bagian" name="bagian">
											 <option value="">-- Pilih --</option>
										</select>
										<input type="hidden" name="nm_bagian" id="nm_bagian" />
                      		</div>
								</div>
                        <div class="form-group row">
                           <div class="form-group col-md-2">
                              <label class="form-control-label">
                                 No SOP <span style="color:red;">*</span>
                              </label>
                              <input type="text" class="form-control" name="no_sop" id="no_sop" />
                              <small class="form-text text-muted">
                                 Format nomor/tahun
                              </small>
                           </div>
                           <div class="form-group col-md-10">
                              <label class="form-control-label">Nama SOP <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="namasop">
                           </div>
                        </div>

								<div class="form-group row">
                           <div class="form-group col-md-3">
                              <label class="form-control-label">
                                 Tanggal Penerbitan <span style="color:red;">*</span>
                              </label>
                               <input type="text" name="tanggal_penerbitan" id="tanggal_penerbitan" class="form-control datePicker" placeholder="Tanggal Penerbitan" autocomplete="off" />
                           </div>
                      		<div class="form-group col-md-6">
                        		<label class="form-control-label">
                                 File Upload <span style="color:red;">*</span>
                              </label>
                        		<input type="file" class="form-control" name="fileupload"/>
                              <small class="form-text text-muted">
                                 Format .pdf max 5 MB
                              </small>
                      		</div>
								</div>
								<div class="text-right">
					  				<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</form>
						<?php elseif($title == 'Edit Berkas SOP'): ?>
                     <form class="form-horizontal" action="<?= site_url('kelola_sop/update_sop_upload') ?>" enctype="multipart/form-data">
                        <input type="hidden" name="alias" value="<?= $sop->sop_alias ?>"/>
                        <div class="form-group row">
                           <div class="form-group col-md-4">
                              <label class="form-control-label">
                                 Satuan Organisasi <span style="color:red;">*</span>
                              </label>
                              <select class="form-control" id="satker" name="satker">
                                 <option value="">-- Pilih --</option>
                              </select>
                              <input type="hidden" name="nm_satker" id="nm_satker" value="<?= $sop->satuan_organisasi_nama ?>"/>
                           </div>
                           <div class="form-group col-md-4">
                              <label class="form-control-label">
                                 Unit Kerja
                              </label>
                              <select class="form-control" id="unitkerja" name="unitkerja">
                                  <option value="">-- Pilih --</option>
                              </select>
                              <input type="hidden" name="nm_unit" id="nm_unit" value="<?= $sop->nama_deputi ?>"/>
                           </div>
                           <div class="form-group col-md-4">
                              <label class="form-control-label">
                                 Unit Kerja 2
                              </label>
                              <select class="form-control" id="bagian" name="bagian">
                                  <option value="">-- Pilih --</option>
                              </select>
                              <input type="hidden" name="nm_bagian" id="nm_bagian" value="<?= $sop->nama_unit ?>"/>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="form-group col-md-2">
                              <label class="form-control-label">
                                 No SOP <span style="color:red;">*</span>
                              </label>
                              <input type="text" class="form-control" name="no_sop" id="no_sop" value="<?= $sop->sop_no ?>"/>
                              <small class="form-text text-muted">
                                 Format nomor/tahun
                              </small>
                           </div>
                           <div class="form-group col-md-10">
                              <label class="form-control-label">Nama SOP <span style="color:red;">*</span></label>
                              <input type="text" class="form-control" name="namasop" value="<?= $sop->sop_nama ?>" />
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="form-group col-md-6">
                              <label class="form-control-label">
                                 File SOP
                              </label>
                              <label class="form-control-label">
                                 <?= $sop->sop_update_file ?>&nbsp;&nbsp;
                                 <a href="<?= site_url('kelola_sop/lihat_berkas/'.enkripsi_id_url($sop->sop_alias)) ?>" target="_blank">Preview</a>
                              </label>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="form-group col-md-3">
                              <label class="form-control-label">
                                 Tanggal Penerbitan <span style="color:red;">*</span>
                              </label>
                               <input type="text" name="tanggal_penerbitan" id="tanggal_penerbitan" class="form-control datePicker" placeholder="Tanggal Penerbitan" value="<?= date('d-m-Y', strtotime($sop->tgl_efektif))?>" autocomplete="off" />
                           </div>
                           <div class="form-group col-md-6">
                              <label class="form-control-label">
                                 File Edit
                              </label>
                              <input type="file" class="form-control" name="fileupload"/>
                              <small class="form-text text-muted">
                                 Format .pdf max 5 MB
                              </small>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="form-group col-md-8">
                              <label class="form-control-label">
                                 <b>Catatan:</b> Jika Anda mengupload lampiran baru maka lampiran lama akan dihapus dan digantikan dengan lampiran yang baru
                              </label>       
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

      	//ambil data satorg
      	$.getJSON("<?= site_url('pencarian_sop/get_list_satorg'); ?>", function(e){
         	$.each(e, function(e, a){ 
            	$('#satker').append($('<option></option>').val(a.idsatorg).html(a.satorg));
         	});
      	});

         <?php if($title == 'Edit Berkas SOP'): ?>
            //$('#satker').val('02');
            

         <?php endif; ?>

      	//ambil data deputi berdasarkan satorg
      	$('#satker').change(function(){
        	   var value = $(this).find('option:selected').val();
        	   $('#nm_satker').val($(this).find('option:selected').text());
        	   $('#nm_unit').val('');
        	   $('#nm_bagian').val('');
         	$('#unitkerja').empty();
         	$('#unitkerja').append($('<option></option>').val('').html('-- Pilih --'));
         	$('#bagian').empty();
         	$('#bagian').append($('<option></option>').val('').html('-- Pilih --'));
         	if(value != ''){
           
            	$.ajax({ 
               		url: '<?= site_url('pencarian_sop/get_list_deputi') ?>',
               		type: "POST",
               		data: "satorg="+value+"&<?= $this->security->get_csrf_token_name(); ?>="+token_csrf(),
               		dataType: "JSON",
               		success: function(response){
                  		$.each(response, function(e, a){ 
                     		$('#unitkerja').append($('<option></option>').val(a.iddeputi).html(a.deputi));
                  		});
               		}
            	});
         	}
      	});

      	//ambil data biro berdasarkan deputi
      	$('#unitkerja').change(function(){
        	var value = $(this).find('option:selected').val();
        	$('#nm_unit').val($(this).find('option:selected').text());
        	$('#nm_bagian').val('');
         	$('#bagian').empty();
         	$('#bagian').append($('<option></option>').val('').html('-- Pilih --'));
        
         	if(value != ''){
            	$.ajax({ 
               		url: '<?= site_url('pencarian_sop/get_list_biro') ?>',
               		type: "POST",
               		data: "deputi="+value+"&<?= $this->security->get_csrf_token_name(); ?>="+token_csrf(),
               		dataType: "JSON",
               		success: function(response){
                  		$.each(response, function(e, a){ 
                     		$('#bagian').append($('<option></option>').val(a.idbiro).html(a.biro));
                  		});
               		}
            	});
         	}
      	});

      	$('#bagian').change(function(){
      		$('#nm_bagian').val($(this).find('option:selected').text());
      	});

      	//submit form
      	$('form').submit(function(e){
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
            			window.location = '<?= site_url('kelola_sop/upload_berkas') ?>';
            		}else{
                     $("html, body").animate({
                        scrollTop: $(document).height()
                     }, 1000);
            			$('#pesan').show().html(response.message);
                  	$('#pesan').fadeOut(5000);
            		}
            	} 
      		});
      	});

	});
</script>