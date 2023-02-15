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
  <link rel="stylesheet" href="<?=base_url()?>assets/global/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/global/css/bootstrap-extend.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/css/site.min.css">
  <!-- Plugins -->
  <link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/animsition/animsition.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/asscrollable/asScrollable.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/switchery/switchery.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/intro-js/introjs.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/slidepanel/slidePanel.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/global/vendor/flag-icon-css/flag-icon.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/examples/css/apps/message.css">
  <!-- Fonts -->
  <link rel="stylesheet" href="<?=base_url()?>assets/global/fonts/web-icons/web-icons.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/global/fonts/brand-icons/brand-icons.min.css">
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
  <link rel="stylesheet" href="<?=base_url()?>assets/css/reset.css">
  <script src="<?=base_url()?>assets/global/vendor/breakpoints/breakpoints.js"></script>
  <script>
  Breakpoints();
  </script>
</head>
<body class="animsition site-navbar-small app-message page-aside-scroll page-aside-left">
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
        <img class="navbar-brand-logo navbar-brand-logo-normal" src="<?=base_url()?>assets/images/logo.png" title="Sistem e-SOP Sekretariat Negara">
        <img class="navbar-brand-logo navbar-brand-logo-special" src="<?=base_url()?>assets/images/logo-blue.png" title="Sistem e-SOP Sekretariat Negara">
        <span class="navbar-brand-text hidden-xs-down"> Sistem e-SOP Kementerian Sekretariat Negara</span>
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
						$linkgrup = ($groupid == 11 ? 'periksa' : 'lihat');
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
              <a class="dropdown-item" href="<?=base_url()?>logout" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>
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
  
  <!-- Page -->
  <div class="page">
    <!-- Message Sidebar -->
    <div class="page-aside">
      <div class="page-aside-switch">
        <i class="icon wb-chevron-left" aria-hidden="true"></i>
        <i class="icon wb-chevron-right" aria-hidden="true"></i>
      </div>
      <div class="page-aside-inner">
        <div class="input-search">
          <button class="input-search-btn" type="submit">
            <i class="icon wb-search" aria-hidden="true"></i>
          </button>
          <form id="FrmSearchKontak">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <input class="form-control" type="text" placeholder="Search Keyword" id="key" onkeyup="searchKontak()">
          </form>
        </div>
        <div class="app-message-list page-aside-scroll">
          <div data-role="container">
            <div data-role="content">
              <ul class="list-group" id="ListKontak"></ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Message Sidebar -->
    <div class="page-main">
      <!-- Chat Box -->
	  <div class="app-message-chats" id="box">
		  <div id="chat-box">
			<h2 style='text-align:center;color:grey'>Klik List User Untuk Memulai Chatt</h2>
		  </div>
	  </div>
      <!-- End Chat Box -->
      <!-- Message Input-->
      <form class="app-message-input" style="display:none">
        <div class="message-input">
          <textarea class="form-control" id="pesan"></textarea>
        </div>
        <button class="message-input-btn btn btn-primary" type="button"  onClick="sendMessage()">SEND</button>
      </form>
      <!-- End Message Input-->
    </div>
  </div>
  <!-- Footer -->
  <footer class="site-footer">
    <div class="site-footer-legal">&copy; 2017 Sekretariat Negara</div>
    <div class="site-footer-right">
     <a href="http://www.jake.co.id" target="_blank">Jake Id</a>
    </div>
  </footer>
  <!-- Core  -->
  <script src="<?=base_url()?>assets/global/vendor/babel-external-helpers/babel-external-helpers.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/jquery/jquery.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/tether/tether.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/bootstrap/bootstrap.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/animsition/animsition.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/mousewheel/jquery.mousewheel.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/asscrollbar/jquery-asScrollbar.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/asscrollable/jquery-asScrollable.js"></script>
  <!-- Plugins -->
  <script src="<?=base_url()?>assets/global/vendor/switchery/switchery.min.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/intro-js/intro.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/screenfull/screenfull.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/slidepanel/jquery-slidePanel.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/slidepanel/jquery-slidePanel.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/autosize/autosize.js"></script>
  <!-- Scripts -->
  <script src="<?=base_url()?>assets/global/js/State.js"></script>
  <script src="<?=base_url()?>assets/global/js/Component.js"></script>
  <script src="<?=base_url()?>assets/global/js/Plugin.js"></script>
  <script src="<?=base_url()?>assets/global/js/Base.js"></script>
  <script src="<?=base_url()?>assets/global/js/Config.js"></script>
  <script src="<?=base_url()?>assets/js/Section/Menubar.js"></script>
  <script src="<?=base_url()?>assets/js/Section/Sidebar.js"></script>
  <script src="<?=base_url()?>assets/js/Section/PageAside.js"></script>
  <script src="<?=base_url()?>assets/js/Plugin/menu.js"></script>
  <!-- Config -->
  <script src="<?=base_url()?>assets/global/js/config/colors.js"></script>
  <script src="<?=base_url()?>assets/js/config/tour.js"></script>
  <script>
  Config.set('assets', '<?=base_url()?>assets');
  </script>
  <!-- Page -->
  <script src="<?=base_url()?>assets/js/Site.js"></script>
  <script src="<?=base_url()?>assets/global/js/Plugin/asscrollable.js"></script>
  <script src="<?=base_url()?>assets/global/js/Plugin/slidepanel.js"></script>
  <script src="<?=base_url()?>assets/global/js/Plugin/switchery.js"></script>
  <script src="<?=base_url()?>assets/js/Site.js"></script>
  <script src="<?=base_url()?>assets/js/App/Message.js"></script>
  <script src="<?=base_url()?>assets/examples/js/apps/message.js"></script>
  <script>
