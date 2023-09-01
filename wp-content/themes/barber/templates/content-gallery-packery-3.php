<?php 
    $i = 1;
    $pakery_class ='';
?>
<?php while (have_posts()) : the_post(); ?>

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
	$gallery = get_post_meta(get_the_ID(), 'images_gallery', true);
?>    
<?php 
    $attachment_id = get_post_thumbnail_id();
    $index_size2=  array('1','6','8','13','15','20','22','27','29','34','36','41','43','48','50','55');
    $index_size3=  array('4','11','18','25','32','39','46','53');
    if(in_array($i, $index_size3) ){
        $pakery_class = 'image_size3';
        $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_packery9'); 
    }elseif(in_array($i, $index_size2) ){
         $pakery_class = 'image_size2';
         $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_packery7'); 
    }else{
        $pakery_class = 'image_size';
        $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_packery8');
    }
?>    
<div class="item <?php echo esc_attr($apr_post_term_filters).' '.esc_attr($pakery_class);?>">
    <div class="figcaption">
        <?php if ( has_post_thumbnail() ) : ?>
    		<figure class="gallery-image">
    			<div class="gallery-img">
					<?php if (is_array($gallery) && count($gallery) > 1) : ?>
						<?php
							$index = 0;
							foreach ($gallery as $key => $value) :
								$alt = get_post_meta($value, '_wp_attachment_image_alt', true);
								$apr_gallery_full = wp_get_attachment_image_src($value, 'full');
								if(in_array($i, $index_size3) ){
									$apr_gallery_2 = wp_get_attachment_image_src($value, 'apr_gallery_packery9');
									echo '<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="' . esc_url($apr_gallery_full[0]) . '" title="">
										<i class="fa fa-search" aria-hidden="true"></i>
										<img src="' . esc_url($apr_gallery_2[0]) . '" alt="gallery-blog" class="gallery-img" />
									</a>';
								}else if(in_array($i, $index_size2) ){
									$apr_gallery_3 = wp_get_attachment_image_src($value, 'apr_gallery_packery7');
									echo '<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="' . esc_url($apr_gallery_full[0]) . '" title="">
										<i class="fa fa-search" aria-hidden="true"></i>
										<img src="' . esc_url($apr_gallery_3[0]) . '" alt="gallery-blog" class="gallery-img" />
									</a>';
								}else{
									$apr_gallery = wp_get_attachment_image_src($value, 'apr_gallery_packery8');
									echo '<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="' . esc_url($apr_gallery_full[0]) . '" title="">
										<i class="fa fa-search" aria-hidden="true"></i>
										<img src="' . esc_url($apr_gallery[0]) . '" alt="gallery-blog" class="gallery-img" />
									</a>';
								}
								$index++;
							endforeach;
						?>
					<?php else: ?>
						<?php 
							$apr_gallery_full = apr_get_attachment($attachment_id, 'full'); 
							$apr_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
						?>
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