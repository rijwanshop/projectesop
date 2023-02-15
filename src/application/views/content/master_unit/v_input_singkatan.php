<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/examples/css/tables/datatable.css">
  
<div class="page">
   <div class="page-header">
      <h1 class="page-title"><?=$title?></h1>
         <ol class="breadcrumb">
		      <li class="breadcrumb-item">
               <a href="<?=base_url()?>dashboard">Dashboard</a></li>
		      <li class="breadcrumb-item active">Singkatan</li>
	      </ol>
      <div class="page-header-actions">
		   <a type="button" class="btn btn-warning" href="<?= site_url('master_unit') ?>">
			   <i class="icon wb-arrow-left" aria-hidden="true"></i> Kembali
		   </a>
      </div>
   </div>
   <div class="page-content container-fluid">
      <div class="row">
         <div class="col-xxl-6">
          <!-- Panel Basic -->
            <div class="panel">
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-8">
                        <div id="pesan"></div>

                        

                        <?php if($title == 'Edit Singkatan'): ?>

                           <form id="form-input" method="post" action="<?= site_url('master_unit/update_singkatan'); ?>">
                              <input type="hidden" name="id" id="id" value="<?= $dt_singkatan->row()->idsingkatan ?>" />

                              <div class="form-group row">
                                 <label for="singkatan" class="col-sm-2 col-form-label">
                                    Singkatan <span style="color:red;">*</span>
                                 </label>
                                 <div class="col-sm-10">
                                    <input type="text" class="form-control" id="singkatan" name="singkatan" placeholder="Singkatan" value="<?= $dt_singkatan->row()->singkatan ?>" />
                                 </div>
                              </div>
                           
                              <div class="form-group row">
                                 <label for="nama_singkatan" class="col-sm-2 col-form-label">
                                    Jabatan <span style="color:red;">*</span>
                                 </label>
                                 <div class="col-sm-10">
                                    <textarea name="nama_jabatan" id="nama_jabatan" class="form-control" rows="4" placeholder="Kepanjangan" readonly><?= $dt_singkatan->row()->nama_jabatan; ?></textarea>
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                 </div>
                              </div>
                           </form>
                        <?php endif; ?>
                     </div>
                  </div>
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

      $('#form-input').submit(function(e){
         e.preventDefault();
         
         $.ajax({ 
            url: $(this).attr('action'),
            type: "POST",
            data: $(this).serialize() + "&<?= $this->security->get_csrf_token_name(); ?>=" + token_csrf(),
                dataType: "JSON",
            success: function(response){
               if(response.success == true){
                  location.href = '<?= site_url('master_unit'); ?>';
               }else{
                  $('#pesan').show().html(response.message);
                  $('#pesan').fadeOut(5000);
               }
               
                  
            }
         });
         
      });
     
	  
    });
</script>
