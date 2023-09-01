<?php
/*
	* Mega Menu Product Carousel
*/
?>

<?php
if( $query->have_posts() ):
?>
	<div class="de-megamenu__carousel-wrapper" data-source="product" data-column="<?php echo esc_attr( $column );?>">

	<?php
		while ( $query->have_posts() ) : $query->the_post();

			$current_product 	= new WC_Product( get_the_ID() );

			$regular_price 		= $current_product->get_price_html();
		?>

			<div class="de-megamenu-carousel column">
				<div class="de-megamenu-carousel__image">
					<a href="<?php the_permalink();?>" class="de-megamenu-carousel--link">
						<?php
						if ( has_post_thumbnail() ) :

							the_post_thumbnail( 'shop_catalog' );

						else :

							wc_placeholder_img( 'shop_catalog' );

						endif;

						?>
						<!-- <span><?php the_title();?></span> -->
					</a>
				</div>
				<div class="de-megamenu-carousel--desc">
					<h5>
						<a href="%1$s">
							<?php the_title();?>
						</a>
					</h5>
					<?php echo sprintf( '<p>%1$s</p>', $regular_price );?>
				</div>
			</div>

		<?php endwhile;?>
	</div>
<?php endif;?>
