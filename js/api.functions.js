(function ( $ ){

    $.Shop = function( element ) {
      this.$element = $( element ); // top-level element
      this.init();
    };

    $.Shop.prototype = {
      init: function() {
        // initializes properties and methods
        this.$formCart = $("#shopping-cart");
        this.$tableCart = $(".shopping-cart");
        this.$tableCartBody = this.$tableCart.find( "tbody" );
        this.storage = Storages.localStorage;
        this.cartName = "CI-cart";
        this.total = "total";
        this.$emptyCartBtn = $("#empty-cart");
        this.createCart();
        this.displayCart();
        this.emptyCart();
        this.deleteItem();
      },

      createCart: function() {
        if( this.storage.get( this.cartName ) == null ) {        
          var cart = [];        
          this.storage.set( this.cartName, cart);
          this.storage.set( this.total, "0" );
        }
      },

      displayCart: function() {
        if( this.$formCart.length ) {
          var cart = this.storage.get(this.cartName);
          if (cart.length == 0)
            this.$tableCartBody.html("");
          else {
            for (var i=0; i<cart.length; i++){
              var item = cart[i];
              var html = "<tr><td>" + item.id + "</td><td>" + item.desc + "</td>";
              html += "<td>" + item.size + "</td><td>" + item.license + "</td>";
              html += "<td>" + item.price + "</td>";
              html += "<td class='delete'><a href='' data-item='" + item.id + "'>&times;</a></td></tr>";
              this.$tableCartBody.html( $tableCartBody.html() + html );
            }
          }
        }
      },

      addToCart: function(form){
        var id = $("#mediaid").val();
        var size = $("#media-sizes").val().split('-')[0];
        var license = $("input[name=license]:checked").val();
        var price = $("#media-sizes").val().split('-')[1];
        var cart = this.storage.get(this.cartName);
        cart.push({'id':id, 'desc':'description', 'size':size, 'license':license, 'price':price});
        this.storage.set(this.cartName, cart);

        // setup.config.cartCount.toggle();
        // var count = storage.get('media');
      },

      deleteItem: function() {
        var self = this;
        var cart = this.storage.get(this.cartName);
        $(document).on("click", ".delete a", function(event){
          event.preventDefault();
          for (var i=0; i<cart.length; i++) {
            var item = cart[i];
            var selected = $(this).data('item');
            if (item.id == selected) {
              cart.splice(i,1);
              self.storage.set(self.cartName, cart);
            }
          }
        });
      },

      emptyCart: function() {
        var self = this;
        this.$emptyCartBtn.on("click", function() {
          self.storage.removeAll();
        });
      }
      
    };

}(jQuery));


