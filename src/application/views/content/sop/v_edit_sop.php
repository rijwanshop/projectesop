<style type="text/css">
	/*----- Tabs -----*/
    .tabs {
        width:100%;
        display:inline-block;
    }

    /*----- Tab Links -----*/
    /* Clearfix */
    .tab-links:after {
        display:block;
        clear:both;
        content:'';
    }
    .tab-links li {
        margin:0px 5px;
        float:left;
        list-style:none;
    }
    .tab-links a {
        padding:9px 15px;
        display:inline-block;
        border-radius:3px 3px 0px 0px;
        background:#7FB5DA;
        font-size:16px;
        font-weight:600;
        color:#4c4c4c;
        transition:all linear 0.15s;
    }
    .tab-links a:hover {
        background:#a7cce5;
        text-decoration:none;
    }
    li.active a, li.active a:hover {
        background:#fff;
        color:#4c4c4c;
    }

    /*----- Content of Tabs -----*/
    .tab-content {
        padding:15px;
        border-radius:3px;
        box-shadow:-1px 1px 1px rgba(0,0,0,0.15);
        background:#fff;
    }
    .tab {
        display:none;
    }
    .tab.active {
        display:block;
    }
</style>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/select2/select2.css" />
<link href="<?= base_url(); ?>assets/plugins/jquery-ui/jquery-ui.css" rel="stylesheet"/>
<link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css" />

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

						
						<div class="alert alert-success alert-dismissible" role="alert" id="bgalert" style="display:none">
							<button type="button" class="close">
								<span>×</span>
							</button>
							<p>SOP Berhasil Disimpan</p>
						</div>

						<div class="tabs">
                            <ul class="tab-links">
                                <li class="active">
                                    <a href="#tab1">Header</a>
                                </li>
                                <li>
                                    <a href="#tab2">Kegiatan</a>
                                </li>
                                <li>
                                    <a href="#tab3">Hasil</a>
                                </li>
                            </ul>

                            <div class="tab-content">

                                <div id="tab1" class="tab active">
                                    <?php $this->load->view('content/sop/header_edit');?>
                                </div>

                                <div id="tab2" class="tab">
                                    <?php $this->load->view('content/sop/kegiatan_edit');?>
                                </div>
                                <div id="tab3" class="tab">
                                    
                                    <div id="HasilTableHeader"></div>
                                    <div id="HasilTableKeg"></div>
                                    <br>
                                    <div class="form-group row">
                                        <div class="col-sm-12" style="text-align: right;">
                                            <button type="button" class="btn btn-warning">
                                                <i class="fa fa-arrow-left"></i> Kembali
                                            </button>
                                            &nbsp;
                                            <a href="<?= $back_link ?>" class="btn btn-info">
                                                Kembali ke Daftar <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                        
                                </div>
                            </div>
                        </div>


					</div>
			  	</div>
			</div>
      	</div>
    </div>
