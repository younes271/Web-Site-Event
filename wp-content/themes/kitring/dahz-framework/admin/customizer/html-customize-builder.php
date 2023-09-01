<?php
	$builder_type	= $_POST['builder_type'];
	$builder_class	= 'de-custom-'. $builder_type;
	$builder_title	= '';
	switch( $builder_type ) {
		case 'header':
			$builder_title = 'Header';
			break;
		case 'footer':
			$builder_title = 'Footer';
			break;
		case 'headermobile':
			$builder_title = 'Header Mobile';
			break;
	}
?>
<div class="de-wrapper-<?php echo esc_attr( $builder_type ); ?>-builder">
	<div id="de-<?php echo esc_attr( $builder_type ); ?>-use" class="de-<?php echo esc_attr( $builder_type ); ?>-use" data-status="saved" data-<?php echo esc_attr( $builder_type ); ?>="<?php echo esc_attr( $builder_type ); ?>"></div>
	<div class="<?php echo esc_attr( $builder_class ); ?>__wrapper">
		<div class="<?php echo esc_attr( $builder_class ); ?>__wrapper-tooltip">
			<span class="<?php echo esc_attr( $builder_class ); ?>__wrapper-title">
				<span class="<?php echo esc_attr( $builder_class ); ?>__wrapper-default-preset-title">
					<?php printf( esc_html__( '%s Builder', 'kitring' ), $builder_title ); ?>
				</span>
			</span>
			<span class="<?php echo esc_attr( $builder_class ); ?>__wrapper-preview">
				<a class="<?php echo esc_attr( $builder_class ); ?>__wrapper-preview-action" data-trigger="preview-desktop"><?php esc_attr_e( 'Desktop', 'kitring' ); ?></a>
				<a class="<?php echo esc_attr( $builder_class ); ?>__wrapper-preview-action" data-trigger="preview-mobile"><?php esc_attr_e( 'Tablet/Mobile', 'kitring' ); ?></a>
			</span>
			<span class="<?php echo esc_attr( $builder_class ); ?>__wrapper-right">
				<a class="<?php echo esc_attr( $builder_class ); ?>__wrapper-default"><?php echo esc_html__( 'Set as Default', 'kitring' ); ?></a>
				<a class="<?php echo esc_attr( $builder_class ); ?>__wrapper-default-set"><?php echo esc_html__( 'Default Preset', 'kitring' ); ?></a>
				<a class="<?php echo esc_attr( $builder_class ); ?>__wrapper-open-container"><?php echo esc_html__( 'Save Preset', 'kitring' ); ?></a>
				<a class="<?php echo esc_attr( $builder_class ); ?>__wrapper-default-cancel"><?php echo esc_html__( 'Cancel Edit', 'kitring' ); ?></a>
				<div class="<?php echo esc_attr( $builder_class ); ?>__wrapper-preset-container">
					<div class="<?php echo esc_attr( $builder_class ); ?>__wrapper-preset-container-inner-wrapper">
						<span class="<?php echo esc_attr( $builder_class ); ?>__wrapper-preset-title">
							<?php echo esc_html__( 'Save Header as Preset', 'kitring' ); ?>
							<a class="<?php echo esc_attr( $builder_class ); ?>__wrapper-preset-container-close">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
									<path d="M207,182.8c-6.7-6.7-17.6-6.7-24.3,0s-6.7,17.6,0,24.3l38,38l-38,38c-6.7,6.7-6.7,17.6,0,24.3c3.3,3.3,7.7,5,12.1,5 c4.4,0,8.8-1.7,12.1-5l38-38l38,38c3.3,3.3,7.7,5,12.1,5s8.8-1.7,12.1-5c6.7-6.7,6.7-17.6,0-24.3l-38-38l38-38 c6.7-6.7,6.7-17.6,0-24.3s-17.6-6.7-24.3,0l-38,38L207,182.8z"/>
									<path d="M0,245c0,135.1,109.9,245,245,245s245-109.9,245-245S380.1,0,245,0S0,109.9,0,245z M455.7,245 c0,116.2-94.5,210.7-210.7,210.7S34.3,361.2,34.3,245S128.8,34.3,245,34.3S455.7,128.8,455.7,245z"/>
								</svg>
							</a>
						</span>
						<div class="<?php echo esc_attr( $builder_class ); ?>__wrapper-preset-container-save">
							<p><?php echo esc_html__( 'Save current layout as a template', 'kitring' ); ?></p>
							<div class="<?php echo esc_attr( $builder_class ); ?>__wrapper-preset-container-inner">
								<input type="text" id="de-<?php echo esc_attr( $builder_type ); ?>-builder-preset-name"/>
								<?php
									if ( DAHZ_FRAMEWORK_DEVELOP_MODE ) {
										printf(
											'
											<label for="de-%1$s-builder-preset-category-id">%2$s</label>
											<input type="text" id="de-%1$s-builder-preset-category-id" placeholder="%3$s"/>

											<label for="de-%1$s-builder-preset-category-name">%4$s</label>
											<input type="text" id="de-%1$s-builder-preset-category-name" placeholder="%5$s"/>

											<label for="de-%1$s-builder-preset-title">%6$s</label>
											<input type="text" id="de-%1$s-builder-preset-title" placeholder="%7$s"/>

											<label for="de-%1$s-builder-preset-image">%8$s</label>
											<input type="text" id="de-%1$s-builder-preset-image" placeholder="%9$s"/>
											',
											esc_attr( $builder_type ),

											esc_html__( 'Preset Category ID', 'kitring' ),
											esc_attr__( 'Preset Category ID', 'kitring' ),

											esc_html__( 'Preset Category Name', 'kitring' ),
											esc_attr__( 'Preset Category Name', 'kitring' ),

											esc_html__( 'Preset Title', 'kitring' ),
											esc_attr__( 'Preset Title', 'kitring' ),

											esc_html__( 'Preset Image ( Notes : put only image name and images file must be exist in directory "kitring/dahz-framework/admin/customizer/presets/images/" )', 'kitring' ),
											esc_attr__( 'Preset Image', 'kitring' )

										);
									}
								?>
								<p><?php echo esc_html__( 'Save layout and reuse it on different sections of this site', 'kitring' ); ?></p>
							</div>
						</div>
						<div class="<?php echo esc_attr( $builder_class ); ?>__wrapper-preset-container-edit">
							<p><?php echo esc_html__( 'Are you sure want to change preset?', 'kitring' ); ?></p>
						</div>
						<a class="<?php echo esc_attr( $builder_class ); ?>__wrapper-save"><?php echo esc_html__( 'Save Preset', 'kitring' ); ?></a>
					</div>
				</div>
				<a class="<?php echo esc_attr( $builder_class ); ?>__wrapper-icon">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
						<path d="M490,245C490,109.9,380.1,0,245,0S0,109.9,0,245s109.9,245,245,245S490,380.1,490,245z M34.3,245 c0-116.2,94.5-210.7,210.7-210.7S455.7,128.8,455.7,245S361.2,455.7,245,455.7S34.3,361.2,34.3,245z"/>
						<path d="M302.3,232.9l-72.1-72.1c-6.7-6.7-17.6-6.7-24.3,0s-6.7,17.6,0,24.3l60,60l-60,60c-6.7,6.7-6.7,17.6,0,24.3 c3.3,3.3,7.7,5,12.1,5c4.4,0,8.8-1.7,12.1-5l72.1-72.1C309,250.4,309,239.6,302.3,232.9z"/>
					</svg>
				</a>
			</span>
		</div>
		<div class="<?php echo esc_attr( $builder_class ); ?> <?php echo esc_attr( $builder_class ); ?>__builder">
			<?php
				for ($i = 1; $i <= 3; $i++) {
					$sectionID = "{$i}";
					?>
						<div class="<?php echo esc_attr( $builder_class ); ?>__inner <?php echo esc_attr( $builder_class ); ?>__section" data-section-<?php echo esc_attr( $builder_type ); ?>="<?php echo esc_attr( $sectionID ); ?>">
							<div class="<?php echo esc_attr( $builder_class ); ?>__tooltip">
								<p><?php echo esc_html__( 'Section ', 'kitring' ) . $i?></p>
								<a class="<?php echo esc_attr( $builder_class ); ?>__tooltip-hide"></a>
							</div>
							<div class="<?php echo esc_attr( $builder_class ); ?>__section-wrapper">
								<div class="<?php echo esc_attr( $builder_class ); ?>__section-inner">

								</div>
								<a class="<?php echo esc_attr( $builder_class ); ?>__content-new">
									<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
										<path d="M17.1,490h349.4c9.5,0,17.2-7.7,17.2-17.2v-89.2h89.2c9.5,0,17.1-7.7,17.1-17.1V17.1C490,7.6,482.3,0,472.9,0H123.5 c-9.5,0-17.2,7.7-17.2,17.1v89.2H17.1C7.6,106.3,0,114,0,123.5v349.4C0,482.3,7.7,490,17.1,490z M140.6,34.3h315.1v315.1H140.6 V34.3z M34.3,140.6h72v225.9c0,9.5,7.7,17.1,17.2,17.1h225.9v72H34.3V140.6z"/>
										<path d="M219.5,209H281v61.5c0,9.5,7.7,17.2,17.2,17.2s17.1-7.7,17.1-17.2V209h61.5c9.5,0,17.1-7.7,17.1-17.2 s-7.7-17.2-17.1-17.2h-61.5v-61.5c0-9.5-7.7-17.2-17.1-17.2c-9.5,0-17.2,7.7-17.2,17.2v61.5h-61.5c-9.5,0-17.1,7.7-17.1,17.2 C202.3,201.3,210,209,219.5,209z"/>
									</svg>
								</a>
							</div>
						</div>
					<?php
				}
			?>
			<div class="<?php echo esc_attr( $builder_class ); ?>__element-storage">
				<div class="<?php echo esc_attr( $builder_class ); ?>__wrapper-tooltip">
					<span class="<?php echo esc_attr( $builder_class ); ?>__wrapper-title">
						<span class="<?php echo esc_attr( $builder_class ); ?>__wrapper-default-preset-title">
							<?php printf( esc_html__( '%s Element', 'kitring' ), $builder_type ); ?>
						</span>
					</span>
					<a class="<?php echo esc_attr( $builder_class ); ?>__element-storage-close">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
							<path d="M207,182.8c-6.7-6.7-17.6-6.7-24.3,0s-6.7,17.6,0,24.3l38,38l-38,38c-6.7,6.7-6.7,17.6,0,24.3c3.3,3.3,7.7,5,12.1,5 c4.4,0,8.8-1.7,12.1-5l38-38l38,38c3.3,3.3,7.7,5,12.1,5s8.8-1.7,12.1-5c6.7-6.7,6.7-17.6,0-24.3l-38-38l38-38 c6.7-6.7,6.7-17.6,0-24.3s-17.6-6.7-24.3,0l-38,38L207,182.8z"/>
							<path d="M0,245c0,135.1,109.9,245,245,245s245-109.9,245-245S380.1,0,245,0S0,109.9,0,245z M455.7,245 c0,116.2-94.5,210.7-210.7,210.7S34.3,361.2,34.3,245S128.8,34.3,245,34.3S455.7,128.8,455.7,245z"/>
						</svg>
					</a>
				</div>
				<div class="<?php echo esc_attr( $builder_class ); ?>__element-item-wrapper">
					<?php dahz_framework_customize_render_builder_items( $builder_type ); ?>
				</div>
			</div>
			<div class="<?php echo esc_attr( $builder_class ); ?>__column-edit-container">
				<div class="<?php echo esc_attr( $builder_class ); ?>__column-edit-container-inner-wrapper">
					<span class="<?php echo esc_attr( $builder_class ); ?>__column-edit-title">
						<?php echo esc_html__( 'Edit Column', 'kitring' ); ?>
						<a class="<?php echo esc_attr( $builder_class ); ?>__column-edit-container-close">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
								<path d="M207,182.8c-6.7-6.7-17.6-6.7-24.3,0s-6.7,17.6,0,24.3l38,38l-38,38c-6.7,6.7-6.7,17.6,0,24.3c3.3,3.3,7.7,5,12.1,5 c4.4,0,8.8-1.7,12.1-5l38-38l38,38c3.3,3.3,7.7,5,12.1,5s8.8-1.7,12.1-5c6.7-6.7,6.7-17.6,0-24.3l-38-38l38-38 c6.7-6.7,6.7-17.6,0-24.3s-17.6-6.7-24.3,0l-38,38L207,182.8z"/>
								<path d="M0,245c0,135.1,109.9,245,245,245s245-109.9,245-245S380.1,0,245,0S0,109.9,0,245z M455.7,245 c0,116.2-94.5,210.7-210.7,210.7S34.3,361.2,34.3,245S128.8,34.3,245,34.3S455.7,128.8,455.7,245z"/>
							</svg>
						</a>
					</span>
					<p><?php echo esc_html__( 'Alignment', 'kitring' ); ?></p>
					<div class="<?php echo esc_attr( $builder_class ); ?>__column-edit-container-inner">
						<select id="de-<?php echo esc_attr( $builder_type ); ?>-builder-column-alignment">
							<option value="flex-start"><?php esc_html_e( 'Left', 'kitring' ); ?></option>
							<option value="flex-center"><?php esc_html_e( 'Center', 'kitring' ); ?></option>
							<option value="flex-end"><?php esc_html_e( 'Right', 'kitring' ); ?></option>
						</select>
					</div>
					<p><?php echo esc_html__( 'Extra class name', 'kitring' ); ?></p>
					<div class="<?php echo esc_attr( $builder_class ); ?>__column-edit-container-inner">
						<input type="text" id="de-<?php echo esc_attr( $builder_type ); ?>-builder-column-extraclass" />
						<p><?php echo esc_html__( 'Adding extra class', 'kitring' ); ?></p>
					</div>
					<div class="<?php echo esc_attr( $builder_class ); ?>__column-edit-container-section2-vertical">
						<p><?php echo esc_html__( 'Padding Top', 'kitring' ); ?></p>
						<div class="<?php echo esc_attr( $builder_class ); ?>__column-edit-container-inner">
							<input type="text" id="de-<?php echo esc_attr( $builder_type ); ?>-builder-column-padding-top" />
							<p><?php echo esc_html__( 'Adding Padding Top', 'kitring' ); ?></p>
						</div>
						<p><?php echo esc_html__( 'Padding Bottom', 'kitring' ); ?></p>
						<div class="<?php echo esc_attr( $builder_class ); ?>__column-edit-container-inner">
							<input type="text" id="de-<?php echo esc_attr( $builder_type ); ?>-builder-column-padding-bottom" />
							<p><?php echo esc_html__( 'Adding Padding Bottom', 'kitring' ); ?></p>
						</div>
					</div>
					<a class="<?php echo esc_attr( $builder_class ); ?>__column-edit-save"><?php echo esc_html__( 'Save', 'kitring' ); ?></a>
				</div>
			</div>
			<div class="<?php echo esc_attr( $builder_class ); ?>__custom-row-edit-container">
				<div class="<?php echo esc_attr( $builder_class ); ?>__custom-row-edit-container-inner-wrapper">
					<span class="<?php echo esc_attr( $builder_class ); ?>__custom-row-edit-title">
						<?php echo esc_html__( 'Custom Row', 'kitring' ); ?>
						<a class="<?php echo esc_attr( $builder_class ); ?>__custom-row-edit-container-close">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
								<path d="M207,182.8c-6.7-6.7-17.6-6.7-24.3,0s-6.7,17.6,0,24.3l38,38l-38,38c-6.7,6.7-6.7,17.6,0,24.3c3.3,3.3,7.7,5,12.1,5 c4.4,0,8.8-1.7,12.1-5l38-38l38,38c3.3,3.3,7.7,5,12.1,5s8.8-1.7,12.1-5c6.7-6.7,6.7-17.6,0-24.3l-38-38l38-38 c6.7-6.7,6.7-17.6,0-24.3s-17.6-6.7-24.3,0l-38,38L207,182.8z"/>
								<path d="M0,245c0,135.1,109.9,245,245,245s245-109.9,245-245S380.1,0,245,0S0,109.9,0,245z M455.7,245 c0,116.2-94.5,210.7-210.7,210.7S34.3,361.2,34.3,245S128.8,34.3,245,34.3S455.7,128.8,455.7,245z"/>
							</svg>
						</a>
					</span>
					<p><?php echo esc_html__( 'Custom Row', 'kitring' ); ?></p>
					<div class="<?php echo esc_attr( $builder_class ); ?>__custom-row-edit-container-inner">
						<input type="text" id="de-<?php echo esc_attr( $builder_type ); ?>-builder-custom-row-input" />
						<p><?php echo esc_html__( 'example : 1/2+1/2', 'kitring' ); ?></p>
					</div>
					<a class="<?php echo esc_attr( $builder_class ); ?>__custom-row-edit-save"><?php echo esc_html__( 'Save', 'kitring' ); ?></a>
				</div>
			</div>
		</div>
		<div class="<?php echo esc_attr( $builder_class ); ?>__wrapper-tooltip">
			<span class="<?php echo esc_attr( $builder_class ); ?>__wrapper-title">
				<span class="<?php echo esc_attr( $builder_class ); ?>__wrapper-default-preset-title--borderless">
					<?php printf( esc_html__( '%s Preset', 'kitring' ), $builder_title ); ?>
				</span>
			</span>
			<a class="<?php echo esc_attr( $builder_class ); ?>__wrapper-icon">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
					<path d="M490,245C490,109.9,380.1,0,245,0S0,109.9,0,245s109.9,245,245,245S490,380.1,490,245z M34.3,245 c0-116.2,94.5-210.7,210.7-210.7S455.7,128.8,455.7,245S361.2,455.7,245,455.7S34.3,361.2,34.3,245z"/>
					<path d="M302.3,232.9l-72.1-72.1c-6.7-6.7-17.6-6.7-24.3,0s-6.7,17.6,0,24.3l60,60l-60,60c-6.7,6.7-6.7,17.6,0,24.3 c3.3,3.3,7.7,5,12.1,5c4.4,0,8.8-1.7,12.1-5l72.1-72.1C309,250.4,309,239.6,302.3,232.9z"/>
				</svg>
			</a>
		</div>
		<div class="<?php echo esc_attr( $builder_class ); ?> <?php echo esc_attr( $builder_class ); ?>__preset">
			<div class="<?php echo esc_attr( $builder_class ); ?>__preset-inner">
				<?php dahz_framework_render_default_presets( $builder_type ); ?>
			</div>
		</div>
	</div>
	<div class="<?php echo esc_attr( $builder_class ); ?>__inner-control">
		<a class="builder-<?php echo esc_attr( $builder_type ); ?>-control"><i class="fa fa-caret-up builder-arrow-control" aria-hidden="true"></i></a>
	</div>
</div>