<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package kitring
 */
?>

<div class="site-branding de-header__site-branding">
	<div class="de-header__site-branding-wrapper">
	<?php
		echo apply_filters( 
			'dahz_framework_logo',
			sprintf( '
				<div class="de-header__logo-media de-header__logo-media--normal">
					%1$s
				</div>
				%2$s
				%3$s
				%4$s
				',
				$site_logo_image,
				apply_filters( 'dahz_framework_logo_light', '', $site_logo_image, true  ),
				apply_filters( 'dahz_framework_logo_dark', '', $site_logo_image, true ),
				apply_filters( 'dahz_framework_logo_sticky', '', $site_logo_image, true )
			),
			$builder_type,
			$section,
			$row,
			$column
		);

	?>
	</div>
</div>