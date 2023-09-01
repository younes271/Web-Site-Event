<?php
global $apr_settings;
require_once(APR_FUNCTIONS . '/config_options.php');
require_once(APR_FUNCTIONS . '/vc_functions.php');
require_once(APR_FUNCTIONS . '/sidebars.php');
require_once(APR_FUNCTIONS . '/layout.php');
require_once(APR_FUNCTIONS . '/menus.php');
require_once(APR_FUNCTIONS . '/gallery_like_count.php');
require_once(APR_FUNCTIONS . '/widgets/apr_recent_posts.php'); 
require_once(APR_FUNCTIONS . '/widgets/apr_recent_comments.php');
require_once(APR_FUNCTIONS . '/panel-social/functions.php');
require_once(APR_FUNCTIONS . '/ajax_search/ajax-search.php');;
if (class_exists('Woocommerce')) {
    require_once(APR_FUNCTIONS . '/woocommerce.php');
	require_once(APR_FUNCTIONS . '/widgets/apr_override_woocommerce.php'); 
}
require_once(APR_FUNCTIONS . '/wpml.php');
add_action( 'wp_ajax_apr_ajax_load_more', 'apr_ajax_load_more' );
add_action( 'wp_ajax_nopriv_apr_ajax_load_more', 'apr_ajax_load_more' );
function apr_ajax_load_more(){
    $apr_perpage = $_POST['apr_perpage'];
    $apr_currentpage = $_POST['apr_currentpage'];
    $args = array(
        'post_type' => 'gallery' ,
        'post_status' => 'publish',
        'posts_per_page' => (int)$apr_perpage,
        'paged' => (int)$apr_currentpage + 1,
    );
    $rquery = new Wp_Query( $args );
    if ( $rquery->have_posts() ) :
                    while ( $rquery->have_posts() ) : $rquery->the_post();
                ?>
                    <?php 
                        $post_term_arr = get_the_terms( get_the_ID(), 'gallery_cat' );
                        $post_term_filters = '';
                        $post_term_names = '';

                        if (is_array($post_term_arr) || is_object($post_term_arr)){
                            foreach ( $post_term_arr as $post_term ) {

                                $post_term_filters .= $post_term->slug . ' ';
                                $post_term_names .= $post_term->name . ', ';
                                if($post_term->parent!=0){
                                    $parent_term = get_term( $post_term->parent,'gallery_cat' );
                                    $post_term_filters .= $parent_term->slug . ' ';
                                    
                                }
                            }
                        }

                        $post_term_filters = trim( $post_term_filters );
                        $post_term_names = substr( $post_term_names, 0, -2 );
                        $author = get_the_author_link();
                    ?>
                    <div class="item <?php echo esc_attr($post_term_filters);?>">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <figure class="gallery-image">
                                <div class="gallery-img">
                                    <?php 
                                        $attachment_id = get_post_thumbnail_id();
                                        $attachment_grid = apr_get_attachment($attachment_id, 'apr_gallery_grid'); 
                                        $attachment_grid_2 = apr_get_attachment($attachment_id, 'apr_blog_detail'); 
                                    ?>
                                    <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($attachment_grid_2['src']) ?>" ><img width="<?php echo esc_attr($attachment_grid['width']) ?>" height="<?php echo esc_attr($attachment_grid['height']) ?>" src="<?php echo esc_url($attachment_grid['src']) ?>" alt="<?php echo esc_html__('gallery','barber') ?>" /></a> 
                                </div>
                            </figure>   
                        <?php endif;?>  
                    </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
}
function apr_get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
//* Wrap first word of widget title into a span tag
add_filter ( 'widget_title', 'apr_add_span_widgets' );
function apr_add_span_widgets( $old_title ) {
  
    $parsed = apr_get_string_between($old_title, '{', '}');
    if($parsed != ''){
        $title = substr($old_title, strpos($old_title, "}") + 1);
        $titleNew = '<span class="before_title">'.esc_html($parsed).'</span>'.esc_html($title);
    }else{
        $titleNew = $old_title;
    }

    return $titleNew;
}
//preloader
function apr_pre_loader() {
    $result = '';
    global $apr_settings, $wp_query, $preload_type;
    if(isset($apr_settings['logo-preload']) && $apr_settings['logo-preload']!=''){
        $apr_logo_preload = $apr_settings['logo-preload']['url'];
    }
    if (empty($preload_type)) {
        $result = isset($apr_settings['preload-type']) ? $apr_settings['preload-type'] : 1;
        if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $cat_layout = get_metadata('category', $cat->term_id, 'preload', true);
            if (!empty($cat_layout) && $cat_layout != 'default') {
                    $result = $cat_layout;
                }
            else{   
                $result = isset($apr_settings['preload-type'])?$apr_settings['preload-type']:'';
            }
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_layout = get_post_meta(wc_get_page_id('shop'), 'preload', true);
                if(!empty($shop_layout) && $shop_layout != 'default') {
                    $result = $shop_layout;
                }
            } 
        } else if(is_404()){
            if(isset($apr_settings['404_preload'])){
                $result = $apr_settings['404_preload'];
            }else{
                $result = isset($apr_settings['preload-type'])?$apr_settings['preload-type']:'';
            }
        } else if(is_page_template( 'coming-soon.php' )){
            if(isset($apr_settings['coming_preload'])){
                $result = $apr_settings['coming_preload'];
            }else{
                $result = isset($apr_settings['preload-type'])?$apr_settings['preload-type']:'';
            }            
        }else {
            if (is_singular()) {
                $single_layout = get_post_meta(get_the_id(), 'preload', true);
                if (!empty($single_layout) && $single_layout != 'default') {
                    $result = $single_layout;
                }
            } else {
                if (!is_home() && is_front_page()) {
                    $result = $apr_settings['preload-type'];
                } else if (is_home() && !is_front_page()) {
                    $posts_page_id = get_option( 'page_for_posts' );
                    $posts_page_layout = get_post_meta($posts_page_id, 'preload', true);
                    if (!empty($posts_page_layout) && $posts_page_layout != 'default') {
                        $result = $posts_page_layout;
                    }
                }
            }
        }
        $preload_type = $result;
    }
    if(isset($apr_settings['preload']) && $apr_settings['preload'] =='enable'){
        ob_start();
    ?>
    <div class="preloader">
        <?php if($result == 1): ?>
            <div id="loading">
                <div id="loading-center">
                    <div id="loading-center-absolute">
                        <div class="object" id="object_one"></div>
                        <div class="object" id="object_two"></div>
                        <div class="object" id="object_three"></div>
                        <div class="object" id="object_four"></div>
                        <div class="object" id="object_five"></div>
                        <div class="object" id="object_six"></div>
                        <div class="object" id="object_seven"></div>
                        <div class="object" id="object_eight"></div>
                        <div class="object" id="object_big"></div>
                    </div>
                </div>
            </div>
        <?php elseif($result == 2): ?>
             <div id="loading-2">
                <div id="loading-center-2">
                    <?php
                    if ($apr_logo_preload && $apr_logo_preload!=''):
                        echo '<img class="logo-preload" src="' . esc_url(str_replace(array('http:', 'https:'), '', $apr_logo_preload)) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
                    else:
                        bloginfo('name');
                    endif;
                    ?>
                    <div id="loading-center-absolute-2">
                        <div class="object-2" id="object_one_2"></div>
                        <div class="object-2" id="object_two_2"></div>
                        <div class="object-2" id="object_three_2"></div>
                    </div>
                </div>
            </div>
        <?php elseif($result == 3): ?>
            <div id="loading-3">
                <div id="loading-center-3">
                    <div id="loading-center-absolute-3">
                        <div class="object-3" id="object_four_3"></div>
                        <div class="object-3" id="object_three_3"></div>
                        <div class="object-3" id="object_two_3"></div>
                        <div class="object-3" id="object_one_3"></div>
                    </div>
                </div>
            </div>
        <?php elseif($result == 4): ?>
            <div class="preloader-4">
                <div class="busy-loader">
                    <div class="w-ball-wrapper ball-1">
                        <div class="w-ball">
                        </div>
                    </div>
                    <div class="w-ball-wrapper ball-2">
                        <div class="w-ball">
                        </div>
                    </div>
                    <div class="w-ball-wrapper ball-3">
                        <div class="w-ball">
                        </div>
                    </div>
                    <div class="w-ball-wrapper ball-4">
                        <div class="w-ball">
                        </div>
                    </div>
                    <div class="w-ball-wrapper ball-5">
                        <div class=" w-ball">
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif($result == 5): ?>
            <div class="preloader-5">
                <?php
                if ($apr_logo_preload && $apr_logo_preload!=''):
                    echo '<img class="logo-preload" src="' . esc_url(str_replace(array('http:', 'https:'), '', $apr_logo_preload)) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
                else:
                    bloginfo('name');
                endif;
                ?>
                <div class="loader"></div>
            </div>
        <?php elseif($result == 6): ?>
            <div id="loading-6">
                <div id="loading-center-6">
                    <div id="loading-center-absolute-6">
                        <div class="object-6" id="first_object_6"></div>
                        <div class="object-6" id="second_object_6"></div>
                        <div class="object-6" id="third_object_6"></div>
                        <div class="object-6" id="forth_object_6"></div>
                    </div>
                </div>
            </div>
        <?php elseif($result == 7): ?>
            <div id="loading-7">
                <div id="loading-center-7">
                    <div id="loading-center-absolute-7">
                        <div id="object-7"></div>
                    </div>
                </div>
            </div>
        <?php elseif($result == 9): ?>
            <div id="loading-9">
                <div id="loading-center-9">
                    <div id="loading-center-absolute-9">
                        <div class="object-9"></div>
                        <div class="object-9"></div>
                        <div class="object-9"></div>
                        <div class="object-9"></div>
                        <div class="object-9"></div>
                        <div class="object-9"></div>
                        <div class="object-9"></div>
                        <div class="object-9"></div>
                        <div class="object-9"></div>
                        <div class="object-9"></div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="loader-8">
                <div class="loader-inner pacman">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php
   return ob_get_clean();
    }else{ 
        ?>
        <div class="preloader">
            <div id="pre-loader">
            </div>
        </div>
        <?php
     }
}

