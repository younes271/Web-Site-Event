<?php
/**
 * The Header column template file

 * @params
 * $enable_contact
 * $icon_ratio
 * $enable_opening_hours
 * $enable_address
 * $phone
 * $email
 * $opening_hours_line_1
 * $opening_hours_line_2
 * $address_line_1
 * $address_line_2
 * $link_map

 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */
?>
<div class="uk-width-1-1@m">
<?php if( $enable_contact ):?>
	<div class="de-header__section-contact-item">
		<span class="uk-icon" data-uk-icon="icon: receiver; ratio: <?php echo esc_attr( $icon_ratio );?>" ></span>
		<div class="de-header__section-contact-item--inner">
			<span class="de-header__section-contact-item--inner__item item-1"><?php echo esc_html( $phone ); ?></span>
			<span class="de-header__section-contact-item--inner__item item-2"><?php echo esc_html( $email ); ?></span>
		</div>
	</div>
	<!-- Render Contact -->
<?php endif;?>
<?php if( $enable_opening_hours ):?>
	<div class="de-header__section-contact-item">
		<span class="uk-icon" data-uk-icon="icon: clock; ratio: <?php echo esc_attr( $icon_ratio );?>"></span>
		<div class="de-header__section-contact-item--inner">
			<span class="de-header__section-contact-item--inner__item item-1"><?php echo esc_html( $opening_hours_line_1 ); ?></span>
			<span class="de-header__section-contact-item--inner__item item-2"><?php echo esc_html( $opening_hours_line_2 ); ?></span>
		</div>
	</div>
	<!-- Render Contact -->
<?php endif;?>
<?php if( $enable_address ):?>
	<div class="de-header__section-contact-item">
			<a href="<?php echo esc_url( $link_map ) ?>">
				<span class="uk-icon" data-uk-icon="icon: home; ratio: <?php echo esc_attr( $icon_ratio );?>"></span>
			</a>
			<div class="de-header__section-contact-item--inner">
				<span class="de-header__section-contact-item--inner__item item-1"><?php echo esc_html( $address_line_1 ); ?></span>
				<span class="de-header__section-contact-item--inner__item item-2"><?php echo esc_html( $address_line_2 ); ?></span>
			</div>
	</div>
	<!-- Render Contact -->
<?php endif;?>
</div>