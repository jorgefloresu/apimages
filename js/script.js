
//$(document).ready(function(){
/*
                var boxGroup1 = $('#box-Fotosearch');
                for(var i=0;i<10;i++){
                    var card = $('<div>').addClass('card').css({
                        height: Math.floor((Math.random() * 100) + 100)+"px",
                        background: '#ace'
                    }); boxGroup1.append(card);
                }
*/
/*
var setting = {
    scrollbottom : {
      endtxt : 'No More Data !!',
      callback: function(container){
        // if scroll to bottom, load more data...
        $.ajax({
        	url: ""
        }).done(function(data){
          if(data){    
            // resort elements
            container.waterfall('sort');
        	}
          else
            // done, show message
            container.waterfall('end');
        });
      }
    }
};
*/
//$('#box-Fotosearch').waterfall(setting);
/*
$('#box-Fotosearch').waterfall();
$('#box-Depositphoto').waterfall();
$('#box-Fotolia').waterfall();
$('#box-Ingimages').waterfall();
*/


//	$('#box').waterfall({gridWidth: [0,100,200,400,800,1080,1200]});
 
 // Search class for focus
  $('.header-search-input').focus(
  function(){
      $(this).parent('div').addClass('header-search-wrapper-focus');
  }).blur(
  function(){
      $(this).parent('div').removeClass('header-search-wrapper-focus');
  });  


/*
$('a[rel=popover]').popover({
  	html: true,
  	trigger: 'hover',
  	placement: 'auto right',
  	content: function(){return $(this).data('img');}
  	//function(){return '<img src="'+$(this).data('img') + '" />';}
});
*/
$('#fsModal').on('show.bs.modal', function(e) {
	var link = $(e.relatedTarget),
	 	preview_url = link.data('url'),
	 	image_code = link.data('img'),
	 	image_caption = link.data('caption');

	$('#mod-imagepreview').attr('src', ''); // clean the last image loaded
	$('div.loading-indicator').show(); 	
	$('.modal-title').text(image_code);
	$('.modal-header p').text(image_caption);

	$.getJSON(preview_url, function(res) {
		$('#mod-imagepreview').attr('src', res.preview_url);
		$('#mod-colortype').text(res.type);
		$('#mod-orientation').text();
		$('#mod-keywords small').text(res.keywords.toString());
	});

	$('#mod-imagepreview').on('load', function(){
		$('div.loading-indicator').hide();
	});

});

$('#mmModal').on('show.bs.modal', function(e) {
	var link = $(e.relatedTarget),
	 	preview_url = link.data('url'),
	 	image_code = link.data('img'),
	 	image_caption = link.data('caption');

	$('#mod-imagepreview').attr('src', ''); // clean the last image loaded
	$('div.loading-indicator').show(); 	
	$('.modal-title').text(image_code);
	$('.modal-header p').text(image_caption);

	$('dl.dl-horizontal').text('');

	$.getJSON(preview_url, function(res) {
		$('#mod-imagepreview').attr('src', res.url);
		$.each(res.prop, function(key, val){
			$('dl.dl-horizontal').append(
				'<dt class="fix-dt-width">'+key+':</dt>'+
				'<dd id="mod-'+key+'" class="fix-dd-margin">'+val+'</dd>'
				);
		});
	});

	$('#mod-imagepreview').on('load', function(){
		$('div.loading-indicator').hide();
	});

});


$('#xxModal').on('show.bs.modal', function(e) {
	var link = $(e.relatedTarget),
	 	url = link.data('url'),
	 	image_code = link.data('img'),
	 	image_caption = link.data('caption'),
	 	image_preview = link.attr('href');

	$.get(url, function (res) {
		var orientation;
		xmlDoc = $.parseXML(res);
		$xml = $(xmlDoc);
		
		colortype = $xml.find('colorType').text();
		ori = $xml.find('orientation').text();
		switch (ori) {
			case '1': orientation = 'Vertical'; break;
			case '2': orientation = 'Horizontal'; break;
			case '3': orientation = 'Cuadrada'; break;
			};
		keywords = $xml.find('keywords').text();
		$('#mod-colortype').text(colortype);
		$('#mod-orientation').text(orientation);
		$('#mod-keywords small').text(keywords);
	});

});

$('#clearsearch').click(function() {
	//var myPicker = new jscolor.color(document.getElementById('jsColor'), {required:false});  // now you can access API via 'myPicker' variable
	$('.selectpicker').selectpicker('deselectAll');
	$('#jsColor').val('');
	//$('#navform button').click();
});

$('.selectpicker').change(function() {
	$('#navform button').click();
});

$('#jsColor').change(function() {
	$('#navform button').click();
});

$('#del_img').click(function() {
	
	var form_data = {
		image_name: "<?php echo $news_item['img_name']; ?>",
		image_ext: "<?php echo $news_item['ext']; ?>",
		id: "<?php echo $news_item['id']; ?>"		
	};

	$.ajax({
		url: "<?php echo base_url('news/delete_img'); ?>",
		type: 'POST',
		data: form_data,
		success: function(msg) {
			$('#img_removed').html(msg);
			$('#img_deleted').val('1');
			/*alert(msg);*/
		}
	});

	return false;
});

