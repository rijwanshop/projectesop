<link rel="stylesheet" href="<?=base_url()?>assets/css/video.css">


  <!-- Page -->
  <div class="page">
    <div class="page-content container-fluid">
      <div class="row" data-plugin="matchHeight" data-by-row="true">
	  
				<div class="page-content container-fluid">
				  <div class="row">
				  
					<div class="col-md-6">
					  <!-- Panel Basic -->
					  <div class="panel">
						<div class="panel-body">
						  <h4 style="border-bottom:1px dashed #ddd; padding-bottom:20px; margin-bottom:20px"><i class="fa fa-book"></i> Document</h4>
						  <div class="row">
						  
							 <?php foreach($doc->result_array() as $r){ ?>
							 <div class="col-md-4">
								<a href="<?=base_url().'panduan/pdf_juknis/'.$r['id']?>" target="_blank">
								<div class="example">
								  <div class="card" style="text-align:center">
									<i class="fa-file-pdf-o" style="font-size:50px"></i>
									<div class="card-block" style="padding:10px 0 0 0">
									  <h4 class="card-title" style="font-size:14px; line-height:24px"><?=$r['judul']?></h4>
									</div>
								  </div>
								</div>
								</a>
							  </div>
							 <?php } ?>
							  
						  </div>
						</div>
					  </div>
					  <!-- End Panel Basic -->
					</div>
					
					<div class="col-md-6">
						<div class="panel">
						<div class="panel-body">
						  <h4 style="border-bottom:1px dashed #ddd; padding-bottom:20px; margin-bottom:20px"><i class="fa fa-camera"></i> Video</h4>
						
								<div class="vid-container">
									<?php
									$first = $video->row();
									$ex = explode('/',$first->link);
									$id = $ex[4];
									?>
									<iframe id="vid_frame" src="https://www.youtube.com/embed/<?=$id?>" frameborder="0" width="100%" height="315" allowfullscreen></iframe>
								</div>

								<div class="vid-list-container">
									<div class="vid-list">
									
										<?php foreach($video->result_array() as $r){ 
										$ex = explode('/',$r['link']);
										$id = $ex[4];
										?>
										<div class="vid-item" onClick="document.getElementById('vid_frame').src='http://youtube.com/embed/<?=$id?>?autoplay=1&rel=0&showinfo=0&autohide=1'">
										  <div class="thumb"><img src="http://img.youtube.com/vi/<?=$id?>/0.jpg"></div>
										  <div class="desc"><?=$r['judul']?></div>
										</div>
										<?php } ?>
										
									</div>
								</div>

								<!-- LEFT AND RIGHT ARROWS -->
								<div class="arrows">
									<div class="arrow-left"><i class="fa fa-chevron-left fa-lg"></i></div>
									<div class="arrow-right"><i class="fa fa-chevron-right fa-lg"></i></div>
								</div>
						</div>
						</div>
					  
					</div>
					
				  </div>
				</div>
      </div>
    </div>
  </div>
  <!-- End Page -->
  
  
   <script type="text/javascript">
	$(document).ready(function () {
		$(".arrow-right").bind("click", function (event) {
			event.preventDefault();
			$(".vid-list-container").stop().animate({
				scrollLeft: "+=336"
			}, 750);
		});
		$(".arrow-left").bind("click", function (event) {
			event.preventDefault();
			$(".vid-list-container").stop().animate({
				scrollLeft: "-=336"
			}, 750);
		});
	});
</script>