$(document).ready(function(){
	searchKontak()
	
	//getChat(0);
	$("#user").click(function(){
		$("#id_max").val('0');
	});
	
	setInterval(function(){ 
		if($("#id_user").val() > 0){
			getLastId($("#id_user").val(),$("#id_max").val()); 
			getChat($("#id_user").val(),$("#id_max").val()); 
			autoScroll();
		}else{
			
		}
	},3000);
});

function getChatAll(id_user,id_max){
	
	$.ajax({
		url		: "<?php echo site_url('komunikasi/getChat_all') ?>",
		type	: 'POST',
		dataType: 'html',
		data 	: {id_user:id_user,id_max:id_max,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
		beforeSend	: function(){
			$("#loading").show();
		},
		success	: function(result){
			$("#loading").hide();
			$("#chat-box").html(result);
			$(".app-message-input").show();
			
			autoScroll();
			document.getElementById('pesan').focus();
		}
	});
}

function getChat(id_user,id_max){
	
	$.ajax({
		url		: "<?php echo site_url('komunikasi/getChat') ?>",
		type	: 'POST',
		dataType: 'html',
		data 	: {id_user:id_user,id_max:id_max,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
		beforeSend	: function(){
			$("#loading").show();
		},
		success	: function(result){
			$("#loading").hide();
			if(id_user != $("#id_user").val() ){
				$("#chat-box").html(result);
			}else{
				$("#chat-box").append(result);
			}
			$(".app-message-input").show();
			document.getElementById('pesan').focus();
		}
	});
}

function getLastId(id_user,id_max){
	$.ajax({
		url		: "<?php echo site_url('komunikasi/getLastId') ?>",
		type	: 'POST',
		dataType: 'json',
		data 	: {id_user:id_user,id_max:id_max,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
		beforeSend	: function(){
			
		},
		success	: function(result){
			$("#id_max").val(result.id);
		}
	});
}

function sendMessage(){
	var pesan 	= $("#pesan").val();
	var id_user = $("#id_user").val();
	
	if(pesan == ''){
		document.getElementById('pesan').focus();
	}else{
		$.ajax({
			url		: "<?php echo site_url('komunikasi/sendMessage') ?>",
			type	: 'POST',
			dataType: 'json',
			data 	: {id_user:id_user,pesan:pesan,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
			beforeSend	: function(){
			},
			success	: function(result){
				getChat($("#id_user").val(),$("#id_max").val());
				getLastId($("#id_user").val(),$("#id_max").val()); 
				$("#pesan").val('');
				autoScroll();
			}
		});
	}
}

function searchKontak(){
	var search 	= $("#key").val();
	var csrf_test_name = $("input[name=csrf_test_name]").val();
	
	$.ajax({
		url		: "<?php echo site_url('komunikasi/searchKontak') ?>",
		type	: 'POST',
		data 	: {'csrf_test_name' : csrf_test_name,key:search},
		beforeSend	: function(){
		},
		success	: function(result){
			$("#ListKontak").html(result);
		}
	});
	
}

function autoScroll(){
	var elem = document.getElementById('box');
	elem.scrollTop = elem.scrollHeight;
}

function aktifkan(i){
	$("li").removeClass("active");
	$("#aktif-"+i).addClass("active");
}
</script>
</body>
</html>