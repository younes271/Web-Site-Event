<?php 
require_once(APR_METABOXES . '/default_options.php');
require_once(APR_METABOXES . '/page.php');
require_once(APR_METABOXES . '/post.php');
require_once(APR_METABOXES . '/products.php');
require_once(APR_METABOXES . '/gallery.php');
require_once(APR_METABOXES . '/related_post.php');
require_once(APR_METABOXES . '/portfolio.php');
require_once(APR_METABOXES . '/user-profile.php');
function apr_post_gallery_related(){
$gallery_related = get_post_meta(get_the_ID(), 'related_entries', true);
$output = '';
ob_start();
?>
    <?php if (is_array($gallery_related)) : ?>
        <?php if (count($gallery_related) > 0) : ?>
            <div class="mad_section_bg1 gallery_related">
                <h2 class="align_center"><?php echo esc_html__('Related Projects','barber' );?></h2>
                <div class="container extra">
                    <div class="carousel_type_4">
                        <div class="owl-carousel" data-max-items="4">
                            <?php foreach ($gallery_related as $key => $entry) : ?>
                            <div>
                                <div class="item_wrapper">
                                    <?php
                                    $post_term_arr = get_the_terms($entry, 'gallery_cat');

                                    $post_term_names = '';

                                    foreach ($post_term_arr as $post_term) {
                                        $post_term_names .= $post_term->name . ', ';
                                    }
                                    $post_term_names = substr($post_term_names, 0, -2);
                                    ?>
                                    <?php if (has_post_thumbnail($entry)) : ?>
                                    <figure>
                                        <?php $image = get_the_post_thumbnail($entry, 'apr_gallery'); 
                                        $attachment_url = wp_get_attachment_url(get_post_thumbnail_id($entry)); 
                                        ?>
                                        <div class="post_image plus_link">
                                          <?php echo wp_kses($image,array(
                                              'img' =>  array(
                                                'width' => array(),
                                                'height'  => array(),
                                                'src' => array(),
                                                'class' => array(),
                                                'alt' => array(),
                                                'id' => array(),
                                                )
                                            )); ?>
                                          <div class="curtain two_items">
                                            <a href="<?php echo esc_url($attachment_url) ?>" class="gallery" rel="category"></a>
                                            <a href="<?php echo get_permalink($entry); ?>" class="link" rel="category"></a>
                                          </div> 
                                        </div>
                                    </figure>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>    
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php
$output .= ob_get_clean();
return $output;
}
function apr_sidebars() {
    global $wp_registered_sidebars;

    $sidebar_options = array();
    $sidebar_options['default'] = esc_html__('Default sidebar', 'barber');
    $sidebar_options['none'] = esc_html__('None', 'barber');
    if (!empty($wp_registered_sidebars)) {
        foreach ($wp_registered_sidebars as $sidebar) {
            $sidebar_options[$sidebar['id']] = $sidebar['name'];
        }
    }
    return $sidebar_options;
}
function apr_metabox_template($meta_boxes) {
    global $post;
    $output = '';
    ob_start();
    foreach ($meta_boxes as $meta_box):
        $name = isset($meta_box['name']) ? $meta_box['name'] : '';
        $title = isset($meta_box['title']) ? $meta_box['title'] : '';
        $desc = isset($meta_box['desc']) ? $meta_box['desc'] : '';
        $default = isset($meta_box['default']) ? $meta_box['default'] : '';
        $type = isset($meta_box['type']) ? $meta_box['type'] : '';
        $required = isset($meta_box['required']) ? $meta_box['required'] : '';
        $options = isset($meta_box['options']) ? $meta_box['options'] : '';
        $display_condition = isset($meta_box['display_condition']) ? $meta_box['display_condition'] : '';
        $status = isset($meta_box['status']) ? $meta_box['status'] : '';
        $group = isset($meta_box['group']) ? $meta_box['group'] : '';
        $number_after = isset($meta_box['number_after']) ? $meta_box['number_after'] : '';
        $meta_box_value = get_post_meta($post->ID, $name, true);

        if ($meta_box_value == "")
            $meta_box_value = $default;

        echo '<input type="hidden" name="' . $name . '_noncename" id="' . $name . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
        $format_type ="";
        if ( get_post_type() == "post" ) {
            $format_type =  $display_condition.' format-type';
        }
        ?>
        <?php if ($type == "text") : ?>
            <div class="metabox <?php echo esc_attr($format_type); ?> <?php echo esc_attr($group); ?>">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option">
                        <input type="text" id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo stripslashes($meta_box_value) ?>" size="50%" />
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc)?></label></div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == "textfield") : ?>
            <div class="metabox <?php echo esc_attr($group);?> <?php echo esc_attr($format_type); ?>">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option">
                        <input type="text" id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo stripslashes($meta_box_value) ?>" size="50%" />
                    </div>
                    <?php if($desc != ''):?>
                        <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == "number") : ?>
            <div class="metabox <?php echo esc_attr($group);?>">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option">
                        <input type="number" id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo stripslashes($meta_box_value) ?>" size="50%" />
                        <p class="number_after"><?php echo esc_html($number_after); ?></p>
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                </div>
            </div>
        <?php endif; ?>       
        <?php if ($type == "select") : ?>
            <div class="metabox <?php echo esc_attr($group);?>">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option">
                        <select name="<?php echo esc_attr($name) ?>" id="<?php echo esc_attr($name) ?>">
                            <?php if (is_array($options)) : ?>
                                <?php foreach ($options as $key => $value) : ?>
                                    <option value="<?php echo esc_attr($key) ?>"<?php echo ($meta_box_value == $key ? ' selected="selected"' : '') ?>>
                                        <?php echo esc_html( $value ); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == "upload") : ?>
            <div class="metabox">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option">
                        <label for='upload_image'>
                            <input value="<?php echo stripslashes($meta_box_value) ?>" type="text" name="<?php echo esc_attr($name) ?>"  id="<?php echo esc_attr($name) ?>" size="50%" />
                            <br/>
                            <input class="button_upload_image button" id="<?php echo esc_attr($name) ?>" type="button" value="<?php echo esc_html__('Upload File', 'barber') ?>" />&nbsp;
                            <input class="button_remove_image button" id="<?php echo esc_attr($name) ?>" type="button" value="<?php echo esc_html__('Remove File', 'barber') ?>" />
                        </label>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == "editor") : ?>
            <div class="metabox">
                <h3 style="float:none;"><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option">
                        <?php wp_editor($meta_box_value, $name) ?>
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == "textarea") : ?>
            <div class="metabox <?php echo esc_attr($format_type); ?>">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option">
                        <textarea id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>"><?php echo stripslashes($meta_box_value) ?></textarea>
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (($type == 'radio')) : ?>
            <div class="metabox">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option radio">
                        <?php foreach ($options as $key => $value) : ?>
                            <input type="radio" id="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo esc_attr($key) ?>"
                                   <?php echo (isset($meta_box_value) && ($meta_box_value == $key) ? ' checked="checked"' : '') ?>/>
                            <label for="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>"><?php echo esc_html( $value ); ?></label>
                        <?php endforeach; ?>
                        <br>
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == "checkbox") : ?>
            <?php
            if ($meta_box_value == $name) {
                $checked = "checked=\"checked\"";
            } else {
                $checked = "";
            }
            ?>
            <div class="metabox">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option checkbox">
                        <label><input type="checkbox" name="<?php echo esc_attr($name) ?>" value="<?php echo esc_attr($name) ?>" <?php echo esc_attr($checked) ?>/> <?php echo esc_html($desc) ?></label>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (($type == 'multi_checkbox') && (!empty($options))) : ?>
            <div class="metabox">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option radio">
                        <?php foreach ($options as $key => $value) : ?>
                            <input type="checkbox" id="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>" name="<?php echo esc_attr($name) ?>[]" value="<?php echo esc_attr($key) ?>" <?php echo (isset($meta_box_value) && in_array($key, explode(',', $meta_box_value))) ? ' checked="checked"' : '' ?>/><label for="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>"> <?php echo esc_html( $value ); ?> </label>
                        <?php endforeach; ?>
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == "color") : // color ?>
            <div class="metabox" <?php echo esc_attr($required); ?>>
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option apr-meta-color">
                        <input type="text" id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo stripslashes($meta_box_value) ?>" size="50%" class="apr-color-field" />
                        <label class="apr-transparency-check" for="<?php echo esc_attr($name) ?>-transparency"><input type="checkbox" value="1" id="<?php echo esc_attr($name) ?>-transparency" class="checkbox apr-color-transparency"<?php if ($meta_box_value == 'transparent') echo ' checked="checked"' ?>> <?php echo esc_html__('Transparent', 'barber') ?></label>
                    </div>
                    <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($type == 'skin') : ?> 
            <div class="metabox  <?php echo ($status != '') ? esc_attr($status): ''?>" <?php if($status != ''){ ?>data-require="<?php echo esc_attr($require)?>" <?php }?> data-name="<?php echo esc_attr($name)?>">
                <h3><?php echo esc_html($title) ?></h3>
                <div class="metainner">
                    <div class="box-option skin">
                        <ul class="list-inline list-color">
                            <?php foreach ($options as $option) : ?>
                                <li class="<?php echo esc_attr($option); ?><?php echo (isset($meta_box_value) && $meta_box_value == $option) ? ' selected': '' ?>" data-name="<?php echo esc_attr($option); ?>"><a href="#"></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <input type="hidden" name="<?php echo esc_attr($name)?>" value="<?php echo (isset($meta_box_value) && $meta_box_value !='') ? esc_attr($meta_box_value): esc_attr($default) ?>"/>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; //end loop $meta_boxes ?>
    <?php
    $output .= ob_get_clean();
    return $output;
}

