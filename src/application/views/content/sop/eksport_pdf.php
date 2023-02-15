<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
    <head>
     
        <title>Eskport SOP</title>
        <script src="<?=base_url()?>assets/global/vendor/jquery/jquery.js"></script>
        <script src="<?=base_url()?>assets/plugins/pdf/html2pdf.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/require.js/2.3.6/require.min.js"></script>
   
    </head>
    <body>
        
        <div id="content">
            <?= $header ?>
        </div>
        

        <script type="text/javascript">
            var element = document.getElementById('content');

            var opt = {
                margin: 0.9,
                filename: 'myfile.pdf',
                image: {type:'png'},
                jsPDF: {unit:'in', format:'letter', orientation:'landscape'}
            };

            html2pdf().set(opt).from(element).save();

            const PDFMerger = require('<?= base_url() ?>assets/plugins/pdf/index');
            var merger = new PDFMerger();

           
           

        </script>

    </body>
</html>