<style type="text/css">
/*
  body {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
  }

  main {
    flex: 1 0 auto;
  }

#topbar li a, 
#footbar li a,
.footer-copyright div {
	font-size: 11px;
    color: #757575;
}
.footer-copyright .row {
	margin-bottom: 0;
}

#social li a{
	padding: 0 10px;
}

.page-footer .footer-copyright {
    box-shadow: 0px -3px 5px 0px rgba(0, 0, 0, 0.16);
    z-index: 999;
    position: relative;
    background-color: white;
}
.page-footer {
    margin-top: 0;
} 
ul#footer {	
	height: 50px;
	width: 260px;
    margin: auto;	
} */
/*
nav#topbar, nav#topbar i{
	height: 40px;
    line-height: 40px;
}
*/
nav#footbar, nav#footbar i{
	height: 50px;
    line-height: 50px;
}
nav#footbar {
	box-shadow: 0px -3px 5px 0px rgba(0, 0, 0, 0.16);
	z-index: 999;
	position: relative;
}
/*
nav#home-horizontal-nav{
    margin-top: 40px;
    opacity: 1;
}
nav#home-horizontal-nav li a {
	color: #757575;
}
/*
i.tiny {
	font-size: 1.3em;
}
*/
i.closer-right {
  margin-left: 4px;
  font-size: 16px;
}
i.closer-left {
  margin-right: 4px;
  font-size: 16px;
}

/*nav#home-horizontal-nav,*/
nav a.button-collapse,
nav a.button-collapse i,
nav i.mdi-navigation-more-vert {
	height: 50px;
    line-height: 50px;
}

nav a.button-collapse i,
nav i.mdi-navigation-more-vert {
	color: #757575;
	font-size: 1.5em;
	padding-left: 10px;
    margin-right: 10px;
}

ul#mobile-demo {
	top:40px;
	background-color: #333;
    opacity: 0.96;
    z-index: 1001;
}
.fixed-action-btn {
	top: 45px; 
	right: 80px;
	z-index: 1000;
}
.fixed-action-btn.horizontal ul {
	top: 53%;
}

.slider .slides h3 {
	font-weight: 200;
	color: #000;
	margin: 0.5rem 0 0.5rem 0;
}

a.btn-large,
button.btn-large {
	border-radius: 45px;
	top: 20px;
	font-size: 12px;
	height: 45px;
    line-height: 45px;
}

nav .input-field label i {
	text-align: left;
    margin-top: 6px;
}

nav i.material-icons {
	font-size: 1.2rem;
    height: 45px;
    line-height: 45px;
}

nav .input-field label.active i {
	color:#CCC;
}

nav .input-field input[type=search] {
	margin: 0;
	height: 55px;
}
/*
nav#slide-search-bar {
	width: 700px;
	height: 0;
	margin: 50px auto;
	line-height: 55px;
}
*/
.search-wrapper{
	margin:0 12px;
	transition:margin .25s ease
}
.search-wrapper.focused{
	margin:0
}

</style>
<header id="header" class="page-topbar">
<div class="navbar-fixed">
	<nav id="topbar" class="grey lighten-3 z-depth-0">
		<div class="nav-wrapper">
			<ul class="left">
		    	<li><a href="#">TOP IMAGES</a></li>
		    	<li><a class="dropdown-menu" href="#">CATEGORIES<i class="mdi-navigation-arrow-drop-down right closer-right"></i></a></li>		    	
		    	<li><a class="dropdown-menu" href="#">COLOR<i class="mdi-image-color-lens right closer-right"></i></a></li>
		    	<li><a href="#" id="search-link" class="search">SEARCH<i class="mdi-action-search right closer-right"></i></a></li>		    	
		    </ul>		    
		    <ul class="right hide-on-med-and-down">
		    	<li id="loguser">
					<a href="#"><i class="mdi-action-lock-outline left closer-left"></i>LOGIN / SIGN UP</a></li>
		    	<li id="top-usercart"><a href="#">
		    		<i class="material-icons left closer-left tiny">cloud</i><div class="cart-total"></div>MY CLOUD</a></li>
		    	<li id="top-options"><a href="#"><i class="fa fa-cog"></i></a></li>
			</ul>
		</div>
	</nav>
	<nav id="home-horizontal-nav" class="white">
        <div class="nav-wrapper">                  
			<a href="#" data-activates="mobile-demo" class="button-collapse show-on-large">
				<i class="mdi-navigation-menu"></i></a>
			<a href="#" class="brand-logo center"><img src="<?php echo base_url("images/rfstock.png"); ?>" alt="fivestock"></a>                
		    <ul class="side-nav" id="mobile-demo">
		        <li><a href="#" class="left-align">Sass</a></li>
		        <li><a href="#" class="left-align">Components</a></li>
		        <li><a href="#" class="left-align">Javascript</a></li>
		        <li><a href="#" class="left-align">Mobile</a></li>
		    </ul>
		    <a href="#"><i class="mdi-navigation-more-vert right"></i></a>
  <div class="progress">
  	<div class="determinate" style=""></div>
  </div>

        </div>
    </nav>

</div>

</header>

