<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<!-- Site Title   -->
<title><?=$title?> | e-SOP Kementerian Sekretariat Negara</title>
<!-- Fav Icons   -->
<link rel="icon" href="<?=base_url()?>assets/front/images/favicon.png" type="image/x-icon">
<!-- Bootstrap -->
<link href="<?=base_url()?>assets/front/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=base_url()?>assets/front/css/bootstrap-dropdownhover.min.css" rel="stylesheet">
<!-- Fonts Awesome -->
<link href="<?=base_url()?>assets/front/css/font-awesome.min.css" rel="stylesheet">
<!-- Google Fonts -->
<link href='https://fonts.googleapis.com/css?family=Raleway:400,200,300,100,500,600,700,800,900' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400" rel="stylesheet">
<!-- animate Effect -->
<link href="<?=base_url()?>assets/front/css/animate.css" rel="stylesheet">
<!-- Main CSS -->
<link href="<?=base_url()?>assets/front/css/style.css" rel="stylesheet">
<!-- Responsive CSS -->
<link href="http://templatesell.net/demo/medicamp/css/magnific-popup.css" rel="stylesheet">
<link href="<?=base_url()?>assets/front/css/responsive.css" rel="stylesheet">
<link href="<?=base_url()?>assets/front/css/reset.css" rel="stylesheet">


<script src="<?=base_url()?>assets/front/js/jquery.min.js"></script> 
</head>
<body>
<header id="header" class="head">
  <div class="top-header">
     <div class="container">
       <div class="row ">
         <ul class="contact-detail2 col-md-12 pull-left">
           <li> <a href="#"><i class="fa fa-calendar"></i><?=nama_hari(date('d-m-Y'))?>, <?=tgl_indo(date('d-m-Y'))?></a> </li>
           <li> <a href="#"><i class="fa fa-users"></i> Total Pengunjung : <?=$totalpengunjung?></a> </li>
         </ul>
       </div>
     </div>
    </div>
    <nav class="navbar navbar-default navbar-menu">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> 
            <span class="sr-only">Toggle navigation</span> 
            <span class="icon-bar"></span> 
            <span class="icon-bar"></span> 
            <span class="icon-bar"></span> 
          </button>
          <a class="navbar-brand" href="<?=base_url()?>">
            <img src="<?=base_url()?>assets/images/logo-sekneg.png" alt="logo" width="200">
          </a> 
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" data-hover="dropdown" data-animations="fadeIn" style="font-size:13px; text-transform: uppercase;">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="<?=base_url()?>beranda">Beranda</a></li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tentang Kami <span class="caret"></span></a>
              <ul class="dropdown-menu">
			  <?php foreach($tentangkami->result_array() as $row){ ?>
                <li><a href="<?=base_url()?>tentang_kami/<?=$row['content_alias']?>"><?=$row['content_nama']?></a></li>
			  <?php } ?>
              </ul>
            </li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Agenda <span class="caret"></span></a>
              <ul class="dropdown-menu">
			  <?php foreach($agenda->result_array() as $row){ ?>
                <li><a href="<?=base_url()?>agenda/<?=$row['content_alias']?>"><?=$row['content_nama']?></a></li>
			  <?php } ?>
              </ul>
            </li>
            <li><a href="<?=base_url()?>pengumuman">Berita</a></li>
            <li><a href="<?=base_url()?>pencarian_sop">Pencarian SOP</a></li>
            <li <?=($evaluasi > 0 ? 'style="display:block"' : 'style="display:none"')?>><a href="<?=base_url()?>evaluasi_sop">Evaluasi SOP</a></li>
            <li><a href="<?=base_url()?>login" style="color:green; font-weight:bold">Login</a></li>
          </ul>
        </div>
        <!--/.nav-collapse --> 
      </div>
    </nav>
</header>