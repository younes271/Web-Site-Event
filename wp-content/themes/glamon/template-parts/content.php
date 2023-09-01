<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package glamon
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'style-one' ); ?>>
	<?php if ( true == glamon_global_var( 'display_categries', '', false ) ) : ?>
	<div class="category-list">
		<?php
		$category_detail = get_the_category( get_the_id() );
		$result          = '';
		foreach ( $category_detail as $item ) :
			$category_link = get_category_link( $item->cat_ID );
			$result       .= '<a href = "' . esc_url( $category_link ) . '">' . $item->name . '</a>';
		endforeach;
		echo wp_kses_post( $result );
		?>
	</div><!-- .category-list -->
	<?php endif; ?>
	<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
		<div class="post-thumbnail">
			<img src="<?php echo esc_url( get_parent_theme_file_uri( '/assets/images/no-image/No-Image-Found-400x264.png' ) ); ?>" alt="<?php echo esc_attr__( 'No Image Found', 'glamon' ); ?>" width="400" height="264">
			<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
				<a class="placeholder" href="<?php the_permalink(); ?>" style="background-image:url('<?php esc_url( the_post_thumbnail_url( 'full' ) ); ?>')"></a>
			<?php endif; ?>
		</div><!-- .post-thumbnail -->
	<?php endif; ?>
	<div class="entry-main matchHeight">
		<header class="entry-header">
			<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
		</header><!-- .entry-header -->
		<div class="entry-content">
			<p><?php echo wp_kses_post( substr( strip_tags( get_the_excerpt() ), 0, 150 ) . '...' ); ?></p>
		</div><!-- .entry-content -->
	</div><!-- .entry-main -->
	<div class="post-meta">
		<span class="author"><?php echo get_the_author_link(); ?></span>
		<span class="date"><?php the_time('F j, Y'); ?></span>
	</div><!-- .post-meta -->
</article><!-- #post-## -->