function apr_show_meta_box($meta_boxes) {
    if (count($meta_boxes)) :
        $metabox_template = apr_metabox_template($meta_boxes);
        echo '<div class="postoptions">'.$metabox_template.'</div>'; //end div class postoptions
    endif;
}

function apr_save_meta_data($post_id, $meta_boxes) {
    global $post;
    if (!isset($meta_boxes) || empty($meta_boxes))
        return;

    foreach ($meta_boxes as $meta_box) {

        extract(shortcode_atts(array(
            "name" => '',
            "title" => '',
            "desc" => '',
            "type" => '',
            "default" => '',
            "options" => ''
                        ), $meta_box));

        if (!isset($_POST[$name . '_noncename']))
            return $post_id;

        if (!wp_verify_nonce($_POST[$name . '_noncename'], plugin_basename(__FILE__))) {
            return $post_id;
        }

        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
        } else {
            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }

        $meta_box_value = get_post_meta($post_id, $name, true);

        if (!isset($_POST[$name])) {
            delete_post_meta($post_id, $name, $meta_box_value);
            continue;
        }

        $data = $_POST[$name];

        if (is_array($data))
            $data = implode(',', $data);

        if (!$meta_box_value && !$data)
            add_post_meta($post_id, $name, $data, true);
        elseif ($data != $meta_box_value)
            update_post_meta($post_id, $name, $data);
        elseif (!$data)
            delete_post_meta($post_id, $name, $meta_box_value);
    }
}

