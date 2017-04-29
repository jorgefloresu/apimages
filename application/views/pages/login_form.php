
<div id="login-page" class="row">
<div class="col s12 z-depth-4 card-panel">

			<?php echo form_open('login/validate_credentials', 'id="form" class="login-form" novalidate'); ?>
		        <div class="row">
			        <div class="input-field col s12 center">
			            <img src="<?php echo base_url('images/login-logo.png'); ?>" alt="" class="circle responsive-img valign profile-image-login">
			            <p class="center login-form-text">Please sign in</p>
			        </div>
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
					<div class="input-field col s12 m12 l12 login-text">
				      	<input type="checkbox" id="rememberMe">
				      	<label for="rememberMe">Remember Me</label>
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
						<p class="margin right-align medium-small"><?php echo anchor('login/forgot_pass', 'Forgot Password'); ?></p>
					</div>
				</div>
			<?php echo form_close(); ?>


</div>
</div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   	<script src="<?php echo base_url("materialize/js/materialize.js"); ?>"></script>
   	<script src="<?php echo base_url("js/plugins.js"); ?>"></script>

<script type="text/javascript">

	$('form').submit(function(event)
	{
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

		$.ajax(
		{
			url: submit_url,
			type: 'POST',
			data: form_data,
			success:function(data)
			{
				// If the returned login value successul.
				if (data)
				{
					// Hide any error message that may be showing.
					$('#message').hide();
					window.location = success_url;
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


</script>   	