<?php
$id = '';
$nama = '';
$status = 'Y';
$act = 'add_usergroup';
foreach($edit->result_array() as $row){
	$id = $row['user_group_id'];
	$nama = $row['user_group_name'];
	$status = $row['user_group_status'];
	$act = 'edit_usergroup';
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
		<a type="button" class="btn btn-warning" href="<?=base_url()?>settings/user_group">
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
					<div class="form-group row">
					  <label class="col-md-3 form-control-label">Nama Group</label>
					  <div class="col-md-9">
						<input type="text" class="form-control" name="GroupName" value="<?=$nama?>"/>
					  </div>
					</div>
					<div class="form-group row">
					  <label class="col-md-3 form-control-label">Status</label>
					  <div class="col-md-9">
						  <div class="radio-custom radio-default radio-inline">
							<input type="radio" id="a" name="StatusGroup" value="Y" <?=($status == 'Y' ? 'checked' : '')?>/>
							<label for="a">Aktif</label>
						  </div>
						  <div class="radio-custom radio-default radio-inline">
							<input type="radio" id="n" name="StatusGroup" value="N" <?=($status == 'N' ? 'checked' : '')?>/>
							<label for="n">Nonktif</label>
						  </div>
					  </div>
                      
                    </div>
				</div>
			  </div>
			  
			  <div class="panel">
				<div class="panel-body">
					<div class="form-group row">
					  <table class="table table-striped table-bordered table-hover">
							<thead>
							  <tr align="center">
								<th rowspan="2">Menu Name</th>
								<th width="30" align="center" rowspan="2">Checklist</th>
								<th width="30" align="center" colspan="4">Action</th>
							  </tr>
							  <tr>
								<th width="30" align="center">Add</th>
								<th width="30" align="center">Edit</th>
								<th width="30" align="center">Delete</th>
							  </tr>
							</thead>
							<tbody>
							<?php 
							if($this->uri->segment(3) == 'add'){
								foreach($listmenu->result_array() as $rows) {
									$this->menuchecklist->addToArray($rows['menu_id'], $rows['menu_name'], $rows['parent'], $rows['menu_level']);
								}
								$this->menuchecklist->drawTree();
							}else{
								foreach($listmenu->result_array() as $rows) {
									$this->menuchecklistedit->addToArray($rows['menu_id'], $rows['menu_name'], $rows['parent'], $rows['menu_level'], $rows['checklist'], $rows['checkadd'], $rows['checkedit'], $rows['checkdelete']);
								}
								$this->menuchecklistedit->drawTree(); 
							}
							?>
							</tbody>
						</table>
                      
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
						location.href="<?=base_url()?>settings/user_group"
					}else{
						  $('.alert').show();
						  $('.Errors').html('<div class="errors alert alert-danger alert-dismissible"><button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button><p>Errors : </p>'+data+'</div>');
					}
				}
				});
			}));
</script>