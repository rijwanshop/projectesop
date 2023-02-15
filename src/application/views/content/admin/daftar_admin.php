<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
<link rel="stylesheet" href="<?=base_url()?>assets/examples/css/tables/datatable.css">
<style type="text/css">
   #tbl_user th{
      text-align: center;
   }
   #tbl_user td:nth-child(6){
      white-space: nowrap;
      text-align: center;
   }
</style>
<div class="page">
   <div class="page-header">
      <h1 class="page-title"><?=$title?></h1>
      <ol class="breadcrumb">
		   <li class="breadcrumb-item">
            <a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
		   <li class="breadcrumb-item active">User</li>
	   </ol>
      <div class="page-header-actions">
         <a type="button" class="btn btn-success" href="<?= site_url('admin/tambah_pengguna') ?>">
            <i class="fa fa-user-plus" aria-hidden="true"></i> Tambah Pengguna
         </a>
      </div>
   </div>
   <div class="page-content container-fluid">
      <div class="row">
	  
         <div class="col-xxl-6">
            <div class="panel">
               <div class="panel-body">
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                     <i class="fa fa-info-circle"></i> &nbsp;
                     Anda tidak perlu menambahkan user Penyusun, Reviewer, dan Pengesah karena sudah terregistrasi otomatis dengan akun SSO
                  </div>
                  <div id="pesan"></div>


                  <table class="table table-bordered table-striped" id="tbl_user">
                     <thead>
                        <tr>
                           <th scope="col">No</th>
                           <th scope="col">NIP SSO</th>
                           <th scope="col">Nama</th>
                           <th scope="col">Jabatan</th>
                           <th scope="col">Role user</th>
                           <th scope="col">Opsi</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach($pengguna->result() as $row): ?>
                           <tr>
                           <td><?= $no++; ?></td>
                           <td><?= $row->niplama ?></td>
                           <td><?= $row->nama_pengguna ?></td>
                           <td><?= $row->jabatan ?></td>
                           <td><?= $row->user_group_name ?></td>
                           <td>
                              <a href="<?= site_url('admin/edit_pengguna/'.$row->idpengguna) ?>" class="btn btn-warning btn-icon">
                                 <i class="fa fa-edit"></i>
                              </a>
                              <a href="<?= $row->idpengguna ?>" class="btn btn-danger btn-icon" id="btn-hapus">
                                 <i class="fa fa-remove"></i>
                              </a>
                           </td>
                        </tr>
                        <?php endforeach; ?>
                     </tbody>
                  </table>



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



      $('#tbl_user').DataTable();


      $(document).on('click', 'a#btn-hapus', function(e){
         e.preventDefault();
         var dom = $(this);
         if(confirm('Apakah anda yakin ingin menghapus data ini?')){

            $.ajax({
               url: '<?= site_url('admin/hapus_pengguna'); ?>',
               type: 'POST',
               dataType: 'json',
               data:{
                  '<?= $this->security->get_csrf_token_name(); ?>': token_csrf(),
                  'id': dom.attr('href'),
               },
               success: function(response){
               
               if(response.success == true){
                  dom.closest('tr').remove();
               }
               $('#pesan').show().html(response.message);
               $('#pesan').fadeOut(5000);
            }
         });
         }
      });
	  
    });
</script>
