<div class="uk-width-1-1">
	<hr class="uk-margin-medium">
	<div class="uk-grid" data-uk-grid>
		<div class="de-single__author-box--inner-content-image uk-width-1-6@m">
				<?php
				echo get_avatar(
					$author_id,
					100,
					'',
					'author_avatar'
				);
				if ( '' !== $author_job ) : ?>
				<p><?php echo get_the_author_meta( 'job_title' ); ?></p>
			<?php endif; ?>
		</div>
		<div class="de-single__author-box--inner-content-detail uk-width-5-6@m">
			<h6><?php esc_html_e( 'Published by', 'kitring' ) ?> <a href="<?php esc_url( $author_url ) ?>" class="uk-link-heading uk-link"><?php echo esc_html( $author_name ); ?></a></h6>
			<p><?php echo get_the_author_meta( 'description' );?></p>
		</div>
	</div>
</div>
