<link href="<?=base_url()?>assets/front/css/dataTables.bootstrap.min.css" rel="stylesheet">
<script src="<?=base_url()?>assets/front/js/jquery.dataTables.min.js"></script> 
<script src="<?=base_url()?>assets/front/js/dataTables.bootstrap.min.js"></script> 
  
<section id="inner-title" class="inner-title">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-lg-6"><h2>Evaluasi SOP</h2></div>
      <div class="col-md-6 col-lg-6">
        <div class="breadcrumbs">
          <ul>
            <li>Current Page:</li>
            <li><a href="<?=base_url()?>">Beranda</a></li>
            <li><a href="<?=base_url()?>">Evaluasi SOP</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section> 
<section id="section18" class="section-margine" style="margin-bottom:30px">
  <div class="container">
	<div class="row">
      <div class="col-md-12 col-lg-12">
        <header class="title-head" style="margin-bottom:10px">
          <h2>Evaluasi SOP</h2>
          <div class="line-heading">
            <span class="line-left"></span>
            <span class="line-middle">+</span>
            <span class="line-right"></span>
          </div>
        </header>
      </div>
    </div>
    <div class="row">
      <div class="col-md-2 col-lg-12 wow fadeInUp">
        <div class="textcont">
			<div class="Errors"></div>
			<?php if($cekpenilaian == 0){?>
				<div id="pertanyaan">
				<form id="FrmAjax">
					Berikan penilaian saudara terhadap SOP di bawah ini dengan memilih jawaban dibawah, apakah pelaksanaan kegiatan sudah sesuai dengan SOP ini pada setiap tahapannya?<br>
					Jawaban : 
					<ol>
						<?php foreach($pertanyaan->result_array() as $row){?>
							<li> <label><input type="radio" name="jawaban" class="jawaban" value="<?=$row['pertanyaan_isi']?>"> <?=$row['pertanyaan_isi']?></label></li>
						<?php } ?>
					</ol>
				</form>
				</div>
			<?php }else{ ?>
				<div class="errors alert alert-success alert-dismissible"><p>Success : </p>Anda sudah memberikan penilaian untuk SOP ini.</div>
			<?php } ?>
						<iframe scrolling="yes" frameborder="0"  src="<?=base_url()?>pdf/index.php?alias=<?=$this->uri->segment(3)?>" style="width:100%;height:1000px; padding:1% 2% 0 0.5%"></iframe>
		</div>  
      </div>
    </div>
  </div>
</section>

<script>
	$(document).ready(function() {
      $("input:radio").change(function(){
         $.post('<?=base_url()?>act_sop/add_jawaban', { 
			"jawaban": $(this).val()
			'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
		}, function(data) {
			if(data == '1'){
				$('#pertanyaan').hide();
				$('.Errors').html('<div class="errors alert alert-success alert-dismissible"><p>Success : </p>Anda sudah memberikan penilaian untuk SOP ini.</div>');
			}else{
				  $('.Errors').html('<div class="errors alert alert-danger alert-dismissible"><button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button><p>Errors : </p>'+data+'</div>');
			}
         });
      });
    });
</script>