var Api = (function(){
  
  var setup = {
      init: function(settings){
        setup.config = {
          // Search controls
          searchForm: $("#search"),
          resultSearch: $("#result"),             // Contenedor del JSON de la respuesta de search
          fullUrlSearch: $("#url"),               // Contenedor del url que se ejecuta del search

          mediaForm: $("#media"),
          resultMedia: $("#resultMedia"),         // Contenedor del JSON de la respuesta de getMediaData
          fullUrlMedia: $("#urlMedia"),           // Contenedor del url que se ejecuta del getMediaData
          mediaSizes: $("#media-sizes"),
          mediaPrice: $("#mediaPrice"),

          loginForm: $("#loginform"),
          resultLogin: $("#resultlogin"),         // Contenedor del JSON de la respuesta de login
          sessionId: $("input[name=sessionid]"),  // Muestra el ID de la session
          sessionIdText: $("#sessionidtext"),
          loginBtn: $("#loginform button"),       // Contenedor del boton login
          logged: $("#logged"),

          subAccountForm: $("#subaccountform"),
          subAccounts: $("#subaccounts"),
          resultSubaccounts: $("#resultsubaccounts"),
          subAccountId: $("input[name=subaccountid]"),
          subAccountIdText: $("#subAccountIdText"),

          subscriptionsForm: $("#subscriptionsForm"),
          resultSubscriptions: $("#resultSubscriptions"),
          subsPeriod: $("#subsPeriod"),
          subsCount: $("#subsCount"),
          subsBtn: $("#subsBtn"),
          subsPlans: $("#subsPlans"),

          cart: $("#cart"),
          saveToCart: $("button[name=savetocart]"),
          cartCount: $("#cartCount"),

          paginator: $("#paginator"),             // Contenedor del HTML del paginador
          progress: $(".progress"),
          error: $("#error")
        };

        $.extend(setup.config, settings);
      }
  }

  // Asigna el contenido a los contenedores relacionados con el search
  var searchFields = function(data) {
      setup.config.resultSearch.html(JSON.stringify(data.source, null, 3));
      setup.config.fullUrlSearch.html(data.fullurl);
      setup.config.paginator.html(data.pags);
  }

  // Asigna el contenido a los contenedores relacionados con el getMediaData
  var mediaFields = function(data) {
      setup.config.resultMedia.html(JSON.stringify(data.source, null, 3));
      setup.config.fullUrlMedia.html(data.fullurl);
      setup.config.mediaSizes.html(data.sizes);
      var price = setup.config.mediaSizes.val().split('-')[1];
      setup.config.mediaPrice.val(price);
      $("select").material_select();
      Materialize.updateTextFields();
  }

  var mediaSizesChange = function() {
      var size = setup.config.mediaSizes.val();
      var price = size.split('-')[1];
      setup.config.mediaPrice.val(price);
      Materialize.updateTextFields();

  }

  // Asigna el contenido a los contenedores relacionados con el login
  var loginFields = function(data) {
      setup.config.loginForm.attr('action', data.action);
      setup.config.resultLogin.html(JSON.stringify(data.source, null, 3));
      var _sessionid = (data.sessionid ? data.sessionid : String.fromCharCode(160));
      setup.config.sessionIdText.text(_sessionid);
      setup.config.sessionId.val(data.sessionid);
      setup.config.loginBtn.html(data.loglabel);
      setup.config.logged.toggle();
  }

  var subaccountsFields = function(data) {
      setup.config.resultSubaccounts.html(JSON.stringify(data.source, null, 3));
      setup.config.subAccounts.html(data.subaccounts);
      setup.config.subAccountId.val(setup.config.subAccounts.val());
      setup.config.subAccountIdText.text(setup.config.subAccounts.val());
      $("select").material_select(); 
  }

  var subAccountChange = function() {
      setup.config.subAccountId.val($(this).val());
      setup.config.subAccountIdText.text($(this).val());
      setup.config.cart.forSubAccount($(this).val());

  }

  var subscriptionsFields = function(data) {
      setup.config.resultSubscriptions.html(JSON.stringify(data.source, null, 3));
      setup.config.subsPeriod.html(data.subsPeriod);
      setup.config.subsCount.html(data.subsCount);
      setup.config.subsPlans.html(data.subsPlans);
      $("select").material_select(); 
  }

  var cartFields = function(storage) {
      //setup.config.subAccountId.val(data.subAccountId);
      var media = this.storage.get('media');
      alert(media.id);
  }

  var loginMethod = function(event) {
      event.preventDefault();
      var formData = $(this).prepareData();
      $.submitForm(formData, loginFields);
  }

  var mainMethod = function(event) {
    event.preventDefault();
    setup.config.progress.toggle();
    var formData = $(this).prepareData();
    $(formData).getDataProvider()
               .then(event.data.fillOut)
               .done(isGood)
               .fail(notGood);
  }

  var notGood = function(res){
    //alert("not good");
    console.log(res);
    setup.config.error.html(res.responseText);
    setup.config.error.modal('open');
    setup.config.progress.toggle();
  }

  var isGood = function(res) {
    setup.config.progress.toggle();

  }

  return { 
     setup: setup,
     searchFields: searchFields, 
     mediaFields: mediaFields,
     mediaSizesChange: mediaSizesChange,
     loginFields: loginFields,
     subaccountsFields: subaccountsFields,
     subAccountChange: subAccountChange,
     subscriptionsFields: subscriptionsFields,
     cartFields: cartFields,
     notGood: notGood,
     isGood: isGood,
     mainMethod: mainMethod,
     loginMethod: loginMethod 
   }

})();

(function ( $ ) {

    // Guarda el url de cada link visitado
    var cache = {};                       

    // Ejecuta la llamada al servidor para obtener el set de datos    
    $.fn.getDataProvider = function() {
        var url = this[0].url;
        var formData = this[0].inputs;
        if ( formData )
          url += '?' + $.param(formData);

        if ( !cache[url] ) {
          cache[url] =  $.Deferred(function(defer){
                          $.getJSON(url,formData).then(defer.resolve, defer.reject);
                        }).promise();
        }
        return cache[url];
    }


    // Organiza el action y los inputs del form en un solo array
    $.fn.prepareData = function() {
        var form = {};
        if (this.is("form")) {
          form.url = $(this).attr("action");
          form.inputs = $(this).formInputs();  
        }
        else {
          form.url = $(this).attr('href');
          form.inputs = null;
        }
        return form;  
    }

    // Organiza los inputs del form en un solo array
    $.fn.formInputs = function(){
        var $form_inputs = $(this).find(':input');
        var form_data = {};
        $form_inputs.each(function() {
          form_data[this.name] = $(this).val();
        });
        return form_data;
    }
    
    // Submit the form data using Ajax  
    $.submitForm = function(form, populate){
        Api.setup.config.progress.toggle();
        $.ajax({
            url: form.url, 
            data: form.inputs,
            method: "POST",
            dataType: "json"          
        }).done(function(res){
          populate(res);
          Api.setup.config.progress.toggle();
        }).fail(Api.notGood);
    }

    $.fn.forSubAccount = function(subAccountId) {        
        $(this).attr('href', function(){
          return $(this).attr('href').split('?')[0] + '?subaccountid=' + subAccountId;
        });
    }


}(jQuery))

