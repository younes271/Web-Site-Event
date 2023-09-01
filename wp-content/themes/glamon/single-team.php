<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package glamon
 */

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php if ( 'default' === glamon_global_var( 'team_details_style', '', false ) ) { ?>
			<?php get_template_part( 'template-parts/team-single-blank', get_post_format() ); ?>
		<?php } else { ?>
			<!-- wraper_team_single -->
			<section class="wraper_team_single">
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<?php get_template_part( 'template-parts/team-single-' . glamon_global_var( 'team_details_style', '', false ), get_post_format() ); ?>
						</div>
					</div>
					<!-- row -->
				</div>
			</section>
			<!-- wraper_team_single -->
		<?php } ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