//search filter
if ( !is_admin() ) {
    function apr_searchfilter($query) {
        if ($query->is_search && !is_admin() && $query->get( 'post_type' ) != 'kbe_knowledgebase' && $query->get( 'post_type' ) != 'product') {
        $query->set('post_type',array('post','recipe'));
        }
        return $query;
    }
    add_filter('pre_get_posts','apr_searchfilter');
}
//back to top
add_action( 'wp_footer', 'apr_back_to_top' );
function apr_back_to_top() {
echo '<a class="scroll-to-top"><i class="fa fa-angle-up"></i></a>';
}
add_action( 'wp_footer', 'apr_overlay' );
function apr_overlay() {
echo '<div class="overlay"></div>';
}
function apr_get_post_media(){ 
    global $apr_settings;
    $apr_sidebar_left = apr_get_sidebar_left();
    $apr_sidebar_right = apr_get_sidebar_right();
    $gallery = get_post_meta(get_the_ID(), 'images_gallery', true);
	$apr_single_post_layout = get_post_meta(get_the_ID(), 'single-post-layout-version', true);
    $layout_version = isset($apr_settings['single-post-layout-version']) ? $apr_settings['single-post-layout-version'] : '';
	$apr_single_post_layout = ($apr_single_post_layout == 'default' || !$apr_single_post_layout) ? $layout_version : $apr_single_post_layout;
    $apr_post_layout = isset($apr_settings['post-layout-version']) ? $apr_settings['post-layout-version'] :'';
    $apr_list_style = isset($apr_settings['post-list-style']) ? $apr_settings['post-list-style'] :'list_s1';   
    $attachment_id = get_post_thumbnail_id();
    if (is_category()){
        $category = get_category( get_query_var( 'cat' ) );
        $cat_id = $category->cat_ID;
        if(get_metadata('category', $cat_id, 'blog_layout', true) != 'default'){
            $apr_post_layout = get_metadata('category', $cat_id, 'blog_layout', true);    
        }
        if(get_metadata('category', $cat_id, 'blog_columns', true) != 'default'){
            $apr_post_columns = get_metadata('category', $cat_id, 'blog_columns', true);  
        }
        if(get_metadata('category', $cat_id, 'blog_list_style', true) != 'default'){
            $apr_list_style = get_metadata('category', $cat_id, 'blog_list_style', true);
        }
    }    
    $image_grid = apr_get_attachment($attachment_id, 'apr_blog_grid'); 
   
    $image_full = apr_get_attachment($attachment_id, 'full'); 
    if($apr_list_style == "list_s3" && $apr_post_layout == 'list'){
        $image_list_full = apr_get_attachment($attachment_id, 'apr_blog_list_3');
        $image_list = apr_get_attachment($attachment_id, 'apr_blog_list_3'); 
    }elseif($apr_post_layout == 'masonry'){
        $tile_sizes = array('apr_blog_masonry','apr_blog_masonry2','apr_blog_masonry1');
        $random_size = rand(0,2);
        $chosen_size = $tile_sizes[$random_size];
        $image_full = apr_get_attachment($attachment_id, $chosen_size); 
        
    }else{
        $image_list = apr_get_attachment($attachment_id, 'apr_blog_list'); 
        $image_list_full = apr_get_attachment($attachment_id, 'apr_blog_fullwidth');
    }    
    $image_detail = apr_get_attachment($attachment_id, 'apr_blog_detail');    
    $image_detail_2 = apr_get_attachment($attachment_id, 'apr_blog_detail_2');    
    ?> 
    <?php if ( get_post_format() == 'video' ||  get_post_format() == 'audio') : ?>
        <?php $video = get_post_meta(get_the_ID(), 'video_code', true); ?>
            <?php if ($video && $video != ''): ?>
                <div class="align_left blog-media">
                    <div class="blog-video">

                            <?php if(get_post_format() == 'video'){
                                echo '<div class="iframe_video_container">';
                            }
                            ?>                    
                                <?php if (strpos($video,'iframe') !== false):?>
                                    <?php echo wp_kses($video,array(
                                      'iframe' => array(
                                        'height' => array(),
                                        'frameborder' => array(),
                                        'style' => array(),
                                        'src' => array(),
                                        'allowfullscreen' => array(),
                                        )
                                    )); ?>                            
                                <?php else: ?>
                                    <iframe src="<?php echo esc_url(is_ssl() ? str_replace( 'http://', 'https://', $video ) : $video); ?> " width="100%" <?php if(get_post_format() == 'video'){echo 'height="400"';}?>></iframe>
                                <?php endif;?>
                            <?php if(get_post_format() == 'video'){
                                echo '</div>';
                            }
                            ?>                 
                    </div>
                </div>
        <?php endif; ?>
    <?php elseif(has_post_format('gallery')): ?>
        <?php if (is_array($gallery) && count($gallery) > 1) : ?>   
            <?php if(is_singular()):?>
                <div class="blog-gallery blog-media arrows-custom"> 
                    <?php
                    $index = 0;
                    foreach ($gallery as $key => $value) :
                        $image_detail = wp_get_attachment_image_src($value, 'apr_blog_detail');
                        $alt = get_post_meta($value, '_wp_attachment_image_alt', true);
                            echo '<div class="img-gallery">
                                <div class="blog-img">
                                    <img src="' . esc_url($image_detail[0]) . '" alt="gallery-blog" class="gallery-img" />
                                </div>
                            </div>';
                        $index++;
                    endforeach;
                    ?>
                </div> 
            <?php else: ?>   
                <div class="blog-gallery blog-media align_left arrows-custom"> 
                    <?php
                    $index = 0;
                    foreach ($gallery as $key => $value) :
                        $image_grid = wp_get_attachment_image_src($value, 'apr_blog_grid');
                        $image_detail = wp_get_attachment_image_src($value, 'apr_blog_detail');                       
                        if($apr_list_style == "list_s3"){
                            $image_list_full = wp_get_attachment_image_src($value, 'apr_blog_list_3');
                             $image_list = wp_get_attachment_image_src($value, 'apr_blog_list_3');
                        }else{
                            $image_list_full = wp_get_attachment_image_src($value, 'apr_blog_fullwidth');
                             $image_list = wp_get_attachment_image_src($value, 'apr_blog_list');
                        }
                       
                        $alt = get_post_meta($value, '_wp_attachment_image_alt', true);
                        if ($apr_post_layout == "list"){
							if(($apr_sidebar_left == 'none') || ($apr_sidebar_right == 'none')){
								echo '<div class="img-gallery">
									<div class="blog-img">
										<a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="' . esc_url($image_detail[0]) . '"><img src="' . esc_url($image_list_full[0]) . '" alt="gallery-blog" class="gallery-img" /></a>
									</div>
								</div>';
							}else{
								echo '<div class="img-gallery">
									<div class="blog-img">
										<a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="' . esc_url($image_detail[0]) . '"><img src="' . esc_url($image_list[0]) . '" alt="gallery-blog" class="gallery-img" /></a>
									</div>
								</div>';
							}
                        }else{
                            echo '<div class="img-gallery">
                                <div class="blog-img">
                                    <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="' . esc_url($image_detail[0]) . '"><img src="' . esc_url($image_grid[0]) . '" alt="gallery-blog" class="gallery-img" /></a>
                                </div>
                            </div>';
                        }
                        
                        $index++;
                    endforeach;
                    ?>
                </div>
            <?php endif; ?> 
        <?php else: ?>
            <?php if (has_post_thumbnail()): ?>
               <div class="blog-img blog-media">
                    <?php if ($apr_post_layout == "list"): ?>
						<?php if(($apr_sidebar_left == 'none') || ($apr_sidebar_right == 'none')): ?>
							<a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($image_detail['src']) ?>"><img width="<?php echo esc_attr($image_list['width']) ?>" height="<?php echo esc_attr($image_list_full['height']) ?>" src="<?php echo esc_url($image_list_full['src']) ?>" alt="<?php echo esc_attr($image_list_full['alt']) ?>" /></a>
						<?php else: ?>
							<a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($image_detail['src']) ?>"><img width="<?php echo esc_attr($image_list_full['width']) ?>" height="<?php echo esc_attr($image_list['height']) ?>" src="<?php echo esc_url($image_list['src']) ?>" alt="<?php echo esc_attr($image_list['alt']) ?>" /></a>
						<?php endif;?>
					<?php elseif($apr_post_layout == "masonry")  :?>
                        <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($image_detail['src']) ?>"><img width="<?php echo esc_attr($image_full['width']) ?>" height="<?php echo esc_attr($image_full['height']) ?>" src="<?php echo esc_url($image_full['src']) ?>" alt="<?php echo esc_attr($image_full['alt']) ?>" /></a>
                    <?php else:?>
                        <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($image_detail['src']) ?>"><img width="<?php echo esc_attr($image_grid['width']) ?>" height="<?php echo esc_attr($image_grid['height']) ?>" src="<?php echo esc_url($image_grid['src']) ?>" alt="<?php echo esc_attr($image_grid['alt']) ?>" /></a>                        
                    <?php endif;?>
                </div> 
            <?php endif;?>
        <?php endif; ?>
    <?php elseif(has_post_format('link')):?>
        <?php 
            $link = get_post_meta(get_the_ID(), 'link_code', true); 
            $link_title = get_post_meta(get_the_ID(), 'link_title', true);
        ?>
        <?php if(is_singular()):?>
            <?php if($link && $link != ''):?>
                <div class="blog-media">
                    <figure>
                        <a class="post_link" href="<?php echo esc_url(is_ssl() ? str_replace( 'http://', 'https://', $link ) : $link);?>">
                            <i class="pe-7s-link"></i>
                            <?php if($link_title && $link_title != ''):?>
                                <span><?php echo wp_kses($link_title,array());?></span>
                            <?php endif;?> 
                        </a>
                    </figure>
                </div>
            <?php endif;?> 
        <?php else: ?>
            <?php if ($apr_post_layout == "grid"): ?>
                <div class="blog-img blog-media">
                    <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($image_detail['src']) ?>"><img width="<?php echo esc_attr($image_grid['width']) ?>" height="<?php echo esc_attr($image_grid['height']) ?>" src="<?php echo esc_url($image_grid['src']) ?>" alt="<?php echo esc_attr($image_grid['alt']) ?>" /></a>      
                </div>
            <?php else: ?>
                <?php if($link && $link != ''):?>
                    <div class="blog-media">
                        <figure>
                            <a class="post_link" href="<?php echo esc_url(is_ssl() ? str_replace( 'http://', 'https://', $link ) : $link);?>">
                                <i class="pe-7s-link"></i>
                                <?php if($link_title && $link_title != ''):?>
                                    <span><?php echo wp_kses($link_title,array());?></span>
                                <?php endif;?> 
                            </a>
                        </figure>
                    </div>
                <?php endif;?>
            <?php endif; ?>  
        <?php endif; ?>  
    <?php elseif(has_post_format('quote')):?>
        <?php 
            $quote = get_post_meta(get_the_ID(), 'quote_code', true); 
            $quote_author = get_post_meta(get_the_ID(), 'quote_author', true); 
        ?>
        <?php if(is_singular()):?>

            <div class="blog-img blog-media">
                <img width="<?php echo esc_attr($image_detail['width']) ?>" height="<?php echo esc_attr($image_detail['height']) ?>" src="<?php echo esc_url($image_detail['src']) ?>" alt="<?php echo esc_attr($image_detail['alt']) ?>" />
            </div>
            <?php if($quote && $quote != ''):?>
                <figure>
                    <div class="quote_section">
                        <blockquote class="var3">
                            <?php echo wp_kses($quote,array());?>
                        </blockquote>
                        <?php if($quote_author && $quote_author != ''):?>
                            <div class="author_info">- <?php echo  wp_kses($quote_author,array());?></div>
                        <?php endif;?> 
                    </div>
                </figure>
            <?php endif;?>  
        <?php else: ?>
            <?php if ($apr_post_layout == "grid"): ?>
                <div class="blog-img blog-media">
                    <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($image_detail['src']) ?>"><img width="<?php echo esc_attr($image_grid['width']) ?>" height="<?php echo esc_attr($image_grid['height']) ?>" src="<?php echo esc_url($image_grid['src']) ?>" alt="<?php echo esc_attr($image_grid['alt']) ?>" /></a>      
                </div>
            <?php else: ?>
                <?php if($quote && $quote != ''):?>
                    <figure class="blog-media">
                        <div class="quote_section">
                            <blockquote class="var3">
                                <?php echo wp_kses($quote,array());?>
                            </blockquote>
                            <?php if($quote_author && $quote_author != ''):?>
                                <div class="author_info">- <?php echo  wp_kses($quote_author,array());?></div>
                            <?php endif;?> 
                        </div>
                    </figure>
                <?php endif;?>  
            <?php endif; ?>  
        <?php endif; ?>  
    <?php else: ?>
        <?php if (has_post_thumbnail()): ?>
             <?php if(is_singular()):?>
                <div class="blog-img blog-media">
                    <?php if ($apr_single_post_layout == "single-4"): ?>
                         <img width="<?php echo esc_attr($image_detail_2['width']) ?>" height="<?php echo esc_attr($image_detail_2['height']) ?>" src="<?php echo esc_url($image_detail_2['src']) ?>" alt="<?php echo esc_attr($image_detail_2['alt']) ?>" />
                    <?php else: ?>
                        <img width="<?php echo esc_attr($image_detail['width']) ?>" height="<?php echo esc_attr($image_detail['height']) ?>" src="<?php echo esc_url($image_detail['src']) ?>" alt="<?php echo esc_attr($image_detail['alt']) ?>" />
                    <?php endif;?>
                </div>
            <?php else: ?>
                <div class="blog-img blog-media">
                    <?php if ($apr_post_layout == "list"): ?>
						<?php if(($apr_sidebar_left == 'none') || ($apr_sidebar_right == 'none')): ?>
							<a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($image_detail['src']) ?>"><img width="<?php echo esc_attr($image_list['width']) ?>" height="<?php echo esc_attr($image_list_full['height']) ?>" src="<?php echo esc_url($image_list_full['src']) ?>" alt="<?php echo esc_attr($image_list_full['alt']) ?>" /></a>
						<?php else: ?>
							<a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($image_detail['src']) ?>"><img width="<?php echo esc_attr($image_list_full['width']) ?>" height="<?php echo esc_attr($image_list['height']) ?>" src="<?php echo esc_url($image_list['src']) ?>" alt="<?php echo esc_attr($image_list['alt']) ?>" /></a>
						<?php endif;?>
                    <?php elseif($apr_post_layout == "masonry") :?>
                        <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($image_detail['src']) ?>"><img width="<?php echo esc_attr($image_full['width']) ?>" height="<?php echo esc_attr($image_full['height']) ?>" src="<?php echo esc_url($image_full['src']) ?>" alt="<?php echo esc_attr($image_full['alt']) ?>" /></a>  
                    <?php elseif(($apr_sidebar_right =="none" && $apr_post_layout == "list") || ($apr_sidebar_left =="none" && $apr_post_layout == "list")):?>
                          <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($image_detail['src']) ?>"><img width="<?php echo esc_attr($image_list_full['width']) ?>" height="<?php echo esc_attr($image_list_full['height']) ?>" src="<?php echo esc_url($image_list_full['src']) ?>" alt="<?php echo esc_attr($image_list_full['alt']) ?>" /></a>                 
                    <?php else :?>
                        <a class="fancybox-thumb" data-fancybox-group="fancybox-thumb" href="<?php echo esc_url($image_detail['src']) ?>"><img width="<?php echo esc_attr($image_grid['width']) ?>" height="<?php echo esc_attr($image_grid['height']) ?>" src="<?php echo esc_url($image_grid['src']) ?>" alt="<?php echo esc_attr($image_grid['alt']) ?>" /></a>    
                    <?php endif;?>
                </div>
            <?php endif;?>
        <?php endif;?>
    <?php endif; 
}
function apr_get_share_link(){
    global $apr_settings;
    if (isset($apr_settings['post-share']) && is_array($apr_settings['post-share']) &&
        (
            in_array('facebook', $apr_settings['post-share'])||
            in_array('twitter', $apr_settings['post-share'])||
            in_array('pin', $apr_settings['post-share'])||
            in_array('insta', $apr_settings['post-share'])
    ) ) : ?>
        <div class="share-links">
            <div class="addthis_sharing_toolbox">
                <span class="lab"><?php echo esc_html__('Share', 'barber');?></span>
                <div class="f-social">

                    <ul>
                        <?php if (isset($apr_settings['post-share']) && in_array('facebook', $apr_settings['post-share'])) : ?>
                            <li><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_the_permalink()); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <?php endif;?>
                        <?php if (isset($apr_settings['post-share']) && in_array('twitter', $apr_settings['post-share'])) : ?>
                            <li><a href="https://twitter.com/share?url=<?php echo urlencode(get_the_permalink()); ?>&amp;text=<?php echo urlencode(get_the_title()); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li> 
                        <?php endif;?>  
                        <?php if (isset($apr_settings['post-share']) && in_array('pin', $apr_settings['post-share'])) : ?>                  
                            <li>
                                <a href="https://pinterest.com/share?url=<?php echo urlencode(get_the_permalink()); ?>" target="_blank">
                                    <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                                </a>
                            </li>
                        <?php endif;?>
                        <?php if (isset($apr_settings['post-share']) && in_array('insta', $apr_settings['post-share'])) : ?>
                            <li><a href="http://www.instagram.com/?url=<?php echo urlencode(get_the_permalink()); ?>&amp;title=<?php echo urlencode(get_the_title()); ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
        </div>  
    <?php endif;   
}
function apr_gallery_posts_per_page( $query ) {
    global $apr_settings,$wp_query;
    $apr_gallery_per_page = isset($apr_settings['gallery_per_page']) ? $apr_settings['gallery_per_page'] :'12';
    if (is_tax('gallery_cat')){
        $cat = $wp_query->get_queried_object();
        if(get_metadata('gallery_cat', $cat->term_id, 'gallery_per_page', true)  != 'default'){
            $apr_gallery_per_page = get_metadata('gallery_cat', $cat->term_id, 'gallery_per_page', true);    
        }
    }
    if(isset($apr_gallery_per_page) && $apr_gallery_per_page != ''){
          if ( !is_admin() && $query->is_main_query() && (is_post_type_archive( 'gallery' ) || is_tax('gallery_cat') )) {
            $query->set( 'posts_per_page', $apr_gallery_per_page );
          }
    }else{
        if ( !is_admin() && $query->is_main_query() && (is_post_type_archive( 'gallery' ) || is_tax('gallery_cat') )) {
            $query->set( 'posts_per_page',  '8');
        }
    }
}
add_action( 'pre_get_posts', 'apr_gallery_posts_per_page' );
function apr_posts_per_page( $query ) {
    global $apr_settings;
    $apr_post_layout = isset($apr_settings['post-layout-version']) ? $apr_settings['post-layout-version'] :'';   

    if(isset($apr_settings['post_per_page']) && $apr_settings['post_per_page'] != '' && $apr_post_layout == 'masonry'){
          if ( !is_admin() && $query->is_main_query() && (is_category() || is_tag() || is_home())) {
            $query->set( 'posts_per_page', $apr_settings['post_per_page'] );
          }
    }
}
add_action( 'pre_get_posts', 'apr_posts_per_page' );

