<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/examples/css/tables/datatable.css">
<style>
   #Tabel th, #Tabel td:nth-child(1), #Tabel td:nth-child(4), #Tabel td:nth-child(5){
      text-align: center;
   }
   #Tabel td:nth-child(6){
      text-align: center;
      white-space: nowrap;
   }
</style>
<div class="page">
	<div class="page-header">
      <h1 class="page-title"><?=$title?></h1>
      <ol class="breadcrumb">
		   <li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
		   <li class="breadcrumb-item active">SOP</li>
	   </ol>
      <div class="page-header-actions">
		   <a type="button" class="btn btn-success" href="<?= site_url('kelola_sop/input_sop_upload') ?>">
			   <i class="icon wb-plus" aria-hidden="true"></i> Tambah Data
		   </a>
	   </div>
   </div>
   <div class="page-content container-fluid">
      <div class="row">
	  
         <div class="col-xxl-6">
            <!-- Panel Basic -->
            <div class="panel">
               <div class="panel-body">
                  <?php if($this->session->flashdata('message')): ?>
                     <?= $this->session->flashdata('message') ?> 
                  <?php unset($_SESSION['message']); endif; ?>
                  <div id="pesan"></div>
                  <table class="table table-hover dataTable table-striped w-full" id="Tabel">
				         <thead>
				            <tr>
					            <th width="30" data-sortable="false">No.</th>
					            <th width="50">No. SOP</th>
					            <th>Nama SOP</th>
                           <th width="120">Waktu Upload</th>
					            <th width="50">Lihat PDF</th>
					            <th width="50">Action</th>
				            </tr>
				         </thead>
				         <tbody></tbody>
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

      $('#Tabel').DataTable({ 
         processing: true,
         serverSide: true,
         responsive: true,
         info: false,
         order: [],
         ajax:{
            url: "<?php echo site_url('kelola_sop/get_upload_sop')?>",
            type: "POST",
            data: function(d){
               return $.extend({},d,{
                  '<?= $this->security->get_csrf_token_name(); ?>':token_csrf(),
               });
            },
         },
         columnDefs: [
         { 
            targets: [ 0,4,5 ], 
            orderable: false,
         },
        ],
      });

      $(document).on('click', 'a#btn-hapus', function(e){
         e.preventDefault();
         var dom = $(this);
         if(confirm('Apakah anda yakin ingin menghapus data ini ?')){

            $.ajax({
               url: '<?= site_url('kelola_sop/hapus_berkas'); ?>',
               type: 'POST',
               dataType: 'json',
               data:{
                  '<?= $this->security->get_csrf_token_name(); ?>': token_csrf(),
                  'id': dom.attr('href'),
               },
               success: function(response){
                  $('#pesan').show().html(response.message);
                  $('#Tabel').DataTable().ajax.reload();
                  $('#pesan').fadeOut(5000);
               }
            });
         }
      });
	  
    });
</script>