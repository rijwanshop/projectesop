<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/examples/css/tables/datatable.css">

<style type="text/css">
   #Tabel th{
      text-align: center;
   }
   #Tabel td:nth-child(1), #Tabel td:nth-child(4){
      text-align: center;
   }
   #Tabel td:nth-child(2){
      text-align: justify;
   }
   #Tabel td:nth-child(4){
      white-space: nowrap;
   }
</style>>
  
<div class="page">
   <div class="page-header">
      <h1 class="page-title"><?=$title?></h1>
      <ol class="breadcrumb">
		   <li class="breadcrumb-item">
            <a href="<?=base_url()?>dashboard">Dashboard</a>
         </li>
		   <li class="breadcrumb-item active">Daftar Singkatan</li>
	   </ol>
      <div class="page-header-actions">
       
		   <a type="button" class="btn btn-success" href="<?= site_url('master_unit/tarik_data_singkatan'); ?>" target="_blank">
			   <i class="icon wb-refresh"></i> Tarik Data
		   </a>
      </div>
    </div>
    <div class="page-content container-fluid">
      <div class="row">
	  
        <div class="col-xxl-6">
          <!-- Panel Basic -->
          <div class="panel">
            <div class="panel-body">
               <div id="pesan"></div>

               <?php if($this->session->flashdata('message')): ?>
                <div class="alert alert-success" role="alert">
                  <?= $this->session->flashdata('message') ?>
                </div>
              <?php unset($_SESSION['message']); endif; ?>

              <table class="table table-hover dataTable table-striped w-full" id="Tabel">
				<thead>
				  <tr>
					<th data-sortable="false">No</th>
					<th>Nama Jabatan</th>
					<th>Singkatan</th>
					<th data-sortable="false">Action</th>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-input">
        <input type="hidden" name="method" id="method" value="insert" />
        <input type="hidden" name="id" id="id" />
        <div class="modal-body">
          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Kategori Aplikasi</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Nama kategori aplikasi">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
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
		    
          ajax:{
            url: "<?php echo site_url('master_unit/get_data_singkatan')?>",
            type: "POST",
            data: function(d){
               return $.extend({},d,{
                  '<?= $this->security->get_csrf_token_name(); ?>':token_csrf(),
               });
            },
        },
		  columnDefs: [
         { 
            targets: [ 0,3 ], 
            orderable: false,
         },
        ],
      });

      $(document).on('click', 'a#btn-hapus', function(e){
         e.preventDefault();
         var dom = $(this);
         if(confirm('Apakah anda yakin ingin menghapus data ini ?')){

            $.ajax({
               url: '<?= site_url('master_unit/hapus_singkatan'); ?>',
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
