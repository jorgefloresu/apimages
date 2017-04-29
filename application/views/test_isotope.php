<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="<?php echo base_url("materialize/css/materialize.min.css"); ?>" media="screen, projection"/>
		<link rel="stylesheet" href="<?php echo base_url("materialize/css/materialize-plus.css"); ?>" />
		<link rel="stylesheet" href="<?php echo base_url("materialize/css/perfect-scrollbar.css"); ?>" />
		<link rel="stylesheet" href="<?php echo base_url("materialize/css/style-horizontal.css"); ?>" />
	<!--<link rel="stylesheet" href="<?php echo base_url("materialize/css/materialize-fix.css"); ?>" /> -->
	<!--	<link rel="stylesheet" href="<?php echo base_url("materialize/css/freewall.css"); ?>" /> -->
	<!--	<link rel="stylesheet" href="<?php echo base_url("materialize/css/collage.css"); ?>" /> -->
		<link rel="stylesheet" href="<?php echo base_url("materialize/css/masonry.css"); ?>" />
		<link rel="stylesheet" href="<?php echo base_url("materialize/css/magnific-popup.css"); ?>" />  
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<style type="text/css">

		.grid {
		  background: #DDD;
		  max-width: 1600px;
		}

		/* clear fix */
		.grid:after {
		  content: '';
		  display: block;
		  clear: both;
		}

		/* ---- .grid-item ---- */

		.grid-item {
		  float: left;
		  width: 170px;
		  height: 170px;
		  margin-bottom: 10px;
		  text-align: center;
		  background: #FFF;
		  box-shadow:1px 3px 4px #B3B3B3;
		  /*border-radius: 6px;*/
		  border-color: hsla(0, 0%, 0%, 0.7);
		}

		.grid-item--width2 { width: 200px; }

		/*.grid-item img {
		  display: block;
		  max-width: 100%;
		}
		.grid-item img {
		  display: inline-block;
		  vertical-align: middle;
		  /*height: 100%;

		}

		.centerer {
		  display: inline-block;
		  height: 100%;
		  vertical-align: middle;
		}	*/

</style>
</head>
<body>
<button class="action">Action</button>
<div class="grid">
<!--	
	<div class="grid-item"><img src="http://s33.impactinit.com/smsimg45/th170/IsignstockContributors/ISS_12137_00958.jpg"/></div>
	<div class="grid-item"><img src="http://s33.impactinit.com/smsimg45/th170/IsignstockContributors/ISS_12137_01030.jpg"/></div>
	<div class="grid-item"><img src="http://s33.impactinit.com/smsimg45/th170/IsignstockContributors/ISS_12137_00952.jpg"/></div>
	<div class="grid-item"><img src="http://s33.impactinit.com/smsimg45/th170/IsignstockContributors/ISS_12137_01068.jpg"/></div>
	<div class="grid-item"><img src="http://s33.impactinit.com/smsimg44/th170/Ingram/03C06184.jpg"/></div>
	<div class="grid-item"><img src="http://s33.impactinit.com/smsimg45/th170/IsignstockContributors/ISS_12137_01039.jpg"/></div>
	<div class="grid-item"><img src="http://s33.impactinit.com/smsimg45/th170/IngimageContributors/ING_39829_07205.jpg"/></div>
	<div class="grid-item"><img src="http://s33.impactinit.com/smsimg44/th170/Ingram/03B62779.jpg"/></div>
	<div class="grid-item"><img src="http://s33.impactinit.com/smsimg44/th170/Ingram/03B65151.jpg"/></div>
	<div class="grid-item"><img src="http://s33.impactinit.com/smsimg44/th170/Ingram/03B68237.jpg"/></div>
	<div class="grid-item"><img src="https://t2.ftcdn.net/jpg/00/99/92/89/160_F_99928932_jfy8DUj0lcoKYbyK33GByQWmZVkIrANR.jpg"/></div>
	<div class="grid-item"><img src="https://t2.ftcdn.net/jpg/00/99/58/81/160_F_99588132_QyZayf9ONqjOaEc4IEFwRtqG1yOpjuc0.jpg"/></div>
	<div class="grid-item"><img src="https://t2.ftcdn.net/jpg/00/99/63/53/160_F_99635365_N9bQ5U36qf1ZseBFYk8SCP4DzRKEBnCO.jpg"/></div>
	<div class="grid-item"><img src="https://t2.ftcdn.net/jpg/00/99/79/79/160_F_99797908_epiturx4RKE9YJzRttYDbFqoWSgeRc6w.jpg"/></div>
	<div class="grid-item"><img src="https://t1.ftcdn.net/jpg/00/99/22/12/160_F_99221236_1cDecdk0NWVXnTlrVAbaopeyYHHmSCiJ.jpg"/></div>
	<div class="grid-item"><img src="https://t1.ftcdn.net/jpg/01/00/02/94/160_F_100029424_karlblX4BhoAHu4vi4G3V1eNOLhcMAHw.jpg"/></div>
	<div class="grid-item"><img src="https://t2.ftcdn.net/jpg/01/00/59/61/160_F_100596134_SuiJf8HTKpOTI5BQGEbM4tHDAgxCac5t.jpg"/></div>
	<div class="grid-item"><img src="https://t2.ftcdn.net/jpg/01/00/79/11/160_F_100791185_KRJIO8BpCjRhGnmjDr49tOFDDlCGTQCe.jpg"/></div>
	<div class="grid-item"><img src="https://t2.ftcdn.net/jpg/01/00/67/37/160_F_100673786_qX2z2nCAZcWsQOykgXd6v3p4YgitAoCr.jpg"/></div>
	<div class="grid-item"><img src="https://t2.ftcdn.net/jpg/00/96/49/49/160_F_96494924_GriF6TrpkxXol668fcxtmPWJ2aExdaTj.jpg"/></div>
	<div class="grid-item"><img src="http://photos.unlistedimages.com/thumbs/CSP/CSP007/k0072448.jpg"/></div>
	<div class="grid-item"><img src="http://photos.unlistedimages.com/thumbs/CSP/CSP162/k1629456.jpg"/></div>
	<div class="grid-item"><img src="http://photos.unlistedimages.com/thumbs/CSP/CSP183/k1837158.jpg"/></div>
	<div class="grid-item"><img src="http://photos.unlistedimages.com/thumbs/CSP/CSP645/k6455007.jpg"/></div>
	<div class="grid-item"><img src="http://photos.unlistedimages.com/thumbs/CSP/CSP990/k10546354.jpg"/></div>
	<div class="grid-item"><img src="http://photos.unlistedimages.com/thumbs/CSP/CSP008/k0088313.jpg"/></div>
	<div class="grid-item"><img src="http://photos.unlistedimages.com/thumbs/CSP/CSP829/k8296609.jpg"/></div>
	<div class="grid-item"><img src="http://photos.unlistedimages.com/thumbs/CSP/CSP829/k8297665.jpg"/></div>
	<div class="grid-item"><img src="http://photos.unlistedimages.com/thumbs/CSP/CSP193/k1936678.jpg"/></div>
	<div class="grid-item"><img src="http://photos.unlistedimages.com/thumbs/CSP/CSP172/k1727171.jpg"/></div>
