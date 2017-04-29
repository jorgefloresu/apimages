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
		    	<li><img src="<?php echo base_url('js/294.gif'); ?>" width="120"></li>
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


	<section class="Collage effect-parent"></section>
	<button id="reorder" class="btn btn-default fix-font">Reorder</button>
	<p id="total"></p>				


	<!-- The Modal section -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   	<script src="<?php echo base_url("materialize/js/materialize.min.js"); ?>"></script>
 	<script src="<?php echo base_url("js/jquery.collagePlus.js"); ?>"></script>
 	<script src="<?php echo base_url("js/jquery.removeWhitespace.js"); ?>"></script>
 	<script src="<?php echo base_url("js/jscolor/jscolor.js"); ?>"></script>
  	<script src="<?php echo base_url("js/script.js"); ?>"></script>

<script type="text/javascript">

	var next_limit = 0;

	$('#navform').submit(function(e){
		e.preventDefault();		
		LoadImages(0);
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
	    var	totalSearch = 0;
		var container = $('.Collage');
		var items = '';
		if (limit==0)
			container.empty();
		$('p#loader').css("visibility","visible");
	    $.each(providers, function(i, provider){
		    var	search_url = url+"/"+limit+"/"+provider;

            $.ajax({
                url: search_url,
                method: "GET",
                data: form_data,
                dataType: "json",
                success: function(msg) {
                	items += msg.html;
                	next_limit = msg.next_limit;
            		container.append(msg.html);           		
            		$('.Collage div').each(function(i,el){
            			img = el.firstChild;
            			width  = img.width == 0 ? '160px' : img.width + 'px';
            			height = img.height == 0 ? '80px' : img.height + 'px';
            			img.setAttribute("width", width);
            			img.setAttribute("height", height);
            			//alert(img.height);
            			//console.log(container.html());
            			//images.push(el);
            		});
           			if (i==3){
                		$('p#loader').css("visibility","hidden");
                	}
               		collage(container);
                }
            })
        });

	}
	
	$('#reorder').click(function(){
		reorder($('.Collage'))
	});

	$('#options').click(function(){
		
		$(this).addClass(function(index, currentClass){
			var addedClass;
			if (currentClass === "active")
				$(this).removeClass("active")
			else
				addedClass = "active";
			return addedClass
		})

	});

	function reorder(container){
		var old = container.html();
		container.empty();
		container.html(old);
		collage(container)
	}

	function collage(container){
		container.collagePlus({
			'fadeSpeed': 1000,
			'targetHeight': 160,
			'allowPartialLastRow' : true,
			'effect': 'default',
			'direction': 'horizontal'
		})
	}

	var resizeTimer = null;
	$(window).bind('resize', function() {
	    // hide all the images until we resize them
	    // set the element you are scaling i.e. the first child nodes of ```.Collage``` to opacity 0
	    $('.Collage .Image_Wrapper').css("opacity", 0);
	    // set a timer to re-apply the plugin
	    if (resizeTimer) clearTimeout(resizeTimer);
	    resizeTimer = setTimeout(collage($('.Collage')), 200);
	});

	$(window).scroll(function() {
	    if($(window).scrollTop() == $(document).height() - $(window).height()) {
	           LoadImages(next_limit)
	    }
	});

</script>
