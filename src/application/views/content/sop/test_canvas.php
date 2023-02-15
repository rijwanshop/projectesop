<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Print SOP</title>
		<script src="<?=base_url()?>assets/global/vendor/jquery/jquery.js"></script>
		<script src="<?=base_url()?>assets/plugins/html2canvas/html2canvas.min.js"></script>
	</head>
	<body>
		
    	<div id="target">
    		<div style="margin-left:20px">
    			<?php $this->load->view('content/sop/kegiatan_detail'); ?>
    		</div>
    	</div>
    	<div id="img" style="display:none;"> 
            <img src="" id="newimg" class="top" /> 
        </div> 

	<script>
		$(document).ready(function(){ 

			html2canvas($('#target'), {
				scrollX: 0,
        		scrollY: 0,
                dpi: 144,
				onrendered: function(canvas){
					var imgsrc = canvas.toDataURL("image/png"); 
					$("#newimg").attr('src', imgsrc); 
                	$("#img").show(); 
                	var dataURL = canvas.toDataURL(); 

                	$.ajax({ 
                		url: '<?= site_url('pengolahan_sop/save_image') ?>',
        				type: 'post',
        				data: {
            				imgBase64: dataURL,
            				alias: '<?= $alias ?>',  
        				},
        				dataType: 'json',
        				success: function(response){
        					if(response.success == true){
                                window.location = '<?= site_url('exportpdf/cetak_sop/'.$alias) ?>';
        					}else{
        						alert(response.message);
        					}
        				}
                	});
				}
			});    
		});

	</script>
</body>
</html>