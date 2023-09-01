<?php

 ?>
<?php if( $is_signed_in ) :?>
	<div class="de-account-content de-account-content--<?php echo esc_attr( $myaccount_content_style ); ?>">
		<div class="de-account-content--inner">
			<a href="#" class="ds-account-content--close de-account-content--close signed-in"><i class="df-cancel"></i></a>
			<ul>
				<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
					<li class="<?php echo esc_attr( wc_get_account_menu_item_classes( $endpoint ) );?>">
						<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
					</li>
				<?php endforeach;?>
			</ul>
		</div>
	</div>
<?php else :
	dahz_framework_get_template(
		"form-login.php", 
		array(  
			'myaccount_content_style'	=> $myaccount_content_style,
			'myaccount_register'		=> $myaccount_register,
			'uniqid'					=> $uniqid
		), 
		'dahz-modules/header-myaccount/templates/' 
	);

endif;

?>