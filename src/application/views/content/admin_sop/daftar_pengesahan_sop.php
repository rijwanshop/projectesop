<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/examples/css/tables/datatable.css">
<style type="text/css">
   #Tabel th{
      text-align: center;
   }
   #Tabel td:nth-child(8){
      white-space: nowrap;
      text-align: center;
   }
</style>
<div class="page">
   <div class="page-header">
      <h1 class="page-title"><?=$title?></h1>
      <ol class="breadcrumb">
		   <li class="breadcrumb-item">
            <a href="<?=base_url()?>dashboard">Dashboard</a></li>
		   <li class="breadcrumb-item active">SOP</li>
	   </ol>
   </div>
   <div class="page-content container-fluid">
      <div class="row">
	  
         <div class="col-xxl-6">
            <div class="panel">
               <div class="panel-body">
                  <div id="pesan"></div>
                  <?php if($this->session->flashdata('message')): ?>
                     <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('message') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                  <?php elseif($this->session->flashdata('failed')): ?>
                     <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('failed') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                  <?php endif; ?>



                  <div class="table-responsive">
                  <table class="table table-hover dataTable w-full" id="Tabel">
				         <thead>
				            <tr>
					            <th width="30">No</th>
					             <th width="100">No SOP</th>
					             <th>Nama SOP</th>
					             <th width="100">Tgl Pengajuan</th>
					             <th width="60">Status</th>
					             <th width="60">Step</th>
					             <th width="60">Ket</th>
					             <th width="50" data-sortable="false">Action</th>
				           </tr>
				        </thead>
                    <tbody></tbody>
				        
				
			         </table>
                  </div>
                  <b>NB: Warna Kuning adalah SOP Lama</b>
               </div>
            </div>
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
            url: "<?php echo site_url('pengesah_sop/get_daftar_pengesahan')?>",
            type: "POST",
            data: function(d){
               return $.extend({},d,{
                  '<?= $this->security->get_csrf_token_name(); ?>':token_csrf(),
               });
            },
         },
		   columnDefs: [
            { 
               targets: [0,7], //last column
            },
         ],
         createdRow: function(row, data, dataIndex){
            if(data[8] == 'sop lama'){
               $(row).css("background-color", "#F0E68C");
               $(row).css("color", "#555");
            }
         },
      });


      $(document).on('click', 'a#btn-terima', function(e){
         e.preventDefault();
         var dom = $(this);
         if(confirm('Apakah anda yakin ingin menerima data ini?')){

            $.ajax({
               url: '<?= site_url('admin_sop/terima'); ?>',
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
