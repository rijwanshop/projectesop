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
		<li class="breadcrumb-item active">Settings</li>
	  </ol>
      <div class="page-header-actions">
		<a type="button" class="btn btn-success" href="<?=base_url()?>settings/menu_manager/add/0/<?=$order?>/1">
			<i class="icon wb-plus" aria-hidden="true"></i> Add
		</a>
      </div>
    </div>
    <div class="page-content container-fluid">
      <div class="row">
	  
        <div class="col-xxl-6">
          <!-- Panel Basic -->
          <div class="panel">
            <div class="panel-body">
              <table class="table table-hover dataTable table-striped w-full">
				<thead>
				  <tr>
					<th data-sortable="false">Menu Name</th>
					<th width="50" data-sortable="false">Order</th>
					<th width="110" data-sortable="false">Action</th>
				  </tr>
				</thead>
				<tbody>
				<?php 
				if($listmenuback->num_rows() > 0){
					foreach($listmenuback->result_array() as $rows) {
						$up = $rows['menu_order'] - 1;
						$down = $rows['menu_order'] + 1;
						$level = $rows['menu_level'];
						$this->listmenubackend->addToArray($rows['menu_id'], $rows['menu_name'], $rows['parent'], $level, $rows['menu_order'], $up, $down);
					}
					
					$this->listmenubackend->drawTree(); 
				}?>
				</tbody>
			  </table>
            </div>
          </div>
          <!-- End Panel Basic -->
        </div>
		
      </div>
    </div>
  </div>
  