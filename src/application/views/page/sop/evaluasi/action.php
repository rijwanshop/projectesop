  <link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/examples/css/tables/datatable.css">
  
<?php
$id = '';
//$nama = '';
$act = 'add_evaluasi';
//foreach($edit->result_array() as $row){
//	$id = $row['unit_kerja_id'];
//	$nama = $row['unit_kerja_nama'];
//	$act = 'edit_unit_kerja';
//}

?>

<div class="page">
	<div class="page-header">
      <h1 class="page-title"><?=$title?></h1>
      <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
		<li class="breadcrumb-item active">SOP</li>
	  </ol>
      <div class="page-header-actions">
		<a type="button" class="btn btn-warning" href="<?=base_url()?>sop/evaluasi_sop">
			<i class="icon wb-arrow-left" aria-hidden="true"></i> Back
		</a>
      </div>
    </div>
	
	
    <div class="page-content container-fluid">
      <div class="row">
	  
			<div class="col-lg-12">
			  <!-- Panel Summary Mode -->
			  <div class="panel">
				<div class="panel-heading">
				  <h3 class="panel-title">Add <?=$title?></h3>
				</div>
				<div class="panel-body">
				  <form class="form-horizontal" id="FrmAjax">
				  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				  <input type="hidden" name="id" value="<?=$id?>"/>
					<div class="Errors"></div>
					<div class="row">
						<div class="col-md-7"><h5>Pilih SOP yang akan di evaluasi</h5><hr></div>
						<div class="col-md-5"><h5>Daftar SOP yang akan di evaluasi</h5><hr></div>
						
					</div>
					<div class="form-group row">
						<div class="col-md-7">
							<table class="table table-hover dataTable table-striped w-full" id="Tabel">
								<thead>
								  <tr>
									<th width="30" data-sortable="false">No</th>
									<th>Nama SOP</th>
									<th width="60">Action</th>
								  </tr>
								</thead>
								<tfoot>
								  <tr>
									<th>No</th>
									<th>Nama SOP</th>
									<th>Action</th>
								  </tr>
								</tfoot>
								<tbody></tbody>
							  </table>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								  <select class="form-control" multiple="multiple" name="daftarsop[]" style="height:300px" id="DaftarSOP">
								  </select>
							</div>
							
							<label class="form-control-label">Status</label>
							  <div class="radio-custom radio-default radio-inline">
								<input type="radio" id="a" name="status" value="Y" checked/>
								<label for="a">Aktif</label>
							  </div>
							  <div class="radio-custom radio-default radio-inline">
								<input type="radio" id="n" name="status" value="N"/>
								<label for="n">Nonktif</label>
							  </div>
						</div>
					</div>
					<div class="text-right">
					  <button type="submit" class="btn btn-primary">Submit</button>
					</div>
				  </form>
				</div>
			  </div>
			  
			  
			  <!-- End Panel Summary Mode -->
			</div>
		
      </div>
    </div>
	
	
  </div>
  
  
  
  
  
<script>
			// action save
			$("#FrmAjax").on('submit',(function(e) {
				e.preventDefault();
				$.ajax({
				url: "<?=base_url()?>act_sop/<?=$act?>", 
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					if(data == '1'){
						alert('Data Berhasil Disimpan');
						location.href="<?=base_url()?>sop/evaluasi_sop"
					}else{
						  $('.alert').show();
						  $('.Errors').html('<div class="errors alert alert-danger alert-dismissible"><button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button><p>Errors : </p>'+data+'</div>');
					}
				}
				});
			}));
			
			var save_method;
			var table;
			$(document).ready(function() {
			   
			  table = $('#Tabel').DataTable({ 
				"processing": true,
				"serverSide": true,
				"responsive": true,
				"info":     false,
				"ajax": {
					"url": "<?php echo site_url('datatable/pilih_sop')?>",
					"type": "POST",
					"data": {
						'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
					 }
				},
				"columnDefs": [
				{ 
				  "targets": [ -1 ], //last column
				},
				],
			  });
			  
			});
</script>