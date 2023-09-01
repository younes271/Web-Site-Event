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
	$apr_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
?>    
<?php 
    $attachment_id = get_post_thumbnail_id();
    $index_size2=  array('2','13','24','35','46','57','68','79','90');
    $index_size3=  array('8','19','30','41','52','63','74','85','96');
    $index_size4=  array('9','20','31','42','53','64','75','86','97');
    if(in_array($i, $index_size4) ){
        $pakery_class = 'image_size4';
        $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_packery5'); 
    }elseif(in_array($i, $index_size2) ){
         $pakery_class = 'image_size2';
         $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_masonrys1'); 
	}elseif(in_array($i, $index_size3) ){
         $pakery_class = 'image_size3';
         $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_packery4'); 
    }else{
        $pakery_class = 'image_size';
        $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_packery6'); 
    }
?>    
<div class="item <?php echo esc_attr($apr_post_term_filters).' '.esc_attr($pakery_class);?>">
    <div class="figcaption">
        <?php if ( has_post_thumbnail() ) : ?>
            <figure class="gallery-image">
                <div class="gallery-img">
					<img width="<?php echo esc_attr($apr_gallery_grid['width']) ?>" height="<?php echo esc_attr($apr_gallery_grid['height']) ?>" src="<?php echo esc_url($apr_gallery_grid['src']) ?>" alt="<?php echo esc_html($apr_alt) ?>" />    
                </div>
				<div class="gallery-desc">
					<a href="<?php the_permalink();?>" class="gallery_title"><?php the_title();?></a>
					<div class="info category">
						<?php echo get_the_term_list(get_the_ID(),'gallery_cat', '', ', ' ); ?>
					</div>  
				</div>  
            </figure>   
        <?php endif;?>   
    </div>  
</div>
<?php $i++;?>
<?php endwhile; ?>