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
<div id="freewall" class="free-wall"></div>
<!--	</div> -->
	<!--class "container"-->



	

	<!-- The Modal section -->



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?php echo base_url("materialize/js/materialize.min.js"); ?>"></script>
  <script src="<?php echo base_url("js/jscolor/jscolor.js"); ?>"></script>
    <script src="<?php echo base_url("js/script.js"); ?>"></script>
  <script src="<?php echo base_url("js/imagesloaded.pkgd.js"); ?>"></script>
  <script src="<?php echo base_url("js/waterfall-light.js"); ?>"></script>
  <script src="<?php echo base_url("js/freewall.js"); ?>"></script>
  <script src="<?php echo base_url("js/jquery.removeWhitespace.js"); ?>"></script>

<script type="text/javascript">

var next_limit = 0;

var $container = $('#freewall');
var $progress = $('#loadwait');

$('#navform').submit(function(e) {
  // add new images
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
  var providers = ["Fotosearch", "Depositphoto", "Fotolia", "Ingimages"];
  var totalSearch = 0;
  if (limit==0)
    $container.empty();
  $('#loadwait').removeClass('hide');
    $.each(providers, function(i, provider){
      var search_url = url+"/"+limit+"/"+provider;

          $.ajax({
              url: search_url,
              method: "GET",
              data: form_data,
              dataType: "json",
              success: function(msg) {
                next_limit = msg.next_limit;
                if (i==3)
                  $('#loadwait').addClass('hide');                         
                $container.append( $(msg.html) );
                // use ImagesLoaded
                $container.imagesLoaded()
                  .progress( onProgress );
                  //.done(function(instance){
                    //$container.waterfall({gap:5, gridWidth:[0,100,150,200,800,1080,1200]});
                    //fwall;
                  //});
              }
          })
      });

}

function newHTML(html){
  $.each(html, function(i, elem){

    if (elem.nodeName === 'DIV') {
      var $item = elem.firstChild;
      //elem.css('width', $item.width+'px');
      elem.style.width = $item.width+'px';

    }
  })
  $container.append(html);
}

function fwall(){
      var wall = new freewall("#freewall");
      wall.reset({
        selector: '.brick',
        animate: true,
        cellW: 160,
        cellH: 'auto',
        onResize: function() {
          wall.fitWidth();
        }
      });
      var images = wall.container.find('.brick');
      images.find('img').load(function() {
        wall.fitWidth();
      });  
}

$(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
           LoadImages(next_limit)
    }
});

// triggered after each item is loaded
function onProgress( imgLoad, image ) {
  // change class if the image is loaded or broken
  var $item = $( image.img ).parent();
  $item.removeClass('is-loading');
  if ( !image.isLoaded ) {
    $item.addClass('is-broken');
  }
  $item.css('width', image.img.width+'px');
  //alert($item.css('width'));
  //alert(image.img.width);
}

</script>