-->
</div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?php echo base_url("materialize/js/materialize.min.js"); ?>"></script>
  <script src="<?php echo base_url("js/jscolor/jscolor.js"); ?>"></script>
    <script src="<?php echo base_url("js/script.js"); ?>"></script>
    <script src="<?php echo base_url("js/perfect-scrollbar.min.js"); ?>"></script>
    <script src="<?php echo base_url("js/plugins.js"); ?>"></script>


  <script src="<?php echo base_url("js/imagesloaded.pkgd.js"); ?>"></script>
  <script src="<?php echo base_url("js/isotope.pkgd.js"); ?>"></script>

<script type="text/javascript">

var next_limit = 0;

$(document).ready( function() {


  var $grid = $('.grid').isotope({
    /*layoutMode: 'fitRows',*/
    itemSelector: '.grid-item',
    masonry: {
      columnWidth:180,
      gutter:10
    }
  });
  /*$grid.isotopeImagesReveal();
  /*
  $grid.imagesLoaded().progress( function() {
    $grid.isotope('layout');
  }); */
	//LoadImages(0);
});

$('.action').click(function(){
	LoadImages(0);
});


function LoadImages(limit){
  var form_data = {
          keywords: 'business',
          color_sel: "",
          orien_sel: ""
      };
  var controller = '<?php echo site_url("getprovidersfull"); ?>';
  var search = controller + "/search";
  var details = controller + "/imgdetail";
  var providers = ["Fotosearch", "Depositphoto", "Fotolia", "Ingimages"];
  var $grid = $('.grid');
  var html = '';
  if (limit==0){
    //$container.empty();
    //container.append('<div class="grid-sizer"></div>');
  }
  $('#loadwait').removeClass('hide');
    $.each(providers, function(i, provider){
      var search_url = search+"/"+limit+"/"+provider;

          $.ajax({
              url: search_url,
              method: "GET",
              data: form_data,
              dataType: "json",
              success: function(msg) {
                next_limit = msg.next_limit;
                //html += msg.html;
                //if (i==3){
                //  $('#loadwait').addClass('hide');                         
                 //$container.append(msg.html);
                  
	                 $.each(msg.result, function(res, provider){
	                 	$.each(provider.data, function(i, item){
	                  		//alert(item.code);
	                  		if (item.thumburl != ''){
		                  		var elem = 	'<div class="grid-item"><a class="modal-trigger" href="#modal1" '+
		                  					'data-url="'+details+'/'+res+'/'+item.code+'" '+
		                  					'data-img="'+item.code+'" '+
		                  					'data-caption="'+item.caption+'" '+
		                  					'data-thumb="'+item.thumburl+'" '+
		                  					'data-provider="'+res+'">'+
		                  					'<span class="centerer"></span>'+
		                  					'<img src="'+item.thumburl+'"/></a></div>';
		                  		var $items = $(elem);
		                  		$grid.append($items).isotope('appended', $items);
		                  	}
	              		});
	              		$grid.imagesLoaded().progress(function(){
		                  	$grid.isotope('layout');
		                });

	              	});
                  /*
                  var $grid = container.imagesLoaded(function(){
                    $grid.masonry({
                        itemSelector: '.grid-item',
                        percentPosition: true,
                        columnWidth: '.grid-sizer',
                        gutter: 10
                    });
                  });
                  
                  
                  var $grid = container.masonry({
                      itemSelector: '.grid-item',
                      percentPosition: true,
                      columnWidth: '.grid-sizer',
                      gutter: 10
                  });
                  $grid.imagesLoaded().progress(function(){
                    $grid.masonry('layout');
                  });
                  */
                //}
              }
          })
      });

}

</script>
</body>
</html>