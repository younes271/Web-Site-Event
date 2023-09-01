<?php

?>
<div class="de-account-content__wrapper">
	<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" class="de-account-content-link" title="<?php esc_attr_e( 'My Account', 'kitring' ); ?>">
		<?php echo apply_filters( 'dahz_framework_header_my_account_link', $nav_text ); ?>
	</a>
</div>
