<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta name="description" content="e-SOP Kementerian Sekretariat Negara">
      <meta name="author" content="">
      <title><?=$title?> | e-SOP Kementerian Sekretariat Negara</title>
      <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.png">
      <!-- Stylesheets -->
      <link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/animsition/animsition.css">
      <link rel="stylesheet" href="<?=base_url()?>assets/global/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?=base_url()?>assets/global/css/bootstrap-extend.min.css">
      <link rel="stylesheet" href="<?=base_url()?>assets/css/site.min.css">
      <link rel="stylesheet" href="<?=base_url()?>assets/global/fonts/font-awesome/font-awesome.css">
      <link rel="stylesheet" href="<?=base_url()?>assets/css/reset.css">
      <!-- Fonts -->
      <link rel="stylesheet" href="<?=base_url()?>assets/global/fonts/web-icons/web-icons.min.css">
      <link rel="stylesheet" href="<?=base_url()?>assets/global/fonts/brand-icons/brand-icons.min.css">
      <link rel="stylesheet" href="<?=base_url()?>assets/css/googlefont.css">

      <script src="<?=base_url()?>assets/global/vendor/breakpoints/breakpoints.js"></script>
      <script>
         Breakpoints();
      </script>
  
      <!-- Core  -->
      <script src="<?=base_url()?>assets/global/vendor/babel-external-helpers/babel-external-helpers.js"></script>
      <script src="<?=base_url()?>assets/global/vendor/jquery/jquery.js"></script>
      <script src="<?=base_url()?>assets/global/vendor/tether/tether.js"></script>
      <script src="<?=base_url()?>assets/global/vendor/bootstrap/bootstrap.js"></script>
      <script src="<?=base_url()?>assets/global/vendor/animsition/animsition.js"></script>
      <script src="<?=base_url()?>assets/global/vendor/mousewheel/jquery.mousewheel.js"></script>
      <script src="<?=base_url()?>assets/global/vendor/asscrollbar/jquery-asScrollbar.js"></script>
      <script src="<?=base_url()?>assets/global/vendor/asscrollable/jquery-asScrollable.js"></script>
   </head>
   <body class="animsition site-navbar-small dashboard">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
      <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega navbar-inverse" role="navigation">
         <div class="navbar-header">
            <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided" data-toggle="menubar">
               <span class="sr-only">Toggle navigation</span>
               <span class="hamburger-bar"></span>
            </button>
            <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse" data-toggle="collapse">
               <i class="icon wb-more-horizontal" aria-hidden="true"></i>
            </button>
            <a class="navbar-brand navbar-brand-center" href="<?=base_url()?>dashboard">
               <img class="navbar-brand-logo navbar-brand-logo-normal" src="<?=base_url()?>assets/images/logo.png" title="e-SOP Sekretariat Negara">
               <img class="navbar-brand-logo navbar-brand-logo-special" src="<?=base_url()?>assets/images/logo-blue.png" title="e-SOP Sekretariat Negara">
               <span class="navbar-brand-text hidden-xs-down"> 
                  e-SOP Kementerian Sekretariat Negara
               </span>
            </a>
         </div>
         <div class="navbar-container container-fluid">
            <!-- Navbar Collapse -->
            <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
               <!-- Navbar Toolbar -->
               <ul class="nav navbar-toolbar">
                  <li class="nav-item hidden-float" id="toggleMenubar">
                     <a class="nav-link" data-toggle="menubar" href="#" role="button">
                        <i class="icon hamburger hamburger-arrow-left">
                           <span class="sr-only">Toggle menubar</span>
                           <span class="hamburger-bar"></span>
                        </i>
                     </a>
                  </li>
               </ul>
               <!-- End Navbar Toolbar -->
               <!-- Navbar Toolbar Right -->
               <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
                  <li class="nav-item hidden-sm-down" id="toggleFullscreen">
                     <a class="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
                        <span class="sr-only">Toggle fullscreen</span>
                     </a>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" title="Pemberitahuan" aria-expanded="false" data-animation="scale-up" role="button">
                        <i class="icon wb-bell" aria-hidden="true"></i>
                        <?= get_jumlah_notif_user() ?>
                     </a>
                     <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
                        <?php if(get_total_notif_user() > 0): ?>
                           <li class="dropdown-menu-header" role="presentation">
                              <h5>Pemberitahuan</h5>
                              <?= get_total_notif_user() ?>
                           </li>
                        <?php endif; ?>
                        <li class="list-group" role="presentation">
                           <div data-role="container">
                              <div data-role="content">
                                <?= get_notif_user() ?>
                              </div>
                           </div>
                        </li>
                        <li class="dropdown-menu-footer" role="presentation">
                           <a class="dropdown-item" href="<?= site_url('notifikasi') ?>" role="menuitem">
                              Lihat Semua
                           </a>
                        </li>
                     </ul>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false" data-animation="scale-up" role="button">
                        <span class="avatar avatar-online">
                           <img src="<?= $this->session->userdata('foto') ?>" alt="<?= $this->session->userdata('fullname') ?>">
                           <i></i>
                        </span>
                     </a>
                     <div class="dropdown-menu" role="menu">
                        <div class="text-center" style="padding-right:3px; background-color: #62a8ea; color:#fff;">
                           <img class="rounded-circle img-responsive" src="<?= $this->session->userdata('foto') ?>" alt="" width="90" height="90" style="margin-top:10px;">
                           <p style="font-family: Roboto,sans-serif; font-size: 12px; font-weight: 400;">
                              <?= $this->session->userdata('pegawainm') ?>
                           </p>
                           <p style="font-family: Roboto,sans-serif; font-size: 12px; font-weight: 400;">
                              <?= $this->session->userdata('pegawainip') ?>
                           </p>
                        </div>
                        
                        <a class="dropdown-item" href="<?= site_url('login/logout') ?>" role="menuitem">
                           <i class="icon wb-power" aria-hidden="true"></i> Logout
                        </a>
                     </div>
                  </li>
               </ul>
               <!-- End Navbar Toolbar Right -->
            </div>
            <!-- End Navbar Collapse -->
            <!-- Site Navbar Seach -->
            <div class="collapse navbar-search-overlap" id="site-navbar-search">
               <form role="search">
                  <div class="form-group">
                     <div class="input-search">
                        <i class="input-search-icon wb-search" aria-hidden="true"></i>
                        <input type="text" class="form-control" name="site-search" placeholder="Search...">
                        <button type="button" class="input-search-close icon wb-close" data-target="#site-navbar-search" data-toggle="collapse" aria-label="Close"></button>
                     </div>
                  </div>
               </form>
            </div>
            <!-- End Site Navbar Seach -->
         </div>
      </nav>
      <div class="site-menubar site-menubar-light">
         <div class="site-menubar-body">
            <div>
               <div>
                  <ul class="site-menu" data-plugin="menu">
      <?php 
        if($menu->num_rows() > 0){
          foreach($menu->result_array() as $rows) {
            $level = $rows['menu_level'];
            $this->menubackend->addToArray($rows['menu_id'], $rows['menu_name'], $rows['parent'], $rows['menu_link'], $level, $rows['menu_sts_child'], $rows['menu_icon']);
          }
          
          $this->menubackend->drawTree(); 
        }
      ?>
        
                  </ul>
               </div>
            </div>
         </div>
      </div>