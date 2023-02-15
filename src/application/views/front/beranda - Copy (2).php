
<section id="slider" class="">
  <!-- Carousel -->
  <div id="main-slide" class="carousel slide" data-ride="carousel">

    <!-- Indicators -->
    <ol class="carousel-indicators visible-lg visible-md">
	<?php foreach($slide->result_array() as $row){?>
        <li data-target="#main-slide" data-slide-to="<?=$row['slide_id']?>" class="active"></li>
	<?php } ?>
    </ol><!--/ Indicators end-->

    <!-- Carousel inner -->
    <div class="carousel-inner">
	
	  <?php foreach($slide->result_array() as $row){?>
      <div class="item active" style="background-image:url(<?=base_url()?>assets/media/slide/<?=$row['slide_gambar']?>)">
            <div class="slider-content text-left">
               <div class="col-md-12">
                   <h2 class="slide-title effect2">slide</h2>
                   <h3 class="slide-sub-title effect3"><?=$row['slide_judul']?></h3>
                   <p class="slider-description lead effect3"><?=$row['slide_isi']?></p>
                   <p class="effect3">
                    <a href="#" class="slider btn btn-secondary">Detail</a>
                   </p>      
               </div>
            </div>
       </div><!--/ Carousel item 1 end -->
       <?php } ?>
	   
    </div><!-- Carousel inner end-->

    <!-- Controllers -->
    <a class="left carousel-control" href="#main-slide" data-slide="prev">
        <span><i class="fa fa-angle-left"></i></span>
    </a>
    <a class="right carousel-control" href="#main-slide" data-slide="next">
        <span><i class="fa fa-angle-right"></i></span>
    </a>
  </div><!--/ Carousel end -->
</section>

<section id="section4" class="section-4 section-margine">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <header class="title-head">
          <h2>Pengumuman</h2>
          <p>Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc </p>
          <div class="line-heading">
            <span class="line-left"></span>
            <span class="line-middle">+</span>
            <span class="line-right"></span>
          </div>
        </header>
      </div>
    </div>
    <div class="row">
	
	  <?php foreach($pengumuman->result_array() as $row){?>
      <div class="col-md-4 col-lg-4">
        <div class="section-14-box wow fadeInUp">
          <img src="<?=base_url()?>assets/media/pengumuman/<?=$row['pengumuman_gambar']?>" class="img-responsive" alt="<?=$row['pengumuman_judul']?>">
          <h3><a href="<?=base_url()?>pengumuman/<?=$row['pengumuman_alias']?>"><?=$row['pengumuman_judul']?></a></h3>
          <div class="row">
            <div class="col-md-12 col-lg-12">
              <div class="comments">
                <a class="btn btn-primary btn-sm"><?=tgl_indo2($row['pengumuman_tanggal'])?></a>
              </div>
            </div>
          </div>
          <?=$row['pengumuman_isi']?>
        </div>
      </div>
	  <?php } ?>
	  
    </div>
  </div>
</section>

<section id="section-4" class="section-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <header class="title-head" style="margin-bottom:10px">
          <h2>Kegiatan</h2>
          <p>Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc </p>
          <div class="line-heading">
            <span class="line-left"></span>
            <span class="line-middle">+</span>
            <span class="line-right"></span>
          </div>
        </header>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-md-12">
        <div class="portfolioFilter text-center"> 
          <a href="#" data-filter="*" class="current">Semua Kategori</a>/ 
          <a href="#" data-filter=".kat1">Kat 1</a>/
          <a href="#" data-filter=".kat2">Kat 2</a>/
          <a href="#" data-filter=".kat3">Kat 3</a>/
          <a href="#" data-filter=".kat4">Kat 4</a>
        </div>
        <div class="portfolioContainer">
		<?php foreach($kegiatan->result_array() as $row){?>
          <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 <?=$row['kegiatan_kategori']?> text-center"> <a class="magnific-popup" href="<?=base_url()?>assets/media/kegiatan/<?=$row['kegiatan_gambar']?>"><img src="<?=base_url()?>assets/media/kegiatan/<?=$row['kegiatan_gambar']?>" class="img-responsive wow zoomIn" alt="image"></a> </div>
        <?php } ?>
		</div>
      </div>
    </div>
  </div>
</section>
