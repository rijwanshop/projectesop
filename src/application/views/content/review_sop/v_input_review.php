<link rel="stylesheet" href="<?=base_url()?>assets/plugins/select2/select2.css" />
<style type="text/css">
	.select2 {
		width:100%!important;
	}
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
			<a type="button" class="btn btn-warning" href="<?= site_url('review_sop') ?>">
				<i class="icon wb-arrow-left" aria-hidden="true"></i> Back
			</a>
      </div>
    </div>
	
    <div class="page-content container-fluid">
      	<div class="row">
			<div class="col-lg-12">
			  	<div class="panel">
					<div class="panel-body">

						<div class="alert alert-warning" role="alert">
  							Semua field wajib diisi sebelum melakukan submit
						</div>
						<br>
						<div id="message"></div>

						<?php if($list_catatan->num_rows() > 0): ?>
						<div class="row">
							<div class="col-lg-12">
								<b>List Catatan SOP</b>
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
							</div>
						</div>
						<?php endif; ?>

						<div class="row">
							<div class="col-lg-12">
								<form class="form-horizontal" id="form-review">
									<input type="hidden" name="id" value="<?= $review->idlist_review ?>">
                           <input type="hidden" name="alias" value="<?= $sop->sop_alias ?>">
									<div class="form-group row">
    									<label for="nama_sop" class="col-sm-2 col-form-label">
    										Nama SOP
    									</label>
    									<div class="col-sm-8">
      									<input type="text" name="nama_sop" class="form-control" value="<?= strtoupper($sop->sop_nama) ?>" readonly />
    									</div>
  									</div>
  									<div class="form-group row">
    									<label for="tanggal_pembuatan_sop" class="col-sm-2 col-form-label">
    										Tanggal Penyusunan
    									</label>
    									<div class="col-sm-4">
      										<input type="text" class="form-control" value="<?= $sop->sop_tgl_pembuatan ?>" readonly />
    									</div>
  									</div>
  									<div class="form-group row">
    									<label for="nama_verifikator" class="col-sm-2 col-form-label">
    										Nama Reviewer
    									</label>
    									<div class="col-sm-4">
      										<input type="text" class="form-control" value="<?= $review->nama_pereview ?>" readonly />
    									</div>
  									</div>
  									<div class="form-group row">
    									<label for="nip" class="col-sm-2 col-form-label">
    										NIP Reviewer
    									</label>
    									<div class="col-sm-4">
      										<input type="text" class="form-control" value="<?= $review->nipbaru ?>" readonly />
    									</div>
  									</div>
  									<div class="form-group row">
    									<label for="jabatan" class="col-sm-2 col-form-label">
    										Jabatan Reviewer
    									</label>
    									<div class="col-sm-8">
      										<textarea name="jabatan_reviewer" id="jabatan_reviewer" class="form-control" row="2" readonly><?= $review->jabatan ?></textarea>
    									</div>
  									</div>
  									<div class="form-group row">
    									<label for="nip" class="col-sm-2 col-form-label">
    										Status Pengajuan <span style="color: red;">*</span>
    									</label>
    									<div class="col-sm-2">
      										<select name="status_pengajuan" id="status_pengajuan" class="form-control">
      											<option value="">Silahkan Pilih</option>
      											<option value="Diterima">Diterima</option>
      											<option value="Ditolak">Ditolak</option>
      										</select>
    									</div>
  									</div>
  									<div class="form-group row">
    									<label for="catatan_review" class="col-sm-2 col-form-label">
    										Catatan SOP <span style="color: red;">*</span>
    									</label>
    									<div class="col-sm-8">
      										<textarea name="catatan_review" id="catatan_review" class="form-control" rows="4"><?= $review->catatan_review ?></textarea>
    									</div>
  									</div>

  									<div id="field-teruskan" class="d-none">

  									<div class="form-group row">
    									<label for="nip" class="col-sm-2 col-form-label">
    										Teruskan Ke <span style="color: red;">*</span>
    									</label>
    									<div class="col-sm-2">
      										<select name="teruskan_ke" id="teruskan_ke" class="form-control">
      											<option value="">Silahkan Pilih</option>
      											<option value="Reviewer Lain">Reviewer Lain</option>
      											<option value="<?= $next ?>"><?= $next ?></option>
      										</select>
    									</div>
  									</div>

  									</div>

  									<div id="field-reviewer" class="d-none">

  									<div class="form-group row">
    									<label for="preview" class="col-sm-2 col-form-label">
    										Reviewer <span style="color: red;">*</span>
    									</label>
    									<div class="col-sm-5">
      										<select class="form-control select2" name="preview" id="preview">
      											<option value="">-- Pilih --</option>
      											<?php foreach($list_review as $row): ?>
      												<option value="<?= $row['nipbaru'] ?>">
      													<?= $row['nama_pegawai'].' - '.$row['nipbaru'] ?>		
      												</option>
      											<?php endforeach; ?>
      										</select>
    									</div>
  									</div>
  									<input type="hidden" name="nama_reviewer" id="nama_reviewer" />
  									<input type="hidden" name="nip_reviewer" id="nip_reviewer" />
  									<div class="form-group row">
    									<label for="nama_sop" class="col-sm-2 col-form-label">
    										Jabatan <span style="color: red;">*</span>
    									</label>
    									<div class="col-sm-8">
      										<textarea name="jabatan" id="jabatan" class="form-control" row="2" readonly></textarea>
      										<small class="form-text text-muted">Terisi otomatis setelah anda memilih Reviewer</small>
    									</div>
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
		
		$('.select2').select2();

		//menampilkan field Teruskan Ke
		$('#status_pengajuan').change(function(){
			$('#teruskan_ke').val('');
			$('#field-reviewer').addClass('d-none');
    		if($(this).val() == 'Diterima'){
    			$('#field-teruskan').removeClass('d-none');
    		}else{
    			$('#field-teruskan').addClass('d-none');
    		}
		});

		//menampilkan field reviewer
		$('#teruskan_ke').change(function(){
			$(".select2").val('').trigger('change');
			$('#nama_reviewer').val('');
     		$('#nip_reviewer').val('');
     		$('#jabatan').val('');
     		if($(this).val() == 'Reviewer Lain'){
    			$('#field-reviewer').removeClass('d-none');
    		}else{
    			$('#field-reviewer').addClass('d-none');
    		}
		});

		//mengisi field reviewer
		$('.select2').on("select2:select", function(e){ 
			var value = $(this).find('option:selected').val();
			if(value != ''){
				$.ajax({ 
					url: '<?= site_url('pengolahan_sop/get_jabatan_review') ?>',
     				data: {'nipbaru':value},
     				dataType: 'json',
     				type: 'GET',
     				success: function(response){
     					$('#nama_reviewer').val(response.nama);
     					$('#nip_reviewer').val(response.nip);
     					$('#jabatan').val(response.jabatan);
     				}
				});
			}else{
				$('#nama_reviewer').val('');
     			$('#nip_reviewer').val('');
     			$('#jabatan').val('');
			}
		});

      //submit form
		$('#form-review').submit(function(e){
			e.preventDefault();
			var data = $(this).serializeArray(); 
			data.push({name: "<?= $this->security->get_csrf_token_name(); ?>", value: token_csrf()});
			$.ajax({ 
				url: '<?= site_url('review_sop/input_review') ?>',
				type: "POST",
				data: data,
				dataType: 'json',
				success: function(response){
					if(response.success == true)
						window.location = '<?= site_url('review_sop') ?>';
					else{
                  $("html, body").animate({
                     scrollTop: 0
                  }, 1000);     
						$('#message').show().html(response.message);
						$('#message').fadeOut(9000);
					}
				}
			});
		});

	});
</script>