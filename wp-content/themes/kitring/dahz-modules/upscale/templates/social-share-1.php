<li class="de-social-share__list<?php echo esc_attr( $mobile_only ) ? ' uk-hidden@m' : '';?>">
	<a aria-label="<?php echo esc_attr( $title );?>" class="ds-social-share" onclick="return false" href="<?php echo esc_url( $url ); ?>"<?php echo !empty( $color ) ? ' style="color:'. esc_attr( $color ) .';"' : '';?>>
		<?php echo apply_filters( 'dahz_framework_social_share_icon', $icon );?>
	</a>
</li>