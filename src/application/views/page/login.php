<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">
  <title>Sign In | Sistem e-SOP Kementerian Sekretariat Negara</title>
  <link rel="apple-touch-icon" href="<?=base_url()?>assets/images/apple-touch-icon.png">
  <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.ico">
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
  <link rel="stylesheet" href="<?=base_url()?>assets/examples/css/pages/login-v2.css">
  <!-- Fonts -->
  <link rel="stylesheet" href="<?=base_url()?>assets/global/fonts/web-icons/web-icons.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/global/fonts/brand-icons/brand-icons.min.css">
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
  <script src="<?=base_url()?>assets/global/vendor/breakpoints/breakpoints.js"></script>
  <script>
  Breakpoints();
  </script>
</head>
<body class="animsition page-login-v2 layout-full page-dark">

  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
  <style>
  body {
    background: transparent;
  }
  </style>
  <!-- Page -->
  <div class="page" data-animsition-in="fade-in" data-animsition-out="fade-out">
    <div class="page-content">
      <div class="page-brand-info">
        <div class="brand">
          <img class="brand-img" src="<?=base_url()?>assets/images/sekneg.png" alt="...">
          <h2 class="brand-text font-size-40">Sistem e-SOP Kemensetneg</h2>
        </div>
        <p class="font-size-15">Proses elektronik yang mengelola siklus dokumen SOP termasuk pembuatan, review, persetujuan dan penetapan dokumen, serta distribusi dan pengarsipan.</p>
        <p class="font-size-15"><a class="btn btn-success" href="<?=base_url()?>beranda"><< Beranda</a></p>
      </div>
      <div class="page-login-main animation-slide-right animation-duration-1">
        <div class="brand hidden-md-up">
          <img class="brand-img" src="<?=base_url()?>assets/images/sekneg.png" alt="...">
          <h3 class="brand-text font-size-40">eSOP Sekneg</h3>
        </div>
        <h3 class="font-size-24">Sign In</h3>
        <p>Masukkan username dan password untuk mengakses <br>Sistem e-SOP Kementerian Sekretariat Negara.</p>
		<form action="<?=base_url()?>login/act_login" method="post" name="fl" id="f_login" onsubmit="return login();">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
          <div class="form-group" id="konfirmasi"></div>
          <div class="form-group">
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" autofocus required>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" id="password_user" name="password_user" placeholder="Password" autocomplete="off" required>
			
          </div>
          <div class="form-group clearfix">
            <a class="float-right" href="#">Forgot password?</a>
          </div>
          <button class="btn btn-primary btn-block">Sign in</button>
        </form>
          <p align="center">© 2017 Kementerian Sekretariat Negara</p>
        </footer>
      </div>
    </div>
  </div>
  <!-- End Page -->
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
  <script src="<?=base_url()?>assets/global/vendor/jquery-placeholder/jquery.placeholder.js"></script>
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
  <script src="<?=base_url()?>assets/global/js/Plugin/jquery-placeholder.js"></script>
  <script>
  (function(document, window, $) {
    'use strict';
    var Site = window.Site;
    $(document).ready(function() {
      Site.run();
    });
  })(document, window, jQuery);
  
	function login(e) {
		e = e || window.event;
		var data 	= $('#f_login').serialize();
		$("#konfirmasi").html("<div class='alert alert-info'><i class='icon icon-spinner icon-spin'></i> Checking...</div>")
		$.ajax({
			type: "POST",
			data: data,
			url: "<?=base_url()?>login/act_login",
			success: function(r) {
				if (r.log.status == 0) {
					$("#konfirmasi").html("<div class='alert alert-danger'>"+r.log.keterangan+"</div>");
				} else {
					$("#konfirmasi").html("<div class='alert alert-success'>"+r.log.keterangan+"</div>");
					window.location.assign("<?=base_url()?>dashboard"); 
				}
			}
		});
		return false;
	}
  </script>
  <style id="Clickjack">body{display:none !important;}</style>
	<script type="text/javascript">
		if (self === top) {
			var Clickjack = document.getElementById("Clickjack");
			Clickjack.parentNode.removeChild(Clickjack);
		} else {
			top.location = self.location;
		}
	</script>
</body>
</html>