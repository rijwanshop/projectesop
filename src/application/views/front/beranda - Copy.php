<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistem e-SOP Kementerian Sekretariat Negara</title>

	<!-- MAIN CSS FILES===================================
	======================================================= -->
    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url()?>assets/front/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animation -->
    <link rel="stylesheet" href="<?=base_url()?>assets/front/css/animate.css">
    <!-- Custom CSS -->
    <link href="<?=base_url()?>assets/front/css/theme.css" rel="stylesheet">
    <!-- Responsive styles-->
    <link rel="stylesheet" href="<?=base_url()?>assets/front/css/responsive.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?=base_url()?>assets/front/css/font-awesome.min.css">
     <!-- icon moon -->
   <link rel="stylesheet" href="<?=base_url()?>assets/front/css/icon-moon.css">
   <link rel="stylesheet" href="<?=base_url()?>assets/front/css/reset.css">
</head>

<body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-menu">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> 
          <span class="sr-only">Toggle navigation</span> 
          <span class="icon-bar"></span> 
          <span class="icon-bar"></span> 
          <span class="icon-bar"></span> 
        </button>
        <a class="navbar-brand" href="index.html">
          <div class="logo-text"><span><samp>M</samp>Medi</span>camp</div>
          <!-- <img src="images/logo.png" alt="logo"> -->
        </a> 
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" data-hover="dropdown" data-animations="fadeIn fadeInLeft fadeInUp fadeInRight">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="index.html">Home</a></li>
          <li><a href="aboutus.html">About us </a></li>
          <li><a href="services.html">Services </a></li>
          <li class="dropdown active"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Work <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="portfolio-3.html">3 colums</a></li>
              <li><a href="portfolio-4.html">4 colums</a></li>
            </ul>
          </li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Blog <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="blog-listing.html">Blog Listing</a></li>
              <li><a href="blog-details.html">Blog Details</a></li>
            </ul>
          </li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Pages <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="faq.html">Faq</a></li>
              <li><a href="typography.html">Typography</a></li>
              <li><a href="404.html">404</a></li>
            </ul>
          </li>
          <li><a href="contact.html">Contact Us</a></li>
        </ul>
      </div>
      <!--/.nav-collapse --> 
    </div>
  </nav>
	<!-- navbar end -->

	<!-- section slider start -->
	<div id="section-slider">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="carousel slide" id="slider-carousel">
						<div class="carousel-inner">
							<div class="item active">
								<div class="slider-caption ">
									<h2 class="big-title wow slideInLeft">slide 1</h2>
									<p class="wow slideInRight">desc slide 1.</p>
									<a href="#" class="btn btn-primary white">learn more</a>
								</div>
							</div> <!-- item end -->
						</div>
						<!-- Controls -->
						  <a class="left carousel-control" href="#slider-carousel" role="button" data-slide="prev">
						    <i class="fa  fa-long-arrow-left " aria-hidden="true"></i>
						    <span class="sr-only">Previous</span>
						  </a>
						  <a class="right carousel-control" href="#slider-carousel" role="button" data-slide="next">
						    <i class="fa  fa-long-arrow-right " aria-hidden="true"></i>
						    <span class="sr-only">Next</span>
						  </a>
					</div> <!-- carousel slider wrapper -->
				</div>
			</div><!-- row end -->
		</div> <!-- container end -->
	</div>
    <!-- section slider end -->

    <!-- section service start -->
    <section id="section-service">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12 wow fadeIn">
    				<div class="section-heading text-center">
    					<h2>Selamat Datang</h2>
    					<p>Selamat Datang di Sistem e-SOP Kementerian Sekretariat Negara Selamat Datang di Sistem e-SOP Kementerian Sekretariat Negara Selamat Datang di Sistem e-SOP Kementerian Sekretariat Negara .</p>
    				</div>
    			</div>
    		</div> <!-- row end -->

    	</div> <!-- container end -->
    </section>
    <!-- section service end -->



    <!-- section Footer start -->
    <section id="section-footer">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12 text-center wow fadeInDown">
    				<div class="footer-desc">
    					<h6 class="copy">&copy;copyright 2017</h6>
    				</div>
    			</div>
    		</div> <!-- row end -->
    	</div> <!-- container end -->
    </section>
    <!-- section Footer end -->

    <!-- jQuery -->
    <script src="<?=base_url()?>assets/front/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?=base_url()?>assets/front/js/bootstrap.min.js"></script>
    <!-- form validation -->
    <script type="text/javascript" src="<?=base_url()?>assets/front/js/validator.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/front/js/form-scripts.js"></script>
    <!-- Plugin JavaScript -->
    <script src="<?=base_url()?>assets/front/js/jquery.easing.min.js"></script>
    <!-- Wow Animation -->
    <script type="text/javascript" src="<?=base_url()?>assets/front/js/wow.min.js"></script>
    <!-- html5 shiv -->
    <script type="text/javascript" src="<?=base_url()?>assets/front/js/html5shiv.js"></script>
    <!-- respond js -->
    <script type="text/javascript" src="<?=base_url()?>assets/front/js/respond.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?=base_url()?>assets/front/js/theme.js"></script>

</body>

</html>
