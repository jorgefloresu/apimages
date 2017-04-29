<div id="modal4" class="modal">
    <div class="modal-content">
    <div class="row">
    <div class="col s12">         

    <?php echo form_open('order/payment', 'id="myCCForm" class="login-form" novalidate'); ?>
            <input id="token" name="token" type="hidden" value="TokenDePrueba">
            <input id="itemId" name="itemId" type="hidden" value="">
            <input id="orderId" name="orderId" type="hidden" value="">
            <input id="totalId" name="totalId" type="hidden" value="">
            <input id="orderNumber" name="orderNumber" type="hidden" value="">
            <input id="imageCode" name="imageCode" type="hidden" value="">
            <input id="username" name="username" type="hidden" value="">
            <div class="input-field col s12 center">
              <p>Credit Card details</p>
            </div>
            <div class="row margin">
                <div class="col s12">
                    <!--<i class="mdi-social-person-outline prefix"></i>-->
                    <label>Card Number</label>
                    <input type="text" id="ccNo" size="25" value="" class="validate flat-field" required="" aria-required="true" autocomplete="off">
                </div>
            </div>
            <div class="row margin">
                <div class="col s12">
                    <label>EXPIRATION DATE</label>
                </div>
            </div>     
            <div class="row margin">
               <div class="col s3">
                    <!--<i class="mdi-action-lock-outline prefix"></i>
                    <input type="text" id="expMonth" size="2" class="validate" required="" aria-required="true">
                    <label for="expMonth">Month (MM)</label>-->
                    <label>Month</label>
                    <select class="browser-default" id="expMonth">
                        <option value="" disabled selected>MM</option>
                        <?php for ($i=1; $i < 13 ; $i++) {
                            $val = str_pad($i, 2, "0", STR_PAD_LEFT); 
                            echo '<option value="'.$val.'">'.$val.'</option>';
                        }; ?>
                    </select>
                </div>
                <div class="col s9">
                    <!--<i class="mdi-action-lock-outline prefix"></i>
                    <input type="text" id="expYear" size="2" class="validate" required="" aria-required="true">
                    <label for="expYear">Year (YYYY)</label>-->
                    <label>Year</label>
                    <select class="browser-default" id="expYear">
                        <option value="" disabled selected>YYYY</option>
                        <?php for ($i=2016; $i < 2026 ; $i++) { 
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }; ?>
                    </select>
                </div>
            </div>
            <div class="row margin">
                <div class="col s6">
                    <!--<i class="mdi-social-person-outline prefix"></i>-->
                    <label>CVC</label>
                    <input type="text" id="cvv" size="4" value="" class="validate flat-field" required="" aria-required="true" autocomplete="off">
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <button class="btn waves-effect waves-light col s12 pink accent-2" type="submit">Submit Payment
                    </button>
                </div>
                <div id="message">
                    <p class="error_msg center medium-small green-text hide">Your submitted credit card details are incorrect.</p>
                </div>
            </div>

    <?php echo form_close(); ?>
    </div>
    </div>
    </div>
</div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>

        <script type="text/javascript">

            function doPayment(){

                var form_data = {
                    token: $('#token').val(),
                    orderId: $('#orderId').val(),
                    totalId: $('#totalId').val(),
                    orderNumber: $('#orderNumber').val(),
                    imageCode: $('#imageCode').val(),
                    username: $('#username').val()
                };
                var myForm = $('#myCCForm').prop('action');
                var itemId = '#i' + $('#itemId').val() + ' #dlink';
                $.ajax({
                    url: myForm,
                    type: 'POST',
                    data: form_data,
                    dataType: 'json'
                }).done(function(data){
                    if (data.response.responseCode == 'APPROVED'){
                        $('#modal4').closeModal();
                        $(itemId).removeClass('hide');
                    }
                    else
                        alert('error:'+data);
                });
            }

            var AjaxsuccessCallback = function(datatoken) {
                var form_data = {
                    token: datatoken.response.token.token,
                    orderId: $('#orderId').val(),
                    totalId: Number($('#totalId').val()).toFixed(2),
                    orderNumber: $('#orderNumber').val(),
                    imageCode: $('#imageCode').val(),
                    username: $('#username').val()
                };
                var myForm = $('#myCCForm').prop('action');
                var itemId = '#i' + $('#itemId').val() + ' #dlink';
                $('#message p').removeClass('red-text');
                $('#message p').addClass('green-text');
                $('#message p').text('Verificando tarjeta...');
                $('#message p').removeClass('hide');
                $.ajax({
                    url: myForm,
                    type: 'POST',
                    data: form_data,
                    dataType: 'json'
                }).done(function(data){
                    if (data.response.responseCode == 'APPROVED'){
                        $('#modal4').closeModal();
                        $(itemId).removeClass('hide');
                        $('#message p').addClass('hide');
                    }
                }).fail(function(data){
                    $('#message p').text('Su tarjeta fue rechazada. Intente con otra');
                    $('#message p').removeClass('green-text');
                    $('#message p').addClass('red-text');
               });
            }

            // Called when token created successfully.
            var successCallback = function(data) {
                var myForm = document.getElementById('myCCForm');
                // Set the token as the value for the token input
                myForm.token.value = data.response.token.token;
                // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
                myForm.submit();
            };
            // Called when token creation fails.
            var errorCallback = function(data) {
                if (data.errorCode === 200) {
                    tokenRequest();
                } else {
                    alert(data.errorMsg);
                }
            };
            var tokenRequest = function() {
                // Setup token request arguments
                var args = {
                    sellerId: "901331385",
                    publishableKey: "9D266415-16A9-49D0-AD84-AC8A1A735EB2",
                    ccNo: $("#ccNo").val(),
                    cvv: $("#cvv").val(),
                    expMonth: $("#expMonth").val(),
                    expYear: $("#expYear").val()
                };
                //doPayment();
                // Make the token request
                TCO.requestToken(AjaxsuccessCallback, errorCallback, args);
            };
            $(function() {
                // Pull in the public encryption key for our environment
                TCO.loadPubKey('sandbox');
                $("#myCCForm").submit(function(e) {
                    // Call our token request function
                    tokenRequest();
                    // Prevent form from submitting
                    return false;
                });
            });

        </script>
</body>
</html>