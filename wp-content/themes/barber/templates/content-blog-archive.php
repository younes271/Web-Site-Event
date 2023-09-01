<?php 
    $apr_settings = apr_check_theme_options();
    $apr_post_layout = isset($apr_settings['post-layout-version']) ? $apr_settings['post-layout-version'] :'';
    $apr_post_columns = isset($apr_settings['post-layout-columns']) ? $apr_settings['post-layout-columns'] :'';
    $apr_list_style = isset($apr_settings['post-list-style']) ? $apr_settings['post-list-style'] :'list_s1';    
    $apr_post_pagination = isset($apr_settings['post_pagination']) ? $apr_settings['post_pagination'] :'';   
    $apr_post_desc = isset($apr_settings['post_desc']) ? $apr_settings['post_desc'] :'';   
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
        if(get_metadata('category', $cat_id, 'post_pagination', true) != 'default'){
            $apr_post_pagination = get_metadata('category', $cat_id, 'post_pagination', true);
        }  
        if(get_metadata('category', $cat_id, 'post_desc', true) != 'default'){
            $apr_post_desc = get_metadata('category', $cat_id, 'post_desc', true);
        }                 
    }
    $apr_skin = get_post_meta(get_the_ID(),'skin',true);
	$apr_class = '';
	$apr_class_columns = '';
	
	if($apr_post_layout == 'masonry'){
		$apr_class = ' blog-masonry';
		$apr_list_style = '';
	}else if($apr_post_layout == 'list'){
		$apr_class = ' blog-list';
		$apr_post_columns = '1';
	}else{
		$apr_class = ' blog-grid';
		$apr_list_style = '';
	}
	if($apr_post_desc =='2' && $apr_post_layout != 'list' && $apr_post_layout !='grid'){
		$apr_class .= ' display_desc';
	}
	if($apr_post_columns == '1'){
		$apr_class_columns = 'col-md-12 col-sm-12 col-xs-12';
	}else if($apr_post_columns == '2'){
		$apr_class_columns = 'col-md-6 col-sm-6 col-xs-12';
	}else if($apr_post_columns == '4'){
		$apr_class_columns = 'col-md-3 col-sm-6 col-xs-12';
	}else{
		$apr_class_columns = 'col-md-4 col-sm-6 col-xs-12';
	}	
    $current_page = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
