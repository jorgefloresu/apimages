
var next_limit = 0;
var prev_limit = 0;
var grid_style = 'card';
var loadedImageCount = 0;
var expected_result = 0;
var totalSearch = 0; 
var $grid = $('.grid');
var gridElements;
var fxRate;

var init = {};
$.getJSON('js/initvars.json', initvars);


function initvars(json){
  init = json;
  getRate('EUR','USD');
}

function submitform(){
  //$('#navform').submit();
  $.ajax({url:'js/initvars.json', async:false}).done(function(json){initvars(json)});
  CleanGrid();
  LoadImages(0, false);

}

function getItemElement(details, res, item, j){

  if (grid_style == 'autofit')
    var $element = $('<div id="_'+item.code+'" class="grid-item no-card"><div id="loading" class="is-loading">'+
        '<a id="preview" class="modal-trigger red-text text-darken-4" href="#modal1" '+
        'data-url="'+details+'/'+res+'/'+item.code+'" '+
        'data-img="'+item.code+'" '+
        'data-caption="'+item.caption+'" '+
        'data-thumb="'+item.thumburl+'" '+
        'data-provider="'+res+'">'+
        '<span class="centerer"></span>'+
        '<img class="z-depth-1 hoverable" src="'+item.thumburl+'"/></a></div>'+
        '<p class="code-text"><b>'+item.code+'</b></p>'+
        '<div class="switch right"><label><input type="checkbox" name="'+item.code+'">'+
        '<span class="lever"></span></label></div></div>')
  else
    var $element = $('<div id="_'+item.code+'" class="card grid-item hoverable with-card">'+
        '<div class="card-image waves-effect waves-block waves-light">'+
        '<div id="loading" class="is-loading">'+
        '<a class="btn-floating btn-small btn-price red accent-4">9999</a>'+
        '<img class="activator" src="'+item.thumburl+'"></div>'+
        '</div><div class="card-content">'+
        '<span class="card-title activator grey-text text-darken-4">'+item.code+
        '<i class="material-icons right">more_vert</i></span>'+
        '<div class="switch right">'+
        '<p><a id="preview" class="modal-trigger grey-text text-darken-1" href="#modal1" '+
        'data-url="'+details+'/'+res+'/'+item.code+'" '+
        'data-img="'+item.code+'" '+
        'data-caption="'+item.caption+'" '+
        'data-thumb="'+item.thumburl+'" '+
        'data-provider="'+res+'">'+
        '<span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i>'+
        '<i class="fa fa-tag fa-stack-1x"></i></span></a>'+
        '<span class="fa-stack fa-lg grey-text text-darken-1"><i class="fa fa-square-o fa-stack-2x"></i>'+
        '</span><span class="provider grey-text text-darken-1">'+init.logo[res]+'</span></p>'+
        '<label><input type="checkbox" name="'+item.code+'">'+
        '<span class="lever"></span></label></div>'+
        '</div><div class="card-reveal">'+
        '<span class="card-title">'+item.code+
        '<i class="material-icons right">close</i></span>'+
        '<div class="price red-text text-darken-4">'+
        '<i class="fa fa-refresh fa-spin"></i></div>'+
        '<p>#'+j+'<br/>'+item.caption+'</p>'+
        '</div></div>');

  return $element;
}

function updateProgress(value, total, item){
  $('.determinate').css('width', (value/total*100)+'%');
  if (item)
    item.find('#loading').removeClass('is-loading');

}

