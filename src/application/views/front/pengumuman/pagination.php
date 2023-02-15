<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />


<?php if(!empty($posts)): foreach($posts as $row): ?>
	<div class="section-14-box">
	  <img src="<?=base_url()?>assets/media/pengumuman/<?=$row['pengumuman_gambar']?>" class="img-responsive" alt="<?=$row['pengumuman_judul']?>">
	  <h3><a href="<?=base_url()?>pengumuman/<?=$row['pengumuman_alias']?>"><?=$row['pengumuman_judul']?></a></h3>
	  <div class="row">
		<div class="col-md-12 col-lg-12">
		  <div class="comments">
			<a class=""><i class="fa fa-calendar"></i> <?=tgl_indo2($row['pengumuman_tanggal'])?></a> 
			<a class=""><i class="fa fa-user"></i> <?=$row['pengumuman_penulis']?></a>
		  </div>
		</div>
	  </div>
	  <div style="text-align:justify"><?=character_limiter($row['pengumuman_isi'],580)?></div>
	  <div class="row">
		<div class="col-md-12 col-lg-12">
		  <div class="text-left"><a href="<?=base_url()?>pengumuman/<?=$row['pengumuman_alias']?>" class="btn btn-primary">Read More</a></div>
		</div>
	  </div>
	</div>
 <?php endforeach; else: ?>
	<div class="section-14-box">
	   Berita tidak ditemukan
	</div>
<?php endif; ?>
			
			
<!-- Start Pagination -->
<div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div></div>
<div id="pagination">
	<?php echo $this->ajax_pagination->create_links(); ?>
</div>
<!-- End Pagination -->