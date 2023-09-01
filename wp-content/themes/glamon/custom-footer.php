<?php
/**
 * The template is for displaying custom footer builder preview.
 *
 * This file is for previewing footers which are built using Footer Builder feature of Glamon Theme.
 *
 * @package glamon
 */

?>

		</div><!-- #main -->

		<footer class="custom-footer">
			<div class="container">
				<?php
				while ( have_posts() ) :
					the_post();
					the_content();
					endwhile;
				?>
			</div>
		</footer>

	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>