function apr_use_default_meta() {
    global $wp_query;

    $value = '';

    if (is_category()) {
        $cat = $wp_query->get_queried_object();
        $value = get_metadata('category', $cat->term_id, 'default', true);
    } else if (is_archive()) {
        if (function_exists('is_shop') && is_shop()) {
            $value = get_post_meta(wc_get_page_id('shop'), 'default', true);
        } else {
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            if ($term) {
                $value = get_metadata($term->taxonomy, $term->term_id, 'default', true);
            }
        }
    } else {
        if (is_singular()) {
            $value = get_post_meta(get_the_ID(), 'default', true);
        }
    }

    return ($value != 'default') ? true : false;
}

function apr_get_meta_value($meta_key, $boolean = false) {
    global $wp_query, $apr_settings;

    $value = '';

    if (is_category()) {
        $cat = $wp_query->get_queried_object();
        $value = get_metadata('category', $cat->term_id, $meta_key, true);
    } else if (is_archive()) {
        if (function_exists('is_shop') && is_shop())  {
            $value = get_post_meta(wc_get_page_id( 'shop' ), $meta_key, true);
        } else {
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            if ($term) {
                $value = get_metadata($term->taxonomy, $term->term_id, $meta_key, true);
            }
        }
    } else {
        if (is_singular()) {
            $value = get_post_meta(get_the_id(), $meta_key, true);
        } else {
            if (!is_home() && is_front_page()) {
                if (isset($apr_settings[$meta_key]))
                    $value = $apr_settings[$meta_key];
            } else if (is_home() && !is_front_page()) {
                if (isset($apr_settings['blog-'.$meta_key]))
                    $value = $apr_settings['blog-'.$meta_key];
            } else if (is_home() || is_front_page()) {
                if (isset($apr_settings[$meta_key]))
                    $value = $apr_settings[$meta_key];
            }
        }
    }

    if ($boolean) {
        $value = ($value != $meta_key) ? true : false;
    }

    return $value;
}
// Show Taxonomy Add Meta Boxes
function apr_show_tax_add_meta_boxes($meta_boxes) {
    if (!isset($meta_boxes) || empty($meta_boxes))
        return;

    foreach ($meta_boxes as $meta_box) {
        apr_show_tax_add_meta_box($meta_box);
    }
}

// Show Taxonomy Add Meta Box
function apr_show_tax_add_meta_box($meta_box) {

    extract(shortcode_atts(array(
        "name" => '',
        "title" => '',
        "desc" => '',
        "type" => '',
        "default" => '',
        "options" => '',
        "number_after" =>'',
    ), $meta_box));

    ?>

    <input type="hidden" name="<?php echo esc_attr($name) ?>_noncename" id="<?php echo esc_attr($name) ?>_noncename"
        value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ) ?>" />

    <?php
    if ($type == "text") : // text ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <input type="text" id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo stripslashes($meta_box_value) ?>" size="50%" />
            <?php if ($desc) : ?><p><?php echo esc_html($desc) ?></p><?php endif; ?>
        </div>
    <?php endif;
    if ($type == "select") : // select ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <select name="<?php echo esc_attr($name) ?>" id="<?php echo esc_attr($name) ?>">
                <?php if (is_array($options)) :
                    foreach ($options as $key => $value) : ?>
                        <option value="<?php echo esc_attr($key) ?>"><?php echo esc_html( $value ); ?></option>
                    <?php endforeach;
                endif; ?>
            </select>
            <?php if ($desc) : ?><p><?php echo esc_html($desc) ?></p><?php endif; ?>
        </div>
    <?php endif;
    if ($type == "number") : ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
                <input type="number" id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo stripslashes($meta_box_value) ?>" size="50%" />
                <p class="number_after"><?php echo esc_html($number_after); ?></p>
                <div class="box-info"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($desc) ?></label></div>
            </div>
        <?php endif;
    if ($type == "upload") : // upload image ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <label for='upload_image'>
                <input style="margin-bottom:5px;" type="text" name="<?php echo esc_attr($name) ?>"  id="<?php echo esc_attr($name) ?>" /><br/>
                <button class="button_upload_image button" id="<?php echo esc_attr($name) ?>"><?php echo esc_html__('Upload Image', 'barber') ?></button>
                <button class="button_remove_image button" id="<?php echo esc_attr($name) ?>"><?php echo esc_html__('Remove Image', 'barber') ?></button>
            </label>
            <?php if ($desc) : ?><p><?php echo esc_html($desc) ?></p><?php endif; ?>
        </div>
    <?php endif; 

    if ($type == "editor") : // editor ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <?php wp_editor( '', $name ) ?>
            <?php if ($desc) : ?><p><?php echo esc_html($desc) ?></p><?php endif; ?>
        </div>
    <?php endif;

    if ($type == "textarea") : // textarea ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <textarea id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>"></textarea>
            <?php if ($desc) : ?><p><?php echo esc_html($desc) ?></p><?php endif; ?>
        </div>
    <?php endif;

    if (($type == 'radio') && (!empty($options))) : // radio buttons ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <?php foreach ($options as $key => $value) : ?>
                <input style="display:inline-block; width:auto;" type="radio" id="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>" name="<?php echo esc_attr($name) ?>"  value="<?php echo esc_attr($key) ?>"/>
                <label style="display:inline-block" for="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>"><?php echo esc_html( $value ); ?></label>
            <?php endforeach; ?>
            <?php if ($desc) : ?><p><?php echo esc_html($desc) ?></p><?php endif; ?>
        </div>
    <?php endif;

    if ($type == "checkbox") : // checkbox ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <label><input style="display:inline-block; width:auto;" type="checkbox" name="<?php echo esc_attr($name) ?>" value="<?php echo esc_attr($name) ?>" /> <?php echo esc_html($desc) ?></label>
        </div>
    <?php endif;

    if (($type == 'multi_checkbox') && (!empty($options))) : // radio buttons ?>
        <div class="form-field">
            <label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label>
            <?php foreach ($options as $key => $value) : ?>
                <input style="display:inline-block; width:auto;" type="checkbox" id="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>" name="<?php echo esc_attr($name) ?>[]" value="<?php echo esc_attr($key) ?>" />
                <label style="display:inline-block" for="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>"><?php echo esc_html( $value ); ?></label>
            <?php endforeach; ?>
            <?php if ($desc) : ?><p><?php echo esc_html($desc) ?></p><?php endif; ?>
        </div>
    <?php endif;
}

