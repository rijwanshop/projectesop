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
			<li class="breadcrumb-item">
				<a href="<?=base_url()?>dashboard">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">SOP</li>
	  	</ol>
      	<div class="page-header-actions">
			<a type="button" class="btn btn-warning" href="<?= site_url('pengolahan_sop'); ?>">
				<i class="icon wb-arrow-left" aria-hidden="true"></i> Back
			</a>
      	</div>
    </div>
	
    <div class="page-content container-fluid">
      	<div class="row">
			<div class="col-lg-12">
	
			  	<!-- Panel Summary Mode -->
			  	<div class="panel">
					<div class="panel-heading">
				  		<h3 class="panel-title">Add <?=$title?></h3>
					</div>
					<div class="panel-body">
				  
						<div class="alert alert-dismissible" role="alert" id="bgalert" style="display:none">
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
                                    <?php $this->load->view('content/sop/header_baru');?>
                                </div>

                                <div id="tab2" class="tab">
                                    <?php $this->load->view('content/sop/kegiatan_baru');?>
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
                                            <a href="<?= site_url('pengolahan_sop'); ?>" class="btn btn-info">
                                                Kembali ke Daftar <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                        
                                </div>
                            </div>
                        </div>

					</div>
			  	</div>
			  	<!-- End Panel Summary Mode -->
			</div>
      	</div>
    </div>
</div>
<script src="<?= base_url(); ?>assets/plugins/select2/select2.js"></script>
<script src="<?= base_url(); ?>assets/plugins/jquery-ui/jquery-ui.js"></script>
<script src="<?=base_url()?>assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
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

        //pilih pengesah
        $('.select2').select2();
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
                $('#satuan_kerja').text('<?= $nama_satorg ?>');
                $('#deputi').text('<?= $nama_deputi ?>');
                $('#unit_kerja').text('<?= $nama_unit ?>');
                $('input[name="nm_satker"]').val('<?= $nama_satorg ?>');
                $('input[name="nm_deputi"]').val('<?= $nama_deputi ?>');
                $('input[name="nm_unitkerja"]').val('<?= $nama_unit ?>');
                $('#nama-jabatan').text('<?= $jabatan_pengesah ?>');
                $('input[name="jabatan"]').val('<?= $jabatan_pengesah ?>');
                $('#nama-pengesah').text('<?= $nama_pengesah ?>');
                $('input[name="nama_pejabat"]').val('<?= $nama_pengesah ?>');
                $('#nip-pengesah').text('<?= $nip_pengesah ?>');
                $('input[name="nip_pejabat"]').val('<?= $nip_pengesah ?>');
            }
        }); 
		
        //year picker
        $('#select-year').datepicker({
            autoclose: true,
            format: 'yyyy',
            viewMode: 'years', 
            minViewMode: 'years'
        });

        //booking nomor SOP
        $('#select-year').change(function(){
            if($(this).val() != ''){
                $.ajax({
                    url: '<?= site_url('pengolahan_sop/booking_nomor') ?>',
                    data: {'tahun':$(this).val()},
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

        //cari SOP terkait
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

        //event tombol + pada field keterkaiatan
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

        //hapus list SOP terkait
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

            if($('#method').val() == 'insert')
                var url_link = '<?= site_url('pengolahan_sop/insert_header_sop'); ?>';
            else
                var url_link = '<?= site_url('pengolahan_sop/update_header_sop'); ?>';
            
            $.ajax({ 
                url: url_link,
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
                        $('#method').val('update');
                        $('#id').val(response.id);
                        $('#id_kegiatan').val(response.id);
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

        //cari singkatan pelaksana
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