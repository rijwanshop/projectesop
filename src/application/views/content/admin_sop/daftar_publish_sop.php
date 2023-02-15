<style type="text/css">
   .tabs{
      width:100%;
      height:auto;
      margin:0 auto;
   }

   /* tab list item */
   .tabs .tabs-list{
      list-style:none;
      margin:0px;
      padding:0px;
   }
   .tabs .tabs-list li{
      width:100px;
      float:left;
      margin:0px;
      margin-right:2px;
      padding:10px 5px;
      text-align: center;
      background-color:#62a8ea;
      border-radius:3px;
   }
   .tabs .tabs-list li:hover{
      cursor:pointer;
   }
   .tabs .tabs-list li a{
      text-decoration: none;
      color:white;
   }

   /* Tab content section */
   .tabs .tab{
      display:none;
      width:96%;
      min-height:250px;
      height:auto;
      border-radius:3px;
      padding:20px 15px;
      background-color:white;
      color:darkslategray;
      clear:both;
   }
   .tabs .tab h3{
      border-bottom:3px solid #62a8ea;
      letter-spacing:1px;
      font-weight:normal;
      padding:5px;
   }
   .tabs .tab p{
      line-height:20px;
      letter-spacing: 1px;
   }

   /* When active state */
   .active{
      display:block !important;
   }
   .tabs .tabs-list li.active{
      background-color:lavender !important;
      color:black !important;
   }
   .active a{
      color:black !important;
   }

   /* media query */
   @media screen and (max-width:360px){
      .tabs{
        margin:0;
        width:96%;
      }
      .tabs .tabs-list li{
        width:80px;
      }
   }

   table th, table td:nth-child(1){
      text-align: center;
   }
   .tabel-sop td:nth-child(2), .tabel-sop td:nth-child(4){
      text-align: center;
   }
   .tabel-sop td:nth-child(3), .tabel-sop td:nth-child(5), .tabel-sop td:nth-child(6){
      text-align: justify;
   }
   .tabel-sop td:nth-child(7), .tabel-sop td:nth-child(8){
         white-space: nowrap;
         text-align: center;
   }
</style>
<div class="modal" id="LoadingImage" style="display: none;"></div>
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
							
                     <div class="tabs">
                        <ul class="tabs-list">
                           <li class="active">
                              <a href="#tab1">Publikasi</a>
                           </li>
                           <li>
                              <a href="#tab2">Tidak Dipublikasi</a>
                           </li>
                        </ul>

                        <div id="tab1" class="tab active">
                           <h3>Daftar SOP Yang Dipublikasi Di Front End</h3>
                           <br>
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
                                       <th>Sat. Org.</th>
                                       <th>Deputi</th>
                                       <th>Biro</th>
                                       <th>Tgl. Efektif</th>
                                       <th data-sortable="false">Opsi</th>
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
                                       <th></th>
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

                        <div id="tab2" class="tab">
                           <h3>Daftar SOP Yang Tidak Dipublikasi Di Front End</h3>
                           <br>
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
                                       <th>Sat. Org.</th>
                                       <th>Deputi</th>
                                       <th>Biro</th>
                                       <th>Tgl. Efektif</th>
                                       <th data-sortable="false">Opsi</th>
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
                                       <th></th>
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
  
<script>
	$(document).ready(function(){ 
      $(".tabs-list li a").click(function(e){
         e.preventDefault();
      });

      $(".tabs-list li").click(function(){
         var tabid = $(this).find("a").attr("href");
         $(".tabs-list li,.tabs div.tab").removeClass("active");   // removing active class from tab and tab content
         $(".tab").hide();   // hiding open tab
         $(tabid).show();    // show tab
         $(this).addClass("active"); //  adding active class to clicked tab
      });

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
         order: [],
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
               targets: [ 0,7 ], 
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
         order: [],
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
               targets: [ 0,7 ], 
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