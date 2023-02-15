
<?php
$id = '';
$nama = '';
$file = '';
$satker = '';
$unitkerja='';
$bagian='';
$alias='';
foreach($editsop->result_array() as $row){
	$id = $row['id'];
	$nama = $row['sop_nama'];
	$file = $row['file'];
	$satker = $row['satuan_organisasi_id'];
	$unitkerja = $row['unit_kerja_id'];
	$bagian = $row['bagian_id'];
	$alias = $row['sop_alias'];
}
$act = 'upload_berkassop';
?>

<div class="page">
	<div class="page-header">
      <h1 class="page-title"><?=$title?></h1>
      <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
		<li class="breadcrumb-item active">SOP</li>
	  </ol>
      <div class="page-header-actions">
		<a type="button" class="btn btn-warning" href="<?=base_url()?>sop/upload">
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
				  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
					<div class="Errors"></div>
					<div class="form-group row">
					  <div class="form-group col-md-4">
                        <label class="form-control-label">Satuan Organisasi</label>
                        <select class="form-control" id="satker" name="satker">
							<option value="">Pilih Satuan Organisasi</option>
							<?php foreach($dtsatker->result_array() as $row){?>
							<option value="<?=$row['satuan_organisasi_id']?>" <?=($satker == $row['satuan_organisasi_id'] ? 'selected' : '')?>><?=$row['satuan_organisasi_nama']?></option>
							<?php } ?>
						</select>
                      </div>
					  <div class="form-group col-md-4">
                        <label class="form-control-label">Unit Kerja</label>
                        <select class="form-control" id="unitkerja" name="unitkerja">
							<option value="">Pilih Satuan Organisasi</option>
						</select>
                      </div>
					  <div class="form-group col-md-4">
                        <label class="form-control-label">Bagian</label>
                        <select class="form-control" id="bagian" name="bagian">
							<option value="">Pilih Satuan Organisasi</option>
						</select>
                      </div>
					  
					  <div class="form-group col-md-6">
                        <label class="form-control-label">Nama SOP</label>
                        <input type="text" class="form-control" name="namasop" value="<?=$nama?>">
                      </div>
					  
					  <div class="form-group col-md-6">
                        <label class="form-control-label">File Upload</label>
                        <input type="file" class="form-control" name="fileupload"><br>
						<i>File dalam format .pdf</i><br><br>
						<?php if($file != ''){
							echo '<a href="'.site_url().'sop/pdf_sop/'.$alias.'" target="_blank">'.$file.'</a>';
						}?>
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
						location.href="<?=base_url()?>sop/upload"
					}else{
						  $('.alert').show();
						  $('.Errors').html('<div class="errors alert alert-danger alert-dismissible"><button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button><p>Errors : </p>'+data+'</div>');
					}
				}
				});
			}));
			
			
			<?php if($id != ''){ ?>
			$(document).ready(function(){ 
					$.post("<?php echo base_url();?>view/unit_kerja/<?=$satker?>/<?=$unitkerja?>",{
						'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
					},function(obj){
						$('#unitkerja').html(obj);
					});
					$.post("<?php echo base_url();?>view/bagian/<?=$unitkerja?>/<?=$bagian?>",{
						'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
					},function(obj){
						$('#bagian').html(obj);
					});
			}); 
			<?php } ?>
			
			
			$('#satker').change(function(){
				$.post("<?php echo base_url();?>view/unit_kerja/"+$('#satker').val(),{
					'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
				},function(obj){
					$('#unitkerja').html(obj);
					$('#bagian').html('');
				});
			});
			$('#unitkerja').change(function(){
				$.post("<?php echo base_url();?>view/bagian/"+$('#unitkerja').val(),{
					'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
				},function(obj){
					$('#bagian').html(obj);
				});
			});
</script>