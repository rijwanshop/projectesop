<input type="hidden" id="id_user" value="<?php echo $id_user; ?>" />
<input type="hidden" id="id_max" value="<?php echo isset($id_max) ? $id_max : '' ; ?>" />

<?php if($id_user > 0){ ?>
	<?php if($chat->num_rows() > 0){ ?>	
		<?php foreach($chat->result() as $row){ ?>
			<?php if($row->user_from == $userid){ ?>
				<?php $user		= $this->Komunikasi_m->getAllUser(array("id_user" => $userid))->row_array(); ?>
				<?php $foto		= $this->db->query("SELECT user_foto,user_fullname from user where user_id='".$userid."'")->row_array(); ?>
				<div class="chat">
					<div class="chat-avatar">
					  <a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title="<?=$foto['user_fullname']?>">
						<img src="<?=base_url()?>assets<?=($foto['user_foto'] != '' ? '/media/profile/'.$foto['user_foto'].'' : '/global/portraits/5.jpg')?>" alt="<?=$foto['user_foto']?>">
					  </a>
					</div>
					<div class="chat-body">
					  <div class="chat-content" style="text-align:left">
						<p style="float:left;"><?php echo nl2br($row->chating_message); ?></p>
						<small style="float:right; margin-left:20px; margin-top:3px;"><?php echo date("H:i", strtotime($row->chating_date)); ?> <!--<b><?php echo $row->chating_status; ?></b>--></small>
					  </div>
					</div>
				  </div>
			<?php }else{ ?>
				  <?php $user		= $this->Komunikasi_m->getAllUser(array("id_user" => $id_user))->row_array(); ?>
				  <?php $foto		= $this->db->query("SELECT user_foto,user_fullname from user where user_id='".$id_user."'")->row_array(); ?>
				  <div class="chat chat-left">
					<div class="chat-avatar">
					  <a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title="<?=$foto['user_fullname']?>">
						<img src="<?=base_url()?>assets<?=($foto['user_foto'] != '' ? '/media/profile/'.$foto['user_foto'].'' : '/global/portraits/5.jpg')?>" alt="<?=$foto['user_foto']?>">
					  </a>
					</div>
					<div class="chat-body">
					  <div class="chat-content" style="text-align:left">
						<p style="float:left;"><?php echo nl2br($row->chating_message); ?></p>
						<small style="float:right; margin-left:20px; margin-top:3px;"><?php echo date("H:i", strtotime($row->chating_date)); ?> <!--<b><?php echo $row->chating_status; ?></b>--></small>
					  </div>
					</div>
				  </div>
			<?php } ?>
		<?php } ?>
	<?php }else{ ?>
	
	<?php } ?>
<?php } else { echo "<h2>Chatt with $nama; </h2>"; } ?>