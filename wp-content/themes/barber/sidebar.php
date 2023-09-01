<?php
    $apr_sidebar_left = apr_get_sidebar_left();
    $apr_sidebar_right = apr_get_sidebar_right();

    ?>
<?php if ($apr_sidebar_left) : ?>
    <div class="col-md-3 col-sm-12 col-xs-12 left-sidebar ">
        <?php dynamic_sidebar($apr_sidebar_left); ?>
    </div>
<?php endif; ?>
<?php if ($apr_sidebar_right) : ?>
    <div class="col-md-3 col-sm-12 col-xs-12 right-sidebar">
        <?php dynamic_sidebar($apr_sidebar_right); ?>
    </div>
<?php endif; ?>





