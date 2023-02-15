<script src="<?=base_url()?>assets/global/js/Plugin/responsive-tabs.js"></script>
<script src="<?=base_url()?>assets/global/js/Plugin/closeable-tabs.js"></script>
<script src="<?=base_url()?>assets/global/js/Plugin/tabs.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/select2/select2.css" />
<link href="<?= base_url(); ?>assets/plugins/jquery-ui/jquery-ui.css" rel="stylesheet">
<script src="<?= base_url(); ?>assets/plugins/jquery-ui/jquery-ui.js"></script>
<script src="<?= base_url(); ?>assets/plugins/select2/select2.js"></script>

<script src="<?=base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<style>
	#fix {
  		background:#fff;
  		width:31cm;
  		z-index:9
	}
</style>

<div class="modal" id="LoadingImage" style="display: none;"></div>
<div class="page" style="max-width: 1300px;">
	<div class="page-header">
    	<h1 class="page-title"><?=$title?></h1>
      	<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
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
					<div class="panel-heading">
				  		<h3 class="panel-title">Edit <?=$title?></h3>
					</div>
					<div class="panel-body">
						<?= print_catatan_sop($sop->row()->sop_alias) ?>
						<div class="alert dark alert-success alert-dismissible" role="alert" id="bgalert" style="display:none">
							<button type="button" class="close">
								<span>×</span>
							</button>
							SOP Berhasil Disimpan
						</div>
						<div class="nav-tabs-horizontal" data-plugin="tabs">
							<div id="fix">
								<ul class="nav nav-tabs nav-tabs-line mr-25" role="tablist">
									<li class="nav-item" role="presentation">
										<a class="nav-link active" data-toggle="tab" href="#Identitas"
									  aria-controls="Identitas" role="tab">Identitas</a>
									</li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" data-toggle="tab" href="#Kegiatan"
									  aria-controls="Kegiatan" role="tab">Kegiatan</a>
									</li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" data-toggle="tab" href="#Hasil"
									  aria-controls="Hasil" role="tab">Hasil</a>
									</li>
								 </ul>
							</div>
							<div class="tab-content py-15">
								<div class="tab-pane active" id="Identitas" role="tabpanel">
									<?php $this->load->view('content/admin_sop/header_edit_admin');?>
								</div>
								<div class="tab-pane" id="Kegiatan" role="tabpanel">
									<?php $this->load->view('content/sop/kegiatan_edit');?>
								</div>
								<div class="tab-pane" id="Hasil" role="tabpanel">
									<form class="FrmHasil" method="post" enctype="multipart/form-data">
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
										<div id="HasilTableHeader" style="margin-left:-20px"></div>
										<div id="HasilTableKeg" style="margin-left:-20px"></div>
									</form>
								</div>
							</div>
						</div>
					</div>
			  	</div>
			</div>
      	</div>
    </div>
</div>
<script>
	function color(pel,no) {
		var vala = [];
		var count = no+1;
		if($('.pelaksana'+pel+'_'+no+':checkbox:checked').length == 0){ 
			$('.check'+pel+'_'+no+'').css({'background-color': '#fff'});
			$('.deci'+pel+'-'+no+'').prop('checked', false);
			$('.deci'+no+'').val('');
		}else{
			$('.check'+pel+'_'+no+'').css({'background-color': '#28de7b'});
		}
		$('.pel'+count+':checkbox:checked').each(function (i) {
			var ex = $(this).val().split('-');
			vala.push(ex[0]);
		});

		$('.trpel'+no+'').val(vala.join());
	}

	function deci(pel,no){
		if($('.deci'+pel+'-'+no+':checkbox:checked').length == 0){ 
			$('.deci'+no+'').val('');
			$('.check'+pel+'_'+no+'').css({'background-color': '#28de7b'});
		}else{
			$('.deci'+no+'').val(''+pel+'-Y');
			$('.check'+pel+'_'+no+'').css({'background-color': '#f00'});
			$('.pelaksana'+pel+'_'+no+'').prop('checked', true);
			$('.trpel'+no+'').val(pel);
		}
	}
	function select_allKeg() {
		$('input[class=caseKeg]:checkbox').each(function(){ 
			if($('input[class=check_allKeg]:checkbox:checked').length == 0){ 
				$(this).prop("checked", false); 
			} else {
				$(this).prop("checked", true); 
			} 
		});
	}
