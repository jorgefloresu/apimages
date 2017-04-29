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
				<div id="loadwait" class="hide"><img src="<?php echo base_url('js/294.gif'); ?>"></div>		
            </div>
		    <ul class="right hide-on-med-and-down">
		    	<li id="options"><a href="#"><i class="small material-icons">settings</i></a></li>
		    	<li id="usercart"><a href="#" onclick="<?php if ($logged && $incart>0) echo 'javascript: viewCart()'; ?>">
		    		<i class="small mdi-action-shopping-cart"><?php if ($logged && $incart>0): ?><span class="task-cat red"><?php echo $incart; ?></span><?php endif; ?></i></a></li>
		    	<li id="loguser">
		    	<?php if ($logged): ?>
	    		    <ul id="profile-dropdown" class="dropdown-content">
                          <li><a href="#"><i class="mdi-action-face-unlock"></i> Profile</a></li>
                          <li><a href="#"><i class="mdi-action-settings"></i> Settings</a></li>
                          <li><a href="#"><i class="mdi-communication-live-help"></i> Help</a></li>
                          <li class="divider"></li>
                          <li><a href="#"><i class="mdi-action-lock-outline"></i> Lock</a></li>
                          <li><a href="javascript: logout()">
                          	<i class="mdi-hardware-keyboard-tab"></i> Logout</a>
                          </li>
                    </ul>
		    		<a href="#" class="dropdown-button profile-btn" data-activates="profile-dropdown">
		    			<i class="mdi-social-person-outline"><span><?php echo $logged; ?></span>
		    				<i class="mdi-navigation-arrow-drop-down right" id="arrow-beside"></i></i>
		    		</a>
		    	<?php else: ?>
		    		<a href="#" onclick="javascript: login()">Log In</a>
		    	<?php endif; ?>

		    	</li>
		    </ul>
        </form>
	    </div>
  	</nav>

	<nav id="horizontal-nav" class="white">
        <div class="nav-wrapper">                  
            <ul id="nav-mobile" class="left">
                <li>
                    <a href="#" class="light-blue-text">
                    	<i class="mdi-image-color-lens"></i>
                    	<span>Select color</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-menu light-blue-text" href="#!" data-activates="Usersdropdown">
                        <i class="mdi-action-account-circle"></i>
                        <span>Users<i class="mdi-navigation-arrow-drop-down right"></i></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
				    <ul id="Usersdropdown" class="dropdown-content dropdown-horizontal-list">
				        <li><a href="#" class="light-blue-text">Fotosearch</a></li>
				        <li><a href="#" class="light-blue-text">Fotolia</a></li>
				        <li><p><input type="checkbox" id="opt-Depositphoto" /><label for="opt-Depositphoto">Depositphoto</label></p></li>
				        <li><a href="#" class="light-blue-text">Ingimages</a></li>
				        <!--<li><a href="#" class="light-blue-text">Ingimages</a></li>-->                    
				    </ul>

</div>
</header>

	<div id="gridalic"></div>
	<!--		<div id="popup-preview" class="mfp-hide white-popup"></div> -->

	<!-- The Modal section -->
	<div id="modal1" class="modal modal-fixed-footer">
	    <div class="modal-content">
	<!--    	<div id="modal1" class="mfp-hide std-popup">-->
		    <h4>Modal Header</h4>

			<div class="row">
				<div class="col l6 center-align">

					<div class="preloader-wrapper big active">
					    <div class="spinner-layer spinner-blue-only">
					      <div class="circle-clipper left">
					        <div class="circle"></div>
					      </div><div class="gap-patch">
					        <div class="circle"></div>
					      </div><div class="circle-clipper right">
					        <div class="circle"></div>
					      </div>
					    </div>
					 </div>
					 <a class="image-link" href="#"> 
					 <img id="mod-imagepreview" src="http://" style="max-width:100%"/></a>
		<!--			<div style="position: absolute;top: 0;bottom: 0;left: 0;right: 0;text-align:center;font: 0/0 a;"> 
						<div style="display: inline-block;vertical-align: middle;height: 100%;"></div>
					<img id="mod-imagepreview" src="http://" style="vertical-align: middle;display: inline-block;max-height: 100%;max-width: 100%;"/> 
					</div>-->