// Show Taxonomy Add Meta Boxes
function apr_show_tax_edit_meta_boxes($tag, $taxonomy, $meta_boxes) {
    if (!isset($meta_boxes) || empty($meta_boxes))
        return;

    foreach ($meta_boxes as $meta_box) {
        apr_show_tax_edit_meta_box($tag, $taxonomy, $meta_box);
    }
}

// Show Taxonomy Add Meta Box
function apr_show_tax_edit_meta_box($tag, $taxonomy, $meta_box) {

    extract(shortcode_atts(array(
        "name" => '',
        "title" => '',
        "desc" => '',
        "type" => '',
        "default" => '',
        "options" => ''
    ), $meta_box));

    ?>

    <input type="hidden" name="<?php echo esc_attr($name) ?>_noncename" id="<?php echo esc_attr($name) ?>_noncename" 
        value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ) ?>" />

    <?php
    $meta_box_value = get_metadata($tag->taxonomy, $tag->term_id, $name, true);

    if ($meta_box_value == "")
        $meta_box_value = $default;

    if ($type == "text") : // text ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
            <td>
                <input type="text" id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo stripslashes($meta_box_value) ?>" size="50%" />
                <?php if ($desc) : ?><p class="description"><?php echo esc_html($desc) ?></p><?php endif; ?>
            </td>
        </tr>
    <?php endif;
    if ($type == "number") : // text ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
            <td>
                 <input type="number" id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>" value="<?php echo stripslashes($meta_box_value) ?>" size="50%" />
                <?php if ($desc) : ?><p class="description"><?php echo esc_html($desc) ?></p><?php endif; ?>
            </td>
        </tr>
    <?php endif;
    if ($type == "select") : // select ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
            <td>
                <select name="<?php echo esc_attr($name) ?>" id="<?php echo esc_attr($name) ?>">
                    <?php if (is_array($options)) :
                        foreach ($options as $key => $value) : ?>
                            <option value="<?php echo esc_attr($key) ?>"<?php echo $meta_box_value == $key ? ' selected="selected"' : '' ?>><?php echo esc_html( $value ); ?></option>
                        <?php endforeach;
                    endif; ?>
                </select>
                <?php if ($desc) : ?><p class="description"><?php echo esc_html($desc) ?></p><?php endif; ?>
            </td>
        </tr>
    <?php endif; 

    if ($type == "upload") : // upload image ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
            <td>
                <label for='upload_image'>
                    <input style="margin-bottom:5px;" value="<?php echo stripslashes($meta_box_value) ?>" type="text" name="<?php echo esc_attr($name) ?>"  id="<?php echo esc_attr($name) ?>" size="50%" />
                    <br/>
                    <button class="button_upload_image button" id="<?php echo esc_attr($name) ?>"><?php echo esc_html__('Upload Image', 'barber') ?></button>
                    <button class="button_remove_image button" id="<?php echo esc_attr($name) ?>"><?php echo esc_html__('Remove Image', 'barber') ?></button>
                </label>
                <?php if ($desc) : ?><p class="description"><?php echo esc_html($desc) ?></p><?php endif; ?>
            </td>
        </tr>
    <?php endif; 

    if ($type == "editor") : // editor ?>
        <tr class="form-field">
            <th colspan="2" scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
        <tr>
            <td colspan="2">
                <?php wp_editor( $meta_box_value, $name ) ?>
                <?php if ($desc) : ?><p class="description"><?php echo esc_html($desc) ?></p><?php endif; ?>
            </td>
        </tr>
    <?php endif;

    if ($type == "textarea") : // textarea ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
            <td>
                <textarea id="<?php echo esc_attr($name) ?>" name="<?php echo esc_attr($name) ?>"><?php echo stripslashes($meta_box_value) ?></textarea>
                <?php if ($desc) : ?><p class="description"><?php echo esc_html($desc) ?></p><?php endif; ?>
            </td>
        </tr>
    <?php endif;

    if (($type == 'radio') && (!empty($options))) : // radio buttons ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
            <td>
                <?php foreach ($options as $key => $value) : ?>
                    <input style="display:inline-block; width:auto;" type="radio" id="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>" name="<?php echo esc_attr($name) ?>"  value="<?php echo esc_attr($key) ?>"
                        <?php echo (isset($meta_box_value) && ($meta_box_value == $key) ? ' checked="checked"' : '') ?>/>
                    <label for="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>"><?php echo esc_html( $value ); ?></label>
                <?php endforeach; ?>
                <?php if ($desc) : ?><p class="description"><?php echo esc_html($desc) ?></p><?php endif; ?>
            </td>
        </tr>
    <?php endif; 

    if ($type == "checkbox") :  // checkbox ?>
        <?php if ( $meta_box_value == $name ) {
            $checked = "checked=\"checked\"";
        } else {
            $checked = "";
        } ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
            <td>
                <label><input style="display:inline-block; width:auto;" type="checkbox" name="<?php echo esc_attr($name) ?>" value="<?php echo esc_attr($name) ?>" <?php echo esc_attr($checked) ?> /> <?php echo esc_html($desc) ?></label>
            </td>
        </tr>
    <?php endif;

    if (($type == 'multi_checkbox') && (!empty($options))) : // radio buttons ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="<?php echo esc_attr($name) ?>"><?php echo esc_html($title) ?></label></th>
            <td>
                <?php foreach ($options as $key => $value) : ?>
                    <input style="display:inline-block; width:auto;" type="checkbox" id="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>" name="<?php echo esc_attr($name) ?>[]" value="<?php echo esc_attr($key) ?>" <?php echo ((isset($meta_box_value) && in_array($key, explode(',', $meta_box_value))) ? ' checked="checked"' : '') ?>/>
                    <label for="<?php echo esc_attr($name) ?>_<?php echo esc_attr($key) ?>"> <?php echo esc_html( $value ); ?></label>
                <?php endforeach; ?>
                <?php if ($desc) : ?><p class="description"><?php echo esc_html($desc) ?></p><?php endif; ?>
            </td>
        </tr>
    <?php endif;
}

