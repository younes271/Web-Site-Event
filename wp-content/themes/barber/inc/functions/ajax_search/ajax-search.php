<?php
add_action("wp_ajax_woosearch_search", "apr_search_ajax_data_search");
add_action("wp_ajax_nopriv_woosearch_search", "apr_search_ajax_data_search");

function apr_search_ajax_data_search(){

    $output = '';
    $data_view = '';
    $args = array();

    if(isset($_POST['raw_data'])){
        $args = array(
                    's'                 => $_POST['raw_data'],
                    'post_type'         => 'product',
            );
        if(isset($_POST['category'])){
            if($_POST['category']!='' && $_POST['category']!='all'){
                $args['tax_query']  =   array( 
                                            array(
                                                'taxonomy' => 'product_cat',
                                                'field'    => 'slug',
                                                'terms'    => $_POST['category'],
                                            )
                                        );
            }
        }
        if(isset($_POST['number'])){
             $args['posts_per_page'] = $_POST['number'];
        }else{
            $args['posts_per_page'] = 10;
        }
        $data_view = $_POST['raw_data'];
    }

    $search_data = new WP_Query($args);

    if($search_data->have_posts()):
        $output .= '<ul>';
        while ($search_data->have_posts()): $search_data->the_post();
            $the_title = str_ireplace( $data_view ,"<span>".$data_view."</span>", get_the_title() );
            $output .= '<li><a href="'.get_permalink().'"> '.$the_title.'</a></li>';
        endwhile;
        $output .= '</ul>';
        wp_reset_postdata();
    endif;

    wp_die($output);
}