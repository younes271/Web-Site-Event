<?php 
    $apr_settings = apr_check_theme_options();
	$single_layout = get_post_meta(get_the_ID(), 'single-post-layout-version', true);
	$single_layout = ($single_layout == 'default' || !$single_layout) ? $apr_settings['single-post-layout-version'] : $single_layout;
    if (is_category()){
        $category = get_category( get_query_var( 'cat' ) );
        $cat_id = $category->cat_ID;
        if(get_metadata('category', $cat_id, 'single_blog_layouts', true) != 'default'){
            $post_layout = get_metadata('category', $cat_id, 'single_blog_layouts', true);
        }
    }
?>
<?php if($single_layout == 'single-4'):?>
	<div class="blog post-single single-4">
	    <div class="blog-content">
			<div class="blog-item">
				<?php apr_get_post_media(); ?>
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="blog-post-info">
								<?php if(get_the_title() != ''):?>
									<div class="blog-post-title">
										<div class="post-name">
										    <h3><?php the_title(); ?>
												<?php  if ( is_sticky() && is_home() && ! is_paged() ):?>
												 <span class="sticky_post"><?php echo esc_html__('Featured', 'barber')?></span>
												<?php endif;?>          
											</h3>                                     
										</div>					
									</div>
								<?php endif;?>
								<div class="blog-info">
									<div class="info blog-date ">
										<p class="date"><a href="<?php the_permalink(); ?>"><?php echo get_the_time('d'); ?></a></p>
				                    	<p class="month"><a href="<?php the_permalink(); ?>"><?php echo get_the_time('M'); ?></a></p>
									</div>
									<div class="info info-cat">
										<?php echo get_the_term_list($post->ID,'category', '<i class="fa fa-folder-o"></i> ', ',  ' ); ?>
									</div>
									<div class="info info-comment"> 
										<i class="fa fa-comment-o" aria-hidden="true"></i>
										<?php comments_popup_link(esc_html__('0', 'barber'), esc_html__('1', 'barber')); ?>
									</div>
									<div class="info info-like">
										<?php  if(function_exists('apr_getPostLikeLink')) {
										echo apr_getPostLikeLink( get_the_ID() );
										}
										?>
									</div>
									<div class="info info-tag">
										<?php echo get_the_tag_list('<i class="fa fa-tag"></i> ',', ',''); ?>
									</div>				
								</div>		
							</div>
							<div class="blog_post_desc">					
								<?php the_content();?>
									<?php 
										wp_link_pages( array(
											'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'barber' ) . '</span>',
											'after'       => '</div>',
											'link_before' => '<span>',
											'link_after'  => '</span>',
											'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'barber' ) . ' </span>%',
											'separator'   => '<span class="screen-reader-text">, </span>',
										) );
									?>							
							</div>
						</div>
					</div>
				</div>			
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="author-box">
						<?php apr_get_share_link();?>	
						<?php apr_author_box();?>
					</div>
				    <div class="post-comments">
				        <?php comments_template('', true); ?>  
				    </div> 
				</div>
			</div>
		</div>
	</div>
<?php elseif($single_layout == 'single-3'):?>
	<div class="blog post-single single-3">
	    <div class="blog-content">
			<div class="blog-item">
				<div class="blog-post-info">
					<?php if(get_the_title() != ''):?>
						<div class="blog-post-title">
							<div class="post-name">
							    <h3><?php the_title(); ?>
									<?php  if ( is_sticky() && is_home() && ! is_paged() ):?>
									 <span class="sticky_post"><?php echo esc_html__('Featured', 'barber')?></span>
									<?php endif;?>          
								</h3>                                     
							</div>					
						</div>
					<?php endif;?>
					<div class="blog-info">
						<div class="info blog-date ">
							<p class="date"><a href="<?php the_permalink(); ?>"><?php echo get_the_time('d'); ?></a></p>
	                    	<p class="month"><a href="<?php the_permalink(); ?>"><?php echo get_the_time('M'); ?></a></p>
						</div>
						<div class="info info-cat">
							<?php echo get_the_term_list($post->ID,'category', '<i class="fa fa-folder-o"></i> ', ',  ' ); ?>
						</div>
						<div class="info info-comment"> 
							<i class="fa fa-comment-o" aria-hidden="true"></i>
							<?php comments_popup_link(esc_html__('0', 'barber'), esc_html__('1', 'barber')); ?>
						</div>
						<div class="info info-like">
							<?php  if(function_exists('apr_getPostLikeLink')) {
							echo apr_getPostLikeLink( get_the_ID() );
							}
							?>
						</div>
						<div class="info info-tag">
							<?php echo get_the_tag_list('<i class="fa fa-tag"></i> ',', ',''); ?>
						</div>				
					</div>		
				</div>
				<?php apr_get_post_media(); ?>
				<div class="blog_post_desc">					
					<?php the_content();?>
						<?php 
							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'barber' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
								'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'barber' ) . ' </span>%',
								'separator'   => '<span class="screen-reader-text">, </span>',
							) );
						?>							
				</div>				

			</div>
		</div>
		<div class="author-box">
			<?php apr_get_share_link();?>	
			<?php apr_author_box();?>
		</div>
	    <div class="post-comments">
	        <?php comments_template('', true); ?>  
	    </div> 
	</div>
