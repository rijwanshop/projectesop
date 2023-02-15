
<table class="table is-indent">
<tbody>
<?php foreach($results as $data) {?>
  <tr data-url="<?=base_url()?>komunikasi/topik/<?=$data->diskusi_id?>" data-toggle="slidePanel">
	<td class="pre-cell"></td>
	<td class="cell-60 responsive-hide">
	  <a class="avatar" href="javascript:void(0)">
		<img class="img-fluid" src="<?=base_url()?>assets<?=($data->user_foto != '' ? '/media/profile/'.$data->user_foto.'' : '/global/portraits/1.jpg')?>" alt="<?=$data->created_by?>">
	  </a>
	</td>
	<td>
	  <div class="content">
		<div class="title">
		  <?=$data->diskusi_topik?>
		</div>
		<div class="metas">
		  <span class="author"><?=$data->created_by?></span>
		  <span class="started"><?=$data->created_on?></span>
		  <span class="tags"><?=$data->kategori_diskusi_judul?></span>
		</div>
	  </div>
	</td>
	<td class="cell-80 forum-posts">
	  <span class="num"><?=$data->jmlpost?></span>
	  <span class="unit">Post</span>
	</td>
	<td class="suf-cell"></td>
  </tr>
<?php } ?>
</tbody>
</table>
<ul class="pagination pagination-gap" id="ajax_pagingsearc">
<?php echo $links; ?>
</ul>