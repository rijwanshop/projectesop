<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/animsition/animsition.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/asscrollable/asScrollable.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/switchery/switchery.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/intro-js/introjs.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/slidepanel/slidePanel.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/flag-icon-css/flag-icon.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/chartist/chartist.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/aspieprogress/asPieProgress.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/jquery-selective/jquery-selective.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/asscrollable/asScrollable.css">
<link rel="stylesheet" href="<?=base_url()?>assets/examples/css/dashboard/team.css">


<script src="<?=base_url()?>assets/global/vendor/switchery/switchery.min.js"></script>
<script src="<?=base_url()?>assets/global/vendor/intro-js/intro.js"></script>
<script src="<?=base_url()?>assets/global/vendor/screenfull/screenfull.js"></script>
<script src="<?=base_url()?>assets/global/vendor/slidepanel/jquery-slidePanel.js"></script>
<script src="<?=base_url()?>assets/global/vendor/chartist/chartist.js"></script>
<script src="<?=base_url()?>assets/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.min.js"></script>
<script src="<?=base_url()?>assets/global/vendor/aspieprogress/jquery-asPieProgress.js"></script>
<script src="<?=base_url()?>assets/global/vendor/matchheight/jquery.matchHeight-min.js"></script>
<script src="<?=base_url()?>assets/global/vendor/jquery-selective/jquery-selective.min.js"></script>
<script src="<?=base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>

<link rel="stylesheet" href="<?=base_url()?>assets/css/video.css">

  <!-- Page -->
  <div class="page">
    <div class="page-content container-fluid">
      <div class="row" data-plugin="matchHeight" data-by-row="true">
	  
				<div class="page-content container-fluid">
				  <div class="row">
				  
					<div class="col-md-6">
						<div class="panel">
						<div class="panel-body">
						  <h4 style="border-bottom:1px dashed #ddd; padding-bottom:20px; margin-bottom:20px">Video Tutorial Penyusunan SOP</h4>
						
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
				  
					<div class="col-md-6">
					  <!-- Panel Basic -->
					  <div class="panel">
						<div class="panel-body">
						  <h4 style="border-bottom:1px dashed #ddd; padding-bottom:20px; margin-bottom:20px">Selamat Datang, <?= $this->session->userdata('fullname') ?></h4>
						  Selamat datang di sistem e-SOP Kementerian Sekretariat Negara.
						</div>
					  </div>
					  <div class="panel">
						<div class="panel-body">
						  <h4 style="border-bottom:1px dashed #ddd; padding-bottom:20px; margin-bottom:20px">Panduan Teknis Sistem</h4>
						  Untuk membantu menggunakan sistem e-SOP Kementerian Sekretarian Negara, kami menyediakan panduan penggunaan baik video maupun manual book.<br><br>
						  <a href="<?=site_url()?>panduan" class="btn btn-squared btn-success btn-lg waves-effect waves-classic"><i class="fa fa-book"></i> Document</a>
						</div>
					  </div>
					  <!-- End Panel Basic -->
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