function apr_set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
function apr_get_attachment( $attachment_id, $size = 'full' ) {
    if (!$attachment_id)
        return false;
    $attachment = get_post( $attachment_id );
    $image = wp_get_attachment_image_src($attachment_id, $size);

    if (!$attachment)
        return false;

    return array(
        'alt' => esc_attr(get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true )),
        'caption' => esc_attr($attachment->post_excerpt),
        'description' => force_balance_tags($attachment->post_content),
        'href' => get_permalink( $attachment->ID ),
        'src' => esc_url($image[0]),
        'title' => esc_attr($attachment->post_title),
        'width' => esc_attr($image[1]),
        'height' => esc_attr($image[2])
    );
}
function get_image( $size = 'apr_product_thumbnail', $attr = array() ) {
    if ( has_post_thumbnail( $this->id ) ) {
      $image = get_the_post_thumbnail( $this->id, $size, $attr );
    } elseif ( ( $parent_id = wp_get_post_parent_id( $this->id ) ) && has_post_thumbnail( $parent_id ) ) {
      $image = get_the_post_thumbnail( $parent_id, $size, $attr );
    } else {
      $image = wc_placeholder_img( $size );
    }
    return $image;
}
function apr_pagination($max_num_pages = null) {
    global $wp_query, $wp_rewrite;

    $max_num_pages = ($max_num_pages) ? $max_num_pages : $wp_query->max_num_pages;

    if ($max_num_pages < 2) {
        return;
    }

    $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
    $pagenum_link = html_entity_decode(get_pagenum_link());
    $query_args = array();
    $url_parts = explode('?', $pagenum_link);

    if (isset($url_parts[1])) {
        wp_parse_str($url_parts[1], $query_args);
    }

    $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
    $pagenum_link = trailingslashit($pagenum_link) . '%_%';

    $format = $wp_rewrite->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
    $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') : '?paged=%#%';

    // Set up paginated links.
    $links = paginate_links(array(
        'base' => $pagenum_link,
        'format' => $format,
        'total' => $max_num_pages,
        'current' => $paged,
        'end_size' => 1,
        'mid_size' => 1,
        'prev_next' => True,
        'prev_text' => '<i class="fa fa-long-arrow-left"></i>',
        'next_text' => '<i class="fa fa-long-arrow-right"></i>',
        'type' => 'list'
            ));

    if ($links) :
        ?>
        <div class="pagination-content">
            <nav class="pagination">
                <?php echo wp_kses($links, apr_allow_html()); ?>        
            </nav>
        </div>
        <?php
    endif;
}
function apr_get_banner_block(){
    global $post, $apr_settings,$wp_query;
    $cat = $wp_query->get_queried_object();
    $static = ""; 
    if(!is_404()  && !is_search() && (get_post_meta($post->ID,'block_bottom',true) != 'default')){
        $static = get_post_meta($post->ID,'block_bottom',true) != "" ? get_post_meta($post->ID,'block_bottom',true) :"";
    }
    if(is_category()){
        $block_bottom = get_metadata('category', $cat->term_id, 'block_bottom', true);
        if(isset($block_bottom) && $block_bottom != 'default' && $block_bottom != '' && $block_bottom !='none'){
            $static = get_metadata('category', $cat->term_id, 'block_bottom', true);
        }      
    }
    if($static != ''){      
        $block = get_post($static);
        $post_content = $block->post_content;
        $hide_static = apr_get_meta_value('hide_static', true);
        echo apply_filters('the_content', get_post_field('post_content', $static));
    }
}
function apr_get_excerpt($limit = 45) {

    if (!$limit) {
        $limit = 45;
    }

    $allowed_html =array(
        'a' => array(
            'href' => array(),
            'title' => array()
        ),
        'ul' => array(),
        'li'  => array(),
        'ol'  => array(),
        'iframe' => array(
            'src' => true,
            'width' => true,
            'height' => true,
            'align' => true,
            'class' => true,
            'name' => true,
            'id' => true,
            'frameborder' => true,
            'seamless' => true,
            'srcdoc' => true,
            'sandbox' => true,
            'allowfullscreen' => true
        ),
        'blockquote'  => array(),
        'embed' => array(
                'width' => array(),
                'height' => array(),
                ),
        'br' => array(),
        'img' => array(
            'alt' => array(),
            'src' => array(),
            'width' => array(),
            'height' =>array(), 
            'id' => array(),
            'style' => array(),
            'class' => array(),
            ),
        'audio' => array(
            'src' => true,
            'width' => true,
            'height' => true,
            'align' => true,
            'class' => true,
            'name' => true,
            'id' => true,
            'preload' => true,
            'style' => true,
            'controls' => true,
        ),
        'source' => array(
            'src' => true,
            'width' => true,
            'height' => true,
            'align' => true,
            'class' => true,
            'name' => true,
            'id' => true,
            'type' => true,
        ),
        'p'  => array(
            'style' => true,
            'class' => true,
            'id' => true,),
        'em' => array(),
        'strong' => array(),
    );

    if (has_excerpt()) {
        $content =  wp_kses(strip_shortcodes(get_the_excerpt()), $allowed_html) ;
    } else {
        $content = get_the_content( );
        $content = apply_filters( 'the_content', $content );
        $content = str_replace( ']]>', ']]&gt;', $content );
        $content =  wp_kses(strip_shortcodes($content), $allowed_html) ;
    }

    $content = explode(' ', $content, $limit);

    if (count($content) >= $limit) {
        array_pop($content);
            $content = implode(" ",$content).'<a href="'.get_the_permalink().'" class="blog-readmore"><i class="fa fa-caret-right"></i>&nbsp;'.esc_html__(' Read More', 'barber').'</a>';
    } else {
        $content = implode(" ",$content);
    }

    return $content;
}
function apr_latest_tweets_date( $created_at ){
   $date = DateTime::createFromFormat('D M d H:i:s O Y', $created_at ); 
    return sprintf( '%s ' . esc_html__( 'ago', 'barber' ), human_time_diff( $date->format('U') ) );
}
function apr_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;

    return $fields;
}
add_filter( 'comment_form_fields', 'apr_move_comment_field_to_bottom' );

