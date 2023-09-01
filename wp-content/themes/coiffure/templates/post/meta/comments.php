<?php
$show         = comments_open();
$comment_icon = '<svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M448 0H64C28.7 0 0 28.7 0 64v288c0 35.3 28.7 64 64 64h96v84c0 9.8 11.2 15.5 19.1 9.7L304 416h144c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64z"></path></svg>';
?>
<?php if ( $show ) : ?>
	<div class="comment-count vamtam-meta-comments">
		<?php
			comments_popup_link(
				$comment_icon . wp_kses( __( '0 <span class="comment-word ">Comments</span>', 'coiffure' ), 'vamtam-a-span' ),
				$comment_icon . wp_kses( __( '1 <span class="comment-word ">Comment</span>', 'coiffure' ), 'vamtam-a-span' ),
				$comment_icon . wp_kses( __( '% <span class="comment-word ">Comments</span>', 'coiffure' ), 'vamtam-a-span' )
			);
		?>
	</div>
<?php endif; ?>
