
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Search</a>
		</div>
		<?php 
			echo validation_errors(); 
		 	echo form_open($form_action, $formattributes);
			$this->load->view('templates/search_submit'); 
			if ($search_source === 'Getfotolia')
				$this->load->view('templates/color_filter');
			else
  				echo form_dropdown('color', $color_opt, $color_sel, $color_tag);		
  			echo form_dropdown('orientation', $orien_opt, $orien_sel, $orien_tag); 
  		?>
  		<a href="#" id="clearsearch">Clear filters</a>
		<?php echo form_close(); ?>
	</div>
</nav>
<!--
<ol class="breadcrumb">
  <li><a href="<?php echo site_url('pages/view'); ?>">Home</a></li>
  <li class="active">Search result</li>
</ol>
-->
<?php if ( empty($totalrows) ): ?>
	<p>No data</p>
<?php else: ?>
<!--	<div class="container-fluid"> -->

		<section class="Collage effect-parent">
			<?php $this->load->view('templates/search_result_all'); ?>
		</section> <!--class "row"-->

<!--	</div> -->
	<!--class "container"-->

<!--	<nav class="navbar navbar-default navbar-fixed-bottom"> -->

			<div class="row">
				<div class="col-md-4">
					<p class="navbar-text"><?php echo $totalrows . " imágenes encontradas "; ?></p>
				</div>
	        	<div class="col-md-4 col-md-offset-4">
	        		<div class="pull-right">
	        			<?php echo $pagination; ?>
	        		</div>
	        	</div>
	    
			</div>

<!--	</nav> -->


	

	<!-- The Modal section -->
	<?php $this->load->view('pages/viewimage_details'); ?>
<?php endif; ?>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> -->
   	<script src="<?php echo base_url("bootstrap/js/bootstrap.min.js"); ?>"></script>
 	<script src="<?php echo base_url("js/jquery.collagePlus.js"); ?>"></script>
 	<script src="<?php echo base_url("js/jquery.removeWhitespace.js"); ?>"></script>
  	<script src="<?php echo base_url("bootstrap/js/bootstrap-select.js"); ?>"></script> 
  	<script src="<?php echo base_url("js/jscolor/jscolor.js"); ?>"></script>
  	<script src="<?php echo base_url("js/script.js"); ?>"></script>

  	<script type="text/javascript">
	$(window).load(function () {
  		$(document).ready(function(){
  			collage();
  		});
  	});

  	function collage(){
		$('.Collage').removeWhitespace().collagePlus({
			'fadeSpeed': 1000,
			'targetHeight': 130,
			'allowPartialLastRow' : true,
			'effect': 'effect-1',
			'direction': 'vertical'
		});

  	};

  	var resizeTimer = null;
    $(window).bind('resize', function() {
        // hide all the images until we resize them
        $('.Collage .Image_Wrapper').css("opacity", 0);
        // set a timer to re-apply the plugin
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout(collage, 200);
    });

  	</script>
