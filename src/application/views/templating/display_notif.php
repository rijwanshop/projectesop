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
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
        <script src="<?=base_url()?>assets/global/vendor/breakpoints/breakpoints.js"></script>
        <script>
          //Breakpoints();
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

        <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega navbar-inverse" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided" data-toggle="menubar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="hamburger-bar"></span>
                </button>
                <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse" data-toggle="collapse">
                    <i class="icon wb-more-horizontal" aria-hidden="true"></i>
                </button>
                <a class="navbar-brand navbar-brand-center" href="<?= site_url('dashboard') ?>">
                    <img class="navbar-brand-logo navbar-brand-logo-normal" src="<?=base_url()?>assets/images/logo.png" title="e-SOP Sekretariat Negara" />
                    <img class="navbar-brand-logo navbar-brand-logo-special" src="<?=base_url()?>assets/images/logo-blue.png" title="e-SOP Sekretariat Negara" />
                    <span class="navbar-brand-text hidden-xs-down"> e-SOP Kementerian Sekretariat Negara</span>
                </a>
            </div>
            <div class="navbar-container container-fluid">
                <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
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
                    <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
                        <li class="nav-item hidden-sm-down" id="toggleFullscreen">
                            <a class="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
                                <span class="sr-only">Toggle fullscreen</span>
                            </a>
                        </li>
		                <li class="nav-item dropdown">
                            <a class="nav-link" data-toggle="dropdown" href="#" title="Pemberitahuan" aria-expanded="false" data-animation="scale-up" role="button">
                                <i class="icon wb-bell" aria-hidden="true"></i>
                                <?=($notif->num_rows() > 0 ? '<span class="badge badge-pill badge-danger up">'.$notif->num_rows().'</span>' : '')?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
                                <li class="dropdown-menu-header" role="presentation">
                                    <h5>Pemberitahuan</h5>
				                    <?=($notif->num_rows() > 0 ? '<span class="badge badge-round badge-danger">New '.$notif->num_rows().'</span>' : '')?>
                                </li>
                                <li class="list-group" role="presentation">
                                    <div data-role="container">
                                        <div data-role="content">
				                            <?php if($notif->num_rows() > 0){
					                           foreach($notif->result_array() as $row){
						                          $linkgrup = ($this->session->userdata['groupid'] == 11 ? 'periksa' : 'lihat');
						                          $link = ($row['notif_jenis'] == 'reviu' ? ''.base_url().'sop/reviu/'.$linkgrup.'/'.$row['sop_alias'].'/'.$row['notif_id'].'/'.$row['reviu_id'].'' : ''.base_url().'sop/revisi_sop/periksa/'.$row['sop_alias'].'/'.$row['revisi_id'].'');
				                            ?>
						                        <a class="list-group-item" href="<?=$link?>" role="menuitem">
						                            <div class="media">
							                            <div class="pr-10">
							                               <i class="icon <?=$row['notif_icon']?> white icon-circle" aria-hidden="true"></i>
							                            </div>
							                            <div class="media-body">
							                              <h6 class="media-heading"><?=$row['notif_title']?></h6>
							                              <time class="media-meta"><?=tgl_indo2($row['notif_date'])?></time>
							                            </div>
						                            </div>
						                      </a>
				                        <?php }}else{ ?>
				                            <a class="list-group-item" href="#" role="menuitem">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <h6 class="media-heading">Tidak ada pemberitahuan</h6>
                                                    </div>
                                                </div>
                                            </a>
				                        <?php }?>
                                    </div>
                                </div>
                            </li>
              <li class="dropdown-menu-footer" role="presentation">
                <a class="dropdown-item" href="<?=base_url()?>notification/semua" role="menuitem">
                    Lihat Semua
                  </a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
            data-animation="scale-up" role="button">
              <span class="avatar avatar-online">
				<img src="<?=base_url()?>assets<?=($foto != '' ? '/media/profile/'.$foto.'' : '/global/portraits/5.jpg')?>" alt="<?=$fullname?>">
                <i></i>
              </span>
            </a>
            <div class="dropdown-menu" role="menu">
              <a class="dropdown-item" href="<?=base_url()?>settings/profile/<?=$userid?>" role="menuitem">
				<i class="icon wb-user" aria-hidden="true"></i> Profile</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?= site_url('login/logout') ?>" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>
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
              <button type="button" class="input-search-close icon wb-close" data-target="#site-navbar-search"
              data-toggle="collapse" aria-label="Close"></button>
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
