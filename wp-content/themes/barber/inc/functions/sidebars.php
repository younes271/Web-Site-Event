<?php
add_action('widgets_init', 'apr_register_sidebars');

function apr_register_sidebars() {
    
    register_sidebar(array(
        'name' => esc_html__('General Sidebar', 'barber'),
        'id' => 'general-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget general-sidebar %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title widget-title-border">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar( array(
        'name' => esc_html__('Appointment Sidebar', 'barber'),
        'id' => 'appointment-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title widget-title-border">',
        'after_title' => '</h3>',
    ) );
	register_sidebar( array(
        'name' => esc_html__('Arrowpress Social', 'barber'),
        'id' => 'arrowpress-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title widget-title-border">',
        'after_title' => '</h3>',
    ) );
	 register_sidebar( array(
        'name' => esc_html__('Blog Sidebar', 'barber'),
        'id' => 'blog-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title widget-title-border">',
        'after_title' => '</h3>',
    ) );
    register_sidebar(array(
        'name' => esc_html__('Footer Menu', 'barber'),
        'id' => 'footer-menu',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4> ',
    ));
     register_sidebar(array(
        'name' => esc_html__('Footer 2 Menu', 'barber'),
        'id' => 'footer2-menu',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4> ',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Newsletter', 'barber'),
        'id' => 'footer-newsletter',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer 1 Widget 1', 'barber'),
        'id' => 'footer-1-widget1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4>',
    ));

     register_sidebar(array(
        'name' => esc_html__('Footer 1 Widget 2', 'barber'),
        'id' => 'footer-1-widget2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer 3 Widget 1', 'barber'),
        'id' => 'footer-3-widget1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 3 Widget 2', 'barber'),
        'id' => 'footer-3-widget2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 3 Widget 3', 'barber'),
        'id' => 'footer-3-widget3',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 3 Widget 4', 'barber'),
        'id' => 'footer-3-widget4',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer 4 Widget 1', 'barber'),
        'id' => 'footer-4-widget1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4>',
    )); 

    register_sidebar(array(
        'name' => esc_html__('Footer 4 Widget 2', 'barber'),
        'id' => 'footer-4-widget2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4>',
    )); 

    register_sidebar(array(
        'name' => esc_html__('Footer 4 Widget 3', 'barber'),
        'id' => 'footer-4-widget3',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4>',
    )); 

     register_sidebar(array(
        'name' => esc_html__('Footer 5 Widget', 'barber'),
        'id' => 'footer-5-widget',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title">',
        'after_title' => '</h4>',
    )); 
    register_sidebar(array(
        'name' => esc_html__('Footer 8 Widget 1', 'barber'),
        'id' => 'footer-8-widget1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title border">',
        'after_title' => '</h4>',
    )); 
     register_sidebar(array(
        'name' => esc_html__('Footer 8 Widget 2', 'barber'),
        'id' => 'footer-8-widget2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title border">',
        'after_title' => '</h4>',
    )); 
      register_sidebar(array(
        'name' => esc_html__('Footer 8 Widget 3', 'barber'),
        'id' => 'footer-8-widget3',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title border">',
        'after_title' => '</h4>',
    )); 
       register_sidebar(array(
        'name' => esc_html__('Footer 8 Widget 4', 'barber'),
        'id' => 'footer-8-widget4',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h4 class="footer-title border">',
        'after_title' => '</h4>',
    )); 

    if (class_exists('Woocommerce')) {

        register_sidebar(array(
            'name' => esc_html__('Shop Sidebar', 'barber'),
            'id' => 'shop-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title widget-title-border">',
			'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Single Product Sidebar', 'barber'),
            'id' => 'single-product-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title widget-title-border">',
			'after_title' => '</h3>',
        ));
    }
}