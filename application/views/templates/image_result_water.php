<header id="header" class="page-topbar">
<div class="navbar-fixed">
  <nav class="light-blue lighten-1">
    <div class="nav-wrapper">
      <ul class="left">
          <li><a href="#" class="brand-logo">Search</a></li>
        </ul>
        <form action="<?php echo $form_action; ?>" id="navform">
        <div class="header-search-wrapper hide-on-med-and-down">
                <i class="mdi-action-search"></i>
                <input type="text" id="keywords" name="keywords" placeholder="Enter the keywords" 
            value="<?php echo $keywords; ?>" class="header-search-input z-depth-2" />
              <a id="send-query" href="javascript: submitform()">
                <i class="mdi-content-send"></i></a>
            
            </div>
        <ul class="right hide-on-med-and-down">
          <li id="loadwait" class="hide"><img src="<?php echo base_url('js/294.gif'); ?>" width="120"></li>
          <li><a href="#">Search options</a></li>
        </ul>
        </form>
      </div>
    </nav>
<!--
  <nav id="horizontal-nav" class="white hide-on-med-and-down">
        <div class="nav-wrapper">                  
            <ul id="nav-mobile" class="left hide-on-med-and-down">
                <li>
                    <a href="#" class="light-blue-text">
                      <i class="mdi-image-color-lens"></i>
                      <span>Select color</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
-->
</div>
</header>

	<div id="box"></div>



	<!-- The Modal section -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?php echo base_url("materialize/js/materialize.min.js"); ?>"></script>
  <script src="<?php echo base_url("js/jscolor/jscolor.js"); ?>"></script>
    <script src="<?php echo base_url("js/script.js"); ?>"></script>
  <script src="<?php echo base_url("js/waterfall-light.js"); ?>"></script>

<script type="text/javascript">

var next_limit = 0;

$('#navform').submit(function(e){
		e.preventDefault();
		LoadImages(0);
});

$(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
           LoadImages(next_limit)
    }
});

	function submitform(){
		$('#navform').submit()
	}

	function LoadImages(limit){
	    var form_data = {
	            keywords: $('#keywords').val(),
	            color_sel: "<?php echo $color_sel; ?>",
	            orien_sel: "<?php echo $orien_sel; ?>"
	    		};
	   	var url = $('#navform').attr('action');
	    var	providers = ["Fotosearch", "Depositphoto", "Fotolia", "Ingimages"];
		var container = $('#box');

		if (limit==0)
			container.empty();
  		$('#loadwait').removeClass('hide');
	    $.each(providers, function(i, provider){
		    var	search_url = url+"/"+limit+"/"+provider;
		    var images = [];
        var setting = {
            gap: 10,
            gridWidth: [0,100,200,400,800,1080,1200]
          }
            $.ajax({
                url: search_url,
                method: "GET",
                data: form_data,
                dataType: "json",
                success: function(msg) {
                	next_limit = msg.next_limit;
            		  container.append(msg.html);
           			  if (i==3){
                		$('#loadwait').addClass('hide');
                	}
                	container.waterfall(setting);
                }
            })
        });

	}
		


</script>
