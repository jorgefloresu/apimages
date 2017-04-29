
<div id="login-page" class="row">
<div class="col s12 z-depth-4 card-panel">

			<?php echo form_open('login/forgot_pass_phpmailer', 'id="form" class="signup-form"'); ?>
                <input id="username" name="username" type="hidden" value="<?php echo $logged; ?>">
		        <div class="row">
			        <div class="input-field col s12 center">
			            <h4>Recover Password</h4>
			            <p class="center">Your password will be sent by email</p>
			        </div>
		        </div>
				<div class="row margin">
					<div class="input-field col s12">
						<i class="mdi-communication-email prefix"></i>
						<input type="text" id="email_address" name="email_address" class="validate" required="" aria-required="true">
						<label for="email_address">Email address</label>
					</div>
    			</div>
    			<div class="row">
    				<div class="input-field col s12">
						<button class="btn waves-effect waves-light col s12 pink accent-2" type="submit">Get password
						</button>
					</div>
                    <div id="message" style="display:none; color:red">
                        <p class="error_msg center medium-small">Error sending email</p>
                    </div>
				</div>
				<?php echo form_close(); ?>
				<?php echo validation_errors('<p class="error">'); ?>
</div>
</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   	<script src="<?php echo base_url("materialize/js/materialize.js"); ?>"></script>
	<script src="<?php echo base_url("js/perfect-scrollbar.min.js"); ?>"></script>
    <script src="<?php echo base_url("js/jquery.validate.js"); ?>"></script>
   	<script src="<?php echo base_url("js/plugins.js"); ?>"></script>

<script type="text/javascript">

    $('#form').submit(function(event){
        event.preventDefault();
        // Get the url that the ajax form data is to be submitted to.
        var submit_url = $(this).attr('action');
        var success_url = "<?php echo site_url('pages/view'); ?>";

        // Get the form data.
        var $form_inputs = $(this).find(':input');
        var form_data = {};
        $form_inputs.each(function() 
        {
            form_data[this.name] = $(this).val();
        });

        if (form_data['email_address']!=='')
            $.ajax({
                url: submit_url,
                type: 'POST',
                data: form_data
            }).done(function(data){
                    if (data){
                        // Hide any error message that may be showing.
                        $('#message').hide();
                        window.location = success_url;
                        //$('#message p').text(data);
                        //$('#message').show();
                    }
                    else{
                        $('#message').show();
                    }
            });

    });

</script>