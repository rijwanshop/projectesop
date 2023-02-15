<?php 
$judul='';
$isi='';
foreach($content->result_array() as $row){
	$judul = $row['content_nama'];
	$isi = $row['content_isi'];
}
?>
<section id="inner-title" class="inner-title">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-lg-6"><h2><?=$judul?></h2></div>
      <div class="col-md-6 col-lg-6">
        <div class="breadcrumbs">
          <ul>
            <li>Current Page:</li>
            <li><a href="<?=site_url('beranda')?>">Home</a></li>
            <li><a href="<?= $link ?>"><?=$judul?></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section> 
<section id="section18" class="section-margine" style="margin-bottom:30px">
  <div class="container">
  <div class="section18">
    <div class="row">
      <div class="col-md-12 col-lg-12 wow fadeInUp">
        <div class="textcont" style="font-size:14px">
			<?=$isi?>
		</div>  
      </div>
      <!-- <div class="col-md-4 col-lg-4 wow fadeInUp" data-wow-delay=".2s">
        <div class="section-18-img">
          <img src="images/a0.jpg"  class="img-responsive" alt=""/>
        </div>
      </div> -->
    </div>
  </div>  
  </div>
</section>