?>
<div class="row blog-entries-wrap grid-isotope <?php echo esc_attr($apr_class).' '.esc_attr($apr_list_style); ?>">
	<?php while (have_posts()) : the_post(); ?>
		<div class="grid-item <?php echo esc_attr($apr_class_columns); ?>">
			<div class="blog-content">
				<div class="blog-item">
					<?php if($apr_list_style == 'list_s3'):?>
						<?php if(get_the_title() != ''):?>
							<div class="blog-post-title">
								<div class="post-name">
								    <a href="<?php the_permalink(); ?>"><?php the_title(); ?>
										<?php  if ( is_sticky() && is_home() && ! is_paged() ):?>
										 <span class="sticky_post"><?php echo esc_html__('Featured', 'barber')?></span>
										<?php endif;?>          
									</a>                                     
								</div>					
							</div>
						<?php endif;?>
						<?php if (isset($apr_settings['post-meta']) && in_array('date', $apr_settings['post-meta'])) : ?>
							<?php if ($apr_list_style == 'list_s2'): ?>
								<div class="info blog-date ">
									<p class="date">
										<i class="fa fa-calendar" aria-hidden="true"></i>
										<a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a>
									</p>
								</div>
							 <?php else:?>
								<div class="info blog-date ">
									<p class="date"><a href="<?php the_permalink(); ?>"><?php echo get_the_time('d'); ?></a></p>
			                    	<p class="month"><a href="<?php the_permalink(); ?>"><?php echo get_the_time('M'); ?></a></p>
								</div>
							<?php endif;?>
						<?php endif;?>
						<?php apr_get_post_media(); ?>
						<div class="blog-post-info">
							<?php if ($apr_post_layout == "list" || $apr_post_layout == "grid"): ?>
								<div class="blog_post_desc">
									<?php 
									if (get_post_meta(get_the_ID(),'highlight',true) != "") : ?>                            
										<p><?php echo get_post_meta(get_the_ID(),'highlight',true);?></p>
									<?php else:?>
										<?php
										echo '<div class="entry-content">';
										the_content();
										wp_link_pages( array(
											'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'barber' ) . '</span>',
											'after'       => '</div>',
											'link_before' => '<span>',
											'link_after'  => '</span>',
											'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'barber' ) . ' </span>%',
											'separator'   => '<span class="screen-reader-text">, </span>',
										) );
										echo '</div>';
										?>
									<?php endif; ?>
								</div>
							<?php elseif($apr_post_desc == '2'):?>
								<div class="blog_post_desc">
									<?php 
									if (get_post_meta(get_the_ID(),'highlight',true) != "") : ?>                            
										<p><?php echo get_post_meta(get_the_ID(),'highlight',true);?></p>
									<?php endif; ?>
								</div>
							<?php endif;?>						
							<div class="blog-info">
								
								<?php if (isset($apr_settings['post-meta']) && in_array('author', $apr_settings['post-meta'])) : ?>
								<?php $apr_author_id= $post->post_author;?>
									<div class="info author">
										<i class="fa fa-user" aria-hidden="true"></i>
										<span><?php echo esc_html__('By','barber');?></span>
										<a href="<?php echo esc_url(get_edit_user_link( $apr_author_id )); ?>"><?php the_author_meta( 'nickname' , $apr_author_id ); ?></a>
									</div>	
								<?php endif;?>
								<?php if (isset($apr_settings['post-meta']) && in_array('cat', $apr_settings['post-meta'])) : ?>					
									<div class="info info-cat">
										<?php echo get_the_term_list($post->ID,'category', '<i class="fa fa-folder-o"></i> ', ',  ' ); ?>
									</div>
								<?php endif;?>							
								<?php if (isset($apr_settings['post-meta']) && in_array('comment', $apr_settings['post-meta'])) : ?>							
									<div class="info info-comment"> 
										<i class="fa fa-comment-o" aria-hidden="true"></i>
										<?php comments_popup_link(esc_html__('0', 'barber'), esc_html__('1', 'barber'), esc_html__('%', 'barber')); ?>
									</div>	
								<?php endif;?>
								<?php if (isset($apr_settings['post-meta']) && in_array('like', $apr_settings['post-meta'])) : ?>
									<div class="info info-like">
										<?php  if(function_exists('apr_getPostLikeLink')) {
										echo apr_getPostLikeLink( get_the_ID() );
										}
										?>
									</div>	
								<?php endif;?>	
								<?php if (isset($apr_settings['post-meta']) && in_array('tag', $apr_settings['post-meta'])) : ?>
									<div class="info info-tag">
										<?php echo get_the_tag_list('<i class="fa fa-tag"></i> ',', ',''); ?>
									</div>
								<?php endif;?>								
							</div>									
						</div>							
					<?php elseif($apr_post_layout == 'masonry'):?>
						<?php apr_get_post_media(); ?>
						<?php if (isset($apr_settings['post-meta2']) && in_array('date', $apr_settings['post-meta2'])) : ?>
							<div class="info blog-date ">
								<p class="date"><a href="<?php the_permalink(); ?>"><?php echo get_the_time('d'); ?></a></p>
		                    	<p class="month"><a href="<?php the_permalink(); ?>"><?php echo get_the_time('M'); ?></a></p>
							</div>
						<?php endif;?>
						<div class="post_desc">
							<?php if(get_the_title() != ''):?>
								<div class="blog-post-title">
									<div class="post-name">
									    <a href="<?php the_permalink(); ?>"><?php the_title(); ?>
											<?php  if ( is_sticky() && is_home() && ! is_paged() ):?>
											 <span class="sticky_post"><?php echo esc_html__('Featured', 'barber')?></span>
											<?php endif;?>          
										</a>                                     
									</div>					
								</div>
							<?php endif;?>												
							<div class="blog-post-info">
								<div class="blog-info">
									<?php if (isset($apr_settings['post-meta2']) && in_array('author', $apr_settings['post-meta2'])) : ?>
									<?php $apr_author_id= $post->post_author;?>
										<div class="info author">
											<i class="fa fa-user" aria-hidden="true"></i>
											<span><?php echo esc_html__('By','barber');?></span>
											<a href="<?php echo esc_url(get_edit_user_link( $apr_author_id )); ?>"><?php the_author_meta( 'nickname' , $apr_author_id ); ?></a>
										</div>	
									<?php endif;?>
									<?php if (isset($apr_settings['post-meta2']) && in_array('cat', $apr_settings['post-meta2'])) : ?>					
										<div class="info info-cat">
											<?php echo get_the_term_list($post->ID,'category', ' ', ',  ' ); ?>
										</div>
									<?php endif;?>							
									<?php if (isset($apr_settings['post-meta2']) && in_array('comment', $apr_settings['post-meta2'])) : ?>							
										<div class="info info-comment"> 
											<i class="fa fa-comment" aria-hidden="true"></i>
											<?php comments_popup_link(esc_html__('0', 'barber'), esc_html__('1', 'barber'), esc_html__('%', 'barber')); ?>
										</div>	
									<?php endif;?>
									<?php if (isset($apr_settings['post-meta2']) && in_array('like', $apr_settings['post-meta2'])) : ?>
										<div class="info info-like">
											<?php  if(function_exists('apr_getPostLikeLink')) {
											echo apr_getPostLikeLink( get_the_ID() );
											}
											?>
										</div>	
									<?php endif;?>	
									<?php if (isset($apr_settings['post-meta2']) && in_array('tag', $apr_settings['post-meta2'])) : ?>
										<div class="info info-tag">
											<?php echo get_the_tag_list('<i class="fa fa-tag"></i> ',', ',''); ?>
										</div>
									<?php endif;?>								
								</div>									
								
								<?php if ($apr_post_layout == "list" || $apr_post_layout == "grid"): ?>
									<div class="blog_post_desc">
										<?php 
										if (get_post_meta(get_the_ID(),'highlight',true) != "") : ?>                            
											<p><?php echo get_post_meta(get_the_ID(),'highlight',true);?></p>
										<?php else:?>
											<?php
											echo '<div class="entry-content">';
											the_content();
											wp_link_pages( array(
												'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'barber' ) . '</span>',
												'after'       => '</div>',
												'link_before' => '<span>',
												'link_after'  => '</span>',
												'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'barber' ) . ' </span>%',
												'separator'   => '<span class="screen-reader-text">, </span>',
											) );
											echo '</div>';
											?>
										<?php endif; ?>
									</div>
								<?php elseif($apr_post_desc == '2'):?>
									<div class="blog_post_desc">
										<?php 
										if (get_post_meta(get_the_ID(),'highlight',true) != "") : ?>                            
											<p><?php echo get_post_meta(get_the_ID(),'highlight',true);?></p>
										<?php endif; ?>
									</div>
								<?php endif;?>
							</div>	
						</div>						
					<?php else:?>
					<?php apr_get_post_media(); ?>
						<div class="blog-post-info">
							<div class="blog-info">
								<?php if (isset($apr_settings['post-meta']) && in_array('date', $apr_settings['post-meta'])) : ?>
									<?php if ($apr_list_style == 'list_s2'): ?>
										<div class="info blog-date ">
											<p class="date">
												<i class="fa fa-calendar" aria-hidden="true"></i>
												<a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a>
											</p>
										</div>
									 <?php else:?>
										<div class="info blog-date ">
											<p class="date"><a href="<?php the_permalink(); ?>"><?php echo get_the_time('d'); ?></a></p>
					                    	<p class="month"><a href="<?php the_permalink(); ?>"><?php echo get_the_time('M'); ?></a></p>
										</div>
									<?php endif;?>
								<?php endif;?>
								<?php if (isset($apr_settings['post-meta']) && in_array('author', $apr_settings['post-meta'])) : ?>
								<?php $apr_author_id= $post->post_author;?>
									<div class="info author">
										<i class="fa fa-user" aria-hidden="true"></i>
										<span><?php echo esc_html__('By','barber');?></span>
										<a href="<?php echo esc_url(get_edit_user_link( $apr_author_id )); ?>"><?php the_author_meta( 'nickname' , $apr_author_id ); ?></a>
									</div>	
								<?php endif;?>
								<?php if (isset($apr_settings['post-meta']) && in_array('cat', $apr_settings['post-meta'])) : ?>					
									<div class="info info-cat">
										<?php echo get_the_term_list($post->ID,'category', '<i class="fa fa-folder-o"></i> ', ',  ' ); ?>
									</div>
								<?php endif;?>							
								<?php if (isset($apr_settings['post-meta']) && in_array('comment', $apr_settings['post-meta'])) : ?>							
									<div class="info info-comment"> 
										<i class="fa fa-comment-o" aria-hidden="true"></i>
										<?php comments_popup_link(esc_html__('0', 'barber'), esc_html__('1', 'barber'), esc_html__('%', 'barber')); ?>
									</div>	
								<?php endif;?>
								<?php if (isset($apr_settings['post-meta']) && in_array('like', $apr_settings['post-meta'])) : ?>
									<div class="info info-like">
										<?php  if(function_exists('apr_getPostLikeLink')) {
										echo apr_getPostLikeLink( get_the_ID() );
										}
										?>
									</div>	
								<?php endif;?>	
								<?php if (isset($apr_settings['post-meta']) && in_array('tag', $apr_settings['post-meta'])) : ?>
									<div class="info info-tag">
										<?php echo get_the_tag_list('<i class="fa fa-tag"></i> ',', ',''); ?>
									</div>
								<?php endif;?>								
							</div>									
							<?php if(get_the_title() != ''):?>
							<div class="blog-post-title">
								<div class="post-name">
								    <a href="<?php the_permalink(); ?>"><?php the_title(); ?>
										<?php  if ( is_sticky() && is_home() && ! is_paged() ):?>
										 <span class="sticky_post"><?php echo esc_html__('Featured', 'barber')?></span>
										<?php endif;?>          
									</a>                                     
								</div>					
							</div>
							<?php endif;?>
							<?php if ($apr_post_layout == "list" || $apr_post_layout == "grid"): ?>
								<div class="blog_post_desc">
									<?php 
									if (get_post_meta(get_the_ID(),'highlight',true) != "") : ?>                            
										<p><?php echo get_post_meta(get_the_ID(),'highlight',true);?></p>
									<?php else:?>
										<?php
										echo '<div class="entry-content">';
										the_content();
										wp_link_pages( array(
											'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'barber' ) . '</span>',
											'after'       => '</div>',
											'link_before' => '<span>',
											'link_after'  => '</span>',
											'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'barber' ) . ' </span>%',
											'separator'   => '<span class="screen-reader-text">, </span>',
										) );
										echo '</div>';
										?>
									<?php endif; ?>
								</div>
							<?php elseif($apr_post_desc == '2'):?>
								<div class="blog_post_desc">
									<?php 
									if (get_post_meta(get_the_ID(),'highlight',true) != "") : ?>                            
										<p><?php echo get_post_meta(get_the_ID(),'highlight',true);?></p>
									<?php endif; ?>
								</div>
							<?php endif;?>
							<div class="read-more">
								<a href="<?php the_permalink();?>" class="btn btn-primary btn-icon"><?php echo esc_html__('Read more','barber');?><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
							</div>
						</div>	
					<?php endif;?>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
