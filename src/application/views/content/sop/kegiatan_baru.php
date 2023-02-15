<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<style type="text/css">
	#TableKeg{
		margin-left:20px;
		font-size:9px; 
		font-family:arial; 
		color:#000;
	}
	#TableKeg th{
		text-align:center;
	}
	.resize{
		resize:none; 
		width:35px; 
		height:30px;
	}
</style>
<form id="FrmKegiatan" method="post" enctype="multipart/form-data">	
	<input type="hidden" name="id_kegiatan" id="id_kegiatan" />

	<div style="margin-left: 20px;">
		<div class="form-check">
  			<input class="form-check-input" type="radio" name="sop_update_file" id="sop_update_file" value="auto" checked>
  			<label class="form-check-label" for="sop_update_file">
    			Auto
  			</label>
		</div>
	</div>
	<div id="content-kegiatan-auto">
		<div class="alert alert-warning" role="alert" style="margin-left:17px;">
			<ul>
  				<li>Kolom Pelaksana harus terisi sebelum menekan tombol Tambah Kegiatan</li>
  				<li>Kolom Pelaksana diisi singkatan Jabatan yang tertera di Daftar Singkatan</li>
  			</ul>
		</div>
		<table cellpadding="3" cellspacing="0" border="1" align="center" id="TableKeg">
			<tr bgcolor="#ddd">
				<th rowspan="2" width="20" align="left">&nbsp;</th>
				<th rowspan="2" width="40">No.</th>
				<th rowspan="2" width="130">Kegiatan</th>
				<th colspan="10">Pelaksana</th>
				<?php for($i=10; $i<15; $i++): ?>

					<th rowspan="2" width="35" valign="bottom">
						<textarea name="pelaksana[<?= $i ?>]" maxlength="25" class="resize autosave"></textarea>
					</th>

				<?php endfor; ?>

				<th colspan="3">Mutu Baku</th>
				<th rowspan="2" width="120">Keterangan</th>
			</tr>
			<tr bgcolor="#ddd">
				<?php for($i=0; $i<10; $i++): ?>
					<th width="35">
						<textarea name="pelaksana[<?= $i ?>]" maxlength="25" class="resize autosave"></textarea>
					</th>
				<?php endfor; ?>

				<th width="70">Kelengkapan</th>
				<th width="60">Waktu</th>
				<th width="60">Output</th>
			</tr>
		</table>
		<br>
		<div class="form-group row" style="margin-left:5px;">
    		<div class="col-sm-6">
      			<button type="button" class="btn btn-danger btn-xs deleteKeg">
      				<i class="fa fa-minus"></i> Hapus
      			</button>&nbsp;
      			<button type="button" class="btn btn-success btn-xs addmoreKeg">
      				<i class="fa fa-plus"></i> Tambah Kegiatan
      			</button>      		
    		</div>
  		</div>
  		<div class="form-group row" style="margin-left:5px;">
  			<div class="col-sm-6">
  				<p class="font-weight-bold">Daftar Singkatan</p>
  				<div clas="table-responsive">

  					<table class="table table-bordered">
  						<thead>
    						<tr>
      							<th scope="col">No</th>
      							<th scope="col">Jabatan</th>
      							<th scope="col">Singkatan</th>
    						</tr>
  						</thead>
  						<tbody>
  							<?php foreach($dt_singkatan->result() as $row): ?>
  								<tr>
  									<th scope="row"><?= $idx++; ?></th>
  									<td><?= $row->nama_jabatan ?></td>
  									<td><?= $row->singkatan ?></td>
  								</tr>
  							<?php endforeach; ?>

  						</tbody>
					</table>
  				</div>
  			</div>
  		</div>

	</div>

	<div style="margin-left: 20px;">
		<div class="form-check">
  			<input class="form-check-input" type="radio" name="sop_update_file" id="sop_update_file" value="manual">
  			<label class="form-check-label" for="sop_update_file">
    			Manual
  			</label>
		</div>
	</div>

	<div id="field-file" class="d-none">
		<br>
		<div class="alert alert-warning" role="alert" style="margin-left: 20px;">
			Semua field harus diisi
		</div>
		<div class="form-group row" style="margin-left: 25px;">
			<label class="col-md-2 form-control-label">
				File PDF SOP <span style="color:red;">*</span>
			</label>
			<div class="col-md-6">
				<input type="file" class="form-control" name="fileupload" style="border:1px solid #888;">
				<small class="form-text text-muted">Format .pdf max 3 MB</small>			
			</div>		  
		</div>
		<br>
		<div style="margin-left: 40px;">
			<div class="form-check">
  				<input class="form-check-input" type="radio" name="type_draft" id="type_draft" value="file" checked>
  				<label class="form-check-label" for="sop_update_file">
    				Upload File Draft SOP
  				</label>
			</div>
		</div>
		<br>
		<div class="form-group row" style="margin-left: 25px;" id="field-upload">
			<label class="col-md-2 form-control-label">
				File Draft SOP <span style="color:red;">*</span>
			</label>
			<div class="col-md-6">
				<input type="file" class="form-control" name="filedraft" style="border:1px solid #888;">
				<small class="form-text text-muted">Format .doc atau .docx max 3 MB</small>			
			</div>		  
		</div>
		<br>
		<div style="margin-left: 40px;">
			<div class="form-check">
  				<input class="form-check-input" type="radio" name="type_draft" id="type_draft" value="link">
  				<label class="form-check-label" for="sop_update_file">
    				Input URL File Draft SOP
  				</label>
			</div>
		</div>
		<br>

		<div class="form-group row d-none" style="margin-left: 10px;" id="field-link">
    		<label for="tanggal_pembuatan_sop" class="col-md-2 col-form-label">
    			Link Scloud <span style="color: red;">*</span>
    		</label>
    		<div class="col-md-6">
      			<input type="text" name="link_draft" id="link_draft" class="form-control" placeholder="URL File Draft" style="border:1px solid #888;" />
      			<small class="form-text text-muted">Link harus diawali dengan https://scloud.setneg.go.id/</small>
    		</div>
  		</div>
	</div>

	<div class="form-group row">
  		<div class="col-sm-12" style="text-align: right;">
    		<button type="button" class="btn btn-warning">
    			<i class="fa fa-arrow-left"></i> Kembali
    		</button>
      		<button type="submit" class="btn btn-info">
      			Simpan & Lanjut <i class="fa fa-arrow-right"></i>
      		</button>
    	</div>
  	</div>
