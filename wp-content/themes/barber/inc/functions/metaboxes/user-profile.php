<?php
//custom field for user
add_action( 'show_user_profile', 'apr_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'apr_show_extra_profile_fields' );
function apr_show_extra_profile_fields( $user ) { ?>
    <h3><?php echo esc_html__( 'Extra profile information', 'barber' );?></h3>
    <table class="form-table">
        <tr>
            <th><label for="occupation"><?php echo esc_html__( 'Occupation', 'barber' );?></label></th>

            <td>
                <input type="text" name="occupation" id="occupation" value="<?php echo esc_attr( get_the_author_meta( 'occupation', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php echo esc_html__( 'Please enter your occupation.', 'barber' );?></span>
            </td>
        </tr>
        <tr>
            <th><label for="avatar"><?php echo esc_html__('User Avatar (square image recommended)','barber');?></label></th>

            <td>
                <input type="text" name="avatar" id="avatar" value="<?php echo esc_attr( get_the_author_meta( 'avatar', $user->ID ) ); ?>" class="regular-text" /> 
                <input class="button_upload_image button" id="avatar" type="button" value="<?php echo esc_html__('Upload Image', 'barber') ?>" />&nbsp;
                <input class="button_remove_image button" id="avatar" type="button" value="<?php echo esc_html__('Remove Image', 'barber') ?>" />       
                <br />                         
                <div class="user_ava_field">
                <?php if(get_the_author_meta( 'avatar', $user->ID ) !=''):?>
                    <img width="100" alt="" src="<?php echo esc_url( get_the_author_meta( 'avatar', $user->ID ) ); ?>">
                <?php endif;?>
                </div>
                               
            </td>
        </tr>                
    </table>
<?php }
add_action( 'personal_options_update', 'apr_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'apr_save_extra_profile_fields' );

function apr_save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
    update_user_meta( $user_id, 'occupation', $_POST['occupation'] );
    update_user_meta( $user_id, 'avatar', $_POST['avatar'] );    
}
// Apply filter
add_filter( 'get_avatar' , 'apr_custom_avatar' , 1 , 5 );

function apr_custom_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = false;
    if ( is_numeric( $id_or_email ) ) {

        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );

    } elseif ( is_object( $id_or_email ) ) {

        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }

    } else {
        $user = get_user_by( 'email', $id_or_email );   
    }

    if ( $user && is_object( $user ) ) {

        if(get_the_author_meta('avatar') !=''){
            $avatar = get_the_author_meta('avatar');
            $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        }

    }
    

    return $avatar;
}
function apr_author_box() {  ?>
    <?php if(get_the_author_meta( 'description' ) != ''):?>
        <div class="author_blog">
            <div class="avatar_author">
                <?php echo get_avatar( get_the_author_meta( 'user_email' ), '101' ); ?> 
                <div class="author_info">
                    <div class="name_author">
                        <?php the_author(); ?>
                    </div>
                    <?php if ( get_the_author_meta( 'occupation' ) ) : ?>
                    <div class="job_author">
                        <p><?php the_author_meta( 'occupation' );?></p>
                    </div>
                    <?php endif;?>                    
                </div>
            </div>
            <div class="desc_author">
                <p><?php the_author_meta( 'description' ); ?></p>
            </div>
        </div>
    <?php endif;?>
    <?php
}