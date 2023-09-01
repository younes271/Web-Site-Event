<?php if( $is_signed_in ):?>
	<ul class="de-dropdown">
	<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
		<li class="<?php echo esc_attr( wc_get_account_menu_item_classes( $endpoint ) );?>">
			<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
		</li>
	<?php endforeach;?>
	</ul>
<?php endif;?>
