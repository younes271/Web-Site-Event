<?php
/**
 * After Container template.
 *
 * @package Mgana WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
} ?>

                </article><!-- .single-page-article -->

                <?php do_action( 'mgana/action/after_content_inner' ); ?>

                </div><!-- #content -->

            <?php do_action( 'mgana/action/after_content' ); ?>

        </div><!-- #primary -->

        <?php do_action( 'mgana/action/after_primary' ); ?>

    </div><!-- #content-wrap -->

<?php do_action( 'mgana/action/after_content_wrap' ); ?>