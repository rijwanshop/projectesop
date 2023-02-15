<?php
$id = '';
$nama = '';
$status = 'Y';
$act = 'add_kategori_sop';
foreach($edit->result_array() as $row){
	$id = $row['kategori_id'];
	$nama = $row['kategori_nama'];
	$status = $row['kategori_status'];
	$act = 'edit_kategori_sop';
}

?>

<div class="page">
	<div class="page-header">
      <h1 class="page-title"><?=$title?></h1>
      <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
		<li class="breadcrumb-item active">Master</li>
	  </ol>
      <div class="page-header-actions">
		<a type="button" class="btn btn-warning" href="<?=base_url()?>master/jenis_sop">
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
				  <input type="hidden" name="id" value="<?=$id?>"/>
					<div class="Errors"></div>
					<div class="form-group row">
					  <label class="col-md-3 form-control-label">Nama</label>
					  <div class="col-md-9">
						<input type="text" class="form-control" name="nama" value="<?=$nama?>"/>
					  </div>
					</div>
					<div class="form-group row">
					  <label class="col-md-3 form-control-label">Status</label>
					  <div class="col-md-9">
						  <div class="radio-custom radio-default radio-inline">
							<input type="radio" id="a" name="status" value="Y" <?=($status == 'Y' ? 'checked' : '')?>/>
							<label for="a">Aktif</label>
						  </div>
						  <div class="radio-custom radio-default radio-inline">
							<input type="radio" id="n" name="status" value="N" <?=($status == 'N' ? 'checked' : '')?>/>
							<label for="n">Nonaktif</label>
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
				url: "<?=base_url()?>act_master/<?=$act?>", 
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					if(data == '1'){
						alert('Data Berhasil Disimpan');
						location.href="<?=base_url()?>master/jenis_sop"
					}else{
						  $('.alert').show();
						  $('.Errors').html('<div class="errors alert alert-danger alert-dismissible"><button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button><p>Errors : </p>'+data+'</div>');
					}
				}
				});
			}));
</script>