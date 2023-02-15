  <link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/examples/css/tables/datatable.css">

  
  
  
  
<div class="page">
	<div class="page-header">
      <h1 class="page-title"><?=$title?></h1>
      <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?=base_url()?>dashboard">Dashboard</a></li>
		<li class="breadcrumb-item active">SOP</li>
	  </ol>
    </div>
    <div class="page-content container-fluid">
      <div class="row">
	  
        <div class="col-xxl-6">
          <!-- Panel Basic -->
          <div class="panel">
            <div class="panel-body">
              <table class="table table-hover dataTable table-striped w-full" id="Tabel">
				<thead>
				  <tr>
					<th width="30" data-sortable="false">No</th>
					<th width="100">No SOP</th>
					<th>Nama SOP</th>
					<th width="100">Tgl Pembuatan</th>
					<th width="50" data-sortable="false">Action</th>
				  </tr>
				</thead>
				<tfoot>
				  <tr>
					<th>No</th>
					<th>No SOP</th>
					<th>Nama SOP</th>
					<th>Tgl Pembuatan</th>
					<th>Action</th>
				  </tr>
				</tfoot>
				<tbody></tbody>
			  </table>
            </div>
          </div>
          <!-- End Panel Basic -->
        </div>
		
      </div>
    </div>
  </div>
  
  <script type="text/javascript">
    var save_method;
    var table;
    $(document).ready(function() {
	   
      table = $('#Tabel').DataTable({ 
        "processing": true,
        "serverSide": true,
		"responsive": true,
		"info":     false,
        "ajax": {
            "url": "<?php echo site_url('datatable/pengesahan_sop')?>",
            "type": "POST",
			"data": {
                '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
             }
        },
		"columnDefs": [
        { 
          "targets": [ -1 ], //last column
        },
        ],
      });
	  
    });
</script>
