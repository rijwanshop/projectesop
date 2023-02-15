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
		    <li class="breadcrumb-item active">Komunikasi</li>
	  </ol>
    </div>
    <div class="page-content container-fluid">
      <div class="row">
	  
         <div class="col-xxl-6">
          <!-- Panel Basic -->
            <div class="panel">
               <div class="panel-body">
                  <table class="table table-hover dataTable table-striped w-full" id="Tabel">
				        <thead>
				           <tr>
					          <th width="50" data-sortable="false">No</th>
					          <th>Nama</th>
					          <th width="100">Telepon</th>
					          <th width="150">Email</th>
					          <th width="100">Tanggal</th>
					          <th width="70">Status</th>
					          <th width="70" data-sortable="false">Action</th>
				  </tr>
				</thead>
				<tfoot>
				  <tr>
					<th>No</th>
					<th>Nama</th>
					<th>Telepon</th>
					<th>Email</th>
					<th>Tanggal</th>
					<th>Status</th>
					<th>Action</th>
				  </tr>
				</tfoot>
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
         ajax:{
            url: "<?php echo site_url('komunikasi/data_kontak')?>",
            type: "POST",
            data: function(d){
               return $.extend({},d,{
                  '<?= $this->security->get_csrf_token_name(); ?>':token_csrf(),
               });
            },
        },
      columnDefs: [
         { 
            targets: [ -1 ], //last column
         },
        ],
      });
	  
    });
</script> 

