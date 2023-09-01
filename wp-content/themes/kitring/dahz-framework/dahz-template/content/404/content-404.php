<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kitring
 * @since 1.0
 * @version 1.0
 */
 
$page_title_404 = dahz_framework_get_option( 'notfound_title_text_404', '' );

$page_subtitle_404 = dahz_framework_get_option( 'notfound_subtitle_text_404', '' );

$image_404 = dahz_framework_get_option( 'notfound_image_404', get_template_directory_uri() . '/assets/images/customizer/404.png' );

$height_viewport_options = '';

if( !class_exists( 'Woocommerce' ) ){
	
	$height_viewport_options = 'expand:true;';
	
} else {
	
	$height_viewport_options = 'offset-top:true;';
	
}
?>

<section class="error-404 not-found uk-width-1 uk-flex" data-uk-height-viewport="<?php echo esc_attr( $height_viewport_options );?>">
	<div class="error-404__wrapper uk-text-center uk-margin-auto uk-margin-auto-vertical">
		
		<header class="page-header">
		
			<?php if( !empty( $image_404 ) ):?>
				<div class="error-404__image">
				<?php
					echo apply_filters(
						'dahz_framework_404_image',
						sprintf( '
							<img src="%1$s" alt="%2$s" />
							',
							$image_404,
							__( '404 Image', 'kitring' )
						)
					);

				?>
				</div>
			<?php endif;?>
			
			<?php if( !empty( $page_title_404 ) ):?>
				<h1 class="page-title"><?php echo wp_kses_post( $page_title_404 );?></h1>
			<?php else:?>
				<h1 class="page-title"><?php esc_html_e( 'Woopsie Daisy!', 'kitring' ); ?></h1>
			<?php endif;?>
		</header><!-- .page-header -->
		<div class="page-content">
			<p>
				<?php if( !empty( $page_subtitle_404 ) ):?>
					<?php echo wp_kses_post( $page_subtitle_404 );?>
				<?php else:?>
					<?php echo wp_kses_post( 'Looks like something went completely wrong! but don\'t worry<br/>It can happen to the best of us, and it just happened to you', 'kitring' ); ?>
				<?php endif;?>
			</p>
			<?php if( dahz_framework_get_option( 'notfound_enable_back_to_homepage', true ) ):?>
				<a class="uk-button uk-button-default" href="<?php echo esc_url( home_url( '/' ) ) ?>"><?php esc_html_e( 'Go To Homepage', 'kitring' );?></a>
			<?php endif;?>
		</div> <!-- .page-content -->
	</div>
</section> <!-- .error-404 -->