// Save Tax Data
function apr_save_taxdata( $term_id, $tt_id, $taxonomy, $meta_boxes ) {
    if (!isset($meta_boxes) || empty($meta_boxes))
        return;

    foreach ($meta_boxes as $meta_box) {

        extract(shortcode_atts(array(
            "name" => '',
            "title" => '',
            "desc" => '',
            "type" => '',
            "default" => '',
            "options" => ''
        ), $meta_box));

        if ( !isset($_POST[$name.'_noncename']))
            return;

        if ( !wp_verify_nonce( $_POST[$name.'_noncename'], plugin_basename(__FILE__) ) ) {
            return;
        }

        $meta_box_value = get_metadata($taxonomy, $term_id, $name, true);

        if (!isset($_POST[$name])) {
            delete_metadata($taxonomy, $term_id, $name, $meta_box_value);
            continue;
        }

        $data = $_POST[$name];

        if (is_array($data))
            $data = implode(',', $data);

        if (!$meta_box_value && !$data)
            add_metadata($taxonomy, $term_id, $name, $data, true);
        elseif ($data != $meta_box_value)
            update_metadata($taxonomy, $term_id, $name, $data);
        elseif (!$data)
            delete_metadata($taxonomy, $term_id, $name, $meta_box_value);
    }
}

// Create Meta Table
function apr_create_metadata_table($table_name, $type) {
    global $wpdb;

    if (!empty ($wpdb->charset))
        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
    if (!empty ($wpdb->collate))
        $charset_collate .= " COLLATE {$wpdb->collate}";

    if ( get_option( 'apr_'.$table_name ) )
        return false;

    if (!$wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
        $sql = $wpdb->prepare("CREATE TABLE {$table_name} (
            meta_id bigint(20) NOT NULL AUTO_INCREMENT,
            {$type}_id bigint(20) NOT NULL default 0,
            meta_key varchar(255) DEFAULT NULL,
            meta_value longtext DEFAULT NULL,
            UNIQUE KEY meta_id (meta_id)
        ) {$charset_collate};", '', '');
        $wpdb->query($sql);
        update_option( 'apr_'.$table_name, true );
    }

    return true;
}
function apr_meta_page_assets(){
    wp_enqueue_script( 'apr-metabox', get_template_directory_uri() . '/inc/functions/metaboxes/js/metabox.js', array('jquery'), APR_VERSION, true); 
    wp_enqueue_style("apr-page-metabox-style",get_template_directory_uri().'/inc/functions/metaboxes/css/metabox.css?ver=' . APR_VERSION);
}
add_action('admin_enqueue_scripts', 'apr_meta_page_assets' );


