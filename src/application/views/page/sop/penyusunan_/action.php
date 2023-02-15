<script src="<?=base_url()?>assets/global/js/Plugin/responsive-tabs.js"></script>
<script src="<?=base_url()?>assets/global/js/Plugin/closeable-tabs.js"></script>
<script src="<?=base_url()?>assets/global/js/Plugin/tabs.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css" />
<script src="<?=base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<style>
	#fix {
  		background:#fff;
  		width:31cm;
  		z-index:9
	}
</style>
<script>
	jQuery(function($) {
  		function fixDiv() {
    		var $cache = $('#fix');
    		if ($(window).scrollTop() > 100)
      			$cache.css({
        			'position': 'fixed',
        			'top': '130px'
      			});
    		else
      			$cache.css({
        			'position': 'relative',
        			'top': 'auto'
      			});
  		}
  		$(window).scroll(fixDiv);
  		fixDiv();
	});
</script>

<div class="modal" id="LoadingImage" style="display: none;"></div>
	<div class="page" style="max-width: 1300px;">
		<div class="page-header">
      		<h1 class="page-title"><?=$title?></h1>
      		<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
				<li class="breadcrumb-item active">SOP</li>
	  		</ol>
      		<div class="page-header-actions">
				<a type="button" class="btn btn-warning" href="<?=base_url()?>sop/penyusunan_sop">
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
				  
							<div class="alert dark alert-success alert-dismissible" role="alert" id="bgalert" style="display:none">
								<button type="button" class="close">
									<span>×</span>
							  	</button>
							  	SOP Berhasil Disimpan
							</div>
							<div class="nav-tabs-horizontal" data-plugin="tabs">
								<div id="fix">
									<ul class="nav nav-tabs nav-tabs-line mr-25" role="tablist">
										<li class="nav-item" role="presentation">
											<a class="nav-link active" data-toggle="tab" href="#Identitas"
									  aria-controls="Identitas" role="tab">
												Identitas
											</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="nav-link" data-toggle="tab" href="#Kegiatan"
									  aria-controls="Kegiatan" role="tab">
												Kegiatan
											</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="nav-link" data-toggle="tab" href="#Hasil"
									  aria-controls="Hasil" role="tab">
												Hasil
											</a>
										</li>
								  	</ul>
								</div>
								<div class="tab-content py-15">
									<div class="tab-pane active" id="Identitas" role="tabpanel">
										<?php $this->load->view('page/sop/penyusunan/header');?>
									</div>
									<div class="tab-pane" id="Kegiatan" role="tabpanel">
										<?php $this->load->view('page/sop/penyusunan/kegiatan');?>
									</div>
									<div class="tab-pane" id="Hasil" role="tabpanel">
									    <form class="FrmHasil" method="post" enctype="multipart/form-data">
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
											<div id="HasilTableHeader" style="margin-left:-20px"></div>
											<div id="HasilTableKeg" style="margin-left:-20px"></div>
											<input type="hidden" id="id" name="id" value="">
										</form>
									</div>
								</div>
							 </div>
					  
						</div>
			  		</div>
			  	<!-- End Panel Summary Mode -->
				</div>
      		</div>
    	</div>
  	</div>
</div>
  
<script>
			// action save
			$("#FrmHeader").on('submit',(function(e) {
				$("#LoadingImage").show();
				e.preventDefault();
				$.ajax({
				url: "<?=base_url()?>load_sop/add_header", 
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					$("#LoadingImage").hide();
					$('ul.nav li:nth-child(1) a').removeClass("active");
					$('ul.nav li:nth-child(2) a').addClass("active");
					$('#Identitas').removeClass("active");
					$('#Kegiatan').addClass("active");
					
					$('#HasilTableHeader').html(data);
				}
				});
			}));
			
			$("#FrmKegiatan").on('submit',(function(e) {
				$("#LoadingImage").show();
				e.preventDefault();
				$.ajax({
				url: "<?=base_url()?>load_sop/add_kegiatan", 
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					$("#LoadingImage").hide();
					$('ul.nav li:nth-child(2) a').removeClass("active");
					$('ul.nav li:nth-child(3) a').addClass("active");
					$('#Kegiatan').removeClass("active");
					$('#Hasil').addClass("active");
					
					$('#HasilTableKeg').html(data);
				}
				});
			}));
			
			$(".FrmHasil").on('submit',(function(e) {
				$("#LoadingImage").show();
				e.preventDefault();
				$.ajax({
				url: "<?=base_url()?>act_sop/add_sop", 
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values)
				dataType:'html', 
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					$("#LoadingImage").hide();
					if(data != 'Identitas Kosong'){
						$('#bgalert').show();
						$('#id').val(data);
					}else{
						  alert(data);
					}
				}
				});
			}));
			
			$(".close").click(function(){
				$("#bgalert").hide();
			});
</script>