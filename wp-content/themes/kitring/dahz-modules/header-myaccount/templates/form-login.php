<?php

$wrap_attr = array();

$wrap_classes[] = 'de-account-content--dropdown';

$wrap_attr['class'] = $wrap_classes;

?>
<div <?php dahz_framework_set_attributes( $wrap_attr ); ?>>

	<?php do_action( 'dahz_framework_woo_before_login' ); ?>

	<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
		<ul class="de-account-content__tab uk-tab uk-child-width-expand" data-uk-tab>
			<li class="uk-active">
				<a href="<?php echo esc_url( sprintf( '#sign_in_%s', $uniqid ) ); ?>" onClick="return false" aria-selected="true" role="tab"><h5><?php esc_html_e( 'Sign In', 'kitring' ); ?></h5></a>
			</li>
			<li>
				<a href="<?php echo esc_url( sprintf( '#register_%s', $uniqid ) ); ?>" onClick="return false"><h5><?php esc_html_e( 'Register', 'kitring' ); ?></h5></a>
			</li>
		</ul>
		<ul class="uk-switcher de-account-content__form">
			<li id="<?php echo esc_attr( sprintf( 'sign_in_%s', $uniqid ) ); ?>" class="uk-active">
				<form method="post" class="login">
					<?php do_action( 'woocommerce_login_form_start' ); ?>
					<div class="woocommerce-FormRow woocommerce-FormRow--wide uk-margin">
						<label class="uk-form-label" for="username"><?php esc_html_e( 'Username or email address', 'kitring' ); ?><span class="required">*</span></label>
						<div class="uk-form-controls">
							<input type="text" class="woocommerce-Input woocommerce-Input--text input-text uk-input" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
						</div>
					</div>
					<div class="woocommerce-FormRow woocommerce-FormRow--wide uk-margin">
						<label class="uk-form-label" for="password"><?php esc_html_e( 'Password', 'kitring' ); ?><span class="required">*</span></label>
						<div class="uk-form-controls">
							<input class="woocommerce-Input woocommerce-Input--text input-text uk-input" type="password" name="password" id="password" />
						</div>
					</div>
					<div class="woocommerce-FormRow woocommerce-FormRow--wide uk-margin">
						<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce', false ); ?>
						<div class="uk-flex uk-flex-between uk-margin">
							<label class="uk-form-label" for="rememberme" class="inline rememberme"><input class="woocommerce-Input woocommerce-Input--checkbox uk-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /><?php esc_html_e( 'Remember me', 'kitring' ); ?></label>
							<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="lostpassword"><?php esc_html_e( 'Lost your password?', 'kitring' ); ?></a>
						</div>
						<button type="submit" class="woocommerce-Button uk-button uk-button-default uk-width-1-1" name="login" value="<?php esc_attr_e( 'Log In', 'kitring' ); ?>"><?php esc_attr_e( 'Log In', 'kitring' ); ?></button>
					</div>
					<?php do_action( 'woocommerce_login_form' ); ?>
					<?php do_action( 'woocommerce_login_form_end' ); ?>
				</form>
			</li>
			<li id="<?php echo esc_attr( sprintf( 'register_%s', $uniqid ) ); ?>">
				<form method="post" class="register">
					<?php do_action( 'woocommerce_register_form_start' ); ?>
					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
					<div class="woocommerce-FormRow woocommerce-FormRow--wide uk-margin">
						<label class="uk-form-label" for="reg_username"><?php esc_html_e( 'Username', 'kitring' ); ?><span class="required">*</span></label>
						<div class="uk-form-controls">
							<input type="text" class="woocommerce-Input woocommerce-Input--text input-text uk-input" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
						</div>
					</div>
					<?php endif; ?>
					<div class="woocommerce-FormRow woocommerce-FormRow--wide uk-margin">
						<label class="uk-form-label" for="reg_email"><?php esc_html_e( 'Email address', 'kitring' ); ?><span class="required">*</span></label>
						<div class="uk-form-controls">
							<input type="email" class="woocommerce-Input woocommerce-Input--text input-text uk-input" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
						</div>
					</div>
					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
					<div class="woocommerce-FormRow woocommerce-FormRow--wide uk-margin">
						<label class="uk-form-label" for="reg_password"><?php esc_html_e( 'Password', 'kitring' ); ?><span class="required">*</span></label>
						<input type="password" class="woocommerce-Input woocommerce-Input--text input-text uk-input" name="password" id="reg_password" />
					</div>
					<?php endif; ?>
					<!-- Spam Trap -->
					<div style="<?php echo esc_attr( sprintf( '%s: -999em; position: absolute;', ( is_rtl() ) ? 'right' : 'left' ) ); ?>">
						<label for="trap"><?php esc_html_e( 'Anti-spam', 'kitring' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" />
					</div>
					<?php do_action( 'woocommerce_register_form' ); ?>
					<div class="woocomerce-FormRow form-row uk-margin-medium-top">
						<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce', false ); ?>
						<button type="submit" class="woocommerce-Button uk-button uk-button-default uk-width-1-1" name="register" value="<?php esc_attr_e( 'Register', 'kitring' ); ?>"><?php esc_attr_e( 'Register', 'kitring' ); ?></button>
					</div>
					<?php do_action( 'register_form' ); ?>
					<?php do_action( 'woocommerce_register_form_end' ); ?>
				</form>
			</li>
		</ul>
	<?php else : ?>
		<h5><?php esc_html_e( 'Sign In', 'kitring' ); ?></h5>
		<form method="post" class="login">
			<?php do_action( 'woocommerce_login_form_start' ); ?>
			<div class="woocommerce-FormRow woocommerce-FormRow--wide uk-margin">
				<label class="uk-form-label" for="username"><?php esc_html_e( 'Username or email address', 'kitring' ); ?><span class="required">*</span></label>
				<div class="uk-form-controls">
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text uk-input" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
				</div>
			</div>
			<div class="woocommerce-FormRow woocommerce-FormRow--wide uk-margin">
				<label class="uk-form-label" for="password"><?php esc_html_e( 'Password', 'kitring' ); ?><span class="required">*</span></label>
				<div class="uk-form-controls">
					<input class="woocommerce-Input woocommerce-Input--text input-text uk-input" type="password" name="password" id="password" />
				</div>
			</div>
			<div class="woocommerce-FormRow woocommerce-FormRow--wide uk-margin">
				<button type="submit" class="woocommerce-Button uk-button uk-button-default uk-width-1-1" name="login" value="<?php esc_attr_e( 'Log In', 'kitring' ); ?>"><?php esc_attr_e( 'Log In', 'kitring' ); ?></button>
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce', false ); ?>
				<div class="uk-flex uk-flex-between uk-margin">
					<label class="uk-form-label" for="rememberme" class="inline rememberme"><input class="woocommerce-Input woocommerce-Input--checkbox uk-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /><?php esc_html_e( 'Remember me', 'kitring' ); ?></label>
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="lostpassword"><?php esc_html_e( 'Lost your password?', 'kitring' ); ?></a>
				</div>
			</div>
			<?php do_action( 'woocommerce_login_form' ); ?>
			<?php do_action( 'woocommerce_login_form_end' ); ?>
		</form>
	<?php endif; ?>
</div>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
