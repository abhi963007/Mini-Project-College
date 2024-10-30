;(function($){
	'use strict';
	
	var doc = document,
			win = window,
			albums_grid        = [],
			albums_item        = {},
			grid_post_per_page = $('.portfolio_grid').attr('data-perload'),
			grid_container     = $('.gallary-02'),
			already_showed     = 0,
			isMobile = {
				Android: function() { return navigator.userAgent.match(/Android/i); }, 
				BlackBerry: function() { return navigator.userAgent.match(/BlackBerry/i); }, 
				iOS: function() { return navigator.userAgent.match(/iPhone|iPad|iPod/i); }, 
				Opera: function() { return navigator.userAgent.match(/Opera Mini/i); }, 
				Windows: function() { return navigator.userAgent.match(/IEMobile/i); }, 
				any: function() { return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows()); } 
			};
		
	
	albums_item.slide_type = "image";
	albums_item.img = "img/gallary/full/gallary_full_09.jpg";
	albums_item.thmb = "img/gallary/gallary_09.jpg";
	albums_item.width = "grid-item--width1";
	albums_item.categ = "studying lifestyle";
	albums_grid.push(albums_item);
	
	albums_item = {};
	albums_item.slide_type = "image";
	albums_item.img = "img/gallary/full/gallary_full_10.jpg";
	albums_item.thmb = "img/gallary/gallary_10.jpg";
	albums_item.width = "";
	albums_item.categ = "csourses studying";
	albums_grid.push(albums_item);
	
	albums_item = {};
	albums_item.slide_type = "image";
	albums_item.img = "img/gallary/full/gallary_full_11.jpg";
	albums_item.thmb = "img/gallary/gallary_11.jpg";
	albums_item.width = "";
	albums_item.categ = "meeting csourses";
	albums_grid.push(albums_item);
	
	albums_item = {};
	albums_item.slide_type = "image";
	albums_item.img = "img/gallary/full/gallary_full_12.jpg";
	albums_item.thmb = "img/gallary/gallary_12.jpg";
	albums_item.width = "grid-item--width1";
	albums_item.categ = "lessons csourses";
	albums_grid.push(albums_item);	
	
	albums_item = {};
	albums_item.slide_type = "image";
	albums_item.img = "img/gallary/full/gallary_full_13.jpg";
	albums_item.thmb = "img/gallary/gallary_13.jpg";
	albums_item.width = "Photographer Journalist";
	albums_item.categ = "lifestyle meeting lifestyle";
	albums_item.url = "img/gallary/gallary_01.jpg";
	albums_grid.push(albums_item);
	
	albums_item = {};
	albums_item.slide_type = "image";
	albums_item.img = "img/gallary/full/gallary_full_14.jpg";
	albums_item.thmb = "img/gallary/gallary_14.jpg";
	albums_item.width = "";
	albums_item.categ = "studying lessons";
	albums_item.url = "#";
	albums_grid.push(albums_item);
	
	albums_item = {};
	albums_item.slide_type = "image";
	albums_item.img = "img/gallary/full/gallary_full_15.jpg";
	albums_item.thmb = "img/gallary/gallary_15.jpg";
	albums_item.width = "grid-item--width1";
	albums_item.categ = "csourses";
	albums_item.url = "#";
	albums_grid.push(albums_item);
	
	albums_item = {};
	albums_item.slide_type = "image";
	albums_item.img = "img/gallary/full/gallary_full_16.jpg";
	albums_item.thmb = "img/gallary/gallary_16.jpg";
	albums_item.width = "grid-item--width1";
	albums_item.categ = "meeting csourses";
	albums_item.url = "#";
	albums_grid.push(albums_item);
	
	$(doc).ready(function() {
		
		if (isMobile.any()) {
			doc.documentElement.className = doc.documentElement.className + " touch";
			// Parallax
			$('.parallax').each(function(i, obj) {
				$(this).css("background-attachment", "scroll");
			});
		}
	
		// Pretty photo
		if ($('.pretty-photo').size() > 0) {
			$('.pretty-photo').prettyPhoto();
		}
		
		smart_content_update();
		
		// Video background
		var video_bg_tag = $('.video_bg');
		if (video_bg_tag.size() > 0) {
			video_bg_tag.each(function () {
				if (jQuery(this).children().length == 0) {
					jQuery(this).parent().hide();
				}
			});
			jQuery('.play-video').on('click', function(ev) {

				video_bg_tag.each(function() {
					jQuery(this).find('.video_frame').attr('src', jQuery(this).find('.play-video').attr('data-video-url'));
				});
				video_bg_tag.removeClass('show_video_now');
				jQuery(this).parent().find(".video_frame")[0].src += "&autoplay=1";
				ev.preventDefault();
				smart_video_background();
				jQuery(this).parent('.video_bg').addClass('show_video_now');
			});
		}
		
		// Owl carousel
		if ($('.owl-option-02').size() > 0) {
			$('.owl-option-02').owlCarousel({
				loop:true,
				margin:10,
				responsiveClass:true,
				dots: false,
				nav:true,
				responsive:{
					0:{
						items:2
					},
					360:{
						items:3
					},
					480:{
						items:4
					},
					767:{
						items:5
					}
				}
			});
		}
		
	});
	
	$(win).resize(function() {
		
		smart_content_update();
	
		// Height 100 percent
		if (jQuery('.height_100percent').size() > 0) {
			smart_height100_perc();
		}
		smart_fw_block();

		// Video background
		smart_video_background();

		setTimeout("smart_fw_block();",1000);

		setTimeout("smart_video_background();",1000);

		// Video-image Background
		if (jQuery('.image_video_bg_block').size() > 0) {
			smart_image_video_bg();
		}
		
	});
	
	$(win).load(function() {
		
		smart_content_update();
		
		$(".loader").fadeOut(); 
		$("#loader").delay(400).fadeOut("slow"); 
		
		// Isotope
		if ($('.grid').size() > 0) {
			// init Isotope
			var $grid = $('.grid').isotope();
			
			// Filter items on button click
			$('.filter-button-group').on( 'click', '.sort-item', function() {
				var filterValue = $(this).attr('data-filter');
				$grid.isotope({ filter: filterValue });
			});

			// Change is-checked class on buttons
			$('.sort-group').each( function( i, buttonGroup ) {
				var $buttonGroup = $( buttonGroup );
				$buttonGroup.on( 'click', '.sort-item', function(e) {
					e.preventDefault();
					$buttonGroup.find('.is-checked').removeClass('is-checked');
					$( this ).addClass('is-checked');
				});
			});
		}
		
		if ($('.gallary-01').size() > 0) {
			$('.gallary-01').isotope({
				itemSelector: '.gallary-01__item',
				percentPosition: true,
				masonry: {
					columnWidth: '.grid-sizer',
					gutter: '.gutter-sizer'
				}
			})
		}
		
		if ($('.gallary-02').size() > 0) {
			$('.gallary-02').isotope({
				itemSelector: '.gallary-02__item',
				percentPosition: true,
				masonry: {
					columnWidth: '.grid-sizer-02'
				}
			});
		}
		
		
		// Gallary		
		$(doc).on('click', '.gallary-more-btn', function(e) {
			e.preventDefault();
			
			var what_to_append = '',
					allposts = albums_grid.length;
			
			if (already_showed >= allposts) {
				$(this).slideDown(300);
			}	else {
				var now_step = already_showed + parseInt(grid_post_per_page) - 1;
				
				if (now_step < allposts) {
					var limit = now_step;
				} else {
					var limit = allposts - 1;
					$(this).slideUp(300);
				}
				
				for (var i = already_showed; i <= limit; i++) {
					var thishref = albums_grid[i].img,
							thisvideoclass = '';
					what_to_append = what_to_append + '\
						<div class="gallary-02__item loading ' + albums_grid[i].categ + ' ' + albums_grid[i].width + '">\
							<a class="gallary-02__link swipebox" href="' + albums_grid[i].img + '">\
								<img src="' + albums_grid[i].thmb + '" alt="" />\
							</a>\
						</div>\
					';
					already_showed++;
				}
				
				var $newItems = $(what_to_append);
				
				setTimeout(function() {
					grid_container.isotope('insert', $newItems);
					
					// layout Isotope after each image loads:
					grid_container.imagesLoaded().progress(function() {
						grid_container.isotope('layout');
					});  
					
				}, 200);
			}
		});
		
		// Height 100 percent
		if ($('.height_100percent').size() > 0) {
			smart_height100_perc();
		}
		
	});
	
	// Contact form
	if ($('.form-in-wrapp').size() > 0) {
		$("#ajax-contact-form").on('submit', function() {
			var str = $(this).serialize();		
			$.ajax({
				type: "POST",
				url: "contact_form/contact_process.php",
				data: str,
				success: function(msg) {
					// Message Sent - Show the 'Thank You' message and hide the form
					if(msg === 'OK') {
						var result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';
						$("#fields").hide();
					} else {
						var result = msg;
					}
					$('#note').html(result);
				}
			});
			return false;
		});
	}
	
	// Main navigation:
	$('.main-nav__list').superfish({
		hoverClass:    'sfHover',
		delay:         800,
		animation:     {opacity: 'show'},
		animationOut:  {opacity: 'hide'},
		cssArrows:     true
	});
	$('.main-nav__btn').on('click', function () {
		$(this).toggleClass('open');
		if($('.main-nav__list').hasClass('open')) {
			$('.main-nav__list').removeClass('open');
			
		} else {
			$('.main-nav__list').addClass('open');
		}
	});
	
	// Search
	$('.search-btn').on('click', function(){
		$('.search-block__form').toggleClass('active');
	});
	
	// Nivoslider
	if ($('.nivoSlider').size() > 0) {
		$('.nivoSlider').each(function() {
			$(this).nivoSlider({
				directionNav: true,
				controlNav: false,
				effect:'fade',
				pauseTime:4000,
				slices: 1
			});
		});
	}	
	
	// Accordion & Toggle
	if ($('.accordion-01').size() > 0 || $('.module_toggle').size() > 0) {
		$('.accordion-01__title').on('click', function() {
			if (!$(this).hasClass('state-active')) {
				$(this).parents('.accordion-01').find('.accordion-01__body').slideUp(300);
				$(this).next().slideToggle(300);
				$(this).parents('.accordion-01').find('.state-active').removeClass('state-active');
				$(this).addClass('state-active');
			}
		});
		
		$('.accordion-01__title.expanded_yes').each(function(index) {
			$(this).next().slideDown(300);
			$(this).addClass('state-active');
		});
	}
	
	// Services owl carousel
	if ($('.owl-option-01').size() > 0) {
		$('.owl-option-01').owlCarousel({
			loop:true,
			margin: 30,
			responsiveClass:true,
			dots: false,
			nav:true,
			responsive:{
				0:{
					items:1
				},
				767:{
					items:2
				}
			}
		});
	}
	
	// What We Offer
	if ($('.owl-option-03').size() > 0) {
		$('.owl-option-03').owlCarousel({
			loop:true,
			margin:30,
			responsiveClass:true,
			dots: false,
			nav:true,
			autoplay: true,
			responsive:{
				0:{
					items:1
				},
				480:{
					items:1
				},
				640:{
					items:2
				},
				767:{
					items:3
				}
			}
		});
	}
	
	if ($('.owl-option-04').size() > 0) {
		$('.owl-option-04').owlCarousel({
			loop:true,
			margin:30,
			responsiveClass:true,
			dots: false,
			nav:true,
			responsive:{
				0:{
					items:1
				},
				480:{
					items:2
				},
				767:{
					items:3
				},
				1199:{
					items:4
				}
			}
		});
	}
	
	// Skills
	if ($('.shortcode_skills').size() > 0) {
		if ($(window).width() > 760) {
			$('.module_skills').waypoint(function () {
				$('.skill_div').each(function () {
					var set_width = $(this).attr('data-percent');									
					$(this).stop().animate({'width': set_width}, 1500);
				});
			}, {offset: '99.99%'});
		} else {
			$('.skill_div').each(function () {
				$('.skill_div').each(function () {
					var set_width = $(this).attr('data-percent');									
					$(this).stop().animate({'width': set_width}, 1000);
				});
			});
		}
	}
	
	// Tabs
	if ($('.tabs').size() > 0) {
		$('.tabs__caption').on('click', 'li:not(.active)', function() {
			$(this)
				.addClass('active').siblings().removeClass('active')
				.closest('.tabs').find('.tabs__content').removeClass('active').eq($(this).index()).addClass('active');
		});
	}
	
	// Counter
	var counter_module = $('.shortcode_counter');
	if (counter_module.size() > 0) {
		if ($(window).width() > 760) {
			counter_module.each(function() {
				if ($(this).offset().top < $(window).height()) {
					if (!$(this).hasClass('done')) {
						var set_count = $(this).find('.stat_count').attr('data-count');
						$(this).find('.stat_temp').stop().animate({
								width: set_count
						}, {
							duration: 3000,
							step: function(now) {
								var data = Math.floor(now);
								$(this).parents('.counter_wrapper').find('.stat_count').html(data);
							}
						});
						$(this).addClass('done');
						$(this).find('.stat_count');
					}
				} else {
					$(this).waypoint(function() {
						if (!$(this).hasClass('done')) {
							var set_count = $(this).find('.stat_count').attr('data-count');
							$(this).find('.stat_temp').stop().animate({
								width: set_count
							}, {
								duration: 3000,
								step: function(now) {
									var data = Math.floor(now);
									$(this).parents('.counter_wrapper').find('.stat_count').html(data);
								}
							});
							$(this).addClass('done');
							$(this).find('.stat_count');
						}
					}, {
						offset: 'bottom-in-view'
					});
				}
			});
		} else {
			counter_module.each(function() {
				var set_count = $(this).find('.stat_count').attr('data-count');
					$(this).find('.stat_temp').animate({
						width: set_count
					}, {
						duration: 3000,
						step: function(now) {
							var data = Math.floor(now);
							$(this).parents('.counter_wrapper').find('.stat_count').html(data);
						}
					});
				$(this).find('.stat_count');
			}, {
				offset: 'bottom-in-view'
			});
			}
			$('.module_counter').each(function() {
				var counter_icon_color = $(this).find('.counter_content').attr('data-icon-color');
				if (counter_icon_color !== '' && counter_icon_color !== undefined) {
					$(this).find('.counter_ico span').css({
						'color': counter_icon_color
					});
				}
			});
		}
	
	// Coming soon
	if ($('#countdown').size() > 0) {
		var	austDay = new Date(2017, 19 - 1, 3);
		$('#countdown').countdown({
			until: austDay,
			padZeroes: true,
			labels: ['Years', 'Months', 'Weeks', 'Days', 'Hours', 'Minutes', 'Seconds'],
			labels1: ['Year', 'Month', 'Week', 'Day', 'Hour', 'Minute', 'Second']
		});
	}
	
	// Typed
	if ($('.info-box-title').size() > 0) {
		var typed = new Typed('.info-box-title__text', {
			strings: ['Success In Life', 'a Perfect Future', 'a Better Tommorow'],
			typeSpeed: 100,
			backSpeed: 50,
			smartBackspace: true,
			loop: true
		});
	}
	
	// Google maps
	if ($('#map-canvas').size() > 0) {
		function initialize() {
			var styleArray = [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"},{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.attraction","elementType":"all","stylers":[{"visibility":"off"},{"hue":"#ff00ff"},{"lightness":"31"},{"saturation":"100"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"saturation":"-36"},{"color":"#cce3a4"}]},{"featureType":"poi.sports_complex","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","elementType":"geometry","stylers":[{"visibility":"off"},{"color":"#ff0000"}]},{"featureType":"poi.sports_complex","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45},{"visibility":"on"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"labels.icon","stylers":[{"visibility":"on"}]},{"featureType":"transit.station.rail","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"transit.station.rail","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#ffffff"},{"visibility":"on"}]}];
			var myLatlng = new google.maps.LatLng(40.714353, -74.005973);
			var mapOptions = {
				zoom: 15,
				scrollwheel: false,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				styles: styleArray
			};
			var map = new google.maps.Map(doc.getElementById('map-canvas'), mapOptions);
			var marker = new google.maps.Marker({
				position: myLatlng,
				map: map,
				title: 'New York!',
				icon: 'img/map_icon.png'
			});
		}
		google.maps.event.addDomListener(window, 'load', initialize);
	}
	
	// Round circle
	if ($('.progress-circle').size() > 0) {
		if ($(window).width() > 760) {
			$('.progress-circle').waypoint(function () {
				$('.progress-circle').circleProgress({
					size: 155,
					emptyFill: 'transparent',
					thickness: '5',
					fill: { gradient: ["#94c860", "#4da7cc"] }
				}).on('circle-animation-progress', function(event, progress, stepValue) {
					$(this).find('.progress-circle__value').html((stepValue * 100).toFixed().substr(-3) + '<b>%</b>');
				});
			}, {offset: '99.99%'});
		} else {
			$('.progress-circle').circleProgress({
				size: 155,
				emptyFill: 'transparent',
				thickness: '5',
				fill: { gradient: ["#94c860", "#4da7cc"] }
			}).on('circle-animation-progress', function(event, progress, stepValue) {
				$(this).find('.progress-circle__value').html((stepValue * 100).toFixed().substr(-3) + '<b>%</b>');
			});
		}
	};
	
	// Back to Top
	$(window).on('scroll', function () {
		if ($(window).scrollTop() > 0) {
			$('.back2top').fadeIn();
		} else {
			$('.back2top').fadeOut();
		}
		var bottom_pad = parseInt($('.footer_wrapper').height())+parseInt($('.footer_wrapper').attr('data-pad-top'))+parseInt($('.footer_wrapper').attr('data-pad-bottom')) + 30;
		if ($(window).scrollTop() > $(doc).height() - $(window).height() - bottom_pad) {
			$('.back2top').css({'bottom': bottom_pad+'px'});
		} else {
			$('.back2top').css({'bottom': '30px'});
		}
	});
	$('.back2top').on('click', function () {
		$('body,html').animate({
			scrollTop: 0
		}, 400);
		return false;
	});
	
	// Swipebox Popup
	var swipebox_class = $('.swipebox');
	if(swipebox_class.size() > 0) {
		$('html').addClass('smart-box');
		swipebox_class.swipebox();
	}
	
	$(doc).on('click', '#swipebox-container .slide.current img', function (e) {
		$('swipebox-next').trigger('click');
		e.stopPropagation();
	});

	$(doc).on('click', '#swipebox-container', function (e) {
		$('#swipebox-close').trigger('click');
	});
	
})(jQuery);

