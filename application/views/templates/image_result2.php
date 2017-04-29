
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Search</a>
		</div>
		 	<form id="navform" role="search" class="navbar-form navbar-left">
			<?php $this->load->view('templates/search_submit'); 
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


	<div id="box"></div>

	<p id="total"></p>				



	<!-- The Modal section -->
	<?php $this->load->view('pages/viewimage_details'); ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   	<script src="<?php echo base_url("bootstrap/js/bootstrap.min.js"); ?>"></script>
  	<script src="<?php echo base_url("bootstrap/js/bootstrap-select.js"); ?>"></script> 
 	<script src="<?php echo base_url("js/waterfall-light.js"); ?>"></script>
  	<script src="<?php echo base_url("js/jscolor/jscolor.js"); ?>"></script>
  	<script src="<?php echo base_url("js/script.js"); ?>"></script>

<script>

$(function(){

	$('#navform button').click(function(){	
		var page = 0,
			totalSearch = 0;

		// as below
		var setting = {
			gap: 10,
		    gridWidth: [0,100,200,400,800,1080,1200],
		    scrollbottom:{
		    	gap: 300,
		        endtxt : 'No More Data !!',
		        callback: function(container){
		            // if scroll to bottom, load more data...
		           ajax_get_more_data(container);

		           if(page<=45) container.waterfall('sort');
		           else container.waterfall('end');

		        }
		    }
		};

		$('#box').waterfall(setting);
/*
		$('#navform button').click(function(){

			ajax_get_more_data($('#box'));
			$('#box').waterfall(setting);
		});
*/
		function ajax_get_more_data(container) {
		    if (page<=35) {
			    var form_data = {
			            keywords: $('#keywords').val(),
			            color_sel: "<?php echo $color_sel; ?>",
			            orien_sel: "<?php echo $orien_sel; ?>"
			    		},
			    	limit = page*7;
			    	providers = ["Fotosearch", "Depositphoto", "Fotolia", "Ingimages"];
			    totalSearch = 0;
			    $.each(providers, function(i, provider){	
				    var	search_url = "http://localhost:8888/CI/getprovidersfull/search/"+limit+"/"+provider;

		            $.ajax({
		                url: search_url,
		                method: "GET",
		                data: form_data,
		                dataType: "json"
		            })
		                .done(function(msg){
		                	container.append(msg.html);
		                	totalSearch += msg.totalrows;
		                });
	            });
		        $('#total').text(totalSearch);
         	}
	        page++;
        }
    });
});
</script>
