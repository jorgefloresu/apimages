
<div id="login-page" class="row">
<div class="col s12 z-depth-4 card-panel">

			<?php echo form_open('login/create_member', 'id="form" class="signup-form"'); ?>
		        <div class="row">
			        <div class="input-field col s12 center">
			            <h4>Register</h4>
			            <p class="center">Join to our community now !</p>
			        </div>
		        </div>
				<div class="row margin">
					<div class="input-field col s6">
						<i class="material-icons prefix">account_circle</i>
						<input type="text" id="first_name" name="first_name" class="validate" required="" aria-required="true">
						<label for="first_name">First Name</label>
					</div>
					<div class="input-field col s6">
						<i class="material-icons prefix">account_circle</i>
						<input type="text" id="last_name" name="last_name" class="validate" required="" aria-required="true">
						<label for="last_name">Last Name</label>
					</div>
     			</div>
				<div class="row margin">
					<div class="input-field col s12">
						<i class="mdi-social-person-outline prefix"></i>
						<input type="text" id="username" name="username" class="validate" required="" aria-required="true">
						<label for="username">User Name</label>
					</div>
					<div class="input-field col s12">
						<i class="mdi-communication-email prefix"></i>
						<input type="text" id="email_address" name="email_address" class="validate" required="" aria-required="true">
						<label for="email_address">Email address</label>
					</div>
    			</div>
				<div class="row margin">
					<div class="input-field col s6">
						<i class="mdi-action-lock-outline prefix"></i>
						<input type="password" name="password" id="password" class="validate" required="" aria-required="true">
						<label for="password">Password</label>
					</div>
					<div class="input-field col s6">
						<i class="mdi-action-lock-outline prefix"></i>
						<input type="password" name="password2" id="password2" class="validate" required="" aria-required="true">
						<label for="password2">Password Confirmation</label>
					</div>
    			</div>
    			<div class="row">
    				<div class="input-field col s12">
						<button class="btn waves-effect waves-light col s12 pink accent-2" type="submit">Create Account
						</button>
					</div>
					<div class="input-field col s12">
            			<p class="margin center medium-small sign-up">Already have an account? 
            				<?php echo anchor('login', 'Login'); ?></p>
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
$.validator.setDefaults({
    errorClass: 'invalid',
    validClass: "valid",
    errorPlacement: function (error, element) {
        $(element)
            .closest("form")
            .find("label[for='" + element.attr("id") + "']")
            .attr('data-error', error.text());
    },
    submitHandler: function (form) {
        form.submit();
    }
});

$("#form").validate({
    rules: {
        password: {
            minlength: 4
        }
    }
});
</script>