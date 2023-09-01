<h1><?php esc_html_e( 'Setup Kitring Child Theme', 'kitring' )?></h1>

<p>
	<?php esc_html_e( 'If you are going to make changes to the theme source code please use a ', 'kitring' )?>
	<a href="https://codex.wordpress.org/Child_Themes" target="_blank">
		<?php esc_html_e( 'Child Theme', 'kitring' )?>
	</a>
	<?php esc_html_e( 'rather than modifying the main theme HTML/CSS/PHP code. This allows the parent theme to receive updates without overwriting your source code changes. Use the form below to create and activate the Child Theme.', 'kitring' )?>
</p>

<?php if(!isset($_REQUEST['child_theme_name'])){ ?>
<p class="lead"><?php esc_html_e( 'If you not sure what a Child Theme is just click the "Skip this step" button.', 'kitring' )?></p>
<?php } ?>

<?php
	// Create Child Theme
	if( isset( $_REQUEST['child_theme_name'] ) && current_user_can( 'manage_options' ) ){
		echo apply_filters( 'dahz_framework_make_child_theme', $_this->dahz_framework_make_child_theme( esc_html( $_REQUEST['child_theme_name'] ) ) ); 
	}
	$theme = get_option('kitring_child_theme') ? wp_get_theme( get_option('kitring_child_theme') )->Name : 'Kitring Child';
 ?>

<?php if( !isset( $_REQUEST['child_theme_name'] ) ){ ?>

<form action="<?php $_PHP_SELF ?>" method="POST">
	<div class="child-theme-input">
		<label><?php esc_html_e( 'Child Theme Title', 'kitring' )?></label>
		<input type="text" name="child_theme_name" value="<?php echo esc_attr( $theme ); ?>" />
	</div>
<p class="envato-setup-actions step">
	<button type="submit" id= type="submit"  class="button button-primary button-next button-next">
		<?php esc_html_e( 'Create and Use Child Theme', 'kitring' ); ?>
	</button>
	<a href="<?php echo esc_url( $_this->get_next_step_link() ); ?>" class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'kitring' ); ?></a>
</p>
</form>
<?php } else { ?>
<p class="envato-setup-actions step">
	<a href="<?php echo esc_url( $_this->get_next_step_link() ); ?>" class="button button-large button-next"><?php esc_html_e( 'Continue', 'kitring' ); ?></a>
</p>
<?php } ?>