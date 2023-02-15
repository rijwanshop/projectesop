
  <!-- Plugins -->
  <script src="<?=base_url()?>assets/global/vendor/screenfull/screenfull.js"></script>
  <script src="<?=base_url()?>assets/global/js/State.js"></script>
  <script src="<?=base_url()?>assets/global/js/Component.js"></script>
  <script src="<?=base_url()?>assets/global/js/Plugin.js"></script>
  <script src="<?=base_url()?>assets/global/js/Base.js"></script>
  <script src="<?=base_url()?>assets/global/js/Config.js"></script>
  <script src="<?=base_url()?>assets/js/Section/Menubar.js"></script>
  <script src="<?=base_url()?>assets/js/Section/Sidebar.js"></script>
  <script src="<?=base_url()?>assets/js/Section/PageAside.js"></script>
  <script src="<?=base_url()?>assets/js/Plugin/menu.js"></script>
  
  <!-- Page -->
  <script src="<?=base_url()?>assets/js/Site.js"></script>
  <script src="<?=base_url()?>assets/global/js/Plugin/asscrollable.js"></script>
  <script src="<?=base_url()?>assets/global/js/Plugin/slidepanel.js"></script>
  <script src="<?=base_url()?>assets/global/js/Plugin/switchery.js"></script>
  
  <script>
  (function(document, window, $) {
    'use strict';
    var Site = window.Site;
    $(document).ready(function() {
      Site.run();
    });
  })(document, window, jQuery);
  </script>

  <!-- datatable -->
  <script src="<?=base_url()?>assets/global/js/Plugin/datatables.js"></script>
  <script src="<?=base_url()?>assets/examples/js/tables/datatable.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/datatables.net/jquery.dataTables.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/datatables.net-fixedheader/dataTables.fixedHeader.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/datatables.net-scroller/dataTables.scroller.js"></script>
  <script src="<?=base_url()?>assets/global/vendor/datatables.net-responsive/dataTables.responsive.js"></script>
  
  <style id="Clickjack">body{display:none !important;}</style>
	<script type="text/javascript">
		if (self === top) {
			var Clickjack = document.getElementById("Clickjack");
			Clickjack.parentNode.removeChild(Clickjack);
		} else {
			top.location = self.location;
		}
	</script>
  <!-- Footer -->
  <footer class="site-footer">
    <div class="site-footer-legal">&copy; 2017 Kementerian Sekretariat Negara</div>
  </footer>


</body>
</html>