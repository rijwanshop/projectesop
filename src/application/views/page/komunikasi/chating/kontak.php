<?php foreach($listuser->result_array() as $row){?>
<li class="list-group-item" style="cursor:pointer" onClick="getChatAll('<?php echo $row['user_id'] ?>','0'); aktifkan('<?php echo $row['user_id']  ?>')" id="aktif-<?php echo $row['user_id'] ?>" id="<?php echo $row['user_id'] ?>" >
  <div class="media" id="user">
	<div class="pr-20">
	  <a class="avatar avatar-online" href="javascript:void(0)">
		<img src="<?=base_url()?>assets<?=($row['user_foto'] != '' ? '/media/profile/'.$row['user_foto'].'' : '/global/portraits/5.jpg')?>" alt="<?=$row['user_fullname']?>">
		<i></i></a>
	</div>
	<div class="media-body">
	  <h5 class="mt-0 mb-5"><?=$row['user_fullname']?></h5>
	  <span class="media-time"><?=($row['chatdate']=='' ? '' : time_ago($row['chatdate']))?></span>
	</div>
	<div class="pl-20">
	  <span class="badge badge-pill badge-danger"><?=($row['jmlchat'] == 0 ? '' : $row['jmlchat'])?></span>
	</div>
  </div>
</li>
<?php }?>