<?php elseif($single_layout == 'single-2'):?>
	<div class="blog post-single single-2">
	    <div class="blog-content">
			<div class="blog-item">
				<?php apr_get_post_media(); ?>
				<div class="blog-post-info">
					<div class="blog-info">
						<div class="info blog-date ">
							<p class="date"><a href="<?php the_permalink(); ?>"><?php echo get_the_time('d'); ?></a></p>
	                    	<p class="month"><a href="<?php the_permalink(); ?>"><?php echo get_the_time('M'); ?></a></p>
						</div>
						<div class="info info-cat">
							<?php echo get_the_term_list($post->ID,'category', '<i class="fa fa-folder-o"></i> ', ',  ' ); ?>
						</div>
						<div class="info info-comment"> 
							<i class="fa fa-comment-o" aria-hidden="true"></i>
							<?php comments_popup_link(esc_html__('0', 'barber'), esc_html__('1', 'barber')); ?>
						</div>
						<div class="info info-like">
							<?php  if(function_exists('apr_getPostLikeLink')) {
							echo apr_getPostLikeLink( get_the_ID() );
							}
							?>
						</div>
						<div class="info info-tag">
							<?php echo get_the_tag_list('<i class="fa fa-tag"></i> ',', ',''); ?>
						</div>			
					</div>									
					<?php if(get_the_title() != ''):?>
					<div class="blog-post-title">
						<div class="post-name">
						    <h3><?php the_title(); ?>
								<?php  if ( is_sticky() && is_home() && ! is_paged() ):?>
								 <span class="sticky_post"><?php echo esc_html__('Featured', 'barber')?></span>
								<?php endif;?>          
							</h3>                                     
						</div>					
					</div>
					<?php endif;?>
					<div class="blog_post_desc">					
						<?php the_content();?>
							<?php 
								wp_link_pages( array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'barber' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
									'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'barber' ) . ' </span>%',
									'separator'   => '<span class="screen-reader-text">, </span>',
								) );
							?>							
					</div>
				</div>					

			</div>
		</div>
		<div class="author-box">
			<?php apr_get_share_link();?>		
			<?php apr_author_box();?>
		</div>
	    <div class="post-comments">
	        <?php comments_template('', true); ?>  
	    </div>  
	</div>
<?php else: ?>
	<div class="blog post-single single-1">
	    <div class="blog-content">
			<div class="blog-item">
				<?php apr_get_post_media(); ?>
				<div class="blog-post-info">
					<div class="blog-info">
						<div class="info blog-date ">
							<p class="date"><a href="<?php the_permalink(); ?>"><?php echo get_the_time('d'); ?></a></p>
	                    	<p class="month"><a href="<?php the_permalink(); ?>"><?php echo get_the_time('M'); ?></a></p>
						</div>
						<?php $apr_author_id= $post->post_author;?>
						<div class="info author">
							<i class="fa fa-user" aria-hidden="true"></i>
							<span><?php echo esc_html__('By','barber');?></span>
							<a href="<?php echo esc_url(get_edit_user_link( $apr_author_id )); ?>"><?php the_author_meta( 'nickname' , $apr_author_id ); ?></a>
						</div>	
						<div class="info info-comment"> 
							<i class="fa fa-comment" aria-hidden="true"></i>
							<?php comments_popup_link(esc_html__('0 Comment', 'barber'), esc_html__('1 Comment', 'barber'), esc_html__('% Comments', 'barber')); ?>
						</div>			
					</div>									
					<?php if(get_the_title() != ''):?>
					<div class="blog-post-title">
						<div class="post-name">
						    <h3><?php the_title(); ?>
								<?php  if ( is_sticky() && is_home() && ! is_paged() ):?>
								 <span class="sticky_post"><?php echo esc_html__('Featured', 'barber')?></span>
								<?php endif;?>          
							</h3>                                     
						</div>					
					</div>
					<?php endif;?>
					<div class="blog_post_desc">					
						<?php the_content();?>
							<?php 
								wp_link_pages( array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'barber' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
									'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'barber' ) . ' </span>%',
									'separator'   => '<span class="screen-reader-text">, </span>',
								) );
							?>							
					</div>
				</div>					

			</div>
		</div>
		<div class="author-box">
			<?php apr_get_share_link();?>		
			<?php apr_author_box();?>
		</div>
	    <div class="post-comments">
	        <?php comments_template('', true); ?>  
	    </div>  
	</div>
<?php endif; ?>