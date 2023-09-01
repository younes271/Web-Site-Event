<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package glamon
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'style-default' ); ?>>
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'full' ); ?></a>
		</div><!-- .post-thumbnail -->
	<?php } ?>
	<div class="entry-category">
		<?php
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			if ( true == glamon_global_var( 'display_categries', '', false ) ) :
				$categories_list = get_the_category_list( __( ', ', 'glamon' ) );
				if ( $categories_list && glamon_categorized_blog() ) {
					printf(
						wp_kses_post( '<span class="category"><span class="ti-direction-alt"></span>' ) .
						/* translators: used between list items, there is a space after the comma */
						esc_html( ' %1$s' ) .
						wp_kses_post( '</span>' ),
						wp_kses_post( $categories_list )
					);
				}
		endif;
		}
		?>
	</div><!-- .entry-category -->
	<header class="entry-header">
		<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
	</header><!-- .entry-header -->
	<div class="entry-meta">
		<?php glamon_posted_on(); ?>
	</div><!-- .entry-meta -->
	<div class="entry-main">
		<div class="entry-content">
			<?php echo wp_kses_post( substr( wp_strip_all_tags( get_the_excerpt() ), 0, 300 ) . '...' ); ?>
		</div><!-- .entry-content -->
		<div class="row entry-extra">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="entry-extra-item text-left">
					<div class="post-read-more">
						<a class="btn" href="<?php the_permalink(); ?>" data-hover="<?php esc_attr_e( 'Read More', 'glamon' ); ?>"><span><?php esc_html_e( 'Read More', 'glamon' ); ?></span></a>
					</div><!-- .post-read-more -->
				</div><!-- .entry-extra-item -->
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="entry-extra-item text-right">
					<?php
					if ( glamon_global_var( 'display_social_sharing', '', false ) ) {
						?>
						<div class="post-share">
							<ul class="post-share-buttons">
								<?php if ( wp_is_mobile() ) { ?>
									<li class="whatsapp"><a href="https://api.whatsapp.com/send?&text=<?php the_title(); ?> : <?php the_permalink(); ?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php esc_attr_e( 'Share on WhatsApp', 'glamon' ); ?>"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
								<?php } ?>
								<li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php esc_attr_e( 'Share on Facebook', 'glamon' ); ?>"><i class="fa fa-facebook"></i></a></li>
								<li class="google-plus"><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php esc_attr_e( 'Share on Google+', 'glamon' ); ?>"><i class="fa fa-google-plus"></i></a></li>
								<li class="twitter"><a href="http://twitter.com/share?text=<?php the_title(); ?>&amp;url=<?php the_permalink(); ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php esc_attr_e( 'Share on Twitter', 'glamon' ); ?>"><i class="fa fa-twitter"></i></a></li>
								<li class="linkedin"><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;summary=&amp;source=" target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php esc_attr_e( 'Share on LinkedIn', 'glamon' ); ?>"><i class="fa fa-linkedin"></i></a></li>
								<li class="pinterest"><a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php the_post_thumbnail_url( 'full' ); ?>&amp;description=<?php the_title(); ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php esc_attr_e( 'Share on Pinterest', 'glamon' ); ?>"><i class="fa fa-pinterest-p"></i></a></li>
							</ul>
						</div><!-- .post-share -->
						<?php
					}
					?>
				</div><!-- .entry-extra-item -->
			</div>
		</div><!-- .entry-extra -->
	</div><!-- .entry-main -->
</article><!-- #post-## -->