</script>
<script>
	$(document).ready(function(){ 

		function fixDiv() {
    		var $cache = $('#fix');
    		if ($(window).scrollTop() > 100)
      			$cache.css({
        			'position': 'fixed',
        			'top': '130px'
      			});
    		else
      			$cache.css({
        			'position': 'relative',
        			'top': 'auto'
      		});
  		}
  		$(window).scroll(fixDiv);
  		fixDiv();
		
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

		//list pengesah
		$.ajax({
			url: '<?= site_url('admin_sop/get_pengesah') ?>',
			data: {
				'satorg':'<?= $satorg_id ?>',
				'deputi':'<?= $deputi_id ?>',
				'biro':'<?= $biro_id ?>',
			},
			dataType: 'json',
     		type: 'GET',
     		success: function(response){
     			$.each(response, function(response, a){ 
            		$('.select2').append($('<option></option>').val(a.nipbaru).html(a.nama_pegawai));
         		});
         		$('.select2').select2();
     		}
		});

		//event list pengesah
		$('.select2').on("select2:select", function(e){
			var value = $(this).find('option:selected').val();
			if(value != ''){
				$.ajax({
     				url: '<?= site_url('admin_sop/get_pengesah') ?>',
					data: {
						'satorg':'<?= $satorg_id ?>',
						'deputi':'<?= $deputi_id ?>',
						'biro':'<?= $biro_id ?>',
					},
     				dataType: 'json',
     				type: 'GET',
     				success: function(response){
     					$.each(response, function(response, a){
     						if(a.nipbaru == value){
     							$('#satuan_kerja').text(a.satorg);
     							$('#deputi').text(a.deputi);
     							$('#unit_kerja').text(a.biro);
     							$('input[name="nm_satker"]').val(a.satorg);
     							$('input[name="nm_deputi"]').val(a.deputi);
     							$('input[name="nm_unitkerja"]').val(a.biro);
     							$('#nama-jabatan').text(a.jabatan);
     							$('input[name="jabatan"]').val(a.jabatan);
     							$('#nama-pengesah').text(a.nama_pegawai);
     							$('input[name="nama_pejabat"]').val(a.nama_pegawai);
     							$('#nip-pengesah').text(a.nipbaru);
								$('input[name="nip_pejabat"]').val(a.nipbaru);
								return false;
     						} 
     					});
     				}
     			});
			}else{
				$('#satuan_kerja').text('<?= $sop->row()->sop_nama_satker ?>');
     			$('#deputi').text('<?= $sop->row()->sop_deputi ?>');
     			$('#unit_kerja').text('<?= $sop->row()->sop_unit_kerja ?>');
     			$('input[name="nm_satker"]').val('<?= $sop->row()->sop_nama_satker ?>');
     			$('input[name="nm_deputi"]').val('<?= $sop->row()->sop_deputi ?>');
     			$('input[name="nm_unitkerja"]').val('<?= $sop->row()->sop_unit_kerja ?>');
     			$('#nama-jabatan').text('<?= $sop->row()->sop_disahkan_jabatan?>');
     			$('input[name="jabatan"]').val('<?= $sop->row()->sop_disahkan_jabatan?>');
     			$('#nama-pengesah').text('<?= $sop->row()->sop_disahkan_nama ?>');
     			$('input[name="nama_pejabat"]').val('<?= $sop->row()->sop_disahkan_nama ?>');
     			$('#nip-pengesah').text('<?= $sop->row()->sop_disahkan_nip ?>');
				$('input[name="nip_pejabat"]').val('<?= $sop->row()->sop_disahkan_nip ?>');
			}
		}); 

		//picker tahun
		$('#select-year').datepicker({
			autoclose: true,
			format: 'yyyy',
			viewMode: 'years', 
    		minViewMode: 'years'
		});

		//booking nomor
		$('#select-year').change(function(){
     		if($(this).val() != ''){
     			$.ajax({
     				url: '<?= site_url('pengolahan_sop/booking_nomor') ?>',
     				data: {
     					'tahun':$(this).val(),
     					'alias':'<?= $sop->row()->sop_alias?>',
     					'satorg':'<?= $satorg_id ?>',
						'deputi':'<?= $deputi_id ?>',
						'biro':'<?= $biro_id ?>',
     				},
     				dataType: 'json',
     				type: 'GET',
     				success: function(response){
     					$('input[name="no_sop"]').val(response.sop_no);
     				}
     			});
     		}
		});

		//pilih tanggal
		$('.datePicker').datepicker({
			autoclose: true,
			format: 'dd-mm-yyyy'
		});

		$('#FrmHeader').submit(function(e){
			e.preventDefault();
			$("#LoadingImage").show();
			var data = $(this).serializeArray(); 
			data.push({name: "<?= $this->security->get_csrf_token_name(); ?>", value: token_csrf()});

			$.ajax({ 
				url: '<?= site_url('pengolahan_sop/update_header_sop'); ?>',
				type: "POST",
				data: data,
				dataType: 'json',
				success: function(response){
					$("#LoadingImage").hide();
					$("html, body").animate({
        				scrollTop: 100
    				}, 500); 
					$('#bgalert p').text(response.message);
					$('#bgalert').show();
					if(response.success == true){
						$('#bgalert').removeClass('alert-danger');
						$('#bgalert').addClass('alert-success');
						$('ul.nav li:nth-child(1) a').removeClass("active");
						$('ul.nav li:nth-child(2) a').addClass("active");
						$('#Identitas').removeClass("active");
						$('#Kegiatan').addClass("active");
						$('#HasilTableHeader').html(response.content);
					}else{
						$('#bgalert').addClass('alert-danger');
						$('#bgalert').removeClass('alert-success');
					}
					$('#bgalert').fadeOut(3000);
					
				}
			});
		});

		<?php if($keterkaitan != ''): ?>
			$.each($('table#list_sop_terkait > tbody  > tr'), function(index, value){ 
   				var href = $(this).find('td:eq(1) > a').attr('href');
   				href = href.substring(href.lastIndexOf('/') + 1);
   				var text = $(this).find('td:eq(1) > a').text();
   				var content = '<input type="hidden" name="ls_terkait[]" value="'+text+'">';
   				content += '<input type="hidden" name="link_terkait[]" value="'+href+'">';
   				$(this).find('td:last').html(content);
			});
		<?php endif; ?>

		$('#sop_terkait').autocomplete({
			source: function( request, response ){
            	$.ajax({
                	url: "<?= site_url('pengolahan_sop/get_list_sop_terkait');?>",
                	type: 'get',
                	dataType: "json",
                	data: {
                    	search: request.term,
                    	unit_kerja: '<?= $biro_id ?>',
                	},
                	success: function(data){
                    	response(data);
                	}
            	});
        	},
        	select: function (event, ui){
            	$(this).val(ui.item.label);
            	$('#type_link').val(ui.item.link);
            	return false;
        	}
		});

		$('#tambah-terkait').click(function(){
			$(this).prop('disabled', true);
			if($('#sop_terkait').val() != ''){
				var rowCount = $('#list_sop_terkait >tbody >tr').length;
                rowCount++;

                if(rowCount == 1){
                    $('#field_terkait').removeClass('d-none');
                }

                var data = '<tr><td>'+rowCount+'</td>';
				if($('#type_link').val() != ''){
					data += '<td><a href="'+'<?= site_url('pengolahan_sop/detail_sop/') ?>'+$('#type_link').val()+'" target="_blank">'+$('#sop_terkait').val()+'</a></td>';
				}else{
					data += '<td>'+$('#sop_terkait').val()+'</td>';
				}
				data += '<td><a href="#" class="btn btn-icon btn-xs btn-danger" id="remove-terkait"><i class="fa fa-remove"></i></a></td>';
				data += '<td style="display:none;"><input type="hidden" name="ls_terkait[]" value="'+$('#sop_terkait').val()+'">';
				data += '<input type="hidden" name="link_terkait[]" value="'+$('#type_link').val()+'"></td></tr>';
				$('#list_sop_terkait > tbody:last-child').append(data);
				$('#sop_terkait').val('');
				$('#type_link').val('');
			}
			$(this).prop('disabled', false);
		});

		$(document).on('click', 'a#remove-terkait', function(e){
			e.preventDefault();
			$(this).closest("tr").remove();
			var rowCount = $('#list_sop_terkait >tbody >tr').length;
            if(rowCount == 0){
                $('#field_terkait').addClass('d-none');
            }
		});

		//-- Field Kegiatan -- //
		$('.caseKeg').css('display','none');
		$('.caseKeg:last').css('display','block');

		$('input[type="radio"]').click(function(){
    		if ($(this).is(':checked')){
      			if($(this).val() == 'auto'){
      				$('#content-kegiatan-auto').removeClass('d-none');
      				$('#field-file').addClass('d-none');
      				$('#field-file-upload').addClass('d-none');
      			}else{
      				$('#content-kegiatan-auto').addClass('d-none');
      				$('#field-file').removeClass('d-none');
      				$('#field-file-upload').removeClass('d-none');
      			}
    		}
  		});

  		<?php if($sop->row()->sop_update_file != ''): ?>
  			$('#TableKeg').addClass('d-none');
      		$('#field-file').removeClass('d-none');
      		$('#field-file-upload').removeClass('d-none');
  		<?php else: ?>
  			$('#TableKeg').removeClass('d-none');
      		$('#field-file').addClass('d-none');
      		$('#field-file-upload').addClass('d-none');
  		<?php endif;?>

		$('textarea.autosave').autocomplete({
        	source: function( request, response ){
            	$.ajax({
                	url: "<?= site_url('pengolahan_sop/get_pelaksana');?>",
                	type: 'get',
                	dataType: "json",
                	data: {
                    	search: request.term,
                    	alias: $('#id_kegiatan').val(),
                	},
                	success: function( data ) {
                    	response( data );
                	}
            	});
        	},
        	select: function (event, ui){
            	$(this).val(ui.item.label); 
            	$('#iduser').val(ui.item.iduser);
            	return false;
        	}
    	});

    	$('textarea.autosave').on('change paste', function() {
    		var data = $('#FrmKegiatan').serializeArray(); 
    		data.push({name: "<?= $this->security->get_csrf_token_name(); ?>", value: token_csrf()});
    		$.ajax({
    			url: '<?= site_url('pengolahan_sop/save_pelaksana') ?>',
				type: "POST",
				data: data,
				dataType: 'json',
				success: function(response){

				}
    		});
		});

    	$('textarea.text-kegiatan').on('keyup', function(){
			var len = $(this).val().length;
			var maxlength = $(this).attr('maxlength');
			if (len >= maxlength){
            	$(this).val($(this).val().substring(0, maxlength));
     		}
			var sisa = maxlength-len;
			$(this).closest('td').find('div#charNum').text('karakter tersisa: '+sisa);
		});

    	$(".addmoreKeg").on('click',function(){ 
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

		$(".deleteKeg").on('click', function() {
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

		$('#FrmKegiatan').submit(function(e){
			e.preventDefault();
			
			var formData = new FormData(this);
			formData.append('<?= $this->security->get_csrf_token_name(); ?>', token_csrf());

			if($('#id_kegiatan').val() != ''){
				$("#LoadingImage").show();
				$.ajax({ 
					url: '<?= site_url('pengolahan_sop/update_field_kegiatan') ?>',
					type: "POST",
					data: formData,
                	contentType: false,
                	cache: false,
                	processData: false,
                	dataType: "JSON",
					success: function(response){
						$("#LoadingImage").hide();
						$('ul.nav li:nth-child(2) a').removeClass("active");
						$('ul.nav li:nth-child(3) a').addClass("active");
						$('#Kegiatan').removeClass("active");
						$('#Hasil').addClass("active");
						$('#HasilTableKeg').html(response.content);
						$('#id_kegiatan_hasil').val(response.alias);
					}
				});
			}else{
				alert('anda belum mengisi identitas');
			}
		});

		$(".FrmHasil").submit(function(e){
			e.preventDefault();
			var id = $('#id_kegiatan_hasil').val();
			if(id != ''){
				var data = $(this).serializeArray(); 
				data.push({name: "<?= $this->security->get_csrf_token_name(); ?>", value: token_csrf()});
				$.ajax({ 
					url: '<?= site_url('pengolahan_sop/kirim_sop') ?>',
					type: "POST",
					data: data,
					dataType: 'json',
					success: function(response){
						if(response.success == true)
							window.location = '<?= site_url('pengolahan_sop') ?>';
					}
				});
			}
		});
			
		$(".close").click(function(){
			$("#bgalert").hide();
		});
	});
</script>