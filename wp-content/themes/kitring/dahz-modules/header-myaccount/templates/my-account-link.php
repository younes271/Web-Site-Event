<?php
$link_attributes = array(
	'class'			=> array( 
		$class,
		'uk-flex uk-flex-middle uk-inline',
	),
	'aria-label'	=> __( 'My Account', 'kitring' ),
	'href'			=> ( $myaccount_content_style !== 'as-popup' ) ? esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) : "#header-my-account-modal",
	'title'			=> __( 'My Account', 'kitring' )
);
if( $myaccount_content_style == 'as-popup' ) $link_attributes['data-uk-toggle'] = array( 'target: #header-my-account-modal' );
?>
<div <?php dahz_framework_set_attributes(
	array(
		'class'					=> array( 
			'de-account-content__wrapper main-menu-item'
		),
		'data-header-section'	=> $header_section,
		'data-is-lazy-myaccount'=> $is_lazy_myaccount,
		'data-myaccount-style'	=> $myaccount_content_style
	),
	'header_myaccount_wrapper'
);?>>
	<a <?php dahz_framework_set_attributes(
		$link_attributes,
		'header_myaccount_link'
	);?>>
		<?php echo apply_filters( 'dahz_framework_header_my_account_link', $nav_text );?>
	</a>
	<?php if( $myaccount_content_style == 'as-dropdown' ):
		$dropdown_container_attributes = array(
			'class' 							=> array( ( ! $is_signed_in ? 'uk-width-large' : 'uk-navbar-dropdown' ) ),
			'id'								=> 'header-myaccount-dropdown',
			'data-header-my-account-is-loaded'	=> 'false',
			'style'								=> 'display:none;',
			'data-myaccount-style'				=> $myaccount_content_style,
			'data-dahz-drop'					=> json_encode(
				array(
					'flip'			=> 'x',
					'boundary' 		=> '#header-section' . $header_section,
					'pos' 			=> 'bottom-left',
					'boundaryAlign'	=> false,
				)
			),
			
		);
	?>
		<div <?php dahz_framework_set_attributes(
			$dropdown_container_attributes,
			'dropdown_container'
		);?>>
		</div>
	<?php endif;?>
</div>