function apr_get_post_banner_block(){
    global $post, $apr_settings,$wp_query;
    $cat = $wp_query->get_queried_object();
    $static = "";  
    if(is_category()){
        $block_bottom = get_metadata('category', $cat->term_id, 'top_banner', true);
        if(isset($block_bottom) && $block_bottom != 'default' &&  $block_bottom != '' && $block_bottom != 'none'){
            $static = get_metadata('category', $cat->term_id, 'top_banner', true);
        }else if(isset($apr_settings['top_banner']) && $apr_settings['top_banner']!=''){
            $static = $apr_settings['top_banner'];
        }
    }else{
        if( is_singular() &&  get_post_type() == 'post' && (get_post_meta($post->ID,'top_banner',true) != 'default')){
            if(get_post_meta($post->ID,'top_banner',true) == 'none'){
                $static ='';
            }else{        
                $static = get_post_meta($post->ID,'top_banner',true) != "" ? get_post_meta($post->ID,'top_banner',true) :"";
            }
        }else if(isset($apr_settings['post_banner_block']) && $apr_settings['post_banner_block'] != ''){
            $static = $apr_settings['post_banner_block'];

        }
    }
    if($static != ''){      
        $block = get_post($static);
        $post_content = $block->post_content;
        if (class_exists('Ultimate_VC_Addons')) {

            $uvc_addons = new Ultimate_VC_Addons();
            $uvc_addons->aio_front_scripts();
            $apr_ult_assets = str_replace('js/', '', $uvc_addons->assets_js);
            $isAjax = false;
            $ultimate_ajax_theme = get_option('ultimate_ajax_theme');
            if($ultimate_ajax_theme == 'enable')
                $isAjax = true;
            $dependancy = array('jquery');
  
            // register js
            wp_register_script('ultimate-script', $apr_ult_assets . 'min-js/ultimate.min.js', array('jquery'), ULTIMATE_VERSION, false);
            wp_register_script('ultimate-appear', $apr_ult_assets . 'min-js/jquery.appear.min.js', array('jquery'), ULTIMATE_VERSION);
            wp_register_script('ultimate-custom', $apr_ult_assets . 'min-js/custom.min.js', array('jquery'), ULTIMATE_VERSION);
            wp_register_script('ultimate-vc-params', $apr_ult_assets . 'min-js/ultimate-params.min.js', array('jquery'), ULTIMATE_VERSION);

            // register css
            wp_register_style('ultimate-animate', $apr_ult_assets . 'min-css/animate.min.css', array(), ULTIMATE_VERSION);
            wp_register_style('ultimate-style', $apr_ult_assets . 'min-css/style.min.css', array(), ULTIMATE_VERSION);
            wp_register_style('ultimate-style-min', $apr_ult_assets . 'min-css/ultimate.min.css', array(), ULTIMATE_VERSION);

            if(stripos($post_content, 'font_call:'))
            {
                preg_match_all('/font_call:(.*?)"/',$post_content, $display);
                enquque_ultimate_google_fonts_optimzed($display[1]);
            }

            $ultimate_js = get_option('ultimate_js');
            if($ultimate_js == 'enable' || $isAjax == true)
            {
                wp_enqueue_script('ultimate-script');

                if( stripos( $post_content, '[icon_timeline') ) {
                    wp_enqueue_script('masonry');
                }
                if( stripos( $post_content, '[ultimate_google_map') ) {
                    wp_enqueue_script('googleapis');
                }
                if($isAjax == true) { // if ajax site load all js
                    wp_enqueue_script('masonry');
                }
            }
            else if($ultimate_js == 'disable')
            {
                wp_enqueue_script('ultimate-vc-params');

                if(
                    stripos( $post_content, '[ultimate_spacer')
                    || stripos( $post_content, '[ult_buttons')
                    || stripos( $post_content, '[ultimate_icon_list')
                ) {
                    wp_enqueue_script('ultimate-custom');
                }
                if(
                    stripos( $post_content, '[just_icon')
                    || stripos( $post_content, '[ult_animation_block')
                    || stripos( $post_content, '[icon_counter')
                    || stripos( $post_content, '[ultimate_google_map')
                    || stripos( $post_content, '[icon_timeline')
                    || stripos( $post_content, '[bsf-info-box')
                    || stripos( $post_content, '[info_list')
                    || stripos( $post_content, '[ultimate_info_table')
                    || stripos( $post_content, '[interactive_banner_2')
                    || stripos( $post_content, '[interactive_banner')
                    || stripos( $post_content, '[ultimate_pricing')
                    || stripos( $post_content, '[ultimate_icons')
                ) {
                    wp_enqueue_script('ultimate-appear');
                    wp_enqueue_script('ultimate-custom');
                }
                if( stripos( $post_content, '[ultimate_heading') ) {
                    wp_enqueue_script("ultimate-headings-script");
                }
                if( stripos( $post_content, '[ultimate_carousel') ) {
                    wp_enqueue_script('ult-slick');
                    wp_enqueue_script('ultimate-appear');
                    wp_enqueue_script('ult-slick-custom');
                }
                if( stripos( $post_content, '[ult_countdown') ) {
                    wp_enqueue_script('jquery.timeapr');
                    wp_enqueue_script('jquery.countdown');
                }
                if( stripos( $post_content, '[icon_timeline') ) {
                    wp_enqueue_script('masonry');
                }
                if( stripos( $post_content, '[ultimate_info_banner') ) {
                    wp_enqueue_script('ultimate-appear');
                    wp_enqueue_script('utl-info-banner-script');
                }
                if( stripos( $post_content, '[ultimate_google_map') ) {
                    wp_enqueue_script('googleapis');
                }
                if( stripos( $post_content, '[swatch_container') ) {
                    wp_enqueue_script('modernizr-79639-js');
                    wp_enqueue_script('swatchbook-js');
                }
                if( stripos( $post_content, '[ult_ihover') ) {
                    wp_enqueue_script('ult_ihover_js');
                }
                if( stripos( $post_content, '[ult_hotspot') ) {
                    wp_enqueue_script('ult_hotspot_js');
                    wp_enqueue_script('ult_hotspot_tooltipster_js');
                }
                if( stripos( $post_content, '[bsf-info-box') ) {
                    wp_enqueue_script('info_box_js');
                }
                if( stripos( $post_content, '[icon_counter') ) {
                    wp_enqueue_script('flip_box_js');
                }
                if( stripos( $post_content, '[ultimate_ctation') ) {
                    wp_enqueue_script('utl-ctaction-script');
                }
                if( stripos( $post_content, '[stat_counter') ) {
                    wp_enqueue_script('ultimate-appear');
                    wp_enqueue_script('front-js');
                    wp_enqueue_script('ult-slick-custom');
                    array_push($dependancy,'front-js');
                }
                if( stripos( $post_content, '[ultimate_video_banner') ) {
                    wp_enqueue_script('ultimate-video-banner-script');
                }
                if( stripos( $post_content, '[ult_dualbutton') ) {
                    wp_enqueue_script('jquery.dualbtn');

                }
                if( stripos( $post_content, '[ult_createlink') ) {
                    wp_enqueue_script('jquery.ult_cllink');
                }
                if( stripos( $post_content, '[ultimate_img_separator') ) {
                    wp_enqueue_script('ultimate-appear');
                    wp_enqueue_script('ult-easy-separator-script');
                }
            }

            $ultimate_css = get_option('ultimate_css');

            if($ultimate_css == "enable"){
                wp_enqueue_style('ultimate-style-min');
            } else {
                wp_enqueue_style('ultimate-style');


                if( stripos( $post_content, '[ult_animation_block') ) {
                    wp_enqueue_style('ultimate-animate');
                }
                if( stripos( $post_content, '[icon_counter') ) {
                    wp_enqueue_style('ultimate-animate');
                    wp_enqueue_style('ultimate-style');
                    wp_enqueue_style('aio-flip-style', $apr_ult_assets . 'min-css/flip-box.min.css');
                }
                if( stripos( $post_content, '[ult_countdown') ) {
                    wp_enqueue_style('countdown_shortcode', $apr_ult_assets . 'min-css/countdown.min.css');
                }
                if( stripos( $post_content, '[ultimate_icon_list') ) {
                    wp_enqueue_style('ultimate-animate');
                    wp_enqueue_style('aio-tooltip', $apr_ult_assets . 'min-css/tooltip.min.css');
                }
                if( stripos( $post_content, '[ultimate_carousel') ) {
                    wp_enqueue_style("ult-slick", $apr_ult_assets . 'slick/slick.css');
                    wp_enqueue_style("ult-icons", $apr_ult_assets . 'slick/icons.css');
                    wp_enqueue_style("ult-slick-animate", $apr_ult_assets . 'slick/animate.min.css');

                }
                if( stripos( $post_content, '[ultimate_fancytext') ) {
                    wp_enqueue_style('ultimate-fancytext-style');
                }
                if( stripos( $post_content, '[icon_counter') ) {
                    wp_enqueue_style('ultimate-animate');
                    wp_enqueue_style('aio-flip-style', $apr_ult_assets . 'min-css/flip-box.min.css');

                }
                if( stripos( $post_content, '[ultimate_ctation') ) {
                    wp_enqueue_style('utl-ctaction-style');
                }
                if( stripos( $post_content, '[ult_buttons') ) {
                    wp_enqueue_style( 'ult-btn', $apr_ult_assets . 'min-css/btn-min.css' );
                }
                if( stripos( $post_content, '[ultimate_heading') ) {
                    wp_enqueue_style("ultimate-headings-style");
                }
                if( stripos( $post_content, '[ultimate_icons') || stripos( $post_content, '[single_icon')) {
                    wp_enqueue_style('ultimate-animate');
                    wp_enqueue_style('aio-tooltip', $apr_ult_assets . 'min-css/tooltip.min.css');
                }
                if( stripos( $post_content, '[ult_ihover') ) {
                    wp_enqueue_style( 'ult_ihover_css' );
                }
                if( stripos( $post_content, '[ult_hotspot') ) {
                    wp_enqueue_style( 'ult_hotspot_css' );
                    wp_enqueue_style( 'ult_hotspot_tooltipster_css' );
                }
                if( stripos( $post_content, '[bsf-info-box') ) {
                    wp_enqueue_style('ultimate-animate');
                    wp_enqueue_style('info-box-style', $apr_ult_assets . 'min-css/info-box.min.css');
                }
                if( stripos( $post_content, '[info_apr') ) {
                    wp_enqueue_style('ultimate-animate');
                    wp_enqueue_style('info-apr', $apr_ult_assets . 'min-css/info-apr.min.css');
                }
                if( stripos( $post_content, '[ultimate_info_banner') ) {
                    wp_enqueue_style('utl-info-banner-style');
                    wp_enqueue_style('ultimate-animate');
                }
                if( stripos( $post_content, '[icon_timeline') ) {
                    wp_enqueue_style('ultimate-animate');
                    wp_enqueue_style('aio-timeline', $apr_ult_assets . 'min-css/timeline.min.css');
                }
                if( stripos( $post_content, '[just_icon') ) {
                    wp_enqueue_style('ultimate-animate');
                    wp_enqueue_style('aio-tooltip', $apr_ult_assets . 'min-css/tooltip.min.css');
                }
                if( stripos( $post_content, '[interactive_banner_2') ) {
                    wp_enqueue_style('utl-ib2-style', $apr_ult_assets . 'min-css/ib2-style.min.css');
                }
                if( stripos( $post_content, '[interactive_banner') ) {
                    wp_enqueue_style('ultimate-animate');
                    wp_enqueue_style('aio-interactive-styles', $apr_ult_assets . 'min-css/interactive-styles.min.css');
                }
                if( stripos( $post_content, '[info_list') ) {
                    wp_enqueue_style('ultimate-animate');
                }
                if( stripos( $post_content, '[ultimate_modal') ) {
                    wp_enqueue_style('ultimate-animate');
                    wp_enqueue_style('ultimate-modal', $apr_ult_assets . 'min-css/modal.min.css');
                }
                if( stripos( $post_content, '[ultimate_info_table') ) {
                    wp_enqueue_style('ultimate-animate');
                    wp_enqueue_style("ultimate-pricing", $apr_ult_assets . 'min-css/pricing.min.css');
                }
                if( stripos( $post_content, '[ultimate_pricing') ) {
                    wp_enqueue_style('ultimate-animate');
                    wp_enqueue_style("ultimate-pricing", $apr_ult_assets . 'min-css/pricing.min.css');
                }
                if( stripos( $post_content, '[swatch_container') ) {
                    wp_enqueue_style('swatchbook-css', $apr_ult_assets . 'min-css/swatchbook.min.css');
                }
                if( stripos( $post_content, '[stat_counter') ) {
                    wp_enqueue_style('ultimate-animate');
                    wp_enqueue_style('stats-counter-style', $apr_ult_assets . 'min-css/stats-counter.min.css');
                }
                if( stripos( $post_content, '[ultimate_video_banner') ) {
                    wp_enqueue_style('ultimate-video-banner-style');
                }
                if( stripos( $post_content, '[ult_dualbutton') ) {
                    wp_enqueue_style('ult-dualbutton');
                }
                if( stripos( $post_content, '[ult_createlink') ) {
                    wp_enqueue_style('ult_cllink');
                }
                if( stripos( $post_content, '[ultimate_img_separator') ) {
                    wp_enqueue_style('ultimate-animate');
                    wp_enqueue_style('ult-easy-separator-style');
                }
            }

            wp_register_script('ultimate-appear', $apr_ult_assets . 'min-js/jquery.appear.min.js', array('jquery'), ULTIMATE_VERSION, true);
            wp_register_script('ultimate-custom', $apr_ult_assets . 'min-js/custom.min.js', $dependancy, ULTIMATE_VERSION, true);
            wp_register_script('ultimate-smooth-scroll', $apr_ult_assets . 'js/SmoothScroll.js', array('jquery'), ULTIMATE_VERSION, true);

            $ultimate_smooth_scroll = get_option('ultimate_smooth_scroll');
            if($ultimate_smooth_scroll == "enable")
                wp_enqueue_script('ultimate-smooth-scroll');

            if(function_exists('vc_is_editor')){
                if(vc_is_editor()){
                    wp_enqueue_style('vc-fronteditor', $apr_ult_assets . 'min-css/vc-fronteditor.min.css');
                }
            }
            $fonts = get_option('smile_fonts');
            if(is_array($fonts))
            {
                foreach($fonts as $font => $info)
                {
                    $style_url = $info['style'];
                    if(strpos($style_url, 'http://' ) !== false) {
                        wp_enqueue_style('bsf-'.$font, $info['style']);
                    } else {
                        $paths = wp_upload_dir();
                        $paths['fonts'] = 'smile_fonts';
                        $paths['fonturl'] = set_url_scheme(trailingslashit($paths['baseurl']).$paths['fonts']);
                        wp_enqueue_style('bsf-'.$font, trailingslashit($paths['fonturl']).$info['style']);
                    }
                }
            }

        }
        $shortcodes_custom_css = get_post_meta( $static, '_wpb_shortcodes_custom_css', true );
        if ( ! empty( $shortcodes_custom_css ) ) {
            $output = '<style type="text/css" data-type="vc_shortcodes-custom-css">';
            $output .= $shortcodes_custom_css;
            $output .= '</style>';
            echo $output;
        }
        $hide_static = true;
        if($hide_static){
            echo apply_filters('the_content', get_post_field('post_content', $static));
        }
    }
}
?>