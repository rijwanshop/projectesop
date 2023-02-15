<style type="text/css">
	.borderless td, .borderless th{
      border: none;
	}
   #catatan th{
      text-align: center;
   }
   #catatan td:nth-child(1), #catatan td:nth-child(4), #catatan td:nth-child(6){
      text-align: center;
   }
   #catatan td:nth-child(5){
      text-align: justify;
   }

	.timeline{
      list-style:none;
      padding:0 0 20px;
      position:relative;
      margin-top:-15px;
   }
   .timeline:before{
      top:30px;
      bottom:25px;
      position:absolute;
      content:" ";
      width:3px;
      background-color:#ccc;
      left:25px;
      margin-right:-1.5px;
   }
   .timeline>li,.timeline>li>.timeline-panel{
      margin-bottom:5px;
      position:relative;
   }
   .timeline>li:after,.timeline>li:before{
      content:" ";
      display:table;
   }
   .timeline>li:after{
      clear:both
   }
   .timeline>li>.timeline-panel{
      margin-left:55px;
      float:left;
      top:19px;
      padding:4px 10px 8px 15px;
      border:1px solid #ccc;
      border-radius:5px;
      width:45%;
   }
   .timeline>li>.timeline-badge{
      color:#fff;
      width:36px;
      height:36px;
      line-height:36px;
      font-size:1.2em;
      text-align:center;
      position:absolute;
      top:26px;
      left:9px;
      margin-right:-25px;
      background-color:#fff;
      z-index:100;border-radius:50%;
      border:1px solid #d4d4d4;
   }
   .timeline>li.timeline-inverted>.timeline-panel{
      float:left;
   }
   .timeline>li.timeline-inverted>.timeline-panel:before{
      border-right-width:0;border-left-width:15px;
      right:-15px;
      left:auto;
   }
   .timeline>li.timeline-inverted>.timeline-panel:after{
      border-right-width:0;
      border-left-width:14px;
      right:-14px;
      left:auto;
   }
   .timeline-badge.primary{
      background-color:#2e6da4!important;
   }
   .timeline-badge.success{
      background-color:#3f903f!important;
   }
   .timeline-badge.warning{
      background-color:#f0ad4e!important;
   }
   .timeline-badge.danger{
      background-color:#d9534f!important;
   }
   .timeline-badge.info{
      background-color:#5bc0de!important;
   }
   .timeline-title{
      margin-top:0;color:inherit;
   }
   .timeline-body>p,.timeline-body>ul{
      margin-bottom:0;margin-top:0;
   }
   .timeline-body>p+p{
      margin-top:5px;
   }
   .timeline-badge>.glyphicon{
      margin-right:0px;
      color:#fff;
   }
   .timeline-body>h4{
      margin-bottom:0!important;
   }
</style>
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
			<a type="button" class="btn btn-warning" href="<?= $back_link ?>">
				<i class="icon wb-arrow-left" aria-hidden="true"></i> Back
			</a>
      </div>
    </div>
    <div class="page-content container-fluid">
      	<div class="row">
			<div class="col-lg-12">
			  	<div class="panel">
					<div class="panel-body">

					<div class="row">
						<div class="col-lg-12">

							<table class="table borderless">
    							<tr>
      								<th scope="row" style="width: 19%;">Nama SOP</th>
      								<td style="width: 1%;">:</td>
      								<td style="width: 80%;"><?= $sop->sop_nama ?></td>
    							</tr>
    							<tr>
      								<th scope="row">Tanggal Pembuatan</th>
      								<td>:</td>
      								<td><?= $sop->sop_tgl_pembuatan ?></td>
    							</tr>
    							<tr>
      								<th scope="row">Status</th>
      								<td>:</td>
      								<td><?= $sop->sop_status ?></td>
    							</tr>
    							<tr>
      								<th scope="row">Step</th>
      								<td>:</td>
      								<td><?= $sop->sop_step ?></td>
    							</tr>
							</table>


						</div>
					</div>

               <?php if($history->num_rows() > 0): ?>
					<div class="row">
						<div class="col-lg-12">

                     <h5>History SOP</h5>
							<div class="container">
    							<ul class="timeline">

                           <?php foreach($history->result() as $row): ?>
                              <li>
                                 <div class="timeline-badge <?= $row->warna ?>">
                                    <i class="<?= $row->icon ?>"></i>
                                 </div>
                                 <div class="timeline-panel">
                                    <div class="timeline-heading">
                                       <h4 class="timeline-title">
                                          <?= $row->judul ?>
                                       </h4>
                                       <p>
                                          <small class="text-muted">
                                             <i class="fa fa-clock-o"></i> 
                                             <?= date('d-m-Y H:i:s', strtotime($row->waktu)) ?>
                                          </small>
                                       </p>
                                    </div>
                                    <div class="timeline-body">
                                       <p><?= $row->aktivitas ?></p>
                                       <?php if($row->id_data != ''): ?>
                                          <?= display_catatan($row->id_data) ?>
                                       <?php endif; ?>
                                    </div>
                                 </div>
                              </li>
                           <?php endforeach; ?>
        
                        </ul>
                     </div>


						</div>
					</div>
               <?php endif; ?>
               <?php if($list_catatan->num_rows() > 0): ?>
               <div class="row">
                  <div class="col-lg-12">
                     <h5>Daftar Catatan SOP</h5>

                     <table class="table table-bordered" id="catatan">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Nama</th>
                           <th>NIP</th>
                           <th>Status</th>
                           <th>Catatan</th>
                           <th>Waktu</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php foreach($list_catatan->result() as $row): ?>
                        <tr>
                           <td style="width: 5%;"><?= $no++; ?></td>
                           <td style="width: 15%;"><?= $row->nama_pereview ?></td>
                           <td style="width: 10%;"><?= $row->nipbaru ?></td>
                           <td style="width: 10%;"><?= $row->status_pengajuan ?></td>
                           <td style="width: 47%;"><?= $row->catatan_review ?></td>
                           <td style="width: 13%;"><?= date('d-m-Y H:i:s', strtotime($row->tanggal_catatan)) ?></td>
                        </tr>
                     <?php endforeach; ?>
                     </tbody>
                  </table>

                  </div>
               </div>
               <?php endif; ?>

					</div>
			  	</div>
			</div>
      	</div>
    </div>
</div>
