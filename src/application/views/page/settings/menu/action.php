<?php
$id = '';
$nama = '';
$link = '';
$act = 'add_menu';
foreach($edit->result_array() as $row){
	$id = $row['menu_id'];
	$nama = $row['menu_name'];
	$link = $row['menu_link'];
	$act = 'edit_menu';
}

?>

<div class="page">
	<div class="page-header">
      <h1 class="page-title"><?=$title?></h1>
      <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
		<li class="breadcrumb-item active">Settings</li>
	  </ol>
      <div class="page-header-actions">
		<a type="button" class="btn btn-warning" href="<?=base_url()?>settings/menu_manager">
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
					<input type='hidden' name="parent" value="<?=$this->uri->segment(4)?>">
					<input type='hidden' name="order" value="<?=$order?>">
					<input type='hidden' name="level" value="<?=$this->uri->segment(6)?>">
					<div class="Errors"></div>
					<div class="form-group row">
					  <label class="col-md-3 form-control-label">Nama Menu</label>
					  <div class="col-md-9">
						<input class='form-control' placeholder='Menu Name' type='text' name="nama" value="<?=$nama?>">
					  </div>
					</div>
					<div class="form-group row">
					  <label class="col-md-3 form-control-label">Link</label>
					  <div class="col-md-9">
						<input class='form-control' placeholder='Menu Link' type='text' name="link" value="<?=$link?>">
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
				url: "<?=base_url()?>act_settings/<?=$act?>", 
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					if(data == '1'){
						alert('Data Berhasil Disimpan');
						location.href="<?=base_url()?>settings/menu_manager"
					}else{
						  $('.alert').show();
						  $('.Errors').html('<div class="errors alert alert-danger alert-dismissible"><button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button><p>Errors : </p>'+data+'</div>');
					}
				}
				});
			}));
</script>