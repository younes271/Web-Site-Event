<?php

if ( post_password_required() ) {
	return;
}
?>
<?php 
?>
<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="number-comments widget-title">
			<?php echo "<span> ".number_format_i18n( get_comments_number())."</span>". esc_html__(' Comments','barber');?>
		</h2>

		<ul class="commentlist">
			<?php
				wp_list_comments( 'reply_text=Reply&style=ul&short_ping=true&avatar_size=100&callback=apr_comment_body_template&max_depth=5');
			?>
		</ul>

		<?php apr_comment_nav(); ?>
	
	<?php endif; ?>

	<?php
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php echo esc_html__( 'Comments are closed.', 'barber' ); ?></p>
	<?php endif; ?>

	<div class="comment-form">
		<?php 

		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$comment_login='';
		if ( is_user_logged_in() ) {$comment_login="comment-field-login";}
		
		$comment_args = array( 
			'class_form' => 'commentform row',
			'fields' => apply_filters( 'comment_form_default_fields', array(
			    'author' => '<div class="col-md-6 col-sm-12 col-xs-12 info-form"> <div class="comment-field fields"><p class="comment-form-author form-row form-row-first"><input placeholder="' .esc_attr__('Your Name*', 'barber' ) . '" id="author" class="required" name="author" type="text" value="' .
			                esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />' .
			     	'</p>',
			    'email'  => '<p class="comment-form-email form-row"><input placeholder="' .esc_attr__('Your Email*', 'barber' ) . '" id="email" class="required email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />' .
					'</p></div></div>',
			    'url'    => '' ) ),
			'comment_field' => '<div class="col-md-6 col-sm-12 col-xs-12 comment-textarea"><div class="comment-right-field'.$comment_login.' "><p class="comment-form-comment form-row form-row-wide">' .
		       		'<textarea id="comment" class="required" name="comment" cols="45" rows="4" aria-required="true" placeholder="' .esc_attr__('Your comment', 'barber' ) . '"></textarea>' .
		   		'</p></div></div>',
			'title_reply'  => '<span>'.esc_html__( 'Leave your comment','barber' ).'</span>',
			'cancel_reply_link' => esc_html__('Cancel reply','barber'),
		    
		   	'logged_in_as' => '',
		    'comment_notes_before' => '',
		    'class_submit'         => 'hidden',
		    'label_submit'		=> 'submit',
		    'comment_notes_after' => '',
		);
		?>

		<?php comment_form($comment_args); ?>
	<?php
	?> 
	</div>
</div>