</div>
<?php if($apr_post_pagination =='3'):?>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 animate-top">				
			<div class="text-center">
					<?php apr_pagination(); ?>
			</div>
		</div>
	</div>
<?php elseif($apr_post_pagination =='2'):?>
	<?php if( get_previous_posts_link() ||  get_next_posts_link()):?>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 animate-top ">
				<div class="pagination-content">			
					<ul class="paginationtype-2">
						<?php if( get_previous_posts_link()): ?>
						<li class="pagination_button_prev"><?php previous_posts_link( '<span class="lnr lnr-arrow-left"></span>' ); ?></li>
						<?php endif; ?>	
						<?php if( get_next_posts_link()): ?>
						<li class="pagination_button_next"><?php next_posts_link( '<span class="lnr lnr-arrow-right"></span>'); ?></li>
						<?php endif; ?>	
					</ul>
				</div>
			</div>
		</div>
	<?php endif; ?>	
<?php else:?>
	<?php if ($wp_query->max_num_pages > 1) : ?>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 animate-top">				
				<div class="load-more text-center">
					<a data-paged="<?php echo esc_attr($current_page) ?>" data-totalpage="<?php echo esc_attr($wp_query->max_num_pages) ?>" id="blog-loadmore" class="btn btn-primary"><?php echo esc_html__('Load More', 'barber') ?> </a>
				</div>
			</div>
		</div>						
	<?php endif; ?>
<?php endif;?>