<!--
			<div class="card">
            <div class="card-image">
              <img id="mod-imagepreview" src="http://" />
              <span class="card-title">Card Title</span>
            </div>
            <div class="card-content">
              <p>I am a very simple card. I am good at containing small bits of information.
              I am convenient because I require little markup to use effectively.</p>
            </div>
            <div class="card-action">
              <a href="#">This is a link</a>
            </div>
          	</div>
-->


				</div>
				<div class="col l6 left-align">
					<ul id="prices" class="collection">
					</ul>
					<dl class="dl-horizontal">
					</dl>
				</div> 
			</div>

	    </div>
	    <div class="modal-footer">
	      	<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
	    	<a href="#modal3" onclick="javascript: viewCart()" class="modal-action waves-effect waves-green btn-flat"><i class="material-icons left">shopping_cart</i>Check out</a>
	    	</div>
	</div>

	<div id="modal2" class="modal">
	    <div class="modal-content">
			<div class="row">
			<div class="col s12">	    		
			<?php echo form_open('login/validate_credentials', 'id="form" class="login-form" novalidate'); ?>
		    	<div class="input-field col s12 center">
		    		<h4>Sign In</h4>
		    	</div>
				<div class="row margin">
					<div class="input-field col s12">
						<i class="mdi-social-person-outline prefix"></i>
						<input type="text" id="username" name="username" class="validate" required="" aria-required="true">
						<label for="username">Username</label>
					</div>
    			</div>
				<div class="row margin">
					<div class="input-field col s12">
						<i class="mdi-action-lock-outline prefix"></i>
						<input type="password" name="password" id="password" class="validate" required="" aria-required="true">
						<label for="password">Password</label>
					</div>
    			</div>
    			<div class="row">
    				<div class="input-field col s12">
						<button class="btn waves-effect waves-light col s12 pink accent-2" type="submit">Sign in
						</button>
					</div>
					<div id="message" style="display:none; color:red">
						<p class="error_msg center medium-small">Your submitted login details are incorrect.</p>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6 m6 l6">
						<p class="margin medium-small"><?php echo anchor('login/signup', 'Create Account'); ?></p>
					</div>
					<div class="input-field col s6 m6 l6">
						<p class="margin right-align medium-small"><?php echo anchor('login/signup', 'Forgot Password'); ?></p>
					</div>
				</div>
			<?php echo form_close(); ?>
			</div>
			</div>
	    </div>
	</div>

	<div id="modal3" class="modal modal-fixed-footer">
	    <div class="modal-content">
			<ul id="cart" class="collection with-header">
			</ul>
	    </div>
	    <div class="modal-footer">
	      	<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
	    </div>
	</div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   	<script src="<?php echo base_url("materialize/js/materialize.js"); ?>"></script>
   	<script src="<?php echo base_url("js/perfect-scrollbar.min.js"); ?>"></script>
	<script src="<?php echo base_url("js/jquery.grid-a-licious.js"); ?>"></script>
	<script src="<?php echo base_url("js/magnific-popup.js"); ?>"></script>
 	<script src="<?php echo base_url("js/jscolor/jscolor.js"); ?>"></script>
   	<script src="<?php echo base_url("js/plugins.js"); ?>"></script>

  	