function LoadImages(limit, restart){
  var keys = $('#keywords').val();

  if (keys === "")
    return false;

  var form_data = {
          keywords: keys,
          color_sel: '', //"<?php echo $color_sel; ?>",
          orien_sel: '' //"<?php echo $orien_sel; ?>"
      };
  var controller = init.url_controller; //'<?php echo site_url("getprovidersfull"); ?>';
  var search = controller + "/search";
  var details = controller + "/imgdetail";
  var j = 0;
  var res_count = 0;
  var hadErrors = false;
  var provider = '';
  
  // Temporary only during test
  if ($('#opt-Depositphoto').prop("checked")){
    provider = "Depositphoto";
    init.providers = ["Depositphoto"];
  }
  if ($('#opt-Fotosearch').prop("checked")){
    provider = "Fotosearch";
    init.providers = ["Fotosearch"];
  }
  if ($('#opt-Fotolia').prop("checked")){
    provider = "Fotolia";
    init.providers = ["Fotolia"];
  }
  if ($('#opt-Ingimages').prop("checked")){
    provider = "Ingimages";
    init.providers = ["Ingimages"];
  }
  if ($('#opt-Panthermedia').prop("checked")){
    provider = "Panthermedia";
    init.providers = ["Panthermedia"];
  }
  //-------
  expected_result = init.imageBlock * init.providers.length;

  //limit = $('#page').val(); //Para tomar el page
  $grid.append('<div class="static-banner">Contacting image stocks...</div>');
  totalSearch = 0;
  if (limit==0){
    prev_limit = 0; 
  }
  else{
    $('.static-banner').fadeIn(400);
    prev_limit = limit - init.imageBlock;
  }
  console.log('limit:'+limit+'. prev_limit:'+prev_limit+'. expected_result:'+expected_result);
  $('#loadwait').removeClass('hide');
  $('.determinate').css('width','0%');
  $('.determinate').removeClass('hide');
  $('#load-more').remove();

  
//  $.each(init.providers, function(i, provider){
      var search_url = search+"/"+limit+"/"+provider+"/";
      if (restart)
        search_url += "/1";
      var $items;
      var $grid_items;
      var jqXHR = $.ajax({
              url: search_url,
              method: "GET",
              data: form_data,
              dataType: "json",
              async: true,
              timeout: init.timeoutLimit

          }).done(function(msg, textStatus, jqXHR){
                next_limit = msg.next_limit;
                //if (limit==0)
                  totalSearch = Number(msg.totalrows);
                if (Object.keys(msg.result).length>0){
                  expected_result = init.imageBlock * Object.keys(msg.result).length;                  
                  $.each(msg.result, function(res, provider){
                    console.log(res+' done!: '+msg.result[res].data.length+' resultados');
                    res_count = provider.data.length;
                    expected_result -= (init.imageBlock - res_count);
                    $.each(provider.data, function(i, item){
                          j++;
                          $items = getItemElement(details, res, item, j);
                          updateProgress(j, expected_result-init.imageBlock, $items);

                          $grid_items = $grid.append($items).isotope('appended', $items)
                                                  .imagesLoaded()
                                                  .always(function(){
                                                    $grid_items.isotope('layout')
                                                  });
                                                  //.progress(onProgress);
                    });
                  });
                }
                else{
                  res_count = 0;
                  expected_result -= init.imageBlock;
                  updateProgress(j, expected_result-init.imageBlock);
                }

          }).fail(function(jqXHR, textStatus, errorThrown){
                hadErrors = true;
                expected_result -= init.imageBlock;
                j += init.imageBlock;
                updateProgress(j, expected_result-init.imageBlock);
                console.log('fail! textStatus:'+textStatus+'. errorThrown:'+errorThrown);
 
          }).always(function(msg, textStatus){
                var in_screen = $grid.isotope('getItemElements').length;
                console.log('always! j:'+j+'. expected_result:'+expected_result+'. textStatus:'+textStatus+
                            '. in_screen:'+in_screen+'. totalSearch:'+totalSearch);
                console.log(msg);
                if (j >= expected_result || textStatus == 'timeout'){
                  $('.switch').css('z-index','2');
                  $('#loadwait').addClass("hide");
                  $('.determinate').addClass("hide");
                  $('.determinate').css('width','0%');
                  $('div.static-banner').delay(2000).fadeOut(400);
                  if (in_screen==0 && j>=expected_result)
                    //$grid.after('<div id="load-more" class="container">No hay resultados</div>');
                      $grid.after('<div id="load-more" class="container">'+
                        '<a id="button-more" class="waves-effect waves-light btn-large white grey-text text-darken-2" '+
                        'onclick="'+loadless+'">'+'Anteriores '+in_screen+' de '+totalSearch+
                        '. Cargar más imágenes...</a></div>');

                  else
                    if (! $('#load-more').length && in_screen>0){
                      loadmore = (in_screen>=totalSearch ? '' : 'load_more()');
                      loadless = (in_screen>=totalSearch ? '' : 'load_less()');

                      $grid.after('<div id="load-more" class="container">'+
                        '<a id="button-more" class="waves-effect waves-light btn-large white grey-text text-darken-2" '+
                        'onclick="'+loadless+'">'+'Anteriores '+in_screen+' de '+totalSearch+
                        '. Cargar más imágenes...</a>'+
                        '<a id="button-more" class="waves-effect waves-light btn-large white grey-text text-darken-2" '+
                        'onclick="'+loadmore+'">'+'Siguentes '+in_screen+' de '+totalSearch+
                        '. Cargar más imágenes...</a>'+
                        '<a href="#" id="pagerwait" class="hide"><i class="fa fa-refresh fa-spin"></i></a>'+
                        '</div>');
                    }
                  mess = 'Total in screen: ' + in_screen;
                  if (textStatus == 'timeout') 
                    mess += '. Timeout problem ';
                    
                  console.log(mess);

                }
          });

          jqXHR.done(function(msg, textStatus){
                console.log('jqXHR done');
                console.log("finish, result: "+res_count);
                gridElements = $grid.isotope('getItemElements');
                //console.log(gridElements);
                //$('.pagination').remove();
                //$grid.after(msg.pagination);                      

                if (textStatus == 'success'){
                  mess = (j >= expected_result) ? "Completed" : "Loading images found...";
                  if (hadErrors)
                    mess += ". But errors from some sources";
                  $('div.static-banner').text(mess);
                }

          }).fail(function(jqXHR, textStatus, errorThrown){
            console.log('jqXHR fail');
            console.log("fail: "+textStatus+'. error:'+errorThrown);
            if (textStatus == 'timeout')
              $('div.static-banner').text('Some stocks have delayed response. Results may be incompleted.');
            else if (textStatus == 'error')
              $('div.static-banner').text('Some stocks did not respond. Results are less than expected.');
            if (j >= expected_result) {
              $('#loadwait').addClass("hide");
              $('.determinate').addClass("hide");
              $('.determinate').css('width','0%');
              $('div.static-banner').delay(2000).fadeOut(400);              
            }

          });
   // })

}

  function CleanGrid(){
    if (Array.isArray(gridElements)){
      $grid.isotope('remove', gridElements); 
      $grid.isotope({filter: '*'}); 
      //$grid.remove();
      //$('#site-link').after('<div class="grid"></div>');
      //initGrid();
    }
  }

  function getDownloadRef(urlRef, cartId, hReference){
    $.ajax({
      url: urlRef,
      type: 'POST',
      async: false,
      dataType: 'json',
      success:function(data){
        if (data.status == 'OK'){
          hReference(data.downloadreference);
        }
      }
    });
  }

  function delCartItem(item){
    var submit_url = init.url_itemDelete; //"<?php echo site_url('transactions/item_cart_delete'); ?>";
    var itemcol = 'ul#cart li#i'+item.data.itemId;
    var form_data = {id: item.data.itemId};

    $.ajax({
      url: submit_url,
      type: 'POST',
      data: form_data,
      async: false,
      dataType: 'json'

      }).done(function(data){
          $(itemcol).remove();
          changeCartCount(-1, item.data.price);

      }).fail(function(jqXHR, textStatus, errorThrown){
          alert(errorThrown+': error al borrar');
      });

    return false;
  }

   function addToCart(item, hReturn){
    var submit_url = init.url_saveToCart; //"<?php echo site_url('transactions/save_to_cart'); ?>";    
    var form_data = {
      cartid: $('#loguser a span').text(),
      username: $('#loguser a span').text(),
      img_url: item.data.thumb,
      img_code: item.data.imgcode,
      img_provider: item.data.provider,
      img_price: item.data.price,
      price_type: item.data.priceType,
      resolution: item.data.resolution,
      img_dimension: item.data.dimension,
      img_pixels: item.data.pixels,
      size: item.data.size,
      download_url: item.data.elem
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

    function recordTransaction(item, trnx, hReturn){
    var submit_url = init.url_storeTran; //"<?php echo site_url('transactions/store_transaction'); ?>";
    var form_data = {
      username: $('#loguser a span').text(),
      img_url: item.data.elem,
      img_code: item.data.imgcode,
      img_provider: item.data.provider,
      img_price: item.data.price,
      price_type: item.data.priceType,
      resolution: item.data.resolution,
      size: item.data.size,
      img_dimension: item.data.dimension,
      img_pixels: item.data.pixels,
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
    window.location = url;
  }

  function setLicenceId(recId, licenseid){
    $.ajax({
      url: "<?php echo site_url('transactions/set_license_id'); ?>",
      type: 'POST',
      dataType: 'json',
      data: {recId: recId, licenseid: licenseid}
    })
    .done(function(data) {
      if (data.result == 'set')
        console.log("license set");
    });
    
  }

  function go_download(item){
    var user = $('#loguser a span').text();
    if ( is_logged() ){
        recordTransaction(item, 'download', function(output){
        if (output.result === 'recorded')
          switch (item.data.provider){

            case "Fotosearch":
              getIt(item.data.elem);
              break;

            case "Depositphoto":
              $.ajax({
                  url: item.data.elem,
                  type: 'POST',
                  dataType: 'json'
                }).done(function(data){
                    getIt(data.url);
                    setLicenceId(output.recId, data.licenseid);
                });
              break;

            case "Ingimages":
              elem_url = item.data.elem+"/"+output.recId;
              
              getDownloadRef(elem_url, item.data.cartId, function(ref){
                var submit_url = init.url_Ing_down+
                        "/"+item.data.imgcode+"/"+item.data.size+"/"+ref+"/"+output.recId+"/"+item.data.cartId;
                $.ajax({
                  url: submit_url,
                  type: 'POST',
                  dataType: 'json'
                }).done(function(data){
                    getIt(data.url);
                });

              });
              break;

            case "Fotolia":
              $("#i"+item.data.cartId+" #dlink"+" .task-cat").text('Ordered');
              break;

            case "Panthermedia":
              $("#i"+item.data.cartId+" #dlink"+" .task-cat").text('Waiting for link...')
                                                             .prop("class", "task-cat white grey-text");
              $.ajax({
                  url: item.data.elem,
                  type: 'POST',
                  dataType: 'json'
                }).done(function(data){
                    $("#i"+item.data.cartId+" #dlink"+" .task-cat").text('Download')
                                                                   .prop("class", "task-cat green");
                    $("#i"+item.data.cartId+" #dlink").off('click')
                                                      .prop('href', data.url)
                                                      .prop('download', 'download_'+item.data.imgcode+'.jpg');
                });
              break;

            case "Pixabay":
              $("#i"+item.data.cartId+" #dlink"+" .task-cat").text('Download')
                                                             .prop("class", "task-cat green");
              $("#i"+item.data.cartId+" #dlink").off('click')
                                                .prop('href', item.data.elem)
                                                .prop('download', 'download_'+item.data.imgcode);
              //getIt(item.data.elem);
              break;

          }
        else
          alert('Cannot proceed with download');
      });
    }
    else
      alert('Please log-in to download');
    return false;
  }

  function cart(item){
    addToCart(item, function(output){
      if (output.result === 'recorded'){
        Materialize.toast('Sent to My Cloud', 2000);
        changeCartCount(1,0);
      }      
    });
    return false;
  }

  function changeCartCount(val, price){
    //var str_cartcnt = $('#usercart span').html();
    var str_cartcnt = $('.cart-total span').text();
    var str_total = $('li#cartotal a').text().substr(4);
    var cartcnt = 0;

    if (str_cartcnt === undefined)
      cartcnt = val
    else
      cartcnt = Number(str_cartcnt) + val;

    if (Number(cartcnt) == 0){
      $('#usercart i').html('');
      $('.cart-total').html('');
    }
    else{
      $('#usercart i').html('<span class="task-cat red"></span>');
      $('#usercart span').html(Number(cartcnt));

      $('#top-usercart a i').addClass('red-text');
      $('#top-usercart a i').removeClass('tiny');
      $('.cart-total').html('<span class="task-cat">'+Number(cartcnt)+'</span>');
    }

    cartotal = Number(str_total) - Number(price);
    
    $('li#cartotal a').text('USD '+parseFloat(cartotal).toFixed(2));
  }

  function itemPrice(priceType, price){
    var calc_price;

    switch (priceType){
      case "credits":
        calc_price = price * 1.40;
        break;
      case "eur":
        calc_price = price * 1.11;
        break;
      default: 
        calc_price = price;
    }

    return calc_price;    
  }

  function itemLabel(lbl, provider){
    var text;

    switch (provider){

      case "Fotolia":
        download_label = 'Put order';
        label_color = "orange";
        break;
      
      case "Panthermedia":
        download_label = "Get the link";
        label_color = "orange";
        break;

      case "Pixabay":
        download_label = "Request for FREE";
        label_color = "orange";
        break;

      default:
        download_label = "Download";
        label_color = "green";

    }

    return ((lbl=="ldown") ? download_label : label_color);
  }

  function viewCart() {
    if (is_logged()){
      var $cart = $('ul#cart');
      var submit_url = init.url_viewCart; //"<?php echo site_url('transactions/view_cart'); ?>";
      var form_data = {
          username: $('#loguser a span').text()
        };

      $.ajax({
        url: submit_url,
        type: 'POST',
        data: form_data,
        async: true,
        dataType: 'json'
      }).done(function(data){ 
          var total_cart = calc_price = 0;            
          var download_label, label_color;

          $cart.html('<li class="collection-header"><h4>My Cloud items</h4></li>');

          $.each( data, function( key, value ) {

              calc_price = itemPrice(value.price_type, value.img_price);
              download_label = itemLabel("ldown", value.img_provider);
              label_color = itemLabel("lcolor", value.img_provider);

              $li           = $('<li>',  {"id": "i"+value.id, "class": "collection-item avatar"}).appendTo($cart);
              $divrow       = $('<div>', {"class": "row"}).appendTo($li);
              $divcol       = $('<div>', {"class": "col s6"}).appendTo($divrow);
              $img          = $('<img>', {"src": value.img_url, "class": "circle"}).appendTo($divcol);
              $span         = $('<span>'+value.img_code+'</span>', {"class": "title"}).appendTo($divcol);
              $p            = $('<p>'+value.img_dimension+'</p><p>'+value.img_pixels+'</p>').appendTo($divcol);
              $divcol2      = $('<div>', {"class": "col s3"}).appendTo($divrow);
              $a_delete     = $('<a href="#" id="deleteItem"></a>').on("click", {
                                  itemId: value.id,
                                  price: calc_price
                              }, delCartItem).appendTo($divcol2);

              $span_delete  = $('<span class="task-cat red">Delete</span>').appendTo($a_delete);

              $a_delete.append(' ');

              if (value.img_price > 0) {
                $a_pay        = $('<a href="#" id="pay"></a>').on("click", {
                                    itemId: value.id,
                                    imgcode: value.img_code,
                                    price: calc_price
                                }, payItem).appendTo($divcol2);
                $span_pay     = $('<span class="task-cat green">$</span>').appendTo($a_pay);
                $a_pay.append(' ');
                down_ready = "hide";
              }
              else 
                down_ready = "";

              $a_download   = $('<a href="#" id="dlink" class="'+down_ready+'"></a>').on("click", {
                                  elem: value.download_url,
                                  imgcode: value.img_code,
                                  provider: value.img_provider,
                                  price: value.img_price,
                                  priceType: value.price_type,
                                  resolution: value.resolution,
                                  size: value.size,
                                  cartId: value.id,
                                  dimension: value.img_dimension,
                                  pixels: value.img_pixels
                              }, go_download).appendTo($divcol2);

              $span_download  = $('<span class="task-cat '+label_color+'">'+download_label+'</span>')
                                .appendTo($a_download);

              $divcol3        = $('<div>', {"class": "col s3"}).appendTo($divrow);
              $a_price        = $('<a href="#" class="secondary-content">USD '+parseFloat(calc_price).toFixed(2)+'</a>')
                                .appendTo($divcol3);

              total_cart += Number(calc_price);              
          });

          cart_total          = '<li id="cartotal" class="collection-item"><span class="title">TOTAL</span>'+
                                '<a href="#" class="secondary-content">USD '+parseFloat(total_cart).toFixed(2)+'</a></li>';
          $cart.append(cart_total);
      });

      $('#modal3').openModal();
    }
  } 

  function loginIcon(inCart, user){
    var url = init.url_logout; //"<?php echo site_url('login/logout/noindex'); ?>";
    var username = (user==undefined ? $('#username').val() : user);
    /*var html = '<ul id="profile-dropdown" class="dropdown-content">'+
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
            '</a>';*/
    var html = '<ul id="user-dropdown" class="dropdown-content">'+
               '<li><a href="#"><i class="mdi-action-face-unlock"></i> Profile</a></li>'+
               '<li><a href="javascript: logout()"><i class="mdi-hardware-keyboard-tab"></i> Logout</a></li>'+
               '</ul>'+
               '<a href="#" class="dropdown-button" data-activates="user-dropdown">'+
               '<i class="mdi-social-person-outline left closer-left"></i><span>'+username+'</span>'+
               '<i class="mdi-navigation-arrow-drop-down right closer-right"></i></a>';

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

    //$('.recent-activity-list').html('hello');
  }

  function logout(){
    var html = '<a href="#" id="login"><i class="mdi-action-lock-outline left closer-left"></i>LOGIN | SIGN UP</a>';
    //'<a href="#modal2" onclick="javascript: login()">Log In</a>';
    var logout_url = init.url_logout; //"<?php echo site_url('login/logout/noindex'); ?>";
    var form_data = {};

    signOut();
    fbLogout();
    
    $.ajax({
      url: logout_url,
      type: 'POST',
      data: form_data
    }).done(function(data){
        // If the returned login value successul.
        if (data)
        {
          //$('#loguser').html(html);
          $('#loguser').html('');
          $(html).on("click", login).appendTo('#loguser');
          $('.cart-total span').remove();
          $('#top-usercart a i').removeClass('red-text');
          $('#top-usercart a i').addClass('tiny');

          $('#usercart i').html('');


          //$('#modal2').leanModal({dismissible: true});
        }
        // Else the login credentials were invalid.
        else
        {
          // Show an error message stating the users login credentials were invalid.
          $('#message').show();
        }
    });   
  }

  function login(){
    $('#modal2').openModal();
  }

  function payItem(item){
    $('#myCCForm').trigger('reset');
    $('#itemId').val(item.data.itemId);
    $('#orderId').val(item.data.itemId+'-'+item.data.imgcode);
    $('#totalId').val(item.data.price);
    $('#orderNumber').val('9876543210');
    $('#imageCode').val(item.data.imgcode);
    $('#username').val($('#loguser a span').text());
    $('#message p').text('');
    $('#modal4').openModal();
  }

  function is_logged(){
    var loginfo = $('#loguser a span').text();
    return (loginfo !== 'LOGIN | SIGN UP' && loginfo !== '');
  }

  function cart_test(item){
    alert(item.data.elem);
    alert(item.data.price);
    return false;
  }

  function load_more() {
    $('a#pagerwait').removeClass('hide');
    CleanGrid();
    $('#load-more').remove();
    $('.static-banner').show();
    $('html, body').animate({ scrollTop: 0 }, "slow");
    console.log('prev:'+prev_limit+' next:'+next_limit);
    LoadImages(next_limit, false);
  }      

  function load_less() {
    $('a#pagerwait').removeClass('hide');
    CleanGrid();
    $('#load-more').remove();
    $('.static-banner').show();
    $('html, body').animate({ scrollTop: 0 }, "slow");
    console.log('prev:'+prev_limit+' next:'+next_limit);
    LoadImages(prev_limit, false);
  }      

  function user_profile() {
    alert($('#loguser a span').text());
  }

  function imgPreview(url, provider, id, caption, image_thumb, res) {
      var download_code = '',
          resolution_id = '',
          price_type = '',
          show_val = '',
          dimension = '',
          image_url = '',
          license = '',
          size = '',
          name = '',
          license = '',
          pixels = '',
          price = 0;

      var tbuy = {cash: new Object(), credits: new Object()};
      var provMethod = res.prop.More["Buy method"].split(", ");

      var haveExtended = $.map(res.resolutions, function(item,i){
            if (item.license=='Extended')
            return (i);
        })[0];

      var li    = '<li></li>';
      var divhd = '<div class="collapsible-header active"></div>';
      var divbd = '<div class="collapsible-body white"></div>';
      var i     = '<i class="material-icons"></i>';
      var ul    = '<ul class="collapsible" data-collapsible="accordion"></ul>';
      var table = '<table class="bordered highlight responsive-table"></table>';
      var thead = '<thead><tr><th data-field="res">Resolución</th>'+
                             '<th data-field="size">Tamaño</th>'+
                             '<th data-field="price">Precio</th>'+
                             '<th data-field="action">My Cloud</th></tr></thead>';
      var litab = '<li class="tab col s6"></li>';

    $.fn.tagContent = function(args) {
        $(this).find('i').text(args.i);
        var div = $(this).html();
        $(this).html(div+args.div);       
        return this;      
    } 

    $row = $('#prices');
    $row.empty();

    $('.imgdetail #loading').empty();
    $('.imgdetail #loading').addClass('is-loading');
    $('.imgdetail #loading').append('<a class="image-link" href="'+res.url+'" title="'+caption+'">'+
                            '<img id="imgdetail-preview" class="z-depth-1" src="'+res.url+'" /></a>')
                            .imagesLoaded().done(function(instance){
                              $('.imgdetail #loading').removeClass('is-loading');
                              $('#_'+id+' #loading').removeClass('is-loading');
                            });
    $('.imgdetail #title').text('Image ID: '+id);
    $('.imgdetail #subtitle').text(caption.toUpperCase());
    $('.imgdetail #keywords-preview').text(res.prop.Keywords)

    $col   = $('<div class="col s12 m12 l12"></div>').appendTo($row);

    if (provMethod.length > 1){
      //$tabcol = $('<div class="col s12"></div>').prependTo($row);
      $tabul = $('<ul class="tabs"></ul>').appendTo($col);
      $.each(provMethod, function(i,method){
        tbuy[method].litab      = $(litab).appendTo($tabul);
        active = (i==0) ? "active" : "";
        linkm  = "#"+method;
        tbuy[method].atab       = $('<a>'+method+'</a>').prop({href:linkm, class:active}).appendTo(tbuy[method].litab);
        tbuy[method].divtab     = $('<div>',{"id":method, "class":"col s12"}).appendTo($row);
      });
    }
    else {
      tbuy[provMethod[0]].divtab = $col;
    }

    $.each(provMethod, function(index,method){
      tbuy[method].ul         = $(ul).appendTo(tbuy[method].divtab);

      tbuy[method].std        = $(li).appendTo(tbuy[method].ul);
      tbuy[method].std_head   = $(divhd).append(i).tagContent({i:"filter_drama", div:"Standard"}).appendTo(tbuy[method].std);        
      tbuy[method].std_body   = $(divbd).appendTo(tbuy[method].std);
      tbuy[method].std_tbl    = $(table).appendTo(tbuy[method].std_body);
      tbuy[method].std_tbl_hd = $(thead).appendTo(tbuy[method].std_tbl);
      tbuy[method].std_tbl_bd = $('<tbody>',{"id":"Standard"}).appendTo(tbuy[method].std_tbl);

      if (haveExtended) {
        tbuy[method].ext        = $(li).appendTo(tbuy[method].ul);
        tbuy[method].ext_head   = $(divhd).append(i).tagContent({i:"place", div:"Extended"}).appendTo(tbuy[method].ext);
        tbuy[method].ext_body   = $(divbd).appendTo(tbuy[method].ext);
        tbuy[method].ext_tbl    = $(table).appendTo(tbuy[method].ext_body);
        tbuy[method].ext_tbl_hd = $(thead).appendTo(tbuy[method].ext_tbl);
        tbuy[method].ext_tbl_bd = $('<tbody>',{"id":"Extended"}).appendTo(tbuy[method].ext_tbl);
      }
    });    

    for (var i = 0; i < res.resolutions.length; i++) {
      //if ( i<3 ){
        /*
        $card = $('<div class="card hoverable"></div>').hover(function(){
                    $(this).find('.card-content').addClass('card-black');
                    $(this).find('.card-content p').addClass('card-text');
                    $(this).find('.card-action').removeClass('black').addClass('action-red');
                }, function(){
                    $(this).find('.card-content').removeClass('card-black');
                    $(this).find('.card-content p').removeClass('card-text');
                    $(this).find('.card-action').removeClass('action-red').addClass('black');
                }).appendTo($col);
        color_cont = 'white';
        color_tcont = '';
        color_title = 'red-text';
        color_action= 'black';

        $c_cont = $('<div class="card-content center-align"></div>').appendTo($card);
        */
 
        $.each(res.resolutions[i], function(key, val){

          switch (key){
              case "code":
                size = val;
                break;
              case "price_type":
                price_type = val;
                break;
              case "price":

                if (price_type == 'credits'){
                  show_val = val + ' ' + price_type;
                  buyMethod = price_type;
                }
                else{
                  if (val == 0)
                    show_val = 'Free'
                  else
                    show_val = price_type + ' ' + val;
                  buyMethod = 'cash';
                }
                price = val;
                //$('<span class="card-title '+color_title+'">'+show_val+'</span>').appendTo($c_cont);
                //$('<p style="font-size:24px;line-height:13px"><b>-</b></p>').appendTo($c_cont);
                //$('<p style="color:grey">'+name.toUpperCase()+'</p>').appendTo($c_cont);
                break;
              case "name":
                resolution_id = val.substring(0,1);
                name = val;
                break;
              case "license":
                license = val;
                break;
              case "pixels":
                //$('<p>'+val+'</p>').appendTo($c_cont);
                //license = (name != 'Extended') ? 'Standard' : 'Extended';
                //$('<p>'+license.toUpperCase()+'</p>').appendTo($c_cont);
                pixels = val;
                break;
              case "dimension":
                dimension = val.replace(/'/g, "");
                break;
          }
        });
        
        down_url = url + downloadUrlRef(provider, size, resolution_id, id, license, price, res.url);

        if (license == 'Standard'){
          $selected_row = $('<tr></tr>').appendTo(tbuy[buyMethod].std_tbl_bd);
        }
        else{
          $selected_row = $('<tr></tr>').appendTo(tbuy[buyMethod].ext_tbl_bd);
        }

        $('<td>'+name+'</td>').appendTo($selected_row);
        $('<td>'+pixels+'</td>').appendTo($selected_row);
        $('<td>'+show_val+'</td>').appendTo($selected_row);
        $('<td><a href="#">Send</a></td>').on("click", {
                              elem: down_url,
                              imgcode: id,
                              provider: provider,
                              price: price,
                              resolution: resolution_id,
                              size: size,
                              priceType: price_type,
                              thumb: image_thumb,
                              dimension: dimension,
                              pixels: pixels
                            }, cart).appendTo($selected_row);
        /*
        $c_action = $('<div class="card-action black center-align"></div>').appendTo($card);
        $('<a href="#">SEND TO MY CLOUD</a>').on("click", {
                              elem: url,
                              imgcode: id,
                              provider: provider,
                              price: price,
                              resolution: resolution_id,
                              size: size,
                              priceType: price_type,
                              thumb: image_thumb,
                              dimension: dimension,
                              pixels: pixels
                            }, cart).appendTo($c_action);
        */
    //  } // del if
    };
    $('#dimension').text(dimension);
    $.each(res.prop.More, function(key, val){
      $('dl.dl-horizontal').append(
        '<dt class="fix-dt-width">'+key.toUpperCase()+'</dt>'+
        '<dd class="fix-dd-margin">: '+val+'</dd>'
        );
    });

    //$('.imgdetail').slideDown('fast');
    /*$('.imgdetail').animate({
          'top': "90px"
        }, 500);*/
    $('.imgdetail').velocity({top:"90px", opacity:1}, {duration:600, queue: false}, "easeInSine");
    //$('#_'+id+' #loading').removeClass('is-loading');
    
    $('.image-link').magnificPopup({
        type: 'image',
        mainClass: 'mfp-no-margins mfp-with-zoom',
        closeOnContentClick: true,
        closeBtnInside: true,
        zoom: {
          enabled: true, // By default it's false, so don't forget to enable it
          duration: 300, // duration of the effect, in milliseconds
          easing: 'ease-in-out'
        },
        image: {
          titleSrc: 'title'
        }
        /*
        callbacks: {
          elementParse: function(item) {
            alert(item.src);
          }
        }
        */
      });

    $('.collapsible').collapsible({
      accordion: true 
    });

    $('ul.tabs').tabs();

  }

  function downloadUrlRef(provider, size, resolution_id, image_code, license, price, urlPrev) {
    var username = $('#loguser a span').text();
    var collection_str = "";
    switch (provider){
      case "Fotosearch":
        collection_str = "sale/"+size+"/photosale_"+resolution_id+image_code;
        break;
      case "Depositphoto":
        collection_str = size+"/"+license.toLowerCase()+"/"+username;
        break;
      case "Ingimages":
        collection_str = "single/"+size+"/"+username+"/"+price;
        break;
      case "Fotolia":
        collection_str = "";
        break;
      case "Panthermedia":
        collection_str = size;
        break;
      case "Pixabay":
        collection_str = urlPrev.replace("_640", size);
        //collection_str = urlPrev;
        break;
    }
    return collection_str;
  }

  function getPrices(obj) {
    var item = '#_'+obj.find('span').text().replace('close','')+' a#preview';
    var preview_url = $(item).data('url');

    $.ajax({
      url: preview_url,
      type: 'POST',
      dataType: 'json'
    }).done(function(res){
    //$.getJSON(preview_url, function(res) {
      var price_type = res.resolutions[0].price_type;
      var price = res.resolutions[0].price;
      
      if (price_type==unescape("&euro;"))
        price = (price*fxRate).toFixed(0);
      
      currency = "$";
      //var show_val = (price_type == 'credits' ? price+'<sub>/cr</sub>' : '<sup>'+price_type+'</sup>'+price );
      var show_val = '<sup>'+currency+'</sup>'+price;

      //$(obj).find('p:last').text(show_val);
      obj.find('.price').html('<sub>Precios desde:</sub><br/>'+show_val);
      obj.parent().find('.btn-price').html(show_val).velocity({scale:1, opacity:1});
      //obj.parent().find('.btn-price').html(show_val).removeClass('hide');
    });
  }

//$(document).ready( function() {
  $(function(){

    //var $grid = $('.grid').isotope({

    initGrid();

    function initGrid(){
      $grid.isotope({
        /*layoutMode: 'fitRows',*/
        itemSelector: '.grid-item',
        masonry: {
          columnWidth:160,
          gutter:20
        },
        animationOptions: {
           queue: false
        },
        getSortData: {
          price: function(item){
            var p = $(item).find('.btn-price').remove('sub').remove('sup').text();
            return p;
          }
        }
         /*fitRows: {
          columnWidth: 160,
          gutter:30
        }*/
      });
    }

    $('#view-card').on("click", function(){
      $(this).toggleClass('active');
      $('#view-fit').toggleClass('active')
      grid_style = 'card';
      $('#load-more').remove();
      CleanGrid();
      //change_view(grid_style)
      LoadImages(prev_limit, true);
    });

    $('#view-fit').on("click", function(){
      $(this).toggleClass('active');
      $('#view-card').toggleClass('active');
      grid_style = 'autofit';
      $('#load-more').remove();
      CleanGrid();
      //change_view(grid_style);
      LoadImages(prev_limit, true);
    });


    $grid.on("click", "input[type=checkbox]", function(){
      var id = $( this ).prop('name');
      $('#_'+id).toggleClass("selected");
    });

    $grid.on("click", ".btn-price", function(){
        //$(this).parent().parent().parent().find('input[type=checkbox]').click();
        //$(this).velocity({scale:0, opacity:0}).html('<sup>$</sup>9999');
        var obj = this;
        $.Velocity.animate(obj, {scale:0, opacity:0}).then(function(){
          $(obj).html('<sup>$</sup>9999');
        });
    });

    $grid.on({
      mouseenter: function(){
          $(this).find('.fa-stack-2x').removeClass('fa-square-o').addClass('fa-square');
          $(this).find('.fa-stack-1x').addClass('fa-inverse');
      },

      mouseleave: function(){
          $(this).find('.fa-stack-2x').removeClass('fa-square').addClass('fa-square-o');
          $(this).find('.fa-stack-1x').removeClass('fa-inverse');        
      },

      click: function(){
          var preview_url = $(this).data('url'),
            image_code = $(this).data('img'),
            image_caption = $(this).data('caption'),
            provider = $(this).data('provider'),
            image_thumb = $(this).data('thumb');

          if ( "Fotosearch Depositphoto Panthermedia".search(provider)>=0 )
            var download_url = init.url_controller+
                    "/"+provider+"_Download/"+image_code+"/"
          else if (provider == "Ingimages")
                  var download_url = init.url_down_ref+
                    "/"+provider+"/"+image_code+"/"
                else
                  var download_url = "";

          $('#_'+image_code).find('#loading').addClass('is-loading');
          $('#mod-imagepreview').attr('src', ''); // clean the last image loaded
          $('div.preloader-wrapper').show();  
          $('#modal1 h4').text(image_code);

          $('dl.dl-horizontal').text('');
          $('ul#prices').text('');

          $.ajax({
            url: preview_url,
            type: 'POST',
            dataType: 'json',
            async: true
          }).done(function(res){ 
              imgPreview(download_url, provider, image_code, image_caption, image_thumb, res)
          });
      }

    }, "a#preview");

    $('#filters').on("click", function() {
      var filterValue = $(this).data('filter');
      //console.log($(this).data('filter'));
      $('#load-more').remove();
      $grid.isotope({filter: filterValue});
      $('#top-options').click();
      if (filterValue == '*'){
        $(this).data('filter','.selected');
        $(this).find('span').text('Set Filter ON');
      }
      else{
        $(this).data('filter','*');
        $(this).find('span').text('Set Filter OFF');
      }
    });

    $('#sort').on("click", function() {
      var elements = $grid.isotope('getItemElements');
      var price_array = [];
      $.each(elements, function(i,item){
        p = $(item).find('.btn-price').remove('sub').remove('sup').text();
        if (p != '')
          price_array.push(item)
      })

      $grid.isotope('updateSortData', price_array);
      $grid.isotope({ sortBy: 'price', sortAscending: true });
    });

    //$grid.on("click", "a#preview", function(){
    //}); 
      
/* ----- usado antes para "on click de a#preview"

        $.getJSON(preview_url, function(res) {
        var username = $('#loguser a span').text(),
          download_code = '',
          resolution_id = '',
          price_type = '',
          show_val = '',
          dimension = '',
          image_url = '',
          license = 'standard',
          size = '',
          price = 0;

        $('#mod-imagepreview').attr('src', res.url);
        $('.image-link').prop('href', res.url);
        $('<img>', {"src": res.url}).appendTo('.imgdetail');
        image_url = res.url;

        for (var i = 0; i < res.resolutions.length; i++) {
          $li = $('<li class="collection-item avatar"></li>').appendTo('ul#prices');

          $.each(res.resolutions[i], function(key, val){
            icolor = '';
            switch (key){
              case "name":
                resolution_id = val.substring(0,1);
                if ("US".search(resolution_id)>=0)
                  icolor = 'green'
                else if (resolution_id == "E"){
                    icolor = 'orange';
                    license = "Extended";
                  }
                $i_res = $('<i class="material-icons circle '+icolor+'">'+resolution_id+'</i>'
                          ).appendTo($li);
                $('<span class="title">'+val+'</span>').appendTo($li);
                break;

              case "price":
                if (price_type == 'credits')
                  show_val = val + ' ' + price_type
                else
                  show_val = price_type + ' ' + val;
                price = val;
                $('<a href="#" class="secondary-content">'+show_val+'</a>').appendTo($li);
                break;

              case "code":
                size = val;
                break;

              case "price_type":
                price_type = val;
                break;

              case "pixels":
                if (is_logged()){
                  switch (provider){
                    case "Fotosearch":
                      collection_str = download_url+"sale/"+size+"/photosale_"+resolution_id+image_code;
                      break;
                    case "Depositphoto":
                      collection_str = download_url+size+"/"+license+"/"+username;
                      break;
                    case "Ingimages":
                      collection_str = download_ref_url+"single/"+size+"/"+username+"/"+price;
                      break;
                    case "Fotolia":
                      collection_str = "";
                      break;
                    case "Panthermedia":
                      collection_str = download_url+size;
                      break;
                  }

                  $p_pixels = $('<p>'+val+'</p>').appendTo($li);

                  $a_cart = $('<a href="#"></a>').on("click", {
                              elem: collection_str,
                              imgcode: image_code,
                              provider: provider,
                              price: price,
                              resolution: resolution_id,
                              size: size,
                              priceType: price_type,
                              thumb: image_thumb,
                              dimension: dimension,
                              pixels: val
                            }, cart).appendTo($p_pixels);

                  $('<span class="new badge pink accent-2">Add to Cart</span>').appendTo($a_cart);
                }
                else
                  $('<p>'+val+'</p>').appendTo($li);
                break;

              case "dimension":
                dimension = val.replace(/'/g, "");
                $('<p>'+dimension+'</p>').appendTo($li);
                break;
            }
          });         
          
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
*/ 
      /*
      $('.open-popup').magnificPopup({
        items: {src: image_url},
          type: 'image'
        });
*/

    $('#top-options').click(function(e){
      e.preventDefault();

      $(this).addClass(function(index, currentClass){
        var addedClass;
        var navSize, navShow;
        if (currentClass === "active") {
          $(this).removeClass("active");
          navSize = navShow = "0";
        }
        else {
          addedClass = "active";
          navSize = "90px";
          navShow = "1";
        }
        $('#horizontal-nav').animate({
          'margin-top': navSize,
          'opacity': navShow
        }, 500);

        return addedClass
      })


    });

    $('#top-usercart').click(function(e){
      viewCart();
      e.preventDefault();
    });

    $('#login').click(function(e){
      login();
      e.preventDefault();
    });

    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal({dismissible: true});


    //$('.tooltipped').tooltip({delay: 50, position: "bottom"});

    $('#navform').submit(function(e){
      e.preventDefault(); 
      CleanGrid();
      LoadImages(0, false);
    
    });

    //$('.materialboxed').materialbox();
    /*$('.image-link').magnificPopup({
        type: 'image',
        mainClass: 'mfp-no-margins mfp-with-zoom',
        closeOnContentClick: true,
        closeBtnInside: false,
        zoom: {
          enabled: true, // By default it's false, so don't forget to enable it
        duration: 300, // duration of the effect, in milliseconds
          easing: 'ease-in-out'
        }
      });*/

    $('#form').submit(function(event)
    {
      // Get the url that the ajax form data is to be submitted to.
      var submit_url = $(this).attr('action');
      var success_url = init.url_controller; //"<?php echo site_url('getprovidersfull'); ?>";

      // Get the form data.
      var $form_inputs = $(this).find(':input');
      var form_data = {};
      $form_inputs.each(function() 
      {
        form_data[this.name] = $(this).val();
      });

      $.ajax({
        url: submit_url,
        type: 'POST',
        data: form_data,
        dataType: 'html'
      }).done(function(data){
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
      });
      event.preventDefault();

    });

    $('#top-images').click(function(){
      fbLogout();
    });
    
    $('.imgdetail-close').click(function(e){
      e.preventDefault();
      $('.imgdetail').velocity({top:"-800px", opacity:0}, {duration:600, queue: false}, "easeInSine");
      /*$('.imgdetail').animate({
          'top': "-800px"
        }, 500);*/
    //$('.imgdetail').slideUp('fast');
    });

    // Search class for focus
    $('.header-search-input').focus(
    function(){
        $(this).parent('div').addClass('header-search-wrapper-focus');
    }).blur(function(){
        $(this).parent('div').removeClass('header-search-wrapper-focus');
    });  

    if ( $('#keywords').val() !== "")
      submitform();

});
/*
$(window).load(function(){
  if ($('#keywords').val() != '')
      submitform();
});
*/
/*
$(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
          $('.static-banner').show();
          LoadImages(next_limit);
    }
});
*/
$(window).on("resize", function(){
  if ($(window).width() <= 580) 
      $('#imgheight-container').removeClass('imgheight');
    else
      $('#imgheight-container').addClass('imgheight')
});

// triggered after each item is loaded
function onProgress( imgLoad, image ) {
  // change class if the image is loaded or broken
  //$grid.isotope('layout');
  if ($( image.img ).parent().prop('id') == "preview")
    var $item = $( image.img ).parent().parent();
  else
    var $item = $( image.img ).parent();
  $item.removeClass('is-loading');
  if ( !image.isLoaded ) {
    $item.addClass('is-broken');
  }
  // update progress element
  //loadedImageCount++;
  //  console.log('count:'+loadedImageCount+' id: '+$item.parent().parent().prop('id'));
  //updateProgress( loadedImageCount );

  //$item.css('width', image.img.width+'px');
  //alert($item.css('width'));
  //alert(image.img.width);
}

function getRate(from, to) {
  var script = document.createElement('script');
  script.setAttribute('src', "https://query.yahooapis.com/v1/public/yql?q=select%20rate%2Cname%20from%20csv%20where%20url%3D'http%3A%2F%2Fdownload.finance.yahoo.com%2Fd%2Fquotes%3Fs%3D"+from+to+"%253DX%26f%3Dl1n'%20and%20columns%3D'rate%2Cname'&format=json&callback=parseExchangeRate");
  document.body.appendChild(script);
}
function parseExchangeRate(data) {
  var name = data.query.results.row.name;
  fxRate = parseFloat(data.query.results.row.rate, 10);
  //alert("Exchange rate " + name + " is " + rate);
}

function setLoginData(profile_data){
  $.ajax({
    url: init.url_validate, //"<?php echo site_url('login/validate_credentials'); ?>",
    type: 'POST',
    data: profile_data,
    dataType: 'html'
  }).done(function(data){
      // If the returned login value successul.
      if (data)
      {
        // Hide any error message that may be showing.
        $('#message').hide();
        $('#modal2').closeModal();
        //window.location = success_url;
        loginIcon(data, profile_data.email_address);
      }
      // Else the login credentials were invalid.
      else
        $('#message').show();
  });

}

function onSuccess(googleUser) {
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Full Name: ' + profile.getName());
  console.log('Given Name: ' + profile.getGivenName());
  console.log('Family Name: ' + profile.getFamilyName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail());

  profile_data = {
    auth_by: 'google',
    external: true,
    first_name: profile.getGivenName(),
    last_name: profile.getFamilyName(), 
    email_address: profile.getEmail(),
    username: profile.getEmail()
  };

  setLoginData(profile_data);

}

function onFailure(error) {
  console.log(error);
}

function renderButton() {
  gapi.signin2.render('my-signin2', {
    'scope': 'profile email',
    'width': 130,
    'height': 25,
    'longtitle': false,
    'theme': 'dark',
    'onsuccess': onSuccess,
    'onfailure': onFailure
  });
}

function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }

// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
  console.log('statusChangeCallback');
  console.log(response);
  // The response object is returned with a status field that lets the
  // app know the current login status of the person.
  // Full docs on the response object can be found in the documentation
  // for FB.getLoginStatus().
  if (response.status === 'connected') {
    // Logged into your app and Facebook.
    testAPI();
  } else if (response.status === 'not_authorized') {
    // The person is logged into Facebook, but not your app.
    document.getElementById('status').innerHTML = 'Please log ' +
      'into this app.';
  } else {
    // The person is not logged into Facebook, so we're not sure if
    // they are logged into this app or not.
    document.getElementById('status').innerHTML = 'Please log ' +
      'into Facebook.';
  }
}

// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.
function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}


window.fbAsyncInit = function() {
  FB.init({
    appId      : '1742929142619184',
    cookie     : true,  // enable cookies to allow the server to access the session
    xfbml      : true,
    version    : 'v2.6'
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  checkLoginState();

};

(function(d, s, id){
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "//connect.facebook.net/es_LA/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
 }(document, 'script', 'facebook-jssdk'));
 
  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', 'GET', {"fields" : "id, first_name, last_name, email"} ,function(response) {
      console.log('Successful login for: ' + response.name);
      console.log(response);
      //document.getElementById('status').innerHTML =
      //  'Email is, ' + response.email + '. Name is, ' + response.first_name +' '+response.last_name+ '!';
      var profile_data = {
        auth_by: 'facebook',
        external: true,
        first_name: response.first_name,
        last_name: response.last_name, 
        email_address: response.email,
        username: response.email
      };

      setLoginData(profile_data);

    });
  }

  function fbLogout(){
    FB.logout(function(response) {
      console.log(response);
      //document.getElementById('status').innerHTML =
      //  'Logged out, bye ' + response.name + '!';
  });
  }
