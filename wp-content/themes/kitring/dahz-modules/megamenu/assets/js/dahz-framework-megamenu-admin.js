(function($){
	"use strict";
	var dfNavMegamenu = function (){
		
	}
	
	dfNavMegamenu.prototype.initUploader = function(content){
		var meta_image_frame,
			uploadButton = jQuery('.de-upload-button'),
			deleteUploadButton = jQuery('.de-delete-upload-button'),
			selector,
			inputHandler,
			imageHandler,
			_this,
			$container,
			_self = this;
		if(typeof content !== 'undefined'){
			uploadButton = $('.is-dahz-mega-menu',content);
			deleteUploadButton = jQuery('.de-delete-upload-button',content);
		}
		
		uploadButton.unbind('click');
		
		deleteUploadButton.unbind('click');
		
		uploadButton.on('click',function(e) {
			
			_this = this;
			selector = jQuery(this);
			$container = selector.parents('.de-uploader.de-mega-menu');
			// Prevents the default action from occuring.
			e.preventDefault();
	
			// If the frame already exists, re-open it.
			if ( meta_image_frame ) {
				meta_image_frame.open();
			} else {
				// Sets up the media library frame
				meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
					title: 'Choose Image',
					button: { text:  'Choose Image' },
					library: { type: 'image' }
				});
				meta_image_frame.open();
			}
			meta_image_frame.off('select');
			// Runs when an image is selected.
			meta_image_frame.on('select', function(){
				
				var attachment = meta_image_frame.state().get('selection').first().toJSON(),
					attachment_url, attachment_width, attachment_height;
				
				if( typeof attachment !== 'object' ) return;
				
				if( typeof attachment.sizes !== 'undefined' ){
					if( typeof attachment.sizes.thumbnail !== 'undefined' ){
						attachment_url = attachment.sizes.thumbnail.url;
						attachment_width = attachment.sizes.thumbnail.width;
						attachment_height = attachment.sizes.thumbnail.height;
					} else if( typeof attachment.sizes.medium !== 'undefined' ){
						attachment_url = attachment.sizes.medium.url;
						attachment_width = attachment.sizes.medium.width;
						attachment_height = attachment.sizes.medium.height;
					} else if( typeof attachment.sizes.full !== 'undefined' ){
						attachment_url = attachment.sizes.full.url;
						attachment_width = attachment.sizes.full.width;
						attachment_height = attachment.sizes.full.height;
					} else {
						attachment_url = attachment.url;
						attachment_width = attachment.width;
						attachment_height = attachment.height;
					}
				} else {
					attachment_url = attachment.url;
					attachment_width = attachment.width;
					attachment_height = attachment.height;
				}
				
				_self.setImageUpload( $container, attachment_url, attachment_width, attachment_height );
				_self.setValueUpload( $container, attachment.id );

			});
		});
		
		deleteUploadButton.on('click',function(e) {
			selector = jQuery(this);
			$container = selector.parents('.de-uploader.de-mega-menu');
			$('img',$container).remove();
			_self.setValueUpload( $container, "" );
		});
	}
	
	dfNavMegamenu.prototype.setImageUpload = function( $container, url, width, height ){
		var imageUpload = $('img', $container);
		if( imageUpload.length ){
			imageUpload.attr( 'src', url );
			imageUpload.attr( 'width', width );
			imageUpload.attr( 'height', height );
		} else {
			$container.prepend( 
				'<img src="'+url+'" width="'+width+'" height="'+height+'" >'
			);
		}
		
	}
	dfNavMegamenu.prototype.setValueUpload = function( $container, value ){
		$('.de-to-element.de-uploader-path', $container)
			.val( value )
			.trigger('change');
	}
	
	dfNavMegamenu.prototype.initAutoComplete = function(content){
		var _that = this;
		var autocompleteElement = $('.de-autocomplete-megamenu');
		if(typeof content !== 'undefined'){
			autocompleteElement = $('.de-autocomplete-megamenu',content);
		}
		autocompleteElement.each(function(){
			var _this = this;
			var parentForm = $(_this).parent().parent().parent();
			
			_that.setDataAutoComplete(_this,$('.source-carousel',parentForm).val());
			$('.source-carousel',parentForm).on('change',function(){
				_that.setDataAutoComplete( _this, $(this).val());
			})
		});


	}
	
	dfNavMegamenu.prototype.setDataAutoComplete = function($el,source){
		var optionsAutoComplete = {
			 searchContain: true,
			 textProperty: 'id: {id} , name: {text}',
			 valueProperty: 'id',
			 minLength: 1,
			 focusFirstResult: true,
			 selectionRequired: true,
			 visibleProperties: ["text"],
			 searchIn: ["text","id"],
			 url:ajaxurl ,
			 cache: false,
			 params:{'action': 'dahz_framework_autocomplete','source':source},
			 chainedRelatives : true,
			 toggleSelected: false,
			 
		}
		if($($el).hasClass('flexdatalist-set')){
			$($el).flexdatalist('destroy');
		}
		
		$($el).flexdatalist(optionsAutoComplete);
		
	}
	
	dfNavMegamenu.prototype.init = function(content){
		var _that = this;
		_that.initUploader(content);
		_that.initAutoComplete(content);
		var isMegamenu = $('.is-dahz-mega-menu');
		if(typeof content !== 'undefined'){
			isMegamenu = $('.is-dahz-mega-menu',content);
		}
		isMegamenu.each(function(){
			var parentContainer = $(this).parent().parent().parent();
			var childsContainer = [];
			var objectId = $('.menu-item-data-db-id',parentContainer).val();
			$('.menu-item-data-parent-id[value="'+objectId+'"]').each(function(){
				parentContainer = $(this).parent()
				objectId = $('.menu-item-data-db-id',parentContainer).val();
				childsContainer.push( parentContainer );
				$('.menu-item-data-parent-id[value="'+objectId+'"]').each(function(){
					childsContainer.push($(this).parent());
				})
			});
			if(this.checked){
				$('.de-mega-menu',$(this).parent().parent().parent()).show();
				for( var item in childsContainer){
					$('.de-mega-menu',childsContainer[item]).show();
				}
			} else {
				$('.de-mega-menu',$(this).parent().parent().parent()).hide();
				for( var item in childsContainer){
					$('.de-mega-menu',childsContainer[item]).hide();
				}
			}
		})
		isMegamenu.on('change', function(){
			var parentContainer = $(this).parent().parent().parent();
			var childsContainer = [];
			var objectId = $('.menu-item-data-db-id',parentContainer).val();
			$('.menu-item-data-parent-id[value="'+objectId+'"]').each(function(){
				parentContainer = $(this).parent()
				objectId = $('.menu-item-data-db-id',parentContainer).val();
				childsContainer.push( parentContainer );
				$('.menu-item-data-parent-id[value="'+objectId+'"]').each(function(){
					childsContainer.push($(this).parent());
				})
			});
			if(this.checked){
				$('.de-mega-menu',$(this).parent().parent().parent()).show();
				for(var item in childsContainer){
					$('.de-mega-menu',childsContainer[item]).show();
				}
			} else {
				$('.de-mega-menu',$(this).parent().parent().parent()).hide();
				for(var item in childsContainer){
					$('.de-mega-menu',childsContainer[item]).hide();
				}
			}
			
		})
	}
	
	wpNavMenu.addItemToMenu = function(menuItem, processMethod, callback){
		var menu = $('#menu').val(),
			nonce = $('#menu-settings-column-nonce').val(),
			params;

		processMethod = processMethod || function(){};
		callback = callback || function(){};

		params = {
			'action': 'add-menu-item',
			'menu': menu,
			'menu-settings-column-nonce': nonce,
			'menu-item': menuItem
		};

		$.post( ajaxurl, params, function(menuMarkup) {
			var ins = $('#menu-instructions');

			menuMarkup = $.trim( menuMarkup ); // Trim leading whitespaces
			processMethod(menuMarkup, params);

			// Make it stand out a bit more visually, by adding a fadeIn
			$( 'li.pending' ).hide().fadeIn('slow');
			$( '.drag-instructions' ).show();
			if( ! ins.hasClass( 'menu-instructions-inactive' ) && ins.siblings().length )
				ins.addClass( 'menu-instructions-inactive' );

			callback();
			dfNavMegamenuObj.init($(menuMarkup));
		});
	}

	$(document).on('ready',function(){
		window.dfNavMegamenuObj = new dfNavMegamenu();
		dfNavMegamenuObj.init();
	})
})(jQuery);