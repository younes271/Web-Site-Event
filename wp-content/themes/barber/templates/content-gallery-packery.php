<?php 
    $i = 0;
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
?>    
<?php 
    $attachment_id = get_post_thumbnail_id();
    $index_size1 = array('1','10','19','28','37','46','55','64','73','82','91','100');
    $index_size2=  array('2','3','6','8','11','12','15','17','20','21','24','26','29','30','33','35','38','39','42','44','47','48','51','53','16');
    $index_size3=  array('4','7','22','25','31','34','40','43','52');
    if(in_array($i, $index_size1) ){
        $pakery_class = 'image_size1';
        $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_packery11'); 
    }elseif(in_array($i, $index_size2) ){
         $pakery_class = 'image_size2';
         $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_packery12'); 
    }else{
        $pakery_class = 'image_size';
        $apr_gallery_grid = apr_get_attachment($attachment_id, 'apr_gallery_packery10'); 
    }
	$gallery = get_post_meta(get_the_ID(), 'images_gallery', true);
?>    
<div class="item <?php echo esc_attr($apr_post_term_filters).' '.esc_attr($pakery_class);?>">
    <div class="figcaption">
        <?php if ( has_post_thumbnail() ) : ?>
    		<figure class="gallery-image">
    			<div class="gallery-img">

						<?php 
							$apr_gallery_full = apr_get_attachment($attachment_id, 'full'); 
							$apr_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
						?>
						<a class="fancybox-thumb btn-fancybox" data-fancybox-group="fancybox-thumb"  href="<?php echo esc_url($apr_gallery_full['src']);?>" title="">
							<i class="fa fa-search" aria-hidden="true"></i>
							<img width="<?php echo esc_attr($apr_gallery_grid['width']) ?>" height="<?php echo esc_attr($apr_gallery_grid['height']) ?>" src="<?php echo esc_url($apr_gallery_grid['src']) ?>" alt="<?php echo esc_html($apr_alt) ?>" />    
						</a>
				
    			</div>
    		</figure>   
        <?php endif;?>    
    </div>  
</div>
<?php $i++;?>
<?php endwhile; ?>