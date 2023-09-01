<?php 
$apr_settings = apr_check_theme_options();
$footer_type = apr_get_footer_type();
$apr_layout = apr_get_layout();
$apr_hide_footernewsletter = apr_get_meta_value('hide_footernewsletter', true);
$apr_hide_f_info = apr_get_meta_value('hide_f_info', true);
$apr_footer_fixed = get_post_meta(get_the_ID(), 'footer_fixed', true);
$footer_class = '';
if($apr_footer_fixed || (isset($apr_settings['footer-position']) && $apr_settings['footer-position']) && !is_404()){
    $footer_class = ' footer-fixed';
}
if (is_404() || is_page_template( 'coming-soon.php' )) {
    $apr_layout =  'wide';
}
?> 

	<?php if($apr_layout == 'fullwidth') :?>
		</div>
	</div>
	<?php else:?>
		</div>
	<?php endif; ?>

</div> <!-- End main-->
<?php if (apr_get_meta_value('show_footer', true)) : ?>
<?php apr_get_banner_block(); ?>
<footer id="colophon" class="footer <?php if(!$apr_hide_f_info){echo 'remove_f_info';}?><?php echo esc_attr($footer_class); ?>">
    <div class="footer-v<?php echo esc_attr($footer_type); ?>">      
        <?php get_template_part('footers/footer_' . $footer_type); ?>
    </div> <!-- End footer -->
</footer> <!-- End colophon -->
<?php endif;?>
</div> <!-- End page-->
<?php wp_footer(); ?>
</body>
</html>