</form>
<script>
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

	$('input[type="radio"]').click(function(){
    	if ($(this).is(':checked')){
      		if($(this).val() == 'auto'){
      			$('#content-kegiatan-auto').removeClass('d-none');
      			$('#field-file').addClass('d-none');
      		}else if($(this).val() == 'manual'){
      			$('#content-kegiatan-auto').addClass('d-none');
      			$('#field-file').removeClass('d-none');
      		}else if($(this).val() == 'file'){
      			$('#field-link').addClass('d-none');
      			$('#field-upload').removeClass('d-none');
      		}else if($(this).val() == 'link'){
      			$('#field-upload').addClass('d-none');
      			$('#field-link').removeClass('d-none');
      		}
    	}
  	});
  	$(".deleteKeg").on('click', function(){
		
		if($('input[name="sop_update_file"]:checked').val() == 'manual'){
			return false;
		}
		
		$('.caseKeg:checkbox:checked').parents("tr").remove();
		$('.check_allKeg').prop("checked", false); 
		$('.caseKeg:last').css('display','block');	

		var data = $('#FrmKegiatan').serializeArray(); 
		data.push({
			name: "<?= $this->security->get_csrf_token_name(); ?>", value: token_csrf()
		});
		data.push({name: "no", value: $('#TableKeg tr').length - 2});
		data.push({name: "count", value: $('#TableKeg tr').length - 1});

		$.ajax({
			url: '<?= site_url('pengolahan_sop/save_kegiatan'); ?>',
			type: 'POST',
            dataType: 'json',
            data:data,
            success: function(response){
				if(response.success == true){
					$('#bgalert p').text('Data kegiatan berhasil dihapus');
					$('#bgalert').show();
					$('#bgalert').fadeOut(3000);
				}
			}
		});
	});


	$(".addmoreKeg").on('click',function(){ 
		if($('input[name="sop_update_file"]:checked').val() == 'manual'){
			return false;
		}
		
		var no=$('#TableKeg tr').length - 2;
		var prev = no -1;

		var data = $('#FrmKegiatan').serializeArray(); 
		data.push({
			name: "<?= $this->security->get_csrf_token_name(); ?>", value: token_csrf()
		});
		data.push({name: "no", value: no});
		data.push({name: "count", value: $('#TableKeg tr').length - 1});

		$.ajax({
			url: '<?= site_url('pengolahan_sop/save_kegiatan'); ?>',
			type: 'POST',
            dataType: 'json',
            data:data,
            success: function(response){
				$('#TableKeg tr').last().after(response.content);
				$('.caseKeg').css('display','none');
				$('.H'+no+'').css('display','block');
				if(no > 1){
					$(".dc"+prev).show();
				}
				if(response.success == true){
					$('#bgalert p').text(response.message);
					$('#bgalert').show();
					$('#bgalert').fadeOut(3000);
				}
			}
		});
	});

	function color(pel,no) {
		var vala = [];
		var count = no+1;
		if($('.pelaksana'+pel+'_'+no+':checkbox:checked').length == 0){ 
			$('.check'+pel+'_'+no+'').css({
				'background-color': '#fff'
			});
			$('.deci'+pel+'-'+no+'').prop('checked', false);
			$('.deci'+no+'').val('');
		}else{
			$('.check'+pel+'_'+no+'').css({
				'background-color': '#28de7b'
			});
		}
		$('.pel'+count+':checkbox:checked').each(function (i) {
			var ex = $(this).val().split('-');
			vala.push(ex[0]);
		});
		$('.trpel'+no+'').val(vala.join());
	}

	function deci(pel,no) {
		if($('.deci'+pel+'-'+no+':checkbox:checked').length == 0){ 
			$('.deci'+no+'').val('');
			$('.check'+pel+'_'+no+'').css({
				'background-color': '#28de7b'
			});
		}else{
			$('.deci'+no+'').val(''+pel+'-Y');
			$('.check'+pel+'_'+no+'').css({
				'background-color': '#f00'
			});
			$('.pelaksana'+pel+'_'+no+'').prop('checked', true);
			$('.trpel'+no+'').val(pel);
		}
	}


</script>