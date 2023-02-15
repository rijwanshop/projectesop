<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
     
    <title>Eskport PDF</title>
    <script src="<?=base_url()?>assets/global/vendor/jquery/jquery.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/plugins/pdf/pdf.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/plugins/pdf/pdf.worker.min.js"></script>


   
</head>
<body onload="load()">
    <form id="form1" runat="server">
    <div>
            <button id="prev">Previous</button>
            <button id="next">Next</button>
               
            <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
        </div>

        <div>
            <canvas id="the-canvas" style="border:1px solid black"></canvas>
        </div>


    </form>


   

    <script type="text/javascript">







var urls = [
    //'C:\Users\Khagesh\Desktop\PaySlip_Itentso\Payslip_Dec',
    //'C:\Users\Khagesh\Desktop\PaySlip_Itentso\Payslip_Nov'
       'http://mozilla.github.io/pdf.js/web/compressed.tracemonkey-pldi-09.pdf',
      'http://mozilla.github.io/pdf.js/web/compressed.tracemonkey-pldi-09.pdf'
];

// Disable workers to avoid yet another cross-origin issue (workers need
// the URL of the script to be loaded, and dynamically loading a cross-origin
// script does not work).
//
// PDFJS.disableWorker = true;

// In cases when the pdf.worker.js is located at the different folder than the
// pdf.js's one, or the pdf.js is executed via eval(), the workerSrc property
// shall be specified.
//
// PDFJS.workerSrc = 'pdf.worker.js';

/**
 * @typedef {Object} PageInfo
 * @property {number} documentIndex 
 * @property {number} pageNumber
 */

var pdfDocs = [],
    /**
     * @property {PageInfo}
     */
    current = {},
    totalPageCount = 0,
    pageNum = 1,
    pageRendering = false,
    pageNumPending = null,
    scale = 0.8,
    canvas = document.getElementById('the-canvas'),
    ctx = canvas.getContext('2d');

/**
 * Get page info from document, resize canvas accordingly, and render page.
 * @param num Page number.
 */
function renderPage(num) {
    pageRendering = true;
    current = getPageInfo(num);
    // Using promise to fetch the page
    pdfDocs[current.documentIndex]
    .getPage(current.pageNumber).then(function (page) {
        var viewport = page.getViewport(scale);
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        // Render PDF page into canvas context
        var renderContext = {
            canvasContext: ctx,
            viewport: viewport
        };
        var renderTask = page.render(renderContext);

        // Wait for rendering to finish
        renderTask.promise.then(function () {
            pageRendering = false;
            if (pageNumPending !== null) {
                // New page rendering is pending
                renderPage(pageNumPending);
                pageNumPending = null;
            }
        });
    });

    // Update page counters
    document.getElementById('page_num').textContent = pageNum;
}

/**
 * If another page rendering in progress, waits until the rendering is
 * finised. Otherwise, executes rendering immediately.
 */
function queueRenderPage(num) {
    if (pageRendering) {
        pageNumPending = num;
    } else {
        renderPage(num);
    }
}

/**
 * Displays previous page.
 */
function onPrevPage() {
    if (pageNum <= 1) {
        return;
    }
    pageNum--;
    queueRenderPage(pageNum);
}
document.getElementById('prev').addEventListener('click', onPrevPage);

/**
 * Displays next page.
 */
function onNextPage() {
    if (pageNum >= totalPageCount && current.documentIndex + 1 === pdfDocs.length) {
        return;
    }

    pageNum++;
    queueRenderPage(pageNum);
}
document.getElementById('next').addEventListener('click', onNextPage);

/**
 * @returns PageNumber
 */
function getPageInfo(num) {
    var totalPageCount = 0;
    for (var docIdx = 0; docIdx < pdfDocs.length; docIdx++) {

        totalPageCount += pdfDocs[docIdx].numPages;
        if (num <= totalPageCount) {
            return { documentIndex: docIdx, pageNumber: num };
        }
        num -= pdfDocs[docIdx].numPages;
    }

    return false;
};

function getTotalPageCount() {
    var totalPageCount = 0;
    for (var docIdx = 0; docIdx < pdfDocs.length; docIdx++) {
        totalPageCount += pdfDocs[docIdx].numPages;
    }
    return totalPageCount;
}

var loadedCount = 0;
function load() {
    // Load PDFs one after another
    PDFJS.getDocument(urls[loadedCount]).then(function (pdfDoc_) {
        console.log('loaded PDF ' + loadedCount);
        pdfDocs.push(pdfDoc_);
        loadedCount++;
        if (loadedCount !== urls.length) {
            return load();
        }

        console.log('Finished loading');
        totalPageCount = getTotalPageCount();
        document.getElementById('page_count').textContent = totalPageCount;

        // Initial/first page rendering
        renderPage(pageNum);
    });
}
</script>
</body>
</html>