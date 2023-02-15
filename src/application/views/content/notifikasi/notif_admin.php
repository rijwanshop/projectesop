<style type="text/css">
	.tabs{
      width:100%;
      height:auto;
      margin:0 auto;
   }

   /* tab list item */
   .tabs .tabs-list{
      list-style:none;
      margin:0px;
      padding:0px;
   }
   .tabs .tabs-list li{
      width:100px;
      float:left;
      margin:0px;
      margin-right:2px;
      padding:10px 5px;
      text-align: center;
      background-color:#62a8ea;
      border-radius:3px;
   }
   .tabs .tabs-list li:hover{
      cursor:pointer;
   }
   .tabs .tabs-list li a{
      text-decoration: none;
      color:white;
   }

   /* Tab content section */
   .tabs .tab{
      display:none;
      width:96%;
      min-height:250px;
      height:auto;
      border-radius:3px;
      padding:20px 15px;
      background-color:white;
      color:darkslategray;
      clear:both;
   }
   .tabs .tab h3{
      border-bottom:3px solid #62a8ea;
      letter-spacing:1px;
      font-weight:normal;
      padding:5px;
   }
   .tabs .tab p{
      line-height:20px;
      letter-spacing: 1px;
   }

   /* When active state */
   .active{
      display:block !important;
   }
   .tabs .tabs-list li.active{
      background-color:lavender !important;
      color:black !important;
   }
   .active a{
      color:black !important;
   }

   /* media query */
   @media screen and (max-width:360px){
      .tabs{
        margin:0;
        width:96%;
      }
      .tabs .tabs-list li{
        width:80px;
      }
   }

   table th, table td:nth-child(1){
      text-align: center;
   }
   #Tabel td:nth-child(3), #Tabel td:nth-child(5), #Tabel2 td:nth-child(3), #Tabel2 td:nth-child(5), #Tabel2 td:nth-child(7){
      white-space: nowrap;
   }
   #Tabel td:nth-child(5),#Tabel td:nth-child(6), #Tabel td:nth-child(7){
      text-align: center;
   } 
   #Tabel2 td:nth-child(5), #Tabel2 td:nth-child(6), #Tabel2 td:nth-child(7){
      text-align: center;
   }
</style>
<div class="page" style="max-width: 1300px;">
	<div class="page-header">
    	<h1 class="page-title"><?=$title?></h1>
      	<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="<?=base_url()?>dashboard">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Pemberitahuan</li>
	  	</ol>
      	<div class="page-header-actions">
			<a type="button" class="btn btn-warning" href="<?= site_url('notifikasi') ?>">
				<i class="icon wb-arrow-left" aria-hidden="true"></i> Back
			</a>
      </div>
    </div>
	
	
    <div class="page-content container-fluid">
      	<div class="row">
			<div class="col-lg-12">
			  	<div class="panel">
					<div class="panel-body">
						

                  <div class="tabs">
                     <ul class="tabs-list">
                        <li class="active">
                           <a href="#tab1">Notifikasi Saya</a>
                        </li>
                        <li>
                           <a href="#tab2">Semua Notifikasi</a>
                        </li>
                     </ul>

                     <div id="tab1" class="tab active">
                        <h3>Notifikasi Saya</h3>
                        <br>
                        <div class="table-responsive">
                           <table class="table table-hover dataTable table-striped w-full tabel-sop" id="Tabel">
                              <thead>
                                 <tr>
                                    <th>No</th>
                                    <th>Nama Pengirim</th>
                                    <th>NIP Pengirim</th>
                                    <th>Aktivitas</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Lihat</th>
                                 </tr>
                              </thead>
                              <tbody></tbody>
                           </table>
                        </div>
                     </div>

                     <div id="tab2" class="tab">
                        <h3>Semua Notifikasi</h3>
                        <br>
                        <div class="table-responsive">
                           <table class="table table-hover dataTable table-striped w-full tabel-sop" id="Tabel2">
                              <thead>
                                 <tr>
                                    <th style="width:8%;">No</th>
                                    <th style="width:22%;">Nama Penerima</th>
                                    <th style="width:10%;">NIP Penerima</th>
                                    <th style="width:25%;">Aktivitas</th>
                                    <th style="width:10%;">Waktu</th>
                                    <th style="width:10%;">Status</th>
                                    <th style="width:15%;">Tindakan</th>
                                 </tr>
                              </thead>
                              <tbody></tbody>
                              <tfoot>
                                 <tr>
                                    <th></th>
                                    <th>
                                       <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" />
                                    </th>
                                    <th>
                                       <input type="text" name="nip" id="nip" class="form-control" placeholder="NIP Penerima" />
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                 </tr>
                              </tfoot>
                           </table>
                        </div>
                     </div>
       
                  </div>
					
					</div>
			  	</div>
			</div>
      	</div>
    </div>
</div>
<script type="text/javascript">
   $(document).ready(function(){

      $(".tabs-list li a").click(function(e){
         e.preventDefault();
      });

      $(".tabs-list li").click(function(){
         var tabid = $(this).find("a").attr("href");
         $(".tabs-list li,.tabs div.tab").removeClass("active");   // removing active class from tab and tab content
         $(".tab").hide();   // hiding open tab
         $(tabid).show();    // show tab
         $(this).addClass("active"); //  adding active class to clicked tab
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

      //daftar notifikasi khusus admin
      $('#Tabel').DataTable({ 
         processing: true,
         serverSide: true,
         responsive: true,
         dom: 'lrtp',
         order: [],
         ajax:{
            url: "<?php echo site_url('notifikasi/get_notif_user')?>",
            type: "POST",
            data: function(d){
               return $.extend({},d,{
                  '<?= $this->security->get_csrf_token_name(); ?>':token_csrf(),
               });
            },
         },
         columnDefs: [{ 
            targets: [ 0,6 ], 
            orderable: false, 
         },
        ],
      });

      //daftar SOP yang tidak ditampilkan di menu pencarian
      $('#Tabel2').DataTable({ 
         processing: true,
         serverSide: true,
         responsive: true,
         dom: 'lrtp',
         order: [],
         ajax:{
            url: "<?php echo site_url('notifikasi/get_notifikasi_admin')?>",
            type: "POST",
            data: function(d){
               return $.extend({},d,{
                  '<?= $this->security->get_csrf_token_name(); ?>':token_csrf(),
                  'nama':$('#nama').val(),
                  'nip':$('#nip').val(),
               });
            },
         },
         columnDefs: [
            { 
               targets: [ 0,6 ], 
               orderable: false,
            },
         ],
      });

      //filter NIP dan nama
      $('input[type="text"]').on('change keyup', function(){ 
         $('#Tabel2').DataTable().ajax.reload();
      });

   });
</script>