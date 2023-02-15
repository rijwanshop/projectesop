<link href="<?=base_url()?>assets/front/css/dataTables.bootstrap.min.css" rel="stylesheet">
<script src="<?=base_url()?>assets/front/js/jquery.dataTables.min.js"></script> 
<script src="<?=base_url()?>assets/front/js/dataTables.bootstrap.min.js"></script> 

<style type="text/css">
   #Tabel th, #Tabel td:nth-child(1), #Tabel td:nth-child(2), #Tabel td:nth-child(4), #Tabel td:nth-child(7), #Tabel td:nth-child(8){
      text-align: center;
   }
   #Tabel td:nth-child(3), #Tabel td:nth-child(5), #Tabel td:nth-child(6){
      text-align: justify;
   }
   #Tabel td:nth-child(8){
      white-space: nowrap;
   }
</style>
  
<section id="inner-title" class="inner-title">
   <div class="container">
      <div class="row">
         <div class="col-md-6 col-lg-6"><h2>Pencarian SOP</h2></div>
         <div class="col-md-6 col-lg-6">
            <div class="breadcrumbs">
               <ul>
                  <li>Current Page:</li>
                  <li><a href="<?= site_url('beranda') ?>">Beranda</a></li>
                  <li><a href="<?= site_url('pencarian_sop')?>">Pencarian SOP</a></li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</section> 
<section id="section18" class="section-margine" style="margin-bottom:30px">
   <div class="container">
	   <div class="row">
         <div class="col-md-12 col-lg-12">
            <header class="title-head" style="margin-bottom:10px">
               <h2>Pencarian SOP</h2>
       
               <div class="line-heading">
                  <span class="line-left"></span>
                  <span class="line-middle">+</span>
                  <span class="line-right"></span>
               </div>
            </header>
         </div>
      </div>
      <div class="row">
         <div class="col-md-2 col-lg-12 wow fadeInUp">
            <div class="textcont">
               <div class="form-group row">
                  <label for="satker" class="col-sm-2 col-form-label">
                     Satuan Organisasi
                  </label>
                  <div class="col-sm-5">
                     <select class="form-control" id="satker">
                        <option value="">-- Pilih --</option>
                        
                     </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label for="unit_kerja" class="col-sm-2 col-form-label">
                     Unit Kerja 1
                  </label>
                  <div class="col-sm-5">
                     <select name="unit_kerja" id="unit_kerja" class="form-control">
                        <option value="">-- Pilih --</option>     
                     </select> 
                  </div>
               </div>
               <div class="form-group row">
                  <label for="unit_kerja2" class="col-sm-2 col-form-label">
                     Unit Kerja 2
                  </label>
                  <div class="col-sm-5">
                     <select name="unit_kerja2" id="unit_kerja2" class="form-control">
                        <option value="">-- Pilih --</option>     
                     </select> 
                  </div>
               </div>
					<table id="Tabel" class="table table-striped table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th width="8%">No</th>
								<th width="10%">No SOP</th>
								<th width="34%">Nama SOP</th>
                        <th width="15%">Sat. Org.</th>
                        <th width="10%">Deputi</th>
								<th width="15%">Biro</th>
								<th width="15%">Tgl. Efektif</th>
								<th width="8%">Opsi</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th></th>
								<th><input type="text" name="no_sop" id="no_sop" class="form-control" placeholder="No SOP" /></th>
								<th><input type="text" name="nama_sop" id="nama_sop" class="form-control" placeholder="Nama SOP" /></th>
								<th>
                                          
                        </th>
                        <th>
                                          
                        </th>
                        <th>
                                          
                        </th>
								<th>
                           <select name="tahun" id="tahun" class="form-control">
                              <option value="">-- Tahun --</option>
                              <?php foreach($list_tahun as $row): ?>
                                 <option value="<?= $row ?>"><?= $row ?></option>
                              <?php endforeach; ?>
                           </select>                
                        </th>
								<th>
                           <a href="#" data-unit="" data-satker="" class="btn btn-primary btn-sm" id="btn-download" title="Download per unit">
                              <i class="fa fa-download"></i>
                           </a>                
                        </th>
							</tr>
						</tfoot>
					</table>
		      </div>  
         </div>
      </div>
   </div>
</section>

<script type="text/javascript">
    
   $(document).ready(function() {
	   
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
         var csrf = $.xResponse('<?= site_url('agenda/get_csrf') ?>', {issession: 1,selector: true});
         return csrf;
      }

      $('#Tabel').DataTable({ 
         processing: true,
         serverSide: true,
		   responsive: true,
		   dom: 'lrtp',
         aaSorting: [ [0,"desc" ]],
         order: [],
         ajax:{
            url: "<?php echo site_url('pencarian_sop/get_data_sop')?>",
            type: "POST",
            data: function(d){
               return $.extend({},d,{
                  '<?= $this->security->get_csrf_token_name(); ?>':token_csrf(),
                  'satorg': $('#satker').val(),
                  'deputi': $('#unit_kerja').val(),
                  'biro': $('#unit_kerja2').val(),
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

      //ambil data satorg
      $.getJSON("<?= site_url('pencarian_sop/get_list_satorg'); ?>", function(e){
         $.each(e, function(e, a){ 
            $('#satker').append($('<option></option>').val(a.idsatorg).html(a.satorg));
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
            $('#btn-download').attr('data-satker', value);
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
         }else{
            $('#btn-download').attr('data-satker', '');
         }
      });

      //ambil data biro berdasarkan deputi
      $('#unit_kerja').change(function(){
         var value = $(this).find('option:selected').val();
         $('#unit_kerja2').empty();
         $('#unit_kerja2').append($('<option></option>').val('').html('-- Pilih --'));
         $('#Tabel').DataTable().ajax.reload();
         if(value != ''){
            $('#btn-download').attr('data-unit', value);
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
         }else{
            $('#btn-download').attr('data-unit', '');
         }
      });

      //filter biro
      $('#unit_kerja2').change(function(){
         $('#Tabel').DataTable().ajax.reload();
      });

      $('input[type="text"]').on('change keyup', function(){ 
         $('#Tabel').DataTable().ajax.reload();
      });

      $('#tahun').change(function(){
         $('#Tabel').DataTable().ajax.reload();
      });

      //download per unit
	   $(document).on('click', 'a#btn-download', function(e){
         e.preventDefault();
         //satorg
         if($(this).attr('data-satker') == ''){
            alert('Anda belum memilih satuan Organisasi');
            return false;
         }
         
         var url = '<?= site_url('pencarian_sop/download_filter_sop/'); ?>'+$(this).attr('data-satker')+'/'+$(this).attr('data-unit')+'/'+$('#unit_kerja2').val();
         window.open(url, '_blank'); 
      });
	  
    });
</script>