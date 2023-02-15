<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/examples/css/tables/datatable.css">

<div class="page">
	<div class="page-header">
      <h1 class="page-title"><?=$title?></h1>
      <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
		    <li class="breadcrumb-item active">Laporan</li>
	   </ol>
		
   </div>
   <div class="page-content container-fluid">
      <div class="row">
         <div class="col-xxl-6">
          <!-- Panel Basic -->
            <div class="panel">
               <div class="panel-body">
			         <div class="col-xxl-12" style="margin-bottom:50px">
					      <div class="form-group row">
					         <div class="col-md-4">
						         <label class="form-control-label">Satuan Organisasi</label>
						         <select class="form-control" id="satuan_organisasi" name="satuan_organisasi">
							        <option value="">Pilih Satuan Organisasi</option>
						         </select>
					         </div>
					         <div class="col-md-4">
						         <label class="form-control-label">Unit Kerja 1</label>
						         <select class="form-control" id="unitkerja" name="unitkerja">
							        <option value="">Semua Unit</option>
						         </select>
					         </div>
					         <div class="col-md-4">
						         <label class="form-control-label">Unit Kerja 2</label>
						         <select class="form-control" id="unit2" name="unit2">
							         <option value="">Semua Unit</option>
						         </select>
					         </div>
					      </div>
					      <div class="form-group row">
					          <div class="col-md-3">
						            <button type="button" class="btn btn-primary" id="btn-filter">
                                 Reset
                              </button>
						            <a href="#" id="Excel" class="btn btn-success">Excel</a>
					          </div>
					      </div>
			         </div>
			  
                  <table class="table table-hover dataTable table-striped w-full" id="Tabel">
				         <thead>
				            <tr>
					             <th width="30" data-sortable="false">No</th>
					             <th width="100">No SOP</th>
					             <th>Nama SOP</th>
					             <th width="100">Tgl Pembuatan</th>
					             <th width="60">Ket</th>
					             <th width="50" data-sortable="false">Lihat</th>
				            </tr>
				         </thead>
                     <tbody></tbody>
				         <tfoot>
				           <tr>
					            <th>No</th>
					            <th>No SOP</th>
					            <th>Nama SOP</th>
					            <th>Tgl Pembuatan</th>
					            <th>Ket</th>
					            <th>Lihat</th>
				           </tr>
				        </tfoot>
			         </table>
               </div>
            </div>
            <!-- End Panel Basic -->
         </div>
		
      </div>
   </div>
</div>
<script type="text/javascript">
  
   $(document).ready(function() {
	   
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

      $('#Tabel').DataTable({ 
        	processing: true,
         serverSide: true,
		   responsive: true,
		   info: false,
         ajax:{
            url: "<?php echo site_url('laporan/laporan_sop')?>",
            type: "POST",
            data: function(d){
               return $.extend({},d,{
                  '<?= $this->security->get_csrf_token_name(); ?>':token_csrf(),
                  'satorg': $('#satuan_organisasi').val(),
                  'deputi':$('#unitkerja').val(),
                  'biro':$('#unit2').val(),
               });
            },
        	},
		  	columnDefs: [
         		{ 
            		targets: [ -1 ], //last column
         		},
        	],
      });

      //ambil data satorg
      $.getJSON("<?= site_url('pencarian_sop/get_list_satorg'); ?>", function(e){
        	$.each(e, function(e, a){ 
            $('#satuan_organisasi').append($('<option></option>').val(a.idsatorg).html(a.satorg));
         });
      });

      //ambil data deputi berdasarkan satorg
      $('#satuan_organisasi').change(function(){
			var value = $(this).find('option:selected').val();
         $('#unitkerja').empty();
         $('#unitkerja').append($('<option></option>').val('').html('Semua Unit'));
         $('#unit2').empty();
         $('#unit2').append($('<option></option>').val('').html('Semua Unit'));
         $('#Tabel').DataTable().ajax.reload();
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
         $('#unit2').empty();
         $('#unit2').append($('<option></option>').val('').html('Semua Unit'));
         $('#Tabel').DataTable().ajax.reload();
         if(value != ''){
         	$.ajax({ 
               url: '<?= site_url('pencarian_sop/get_list_biro') ?>',
               type: "POST",
               data: "deputi="+value+"&<?= $this->security->get_csrf_token_name(); ?>="+token_csrf(),
               dataType: "JSON",
               success: function(response){
                  $.each(response, function(e, a){ 
                     $('#unit2').append($('<option></option>').val(a.idbiro).html(a.biro));
                  });  		
               }
            });
         }
		});

     
		$('#unit2').change(function(){ 
			$('#Tabel').DataTable().ajax.reload();
		});

		//tombol reset
		$('#btn-filter').click(function(){
			$('#satuan_organisasi').val('');
			$('#unitkerja').empty();
         $('#unitkerja').append($('<option></option>').val('').html('Semua Unit'));
         $('#unit2').empty();
         $('#unit2').append($('<option></option>').val('').html('Semua Unit'));
         $('#Tabel').DataTable().ajax.reload();
		});

      //tombol excel
		$('#Excel').click(function(e){
         e.preventDefault();
			var satorg = $('#satuan_organisasi').val();
			var deputi = $('#unitkerja').val();
			var biro = $('#unit2').val();
         window.open('<?= site_url('laporan/excel_sop/') ?>'+satorg+'/'+deputi+'/'+biro, '_blank').focus();
         
		});
    });
</script>