</div>
<script src="<?= base_url(); ?>assets/plugins/select2/select2.js"></script>
<script src="<?= base_url(); ?>assets/plugins/jquery-ui/jquery-ui.js"></script>
<script src="<?=base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
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
		$('.tabs .tab-links a').on('click', function(e) {
            var currentAttrValue = $(this).attr('href');
            // Show/Hide Tabs
            $('.tabs ' + currentAttrValue).show().siblings().hide();
            // Change/remove current tab to active
            $(this).parent('li').addClass('active').siblings().removeClass('active');
            e.preventDefault();
        });

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

		//pilih pengesah
		$('.select2').on("select2:select", function(e){
			var value = $(this).find('option:selected').val();
			if(value != ''){
				$.ajax({
     				url: '<?= site_url('pengolahan_sop/get_unit_pengesah') ?>',
     				data: {'nip':value},
     				dataType: 'json',
     				type: 'GET',
     				success: function(response){
     					if(response.success == true){
     						$('#satuan_kerja').text(response.satorg);
     						$('#deputi').text(response.deputi);
     						$('#unit_kerja').text(response.biro);
     						$('input[name="nm_satker"]').val(response.satorg);
     						$('input[name="nm_deputi"]').val(response.deputi);
     						$('input[name="nm_unitkerja"]').val(response.biro);
     						$('#nama-jabatan').text(response.jabatan);
     						$('input[name="jabatan"]').val(response.jabatan);
     						$('#nama-pengesah').text(response.nama_pegawai);
     						$('input[name="nama_pejabat"]').val(response.nama_pegawai);
     						$('#nip-pengesah').text(response.nipbaru);
							$('input[name="nip_pejabat"]').val(response.nipbaru);
     					}
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

		//year picker
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
     					'alias':'<?= $sop->row()->sop_alias?>'
     				},
     				dataType: 'json',
     				type: 'GET',
     				success: function(response){
     					$('input[name="no_sop"]').val(response.sop_no);
     				}
     			});
     		}
		});

		//date picker tanggal pembuatan dan revisi
		$('.datePicker').datepicker({
			autoclose: true,
			format: 'dd-mm-yyyy'
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

		//cari sop terkait
		$('#sop_terkait').autocomplete({
			source: function( request, response ){
            	$.ajax({
                	url: "<?= site_url('pengolahan_sop/get_list_sop_terkait');?>",
                	type: 'get',
                	dataType: "json",
                	data: {
                    	search: request.term,
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

		//tambah sop terkait
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

		//hapus SOP terkait
		$(document).on('click', 'a#remove-terkait', function(e){
			e.preventDefault();
			$(this).closest("tr").remove();
			var rowCount = $('#list_sop_terkait >tbody >tr').length;
            if(rowCount == 0){
                $('#field_terkait').addClass('d-none');
            }
		});

		//submit Header SOP
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
						//next tab
                        $('.tab-links li.active').next('li').find('a').trigger("click");
						$('#HasilTableHeader').html(response.content);
					}else{
						$('#bgalert').addClass('alert-danger');
						$('#bgalert').removeClass('alert-success');
					}
					$('#bgalert').fadeOut(12000);
					
				}
			});
		});

		//-- Field Kegiatan -- //
		$('.caseKeg').css('display','none');
		$('.caseKeg:last').css('display','block');

		<?php if($sop->row()->sop_update_file != ''): ?>
  			$('#content-kegiatan-auto').addClass('d-none');
  		<?php else: ?>
      		$('#field-file').addClass('d-none');
  		<?php endif;?>

        <?php if($sop->row()->link_draft_file != ''): ?>
            $('#field-upload').addClass('d-none');
        <?php elseif($sop->row()->sop_draft_file != ''): ?>
            $('#field-link').addClass('d-none');
        <?php endif;?>

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

		//get singkatan pelaksana
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

  		//menampilkan sisa karakter di textarea
    	$('textarea.text-kegiatan').on('keyup', function(){
			var len = $(this).val().length;
			var maxlength = $(this).attr('maxlength');
			if (len >= maxlength){
            	$(this).val($(this).val().substring(0, maxlength));
     		}
			var sisa = maxlength-len;
			$(this).closest('td').find('div#charNum').text('karakter tersisa: '+sisa);
		});

    	//button tambah kegiatan
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
						$('#bgalert').fadeOut(12000);
					}
				}
			});
		});

		//button hapus kegiatan
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
						$('#bgalert').fadeOut(12000);
					}
				}
			});
		});

		//submit Kegiatan SOP
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
                        $("html, body").animate({
                            scrollTop: 100
                        }, 500); 
                        $('#bgalert p').text(response.message);
                        $('#bgalert').show();
                        if(response.success == true){
                            $('#bgalert').removeClass('alert-danger');
                            $('#bgalert').addClass('alert-success');
                            //next tab
                            $('.tab-links li.active').next('li').find('a').trigger("click");
                            $('#HasilTableKeg').html(response.content);
                        
                        }else{
                            $('#bgalert').addClass('alert-danger');
                            $('#bgalert').removeClass('alert-success');
                        }
                        $('#bgalert').fadeOut(12000);
					}
				});
			}else{
				alert('anda belum mengisi identitas');
			}
		});

	});
</script>