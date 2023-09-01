( function( $, v, undefined ) {
	'use strict';

	function productThumbsFix() {
		let gallery = document.querySelector( '.woocommerce-product-gallery' );

		if ( ! gallery ) {
			return;
		}

		// scrollable thumbnails - always show the active thumbnail
		let observerImageChange = new MutationObserver( mutationList => {
			for ( let record of mutationList ) {
				if ( record.type === 'attributes' && record.attributeName === 'class' && record.target.matches( 'img.flex-active' ) ) {
					record.target.scrollIntoView({block: "nearest", inline: "nearest", behavior: 'smooth'});
				}
			}
		});

		let observerThumbsLoaded = new MutationObserver( mutationList => {
			for ( let record of mutationList ) {
				if ( record.type === 'childList' && 'addedNodes' in record ) {
					for ( let node of record.addedNodes ) {
						if ( node.matches( '.flex-control-thumbs' ) ) {
							v.waitForLoad( thumbsLoaded );
						}
					}
				}
			}
		});

		let thumbs;

		let scrollTop;
		let offsetHeight, scrollHeight;

		const numThumbs = getComputedStyle( gallery ).getPropertyValue('--vamtam-single-product-vertical-thumbs') || 4;

		const prevThumbs = document.createElement( 'div' );
		prevThumbs.classList.add( 'vamtam-product-gallery-thumbs-prev' );

		prevThumbs.addEventListener( 'click', () => {
			let newTop = thumbs.scrollTop - offsetHeight;

			showOrHideButtons( newTop );

			thumbs.scrollTo( { top: newTop, behavior: 'smooth' } );
		} );

		const nextThumbs = document.createElement( 'div' );
		nextThumbs.classList.add( 'vamtam-product-gallery-thumbs-next' );

		nextThumbs.addEventListener( 'click', () => {
			let newTop = thumbs.scrollTop + offsetHeight;

			showOrHideButtons( newTop );

			thumbs.scrollTo( { top: newTop, behavior: 'smooth' } );
		} );

		function showOrHideButtons( top ) {
			prevThumbs.classList.toggle( 'hidden', top <= 0 );
			nextThumbs.classList.toggle( 'hidden', top + offsetHeight >= scrollHeight );
		}

		function onScroll() {
			requestAnimationFrame( () => {
				scrollTop = thumbs.scrollTop;

				showOrHideButtons( scrollTop );
			} );
		}

		function thumbsLoaded() {
			requestAnimationFrame( () => {
				thumbs       = gallery.querySelector( '.flex-control-thumbs' );
				scrollTop    = thumbs.scrollTop;
				offsetHeight = thumbs.offsetHeight;
				scrollHeight = thumbs.scrollHeight;

				if ( thumbs.childElementCount <= numThumbs ) {
					prevThumbs.style.display = 'none';
					nextThumbs.style.display = 'none';
				}

				showOrHideButtons( scrollTop );

				thumbs.addEventListener( 'scroll', v.debounce( onScroll, 100 ), { passive: true } );

				gallery.append( prevThumbs, nextThumbs );

				thumbs.addEventListener( 'touchstart', e => {
					e.stopPropagation();
				} );

				let blockClicks = false;

				const preventClick = (e) => {
					if ( blockClicks ) {
						e.preventDefault();
						e.stopPropagation();
						blockClicks = false;
					}
				};

				// we need to stop the event propagation from the img element, can't do this on the wrapper
				thumbs.querySelectorAll( 'img, a' ).forEach( el => {
					el.addEventListener( 'click', preventClick );
					el.addEventListener( 'touchend', preventClick );
					el.addEventListener( 'keyup', preventClick );
				} );

				let touchend = function( e ) {
					e.stopPropagation();
					e.preventDefault();

					thumbs.removeEventListener( 'touchend', touchend );
				};

				thumbs.addEventListener( 'touchmove', e => {
					e.stopPropagation();

					blockClicks = true;

					thumbs.addEventListener( 'touchend', touchend );
				} );
			} );
		}

		// Start observing.
		observerImageChange.observe( gallery, {
			attributes: true,
			subtree: true,
		});

		observerThumbsLoaded.observe( gallery, {
			childList: true,
			subtree: true,
		} );
	}

	document.addEventListener('DOMContentLoaded', function() {
		productThumbsFix();
	});
} )( jQuery, window.VAMTAM );
