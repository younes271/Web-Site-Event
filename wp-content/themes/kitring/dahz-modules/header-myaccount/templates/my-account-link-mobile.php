<?php

?>
<ul class="uk-nav-default uk-nav-parent-icon" data-uk-nav="multiple:false;">
	<li class="uk-parent">
		<a aria-label="<?php esc_attr_e( 'My Account', 'kitring' );?>" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" class="header-mobile-menu__elements--link-parent uk-flex uk-flex-middle" title="<?php esc_attr_e( 'My Account', 'kitring' ); ?>">
			<?php echo apply_filters( 'dahz_framework_header_my_account_link', $nav_text );?>
		</a>
		<?php if( $is_signed_in ):?>
			<ul class="uk-nav-sub">
			<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
				<li class="<?php echo esc_attr( wc_get_account_menu_item_classes( $endpoint ) );?>">
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
				</li>
			<?php endforeach;?>
		<?php endif;?>
	</li>
</ul>

