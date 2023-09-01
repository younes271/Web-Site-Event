<?php if ( $is_signed_in ) : ?>
	<ul <?php dahz_framework_set_attributes(
		array(
			'class'	=> array( 'uk-nav uk-navbar-dropdown-nav' )
		),
		'dropdown_start_level'
	);?>>
		<?php foreach( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="sub-menu-item <?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a class="de-quickview__button" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php else : ?>
	<div class="uk-card uk-card-body uk-card-default">
		<div class="uk-drop-grid uk-child-width-1-1" data-uk-grid>
			<?php dahz_framework_get_template(
				"form-login.php",
				array(
					'myaccount_content_style'	=> $myaccount_content_style,
					'myaccount_register'		=> $myaccount_register,
					'uniqid'					=> $uniqid
				),
				'dahz-modules/header-myaccount/templates/'
			);?>
		</div>
	</div>
<?php endif; ?>
