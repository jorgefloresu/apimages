<div id="modal2" class="modal">
    <div class="modal-content">
    <div class="row">
    <div class="col s12">         
    <?php echo form_open('login/validate_credentials', 'id="form" class="login-form" novalidate'); ?>
        <div class="input-field col s12 center">
          <h4>Sign In</h4>
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
      <div class="row margin">
        <div class="input-field col s12">
          <button class="btn waves-effect waves-light col s12 pink accent-2" type="submit">Sign in
          </button>
        </div>
      </div>
      <div class="row margin">
        <div class="input-field col s6">
        <!-- <div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"></div>-->
          <fb:login-button scope="public_profile,email" size="large" onlogin="checkLoginState();"></fb:login-button>
        </div>
        <div id="my-signin2" class="input-field col s6"></div>
        <div id="message" style="display:none; color:red">
          <p class="error_msg center medium-small">Your submitted login details are incorrect.</p>
        </div>
      </div>
      <div class="row margin">
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
    </div>
</div>