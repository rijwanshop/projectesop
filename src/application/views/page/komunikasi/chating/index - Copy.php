  <div class="page page-user">
    <div class="page-header">
      <h1 class="page-title">Chating</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
		<li class="breadcrumb-item active">Komunikasi</li>
      </ol>
    </div>
    <div class="page-content">
      <!-- Panel Title -->
			<div class="row">
			<div class="col-xl-8">
				  <div class="panel">
					<div class="panel-body">
					  <div class="chat-box" style="height:450px; overflow: auto">
						<div class="chats">Pilih User Untuk Memulai</div>
					  </div>
					</div>
					<div class="panel-footer pb-30">
					  <form id="FrmAjax">
						<div class="input-group">
						  <input type="hidden" name="userto" class="form-control userto">
						  <input type="text" name="tulis" class="form-control" placeholder="Tulis disini" maxlength="100">
						  <span class="input-group-btn">
							<button class="btn btn-primary" type="submit">Send</button>
						  </span>
						</div>
					  </form>
					</div>
				  </div>
			</div>
			<div class="col-xl-4">
			<link rel="stylesheet" href="http://localhost/template/classic/topicon/assets/examples/css/pages/user.css">
			
			
					  <!-- Panel -->
					  <div class="panel">
						<div class="panel-body">
						  <form class="page-search-form" role="search" style="margin-bottom:10px">
							<div class="input-search input-search-dark">
							  <i class="input-search-icon wb-search" aria-hidden="true"></i>
							  <input type="text" class="form-control" id="inputSearch" name="search" placeholder="Search Users">
							  <button type="button" class="input-search-close icon wb-close" aria-label="Close"></button>
							</div>
						  </form>
								<ul class="list-group">
								  <?php foreach($listuser->result_array() as $row){?>
								  <li class="list-group-item UsersChat" style="cursor:pointer;" id="u-<?=$row['user_id']?>">
									<div class="media">
									  <div class="pr-20">
										<div class="avatar avatar-online">
										  <img src="<?=base_url()?>assets/global/portraits/5.jpg" alt="...">
										  <i class="avatar avatar-busy"></i>
										</div>
									  </div>
									  <div class="media-body">
										<h5 class="mt-0 mb-5">
										  <?=$row['user_fullname']?>
										  <!--<small>Last Access: 1 hour ago</small>-->
										</h5>
										<div>
										  <a class="text-action" href="javascript:void(0)">
											<i class="icon icon-color wb-envelope" aria-hidden="true"></i>
										  </a>
										  <a class="text-action" href="javascript:void(0)">
											<i class="icon icon-color wb-mobile" aria-hidden="true"></i>
										  </a>
										</div>
									  </div>
									</div>
								  </li>
								  <?php } ?>
								</ul>
								
							  </div>
							</div>

			</div>
			</div>
			
      <!-- End Panel Title -->
    </div>
  </div>
  
  
  
  <script>
  $(document).ready(function(){
	  $("body").removeClass("animsition site-navbar-small dashboard");
	  $("body").addClass("animsition site-navbar-small app-message page-aside-scroll page-aside-left");
  });
  
	$('.UsersChat').click(function(){
		var id = this.id;
		var userto = id.split('-');
		$('.UsersChat').css('background','#fff');
		$('#'+id+'').css('background','#eee');
		$('.userto').val(userto[1]);
		$.post("<?php echo base_url();?>load_komunikasi/chat/"+userto[1]+"",{},function(obj){
			$('.chats').html(obj);
		});
	});
	// action save
	$("#FrmAjax").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
		url: "<?=base_url()?>load_komunikasi/send", 
		type: "POST",             // Type of request to be send, called as method
		data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
		contentType: false,       // The content type used when sending data to the server.
		cache: false,             // To unable request pages to be cached
		processData:false,        // To send DOMDocument or non processed data file it is set to false
		success: function(data)   // A function to be called if request succeeds
		{
			$('.chats').html(data);
		}
		});
	}));
</script>