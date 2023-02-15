<style type="text/css">
  table th{
    text-align: center;
  }
  table td:nth-child(1), table td:nth-child(6){
    text-align: center;
  }
  table td:nth-child(4), table td:nth-child(5){
    text-align: justify;
  }
</style>
<div class="page" style="max-width: 1300px;">
	<div class="page-header">
    	<h1 class="page-title"><?=$title?></h1>
      	<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="<?=base_url()?>dashboard">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">SOP</li>
	  	</ol>
      	<div class="page-header-actions">
			<a type="button" class="btn btn-warning" href="<?= $back_link ?>">
				<i class="icon wb-arrow-left" aria-hidden="true"></i> Back
			</a>
      </div>
    </div>
	
	
    <div class="page-content container-fluid">
      	<div class="row">
			<div class="col-lg-12">
			  	<div class="panel">
					<div class="panel-body">
						<?php if($list_catatan->num_rows() > 0): ?>

						<b>List Catatan SOP</b>
						<br>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama</th>
                  					<th>NIP</th>
									<th>Jabatan</th>
									<th>Catatan</th>
                  					<th>Waktu</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($list_catatan->result() as $row): ?>
								<tr>
									<td style="width: 5%;"><?= $no++; ?></td>
                  					<td style="width: 15%;"><?= $row->nama_pereview ?></td>
                  					<td style="width: 10%;"><?= $row->nipbaru ?></td>
									<td style="width: 20%;"><?= $row->jabatan ?></td>
									<td style="width: 37%;"><?= $row->catatan_review ?></td>
                  					<td style="width: 13%;"><?= date('d-m-Y H:i:s', strtotime($row->tanggal_catatan)) ?></td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
						<br><br>
						
					<?php endif; ?>

						<div id="message"></div>
						<div class="col-lg-12">
							<form class="form-horizontal" id="form-review">
								<input type="hidden" name="alias" id="alias" value="<?= $sop->sop_alias; ?>">
								<input type="hidden" name="id" value="<?= $review->idlist_review ?>">
								<div class="form-group row">
    								<label for="nama_sop" class="col-sm-2 col-form-label">
    									Nama SOP
    								</label>
    								<div class="col-sm-8">
      									<input type="text" name="nama_sop" id="nama_sop" class="form-control" value="<?= strtoupper($sop->sop_nama) ?>" readonly />
    								</div>
  								</div>
  								<div class="form-group row">
    								<label for="tanggal_pembuatan_sop" class="col-sm-2 col-form-label">
    									Tanggal Penyusunan
    								</label>
    								<div class="col-sm-2">
      									<input type="text" class="form-control" value="<?= $sop->sop_tgl_pembuatan ?>" readonly />
    								</div>
  								</div>
  								<div class="form-group row">
    								<label for="nama_sop" class="col-sm-2 col-form-label">
    									Status Peninjauan
    								</label>
    								<div class="col-sm-2">
      									<input type="text" class="form-control" value="Ditolak" readonly />
    								</div>
  								</div>	
  								<div class="form-group row">
    								<label for="catatan_review" class="col-sm-2 col-form-label">
    									Catatan SOP <span style="color: red;">*</span>
    								</label>
    								<div class="col-sm-8">
      									<textarea name="catatan_review" id="catatan_review" class="form-control" rows="4" placeholder="Catatan SOP"></textarea>
    								</div>
  								</div>
  								<div class="form-group row">
    								<div class="offset-md-2 col-md-10">
      									<button type="submit" class="btn btn-primary">Submit</button>
    								</div>
  								</div>
							
							</form>
						</div>
					</div>
			  	</div>
			</div>
      	</div>
    </div>
</div>
<script src="<?= base_url(); ?>assets/plugins/select2/select2.js"></script>
<script>
	$(document).ready(function(){
		$.extend({
			xResponse: function(url, data) {
			var theResponse = null;
			$.ajax({
				url: url,
				type: 'GET',
				dataType: "JSON",
				async: false,
				success: function(respText) {
					theResponse = respText;
				}
			});
			return theResponse;
			}
		});
		function token_csrf(){
			var csrf = $.xResponse('<?= site_url('pengolahan_sop/get_csrf') ?>', {issession: 1,selector: true});
			return csrf;
		}
		
		$('#form-review').submit(function(e){
			e.preventDefault();
			var data = $(this).serializeArray(); 
			data.push({name: "<?= $this->security->get_csrf_token_name(); ?>", value: token_csrf()});
			$.ajax({ 
				url: '<?= $input_post ?>',
				type: "POST",
				data: data,
				dataType: 'json',
				success: function(response){
					if(response.success == true)
						window.location = '<?= $back_link ?>';
					else{
						$('#message').show().html(response.message);
						$('#message').fadeOut(4000);
					}
				}
			});
		});
	});
</script>