<main>
  

  <div class="slider">
    <ul class="slides">
      <li>
        <img src="<?php echo base_url("images/slider1.jpg"); ?>"> 
        <div class="caption left-align">
          <h3 class="light black-text text-lighten-3">UN INCREIBLE <strong>STOCK</strong></h3>
          <h3>A <strong>PRECIOS</strong> FLEXIBLES</h3>
          <a class="waves-effect waves-light btn-large red darken-4">VER OFERTAS</a>
        </div>
      </li>
      <li>
        <img src="<?php echo base_url("images/slider2.jpg"); ?>"> 
        <div class="caption center-align">
          <h3 class="light black-text text-lighten-3"><strong>EXTENSAS</strong> COLECCIONES</h3>
          <h3><strong>FOTOS</strong>, VECTORES & VIDEOS</h3>
          <a class="waves-effect waves-light btn-large red darken-4">ENTRA</a>&nbsp;&nbsp;
          <a class="waves-effect waves-light btn-large white grey-text">REGISTRATE</a>
        </div>
      </li>
      <li>
        <img src="<?php echo base_url("images/slider3.jpg"); ?>"> 
        <div class="caption left-align">
          <h3 class="light black-text text-lighten-3">EL <strong>STOCK</strong> DE STOCKS</h3>
          <h3><strong>ESCOGE</strong> Y COMPRA</h3>
          <h3>EN UN SOLO <strong>SITIO</strong></h3>
          <a class="waves-effect waves-light btn-large red darken-4">VER MAS</a>          
        </div>
      </li>
      <li>
        <img src="<?php echo base_url("images/slider4.jpg"); ?>"> 
        <div class="caption center-align">
          <h3 class="light black-text text-lighten-3"><strong>60,470,883</strong> ROYALTY-FREE</h3>
          <h3 class="light black-text text-lighten-3">STOCK <strong>IMAGES</strong></h3>
		  <nav id="slide-search-bar">
		    <form action="<?php echo base_url('getprovidersfull'); ?>">
		    <div class="search-wrapper card">
		        <div class="input-field col s4">
		          <input id="search" type="search" name="keywords" placeholder="Buscar imágenes, vectores y videos" required>
		          <label for="search"><i class="material-icons left">search</i></label>
		        </div>

		    </div>
		<!--   	<a class="waves-effect waves-light btn-large red darken-4"><i class="material-icons left">search</i>BUSCAR</a>-->
		   	<button class="btn-large waves-effect waves-light red darken-4" type="submit">BUSCAR
    			<i class="material-icons left">search</i>
  			</button>
		    </form>
		  </nav>          
		</div>
      </li>
    </ul>

  </div>
	<div class="fixed-action-btn horizontal">
	    <a class="btn-floating btn-large red">
	      <i class="large mdi-maps-local-offer"></i>
	    </a>
	    <ul>
	      <li><a class="btn-floating red"><i class="material-icons">insert_chart</i></a></li>
	      <li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>
	      <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
	      <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>
	    </ul>
	 </div>

<div class="page-footer">
	<nav id="footbar" class="white">

			<div class="footer-copyright">
			<div class="row">
				<div class="col l4">
					© 2016 COPYRIGHT
			    </div>
			    <div class="col l4">
	              <ul id="lang-dropdown" class="dropdown-content" style="top:-200px;">
	                  <li><a href="#"></i> English</a></li>
	                  <li><a href="#"></i> Spanish</a></li>
	              </ul>
		    
				<ul id="footer">
					<li class="center-align">
						<a href="#!" class="dropdown-menu" data-activates="lang-dropdown">LANGUAGE
							<i class="mdi-navigation-arrow-drop-up right closer-right"></i></a></li>
			    	<li class="center-align"><a href="#!">CONTACT US</a></li>
			    	<li class="center-align"><a href="#!">FAQ</a></li>
			    </ul>

				</div>
				<div class="col l4">
			    <ul id="social" class="right hide-on-med-and-down">
						<li><a href="#!"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#!"><i class="fa fa-twitter"></i></a></li>
						<li><a href="#!"><i class="fa fa-pinterest-p"></i></a></li>
						<li><a href="#!"><i class="fa fa-instagram"></i></a></li>
				</ul>
				</div>
			</div>

		</div>
	</nav>

</div>
</main>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   	<script src="<?php echo base_url("materialize/js/materialize.js"); ?>"></script>
   	<script src="<?php echo base_url("js/perfect-scrollbar.min.js"); ?>"></script>
	<script src="<?php echo base_url("js/plugins.js"); ?>"></script>

	<script type="text/javascript">

	$(document).ready(function(){

		$(".button-collapse").sideNav({
			menuWidth: 240, 
      		closeOnClick: true 
		});
	});

	$('#search-link').click(function(e){
		e.preventDefault();
		$('.slider').slider('search');
	})

    $('input#search').focus(function() { 
    	$('.search-wrapper').addClass('focused'); 
    	$('.slider').slider('pause');
    });
    $('input#search').blur(function() {
      if (!$(this).val()) {
        $('.search-wrapper').removeClass('focused');
        $('.slider').slider('start');
      }

    });
    /*$('a.brand-logo').click(function() {
    	if ($('a.brand-logo img').prop("alt") == 'rfstock') {
    		var img = '<img src="'+'<?php echo base_url("images/fivestock.png"); ?>'+'" alt="fivestock">';
    		var size = '165px';
    	}
    	else {
    		var img = '<img src="'+'<?php echo base_url("images/rfstock.png"); ?>'+'" alt="rfstock">';
    		var size = '135px';   		
    	}
    	$('a.brand-logo').html(img);
    	$('a.brand-logo img').css('width', size);
    });*/
	</script>