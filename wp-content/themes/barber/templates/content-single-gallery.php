<?php 
$apr_gallery_single_layout ='2';
if(get_post_meta(get_the_ID(),'single_gallery_style',true) != 'default'){
    $apr_gallery_single_layout = get_post_meta(get_the_ID(),'single_gallery_style',true);
}else if(isset($apr_settings['single_gallery_style'])){
    $apr_gallery_single_layout = $apr_settings['single_gallery_style'];
}
if($apr_gallery_single_layout != ''){
    $apr_single_class=" gallery_single_".$apr_gallery_single_layout;
}else{
    $apr_single_class =' ';
}
//Pagination
$previous = ( is_attachment() ) ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
$next = get_adjacent_post(false, '', false);
$prev_post = get_previous_post();
$next_post = get_next_post();
?>
<div class="portfolio_single  row <?php echo esc_attr($apr_single_class);?>">
<?php if($prev_post  || $next_post):?>
  <div class="clearfix col-md-12">
        <div class="gallery_paginations text-center">
          <ul>
              <?php
              if($prev_post){
              previous_post_link('<li class="arrow_left"><a href="'.get_permalink( $prev_post->ID ).'" class="btn btn-primary btn-icon"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>'.esc_html__(' Previous Project','barber').'</a></li>', '');
              } ?>
              <?php
              if($next_post){
              next_post_link('<li class="arrow_right"><a href="'.get_permalink( $next_post->ID ).'" class="btn btn-primary btn-icon">'.esc_html__(' Next Project','barber').'<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></li>', '');
              } ?>            
          </ul>
        </div>
  </div>
<?php endif;?>
  <?php if($apr_gallery_single_layout == '3'):?>
    <div class="col-md-7 gallery_right">
  <?php else:?>
    <div class="col-md-12">
  <?php endif;?>
      <?php
        $image_gallery = get_post_meta(get_the_ID(), 'images_gallery', true);
        $client = get_post_meta(get_the_ID(), 'client', true);
        $services = get_post_meta(get_the_ID(), 'services', true);
      ?>  
        <div class="image_list var2">
          <?php if($apr_gallery_single_layout == '2'):?>
            <div class="blog-gallery arrows-custom">
          <?php else:?>
            <div>
          <?php endif;?>
            <?php if (has_post_thumbnail()): ?>
                <div class="img-gallery">
                    <?php 
                      the_post_thumbnail( 'apr_gallery_detail' );
                    ?>
                </div>
            <?php endif;?>
            <?php
              $viewport = '';
              $index = 0;
              if($image_gallery){
              foreach ($image_gallery as $key => $value) :
                  $image_large = wp_get_attachment_image_src($value, 'full');
                  if (isset($image_large[0])) {
                      $image = wp_get_attachment_image_src($value, 'apr_gallery_detail');
                      $alt = get_post_meta($value, '_wp_attachment_image_alt', true);
                      $viewport .= '<div class="img-gallery"><img src="' . $image[0] . '" alt="' . $alt . '"/></div>';
                      $index++;
                  }
              endforeach;
            }
              $viewport .= '';
              echo wp_kses($viewport,array(
                  'div' => array('class' => array()),
                  'img' =>  array(
                    'width' => array(),
                    'height'  => array(),
                    'src' => array(),
                    'class' => array(),
                    'alt' => array(),
                    'id' => array(),
                    )
                ));            
              ?>
          </div>
        </div>

    </div>
    <?php if($apr_gallery_single_layout == '3'):?>
      <div class="col-md-5 gallery_left">
    <?php else:?>
      <div class="col-md-12">
    <?php endif;?>    
        <div class="mad_bottom3">
        
            <div class="portfolio_title text-left">
              <h3><?php the_title(); ?></h3>
            </div>
            <div class="gallery_desciption">
                <?php echo the_content();?>
            </div>
            <div class="vertical_list">
                <ul>
                    <li class="port_cat">
                      <span><?php echo esc_html__( 'Category', 'barber' ); ?></span> <?php echo get_the_term_list($post->ID,'gallery_cat', '', ', ' ); ?>
                    </li>
                    <li>
                      <span><?php echo esc_html__( 'Date', 'barber' ); ?></span> <?php echo get_the_date('dS, F, Y');?>
                    </li>

                    <li class="port_share">
                        <span><?php echo esc_html__( 'Share', 'barber' ); ?></span> 
                        <a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_the_permalink()); ?>" target="_blank"><i class="fa fa-facebook-square"></i></a>
                        <a href="https://twitter.com/share?url=<?php echo urlencode(get_the_permalink()); ?>&amp;text=<?php echo urlencode(get_the_title()); ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="https://plus.google.com/share?url=<?php echo urlencode(get_the_permalink()); ?>" target="_blank">
                            <i class="fa fa-google-plus"></i>
                        </a>
                        <a href="http://www.linkedin.com/shareArticle?url=<?php echo urlencode(get_the_permalink()); ?>&amp;title=<?php echo urlencode(get_the_title()); ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                        <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_the_permalink()); ?>&media=<?php echo urlencode(wp_get_attachment_url( get_post_thumbnail_id() )); ?>&description=<?php echo urlencode(get_the_title()); ?>" target="_blank"><i class="fa fa-pinterest" aria-hidden="true"></i></a>                        
                    </li>
                </ul>
            </div>

        </div>

    </div>
    <?php 
    $gallery_related = get_post_meta(get_the_ID(), 'related_entries', true);
    ?>
    <?php if (is_array($gallery_related)) : ?>
        <?php if (count($gallery_related) > 0) : ?>
            <div class="gallery_related">
                <div class="apr-heading  text-left ">
                    <h4><?php echo esc_html__('Other Works','barber' );?> </h4>
                </div>
                <div class="tabs_sort">
                    <div class="gallery-entries-wrap isotope clearfix gallery-style2">  
                        <?php foreach ($gallery_related as $key => $entry) : ?>
                            <div class="item ">
                                <figure>
                                  <div class="gallery_zoom_effect">
                                    <div class="img_onhover">
                                      <?php if (has_post_thumbnail($entry)) : ?>                                   
                                        <?php $image = get_the_post_thumbnail($entry, 'apr_gallery_square'); 
                                        $attachment_url = wp_get_attachment_url(get_post_thumbnail_id($entry)); 
                                        ?>
                                        <?php echo wp_kses($image,array(
                                          'img' =>  array(
                                            'width' => array(),
                                            'height'  => array(),
                                            'src' => array(),
                                            'class' => array(),
                                            'alt' => array(),
                                            'id' => array(),
                                            )
                                        )); ?>
                                      </div>     
                                  </div>                               
                                <?php endif; ?>
                                     <figcaption>
                                        <div class="caption_block">
                                          <div class="item_desc">
                                            <a href="<?php the_permalink($entry); ?>" class="project_title"><h4><?php echo get_the_title($entry);?></h4></a>
                                            <?php echo get_the_term_list($entry,'gallery_cat', '', ', ' ); ?>               
                                          </div>
                                        </div>
                                    </figcaption>  
                                </figure>                             
                              </div>
                        <?php endforeach; ?>
                    </div>
                </div>   
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>