<script type="text/javascript">

	var next_limit = 0;


	function submitform(){
		$('#navform').submit()
	}

	function LoadImages(limit){
		var keys = $('#keywords').val();
		if (keys === "")
			return false;

	    var form_data = {
	            keywords: keys,
	            color_sel: "<?php echo $color_sel; ?>",
	            orien_sel: "<?php echo $orien_sel; ?>"
	    		};
	   	var url = $('#navform').attr('action');
	    var	providers = ["Fotosearch", "Depositphoto", "Fotolia", "Ingimages"];
	    var	foundSome = false;
	    var noGrid = true;
		var container = $('#gridalic');
		
		if ($('#opt-Depositphoto').prop("checked"))
			providers = ["Depositphoto"];

		if (limit==0) 
			container.empty();
		$('#loadwait').removeClass("hide");

	    $.each(providers, function(i, provider){
		    var	search_url = url+"/"+limit+"/"+provider;

            $.ajax({
                url: search_url,
                method: "GET",
                data: form_data,
                dataType: "json",
                success: function(msg) {

                	if (msg.html !== ""){
                		foundSome = true;
	                	next_limit = msg.next_limit;	                	
	                	if ((i==0 && limit==0) || noGrid) {
	                		noGrid = false;                		
	                		container.append(msg.html);
		        			container.gridalicious({
		        				width: 170, 
		        				gutter:10, 
		        				animate:false,
		        				animationOptions: {
		        					queue: false
		        				}
		        			})
	                	}
	                	else
	        				container.gridalicious('append', msg.html);
	        		}
           			if (i==providers.length-1){
                		$('#loadwait').addClass("hide");
                		if (!foundSome)
                			container.append('No results found');
                 	}
                }
            })
        })
	}

	function getDownloadRef(urlRef, cartId, hReference){
		$.ajax({
			url: urlRef,
			type: 'POST',
			async: false,
			dataType: 'json',
			success:function(data){
				if (data.status == 'OK'){
					$("#i"+cartId+" #dlink").html(' <span class="task-cat green">Download</span>');
					hReference(data.downloadreference);
				}
			}
		});
	}

	function delCartItem(itemId, price){
		var submit_url = "<?php echo site_url('transactions/item_cart_delete'); ?>";
		var itemcol = 'ul#cart li#i'+itemId;
		var form_data = {id: itemId};
		$.ajax({
			url: submit_url,
			type: 'POST',
			data: form_data,
			async: false,
			dataType: 'json',
			success:function(data){
				$(itemcol).remove();
				changeCartCount(-1, price);
			}
		});

	}

	function addToCart(elem, thumb, imgcode, provider, price, priceType, resolution, size, dimension, pixels, hReturn){
		var submit_url = "<?php echo site_url('transactions/save_to_cart'); ?>";		
		var form_data = {
			cartid: $('#loguser a i span').text(),
			username: $('#loguser a i span').text(),
			img_url: thumb,
			img_code: imgcode,
			img_provider: provider,
			img_price: price,
			price_type: priceType,
			resolution: resolution,
			img_dimension: dimension,
			img_pixels: pixels,
			size: size,
			download_url: elem
		};

		$.ajax({
			url: submit_url,
			type: 'POST',
			data: form_data,
			async: false,
			dataType: 'json',
			success:function(data){
				hReturn(data);
			}
		});
	}

	function recordTransaction(elem, imgcode, provider, price, priceType, resolution, size, dimension, pixels, trnx, hReturn){
		var submit_url = "<?php echo site_url('transactions/store_transaction'); ?>";
		var form_data = {
			username: $('#loguser a i span').text(),
			img_url: elem,
			img_code: imgcode,
			img_provider: provider,
			img_price: price,
			price_type: priceType,
			resolution: resolution,
			size: size,
			img_dimension: dimension,
			img_pixels: pixels,
			activity_type: trnx
		};

		$.ajax({
			url: submit_url,
			type: 'POST',
			data: form_data,
			async: false,
			dataType: 'json',
			success:function(data){
				hReturn(data);
			}
		});
	}

	function getIt(url){
		$("#i"+cartId+" #dlink").removeAttr('onclick');
		window.location = url;
	}

	function go_download(elem, imgcode, provider, price, priceType, resolution, size, cartId, typemedia, dimension, pixels){
		var user = $('#loguser a i span').text();
		if ( is_logged() ){
			recordTransaction(elem, imgcode, provider, price, priceType, resolution, size, dimension, pixels, 'download', function(output){
				if (output.result === 'recorded')
					switch (provider){
						case "Fotosearch":
							getIt(elem);
							break;
						case "Depositphoto":
							$.ajax({
									url: elem,
									type: 'POST',
									async: false,
									dataType: 'json',
									success:function(data){
										getIt(data.url);
										//$("#i"+cartId+" #dlink").removeAttr('onclick');
										//$("#i"+cartId+" #dlink").prop('href', data.url);
									}
								});
							break;
						case "Ingimages":
							elem += "/"+output.recId;
							getDownloadRef(elem, cartId, function(ref){
								var submit_url = "<?php echo site_url('getprovidersfull/Ingimages_Download'); ?>"+
												"/"+imgcode+"/"+typemedia+"/"+ref+"/"+output.recId+"/"+cartId;
								//alert(submit_url);
								$.ajax({
									url: submit_url,
									type: 'POST',
									async: false,
									dataType: 'json',
									success:function(data){
										getIt(data.url);
										//$("#i"+cartId+" #dlink").removeAttr('onclick');
										//$("#i"+cartId+" #dlink").prop('href', data.url);
									}
								});

							});
							//window.location = elem+"&userid="+user+"&orderid="+output.recId+"&price="+price;
							break;
						case "Fotolia":
							$("#i"+cartId+" #dlink").removeAttr('onclick');
							$("#i"+cartId+" #dlink"+" .task-cat").text('Ordered');
							break;
					}
				else
					alert('Cannot proceed with download');
			});
		}
		else
			alert('Please log-in to download');
	}

	function cart(elem, imgcode, provider, price, resolution, size, priceType, thumb, dimension, pixels){
		addToCart(elem, thumb, imgcode, provider, price, priceType, resolution, size, dimension, pixels, function(output){
			if (output.result === 'recorded'){
				Materialize.toast('Added to cart', 2000);
				changeCartCount(1,0);
			}
		});
	}

	function changeCartCount(val, price){
		var str_cartcnt = $('#usercart span').html();
		var str_total = $('li#cartotal a').text().substr(4);
		var cartcnt = 0;

		if (str_cartcnt === undefined)
			cartcnt = val
		else
			cartcnt = Number(str_cartcnt) + val;

		if (cartcnt == 0){
			$('#usercart i').html('');
			$('#usercart a').attr('onclick','');
		}
		else{
			$('#usercart i').html('<span class="task-cat red"></span>');
			$('#usercart span').html(cartcnt);
			$('#usercart a').attr('onclick','javascript: viewCart()');
		}

		cartotal = Number(str_total) - Number(price);
		
		$('li#cartotal a').text('USD '+parseFloat(cartotal).toFixed(2));
	}

	function viewCart(){
		if (is_logged()){
			var submit_url = "<?php echo site_url('transactions/view_cart'); ?>",
				cart_details = '',
				total_cart = 0,
				cart_price = 0,
				download_label = "Download",
				label_color = "green",
				download_url = '',
				typemedia = '';
			var	form_data = {
					username: $('#loguser a i span').text()
				};

			$.ajax({
				url: submit_url,
				type: 'POST',
				data: form_data,
				async: false,
				dataType: 'json',
				success:function(data){
					cart_header = '<li class="collection-header"><h4>Cart Details</h4></li>';
					$('ul#cart').html(cart_header);
					$.each( data, function( key, value ) {

						download_url = value.download_url;
						if (value.price_type == 'credits')
							calc_price = value.img_price * 1.40
						else
							calc_price = value.img_price;

						switch (value.img_provider){
							case "Ingimages":
								//download_label = 'Request ' + download_label;
								//label_color = "orange";
								typemedia = download_url.substr(download_url.length-1);
								download_url += "/"+$('#loguser a i span').text()+"/"+value.img_price;							
								break;
							case "Depositphoto":
								download_url += "/"+$('#loguser a i span').text();
								break;
							case "Fotolia":
								download_label = 'Put order';
								label_color = "orange";
								break;
						}

	  					cart_details = '<li id="i'+value.id+'" class="collection-item avatar">'+
	  								   '<div class="row"><div class="col s6">'+
	  								   '<img src="'+value.img_url+'" alt="" class="circle">'+
	  								   '<span class="title">'+value.img_code+'</span>'+
	  								   '<p>'+value.img_dimension+'</p>'+
	  								   '<p>'+value.img_pixels+'</p>'+
	  								   '</div><div class="col s3">'+
	  								   '<a href="#" onclick="javascript: delCartItem('+"'"+
	  								   	value.id+"','"+calc_price+"'"+')"><span class="task-cat red">Delete</span></a>'+
	  								   '<a id="dlink" href="#" onclick="javascript: go_download('+"'"+download_url+
	  								   	"','"+value.img_code+"','"+value.img_provider+"','"+value.img_price+
	  								   	"','"+value.price_type+"','"+value.resolution+"','"+value.size+"','"+value.id+
	  								   	"','"+typemedia+"','"+value.img_dimension+"','"+value.img_pixels+"'"+')"> '+
	  								   '<span class="task-cat '+label_color+'">'+download_label+'</span></a>'+
	  								   '</div><div class="col s3">'+
	  								   '<a href="#" class="secondary-content">USD '+parseFloat(calc_price).toFixed(2)+
	  								   '</a></div></div></li>';

	  					$('ul#cart').append(cart_details);
	  					total_cart += Number(calc_price);
					});
					cart_total = '<li id="cartotal" class="collection-item">'+
				 				 '<span class="title">TOTAL IN CART</span>'+
				 				 '<a href="#" class="secondary-content">USD '+parseFloat(total_cart).toFixed(2)+'</a></li>';
				 	$('ul#cart').append(cart_total);
				}
			});

			$('#modal3').openModal();
		}
	}	

	function loginIcon(inCart){
		var url = "<?php echo site_url('login/logout/noindex'); ?>";
		var username = $('#username').val();
		var html = '<ul id="profile-dropdown" class="dropdown-content">'+
                          '<li><a href="#"><i class="mdi-action-face-unlock"></i> Profile</a></li>'+
                          '<li><a href="#"><i class="mdi-action-settings"></i> Settings</a></li>'+
                          '<li><a href="#"><i class="mdi-communication-live-help"></i> Help</a></li>'+
                          '<li class="divider"></li>'+
                          '<li><a href="#"><i class="mdi-action-lock-outline"></i> Lock</a></li>'+
                          '<li><a href="javascript: logout()">'+
                          	'<i class="mdi-hardware-keyboard-tab"></i> Logout</a>'+
                          '</li>'+
                    '</ul>'+
		    		'<a href="#" class="dropdown-button profile-btn" data-activates="profile-dropdown">'+
		    			'<i class="mdi-social-person-outline"><span>'+username+'</span><i class="mdi-navigation-arrow-drop-down right" id="arrow-beside"></i></i>'+
		    		'</a>';
		
		/*
		$('#loguser').find('href="#modal2"').attr('class', 'dropdown-button profile-btn');
		$('#loguser').find('href="#modal2"').attr('data-activates', 'profile-dropdown');
		$('#loguser').find('href="#modal2"').html(html);
		$('#loguser').find('href="#modal2"').attr('href', '#');*/

		$('li#loguser').html(html);
		
		$('.dropdown-button').dropdown({
		    inDuration: 300,
		    outDuration: 125,
		    constrain_width: true, // Does not change width of dropdown to that of the activator
		    hover: false, // Activate on click
		    alignment: 'left', // Aligns dropdown to left or right edge (works with constrain_width)
		    gutter: 0, // Spacing from edge
		    belowOrigin: true // Displays dropdown below the button
		  });

		if (inCart !== '0')
			changeCartCount(inCart,0);
	}

	function logout(){
		var html = '<a href="#modal2" onclick="javascript: login()">Log In</a>';
		var logout_url = "<?php echo site_url('login/logout/noindex'); ?>";
		var form_data = {};

		$.ajax({
			url: logout_url,
			type: 'POST',
			data: form_data,
			success:function(data)
			{
				// If the returned login value successul.
				if (data)
				{
					$('#loguser').html(html);
					$('#usercart i').html('');
					//$('#modal2').leanModal({dismissible: true});
				}
				// Else the login credentials were invalid.
				else
				{
					// Show an error message stating the users login credentials were invalid.
					$('#message').show();
				}
			}
		});		
	}

	function login(){
		$('#modal2').openModal();
	}

	function is_logged(){
		return ($('#loguser a').html() !== 'Log In');
	}

	$(document).ready(function(){

		$('#gridalic').on("click", "a", function(){
			var preview_url = $(this).data('url'),
			 	image_code = $(this).data('img'),
			 	image_caption = $(this).data('caption'),
			 	provider = $(this).data('provider'),
			 	image_thumb = $(this).data('thumb'),
			 	download_code = '',
			 	resolution_id = '',
			 	price_type = '',
			 	show_val = '',
			 	dimension = '',
			 	image_url = '',
			 	license = 'standard'
			 	size = '',
			 	price = 0;
			var	download_url = "<?php echo site_url('getprovidersfull'); ?>"+
			 					"/"+provider+"_Download/"+image_code+"/";
			var download_ref_url = "<?php echo site_url('getprovidersfull/get_download_ref'); ?>"+
								"/"+provider+"/"+image_code+"/";

			$('#mod-imagepreview').attr('src', ''); // clean the last image loaded
			$('div.preloader-wrapper').show(); 	
			$('#modal1 h4').text(image_code);

			$('dl.dl-horizontal').text('');
			$('ul#prices').text('');
			
			$.getJSON(preview_url, function(res) {
				$('#mod-imagepreview').attr('src', res.url);
				$('.image-link').prop('href', res.url);
				image_url = res.url;
				/*
				$('.open-popup').magnificPopup({
					items: {src: res.url},
					type: 'image'
				});
				*/
				for (var i = 0; i < res.resolutions.length; i++) {
					var collection_str = '<li class="collection-item avatar">';

					$.each(res.resolutions[i], function(key, val){
						switch (key){
							case "name":
								resolution_id = val.substring(0,1);
								if (resolution_id == "U")
									collection_str += '<i class="material-icons circle green">'
								else if (resolution_id == "E"){
										collection_str += '<i class="material-icons circle orange">';
										license = "Extended";
									}
									 else
										collection_str += '<i class="material-icons circle">';
								collection_str += resolution_id+'</i>'+'<span class="title">'+val+'</span>';
								break;

							case "price":
								if (price_type == 'credits')
									show_val = val + ' ' + price_type
								else
									show_val = price_type + val;
								price = val;
								collection_str += '<a href="#" class="secondary-content">'+show_val+'</a>';
								break;

							case "code":
						 		size = val;
						 		switch (provider){
						 			case "Fotosearch":
						 				download_code = download_url+"sale/"+val+"/photosale_";
							 			//download_code += download_url+"usage=sale&res="+val+"&saveas=photosale_";
							 			break;
							 		case "Depositphoto":
							 			download_code = download_url+val;
							 			break;
							 		case "Ingimages":
							 			download_code = download_ref_url+"single/1";
							 			break;
							 		case "Fotolia":
							 			download_code = "";
							 			break;
						 		}
								break;

							case "price_type":
								price_type = val;
								break;

							case "pixels":
								if (is_logged()){
									collection_str += '<p>'+val+'<a href="#" onclick="cart('+"'";
									switch (provider){
										case "Fotosearch":
											collection_str += download_code+resolution_id+image_code;																								
											break;
										case "Depositphoto":
											collection_str += download_code+"/"+license;
											break;
										case "Ingimages":
											collection_str += download_code;
											break;
										case "Fotolia":
											collection_str += download_code;
											break;
									}
									collection_str += "','"+image_code+"','"+provider+"','"+price+"','"+resolution_id+"','"+
												size+"','"+price_type+"','"+image_thumb+"','"+dimension+"','"+val+
												"'"+');">'+'<span class="new badge pink accent-2">Add to Cart</span></a></p></li>';
								}
								else
									collection_str += '<p>'+val+'</p>';
								break;

							case "dimension":
								dimension = val.replace(/'/g, "");
								collection_str += '<p>'+dimension+'</p>';
								break;
						}
/*
						if (key == "name") {
							resolution_id = val.substring(0,1);
							if (resolution_id == "U")
								collection_str += '<i class="material-icons circle green">'
							else if (resolution_id == "E")
									collection_str += '<i class="material-icons circle orange">'
								 else
									collection_str += '<i class="material-icons circle">';
							collection_str += resolution_id+'</i>'+'<span class="title">'+val+'</span>';
						}	
						else if (key == "price") {
								if (price_type == 'credits')
									show_val = val + ' ' + price_type
								else
									show_val = price_type + val;
								price = val;
								collection_str += '<a href="#" class="secondary-content">'+show_val+'</a>';
							 }
							 else if (key == "code"){						 		
							 		download_code = download_url;
							 		switch (provider){
							 			case "Fotosearch":
							 				//download_code = download_url+"sale/"+val+"/photosale_"
								 			download_code += "usage=sale&res="+val+"&saveas=photosale_";
								 			break;
								 		case "Ingimages":
								 			download_code += "plan=single&type=1";
								 			break;
							 		}
							 	  }
							 	  else if (key == "price_type")
							 	  			price_type = val
							 	  	   else if (key == "pixels" && is_logged()){
												collection_str += '<p>'+val+'<a href="#" onclick="cart('+"'";
												switch (provider){
													case "Fotosearch":
														collection_str += download_code+resolution_id+image_code;																								
														break;
													case "Ingimages":
														collection_str += download_code;
														break;
												}
												collection_str += "','"+image_code+"','"+provider+"','"+price+"','"+price_type+"','"+image_thumb+
													"'"+');">'+'<span class="new badge pink accent-2">Add to Cart</span></a></p></li>';
											}
											else
												collection_str += '<p>'+val+'</p>'; */
					});					
					
					$('ul#prices').append(collection_str);
				}
				$.each(res.prop, function(key, val){
					$('dl.dl-horizontal').append(
						'<dt class="fix-dt-width">'+key+':</dt>'+
						'<dd id="mod-'+key+'" class="fix-dd-margin">'+val+'</dd>'
						);
				});
			});

			$('#mod-imagepreview').on('load', function(){
				$('div.preloader-wrapper').hide();
			});


			$('#modal1').openModal();	
			/*
			$('.open-popup').magnificPopup({
				items: {src: image_url},
	    		type: 'image'
	  		});
*/

		});	

		$('#options').click(function(){
			
			$(this).addClass(function(index, currentClass){
				var addedClass;
				var navSize, navShow;
				if (currentClass === "active") {
					$(this).removeClass("active");
					navSize = navShow = "0";
				}
				else {
					addedClass = "active";
					navSize = "64px";
					navShow = "1";
				}
				$('#horizontal-nav').animate({
					'margin-top': navSize,
					'opacity': navShow
				}, 500);

				return addedClass
			})


		});

		// the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
		$('.modal-trigger').leanModal({dismissible: true});

		$('#navform').submit(function(e){
			e.preventDefault();		
			LoadImages(0);
		});

		//$('.materialboxed').materialbox();
		$('.image-link').magnificPopup({
    		type: 'image',
    		mainClass: 'mfp-no-margins mfp-with-zoom',
    		closeOnContentClick: true,
    		closeBtnInside: false,
    		zoom: {
    			enabled: true, // By default it's false, so don't forget to enable it
				duration: 300, // duration of the effect, in milliseconds
    			easing: 'ease-in-out'
    		}
    		/*
    		callbacks: {
    			elementParse: function(item) {
    				alert(item.src);
    			}
    		}
    		*/
    	});

		$('#form').submit(function(event)
		{
			// Get the url that the ajax form data is to be submitted to.
			var submit_url = $(this).attr('action');
			var success_url = "<?php echo site_url('getprovidersfull'); ?>";

			// Get the form data.
			var $form_inputs = $(this).find(':input');
			var form_data = {};
			$form_inputs.each(function() 
			{
				form_data[this.name] = $(this).val();
			});

			$.ajax(
			{
				url: submit_url,
				type: 'POST',
				data: form_data,
				dataType: 'html',
				success:function(data)
				{
					// If the returned login value successul.
					if (data)
					{
						// Hide any error message that may be showing.
						$('#message').hide();
						$('#modal2').closeModal();
						//window.location = success_url;
						loginIcon(data);
					}
					// Else the login credentials were invalid.
					else
					{
						// Show an error message stating the users login credentials were invalid.
						$('#message').show();
					}
				}
			});
			event.preventDefault();

		});

		// Search class for focus
		$('.header-search-input').focus(
		function(){
		  	$(this).parent('div').addClass('header-search-wrapper-focus');
		}).blur(function(){
		  	$(this).parent('div').removeClass('header-search-wrapper-focus');
		});  


	});

	$(window).scroll(function() {
	    if($(window).scrollTop() == $(document).height() - $(window).height()) {
	        LoadImages(next_limit)
	    }
	});


</script>

