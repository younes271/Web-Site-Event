<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$site_layout = mgana_get_site_layout();
?>
<?php if( $site_layout != 'col-1c' ): ?>
    <?php do_action( 'mgana/action/before_sidebar' ); ?>
    <aside id="sidebar_primary" class="sidebar-container widget-area <?php if($site_layout == 'col-2cr' || $site_layout == 'col-2cr-l'){ echo 'sidebar-primary'; } else { echo 'sidebar-secondary'; } ?>">
        <?php do_action( 'mgana/action/before_sidebar_inner' ); ?>
        <div class="sidebar-inner">
            <?php
				dynamic_sidebar(apply_filters('mgana/filter/sidebar_primary_name', 'sidebar'));
            ?>
        </div>
        <?php do_action( 'mgana/action/after_sidebar_inner' ); ?>
    </aside>
    <?php do_action( 'mgana/action/after_sidebar' ); ?>
<?php endif;?>