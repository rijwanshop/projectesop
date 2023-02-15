<script src="<?=base_url()?>assets/global/js/Plugin/responsive-tabs.js"></script>
<script src="<?=base_url()?>assets/global/js/Plugin/closeable-tabs.js"></script>
<script src="<?=base_url()?>assets/global/js/Plugin/tabs.js"></script>
<style>
	#fix {
  		background:#fff;
  		width:31cm;
  		z-index:9
	}
	.tabel-sop th, .tabel-sop td:nth-child(1), .tabel-sop td:nth-child(2){
      text-align: center;
   }
   .tabel-sop td:nth-child(3), .tabel-sop td:nth-child(4){
      text-align: justify;
   }
   .tabel-sop td:nth-child(5), .tabel-sop td:nth-child(6){
   		white-space: nowrap;
   		text-align: center;
   }
</style>
<div class="modal" id="LoadingImage" style="display: none;"></div>
	<div class="page" style="max-width: 1300px;">
		<div class="page-header">
      		<h1 class="page-title"><?=$title?></h1>
      		<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
				<li class="breadcrumb-item active">SOP</li>
	  		</ol>
    	</div>
	
    	<div class="page-content container-fluid">
      	<div class="row">
				<div class="col-lg-12">
			  		<div class="panel">
						<div class="panel-body">
							<div class="nav-tabs-horizontal" data-plugin="tabs">
								<div id="fix">
									<ul class="nav nav-tabs nav-tabs-line mr-25" role="tablist">
										<li class="nav-item" role="presentation">
											<a class="nav-link active" data-toggle="tab" href="#Identitas"
									  aria-controls="Identitas" role="tab">
												Publish
											</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="nav-link" data-toggle="tab" href="#Kegiatan"
									  aria-controls="Kegiatan" role="tab">
												Unpublish
											</a>
										</li>
								  	</ul>
								</div>
								<div class="tab-content py-15">
									<div class="tab-pane active" id="Identitas" role="tabpanel">

                              <div class="form-group row">
                                 <label for="satker" class="col-sm-2 col-form-label">
                                    Satuan Organisasi
                                 </label>
                                 <div class="col-sm-4">
                                    <select class="form-control" id="satker">
                                       <option value="">-- Pilih --</option>
                                             
                                    </select>
                                 </div>
                              </div>
										<div class="form-group row">
                  					<label for="unit_kerja" class="col-sm-2 col-form-label">
                     					Unit Kerja 1
                  					</label>
                  					<div class="col-sm-4">
                     					<select name="unit_kerja" id="unit_kerja" class="form-control">
                              			<option value="">-- Pilih --</option>				
                           			</select> 
                  					</div>
               					</div>
                              <div class="form-group row">
                                 <label for="unit_kerja2" class="col-sm-2 col-form-label">
                                    Unit Kerja 2
                                 </label>
                                 <div class="col-sm-4">
                                    <select name="unit_kerja2" id="unit_kerja2" class="form-control">
                                       <option value="">-- Pilih --</option>           
                                    </select> 
                                 </div>
                              </div>
               							
               					<div id="pesan"></div>
									   <div class="table-responsive">
											<table class="table table-hover dataTable table-striped w-full tabel-sop" id="Tabel">
												<thead>
				  									<tr>
														<th data-sortable="false">No</th>
														<th>No SOP</th>
														<th>Nama SOP</th>
														<th>Unit Kerja</th>
														<th>Tanggal Efektif</th>
														<th data-sortable="false">Action</th>
				  									</tr>
												</thead>
												<tbody></tbody>
												<tfoot>
													<tr>
														<th></th>
														<th>
															<input type="text" name="no_sop" id="no_sop" class="form-control" placeholder="No SOP" />
														</th>
														<th>
															<input type="text" name="nama_sop" id="nama_sop" class="form-control" placeholder="Nama SOP" />
														</th>
														<th></th>
														<th>
                           						<select name="tahun" id="tahun" class="form-control">
                              						<option value="">-- Tahun --</option>
                              						<?php foreach($list_tahun as $row): ?>
                                 						<option value="<?= $row ?>"><?= $row ?></option>
                              						<?php endforeach; ?>
                           						</select>                
                        						</th>
														<th></th>
													</tr>
												</tfoot>
			  								</table>

										</div>
									</div>
									<div class="tab-pane" id="Kegiatan" role="tabpanel">

                              <div class="form-group row">
                                 <label for="satker2" class="col-sm-2 col-form-label">
                                    Satuan Organisasi
                                 </label>
                                 <div class="col-sm-4">
                                    <select class="form-control" id="satker2">
                                       <option value="">-- Pilih --</option>
                                             
                                    </select>
                                 </div>
                              </div>
										<div class="form-group row">
                  					<label for="unit_kerja3" class="col-sm-2 col-form-label">
                     					Unit Kerja 1
                  					</label>
                  					<div class="col-sm-4">
                     					<select name="unit_kerja3" id="unit_kerja3" class="form-control">
                              			<option value="">-- Pilih --</option>
                              						
                           			</select> 
                  					</div>
               					</div>
                              <div class="form-group row">
                                 <label for="unit_kerja4" class="col-sm-2 col-form-label">
                                    Unit Kerja 2
                                 </label>
                                 <div class="col-sm-4">
                                    <select name="unit_kerja4" id="unit_kerja4" class="form-control">
                                       <option value="">-- Pilih --</option>
                                                
                                    </select> 
                                 </div>
                              </div>
               							
               					<div id="pesan2"></div>
										<div class="table-responsive">
											<table class="table table-hover dataTable table-striped w-full tabel-sop" id="Tabel2">
												<thead>
				  									<tr>
														<th data-sortable="false">No</th>
														<th>No SOP</th>
														<th>Nama SOP</th>
														<th>Unit Kerja</th>
														<th>Tanggal Efektif</th>
														<th data-sortable="false">Action</th>
				  									</tr>
												</thead>
												<tbody></tbody>
												<tfoot>
													<tr>
														<th></th>
														<th>
															<input type="text" name="no_sop2" id="no_sop2" class="form-control" placeholder="No SOP" />
														</th>
														<th>
															<input type="text" name="nama_sop2" id="nama_sop2" class="form-control" placeholder="Nama SOP" />
														</th>
														<th></th>
														<th>
                           						<select name="tahun2" id="tahun2" class="form-control">
                              						<option value="">-- Tahun --</option>
                              						<?php foreach($list_tahun as $row): ?>
                                 						<option value="<?= $row ?>"><?= $row ?></option>
                              						<?php endforeach; ?>
                           						</select>                
                        						</th>
														<th></th>
													</tr>
												</tfoot>
			  								</table>
										</div>
									</div>
									
								</div>
							</div>
					  
						</div>
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

      //daftar SOP yang tampil di menu pencarian
		$('#Tabel').DataTable({ 
        	processing: true,
         serverSide: true,
		   responsive: true,
		   dom: 'lrtp',
         aaSorting: [ [0,"desc" ]],
         ajax:{
            url: "<?php echo site_url('admin_sop/get_sop_publish')?>",
            type: "POST",
            data: function(d){
               return $.extend({},d,{
                  '<?= $this->security->get_csrf_token_name(); ?>':token_csrf(),
                  'satorg':$('#satker').val(),
                  'deputi':$('#unit_kerja').val(),
                  'biro':$('#unit_kerja2').val(),
                  'no_sop':$('#no_sop').val(),
                  'nama_sop':$('#nama_sop').val(),
                  'tahun':$('#tahun option:selected').val(),
               });
            },
         },
		   columnDefs: [
            { 
               targets: [ 0,5 ], 
               orderable: false,
            },
         ],
         createdRow: function(row, data, dataIndex){
            if(data[1].indexOf("<?= $last_year ?>") >= 0){
               $(row).css("background-color", "#9EF395");
               $(row).css("color", "#555");
            }
         },
      });

      //daftar SOP yang tidak ditampilkan di menu pencarian
      $('#Tabel2').DataTable({ 
        	processing: true,
         serverSide: true,
		   responsive: true,
		   dom: 'lrtp',
         aaSorting: [ [0,"desc" ]],
         ajax:{
            url: "<?php echo site_url('admin_sop/get_sop_unpublish')?>",
            type: "POST",
            data: function(d){
               return $.extend({},d,{
                  '<?= $this->security->get_csrf_token_name(); ?>':token_csrf(),
                  'satorg':$('#satker2').val(),
                  'deputi':$('#unit_kerja3').val(),
                  'biro':$('#unit_kerja4').val(),
                  'no_sop':$('#no_sop2').val(),
                  'nama_sop':$('#nama_sop2').val(),
                  'tahun':$('#tahun2 option:selected').val(),
               });
            },
         },
		   columnDefs: [
            { 
               targets: [ 0,5 ], 
               orderable: false,
            },
         ],
         createdRow: function(row, data, dataIndex){
            if(data[1].indexOf("<?= $last_year ?>") >= 0){
               $(row).css("background-color", "#9EF395");
               $(row).css("color", "#555");
            }
         },
      });

      //ambil data satorg
      $.getJSON("<?= site_url('pencarian_sop/get_list_satorg'); ?>", function(e){
         $.each(e, function(e, a){ 
            $('#satker').append($('<option></option>').val(a.idsatorg).html(a.satorg));
            $('#satker2').append($('<option></option>').val(a.idsatorg).html(a.satorg));
         });
      });

      //ambil data deputi berdasarkan satorg
      $('#satker').change(function(){
         var value = $(this).find('option:selected').val();
         $('#unit_kerja').empty();
         $('#unit_kerja').append($('<option></option>').val('').html('-- Pilih --'));
         $('#unit_kerja2').empty();
         $('#unit_kerja2').append($('<option></option>').val('').html('-- Pilih --'));
         $('#Tabel').DataTable().ajax.reload();
         if(value != ''){
            $.ajax({ 
               url: '<?= site_url('pencarian_sop/get_list_deputi') ?>',
               type: "POST",
               data: "satorg="+value+"&<?= $this->security->get_csrf_token_name(); ?>="+token_csrf(),
               dataType: "JSON",
               success: function(response){
                  $.each(response, function(e, a){ 
                     $('#unit_kerja').append($('<option></option>').val(a.iddeputi).html(a.deputi));
                  });
               }
            });
         }
      });

      //ambil data deputi berdasarkan satorg
      $('#satker2').change(function(){
         var value = $(this).find('option:selected').val();
         $('#unit_kerja3').empty();
         $('#unit_kerja3').append($('<option></option>').val('').html('-- Pilih --'));
         $('#unit_kerja4').empty();
         $('#unit_kerja4').append($('<option></option>').val('').html('-- Pilih --'));
         $('#Tabel2').DataTable().ajax.reload();
         if(value != ''){
            $.ajax({ 
               url: '<?= site_url('pencarian_sop/get_list_deputi') ?>',
               type: "POST",
               data: "satorg="+value+"&<?= $this->security->get_csrf_token_name(); ?>="+token_csrf(),
               dataType: "JSON",
               success: function(response){
                  $.each(response, function(e, a){ 
                     $('#unit_kerja3').append($('<option></option>').val(a.iddeputi).html(a.deputi));
                  });
               }
            });
         }
      });

      //ambil data biro berdasarkan deputi
      $('#unit_kerja').change(function(){
         var value = $(this).find('option:selected').val();
         $('#unit_kerja2').empty();
         $('#unit_kerja2').append($('<option></option>').val('').html('-- Pilih --'));
         $('#Tabel').DataTable().ajax.reload();
         if(value != ''){
            $.ajax({ 
               url: '<?= site_url('pencarian_sop/get_list_biro') ?>',
               type: "POST",
               data: "deputi="+value+"&<?= $this->security->get_csrf_token_name(); ?>="+token_csrf(),
               dataType: "JSON",
               success: function(response){
                  $.each(response, function(e, a){ 
                     $('#unit_kerja2').append($('<option></option>').val(a.idbiro).html(a.biro));
                  });
               }
            });
         }
      });

       //ambil data biro berdasarkan deputi
      $('#unit_kerja3').change(function(){
         var value = $(this).find('option:selected').val();
         $('#unit_kerja4').empty();
         $('#unit_kerja4').append($('<option></option>').val('').html('-- Pilih --'));
         $('#Tabel2').DataTable().ajax.reload();
         if(value != ''){
            $.ajax({ 
               url: '<?= site_url('pencarian_sop/get_list_biro') ?>',
               type: "POST",
               data: "deputi="+value+"&<?= $this->security->get_csrf_token_name(); ?>="+token_csrf(),
               dataType: "JSON",
               success: function(response){
                  $.each(response, function(e, a){ 
                     $('#unit_kerja4').append($('<option></option>').val(a.idbiro).html(a.biro));
                  });
               }
            });
         }
      });

      //filter biro
      $('#unit_kerja2').change(function(){
         $('#Tabel').DataTable().ajax.reload();
      });

      $('#unit_kerja4').change(function(){
         $('#Tabel2').DataTable().ajax.reload();
      });

      //filter tahun
      $('#tahun').change(function(){
         $('#Tabel').DataTable().ajax.reload();
      });

      $('#tahun2').change(function(){
         $('#Tabel2').DataTable().ajax.reload();
      });

      //filter nomor dan nama SOP
      $('input[type="text"]').on('change keyup', function(){ 
         if($(this).attr('id').indexOf('2') >= 0)
            $('#Tabel2').DataTable().ajax.reload();
         else 
            $('#Tabel').DataTable().ajax.reload();
      });

      //non aktifkan SOP
      $(document).on('click', 'a#btn-unpublish', function(e){
        	e.preventDefault();
         var dom = $(this);
         if(confirm('Apakah anda yakin ingin Unpublish SOP ini ?')){
            $.ajax({
               url: '<?= site_url('admin_sop/unpublish_sop'); ?>',
               type: 'POST',
               dataType: 'json',
               data:{
                  '<?= $this->security->get_csrf_token_name(); ?>': token_csrf(),
                  'id': dom.attr('href'),
               },
               success: function(response){               
               	$('#pesan').show().html(response.message);
               	$('#Tabel').DataTable().ajax.reload();
               	$('#Tabel2').DataTable().ajax.reload();
               	$('#pesan').fadeOut(5000);
            	}
         	});
         }
      });

      //aktifkan SOP
      $(document).on('click', 'a#btn-publish', function(e){
        	e.preventDefault();
         var dom = $(this);
         if(confirm('Apakah anda yakin ingin publish SOP ini ?')){
            $.ajax({
               url: '<?= site_url('admin_sop/publish_sop'); ?>',
               type: 'POST',
               dataType: 'json',
               data:{
                  '<?= $this->security->get_csrf_token_name(); ?>': token_csrf(),
                  'id': dom.attr('href'),
               },
               success: function(response){
               	$('#pesan2').show().html(response.message);
               	$('#Tabel').DataTable().ajax.reload();
               	$('#Tabel2').DataTable().ajax.reload();
               	$('#pesan2').fadeOut(5000);
            	}
         	});
         }
      });

	}); 		
</script>