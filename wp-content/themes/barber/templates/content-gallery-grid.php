
<?php 
    $apr_post_term_arr = get_the_terms( get_the_ID(), 'gallery_cat' );
    $apr_post_term_filters = '';
    $apr_post_term_names = '';

    if (is_array($apr_post_term_arr) || is_object($apr_post_term_arr)){
        foreach ( $apr_post_term_arr as $post_term ) {

            $apr_post_term_filters .= $post_term->slug . ' ';
            $apr_post_term_names .= $post_term->name . ', ';
            if($post_term->parent!=0){
                $parent_term = get_term( $post_term->parent,'gallery_cat' );
                $apr_post_term_filters .= $parent_term->slug . ' ';
                
            }
        }
    }

    $apr_post_term_filters = trim( $apr_post_term_filters );
    $apr_post_term_names = substr( $apr_post_term_names, 0, -2 );
    $apr_author = get_the_author_link();
?>
<div class="item <?php echo esc_attr($apr_post_term_filters);?>">
    <div class="figcaption">
        <?php if ( has_post_thumbnail() ) : ?>
    		<figure class="gallery-image">
    			<div class="gallery-img">
					<?php 
    					$attachment_id = get_post_thumbnail_id();
						$apr_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
    					$apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_grid'); 
    					$apr_gallery_full = apr_get_attachment($attachment_id, 'full'); 
						$gallery = get_post_meta(get_the_ID(), 'images_gallery', true);
    				?>
					<?php if (is_array($gallery) && count($gallery) > 1) : ?>
						<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="<?php echo esc_url($apr_gallery_full['src']);?>" title="">
							<i class="fa fa-search" aria-hidden="true"></i>
							<img width="<?php echo esc_attr($apr_gallery_grid['width']) ?>" height="<?php echo esc_attr($apr_gallery_grid['height']) ?>" src="<?php echo esc_url($apr_gallery_grid['src']) ?>" alt="<?php echo esc_html($apr_alt) ?>" />    
						</a>
						<?php
							$index = 0;
							foreach ($gallery as $key => $value) :
								$apr_gallery = wp_get_attachment_image_src($value, 'apr_gallery_grid');
								$apr_gallery_full = wp_get_attachment_image_src($value, 'full');
								$alt = get_post_meta($value, '_wp_attachment_image_alt', true);
									echo '<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="' . esc_url($apr_gallery_full[0]) . '" title="">
										<i class="fa fa-search" aria-hidden="true"></i>
										<img src="' . esc_url($apr_gallery[0]) . '" alt="gallery-blog" class="gallery-img" />
									</a>';
								$index++;
							endforeach;
						?>
					<?php else: ?>
						<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="<?php echo esc_url($apr_gallery_full['src']);?>" title="">
							<i class="fa fa-search" aria-hidden="true"></i>
							<img width="<?php echo esc_attr($apr_gallery_grid['width']) ?>" height="<?php echo esc_attr($apr_gallery_grid['height']) ?>" src="<?php echo esc_url($apr_gallery_grid['src']) ?>" alt="<?php echo esc_html($apr_alt) ?>" />    
						</a>
					<?php endif;?>
    			</div>
    		</figure>   
        <?php endif;?>   
    </div>  
</div>