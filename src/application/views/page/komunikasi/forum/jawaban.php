
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
		  <div class="flags responsive-hide">
			<span class="sticky-top badge badge-round badge-danger"><i class="icon wb-dropup" aria-hidden="true"></i>TOP</span>
			<i class="locked icon wb-lock" aria-hidden="true"></i>
		  </div>
		</div>
		<div class="metas">
		  <span class="author">By Herman Beck</span>
		  <span class="started">1 day ago</span>
		  <span class="tags">Themes</span>
		</div>
	  </div>
	</td>
	<td class="cell-80 forum-posts">
	  <span class="num">1</span>
	  <span class="unit">Post</span>
	</td>
	<td class="suf-cell"></td>
  </tr>
<?php } ?>
</tbody>
</table>
<ul class="pagination pagination-gap" id="ajax_pagingsearc1">
<?php echo $links; ?>
</ul>