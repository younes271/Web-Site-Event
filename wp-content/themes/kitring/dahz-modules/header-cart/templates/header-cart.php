<?php

$is_uppercase = dahz_framework_get_option( 'header_cart_enable_uppercase', false );

$link_attributes = array(
	'class'			=> array(
		'de-header__mini-cart-btn uk-inline uk-flex uk-flex-middle',
		'ds-header-mini-cart--open-container',
		( $is_uppercase ) ? 'uk-text-uppercase' : '',
		'de-header__mini-cart--empty'
	),
	'href'			=> $cart_url,
	'title'			=> __( 'Cart', 'kitring' ),
	'aria-label'	=> __( 'Cart', 'kitring' )
);
if( $cart_display == 'as-sidebar' ) $link_attributes['data-uk-toggle'] = array( 'target: #header-cart-off-canvas;' );

?>
<div <?php dahz_framework_set_attributes(
	array(
		'class'					=> array(
			'de-header__mini-cart ds-mini-cart__item',
			"de-header__mini-cart--{$cart_display}",
			"de-header__mini-cart--{$header_layout}",
			'main-menu-item',
		),
		'data-cart-layout'		=> $cart_display,
		'data-header-layout'	=> $header_layout
	),
	'header_cart_wrapper'
);?>>
	<a <?php dahz_framework_set_attributes(
		$link_attributes,
		'header_cart_link'
	);?>>
		<?php echo apply_filters( 'dahz_framework_header_cart_link_content', $cart_link_content );?>
	</a>
	<?php if ( $cart_display == 'as-dropdown' ) : ?>
		<div <?php dahz_framework_set_attributes(
			array(
				'class' 						=> array( 'uk-navbar-dropdown', 'de-header__mini-cart-container', 'uk-box-shadow-small' ),
				'data-dahz-drop'				=> json_encode( array(
					'boundary'		=> '#header-section' . $header_section,
					'pos'			=> 'bottom-left',
					'flip'			=> 'x',
					'boundaryAlign'	=> false,
				) ),
				'style'							=> 'display:none;',
				'id'							=> 'header-cart-dropdown',
				'data-mini-cart-is-loaded'  	=> 'false',
				'data-mini-cart-content-style' 	=> "dropdown"
			),
			'header_cart_dropdown_container'
		);?>>
		</div>
	<?php endif; ?>
</div>
