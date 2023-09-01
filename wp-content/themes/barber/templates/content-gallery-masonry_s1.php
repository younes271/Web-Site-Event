
<?php 
    $i=0;
    $apr_gallery_layout = isset($layout)?$layout:'';
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
?>    
<?php 
    $attachment_id = get_post_thumbnail_id();
    $pakery_class ='';
    if(isset($apr_gallery_layout) && $apr_gallery_layout == 'masonry_4'){
        $index_size1 = array('0','7','10','17','20','27','30','37','40','47','50','57','60','67','70','77','80','87',
            '90','97','100','107','110','117');
        if(in_array($i, $index_size1)){
            $pakery_class = ' image_size1';
            $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_masonry_4'); 
        }else{
            $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_square'); 
        }    
    }else if(isset($apr_gallery_layout) && $apr_gallery_layout == 'masonry_5'){
        $index_size1 = array('0','6','7','13','14','20','21','27','28','34','35','41','42','48','49','54','55','61','62','68','69','74','75','81','82','88','94','95','101');
        // $index_size2 = array('5','12');
        $index =5;
        $index_size2 =array();
        for ($a=0; $a<200; $a++){
            $index_size2[] = $index;
            $index = $index +7;
        }
        if(in_array($i, $index_size1)){
            $pakery_class = ' image_size1';
            $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_packery3vertical'); 
        } else if(in_array($i, $index_size2)){
            $pakery_class = ' image_size2';
            $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_packery3big'); 
        }else{
            $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_packery3'); 
        }    
    }
    else{
        $index_size1 = array('0','2','4','5','8','10','12','13','16','18','20','21','24','26','28','29','32','34','36','37','40','42','44','45','48','50','52','53','56','58','60','61','64','66','68','69','72','74','76','77','80','82','84','85');
        if(in_array($i, $index_size1)){
            $pakery_class = ' image_size1';
            $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_masonrys1'); 
        }else{
            $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_square'); 
        }        
    }
    $gallery = get_post_meta(get_the_ID(), 'images_gallery', true);
   
?> 
<div class="item <?php echo esc_attr($apr_post_term_filters).esc_attr($pakery_class);?> ">
    <div class="figcaption">
		<?php if ( has_post_thumbnail() ) : ?>
    		<figure class="gallery-image">
    			<div class="gallery-img">
					<?php if (is_array($gallery) && count($gallery) > 1) : ?>
						<?php
							$index = 0;
							foreach ($gallery as $key => $value) :
								$alt = get_post_meta($value, '_wp_attachment_image_alt', true);
								if(isset($apr_gallery_layout) && $apr_gallery_layout == 'masonry_4'){
									if(in_array($i, $index_size1) ){
										$apr_gallery_2 = wp_get_attachment_image_src($value, 'apr_gallery_masonry_4');
										$apr_gallery_full = wp_get_attachment_image_src($value, 'full');
										echo '<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="' . esc_url($apr_gallery_full[0]) . '" title="">
											<i class="fa fa-search" aria-hidden="true"></i>
											<img src="' . esc_url($apr_gallery_2[0]) . '" alt="gallery-blog" class="gallery-img" />
										</a>';
									}else{
										$apr_gallery = wp_get_attachment_image_src($value, 'apr_gallery_square');
										$apr_gallery_full = wp_get_attachment_image_src($value, 'full');
										echo '<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="' . esc_url($apr_gallery_full[0]) . '" title="">
											<i class="fa fa-search" aria-hidden="true"></i>
											<img src="' . esc_url($apr_gallery[0]) . '" alt="gallery-blog" class="gallery-img" />
										</a>';
									}
								}elseif(isset($apr_gallery_layout) && $apr_gallery_layout == 'masonry_5'){
									if(in_array($i, $index_size1) ){
										$apr_gallery_2 = wp_get_attachment_image_src($value, 'apr_gallery_packery3vertical');
										$apr_gallery_full = wp_get_attachment_image_src($value, 'full');
										echo '<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="' . esc_url($apr_gallery_full[0]) . '" title="">
											<i class="fa fa-search" aria-hidden="true"></i>
											<img src="' . esc_url($apr_gallery_2[0]) . '" alt="gallery-blog" class="gallery-img" />
										</a>';
									}else if(in_array($i, $index_size2) ){
										$apr_gallery_3 = wp_get_attachment_image_src($value, 'apr_gallery_packery3vertical');
										$apr_gallery_full = wp_get_attachment_image_src($value, 'full');
										echo '<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="' . esc_url($apr_gallery_full[0]) . '" title="">
											<i class="fa fa-search" aria-hidden="true"></i>
											<img src="' . esc_url($apr_gallery_3[0]) . '" alt="gallery-blog" class="gallery-img" />
										</a>';
									}else{
										$apr_gallery = wp_get_attachment_image_src($value, 'apr_gallery_packery3');
										$apr_gallery_full = wp_get_attachment_image_src($value, 'full');
										echo '<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="' . esc_url($apr_gallery_full[0]) . '" title="">
											<i class="fa fa-search" aria-hidden="true"></i>
											<img src="' . esc_url($apr_gallery[0]) . '" alt="gallery-blog" class="gallery-img" />
										</a>';
									}
								}else{
									if(in_array($i, $index_size1) ){
										$apr_gallery_2 = wp_get_attachment_image_src($value, 'apr_gallery_masonrys1');
										$apr_gallery_full = wp_get_attachment_image_src($value, 'full');
										echo '<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="' . esc_url($apr_gallery_full[0]) . '" title="">
											<i class="fa fa-search" aria-hidden="true"></i>
											<img src="' . esc_url($apr_gallery_2[0]) . '" alt="gallery-blog" class="gallery-img" />
										</a>';
									}else{
										$apr_gallery = wp_get_attachment_image_src($value, 'apr_gallery_square');
										$apr_gallery_full = wp_get_attachment_image_src($value, 'full');
										echo '<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="' . esc_url($apr_gallery_full[0]) . '" title="">
											<i class="fa fa-search" aria-hidden="true"></i>
											<img src="' . esc_url($apr_gallery[0]) . '" alt="gallery-blog" class="gallery-img" />
										</a>';
									}
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