(function( $ ){
	"use strict";
	var DFRepeater = function( target, dfMetabox ){
		this.target = target;
		this.$target = $( target );
		this.value = {};
		this.inputTarget = $( '.de-repeater-value', target );
		this.defaultValues = {};
		this.dfMetabox = dfMetabox;
		this.init();

	}
	DFRepeater.prototype.idGenerator = function(length) {
		var ts = +new Date;
		ts = ts.toString();
		var parts = ts.split( "" ).reverse();
		var id = "";
		for( var i = 0; i < length; ++i ) {
			var index = this.getRandomInt( 0, parts.length - 1 );
			id += parts[index];
		}

		return id;
	}
	DFRepeater.prototype.getRandomInt = function( min, max ) {
		return Math.floor( Math.random() * ( max - min + 1 ) ) + min;
	}
	DFRepeater.prototype.init = function(){
		var _this = this;
		if (!_.isEmpty(_this.inputTarget.val())) {
		_this.value = $.parseJSON( decodeURI( _this.inputTarget.val() ) );
		}
		_this.value = _this.value == null ? {} : _this.value;
		if( _.isEmpty( _this.value ) ){
			_this.addRepeater();
		}
		_this.defaultValues = _this.$target.data( 'default-values' );
		$( '.de-metabox-value', _this.target ).each(function(){
			_this.bindValue( $( this ).parents( '.de-repeater-item' ).data( 'item-id' ), $( this ).data( 'field-id' ), $( this ).val() );
		});

		_this.$target.on( 'change', '.de-metabox-value', function(){
			$( this ).attr( 'value', this.value );
			_this.bindValue( $( this ).parents( '.de-repeater-item' ).data( 'item-id' ), $( this ).data( 'field-id' ), $( this ).val() );
		});
		_this.$target.on( 'click', '.de-repeater-add', function(e){
			e.preventDefault();
			_this.addRepeater();
		});
		_this.$target.on( 'click', '.de-repeater-delete', function(e){
			e.preventDefault();
			_this.removeRepeater( $( this ).parents( '.de-repeater-item' ) );
		});

		_this.$target.on( 'click', '.de-repeater-clone', function(e){
			e.preventDefault();
			_this.cloneRepeater( $( this ).parents( '.de-repeater-item' ) );
		});
		
		_this.sortable();

	}
	DFRepeater.prototype.addRepeater = function( fieldId, template, value ){
		var _this = this, idGenerated = typeof fieldId == 'undefined' ? 'repeater-item-' + _this.idGenerator(8) : fieldId;

		template = typeof template !== 'undefined' ? template : $( '.de-repeater-template', _this.target ).text();
		var templateHTML = _.template( '<li class="de-repeater-item" data-item-id="'+idGenerated+'">' + template + '</li>' );
		if( typeof _this.value[idGenerated] == 'undefined' ){
			_this.value[idGenerated] = {values:{}, priority:0, id:idGenerated};
			if( typeof value !== 'undefined' && value ){
				_this.value[idGenerated] = value;
			} else {
				_this.value[idGenerated].values = _this.defaultValues;
			}
		}
		$( '.de-repeater', _this.target ).append(
			templateHTML
		).promise().done(function(){
			//_this.dfMetabox.initDependencies();
			_this.dfMetabox.initColorPicker();
			_this.dfMetabox.initUploader();
			_this.dfMetabox.initMultipleUploader();
			_this.dfMetabox.initSwitcher();
			_this.dfMetabox.initRadioImage();
			_this.dfMetabox.initChangeOembedRender();
			_this.bindValue();
			_this.sortable();
		});
	};
	DFRepeater.prototype.removeRepeater = function( $target ){
		var _this = this, itemID = $target.data( 'item-id' );
		$target.remove().promise().done(function(){
			if( typeof _this.value[itemID] !== 'undefined' ){
				delete _this.value[itemID];
			}
			_this.bindValue();
		});
	};
	DFRepeater.prototype.cloneRepeater = function( $target ){
		var _this = this, itemID = $target.data( 'item-id' );
		_this.addRepeater( 'repeater-item-' + _this.idGenerator(8), $target.html(), typeof _this.value[itemID] == 'object' ? _this.value[itemID] : false );
	};
	DFRepeater.prototype.bindValue = function( itemId, fieldId, dataValue ){
		var _this = this, value = {};
		if( typeof _this.value[itemId] == 'object' ){
			value[itemId] = {values:{}, priority:0, id:itemId};
			_.extend( value[itemId].values, _this.value[itemId].values );
			value[itemId]['values'][fieldId] = dataValue;
			_.extend( _this.value, value );
		}
		_this.setPriority();
		_this.inputTarget.val(  encodeURI( JSON.stringify( _this.value ) ) );
	}
	DFRepeater.prototype.setPriority = function(){
		var _this = this, itemId;
		$( 'ul.de-repeater li.de-repeater-item', _this.$target ).each( function( i, $el ){
			itemId = $( this ).data( 'item-id' );
			_this.value[itemId].priority = i;
		});
	}
	DFRepeater.prototype.sortable = function(){
		var _this = this;
		$( 'ul.de-repeater', _this.$target ).sortable({
			forcePlaceholderSize: true,
			handle: '.de-repeater-sort',
			stop: function (event, ui) {
				_this.bindValue();
			}
		});
	}
	

	var DFMetabox = function(){
		var _self = this;
		//_self.initDependencies();
		_self.initColorPicker();
		_self.initUploader();
		_self.initMultipleUploader();
		_self.initSwitcher();
		_self.initRadioImage();
		_self.initPanel();
		_self.initPanelTaxonomy();
		_self.initChangeOembedRender();
		_self.initRepeater();
		
	}
	DFMetabox.prototype.initDependencies = function( container, condition ){
		
		$('[dependencies]').each(function(){
			var _this = this;
			var dependencies = $.parseJSON( $(_this).attr('dependencies') );
		 });
	}
	
	DFMetabox.prototype.initColorPicker = function(){
		$('.ds-meta-color').wpColorPicker();
	}
	DFMetabox.prototype.initUploader = function(){
		var meta_image_frame,_that = this;
		$('.de-image-wrap__delete').each(function(){
			if($(this).hasClass('hide')){
				$(this).hide();
			}
		})
		// Runs when the image button is clicked.
		$('.ds-meta-upload-button').off('click');
		$('.ds-meta-upload-button').on('click',function(e){
			var _this = this;
			// Prevents the default action from occuring.
			e.preventDefault();

			// If the frame already exists, re-open it.
			if ( meta_image_frame ) {
				meta_image_frame.open();
			} else {
				// Sets up the media library frame
				meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
					title: dfMetaboxLocalize.title,
					button: { text:  dfMetaboxLocalize.button },
					library: { type: 'image' }
				});
			}
			meta_image_frame.off('select');
			// Runs when an image is selected.
			meta_image_frame.on('select', function(){

				var imageWrapper = $( _this ).parents('.de-image-wrap');

				// Grabs the attachment selection and creates a JSON representation of the model.
				var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
				// Sends the attachment URL to our custom image input field.
				$('img', imageWrapper).attr( 'src', typeof media_attachment.sizes.thumbnail !== 'undefined' ? media_attachment.sizes.thumbnail.url : media_attachment.url );
				$('.de-image-wrap__delete', imageWrapper).show();
				$('.ds-meta-image-input', imageWrapper).val( media_attachment.id ).trigger('change');

			});

			// Opens the media library frame.
			meta_image_frame.open();
		});

		_that.initUploaderDelete();
	}
	DFMetabox.prototype.initUploaderDelete = function(){
		var _this = this;
		$('.de-image-wrap__delete').off('click');
		$('.de-image-wrap__delete').on('click',function(e){
			var imageWrapper = $( this ).parents('.de-image-wrap');
			e.preventDefault();
			$('.ds-meta-image-input', imageWrapper).val( '' ).trigger('change');
			$('img', imageWrapper).attr('src', dfMetaboxLocalize.imageNone);
			$('.de-image-wrap__delete', imageWrapper).hide();
		});
	}
	DFMetabox.prototype.initMultipleUploader = function(){
		var meta_image_frame,_that = this;
		$('.de-multiple-image-wrap').each(function(){
			_that.multipleUploaderSortable( $(this) );
			_that.multipleUploaderDelete( $(this) );
		});
		// Runs when the image button is clicked.
		$('.ds-meta-multiple-upload-button').off('click');
		$('.ds-meta-multiple-upload-button').on('click',function(e){
			var _this = this;
			// Prevents the default action from occuring.
			e.preventDefault();

			// If the frame already exists, re-open it.
			if ( meta_image_frame ) {
				meta_image_frame.open();
			} else {
				// Sets up the media library frame
				meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
					title: dfMetaboxLocalize.title,
					button: { text:  dfMetaboxLocalize.button },
					library: { type: 'image' },
					multiple: true
				});
			}
			meta_image_frame.off('select');
			// Runs when an image is selected.
			meta_image_frame.on('select', function(){

				// Grabs the attachment selection and creates a JSON representation of the model.
				var media_attachment = meta_image_frame.state().get('selection').toJSON();
				_that.multipleUploaderSetImage( $('.de-multiple-image-wrap', $(_this).parents('.de-multiple-image')), media_attachment );

			});

			// Opens the media library frame.
			meta_image_frame.open();
		});
	}
	DFMetabox.prototype.multipleUploaderSetImage = function( $container, media_attachment ){
		var imagesUploaded = '', _this = this, image;
		for( var i in media_attachment ){
			image = typeof media_attachment[i].sizes.thumbnail !== 'undefined' ? media_attachment[i].sizes.thumbnail.url : media_attachment[i].url;
			imagesUploaded += '<div class="de-multiple-image-item" data-id="'+media_attachment[i].id+'">'+
								'<a href="#" class="de-multiple-image-item__delete">-</a>'+
								'<img src="'+image+'">'+
							'</div>';
		}
		$container.append(imagesUploaded).promise().done(function(){
			_this.multipleUploaderBindValue( $container );
			_this.multipleUploaderSortable( $container );
			_this.multipleUploaderDelete( $container );
		})
	}
	DFMetabox.prototype.multipleUploaderSortable = function( $container ){
		var _this = this;
		$container.sortable({
			forcePlaceholderSize: true,
			placeholder: 'de-sortable-placeholder-row',
			stop:function( event, ui ){
				_this.multipleUploaderBindValue($container);
			}
		});
	}
	DFMetabox.prototype.multipleUploaderBindValue = function( $container ){
		var value = [];
		$('.de-multiple-image-item', $container).each(function(){
			value.push( $(this).attr('data-id') );
		});
		$('.ds-meta-image-input',$container).val( value.join() ).trigger('change');
	}
	DFMetabox.prototype.multipleUploaderDelete = function( $container ){
		var _this = this;
		$('.de-multiple-image-item__delete',$container).off('click');
		$('.de-multiple-image-item__delete',$container).on('click',function(e){
			e.preventDefault();
			$(this).parent().remove().promise().done(function(){
				_this.multipleUploaderBindValue($container)
			})
		});
	}
	DFMetabox.prototype.initSwitcher = function(){
		$.fn.toggleClick = function () {
			var methods = arguments, // store the passed arguments for future reference
				count = methods.length; // cache the number of methods 

			//use return this to maintain jQuery chainability
			return this.each(function (i, item) {
				// for each element you bind to
				var index = 0; // create a local counter for that element
				$(item).on("click", function () {
					return methods[index++ % count].apply(this, arguments); // that when called will apply the 'index'th method to that element

				});

			});
		};
		$('.de-switcher').each(function(){
			var _this = this;
			var switcherInput   = $( '.ds-switcher', $( _this ) );
			if( switcherInput.val() == 'on' ){
				$( _this ).addClass('on');
			} else {
				$( _this ).removeClass('on');
			}
		});
		$('.de-switcher').toggleClick(function(e) {
			var switcherInput   = $( '.ds-switcher', $( this ) );
			$( this ).addClass('on');
			$(this).show();
			switcherInput.val('on').trigger('change');
		}, function(e) {
			var switcherInput   = $( '.ds-switcher', $( this ) );
			$(this).show();
			$(this).removeClass('on');
			switcherInput.val('off').trigger('change');
		});
	}
	DFMetabox.prototype.initRadioImage = function(){
		$('ul.de-radio-image-button').each(function(){
			if( typeof $( 'input[type="radio"]:checked', $(this) ).val() !== 'undefined' ){
				$( 'input[type="radio"]:checked', $(this) ).parents('li').addClass('selected');
			} else {
				if( $( 'input[type="radio"]', $(this) ).length ){
					$( 'input[type="radio"]', $(this) ).first().prop('checked', true).trigger('change');
					$('li',$(this)).first().addClass('selected');
				}
			}
		});
		$('ul.de-radio-image-button li').off('click')
		$('ul.de-radio-image-button li img').on('click',function(){
			$('li', $( this ).parents( 'ul.de-radio-image-button' ) ).removeClass('selected');
			$(this).parents('li').addClass('selected');
			$( 'input[type="radio"]', $(this).parents('li') ).prop('checked', true).trigger('change');
		});
	}
	DFMetabox.prototype.initPanel = function(){

		$('.menu-item.has-child a').on('click',function(e){
			e.preventDefault();
			$('.de-metabox-menu__inner', $(this).parent() ).addClass('is-active');
		});

		$('.de-metabox-menu__inside--item:not(.close) a').on('click',function(e){
			e.preventDefault();
			$('.de-metabox-menu__inside--item:not(.close)', $(this).parents('.postbox')).removeClass('active');
			$(this).parents('.de-metabox-menu__inside--item').addClass('active');
			$(".de-metabox-inner", $(this).parents('.postbox'))
				.hide()
				.removeClass('active');
			var valueID = $(this).attr('href');
			$(".de-metabox-inner" + valueID , $(this).parents('.postbox'))
				.fadeIn()
				.addClass('active');
		});

		$('.de-metabox-menu__inside--item.close a').on('click',function(e){

			e.preventDefault();

			var $elem = $(this).parents('.de-metabox-menu__inner');

			$elem.addClass('is-closing');

			$elem.one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(e){

				$(this).removeClass('is-active is-closing');

			});

			$elem.one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',
				function(e) {

				$(this).removeClass('is-active is-closing').blur();

			});

		});
		$('.postbox').each(function(){

			$('a', $('.de-metabox-menu__inside--item:not(.close):not(.hide-dependencies)').first() ).trigger('click');

		});
	}
	DFMetabox.prototype.initPanelTaxonomy = function(){
		var defaultValue = $('.page-title-style').attr('data-value');
		if( defaultValue == 'upload' ){
			$('.form-upload').show();
			$('.form-custom').hide();
		} else if( defaultValue == 'custom' ) {
			$('.form-custom').show();
			$('.form-upload').hide();
		} else {
			$('.form-custom').hide();
			$('.form-upload').hide();
		}
		$('ul.page-title-style li').unbind('click')
		$('ul.page-title-style li img').each(function(){
			$( 'input[type="radio"]', $(this).parents('li') ).on('change', function(){
				var valueChange = $(this).val();
				if( valueChange == 'upload' ){
					$('.form-upload').show();
					$('.form-custom').hide();
				} else if( valueChange == 'custom' ) {
					$('.form-custom').show();
					$('.form-upload').hide();
				} else {
					$('.form-custom').hide();
					$('.form-upload').hide();
				}
			});
		});
		var defaultValuePageTitle = $('.custom-title-type select').attr('data-value');
		if( defaultValuePageTitle == 'content-block' ){
			$('.custom-content-block').show();
			$('.custom-rev-slider').hide();
		} else if( defaultValuePageTitle == 'rev-slider' ) {
			$('.custom-rev-slider').show();
			$('.custom-content-block').hide();
		} else {
			$('.custom-rev-slider').hide();
			$('.custom-content-block').hide();
		}
		$('.custom-title-type select').on('change', function(e){
			var defaultValueChange = e.currentTarget.value;
			if( defaultValueChange == 'content-block' ){
				$('.custom-content-block').show();
				$('.custom-rev-slider').hide();
			} else if( defaultValueChange == 'rev-slider' ) {
				$('.custom-rev-slider').show();
				$('.custom-content-block').hide();
			} else {
				$('.custom-rev-slider').hide();
				$('.custom-content-block').hide();
			}
		});
	}
	DFMetabox.prototype.initOembedRender = function( i, el ){
		var _that = typeof el !== 'undefined' ? $( el ) : $(i.target);
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			async: true,
			data:{
				action: 'request_oembed',
				renderItem: _that.val()
			},
			success: function( data ){
				//Do something with the result from server
				$( '.oembed-container' , _that.parent()).html( data );
			}
		});
	}
	DFMetabox.prototype.initChangeOembedRender = function(){
		var _this = this;
		$( 'input[data-is-oembed="true"]' ).each( _this.initOembedRender );
		$( 'input[data-is-oembed="true"]' ).off('change');
		$( 'input[data-is-oembed="true"]' ).on( 'change', _this.initOembedRender );
	}
	DFMetabox.prototype.initRepeater = function(){
		var _this = this;
		$( '.de-repeater-container' ).each( function(){
			new DFRepeater( this, _this );
		});
	}
	$( document ).on('ready',function($){

		window.dfMetabox = new DFMetabox();
		
		metaboxDependency.init();

	});
	
	window.metaboxDependency = {
		toggle : function( container, condition ){
			var dependenciesType = $(container).attr('data-dependencies-type');
			if(condition){
				switch( dependenciesType ){
					case "section" :
						$(container)
							.show()
							.removeClass('hide-dependencies');
						break;
					case "panel" :
						break;
					default:
						$(container)
							.show();
						break;
				}
			} else {
				switch( dependenciesType ){
					case "section" :
						$(container)
							.hide()
							.addClass('hide-dependencies');
						if( $(container).hasClass('active') ){
								$(container).removeClass('active');
								$('a', $('.de-metabox-menu__inside--item:not(.close):not(.hide-dependencies)',$(container).parents('.postbox')).first() ).trigger('click');
						}
						if( ! $( '.de-metabox-menu__inside--item:not(.close):not(.hide-dependencies)',$(container).parents('.postbox') ).length ){
							$(".de-metabox-inner", $(container).parents('.postbox'))
								.hide()
								.removeClass('active');
						}
						if( $( '.de-metabox-menu__inside--item:not(.close):not(.hide-dependencies)',$(container).parents('.postbox') ).length
							&& !$( '.de-metabox-menu__inside--item:not(.close):not(.hide-dependencies).active',$(container).parents('.postbox') ).length
						){
							$('a', $('.de-metabox-menu__inside--item:not(.close):not(.hide-dependencies)',$(container).parents('.postbox')).first() ).trigger('click');
						}
						break;
					case "panel" :
						break;
					default:
						$(container)
						.hide();
						break;
				}
			}
		},
		condition : function( container, dependencies ){
			var condition = '';
			var operand = $(container).attr('data-dependencies-operator');
			for( var i in dependencies ){
				if( i >= ( dependencies.length - 1 ) ){
					operand = '';
				}
				if( typeof dependencies[i]['setting'] !== 'undefined' ){
					if( $('[data-field-id="'+dependencies[i]['setting']+'"]').attr('type') == 'radio' ){
						condition += "'" + $('[data-field-id="'+dependencies[i]['setting']+'"]:checked').val() + "'" + dependencies[i]['operator'] + "'" + dependencies[i]['value'] + "'"+ " " + operand + " ";
					} else {
						condition += "'" + $('[data-field-id="'+dependencies[i]['setting']+'"]').val() + "'" + dependencies[i]['operator'] + "'" + dependencies[i]['value'] + "'"+ " " + operand + " ";
					}
				}
				else if( typeof dependencies[i]['name'] !== 'undefined' ){
					if( $('[name="'+dependencies[i]['name']+'"]').attr('type') == 'radio' ){
						condition += "'" + $('[name="'+dependencies[i]['name']+'"]:checked').val() + "'" + dependencies[i]['operator'] + "'" + dependencies[i]['value'] + "'"+ " " + operand + " ";
					} else {
						condition += "'" + $('[name="'+dependencies[i]['name']+'"]').val() + "'" + dependencies[i]['operator'] + "'" + dependencies[i]['value'] + "'"+ " " + operand + " ";
					}
				} else {
					if( $('#'+dependencies[i]['id']).attr('type') == 'radio' ){
						condition += "'" + $('#'+dependencies[i]['id']+":checked").val() + "'" + dependencies[i]['operator'] + "'" + dependencies[i]['value'] + "'"+ " " + operand + " ";
					} else {
						condition += "'" + $('#'+dependencies[i]['id']).val() + "'" + dependencies[i]['operator'] + "'" + dependencies[i]['value'] + "'"+ " " + operand + " ";
					}
				}
			}
			return condition;
		},
		init: function(){
			metaboxDependency.set({
				body : $('body'),
				openBtnOffCanvas : $('.ds-off-canvas--open'),
				closeBtnOffCanvas : $('.ds-off-canvas--close')
			});
			$('[dependencies]').each(function(){
				var _this = this;
				var dependencies = $.parseJSON( $(_this).attr('dependencies') );
				metaboxDependency.toggle( _this, eval( metaboxDependency.condition( _this, dependencies ) ) );
			});
		},
		set: function( options ){
			_.extend(
				metaboxDependency, 
				_.pick(
					options || {}, 
					'body', 
					'openBtnOffCanvas', 
					'closeBtnOffCanvas'
				)
			);
		},
	};

	$( document ).on( 'change', function(){
		metaboxDependency.init();
	});
})(jQuery);