function apr_comment_nav() {
    if (get_comment_pages_count() > 1 && get_option('page_comments')) :
        ?>
        <nav class="navigation comment-navigation" role="navigation">
            <div class="comment-nav-links">
        <?php
        if ($prev_link = get_previous_comments_link(__('Older', 'barber'))) :
            printf('<div class="comment-nav-previous">%s</div>', $prev_link);
        endif;

        if ($next_link = get_next_comments_link(__('Newer', 'barber'))) :
            printf('<div class="comment-nav-next">%s</div>', $next_link);
        endif;
        ?>
            </div>
        </nav>
        <?php
    endif;
}
function apr_comment_body_template($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ('div' == $args['style']) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo esc_html($tag) ?> <?php comment_class(empty($args['has_children']) ? 'profile-content ' : 'parent profile-content' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ('div' != $args['style']) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
        <?php if(get_avatar($comment, $args['avatar_size']) != ''):?>
            <div class="comment-author vcard profile-top">
                <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['avatar_size']); ?>    
            </div>
        <?php endif;?>
            <div class="profile-bottom">
                <?php if ($comment->comment_approved == '0') : ?>
                    <em class="comment-awaiting-moderation"><?php echo esc_html__('Your comment is awaiting moderation.', 'barber'); ?></em>
                    <br />
                <?php endif; ?>
                <div class="comment-bottom ">
                        <div class="info-content">
                            <div class="profile-name"><?php printf(esc_html__('%s','barber'), get_comment_author_link()); ?>
                            </div>
                             <div class="date-cmt">
                                <span><?php
                                  $d = "jS M.";
                                printf(esc_html__('%1$s', 'barber'), get_comment_date($d));
                                ?></span>
                            </div>
                        </div>
                        <div class="profile-desc">
                            <?php comment_text(); ?>
                        </div>
                        <div class="info-right ">
                            <div class="links-info">
                                <?php if($depth<$args['max_depth']): ?>
                                <div class="info">
                                    <?php comment_reply_link(array_merge($args, array('reply_text'=>'<i class="fa fa-reply"></i>'.esc_html__('', 'barber'),'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                </div>
                <?php if ('div' != $args['style']) : ?>
                    </div>
                <?php endif; ?>
            </div>
                <?php

}
add_filter('comment_reply_link', 'apr_reply_link_class');
function apr_reply_link_class($apr_class){
    $apr_class = str_replace("class='comment-reply-link", "class='", $apr_class);
    return $apr_class;
}

add_action( 'comment_form', 'apr_comment_submit' );
function apr_comment_submit( $post_id ) {
    if (get_post_type() !== 'product'){
        echo '<div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="comment-submit">
                        <button type="submit" class="submit btn btn-primary btn-icon" > '.esc_html__('Submit', 'barber').'<i class="fa fa-long-arrow-right"></i> 
                        </button>    
                    </div>
                </div>';
        }
}


add_filter('latest_tweets_render_date', 'apr_latest_tweets_date', 10 , 1 );
//allow html in widget title
function apr_change_widget_title($title)
{
    //convert square brackets to angle brackets
    $title = str_replace('[', '<', $title);
    $title = str_replace(']', '>', $title);

    //strip tags other than the allowed set
    $title = strip_tags($title, '<a><blink><br><span>');
    return $title;
}
add_filter('widget_title', 'apr_change_widget_title');
function apr_custom_excerpt_length( $length ) {
    return 50;
}
add_filter( 'excerpt_length', 'apr_custom_excerpt_length', 999 );

if( ! function_exists( 'apr_pages_ids_from_template' ) ) {
    function apr_pages_ids_from_template( $name ) {
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => $name . '.php'
        ));

        $return = array();

        foreach($pages as $page){
            $return[] = $page->ID;
        }

        return $return;
    }
}
 function apr_coming_soon_mode() { 
    global $apr_settings;
    if(isset($apr_settings['coming_soon_mode']) && $apr_settings['coming_soon_mode'] ==1){
        $page_id = apr_pages_ids_from_template( 'coming-soon' );

        $page_id = current($page_id);

        if( ! $page_id ) return;
       
        if (!current_user_can('edit_themes') || (! is_page( $page_id ) && !is_user_logged_in())) { 
            wp_redirect(get_permalink( $page_id ), 301); exit; 
        } 
    }
}

add_filter('wp_list_categories', 'apr_cat_count_span');
function apr_cat_count_span($links) {
    $links = str_replace('</a> (', '<span> (', $links);
    $links = str_replace(')', ')</span></a>', $links);
    return $links;
}


function apr_allow_html(){
    return array(
        'form'=>array(
            'role' => array(),
            'method'=> array(),
            'class'=> array(),
            'action'=>array(),
            'id'=>array(),
            ),
        'input' => array(
            'type' => array(),
            'name'=> array(),
            'class'=> array(),
            'title'=>array(),
            'id'=>array(), 
            'value'=> array(), 
            'placeholder'=>array(), 
            'autocomplete' => array(),
            'data-number' => array(),
            'data-keypress' => array(),                        
            ),
        'button' => array(
            'type' => array(),
            'name'=> array(),
            'class'=> array(),
            'title'=>array(),
            'id'=>array(),                            
            ),                        
        'div'=>array(
            'class'=> array(),
            ),
        'h4'=>array(
            'class'=> array(),
            ),
        'a'=>array(
            'class'=> array(),
            'href'=>array(),
            'onclick' => array(),
            'aria-expanded' => array(),
            'aria-haspopup' => array(),
            'data-toggle' => array(),
            ),
        'i' => array(
            'class'=> array(),
        ),
        'p' => array(
            'class'=> array(),
        ), 
        'span' => array(
            'class'=> array(),
            'onclick' => array(),
            'style' => array(),
        ), 
        'strong' => array(
            'class'=> array(),
        ),  
        'ul' => array(
            'class'=> array(),
        ),  
        'li' => array(
            'class'=> array(),
        ), 
        'del' => array(),
        'ins' => array(),

    );
}
function apr_get_page_slider() {
    global $wp_query, $header_type;
    $cat = $wp_query->get_queried_object();
    $show_slider = get_post_meta(get_the_ID(), 'show_slider', true);
    $slider_category = get_post_meta(get_the_ID(), 'category_slider', true);
    $output = '';
    ob_start();
    ?>
    <?php if($show_slider) :?>
        <div class="main-slider">
          <?php echo do_shortcode( '[rev_slider alias=' . $slider_category . ']' ); ?>
        </div>
    <?php endif;?>
    <?php
    $output .= ob_get_clean();
    echo $output;
}
?>