function smart_content_update() {
	var frame16_10_tag = jQuery('.frame16x10');
	if (frame16_10_tag.size() > 0) {
		smart_iframe16x10(frame16_10_tag);
	}
	var frame16_14_tag = jQuery('.frame16x14');
	if (frame16_14_tag.size() > 0) {
		smart_iframe16x14(frame16_14_tag);
	}
}

// Height 100 percent
function smart_height100_perc() {
	if (jQuery(window).width() < 900) {
		jQuery('.height_100percent').css({'min-height': jQuery(window).height() - jQuery('.main_header').height() - jQuery('.footer').height() - jQuery('#wpadminbar').height() + 'px'});
	} else {
		jQuery('.height_100percent').css({'min-height': jQuery(window).height() - jQuery('.footer').height() - jQuery('#wpadminbar').height() + 'px'});
	}
}
function smart_fw_block() {
	var div_tag = jQuery('div');
	if (div_tag.hasClass('right-sidebar') || div_tag.hasClass('left-sidebar')) {
	} else {
		var fw_block = jQuery('.fw_block');
		var fw_block_parent = fw_block.parent().width();
		var fw_site_width = fw_block.parents('.wrapper').width();
		var fw_contentarea_site_width_diff = fw_site_width - fw_block_parent;

		fw_block.css('margin-left', '-' + fw_contentarea_site_width_diff / 2 + 'px').css('width', fw_site_width + 'px').children('.fw_wrapinner').css('padding-left', fw_contentarea_site_width_diff / 2 + 'px').css('padding-right', fw_contentarea_site_width_diff / 2 + 'px');
		jQuery('.wall_wrap .fw_wrapinner').css('padding-left', '0px').css('padding-right', '0px');
	}
}

// Video background
function smart_video_background() {
	jQuery('.video_bg').each(function () {
		jQuery(this).find('iframe').css({'height': jQuery(this).height() + 'px'});
	});
}
function smart_iframe16x10(frame_class) {
	frame_class.each(function() {
		jQuery(this).height((jQuery(this).width() / 16) * 10.5);
	});
}
function smart_iframe16x14(frame_class) {
	frame_class.each(function() {
		jQuery(this).height((jQuery(this).width() / 16) * 14);
	});
}