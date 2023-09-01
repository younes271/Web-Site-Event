<?php
    $apr_sidebar_right = apr_get_sidebar_right();
    ?>
<?php if ($apr_sidebar_right && $apr_sidebar_right != "none") : ?>
    <div class="col-md-3 col-sm-12 col-xs-12 right-sidebar active-sidebar"><!-- main sidebar -->
        <?php dynamic_sidebar($apr_sidebar_right); ?>
    </div>
<?php endif; ?>


