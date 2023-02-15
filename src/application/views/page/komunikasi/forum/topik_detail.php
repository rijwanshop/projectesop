<?php
foreach($topik->result_array() as $row){
	$id = $row['diskusi_id'];
	$judul = $row['diskusi_topik'];
	$isi = $row['diskusi_isi'];
	$kategori = $row['kategori_diskusi_id'];
	$on = $row['created_on'];
	$by = $row['created_by'];
	$foto = $row['user_foto'];
}
?>

<header class="slidePanel-header">
  <div class="slidePanel-actions" aria-label="actions" role="group">
    <button type="button" class="btn btn-pure btn-inverse slidePanel-close actions-top icon wb-close"
      aria-hidden="true"></button>
  </div>
  <h1><?=$judul?></h1>
</header>
<div class="slidePanel-inner">
  <section class="slidePanel-inner-section">
    <div class="forum-header">
      <a class="avatar" href="javascript:void(0)">
		<img class="img-fluid" src="<?=base_url()?>assets<?=($foto != '' ? '/media/profile/'.$foto.'' : '/global/portraits/1.jpg')?>" alt="<?=$by?>">
      </a>
      <span class="name"><?=$by?></span>
      <span class="time"><?=$on?></span>
    </div>
    <div class="forum-content">
      <?=$isi?>
    </div>
    <div class="forum-metas">
      <div class="float-right">
        <!--<button type="button" class="btn btn-icon btn-pure btn-default">
          <i class="icon wb-thumb-up" aria-hidden="true"></i>
          <span class="num">2</span>
        </button>-->
      </div>
    </div>
  </section>
  
<?php

$replay_topik = $this->Komunikasi_m->topik_replay($id);
if($replay_topik->num_rows() > 0){
$no = 0;
foreach($replay_topik->result_array() as $row){
	$no++;
	$isi = $row['replay_diskusi_isi'];
	$on = $row['created_on'];
	$by = $row['created_by'];
	$foto = $row['user_foto'];
	
?>
  <section class="slidePanel-inner-section">
    <div class="forum-header">
      <div class="float-right">#
        <span class="floor"><?=$no?></span>
      </div>
      <a class="avatar" href="javascript:void(0)">
		<img class="img-fluid" src="<?=base_url()?>assets<?=($foto != '' ? '/media/profile/'.$foto.'' : '/global/portraits/1.jpg')?>" alt="<?=$by?>">
      </a>
      <span class="name"><?=$by?></span>
      <span class="time"><?=$on?></span>
    </div>
    <div class="forum-content">
      <?=$isi?>
      <div class="float-right">
        <!--<button type="button" class="btn btn-icon btn-pure btn-default">
          <i class="icon wb-thumb-up" aria-hidden="true"></i>
          <span class="num">2</span>
        </button>-->
      </div>
    </div>
  </section>
<?php }}else{ ?>
  <section class="slidePanel-inner-section">
    <div class="forum-content">
      Belum Ada Tanggapan
    </div>
  </section>
<?php } ?>

  <form action="<?=base_url()?>act_komunikasi/add_replay" method="POST">
  <input type="hidden" name="diskusiid" value="<?=$id?>">
  <input type="hidden" name="kategori" value="<?=$kategori?>">
  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
  <div class="slidePanel-comment">
	<div class="Errors"></div>
    <textarea name="replay" class="maxlength-textarea form-control mb-sm mb-20" rows="4"></textarea>
    <button class="btn btn-primary" type="submit">Reply</button>
  </div>
  </form>
</div>
