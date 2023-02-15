<link href="<?=base_url()?>assets/front/css/dataTables.bootstrap.min.css" rel="stylesheet">
<script src="<?=base_url()?>assets/front/js/jquery.dataTables.min.js"></script> 
<script src="<?=base_url()?>assets/front/js/dataTables.bootstrap.min.js"></script> 
  
<section id="inner-title" class="inner-title">
   <div class="container">
      <div class="row">
         <div class="col-md-6 col-lg-6">
            <h2>Evaluasi SOP</h2>
         </div>
         <div class="col-md-6 col-lg-6">
            <div class="breadcrumbs">
               <ul>
                  <li>Current Page:</li>
                  <li><a href="<?=site_url('beranda')?>">Beranda</a></li>
                  <li><a href="<?=site_url('evaluasi_sop')?>">Evaluasi SOP</a></li>
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
               <!-- <p>Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc Desc </p> -->
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

				<table id="Tabel" class="table table-striped table-bordered" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th width="20">No</th>
							<th width="100">No SOP</th>
							<th>Nama SOP</th>
							<th width="150">Tanggal Efektif</th>
							<th width="30">Lihat</th>
						</tr>
					</thead>
					<tbody>
                  <tr>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
               </tbody>
				</table>
            <br>
            <br>
            <br>
            <br>
		   </div>  
      </div>
   </div>
  </div>
</section>

<script type="text/javascript">
    
    $(document).ready(function() {
	   

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
         var csrf = $.xResponse('<?= site_url('agenda/get_csrf') ?>', {issession: 1,selector: true});
         return csrf;
      }

    
    });
</script>