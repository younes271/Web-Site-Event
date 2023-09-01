jQuery(function ($) {
	"use strict";
	var api = wp.customize,
		headerPanel = api.panel('header'),
		footerPanel = api.panel('footer'),
		DFCustomizerExportImport = function () {
			var _this = this;

			if (dfExportImport.messages.dahzExportImportError !== '') {
				alert(dfExportImport.messages.dahzExportImportError);
			}
			$('.dahz-customizer-uploading').hide();
			$('input[name="dahz-preset-export"]').on('click', _this.preset_export);
			$('input[name="dahz-preset-import"]').on('click', _this.preset_import);
			$('input[name="dahz-customizer-export"]').on('click', _this._export);
			$('input[name="dahz-customizer-export-color-scheme"]').on('click', _this._exportColorScheme);
			$('input[name="dahz-customizer-import"]').on('click', _this._import);
		},
		DFCustomizeMergeScripts = function () {
			var _this = this;

			$('input[name="dahz-purge-merged-scripts"]').on('click', _this.purge_scripts);
		},
		DFBuilderCustomizer = function (builderType, builderControl, builderControlEdit, builderControlIsEdit, builderControlPresetUsed, builderControlIsUsePreset, panel) {
			var _this = this;

			_this.defaultCols = {
				col_1_1: {
					icon: `<span>1/1</span>`,
					value: '1/1'
				},
				col_1_2: {
					icon: `<span>1/2 + 1/2</span>`,
					value: '1/2+1/2'
				},
				col_1_3: {
					icon: `<span>1/3 + 1/3 + 1/3</span>`,
					value: '1/3+1/3+1/3'
				},
				col_1_4: {
					icon: `<span>1/4 + 1/4 + 1/4 + 1/4</span>`,
					value: '1/4+1/4+1/4+1/4'
				},
				col_1_5: {
					icon: `<span>1/5 + 1/5 + 1/5 + 1/5 + 1/5</span>`,
					value: '1/5+1/5+1/5+1/5+1/5'
				},
				col_1_6: {
					icon: `<span>1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6</span>`,
					value: '1/6+1/6+1/6+1/6+1/6+1/6'
				},
				col_2_3_1_3: {
					icon: `<span>2/3 + 1/3</span>`,
					value: '2/3+1/3'
				},
				col_1_3_2_3: {
					icon: `<span>1/3 + 2/3</span>`,
					value: '1/3+2/3'
				},
				col_3_4_1_4: {
					icon: `<span>3/4 + 1/4</span>`,
					value: '3/4+1/4'
				},
				col_1_4_3_4: {
					icon: `<span>1/4 + 3/4</span>`,
					value: '1/4+3/4'
				},
				col_1_2_1_4_1_4: {
					icon: `<span>1/2 + 1/4 + 1/4</span>`,
					value: '1/2+1/4+1/4'
				},
				col_1_4_1_4_1_2: {
					icon: `<span>1/4 + 1/4 + 1/2</span>`,
					value: '1/4+1/4+1/2'
				},
				col_1_4_1_2_1_4: {
					icon: `<span>1/4 + 1/2 + 1/4</span>`,
					value: '1/4+1/2+1/4'
				},
				col_2_5_1_5_2_5: {
					icon: `<span>2/5 + 1/5 + 2/5</span>`,
					value: '2/5+1/5+2/5'
				},
				col_3_5_1_5_1_5: {
					icon: `<span>3/5 + 1/5 + 1/5</span>`,
					value: '3/5+1/5+1/5'
				},
				col_1_5_1_5_3_5: {
					icon: `<span>1/5 + 1/5 + 3/5</span>`,
					value: '1/5+1/5+3/5'
				},
				col_1_5_3_5_1_5: {
					icon: `<span>1/5 + 3/5 + 1/5</span>`,
					value: '1/5+3/5+1/5'
				},
				col_2_5_3_5: {
					icon: `<span>2/5 + 3/5</span>`,
					value: '2/5+3/5'
				},
				col_3_5_2_5: {
					icon: `<span>3/5 + 2/5</span>`,
					value: '3/5+2/5'
				},
				col_1_6_2_3_1_6: {
					icon: `<span>1/6 + 2/3 + 1/6</span>`,
					value: '1/6+2/3+1/6'
				},
				col_5_6_1_6: {
					icon: `<span>5/6 + 1/6</span>`,
					value: '5/6+1/6'
				},
				col_1_6_5_6: {
					icon: `<span>1/6 + 5/6</span>`,
					value: '1/6+5/6'
				},
				col_1_2_1_6_1_6_1_6: {
					icon: `<span>1/2 + 1/6 + 1/6 + 1/6</span>`,
					value: '1/2+1/6+1/6+1/6'
				},
				col_1_6_1_6_1_6_1_2: {
					icon: `<span>1/6 + 1/6 + 1/6 + 1/2</span>`,
					value: '1/6+1/6+1/6+1/2'
				},
			};
			_this.builderIsVertical = builderType == 'header' ? api.control('logo_and_site_identity_header_style').setting.get() == 'vertical' || api.control('logo_and_site_identity_header_style').setting.get() == 'hide' ? true : false : false;
			_this.builderType = builderType;
			_this.builderControl = builderControl;
			_this.builderControlEdit = builderControlEdit;
			_this.builderControlEditName = '';
			_this.builderControlIsEdit = builderControlIsEdit;
			_this.builderControlPresetUsed = builderControlPresetUsed;
			_this.builderControlIsUsePreset = builderControlIsUsePreset;
			_this.builderValue = _this.parseJson(_this.builderControl.setting.get());
			_this.hasOwnProperty = Object.prototype.hasOwnProperty;
			_this.row = {};
			_this.column = {};
			_this.item = [];
			_this.itemActionContent = `
				<span class="de-custom-` + _this.builderType + `__element-action">
					<a data-element-action="edit">
						Edit
						<span class="de-custom-` + _this.builderType + `__element-icon">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 489.8 489.8" style="enable-background:new 0 0 489.8 489.8;" xml:space="preserve">
								<path d="M343.45,71.8c-14.4-8.2-29.7-14.6-45.7-19V36.5c0-20.1-16.4-36.5-36.5-36.5h-32.5c-20.1,0-36.5,16.4-36.5,36.5v16.3 c-16,4.4-31.3,10.7-45.7,19l-11.6-11.5c-6.9-6.9-16.1-10.7-25.8-10.7s-18.9,3.8-25.8,10.7l-23,23c-6.9,6.9-10.7,16.1-10.7,25.8 s3.8,18.9,10.7,25.8l11.5,11.5c-8.2,14.4-14.6,29.7-19,45.7h-16.3c-20.1,0-36.5,16.4-36.5,36.5v32.5c0,20.1,16.4,36.5,36.5,36.5 h16.3c4.4,16,10.7,31.3,19,45.7l-11.5,11.6c-14.2,14.2-14.2,37.4,0,51.6l23,23c6.9,6.9,16.1,10.7,25.8,10.7s18.9-3.8,25.8-10.7 l11.5-11.5c14.4,8.2,29.7,14.6,45.7,19v16.3c0,20.1,16.4,36.5,36.5,36.5h32.5c20.1,0,36.5-16.4,36.5-36.5V437 c16-4.4,31.3-10.7,45.7-19l11.5,11.5c6.9,6.9,16.1,10.7,25.8,10.7s18.9-3.8,25.8-10.7l23-23c14.2-14.2,14.2-37.4,0-51.6 l-11.5-11.5c8.2-14.4,14.6-29.7,19-45.7h16.3c20.1,0,36.5-16.4,36.5-36.5v-32.5c0-20.1-16.4-36.5-36.5-36.5h-16.3 c-4.4-16-10.7-31.3-19-45.7l11.5-11.5c14.2-14.2,14.2-37.4,0-51.6l-23-23c-6.9-6.9-16.1-10.7-25.8-10.7s-18.9,3.8-25.8,10.7 L343.45,71.8z M379.25,84.5c0.9-0.9,2.2-0.9,3.1,0l23,23c0.9,0.9,0.9,2.2,0,3.1l-21.1,21.1c-5.8,5.8-6.7,14.9-2.1,21.7 c12.1,18,20.3,38,24.5,59.2c1.6,8,8.6,13.8,16.8,13.8h29.9c1.2,0,2.2,1,2.2,2.2v32.5c0,1.2-1,2.2-2.2,2.2h-29.9 c-8.2,0-15.2,5.8-16.8,13.8c-4.2,21.3-12.5,41.2-24.5,59.2c-4.6,6.8-3.7,15.9,2.1,21.7l21.1,21.1c0.9,0.9,0.9,2.2,0,3.1l-23,23 c-0.8,0.9-2.2,0.8-3.1,0l-21.1-21.1c-5.8-5.8-14.9-6.7-21.7-2.1c-18.1,12.1-38,20.3-59.2,24.5c-8,1.6-13.8,8.6-13.8,16.8v29.9 c0,1.2-1,2.2-2.2,2.2h-32.5c-1.2,0-2.2-1-2.2-2.2v-29.9c0-8.2-5.8-15.2-13.8-16.8c-21.2-4.2-41.2-12.5-59.2-24.5 c-2.9-1.9-6.2-2.9-9.5-2.9c-4.4,0-8.8,1.7-12.1,5l-21.1,21.1c-0.9,0.9-2.2,0.9-3.1,0l-23-23c-0.9-0.9-0.9-2.2,0-3.1l21.1-21.1 c5.8-5.8,6.7-14.9,2.1-21.7c-12.1-18.1-20.3-38-24.5-59.2c-1.6-8-8.6-13.8-16.8-13.8h-30.1c-1.2,0-2.2-1-2.2-2.2v-32.5 c0-1.2,1-2.2,2.2-2.2h29.9c8.2,0,15.2-5.8,16.8-13.8c4.2-21.2,12.5-41.2,24.5-59.2c4.5-6.8,3.7-15.9-2.1-21.7l-21.1-21.1 c-0.4-0.4-0.6-0.9-0.6-1.6c0-0.6,0.2-1.1,0.6-1.5l23-23c0.9-0.9,2.2-0.9,3.1,0l21.1,21.1c5.8,5.8,14.9,6.7,21.7,2.1 c18.1-12.1,38-20.3,59.2-24.5c8-1.6,13.8-8.6,13.8-16.8V36.5c0-1.2,1-2.2,2.2-2.2h32.5c1.2,0,2.2,1,2.2,2.2v29.9 c0,8.2,5.8,15.2,13.8,16.8c21.2,4.2,41.2,12.5,59.2,24.5c6.8,4.5,15.9,3.7,21.7-2.1L379.25,84.5z"/>
								<path d="M244.95,145.3c-54.9,0-99.6,44.7-99.6,99.6s44.7,99.6,99.6,99.6s99.6-44.7,99.6-99.6S299.85,145.3,244.95,145.3z M244.95,310.2c-36,0-65.3-29.3-65.3-65.3s29.3-65.3,65.3-65.3s65.3,29.3,65.3,65.3S280.95,310.2,244.95,310.2z"/>
							</svg>
						</span>
					</a>
					<a data-element-action="delete">
						Delete
						<span class="de-custom-` + _this.builderType + `__element-icon">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 489.7 489.7" style="enable-background:new 0 0 489.7 489.7;" xml:space="preserve">
								<path d="M411.8,131.7c-9.5,0-17.2,7.7-17.2,17.2v288.2c0,10.1-8.2,18.4-18.4,18.4H113.3c-10.1,0-18.4-8.2-18.4-18.4V148.8 c0-9.5-7.7-17.2-17.1-17.2c-9.5,0-17.2,7.7-17.2,17.2V437c0,29,23.6,52.7,52.7,52.7h262.9c29,0,52.7-23.6,52.7-52.7V148.8 C428.9,139.3,421.2,131.7,411.8,131.7z"/>
								<path d="M457.3,75.9H353V56.1C353,25.2,327.8,0,296.9,0H192.7c-31,0-56.1,25.2-56.1,56.1v19.8H32.3c-9.5,0-17.1,7.7-17.1,17.2 s7.7,17.1,17.1,17.1h425c9.5,0,17.2-7.7,17.2-17.1C474.4,83.5,466.8,75.9,457.3,75.9z M170.9,56.1c0-12,9.8-21.8,21.8-21.8h104.2 c12,0,21.8,9.8,21.8,21.8v19.8H170.9V56.1z"/>
								<path d="M262,396.6V180.9c0-9.5-7.7-17.1-17.1-17.1s-17.1,7.7-17.1,17.1v215.7c0,9.5,7.7,17.1,17.1,17.1 C254.3,413.7,262,406.1,262,396.6z"/>
								<path d="M186.1,396.6V180.9c0-9.5-7.7-17.1-17.2-17.1s-17.1,7.7-17.1,17.1v215.7c0,9.5,7.7,17.1,17.1,17.1 C178.4,413.7,186.1,406.1,186.1,396.6z"/>
								<path d="M337.8,396.6V180.9c0-9.5-7.7-17.1-17.1-17.1s-17.1,7.7-17.1,17.1v215.7c0,9.5,7.7,17.1,17.1,17.1 S337.8,406.1,337.8,396.6z"/>
							</svg>
						</span>
					</a>
				</span>
			`;
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				async: true,
				data: {
					'action': 'df_customize_builder',
					'builder_type': _this.builderType
				},
				success: function (response) {
					$('#customize-preview').after(response).promise().done(function () {
						$(panel.headContainer).attr('is-' + _this.builderType + '-builder-renderred', 'true');
						setTimeout(function () {
							$('.de-custom-' + _this.builderType + '__column-edit-container-inner-wrapper').draggable();
							$('.de-custom-' + _this.builderType + '__custom-row-edit-container-inner-wrapper').draggable();
							$('.de-custom-' + _this.builderType + '__wrapper-preset-container-inner-wrapper').draggable();
							_this.triggerEmulator();
							_this.triggerEmulatorBuilder();
							_this.setBuilder();
							_this.togglePresetContainer();
							_this.init();
							_this.showHideBuilder();
							_this.showHideSection();
							_this.addRow();
							_this.removeRow();
							_this.closeItemsStorage();
							_this.addItems();
							_this.initFilterPreset();
							_this.savePreset();
							_this.saveColumnStyle();
							_this.getSavedPresetInit();
							_this.checkSetPresetasDefault();
							_this.setPresetasDefault();
							_this.setDefaultAsTemplate();
							if (_this.builderType == 'header') {
								_this.initChangeHeaderStyleListener();
								_this.BuilderVerticalInit();
							}
						}, 500);
					});
				},
			});
		};

	DFBuilderCustomizer.prototype.init = function () {
		var _this = this;

		_this.builderControlEdit.setting.set('');
		_this.builderControlIsEdit.setting.set('0');
		$('.de-wrapper-' + _this.builderType + '-builder').addClass(_this.builderType + '-builder-active');
		$('.de-custom-' + _this.builderType + '__wrapper-tooltip:first-of-type .de-custom-' + _this.builderType + '__wrapper-icon').trigger('click');
	}
	DFBuilderCustomizer.prototype.initChangeHeaderStyleListener = function () {
		var _this = this;

		$('.ds-' + _this.builderType + '-header-style li a[data-header-style="' + api.control('logo_and_site_identity_header_style').setting.get() + '"]').parent().addClass('selected');
		$('.ds-' + _this.builderType + '-header-style .ds-selected-type').html(api.control('logo_and_site_identity_header_style').setting.get() + ' Header');
		$('.ds-' + _this.builderType + '-header-style li a').on('click',function () {
			if (!$(this).parent().hasClass('selected')) {
				$('.ds-' + _this.builderType + '-header-style li').removeClass('selected');
				$(this).parent().addClass('selected');
				$('input[name="de-builder-' + _this.builderType + '-header-style"]', $('.ds-' + _this.builderType + '-header-style')).val($(this).attr('data-header-style')).trigger('change');
				$('.ds-selected-type').html($(this).attr('data-header-style') + ' Header');
			}
		});
		$('input[name="de-builder-' + _this.builderType + '-header-style"]', $('.ds-' + _this.builderType + '-header-style')).on( 'change', function () {
			api.control('logo_and_site_identity_header_style').setting.set(this.value)
		});
	}
	DFBuilderCustomizer.prototype.parseJson = function (stringJson) {
		var _this = this,
			obj;

		try {
			obj = $.parseJSON(stringJson);
			if (typeof obj == 'object' && obj !== null) {

				if (typeof obj['1'] == 'object' && $.isEmptyObject(obj['1'])) {
					obj['1'] = {};
				}
				if (typeof obj['2'] == 'object' && $.isEmptyObject(obj['2'])) {
					obj['2'] = {};
				}
				if (typeof obj['3'] == 'object' && $.isEmptyObject(obj['3'])) {
					obj['3'] = {};
				}
				return obj;
			} else {
				return {
					'1': {},
					'2': {},
					'3': {}
				};
			}
		} catch (err) {
			return {
				'1': {},
				'2': {},
				'3': {}
			};
		}
	}
	DFBuilderCustomizer.prototype.isEmpty = function (obj) {
		var _this = this;

		if (obj == null) return true;
		if (obj.length > 0) return false;
		if (obj.length === 0) return true;
		if (typeof obj !== "object") return true;
		for (var key in obj) {
			if (_this.hasOwnProperty.call(obj, key)) return false;
		}
		return true;
	}
	DFBuilderCustomizer.prototype.destroy = function () {
		var _this = this;

		if (_this.builderControlIsEdit.setting.get() == 1) {
			_this.setBuilderValue(_this.parseJson(_this.builderControl.setting.get()));
			_this.setBuilder();
			_this.builderControlEdit.setting.set('');
			_this.builderControlIsEdit.setting.set('0');
		}
		$('.de-wrapper-' + _this.builderType + '-builder').removeClass(_this.builderType + '-builder-active');
	}
	DFBuilderCustomizer.prototype.generateID = function () {
		return Math.floor((1 + Math.random()) * 0x10000)
			.toString(16)
			.substring(1);
	}
	DFBuilderCustomizer.prototype.uniqid = function (prefix) {
		var _this = this;

		return prefix + '-' + _this.generateID() + _this.generateID() + '-' + _this.generateID() + _this.generateID();
	}
	DFBuilderCustomizer.prototype.bindValue = function () {
		var _this = this,
			value, valueSanitized;

		valueSanitized = _this.builderValue;
		if (typeof valueSanitized['dataSection'] !== 'undefined') {
			delete valueSanitized['dataSection'];
		}
		value = JSON.stringify(valueSanitized);
		if (_this.builderControlIsEdit.setting.get() == 1) {
			_this.builderControlEdit.setting.set(value);
		} else {
			if (_this.builderControlIsUsePreset.setting.get() == 1) {
				_this.builderControlPresetUsed.setting.set('');
				_this.builderControlIsUsePreset.setting.set('0');
			}
			_this.builderControl.setting.set(value);
		}
	}
	DFBuilderCustomizer.prototype.openItemSection = function () {
		var _this = this,
			itemSection;

		$('.de-custom-' + _this.builderType + '__element-action a[data-element-action="edit"]').off('click');
		$('.de-custom-' + _this.builderType + '__element-action a[data-element-action="edit"]').on('click',function () {
			itemSection = $(this).parents('.de-' + _this.builderType + '-items-registered').attr('data-section');

			if (typeof itemSection !== 'undefined' && itemSection !== '') {
				api.section(itemSection).expand();
			}
		});
	}
	DFBuilderCustomizer.prototype.showHideBuilder = function () {
		var _this = this;

		// Init active class
		$('.de-custom-' + _this.builderType + '__wrapper-tooltip:first-child .de-custom-' + _this.builderType + '__wrapper-icon').addClass('wrapper-icon--active');
		$('.de-custom-' + _this.builderType + '__builder').show({
			step: function (a, b) {
				_this.shortcutTransform(a, b);
			}
		});
		// Toggle show / hide
		$('.de-custom-' + _this.builderType + '__wrapper-icon').on('click',function () {
			if ($(this).hasClass('wrapper-icon--active')) {
				$(this).removeClass('wrapper-icon--active');
				$(this).parents('.de-custom-' + _this.builderType + '__wrapper-tooltip').next().slideUp({
					step: function (a, b) {
						_this.shortcutTransform(a, b);
					}
				});
			} else {
				$('.de-custom-' + _this.builderType + '__wrapper-icon').removeClass('wrapper-icon--active');
				$(this).addClass('wrapper-icon--active');
				$('.de-custom-' + _this.builderType).slideUp();
				$(this).parents('.de-custom-' + _this.builderType + '__wrapper-tooltip').next().slideDown({
					step: function (a, b) {
						_this.shortcutTransform(a, b);
					}
				});
			}
		});
	}
	DFBuilderCustomizer.prototype.showHideSection = function () {
		var _this = this;

		// Init active class
		$('.de-custom-' + _this.builderType + '__section:nth-child(2)').addClass('de-custom-' + _this.builderType + '__section--active');
		$('.de-custom-' + _this.builderType + '__section:nth-child(2) .de-custom-' + _this.builderType + '__section-wrapper').show({
			step: function (a, b) {
				_this.shortcutTransform(a, b);
			}
		});
		// Toggle show / hide
		$('.de-custom-' + _this.builderType + '__tooltip').on('click',function () {
			if (!_this.builderIsVertical) {
				if ($(this).parents('.de-custom-' + _this.builderType + '__section').hasClass('de-custom-' + _this.builderType + '__section--active')) {
					$('.de-custom-' + _this.builderType + '__section').removeClass('de-custom-' + _this.builderType + '__section--active');
					$(':not(.de-custom-' + _this.builderType + '__section--active) .de-custom-' + _this.builderType + '__section-wrapper').slideUp({
						step: function (a, b) {
							_this.shortcutTransform(a, b);
						}
					});
				} else {
					$('.de-custom-' + _this.builderType + '__section').removeClass('de-custom-' + _this.builderType + '__section--active');
					$(this).parents('.de-custom-' + _this.builderType + '__section').addClass('de-custom-' + _this.builderType + '__section--active').promise().done(function () {
						$(':not(.de-custom-' + _this.builderType + '__section--active) .de-custom-' + _this.builderType + '__section-wrapper').slideUp();
						$('.de-custom-' + _this.builderType + '__section--active .de-custom-' + _this.builderType + '__section-wrapper').slideDown({
							step: function (a, b) {
								_this.shortcutTransform(a, b);
							}
						});
					});
				}
			}
		});
	}
	DFBuilderCustomizer.prototype.triggerEmulator = function () {
		var _this = this,
			buttonTrigger;

		// init button active
		$('.de-custom-' + _this.builderType + '__wrapper-preview-action:nth-child(1)').addClass('active');
		// bind builder emulator button event
		$('.de-custom-' + _this.builderType + '__wrapper-preview-action').on('click',function () {
			// get data trigger
			buttonTrigger = $(this).attr('data-trigger');
			// toggle active class on each button
			$('.de-custom-' + _this.builderType + '__wrapper-preview-action').removeClass('active');
			$(this).addClass('active');
			// trigger click button on customizer
			$('#customize-footer-actions .' + buttonTrigger).trigger('click');
		});
	}
	DFBuilderCustomizer.prototype.triggerEmulatorBuilder = function () {
		var _this = this,
			buttonTrigger, buttonClass;

		// bind customizer emulator button event
		$('#customize-footer-actions button').on('click',function () {
			// get data trigger
			buttonTrigger = $(this).attr('data-device');
			// if value = tablet, convert to mobile
			buttonClass = buttonTrigger == 'tablet' ? 'mobile' : buttonTrigger;
			// toggle active class on each button
			$('.de-custom-' + _this.builderType + '__wrapper-preview-action').removeClass('active');
			$('.de-custom-' + _this.builderType + '__wrapper-preview-action[data-trigger="preview-' + buttonClass + '"]').addClass('active');
		});
	}
	DFBuilderCustomizer.prototype.shortcutTransform = function (a, b) {
		var _this = this;

		if (_this.builderType == 'header' || _this.builderType == 'headermobile') {
			var transformVal = ($(b.elem).parents('.de-wrapper-' + _this.builderType + '-builder').height());
			$('.de-customize-shortcut').css({
				'transform': 'translateY(-' + transformVal + 'px)',
				'transition': '0s'
			});
		}
	}

	/** Set Builder */
	DFBuilderCustomizer.prototype.setBuilder = function () {
		var _this = this,
			element = _this.builderValue,
			rows, columns, items,
			rowPosition, columnPosition, itemPosition,
			$section, $row, $column, $item,
			row, column, item,
			rowKeys, columnKeys, itemKeys;

		$('.de-custom-' + _this.builderType + '__content').remove();
		$('.de-' + _this.builderType + '-items', $('.de-custom-' + _this.builderType + '__element-storage')).removeClass('selected');
		for (var section in element) {
			if (section != 'dataSection') {
				$section = $('.de-custom-' + _this.builderType + '__section[data-section-' + _this.builderType + '="' + section + '"]');
				if (!_this.isEmpty(element[section])) {
					rows = element[section];
					// Set Rows
					// Get an array of the keys:
					rowKeys = Object.keys(rows);
					// Then sort by using the keys to lookup the values in the original object:
					rowKeys.sort(function (a, b) {
						return rows[a].position - rows[b].position
					});
					for (var indexRow in rowKeys) {
						row = rowKeys[indexRow];
						_this.setBuilderRow(
							$('.de-custom-' + _this.builderType + '__section-inner', $section),
							row,
							typeof rows[row].columnStyle !== 'undefined' ? rows[row].columnStyle : 'custom',
							typeof rows[row].position !== 'undefined' ? rows[row].position : 0,
							function () {
								$row = $('.de-custom-' + _this.builderType + '__content[data-row-id="' + row + '"]', $section);
								if (!_this.isEmpty(rows[row]['columns'])) {
									columns = rows[row]['columns'];
									// Set Columns
									// Get an array of the keys:
									columnKeys = Object.keys(columns);
									// Then sort by using the keys to lookup the values in the original object:
									columnKeys.sort(function (a, b) {
										return columns[a].position - columns[b].position
									});
									for (var indexColumn in columnKeys) {
										column = columnKeys[indexColumn];
										_this.setBuilderColumn(
											$('.de-custom-' + _this.builderType + '__row', $row),
											column,
											columns[column]['columnClass'],
											columns[column]['columnWidth'],
											typeof columns[column].position !== 'undefined' ? columns[column].position : 0,
											function () {
												$column = $('.de-custom-' + _this.builderType + '__column[data-column-id="' + column + '"]', $row);
												if (!_this.isEmpty(columns[column]['items'])) {
													items = columns[column]['items'];
													// Set Items
													// Get an array of the keys:
													itemKeys = Object.keys(items);
													// Then sort by using the keys to lookup the values in the original object:
													itemKeys.sort(function (a, b) {
														return items[a].position - items[b].position
													});
													for (var indexItem in itemKeys) {
														item = itemKeys[indexItem]
														_this.setBuilderItem(
															$column,
															item,
															items[item].value,
															items[item].section,
															typeof items[item].position !== 'undefined' ? items[item].position : 0,
															function () {});
													}
												}
											});
									}
								}
							});
					}
					_this.openItemSection();
					_this.togglePresetContainer();
					_this.sortableRow(section);
					_this.editColumn();
					_this.initRemoveColumn();
					_this.openRowColumn();
					_this.setRowColumn();
					_this.sortableColumn();
					_this.openItems();
					_this.sortableItems(section);
					_this.initRemoveItem();
				}
			}
		}
	}
	DFBuilderCustomizer.prototype.setBuilderValue = function (json) {
		var _this = this;

		_this.builderValue = json;
		for (var i in _this.builderValue) {
			if ($.isEmptyObject(_this.builderValue[i])) {
				_this.builderValue[i] = {};
			}
		}
	}
	DFBuilderCustomizer.prototype.setBuilderRow = function ($section, row, columnStyle, position, success) {
		var _this = this,
			defaultCols = '',
			selectedDefaultCol = '',
			costumSelected = 'selected',
			customColumnStyle = columnStyle;

		for (var i in _this.defaultCols) {
			selectedDefaultCol = '';
			if (_this.defaultCols[i].value == columnStyle) {
				selectedDefaultCol = 'selected';
				costumSelected = '';
				customColumnStyle = '';
			}
			defaultCols += '<a class="' + selectedDefaultCol + '" data-column="' + _this.defaultCols[i].value + '">' + _this.defaultCols[i].icon + '</a>'
		}
		$section.append(
			`
			<div class="de-custom-` + _this.builderType + `__content" data-row-id="` + row + `">
				<div class="de-custom-` + _this.builderType + `__control">
					<a class="de-custom-` + _this.builderType + `__action de-custom-` + _this.builderType + `__action-move">Move</a>
					<a class="de-custom-` + _this.builderType + `__action de-custom-` + _this.builderType + `__action-column">Column</a>
					<div class="de-custom-` + _this.builderType + `__action de-custom-` + _this.builderType + `__action-control-column">
						<div>
							<div>
								<h2>Select Column</h2>
								<a class="de-custom-` + _this.builderType + `__action-control-column-close">
									<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
										<path d="M207,182.8c-6.7-6.7-17.6-6.7-24.3,0s-6.7,17.6,0,24.3l38,38l-38,38c-6.7,6.7-6.7,17.6,0,24.3c3.3,3.3,7.7,5,12.1,5 c4.4,0,8.8-1.7,12.1-5l38-38l38,38c3.3,3.3,7.7,5,12.1,5s8.8-1.7,12.1-5c6.7-6.7,6.7-17.6,0-24.3l-38-38l38-38 c6.7-6.7,6.7-17.6,0-24.3s-17.6-6.7-24.3,0l-38,38L207,182.8z"/>
										<path d="M0,245c0,135.1,109.9,245,245,245s245-109.9,245-245S380.1,0,245,0S0,109.9,0,245z M455.7,245 c0,116.2-94.5,210.7-210.7,210.7S34.3,361.2,34.3,245S128.8,34.3,245,34.3S455.7,128.8,455.7,245z"/>
									</svg>
								</a>
							</div>
							<div>
								` + defaultCols + `
							</div>
						</div>
					</div>
					<a class="de-custom-` + _this.builderType + `__action de-custom-` + _this.builderType + `__action-delete de-custom-` + _this.builderType + `__action--right">Delete</a>
				</div>
				<div class="de-custom-` + _this.builderType + `__row"></div>
			</div>
			`
		).promise().done(function () {
			success();
		});
	}
	DFBuilderCustomizer.prototype.setBuilderColumn = function ($row, column, columnClass, columnWidth, position, success) {
		var _this = this;

		$row.append(
			`
			<div class="de-custom-` + _this.builderType + `__column ` + columnClass + `" data-column-id="` + column + `" data-column-width="` + columnWidth + `">
				<div class="de-custom-` + _this.builderType + `__column-inner">
					<span class="de-custom-` + _this.builderType + `__column-action">
						<a class="de-custom-` + _this.builderType + `__column-content-add">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
								<path d="M227.8,174.1v53.7h-53.7c-9.5,0-17.2,7.7-17.2,17.2s7.7,17.2,17.2,17.2h53.7v53.7c0,9.5,7.7,17.2,17.2,17.2 s17.1-7.7,17.1-17.2v-53.7h53.7c9.5,0,17.2-7.7,17.2-17.2s-7.7-17.2-17.2-17.2h-53.7v-53.7c0-9.5-7.7-17.2-17.1-17.2 S227.8,164.6,227.8,174.1z"/>
								<path d="M71.7,71.7C25.5,118,0,179.5,0,245s25.5,127,71.8,173.3C118,464.5,179.6,490,245,490s127-25.5,173.3-71.8 C464.5,372,490,310.4,490,245s-25.5-127-71.8-173.3C372,25.5,310.5,0,245,0C179.6,0,118,25.5,71.7,71.7z M455.7,245 c0,56.3-21.9,109.2-61.7,149s-92.7,61.7-149,61.7S135.8,433.8,96,394s-61.7-92.7-61.7-149S56.2,135.8,96,96s92.7-61.7,149-61.7 S354.2,56.2,394,96S455.7,188.7,455.7,245z"/>
							</svg>
						</a>
						<a class="de-custom-` + _this.builderType + `__column-edit">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490.273 490.273" style="enable-background:new 0 0 490.273 490.273;" xml:space="preserve">
								<path d="M313.548,152.387l-230.8,230.9c-6.7,6.7-6.7,17.6,0,24.3c3.3,3.3,7.7,5,12.1,5s8.8-1.7,12.1-5l230.8-230.8 c6.7-6.7,6.7-17.6,0-24.3C331.148,145.687,320.248,145.687,313.548,152.387z"/>
								<path d="M431.148,191.887c4.4,0,8.8-1.7,12.1-5l25.2-25.2c29.1-29.1,29.1-76.4,0-105.4l-34.4-34.4 c-14.1-14.1-32.8-21.8-52.7-21.8c-19.9,0-38.6,7.8-52.7,21.8l-25.2,25.2c-6.7,6.7-6.7,17.6,0,24.3l115.6,115.6 C422.348,190.187,426.748,191.887,431.148,191.887z M352.948,45.987c7.6-7.6,17.7-11.8,28.5-11.8c10.7,0,20.9,4.2,28.5,11.8 l34.4,34.4c15.7,15.7,15.7,41.2,0,56.9l-13.2,13.2l-91.4-91.4L352.948,45.987z"/>
								<path d="M162.848,467.187l243.5-243.5c6.7-6.7,6.7-17.6,0-24.3s-17.6-6.7-24.3,0l-239.3,239.5l-105.6,14.2l14.2-105.6 l228.6-228.6c6.7-6.7,6.7-17.6,0-24.3c-6.7-6.7-17.6-6.7-24.3,0l-232.6,232.8c-2.7,2.7-4.4,6.1-4.9,9.8l-18,133.6 c-0.7,5.3,1.1,10.6,4.9,14.4c3.2,3.2,7.6,5,12.1,5c0.8,0,1.5-0.1,2.3-0.2l133.6-18 C156.748,471.587,160.248,469.887,162.848,467.187z"/>
							</svg>
						</a>
						<a class="de-custom-` + _this.builderType + `__column-delete">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 489.7 489.7" style="enable-background:new 0 0 489.7 489.7;" xml:space="preserve">
								<path d="M411.8,131.7c-9.5,0-17.2,7.7-17.2,17.2v288.2c0,10.1-8.2,18.4-18.4,18.4H113.3c-10.1,0-18.4-8.2-18.4-18.4V148.8 c0-9.5-7.7-17.2-17.1-17.2c-9.5,0-17.2,7.7-17.2,17.2V437c0,29,23.6,52.7,52.7,52.7h262.9c29,0,52.7-23.6,52.7-52.7V148.8 C428.9,139.3,421.2,131.7,411.8,131.7z"/>
								<path d="M457.3,75.9H353V56.1C353,25.2,327.8,0,296.9,0H192.7c-31,0-56.1,25.2-56.1,56.1v19.8H32.3c-9.5,0-17.1,7.7-17.1,17.2 s7.7,17.1,17.1,17.1h425c9.5,0,17.2-7.7,17.2-17.1C474.4,83.5,466.8,75.9,457.3,75.9z M170.9,56.1c0-12,9.8-21.8,21.8-21.8h104.2 c12,0,21.8,9.8,21.8,21.8v19.8H170.9V56.1z"/>
								<path d="M262,396.6V180.9c0-9.5-7.7-17.1-17.1-17.1s-17.1,7.7-17.1,17.1v215.7c0,9.5,7.7,17.1,17.1,17.1 C254.3,413.7,262,406.1,262,396.6z"/>
								<path d="M186.1,396.6V180.9c0-9.5-7.7-17.1-17.2-17.1s-17.1,7.7-17.1,17.1v215.7c0,9.5,7.7,17.1,17.1,17.1 C178.4,413.7,186.1,406.1,186.1,396.6z"/>
								<path d="M337.8,396.6V180.9c0-9.5-7.7-17.1-17.1-17.1s-17.1,7.7-17.1,17.1v215.7c0,9.5,7.7,17.1,17.1,17.1 S337.8,406.1,337.8,396.6z"/>
							</svg>
						</a>
					</span>
					<div class="de-custom-` + _this.builderType + `__column-content-wrapper">
						<div class="de-custom-` + _this.builderType + `__column-content"></div>
					</div>
					<a class="de-custom-` + _this.builderType + `__column-content-add de-custom-` + _this.builderType + `__column-content-add-primary">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
							<path d="M227.8,174.1v53.7h-53.7c-9.5,0-17.2,7.7-17.2,17.2s7.7,17.2,17.2,17.2h53.7v53.7c0,9.5,7.7,17.2,17.2,17.2 s17.1-7.7,17.1-17.2v-53.7h53.7c9.5,0,17.2-7.7,17.2-17.2s-7.7-17.2-17.2-17.2h-53.7v-53.7c0-9.5-7.7-17.2-17.1-17.2 S227.8,164.6,227.8,174.1z"/>
							<path d="M71.7,71.7C25.5,118,0,179.5,0,245s25.5,127,71.8,173.3C118,464.5,179.6,490,245,490s127-25.5,173.3-71.8 C464.5,372,490,310.4,490,245s-25.5-127-71.8-173.3C372,25.5,310.5,0,245,0C179.6,0,118,25.5,71.7,71.7z M455.7,245 c0,56.3-21.9,109.2-61.7,149s-92.7,61.7-149,61.7S135.8,433.8,96,394s-61.7-92.7-61.7-149S56.2,135.8,96,96s92.7-61.7,149-61.7 S354.2,56.2,394,96S455.7,188.7,455.7,245z"/>
						</svg>
					</a>
				</div>
			</div>
		`
		).promise().done(function () {
			success();
		});
	}
	DFBuilderCustomizer.prototype.setBuilderItem = function ($column, itemID, itemValue, section, position, success) {
		var _this = this,
			itemTitle;

		itemTitle = typeof dfCustomizerLocalize.items[_this.builderType][itemValue] !== 'undefined' ? dfCustomizerLocalize.items[_this.builderType][itemValue]['title'] : dfCustomizerLocalize.messages.itemNotExist;
		section = typeof dfCustomizerLocalize.items[_this.builderType][itemValue] !== 'undefined' ? section : '';
		$('.de-' + _this.builderType + '-items[data-item="' + itemValue + '"]', $('.de-custom-' + _this.builderType + '__element-storage')).addClass('selected');
		$('.de-custom-' + _this.builderType + '__column-content', $column).append(
			'<span data-item="' + itemValue + '" data-item-id="' + itemID + '" data-section="' + section + '" class="de-' + _this.builderType + '-items-registered">' +
			'<span class="de-custom-' + _this.builderType + '-name">' + itemTitle + '</span>' +
			_this.itemActionContent +
			'</span>'
		).promise().done(function () {
			$column.addClass('column--not-empty');
			success();
		});
	}
	/** End of Set Builder */

	/** Vertical Builder */
	DFBuilderCustomizer.prototype.BuilderVerticalInit = function () {
		var _this = this;

		if (_this.builderIsVertical) {
			$('.de-custom-' + _this.builderType + '__section[data-section-header="2"]').addClass('de-header__vertical--section-2');
			$('.de-custom-' + _this.builderType + '__section[data-section-header="1"]').addClass('de-header__vertical--section-1');
			$('.de-custom-' + _this.builderType + '__section').addClass('de-custom-' + _this.builderType + '__section--active').promise().done(function () {
				$('.de-custom-' + _this.builderType + '__section--active .de-custom-' + _this.builderType + '__section-wrapper').slideDown({
					step: function (a, b) {
						_this.shortcutTransform(a, b);
					}
				});
			});
			_this.BuilderVerticalHideSection3(true);
			_this.BuilderVerticalRemoveSection3Elements();
			_this.BuilderVerticalHideAddItem(true);
			_this.BuilderVerticalHideControlColumn(true);
			_this.BuilderVerticalHideToggleButtonSection(true);
			_this.BuilderVerticalfilterSection2();
		}

	}
	DFBuilderCustomizer.prototype.BuilderVerticalfilterSection2 = function () {
		var _this = this,
			column;

		$('.de-custom-' + _this.builderType + '__section[data-section-header="2"] .de-custom-' + _this.builderType + '__content').each(function (i, el) {
			column = $('.de-custom-' + _this.builderType + '__column', $(this));
			if (column.length > 1) {
				$('.de-custom-' + _this.builderType + '__action-delete', $(this)).trigger('click');
			} else if (column.length === 1 && $('.de-' + _this.builderType + '-items-registered', column).length > 1) {
				$('.de-custom-' + _this.builderType + '__action-delete', $(this)).trigger('click');
			}
		});
	}
	DFBuilderCustomizer.prototype.BuilderVerticalDestroy = function () {
		var _this = this;

		$('.de-custom-' + _this.builderType + '__section[data-section-header="2"]').removeClass('de-header__vertical--section-2');
		$('.de-custom-' + _this.builderType + '__section[data-section-header="1"]').removeClass('de-header__vertical--section-1');
		$('.de-custom-' + _this.builderType + '__section').removeClass('de-custom-' + _this.builderType + '__section--active').promise().done(function () {
			$('.de-custom-' + _this.builderType + '__section-wrapper').slideUp();
		});
		_this.BuilderVerticalHideSection3(false);
		_this.BuilderVerticalHideAddItem(false);
		_this.BuilderVerticalHideControlColumn(false);
		_this.BuilderVerticalHideToggleButtonSection(false);

	}
	DFBuilderCustomizer.prototype.BuilderVerticalHideSection3 = function (isHide) {
		var _this = this;

		if (isHide) {
			$('.de-custom-' + _this.builderType + '__section[data-section-header="3"]').hide();
		} else {
			$('.de-custom-' + _this.builderType + '__section[data-section-header="3"]').show();
		}
	}
	DFBuilderCustomizer.prototype.BuilderVerticalRemoveSection3Elements = function () {
		var _this = this;

		$('.de-custom-' + _this.builderType + '__action-delete', $('.de-custom-' + _this.builderType + '__section[data-section-header="3"]')).each(function () {
			$(this).trigger('click');
		});
	}
	DFBuilderCustomizer.prototype.BuilderVerticalHideAddItem = function (isHide, column) {
		var _this = this;

		if (isHide) {
			$('.de-custom-' + _this.builderType + '__column-content-add-primary',
				$('.de-custom-' + _this.builderType + '__column.column--not-empty',
					$('.de-custom-' + _this.builderType + '__section[data-section-header="2"]')
				)
			).hide();
		} else {
			$('.de-custom-' + _this.builderType + '__column-content-add-primary',
				$('.de-custom-' + _this.builderType + '__column',
					$('.de-custom-' + _this.builderType + '__section[data-section-header="2"]')
				)
			).show();
		}
	}
	DFBuilderCustomizer.prototype.BuilderVerticalHideControlColumn = function (isHide) {
		var _this = this;

		if (isHide) {
			$('.de-custom-' + _this.builderType + '__action-column, .de-custom-' + _this.builderType + '__action-control-column',
				$('.de-custom-' + _this.builderType + '__section[data-section-header="2"]')
			).hide();
		} else {
			$('.de-custom-' + _this.builderType + '__action-column, .de-custom-' + _this.builderType + '__action-control-column',
				$('.de-custom-' + _this.builderType + '__section[data-section-header="2"]')
			).show();
		}

	}
	DFBuilderCustomizer.prototype.BuilderVerticalHideToggleButtonSection = function (isHide) {
		var _this = this;

		if (isHide) {
			$('.de-custom-' + _this.builderType + '__tooltip-hide',
				$('.de-custom-' + _this.builderType + '__section')
			).hide();
		} else {
			$('.de-custom-' + _this.builderType + '__tooltip-hide',
				$('.de-custom-' + _this.builderType + '__section')
			).show();
		}
	}
	/** End of Vertical Builder */

	/** Section Row */
	DFBuilderCustomizer.prototype.setRow = function (section) {
		var _this = this,
			id = _this.uniqid('row'),
			customColumn,
			defaultCols = '',
			selectedDefaultCol = '';

		_this.builderValue[section][id] = {
			columns: {},
			columnStyle: '1/1'
		};
		for (var i in _this.defaultCols) {
			selectedDefaultCol = ''
			if (_this.defaultCols[i].value == _this.builderValue[section][id].columnStyle) {
				selectedDefaultCol = 'selected';
			}
			defaultCols += '<a class="' + selectedDefaultCol + '" data-column="' + _this.defaultCols[i].value + '">' + _this.defaultCols[i].icon + '</a>'
		}
		return {
			html: `
				<div class="de-custom-` + _this.builderType + `__content" data-row-id="` + id + `">
					<div class="de-custom-` + _this.builderType + `__control">
						<a class="de-custom-` + _this.builderType + `__action de-custom-` + _this.builderType + `__action-move">Move</a>
						<a class="de-custom-` + _this.builderType + `__action de-custom-` + _this.builderType + `__action-column">Column</a>
						<span class="de-custom-` + _this.builderType + `__action de-custom-` + _this.builderType + `__action-control-column">
							<div>
								<div>
									<h2>Select Column</h2>
									<a class="de-custom-` + _this.builderType + `__action-control-column-close">
										<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
											<path d="M207,182.8c-6.7-6.7-17.6-6.7-24.3,0s-6.7,17.6,0,24.3l38,38l-38,38c-6.7,6.7-6.7,17.6,0,24.3c3.3,3.3,7.7,5,12.1,5 c4.4,0,8.8-1.7,12.1-5l38-38l38,38c3.3,3.3,7.7,5,12.1,5s8.8-1.7,12.1-5c6.7-6.7,6.7-17.6,0-24.3l-38-38l38-38 c6.7-6.7,6.7-17.6,0-24.3s-17.6-6.7-24.3,0l-38,38L207,182.8z"/>
											<path d="M0,245c0,135.1,109.9,245,245,245s245-109.9,245-245S380.1,0,245,0S0,109.9,0,245z M455.7,245 c0,116.2-94.5,210.7-210.7,210.7S34.3,361.2,34.3,245S128.8,34.3,245,34.3S455.7,128.8,455.7,245z"/>
										</svg>
									</a>
								</div>
								<div>
									` + defaultCols + `
								</div>
							</div>
						</span>
						<a class="de-custom-` + _this.builderType + `__action de-custom-` + _this.builderType + `__action-delete de-custom-` + _this.builderType + `__action--right">Delete</a>
					</div>
					<div class="de-custom-` + _this.builderType + `__row"></div>
				</div>
				`,
			contentID: id,
			section: section
		};
	}
	DFBuilderCustomizer.prototype.addRow = function () {
		var _this = this,
			section, sectionID, newRow;

		$('.de-custom-' + _this.builderType + '__content-new').on('click',function () {
			section = $(this).parents('.de-custom-' + _this.builderType + '__section');
			sectionID = section.attr('data-section-' + _this.builderType);
			newRow = _this.setRow(sectionID, _this.builderType);
			$('.de-custom-' + _this.builderType + '__section-inner', section).append(newRow.html).promise().done(function () {
				_this.removeRow();
				_this.sortableRow(sectionID);
				_this.setRowPosition(sectionID);
				_this.addColumn(sectionID, newRow.contentID);
				_this.editColumn();
				_this.openRowColumn();
				_this.setRowColumn(sectionID, newRow.contentID);
				_this.bindValue();
			});
		});
	}
	DFBuilderCustomizer.prototype.moveRow = function (section, row) {
		var _this = this,
			sectionTargetID, dataRow = _this.builderValue[section][row];

		sectionTargetID = $('.de-custom-' + _this.builderType + '__content[data-row-id="' + row + '"]').parents('.de-custom-' + _this.builderType + '__section').attr('data-section-' + _this.builderType);
		_this.builderValue[sectionTargetID][row] = dataRow;
		delete _this.builderValue[section][row];
		_this.setRowPosition(section);
		_this.setRowPosition(sectionTargetID);
		_this.initRemoveColumn();
	}
	DFBuilderCustomizer.prototype.removeRow = function () {
		var _this = this,
			section, content, sectionID, contentID, dataItem;

		$('.de-custom-' + _this.builderType + '__action-delete').off('click');
		$('.de-custom-' + _this.builderType + '__action-delete').on('click',function () {
			section = $(this).parents('.de-custom-' + _this.builderType + '__section');
			content = $(this).parents('.de-custom-' + _this.builderType + '__content');
			sectionID = section.attr('data-section-' + _this.builderType);
			contentID = content.attr('data-row-id');
			$('.de-' + _this.builderType + '-items-registered', content).each(function () {
				dataItem = $(this).attr('data-item');
				$('.de-' + _this.builderType + '-items[data-item="' + dataItem + '"]', $('.de-custom-' + _this.builderType + '__element-storage')).removeClass('selected');
			});
			content.remove().promise().done(function () {
				delete _this.builderValue[sectionID][contentID];
				_this.setRowPosition(contentID);
				_this.bindValue();
			});
		});
	}
	DFBuilderCustomizer.prototype.sortableRow = function (sectionID) {
		var _this = this,
			row;

		$('.de-custom-' + _this.builderType + '__section-inner', $('.de-custom-' + _this.builderType + '__section[data-section-' + _this.builderType + '="' + sectionID + '"]')).sortable({
			connectWith: $('.de-custom-' + _this.builderType + '__section-inner', $('.de-custom-' + _this.builderType + '__section[data-section-' + _this.builderType + '="' + sectionID + '"]')),
			forcePlaceholderSize: true,
			handle: '.de-custom-' + _this.builderType + '__action-move',
			placeholder: 'de-sortable-placeholder-row',
			receive: function (event, ui) {
				row = ui.item.attr('data-row-id');
				_this.moveRow(sectionID, row);
				_this.bindValue();
			},
			stop: function (event, ui) {
				sectionID = ui.item.parents('.de-custom-' + _this.builderType + '__section').attr('data-section-' + _this.builderType);
				_this.setRowPosition(sectionID);
				_this.bindValue();
			}
		});
	}
	DFBuilderCustomizer.prototype.setRowPosition = function (section) {
		var rowid = '',
			_this = this;

		$('.de-custom-' + _this.builderType + '__section[data-section-' + _this.builderType + '="' + section + '"] .de-custom-' + _this.builderType + '__content').each(function (i, el) {
			rowid = $(el).attr('data-row-id');
			_this.builderValue[section][rowid]['position'] = i + 1;
		});
	}
	/** End of Section Row */

	/** Section Column */
	DFBuilderCustomizer.prototype.setColumn = function (sectionID, contentID, columnWidth, columnLength) {
		var _this = this,
			id = _this.uniqid('column'),
			dynamicColWidth, columnClass;

		_this.builderValue[sectionID][contentID]['columns'][id] = {
			items: {}
		};
		if (typeof columnWidth !== 'undefined') {
			switch (columnWidth) {
				case '1/2':
					columnClass = 'large-6';
					break;
				case '1/3':
					columnClass = 'large-4';
					break;
				case '1/4':
					columnClass = 'large-3';
					break;
				case '1/5':
					columnClass = 'large-1-5';
					break;
				case '1/6':
					columnClass = 'large-2';
					break;
				case '2/3':
					columnClass = 'large-8';
					break;
				case '2/5':
					columnClass = 'large-2-5';
					break;
				case '3/4':
					columnClass = 'large-9';
					break;
				case '3/5':
					columnClass = 'large-3-5';
					break;
				case '5/6':
					columnClass = 'large-10';
					break;
				default:
					columnClass = 'large-12';
					break;
			}
		} else {
			columnClass = 'large-12';
			columnWidth = '1/1';
		}
		_this.builderValue[sectionID][contentID]['columns'][id]['columnClass'] = columnClass;
		_this.builderValue[sectionID][contentID]['columns'][id]['columnWidth'] = columnWidth;
		return {
			html: `
				<div class="de-custom-` + _this.builderType + `__column ` + columnClass + `" data-column-id="` + id + `" data-column-width="` + columnWidth + `">
					<div class="de-custom-` + _this.builderType + `__column-inner">
						<span class="de-custom-` + _this.builderType + `__column-action">
							<a class="de-custom-` + _this.builderType + `__column-content-add">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
									<path d="M227.8,174.1v53.7h-53.7c-9.5,0-17.2,7.7-17.2,17.2s7.7,17.2,17.2,17.2h53.7v53.7c0,9.5,7.7,17.2,17.2,17.2 s17.1-7.7,17.1-17.2v-53.7h53.7c9.5,0,17.2-7.7,17.2-17.2s-7.7-17.2-17.2-17.2h-53.7v-53.7c0-9.5-7.7-17.2-17.1-17.2 S227.8,164.6,227.8,174.1z"/>
									<path d="M71.7,71.7C25.5,118,0,179.5,0,245s25.5,127,71.8,173.3C118,464.5,179.6,490,245,490s127-25.5,173.3-71.8 C464.5,372,490,310.4,490,245s-25.5-127-71.8-173.3C372,25.5,310.5,0,245,0C179.6,0,118,25.5,71.7,71.7z M455.7,245 c0,56.3-21.9,109.2-61.7,149s-92.7,61.7-149,61.7S135.8,433.8,96,394s-61.7-92.7-61.7-149S56.2,135.8,96,96s92.7-61.7,149-61.7 S354.2,56.2,394,96S455.7,188.7,455.7,245z"/>
								</svg>
							</a>
							<a class="de-custom-` + _this.builderType + `__column-edit">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490.273 490.273" style="enable-background:new 0 0 490.273 490.273;" xml:space="preserve">
									<path d="M313.548,152.387l-230.8,230.9c-6.7,6.7-6.7,17.6,0,24.3c3.3,3.3,7.7,5,12.1,5s8.8-1.7,12.1-5l230.8-230.8 c6.7-6.7,6.7-17.6,0-24.3C331.148,145.687,320.248,145.687,313.548,152.387z"/>
									<path d="M431.148,191.887c4.4,0,8.8-1.7,12.1-5l25.2-25.2c29.1-29.1,29.1-76.4,0-105.4l-34.4-34.4 c-14.1-14.1-32.8-21.8-52.7-21.8c-19.9,0-38.6,7.8-52.7,21.8l-25.2,25.2c-6.7,6.7-6.7,17.6,0,24.3l115.6,115.6 C422.348,190.187,426.748,191.887,431.148,191.887z M352.948,45.987c7.6-7.6,17.7-11.8,28.5-11.8c10.7,0,20.9,4.2,28.5,11.8 l34.4,34.4c15.7,15.7,15.7,41.2,0,56.9l-13.2,13.2l-91.4-91.4L352.948,45.987z"/>
									<path d="M162.848,467.187l243.5-243.5c6.7-6.7,6.7-17.6,0-24.3s-17.6-6.7-24.3,0l-239.3,239.5l-105.6,14.2l14.2-105.6 l228.6-228.6c6.7-6.7,6.7-17.6,0-24.3c-6.7-6.7-17.6-6.7-24.3,0l-232.6,232.8c-2.7,2.7-4.4,6.1-4.9,9.8l-18,133.6 c-0.7,5.3,1.1,10.6,4.9,14.4c3.2,3.2,7.6,5,12.1,5c0.8,0,1.5-0.1,2.3-0.2l133.6-18 C156.748,471.587,160.248,469.887,162.848,467.187z"/>
								</svg>
							</a>
							<a class="de-custom-` + _this.builderType + `__column-delete">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 489.7 489.7" style="enable-background:new 0 0 489.7 489.7;" xml:space="preserve">
									<path d="M411.8,131.7c-9.5,0-17.2,7.7-17.2,17.2v288.2c0,10.1-8.2,18.4-18.4,18.4H113.3c-10.1,0-18.4-8.2-18.4-18.4V148.8 c0-9.5-7.7-17.2-17.1-17.2c-9.5,0-17.2,7.7-17.2,17.2V437c0,29,23.6,52.7,52.7,52.7h262.9c29,0,52.7-23.6,52.7-52.7V148.8 C428.9,139.3,421.2,131.7,411.8,131.7z"/>
									<path d="M457.3,75.9H353V56.1C353,25.2,327.8,0,296.9,0H192.7c-31,0-56.1,25.2-56.1,56.1v19.8H32.3c-9.5,0-17.1,7.7-17.1,17.2 s7.7,17.1,17.1,17.1h425c9.5,0,17.2-7.7,17.2-17.1C474.4,83.5,466.8,75.9,457.3,75.9z M170.9,56.1c0-12,9.8-21.8,21.8-21.8h104.2 c12,0,21.8,9.8,21.8,21.8v19.8H170.9V56.1z"/>
									<path d="M262,396.6V180.9c0-9.5-7.7-17.1-17.1-17.1s-17.1,7.7-17.1,17.1v215.7c0,9.5,7.7,17.1,17.1,17.1 C254.3,413.7,262,406.1,262,396.6z"/>
									<path d="M186.1,396.6V180.9c0-9.5-7.7-17.1-17.2-17.1s-17.1,7.7-17.1,17.1v215.7c0,9.5,7.7,17.1,17.1,17.1 C178.4,413.7,186.1,406.1,186.1,396.6z"/>
									<path d="M337.8,396.6V180.9c0-9.5-7.7-17.1-17.1-17.1s-17.1,7.7-17.1,17.1v215.7c0,9.5,7.7,17.1,17.1,17.1 S337.8,406.1,337.8,396.6z"/>
								</svg>
							</a>
						</span>
						<div class="de-custom-` + _this.builderType + `__column-content-wrapper">
							<div class="de-custom-` + _this.builderType + `__column-content"></div>
						</div>
						<a class="de-custom-` + _this.builderType + `__column-content-add de-custom-` + _this.builderType + `__column-content-add-primary">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
								<path d="M227.8,174.1v53.7h-53.7c-9.5,0-17.2,7.7-17.2,17.2s7.7,17.2,17.2,17.2h53.7v53.7c0,9.5,7.7,17.2,17.2,17.2 s17.1-7.7,17.1-17.2v-53.7h53.7c9.5,0,17.2-7.7,17.2-17.2s-7.7-17.2-17.2-17.2h-53.7v-53.7c0-9.5-7.7-17.2-17.1-17.2 S227.8,164.6,227.8,174.1z"/>
								<path d="M71.7,71.7C25.5,118,0,179.5,0,245s25.5,127,71.8,173.3C118,464.5,179.6,490,245,490s127-25.5,173.3-71.8 C464.5,372,490,310.4,490,245s-25.5-127-71.8-173.3C372,25.5,310.5,0,245,0C179.6,0,118,25.5,71.7,71.7z M455.7,245 c0,56.3-21.9,109.2-61.7,149s-92.7,61.7-149,61.7S135.8,433.8,96,394s-61.7-92.7-61.7-149S56.2,135.8,96,96s92.7-61.7,149-61.7 S354.2,56.2,394,96S455.7,188.7,455.7,245z"/>
							</svg>
						</a>
					</div>
				</div>
			`,
			columnID: id,
			section: sectionID,
			contentID: contentID
		};
	}
	DFBuilderCustomizer.prototype.addColumn = function (sectionID, contentID, columnWidth, columnLength) {
		var _this = this,
			section, content, column;

		section = '.de-custom-' + _this.builderType + '__section[data-section-' + _this.builderType + '="' + sectionID + '"]';
		content = '.de-custom-' + _this.builderType + '__content[data-row-id="' + contentID + '"]';
		column = _this.setColumn(sectionID, contentID, columnWidth, columnLength);
		$(section + ' ' + content + ' .de-custom-' + _this.builderType + '__row').append(column.html).promise().done(function () {
			if (_this.builderIsVertical) {
				_this.BuilderVerticalHideControlColumn(true);
			}
			_this.initRemoveColumn();
			_this.sortableColumn();
			_this.sortableItems(sectionID);
			_this.openItems();
			_this.setColumnPosition(sectionID, contentID);
			_this.bindValue();
		});
	}
	DFBuilderCustomizer.prototype.editColumn = function () {
		var _this = this,
			section, sectionID, content, contentID, column, columnID, editOption, alignment, extraClass, paddingBottom, paddingTop;

		// bind open edit container event
		$('.de-custom-' + _this.builderType + '__column-edit').off('click')
		$('.de-custom-' + _this.builderType + '__column-edit').on('click',function () {
			// get section, content & column from edit button
			section = $(this).parents('.de-custom-' + _this.builderType + '__section');
			sectionID = section.attr('data-section-' + _this.builderType);
			content = $(this).parents('.de-custom-' + _this.builderType + '__content');
			contentID = content.attr('data-row-id');
			column = $(this).parents('.de-custom-' + _this.builderType + '__column');
			columnID = column.attr('data-column-id');
			editOption = _this.builderValue[sectionID][contentID]['columns'][columnID]['options'];
			// add attribute to edit container
			$('.de-custom-' + _this.builderType + '__column-edit-container').attr('data-edit', columnID);
			// check if option value is undefined
			if (typeof editOption != 'undefined') {
				alignment = editOption['alignment'];
				extraClass = editOption['extraClass'];
				paddingBottom = typeof editOption['paddingBottom'] !== 'undefined' ? editOption['paddingBottom'] : '';
				paddingTop = typeof editOption['paddingTop'] !== 'undefined' ? editOption['paddingTop'] : '';
			} else {
				// if value is undefined, set to default
				alignment = 'flex-start';
				extraClass = '';
				paddingBottom = '';
				paddingTop = '';
			}
			// set value to edit option
			_this.setEditColumn(sectionID, contentID, columnID, alignment, extraClass, paddingBottom, paddingTop);
			$('.de-custom-' + _this.builderType + '__column-edit-save').attr('sectionID', sectionID);
			$('.de-custom-' + _this.builderType + '__column-edit-save').attr('contentID', contentID);
			$('.de-custom-' + _this.builderType + '__column-edit-save').attr('columnID', columnID);
			// show edit container
			$('.de-custom-' + _this.builderType + '__column-edit-container').addClass('active');
			if (_this.builderIsVertical && sectionID == '2') {
				$('.de-custom-' + _this.builderType + '__column-edit-container-section2-vertical').show();
			} else {
				$('.de-custom-' + _this.builderType + '__column-edit-container-section2-vertical').hide();
			}
			// bind save edit event
		});
	}
	DFBuilderCustomizer.prototype.getEditColumn = function (sectionID, contentID, columnID) {
		var _this = this,
			alignment, extraClass, paddingBottom, paddingTop;

		alignment = $('.de-custom-' + _this.builderType + '__column-edit-container[data-edit="' + columnID + '"] #de-' + _this.builderType + '-builder-column-alignment').val();
		extraClass = $('.de-custom-' + _this.builderType + '__column-edit-container[data-edit="' + columnID + '"] #de-' + _this.builderType + '-builder-column-extraclass').val();
		paddingTop = $('.de-custom-' + _this.builderType + '__column-edit-container[data-edit="' + columnID + '"] #de-' + _this.builderType + '-builder-column-padding-top').val();
		paddingBottom = $('.de-custom-' + _this.builderType + '__column-edit-container[data-edit="' + columnID + '"] #de-' + _this.builderType + '-builder-column-padding-bottom').val();
		paddingTop = isNaN(parseFloat(paddingTop)) ? 0 : paddingTop;
		paddingBottom = isNaN(parseFloat(paddingBottom)) ? 0 : paddingBottom;
		_this.builderValue[sectionID][contentID]['columns'][columnID]['options'] = {
			alignment,
			extraClass,
			paddingTop,
			paddingBottom
		};
		_this.bindValue();
	}
	DFBuilderCustomizer.prototype.setEditColumn = function (sectionID, contentID, columnID, alignment, extraClass, paddingBottom, paddingTop) {
		var _this = this;

		$('.de-custom-' + _this.builderType + '__column-edit-container[data-edit="' + columnID + '"] #de-' + _this.builderType + '-builder-column-alignment').val(alignment);
		$('.de-custom-' + _this.builderType + '__column-edit-container[data-edit="' + columnID + '"] #de-' + _this.builderType + '-builder-column-extraclass').val(extraClass);
		$('.de-custom-' + _this.builderType + '__column-edit-container[data-edit="' + columnID + '"] #de-' + _this.builderType + '-builder-column-padding-top').val(paddingTop);
		$('.de-custom-' + _this.builderType + '__column-edit-container[data-edit="' + columnID + '"] #de-' + _this.builderType + '-builder-column-padding-bottom').val(paddingBottom);
	}
	DFBuilderCustomizer.prototype.saveColumnStyle = function () {
		var _this = this;
		$('.de-custom-' + _this.builderType + '__column-edit-save').off('click');
		$('.de-custom-' + _this.builderType + '__column-edit-save').on('click',function () {
			// get value from edit option
			// then save it to json
			_this.getEditColumn($(this).attr('sectionID'), $(this).attr('contentID'), $(this).attr('columnID'));
			// trigger close edit container
			$('.de-custom-' + _this.builderType + '__column-edit-container-close').trigger('click');
		});
		// bind close edit container
		$('.de-custom-' + _this.builderType + '__column-edit-container-close').on('click',function () {
			// hide edit container
			$('.de-custom-' + _this.builderType + '__column-edit-container').removeClass('active');
		});
	}
	DFBuilderCustomizer.prototype.openRowColumn = function () {
		var _this = this;

		$('.de-custom-' + _this.builderType + '__action-column').off('click');
		$('.de-custom-' + _this.builderType + '__action-column').on('click',function () {
			$(this).next('.de-custom-' + _this.builderType + '__action-control-column').addClass('active');
		});
		_this.closeRowColumn();
	}
	DFBuilderCustomizer.prototype.closeRowColumn = function () {
		var _this = this;

		$('.de-custom-' + _this.builderType + '__action-control-column-close').off('click');
		$('.de-custom-' + _this.builderType + '__action-control-column-close').on('click',function () {
			$(this).parents('.de-custom-' + _this.builderType + '__action-control-column').removeClass('active');
		});
	}
	DFBuilderCustomizer.prototype.setRowColumn = function (sectionID, contentID) {
		var _this = this,
			dataColumn;

		$('.de-custom-' + _this.builderType + '__action-control-column a:not(.de-custom-' + _this.builderType + '__action-control-column-close)').off('click');
		$('.de-custom-' + _this.builderType + '__action-control-column a:not(.de-custom-' + _this.builderType + '__action-control-column-close)').on('click',function () {
			var columnSelected = $(this).parents('.de-custom-' + _this.builderType + '__content');

			$('a', $(this).parents('.de-custom-' + _this.builderType + '__action-control-column')).removeClass('selected');
			$(this).addClass('selected');
			dataColumn = $(this).attr('data-column');
			_this.addRowColumn(columnSelected.parents('.de-custom-' + _this.builderType + '__section').attr('data-section-' + _this.builderType), columnSelected.attr('data-row-id'), dataColumn, columnSelected);
			_this.editColumn();
			$(this).parents('.de-custom-' + _this.builderType + '__action-control-column').removeClass('active');
		});
	}
	DFBuilderCustomizer.prototype.addRowColumn = function (sectionID, contentID, dataColumn, columnSelected) {
		var _this = this,
			columnCounted, columnLength, dataItem;

		columnCounted = dataColumn.split('+');
		columnLength = columnCounted.length;
		$('.de-' + _this.builderType + '-items-registered', columnSelected).each(function () {
			dataItem = $(this).attr('data-item');
			$('.de-' + _this.builderType + '-items[data-item="' + dataItem + '"]', $('.de-custom-' + _this.builderType + '__element-storage')).removeClass('selected');
		});
		$('.de-custom-' + _this.builderType + '__row', columnSelected).html('').promise().done(function () {
			delete _this.builderValue[sectionID][contentID]['columns'];
			_this.builderValue[sectionID][contentID] = {
				columns: {},
				columnStyle: dataColumn,
				position: _this.builderValue[sectionID][contentID].position
			};
		});
		for (var counter = 0; counter < columnLength; counter++) {
			_this.addColumn(sectionID, contentID, columnCounted[counter], columnLength);
		}
	}
	DFBuilderCustomizer.prototype.initRemoveColumn = function () {
		var _this = this,
			section, sectionID, content, contentID, column, columnID, columnCounted;

		$('.de-custom-' + _this.builderType + '__column-delete').off('click');
		$('.de-custom-' + _this.builderType + '__column-delete').on('click',function () {
			section = $(this).parents('.de-custom-' + _this.builderType + '__section');
			sectionID = section.attr('data-section-' + _this.builderType);
			content = $(this).parents('.de-custom-' + _this.builderType + '__content');
			contentID = content.attr('data-row-id');
			column = $(this).parents('.de-custom-' + _this.builderType + '__column');
			columnID = column.attr('data-column-id');
			columnCounted = $('.de-custom-' + _this.builderType + '__column', content).length;
			if (columnCounted != 1) {
				_this.removeColumn(sectionID, content, contentID, column, columnID);
			} else {
				$('.de-custom-' + _this.builderType + '__action-delete', content).trigger('click');
			}
		});
	}
	DFBuilderCustomizer.prototype.removeColumn = function (sectionID, content, contentID, column, columnID) {
		var _this = this,
			dataItem;

		$('.de-' + _this.builderType + '-items-registered', column).each(function () {
			dataItem = $(this).attr('data-item');
			$('.de-' + _this.builderType + '-items[data-item="' + dataItem + '"]', $('.de-custom-' + _this.builderType + '__element-storage')).removeClass('selected');
		});
		$('.de-custom-' + _this.builderType + '__action-control-column a', content).removeClass('selected');
		$('.de-custom-' + _this.builderType + '__action-control-column a.de-custom-' + _this.builderType + '__action-custom-open', content).addClass('selected');
		column.remove().promise().done(function () {
			delete _this.builderValue[sectionID][contentID]['columns'][columnID];
			_this.setColumnPosition(sectionID, contentID, true);
			_this.bindValue();
		});
	}
	DFBuilderCustomizer.prototype.sortableColumn = function () {
		var _this = this,
			row, section, rowid, sectionID;

		$('.de-custom-' + _this.builderType + '__row').sortable({
			cursor: "move",
			cursorAt: {
				bottom: 0,
				left: 10
			},
			placeholder: "de-sortable-placeholder-column",
			scrollSensitivity: 10,
			scrollSpeed: 40,
			start: function (event, ui) {
				_this.getColumnPlaceholdersize(ui);
			},
			stop: function (event, ui) {
				row = ui.item.parents('.de-custom-' + _this.builderType + '__content');
				rowid = row.attr('data-row-id');
				sectionID = row.parents('.de-custom-' + _this.builderType + '__section').attr('data-section-' + _this.builderType);
				$('.de-sortable-placeholder-column').css({
					'width': 'auto',
					'height': 'auto'
				});
				_this.setColumnPosition(sectionID, rowid);
				_this.bindValue();
			},
			tolerance: "pointer"
		});
	}
	DFBuilderCustomizer.prototype.setColumnPosition = function (section, row, isRemove) {
		var columnID = '',
			_this = this,
			columnWidths = [],
			columnWidthValue;

		$('.de-custom-' + _this.builderType + '__section[data-section-' + _this.builderType + '="' + section + '"] .de-custom-' + _this.builderType + '__content[data-row-id="' + row + '"] .de-custom-' + _this.builderType + '__column').each(function (i, el) {
			columnID = $(el).attr('data-column-id');
			_this.builderValue[section][row]['columns'][columnID]['position'] = i + 1;
			if (isRemove) {
				columnWidths.push(typeof _this.builderValue[section][row]['columns'][columnID]['columnWidth'] !== 'undefined' ? _this.builderValue[section][row]['columns'][columnID]['columnWidth'] : '1/1');
			}
		});
		if (isRemove) {
			columnWidthValue = columnWidths.join('+');
			$('input[name="custom-column"]', '.de-custom-' + _this.builderType + '__section[data-section-' + _this.builderType + '="' + section + '"] .de-custom-' + _this.builderType + '__content[data-row-id="' + row + '"] .de-custom-' + _this.builderType + '__action-control-column').val(columnWidthValue);
			_this.builderValue[section][row].columnStyle = columnWidthValue;
		}

	}
	DFBuilderCustomizer.prototype.getColumnPlaceholdersize = function (ui) {
		$('.de-sortable-placeholder-column').css({
			'width': (ui.item.width() - 1),
			'height': ui.item.height()
		});
	}
	/** End of Section Column */

	/** Builder Items */
	DFBuilderCustomizer.prototype.setItems = function (section, row, column, item, $item) {
		var _this = this,
			dataSection = $item.attr('data-section'),
			dataItem = $item.attr('data-item'),
			id = _this.uniqid('item');

		if (typeof _this.builderValue[section][row]['columns'][column]['items'] == 'undefined') {
			_this.builderValue[section][row]['columns'][column]['items'] = {};
		}
		_this.builderValue[section][row]['columns'][column]['items'][id] = {
			value: item,
			section: dataSection
		};
		return {
			html: '<span data-item="' + dataItem + '" data-item-id="' + id + '" class="de-' + _this.builderType + '-items-registered" data-section="' + dataSection + '">' +
				'<span class="de-custom-' + _this.builderType + '__element-name">' + $('.de-custom-' + _this.builderType + '__element-name', $item).html() + '</span>' +
				_this.itemActionContent +
				'</span>',
			columnID: column,
			section: section,
			rowid: row,
			itemID: id
		};
	}
	DFBuilderCustomizer.prototype.addItems = function () {
		var _this = this,
			that, column, row, section, columnID, rowid, sectionID, item, dataItem;

		$('.de-' + _this.builderType + '-items', $('.de-custom-' + _this.builderType + '__element-storage')).on('click',function () {
			that = this;
			if ($(that).hasClass('selected')) return;
			sectionID = $('.de-custom-' + _this.builderType + '__element-storage').attr('data-section-id');
			rowid = $('.de-custom-' + _this.builderType + '__element-storage').attr('data-row-id');
			columnID = $('.de-custom-' + _this.builderType + '__element-storage').attr('data-column-id');
			dataItem = $(that).attr('data-item');
			section = $('.de-custom-' + _this.builderType + '__section[data-section-' + _this.builderType + '="' + sectionID + '"]');
			row = $('.de-custom-' + _this.builderType + '__content[data-row-id="' + rowid + '"]', section);
			column = $('.de-custom-' + _this.builderType + '__column[data-column-id="' + columnID + '"] .de-custom-' + _this.builderType + '__column-content', row);
			item = _this.setItems(sectionID, rowid, columnID, dataItem, $(this));
			column.append(item.html).promise().done(function () {
				$('.de-custom-' + _this.builderType + '__column[data-column-id="' + columnID + '"]').addClass('column--not-empty').promise().done(function () {
					if (_this.builderIsVertical) {
						_this.BuilderVerticalHideAddItem(true);
					}
				});
				$(that).addClass('selected');
				$('.de-custom-' + _this.builderType + '__element-storage').removeClass('active');
				_this.initRemoveItem();
				_this.sortableItems(sectionID);
				_this.setItemPosition(sectionID, rowid, columnID, column);
				_this.openItemSection();
				_this.bindValue();
			});
		});

	}
	DFBuilderCustomizer.prototype.moveItem = function (sectionID, rowid, columnID, item) {
		var _this = this,
			rowTarget,
			sectionTarget,
			columnTarget,
			rowTargetid,
			sectionTargetID,
			tagetColumnID,
			row,
			column,
			section,
			dataItem = _this.builderValue[sectionID][rowid]['columns'][columnID]['items'][item];

		section = $('.de-custom-' + _this.builderType + '__section[data-section-' + _this.builderType + '="' + sectionID + '"]');
		row = $('.de-custom-' + _this.builderType + '__content[data-row-id="' + rowid + '"]', section);
		column = $('.de-custom-' + _this.builderType + '__column[data-column-id="' + columnID + '"] .de-custom-' + _this.builderType + '__column-content', row);
		columnTarget = $('.de-' + _this.builderType + '-items-registered[data-item-id="' + item + '"]').parents('.de-custom-' + _this.builderType + '__column');
		rowTarget = columnTarget.parents('.de-custom-' + _this.builderType + '__content');
		sectionTarget = rowTarget.parents('.de-custom-' + _this.builderType + '__section');
		tagetColumnID = columnTarget.attr('data-column-id');
		rowTargetid = rowTarget.attr('data-row-id');
		sectionTargetID = sectionTarget.attr('data-section-' + _this.builderType + '');
		if (typeof _this.builderValue[sectionTargetID][rowTargetid]['columns'][tagetColumnID]['items'] == 'undefined' || typeof _this.builderValue[sectionTargetID][rowTargetid]['columns'][tagetColumnID]['items'] !== 'object') {
			_this.builderValue[sectionTargetID][rowTargetid]['columns'][tagetColumnID]['items'] = {};
		}
		_this.builderValue[sectionTargetID][rowTargetid]['columns'][tagetColumnID]['items'][item] = dataItem;
		delete _this.builderValue[sectionID][rowid]['columns'][columnID]['items'][item];
		_this.setItemPosition(sectionID, rowid, columnID, column);
		_this.setItemPosition(sectionTargetID, rowTargetid, tagetColumnID, $('.de-custom-' + _this.builderType + '__column-content', columnTarget));
	}
	DFBuilderCustomizer.prototype.initRemoveItem = function () {
		var _this = this,
			section, sectionID, content, contentID, column, columnID, item, itemID, itemCounted;

		$('.de-custom-' + _this.builderType + '__element-action a[data-element-action="delete"]').off('click');
		$('.de-custom-' + _this.builderType + '__element-action a[data-element-action="delete"]').on('click',function () {
			section = $(this).parents('.de-custom-' + _this.builderType + '__section');
			sectionID = section.attr('data-section-' + _this.builderType);
			content = $(this).parents('.de-custom-' + _this.builderType + '__content');
			contentID = content.attr('data-row-id');
			column = $(this).parents('.de-custom-' + _this.builderType + '__column');
			columnID = column.attr('data-column-id');
			item = $(this).parents('.de-' + _this.builderType + '-items-registered');
			itemID = item.attr('data-item-id');
			itemCounted = $('.de-' + _this.builderType + '-items-registered', column).length;
			if (itemCounted != 1) {
				_this.removeItem(sectionID, contentID, column, columnID, item, itemID);
			} else {
				_this.removeItem(sectionID, contentID, column, columnID, item, itemID);
				column.removeClass('column--not-empty').promise().done(function () {
					if (_this.builderIsVertical && sectionID == '2') {
						_this.BuilderVerticalHideAddItem(false, column);
					}
				});
			}
		});
	}
	DFBuilderCustomizer.prototype.removeItem = function (sectionID, contentID, column, columnID, item, itemID) {
		var _this = this,
			dataItem = item.attr('data-item');

		$('.de-' + _this.builderType + '-items[data-item="' + dataItem + '"]', $('.de-custom-' + _this.builderType + '__element-storage')).removeClass('selected');
		item.remove().promise().done(function () {
			delete _this.builderValue[sectionID][contentID]['columns'][columnID]['items'][itemID];
			_this.setItemPosition(sectionID, contentID, columnID, $('.de-custom-' + _this.builderType + '__column-content', column));
			_this.bindValue();
		});
	}
	DFBuilderCustomizer.prototype.sortableItems = function (sectionIDInit) {
		var _this = this,
			column, row, section, columnID, rowid, sectionID, item, dataItem;

		$('.de-custom-' + _this.builderType + '__column-content', $('.de-custom-' + _this.builderType + '__section[data-section-' + _this.builderType + '="' + sectionIDInit + '"]')).sortable({
			connectWith: $('.de-custom-' + _this.builderType + '__column-content', $('.de-custom-' + _this.builderType + '__section[data-section-' + _this.builderType + '="' + sectionIDInit + '"]')),
			cursor: "move",
			cursorAt: {
				bottom: 0,
				left: 10
			},
			placeholder: "de-sortable-placeholder-item",
			beforeStop: function (event, ui) {

			},
			receive: function (event, ui) {
				if (_this.builderIsVertical && sectionIDInit == '2') {
					if ($(event.target).parents('.de-custom-' + _this.builderType + '__column').hasClass('column--not-empty')) {
						ui.sender.sortable("cancel");
						return;
					}
				}
				column = ui.sender.parents('.de-custom-' + _this.builderType + '__column');
				row = column.parents('.de-custom-' + _this.builderType + '__content');
				section = row.parents('.de-custom-' + _this.builderType + '__section');
				columnID = column.attr('data-column-id');
				rowid = row.attr('data-row-id');
				sectionID = section.attr('data-section-' + _this.builderType + '');
				_this.moveItem(sectionID, rowid, columnID, ui.item.attr('data-item-id'));
				_this.bindValue();
			},
			scrollSensitivity: 10,
			scrollSpeed: 40,
			sort: function (event, ui) {
				ui.item.addClass('on--sort');
			},
			stop: function (event, ui) {
				column = ui.item.parents('.de-custom-' + _this.builderType + '__column');
				row = column.parents('.de-custom-' + _this.builderType + '__content');
				section = row.parents('.de-custom-' + _this.builderType + '__section');
				columnID = column.attr('data-column-id');
				rowid = row.attr('data-row-id');
				sectionID = section.attr('data-section-' + _this.builderType + '');
				_this.setItemPosition(sectionID, rowid, columnID, column);
				$('.de-custom-' + _this.builderType + '__column', section).removeClass('column--not-empty');
				$('.de-custom-' + _this.builderType + '__column', section).each(function () {
					if ($('.de-' + _this.builderType + '-items-registered', this).length) {
						$(this).addClass('column--not-empty').promise().done(function () {
							if (_this.builderIsVertical) {
								_this.BuilderVerticalHideAddItem(true);
							}
						});
					} else {
						if (_this.builderIsVertical) {
							_this.BuilderVerticalHideAddItem(false, $(this));
						}
					}
				});
				_this.bindValue();
			},
			tolerance: "pointer"
		});
	}
	DFBuilderCustomizer.prototype.setItemPosition = function (sectionID, rowid, columnID, column) {
		var itemID = '',
			_this = this;

		$('.de-' + _this.builderType + '-items-registered', column).each(function (i, el) {
			itemID = $(el).attr('data-item-id');
			_this.builderValue[sectionID][rowid]['columns'][columnID]['items'][itemID]['position'] = i + 1;
		});
	}
	DFBuilderCustomizer.prototype.openItems = function () {
		var _this = this,
			column, row, section, columnID, rowid, sectionID;

		$('.de-custom-' + _this.builderType + '__column-content-add').off('click');
		$('.de-custom-' + _this.builderType + '__column-content-add').on('click',function () {
			column = $(this).parents('.de-custom-' + _this.builderType + '__column');
			row = column.parents('.de-custom-' + _this.builderType + '__content');
			section = row.parents('.de-custom-' + _this.builderType + '__section');
			columnID = column.attr('data-column-id');
			rowid = row.attr('data-row-id');
			sectionID = section.attr('data-section-' + _this.builderType + '');
			$('.de-custom-' + _this.builderType + '__element-storage')
				.attr('data-section-id', sectionID)
				.attr('data-row-id', rowid)
				.attr('data-column-id', columnID)
				.addClass('active')
		});
	}
	DFBuilderCustomizer.prototype.closeItemsStorage = function () {
		var _this = this;

		$('.de-custom-' + _this.builderType + '__element-storage-close').on('click',function () {
			$('.de-custom-' + _this.builderType + '__element-storage').removeClass('active');
		});
	}
	/** End of Builder Items */

	/** Preset functions Start */
	DFBuilderCustomizer.prototype.savePreset = function () {
		var _this = this,
			dataPost, isError = false;
		// dfCustomizerLocalize.isDevelopMode
		// bind save preset event
		$('.de-custom-' + _this.builderType + '__wrapper-save').on('click',function () {
			dataPost = {
				'action': 'df_customize_builder_save_preset',
				'preset': {
					name: _this.builderControlIsEdit.setting.get() == 1 ? _this.builderControlEditName : $('#de-' + _this.builderType + '-builder-preset-name').val(),
					builder_type: _this.builderType,
					action_type: _this.builderControlIsEdit.setting.get() == 1 ? 'replace' : 'save',
					is_loaded: $('.de-custom-' + _this.builderType + '__preset-filter li[data-show="saved"]').hasClass('loaded')
				}
			};
			if ($('#de-' + _this.builderType + '-builder-preset-name').val() == '' && !_this.builderControlIsEdit.setting.get()) {
				isError = true;
			} else {
				isError = false;
			}
			if (dfCustomizerLocalize.isDevelopMode) {
				dataPost.preset.title = $('#de-' + _this.builderType + '-builder-preset-title').val();
				dataPost.preset.image = $('#de-' + _this.builderType + '-builder-preset-image').val();
				dataPost.preset.category_id = $('#de-' + _this.builderType + '-builder-preset-category-id').val();
				dataPost.preset.category_name = $('#de-' + _this.builderType + '-builder-preset-category-name').val();
				if (
					dataPost.preset.title == '' ||
					dataPost.preset.image == '' ||
					dataPost.preset.category_id == '' ||
					dataPost.preset.category_name == '' ||
					$('#de-' + _this.builderType + '-builder-preset-name').val() == ''
				) {
					isError = true;
				} else {
					isError = false;
				}
			}
			if (isError) {
				alert(dfCustomizerLocalize.messages.errorSavePresetIncomplete);
				return;
			}
			// get value from item section on customizer
			_this.getValueSavedItemSection();
			dataPost.preset.value = _this.builderValue;
			// request save data to database
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				async: true,
				data: dataPost,
				success: function (response) {
					var result = $.parseJSON(response);
					switch (result.status) {
						case 0:
							alert(result.message);
							break;
						case 1:
							alert(result.message);
							_this.presetDefaultState(result);
							_this.init();
							_this.setPresetasDefault();
							_this.editPreset();
							_this.removePreset();
							$('.de-custom-' + _this.builderType + '__wrapper-default-preset-title').html('');
							$('.de-wrapper-' + _this.builderType + '-builder .de-custom-' + _this.builderType + '__wrapper-default').removeClass('active');
							$('.de-wrapper-' + _this.builderType + '-builder .de-custom-' + _this.builderType + '__wrapper-default-set').removeClass('active');
							$('.de-wrapper-' + _this.builderType + '-builder .de-custom-' + _this.builderType + '__wrapper-default-cancel').removeClass('active');
							$('.de-custom-' + _this.builderType + '__wrapper-preset-container-close').trigger('click');
							break;
						case 2:
							var confirmMessage = confirm(result.message + ' Do you want to replace the current preset?');
							if (confirmMessage == true) {
								_this.replacePreset();
							}
							break;
					}
				}
			});
		});
	}
	DFBuilderCustomizer.prototype.replacePreset = function () {
		var _this = this,
			result;

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			async: true,
			data: {
				'action': 'df_customize_builder_save_preset',
				'preset': {
					name: $('#de-' + _this.builderType + '-builder-preset-name').val(),
					value: _this.builderValue,
					builder_type: _this.builderType,
					action_type: 'replace',
					is_loaded: $('.de-custom-' + _this.builderType + '__preset-filter li[data-show="saved"]').hasClass('loaded')
				}
			},
			success: function (response) {
				result = $.parseJSON(response);
				alert(result.message);
				_this.init();
				_this.presetDefaultState(result);
			},
		});
	}
	DFBuilderCustomizer.prototype.presetDefaultState = function (result) {
		var _this = this;

		$('#de-' + _this.builderType + '-builder-preset-name').val('');
		if ($('.de-custom-' + _this.builderType + '__preset-filter li[data-show="saved"]').hasClass('loaded')) {
			switch (result.type) {
				case 'save':
					$('.de-custom-' + _this.builderType + '__preset-item-wrapper').append(result.preset).promise().done(function () {
						$('.de-custom-' + _this.builderType + '__preset-filter li[data-show="saved"]').addClass('loaded');
					});
					break;
				case 'replace':
					$('.de-custom-' + _this.builderType + '__preset-item-wrapper [data-preset-name="' + result.presetName + '"]').replaceWith(result.preset).promise().done(function () {
						$('.de-custom-' + _this.builderType + '__preset-item-wrapper [data-preset-name="' + result.presetName + '"]').addClass('active');
						$('.de-custom-' + _this.builderType + '__preset-filter li[data-show="saved"]').addClass('loaded');
					});
					break;
			}
		}
	}
	DFBuilderCustomizer.prototype.getSavedPresetInit = function () {
		var _this = this, filterItem, presetParent;

		$('.de-custom-' + _this.builderType + '__preset-filter li[data-show="saved"]').on('click',function () {
			filterItem = $(this).attr('data-show');
			presetParent = $(this).parents('.de-custom-' + _this.builderType + '__preset');
			if (!$(this).hasClass('loaded')) {
				_this.getSavedPreset(filterItem, presetParent);
			} else {
				_this.filterPreset(filterItem, presetParent);
			}
		});
	}
	DFBuilderCustomizer.prototype.getSavedPreset = function (filterItem, presetParent) {
		var _this = this;
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			async: true,
			data: {
				'action': 'df_customize_builder_get_saved_preset',
				'builder_type': _this.builderType
			},
			beforeSend: function () {
				$('.de-custom-' + _this.builderType + '__preset-item-wrapper').addClass('overlay-active');
			},
			success: function (response) {
				$('.de-custom-' + _this.builderType + '__preset-item-wrapper').append(response).promise().done(function () {
					$('.de-custom-' + _this.builderType + '__preset-filter li[data-show="saved"]').addClass('loaded');
					_this.filterPreset(filterItem, presetParent);
					_this.removePreset();
					_this.editPreset();
					_this.checkSetPresetasDefault();
					_this.setPresetasDefaultOnEdit();
					_this.setPresetasDefault();
					$('.de-custom-' + _this.builderType + '__preset-item-wrapper').removeClass('overlay-active');
				});
			},
		});
	}
	DFBuilderCustomizer.prototype.getSavedPresetReload = function () {
		var _this = this;

		$('.de-custom-' + _this.builderType + '__preset-item[data-item="saved"]').remove();
		$('.de-custom-' + _this.builderType + '__preset-filter li[data-show="saved"]').removeClass('loaded');
		$('.de-custom-' + _this.builderType + '__preset-filter li[data-show="saved"]').trigger('click');
	}
	DFBuilderCustomizer.prototype.initFilterPreset = function () {
		var _this = this,
			filterItem, presetParent;

		$('.de-custom-' + _this.builderType + '__preset-item').addClass('active');
		$('.de-custom-' + _this.builderType + '__preset-filter li:not([data-show="saved"])').on('click',function () {
			filterItem = $(this).attr('data-show');
			presetParent = $(this).parents('.de-custom-' + _this.builderType + '__preset');
			_this.filterPreset(filterItem, presetParent);
		});
	}
	DFBuilderCustomizer.prototype.filterPreset = function (filterItem, presetParent) {
		var _this = this;

		if (filterItem == 'all') {
			$('.de-custom-' + _this.builderType + '__preset-item', presetParent).addClass('active');
		} else {
			$('.de-custom-' + _this.builderType + '__preset-item', presetParent).removeClass('active');
			if ($('.de-custom-' + _this.builderType + '__preset-item[data-item="' + filterItem + '"]', presetParent).length > 0) {
				$('.de-custom-' + _this.builderType + '__preset-item[data-item="' + filterItem + '"]', presetParent).addClass('active');
			} else {
				$('.de-custom-' + _this.builderType + '__preset-item', presetParent).addClass('active');
			}
		}
	}
	DFBuilderCustomizer.prototype.getValueSavedItemSection = function () {
		var _this = this,
			itemSection, itemDataSection = {};

		$('.de-' + _this.builderType + '-items-registered').each(function () {
			itemSection = $(this).attr('data-section');
			if (itemSection != '' && typeof itemSection != 'undefined' && $.inArray(itemSection, dfCustomizerLocalize.presetRequired[_this.builderType].exclude_sections) == -1) {
				_.each(wp.customize.section(itemSection).controls(), function (control, b) {
					if (!$(control.selector).hasClass('customize-control-kirki-custom') && $.inArray(control.id, dfCustomizerLocalize.presetRequired[_this.builderType].exclude_controls) == -1) {
						itemDataSection[control.id] = control.setting.get();
					}
				});
			}
		});
		for (var i in dfCustomizerLocalize.presetRequired[_this.builderType].sections) {
			_.each(wp.customize.section(dfCustomizerLocalize.presetRequired[_this.builderType].sections[i]).controls(), function (control, b) {
				if (!$(control.selector).hasClass('customize-control-kirki-custom')) {
					itemDataSection[control.id] = control.setting.get();
				}
			});
		}
		for (var j in dfCustomizerLocalize.presetRequired[_this.builderType].controls) {
			itemDataSection[dfCustomizerLocalize.presetRequired[_this.builderType].controls[j]] = api.control(dfCustomizerLocalize.presetRequired[_this.builderType].controls[j]).setting.get();
		}
		_this.builderValue['dataSection'] = itemDataSection;
	}
	DFBuilderCustomizer.prototype.setValueSavedItemSection = function () {
		var _this = this,
			control;

		if (typeof _this.builderValue['dataSection'] != 'undefined') {
			for (var i in _this.builderValue['dataSection']) {
				if (typeof _this.builderValue['dataSection'][i] != 'undefined') {
					control = api.control(i.indexOf('[') == -1 ? i : i + ']');
					if (typeof control !== 'object') {
						continue;
					}
					control.setting.set(_this.builderValue['dataSection'][i]);
					$('form#customize-controls [data-customize-setting-link="' + control.id + '"]').val(_this.builderValue['dataSection'][i]);
				}
			}
		}
		_this.removeRow();
		_this.initRemoveColumn();
		$('.de-custom-' + _this.builderType + '__preset').slideUp();
		$('.de-custom-' + _this.builderType + '__builder').slideDown();
		$('.de-custom-' + _this.builderType + '__wrapper-icon').removeClass('wrapper-icon--active');
		$('.de-custom-' + _this.builderType + '__wrapper-tooltip:nth-child(1) .de-custom-' + _this.builderType + '__wrapper-icon').addClass('wrapper-icon--active');
	}
	DFBuilderCustomizer.prototype.checkSetPresetasDefault = function () {
		var _this = this,
			isPresetDefault, presetDefault;

		isPresetDefault = _this.builderControlIsUsePreset.setting._value;
		presetDefault = _this.builderControlPresetUsed.setting._value;
		if (typeof isPresetDefault !== 'undefined' && isPresetDefault == 1) {
			$('.de-custom-' + _this.builderType + '__preset-item[data-preset-name="' + presetDefault + '"]').addClass('default-preset--active');
		}
	}
	DFBuilderCustomizer.prototype.setPresetasDefault = function () {
		var _this = this,
			item, itemName, itemData;
		// bind delete preset event
		$('.de-custom-' + _this.builderType + '__preset-item-set').off('click');
		$('.de-custom-' + _this.builderType + '__preset-item-set').on('click',function (e) {
			// get preset item name
			item = $(this).parents('.de-custom-' + _this.builderType + '__preset-item');
			itemName = item.attr('data-preset-name');
			itemData = item.attr('data-preset-value');
			_this.presetDefault(itemName, itemData);
			$('.de-custom-' + _this.builderType + '__wrapper-default-preset-title').html(itemName);
		});
	}
	DFBuilderCustomizer.prototype.setDefaultAsTemplate = function () {
		var _this = this,
			item, itemName, itemData;
		// bind delete preset event
		$('.de-custom-' + _this.builderType + '__preset-item-set-template').off('click');
		$('.de-custom-' + _this.builderType + '__preset-item-set-template').on('click',function (e) {
			// get preset item name
			item = $(this).parents('.de-custom-' + _this.builderType + '__preset-item');
			itemName = item.attr('data-preset-name');
			itemData = item.attr('data-preset-value');
			_this.setTemplate(itemName, itemData);
		});
	}
	DFBuilderCustomizer.prototype.setPresetasDefaultOnEdit = function () {
		var _this = this,
			itemName, itemData;

		$('.de-wrapper-' + _this.builderType + '-builder .de-custom-' + _this.builderType + '__wrapper-default').on('click',function () {
			itemName = $(this).attr('data-preset-name');
			itemData = $(this).attr('data-preset-value');
			_this.presetDefault(itemName, itemData);
		});
	}
	DFBuilderCustomizer.prototype.presetDefault = function (itemName, itemData) {
		var _this = this;

		_this.setBuilderValue(_this.parseJson(itemData));
		_this.builderControlEdit.setting.set('');
		_this.builderControlIsEdit.setting.set('0');
		_this.builderControlEditName = '';
		_this.setBuilder();
		_this.setValueSavedItemSection();
		_this.bindValue();
		_this.builderControlIsUsePreset.setting.set('1');
		_this.builderControlPresetUsed.setting.set(itemName);
		// give name & state set as default
		alert('Preset setup success');
		$('.de-custom-' + _this.builderType + '__preset-item').removeClass('default-preset--active');
		$('.de-custom-' + _this.builderType + '__preset-item[data-preset-name="' + itemName + '"]').addClass('default-preset--active');
		$('.de-custom-' + _this.builderType + '__wrapper-default-preset-title').html('');
		$('.de-wrapper-' + _this.builderType + '-builder .de-custom-' + _this.builderType + '__wrapper-default').removeClass('active');
		$('.de-wrapper-' + _this.builderType + '-builder .de-custom-' + _this.builderType + '__wrapper-default-set').removeClass('active');
		$('.de-custom-' + _this.builderType + '__wrapper-default-cancel').removeClass('active');
	}
	DFBuilderCustomizer.prototype.setTemplate = function (itemName, itemData) {
		var _this = this;
		_this.setBuilderValue(_this.parseJson(itemData));
		_this.setBuilder();
		_this.setValueSavedItemSection();
		_this.bindValue();
	}
	DFBuilderCustomizer.prototype.editPreset = function () {
		var _this = this,
			itemName,
			item,
			itemData;
		// bind delete preset event
		$('.de-custom-' + _this.builderType + '__preset-item-edit').off('click');
		$('.de-custom-' + _this.builderType + '__preset-item-edit').on('click',function (e) {
			// get preset item name
			item = $(this).parents('.de-custom-' + _this.builderType + '__preset-item');
			itemName = item.attr('data-preset-name');
			itemData = item.attr('data-preset-value');
			_this.setBuilderValue(_this.parseJson(itemData));
			_this.builderControlEdit.setting.set(itemData);
			_this.builderControlIsEdit.setting.set('1');
			_this.builderControlEditName = itemName;
			_this.setBuilder();
			_this.setValueSavedItemSection();
			_this.cancelEditPreset();
			// if preset item is default show default button
			if (item.hasClass('default-preset--active')) {
				$('.de-wrapper-' + _this.builderType + '-builder .de-custom-' + _this.builderType + '__wrapper-default').removeClass('active');
				$('.de-wrapper-' + _this.builderType + '-builder .de-custom-' + _this.builderType + '__wrapper-default-set').addClass('active');
			} else {
				$('.de-wrapper-' + _this.builderType + '-builder .de-custom-' + _this.builderType + '__wrapper-default-set').removeClass('active');
				$('.de-wrapper-' + _this.builderType + '-builder .de-custom-' + _this.builderType + '__wrapper-default').addClass('active');
			}
			// give name set as default
			$('.de-custom-' + _this.builderType + '__wrapper-default-preset-title').html(' - ' + itemName + ' (Current)');
			$('.de-wrapper-' + _this.builderType + '-builder .de-custom-' + _this.builderType + '__wrapper-default-cancel').addClass('active');
			$('.de-wrapper-' + _this.builderType + '-builder .de-custom-' + _this.builderType + '__wrapper-default').attr({
				'data-preset-name': itemName,
				'data-preset-value': itemData
			});
		});
	}
	DFBuilderCustomizer.prototype.cancelEditPreset = function () {
		var _this = this;

		$('.de-wrapper-' + _this.builderType + '-builder .de-custom-' + _this.builderType + '__wrapper-default-cancel').on('click',function () {
			_this.builderControlIsEdit.setting.set('0');
			_this.builderControlEdit.setting.set('');
			_this.setBuilderValue(_this.parseJson(_this.builderControl.setting.get()));
			_this.setBuilder();
			$('.de-custom-' + _this.builderType + '__wrapper-default-preset-title').html('');
			$('.de-custom-' + _this.builderType + '__wrapper-default').removeClass('active');
			$('.de-custom-' + _this.builderType + '__wrapper-default-set').removeClass('active');
			$(this).removeClass('active');
		});
	}
	DFBuilderCustomizer.prototype.removePreset = function () {
		var _this = this,
			itemName, confirmMessage, item;

		// bind delete preset event
		$('.de-custom-' + _this.builderType + '__preset-item-delete').off('click');
		$('.de-custom-' + _this.builderType + '__preset-item-delete').on('click',function (e) {
			// get preset item name
			item = $(this).parents('.de-custom-' + _this.builderType + '__preset-item');
			itemName = item.attr('data-preset-name');
			// confirm delete data
			confirmMessage = confirm('Are you sure want to DELETE preset name: ' + itemName + ' ?');
			if (confirmMessage == true) {
				// request delete data from database
				$.ajax({
					type: 'POST',
					url: ajaxurl,
					async: true,
					data: {
						'action': 'df_customize_builder_remove_preset',
						'preset': {
							name: itemName,
							builder_type: _this.builderType,
							action_type: 'delete'
						}
					},
					success: function (response) {
						var result = $.parseJSON(response);
						// inform delete result
						switch (result.status) {
							case 0:
								alert(result.message);
								break;
							case 1:
								alert(result.message);
								// then reload the preset list
								_this.getSavedPresetReload();
								break;
						}
					}
				});
			}
		});
	}
	DFBuilderCustomizer.prototype.togglePresetContainer = function () {
		var _this = this;

		$('.de-custom-' + _this.builderType + '__wrapper-open-container').on('click',function () {
			if (_this.builderControlIsEdit.setting.get() == 1) {
				$('.de-custom-' + _this.builderType + '__wrapper-preset-container-save').hide();
				$('.de-custom-' + _this.builderType + '__wrapper-preset-container-edit').show();
			} else {
				$('.de-custom-' + _this.builderType + '__wrapper-preset-container-save').show();
				$('.de-custom-' + _this.builderType + '__wrapper-preset-container-edit').hide();
			}
			$('.de-custom-' + _this.builderType + '__wrapper-preset-container').addClass('active');
		});

		$('.de-custom-' + _this.builderType + '__wrapper-preset-container-close').on('click',function () {
			$('.de-custom-' + _this.builderType + '__wrapper-preset-container').removeClass('active');
		});
	}
	/** Preset functions End */

	DFCustomizerExportImport.prototype._export = function () {
		window.location.href = dfExportImport.config.customizerURL + '?dahz-customizer-export=' + dfExportImport.config.exportNonce;
	}
	DFCustomizerExportImport.prototype._exportColorScheme = function () {
		window.location.href = dfExportImport.config.customizerURL + '?dahz-customizer-export-color-scheme=' + dfExportImport.config.exportColorSchemeNonce;
	}
	DFCustomizerExportImport.prototype.preset_export = function () {
		var presetType = $(this).attr('data-to-export'),
			nonceType = presetType == 'header-preset' ? dfExportImport.config.headerPresetNonce : dfExportImport.config.footerPresetNonce;

		window.location.href = dfExportImport.config.customizerURL + '?dahz-' + presetType + '-export=' + nonceType;
	}
	DFCustomizerExportImport.prototype._import = function () {
		var win = $(window),
			body = $('body'),
			form = $('<form class="dahz-customize-import-form" method="POST" enctype="multipart/form-data"></form>'),
			controls = $('.dahz-customizer-import-controls'),
			file = $('input[name=dahz-customizer-import-file]'),
			message = $('.dahz-customizer-uploading');

		if ('' == file.val()) {
			alert(dfExportImport.messages.emptyImport);
		} else {
			win.off('beforeunload');
			body.append(form);
			form.append(controls);
			message.show();
			form.trigger('submit');
		}
	}
	DFCustomizerExportImport.prototype.preset_import = function () {
		var presetType = $(this).attr('data-to-export'),
			win = $(window),
			body = $('body'),
			form = $('<form class="dahz-customize-import-form" method="POST" enctype="multipart/form-data"></form>'),
			controls = $('.dahz-' + presetType + '-import-controls'),
			file = $('input[name=dahz-' + presetType + '-import-file]'),
			message = $('.dahz-' + presetType + '-uploading');

		if ('' == file.val()) {
			alert(dfExportImport.messages.emptyImport);
		} else {
			win.off('beforeunload');
			body.append(form);
			form.append(controls);
			message.show();
			form.trigger('submit');
		}
	}
	DFCustomizeMergeScripts.prototype.purge_scripts = function () {
		$.ajax({
			url: dfCustomizerLocalize.ajaxURL,
			type: 'POST',
			async: true,
			data: {
				action: 'dahz_framework_purge_merged_scripts',
			},
			success: function success(data) {
				alert(dfCustomizerLocalize.notices.deletedMergedScripts);
			}
		});
	}

	headerPanel.expanded.bind(function (state) {
		var device, deviceType;
		$('#accordion-section-header_builder').hide();
		$('#accordion-section-headermobile_builder').hide();
		device = $('#customize-footer-actions .devices button.active').attr('data-device');
		deviceType = device == 'tablet' ? 'mobile' : device;
		if (state == true) {
			$('.de-customize-shortcut__btn[data-shortcut="header"]').addClass('active');
			if (deviceType == 'desktop') {
				if (typeof $(headerPanel.headContainer).attr('is-header-builder-renderred') == 'undefined') {
					window.headerBuilder = new DFBuilderCustomizer(
						'header',
						api.control('header_builder_element_desktop'),
						api.control('header_builder_element_desktop_edit'),
						api.control('header_builder_element_desktop_is_edit'),
						api.control('header_builder_element_desktop_preset_used'),
						api.control('header_builder_element_desktop_is_use_preset'),
						headerPanel
					);
				} else {
					headerBuilder.init('header');
				}
			} else if (deviceType == 'mobile') {
				if (typeof $(headerPanel.headContainer).attr('is-headermobile-builder-renderred') == 'undefined') {
					window.headerMobileBuilder = new DFBuilderCustomizer(
						'headermobile',
						api.control('headermobile_builder_element_mobile'),
						api.control('headermobile_builder_element_mobile_edit'),
						api.control('headermobile_builder_element_mobile_is_edit'),
						api.control('headermobile_builder_element_mobile_preset_used'),
						api.control('headermobile_builder_element_mobile_is_use_preset'),
						headerPanel
					);
				} else {
					headerMobileBuilder.init('headermobile');
				}
			}
		} else {
			if (deviceType == 'desktop') {
				headerBuilder.destroy();
			} else if (deviceType == 'mobile') {
				headerMobileBuilder.destroy();
			}
			$('.de-customize-shortcut__btn[data-shortcut="header"]').removeClass('active');
			$('.de-customize-shortcut').css({
				'transform': 'none',
				'transition': '.4s'
			});
		}
	});

	footerPanel.expanded.bind(function (state) {
		$('#accordion-section-footer_builder').hide();
		if (state == true) {
			$('.de-customize-shortcut__btn[data-shortcut="footer"]').addClass('active');
			if (typeof $(footerPanel.headContainer).attr('is-footer-builder-renderred') == 'undefined') {
				window.footerBuilder = new DFBuilderCustomizer(
					'footer',
					api.control('footer_builder_element_desktop'),
					api.control('footer_builder_element_desktop_edit'),
					api.control('footer_builder_element_desktop_is_edit'),
					api.control('footer_builder_element_desktop_preset_used'),
					api.control('footer_builder_element_desktop_is_use_preset'),
					footerPanel
				);
			} else {
				footerBuilder.init('footer');
			}
		} else {
			$('.de-customize-shortcut__btn[data-shortcut="footer"]').removeClass('active');
			footerBuilder.destroy();
		}
	});

	$('#customize-footer-actions .devices button').on('click',function () {
		var device, deviceType;

		device = $(this).attr('data-device');
		deviceType = device == 'tablet' ? 'mobile' : device;
		if (headerPanel.expanded()) {
			switch (deviceType) {
				case 'desktop':
					if (typeof $(headerPanel.headContainer).attr('is-header-builder-renderred') == 'undefined') {
						window.headerBuilder = new DFBuilderCustomizer(
							'header',
							api.control('header_builder_element_desktop'),
							api.control('header_builder_element_desktop_edit'),
							api.control('header_builder_element_desktop_is_edit'),
							api.control('header_builder_element_desktop_preset_used'),
							api.control('header_builder_element_desktop_is_use_preset'),
							headerPanel
						);
					} else {
						headerBuilder.init('header');
					}
					if (typeof headerMobileBuilder !== 'undefined') {
						headerMobileBuilder.destroy();
						$('.de-customize-shortcut').css({
							'transform': 'none',
							'transition': '.4s'
						});
					}
					break;
				case 'mobile':
					if (typeof $(headerPanel.headContainer).attr('is-headermobile-builder-renderred') == 'undefined') {
						window.headerMobileBuilder = new DFBuilderCustomizer(
							'headermobile',
							api.control('headermobile_builder_element_mobile'),
							api.control('headermobile_builder_element_mobile_edit'),
							api.control('headermobile_builder_element_mobile_is_edit'),
							api.control('headermobile_builder_element_mobile_preset_used'),
							api.control('headermobile_builder_element_mobile_is_use_preset'),
							headerPanel
						);
					} else {
						headerMobileBuilder.init('headermobile');
					}
					if (typeof headerBuilder !== 'undefined') {
						headerBuilder.destroy();
						$('.de-customize-shortcut').css({
							'transform': 'none',
							'transition': '.4s'
						});
					}
					break;
			}
		}
	});

	$('.de-customize-shortcut__btn').on('click',function () {
		var shortcut = $(this).attr('data-shortcut');
		if (shortcut != 'undefined') {
			$('#accordion-panel-' + shortcut + ' h3').trigger('click');
		}
	});

	api('logo_and_site_identity_header_style', function (t) {
		t.bind(function (t) {
			if (t !== 'horizontal' && typeof window.headerBuilder !== 'undefined' && !window.headerBuilder.builderIsVertical) {
				window.headerBuilder.builderIsVertical = true;
				window.headerBuilder.BuilderVerticalInit();
			}
			if (t == 'horizontal' && typeof window.headerBuilder !== 'undefined' && window.headerBuilder.builderIsVertical) {
				window.headerBuilder.builderIsVertical = false;
				window.headerBuilder.BuilderVerticalDestroy();
			}
		})
	});

	new DFCustomizerExportImport();

	new DFCustomizeMergeScripts();

	api.control('blogname').section('logo_and_site_identity');
	api.control('blogdescription').section('logo_and_site_identity');
	api.control('site_icon').section('logo_and_site_identity');
	api.control('blogname').priority(11);
	api.control('blogdescription').priority(11);
	$(api.control('logo_and_site_identity_header_style').selector).hide();
});