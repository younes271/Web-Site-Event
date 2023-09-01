
<?php 
$i = 1;
?>
<?php while (have_posts()) : the_post(); ?>
<?php
$masonry_class ='';
    $apr_post_term_arr = get_the_terms( get_the_ID(), 'gallery_cat' );
	$apr_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
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
    $attachment_id = get_post_thumbnail_id();
    $index_size=  array('2','3','5','6','8','9');
    $index_size2=  array('0','1','4','7');
	$apr_gallery_full = apr_get_attachment($attachment_id, 'full'); 
    if(in_array($i, $index_size2) ){
        $masonry_class = 'image_size1';
        $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_masonry2_small'); 
    }
    if(in_array($i, $index_size) ){
        $pakery_class = 'image_size2';
        $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_masonry2_large'); 
    }
	$gallery = get_post_meta(get_the_ID(), 'images_gallery', true);
?>
<div class="item <?php echo esc_attr($apr_post_term_filters).' '.esc_attr($masonry_class);?>">
    <div class="figcaption">
		<?php if ( has_post_thumbnail() ) : ?>
    		<figure class="gallery-image">
    			<div class="gallery-img">
					<?php if (is_array($gallery) && count($gallery) > 1) : ?>
						<a class="fancybox-thumb btn-fancybox ff" data-fancybox-group="fancybox-thumb"  href="<?php echo esc_url($apr_gallery_full['src']);?>" title="">
							<i class="fa fa-search" aria-hidden="true"></i>
							<img width="<?php echo esc_attr($apr_gallery_grid['width']) ?>" height="<?php echo esc_attr($apr_gallery_grid['height']) ?>" src="<?php echo esc_url($apr_gallery_grid['src']) ?>" alt="<?php echo esc_html($apr_alt) ?>" />    
						</a>
						<?php
							
							$index = 0;
							foreach ($gallery as $key => $value) :
								$alt = get_post_meta($value, '_wp_attachment_image_alt', true);
								if(in_array($i, $index_size2) ){
									$apr_gallery = wp_get_attachment_image_src($value, 'apr_gallery_masonry2_small');
									$apr_gallery_full = wp_get_attachment_image_src($value, 'full');
									echo '<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="' . esc_url($apr_gallery_full[0]) . '" title="">
										<i class="fa fa-search" aria-hidden="true"></i>
										<img src="' . esc_url($apr_gallery[0]) . '" alt="gallery-blog" class="gallery-img" />
									</a>';
								}
								if(in_array($i, $index_size) ){
									$apr_gallery_2 = wp_get_attachment_image_src($value, 'apr_gallery_masonry2_large');
									$apr_gallery_full = wp_get_attachment_image_src($value, 'full');
									echo '<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="' . esc_url($apr_gallery_full[0]) . '" title="">
										<i class="fa fa-search" aria-hidden="true"></i>
										<img src="' . esc_url($apr_gallery_2[0]) . '" alt="gallery-blog" class="gallery-img" />
									</a>';
								}
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
<?php $i++;?>
<?php endwhile; ?>