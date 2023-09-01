<?php
function apr_side_tabbed() {
global $apr_settings;
$contact = isset($apr_settings['side-contact']) ? $apr_settings['side-contact'] :"";
$google_map = isset($apr_settings['side-map']) ? $apr_settings['side-map']:"";

echo '<ul class="social_widgets social">'; 
if($contact){ 
$form_shortcode = isset($apr_settings['form_contact']) ? $apr_settings['form_contact'] :"";    
echo '<li class="soc_block_mail">
      <div class="sw_content">
        <h4>'.esc_html__('Contact us','barber').'</h4>
        <p>'.esc_html__('Contact us today for further info:','barber').'</p>';
       ?>
       <?php 
        if($form_shortcode != ""){
          echo do_shortcode(''.$form_shortcode.'');
        }
       ?> 
      </div>  

    </li><?php
}
if($google_map):?>    
<li class="soc_block_marker">
      <div class="sw_content">
        <h4><?php echo esc_html__('Store Location','barber'); ?></h4>
        <ul class="c_info_list">
          <?php if (!empty($apr_settings['store-contact-location'])): ?>
          <li>

            <div class="clearfix">
              <i class="icon-location"></i>
              <p class="contact_e"><?php echo esc_html($apr_settings['store-contact-location']); ?></p>
              <div class="soc_google_map">
              <?php echo wp_kses($apr_settings['iframe-google-map'],array(
                  'iframe' => array(
                    'height' => array(),
                    'frameborder' => array(),
                    'style' => array(),
                    'src' => array(),
                    'allowfullscreen' => array(),
                    )
                )); ?>
              </div>
            </div>

          </li>
          <?php endif;?>
          <?php if (!empty($apr_settings['store-contact-phonenumber'])): ?>
          <li>

            <div class="clearfix">
              <i class="icon-phone-1"></i>
              <p class="contact_e"><?php echo esc_html($apr_settings['store-contact-phonenumber']); ?></p>
            </div>

          </li>
          <?php endif;?>
          <?php if (!empty($apr_settings['store-contact-email'])): ?>
          <li>

            <div class="clearfix">
              <i class="icon-email"></i>
              <a class="contact_e" href="mailto:<?php echo esc_attr($apr_settings['store-contact-email']); ?>"><?php echo esc_html($apr_settings['store-contact-email']); ?></a>
            </div>

          </li>
          <?php endif;?>
          <?php if (!empty($apr_settings['store-contact-time'])): ?>
          <li>

            <div class="clearfix">
              <i class="icon-clock"></i>
              <p class="contact_e"><?php echo esc_html($apr_settings['store-contact-time']); ?></p>
            </div>

          </li>
          <?php endif;?>
        </ul>
      </div>  

    </li>
<?php endif;  
echo '</ul>' ; 
}