// This is main JavaScript file to be used with Crystal Theme
// Developed by Arlind Nushi
var _clearer = null;

// Main Menu
var main_menu, 
	main_menu_items, 
	active_marker, 
	active_item, 
	am_motion_duration, 
	am_easing_type;

jQuery(function($)
{
	_clearer = $('<div />').addClass('clear');
		
	$(".site_footer .photostream, .post_entry .post_block .post_details, .module_content, .tab_content, .post_meta, .blog_post_comments, .portfolio_item .item_meta").append(_clearer.clone());
	
	$(".cblock").each(function()
	{
		var cblock = $(this);
		
		cblock.before(_clearer.clone());
		cblock.append(_clearer.clone());
	});
	
	$(".pagination").before(_clearer.clone());
	
	
	// Like Hover
	var show_liked_duration = 200;
	var show_liked_margin = 8;
	
	$(".portfolio_item .item_meta a.liked").each(function()
	{
		var $this = $(this);
		var liked_markup = $('<div class="already_liked"><i></i>You liked this</div>');
		
		$this.append(liked_markup);
		
		liked_markup.css({marginTop: show_liked_margin});
		
		$this.on('mouseenter', function()
		{
			if( ! liked_markup.is(':visible'))
				liked_markup.fadeTo(0,0);
				
			liked_markup.stop().animate({opacity: 1, marginTop: 0}, show_liked_duration);
		});
		
		$this.on('mouseleave', function()
		{
			liked_markup.stop().animate({opacity: 0, marginTop: show_liked_margin}, show_liked_duration, function()
			{
				liked_markup.hide();
			});
			
		});
		
		$this.each
	});
	
	
	// Social Media Links
	var social_move = -5, social_opacity = 0.5, social_duration = 120, social_easing = 'easeInOutQuad';
	
	$(".site_header .top_social li").fadeTo(0, social_opacity).each(function()
	{
		var $this = $(this);
		
		$this.css({
			position: 'relative'
		});
		
		$this.on('mouseenter', function()
		{
			$this.stop().animate({top: social_move, opacity: 1}, {duration: social_duration, easing: social_easing})
		});
		
		$this.on('mouseleave', function()
		{
			$this.stop().animate({top: 0, opacity: social_opacity}, {duration: social_duration, easing: social_easing})
		});
	});
	
	
	
	
	
	// Tweets (Footer)
	var _show_tweets	= 2; // Tweets per row
	var _tweet_timeout	= 5; // Seconds to switch tweets
	
	var tweets = $(".site_footer .tweets");
	
	if(tweets.data('tweets'))
		_show_tweets = parseInt(tweets.data('tweets'), 10);
		
	if(tweets.data('timeout'))
		_tweet_timeout = parseInt(tweets.data('timeout'), 10);
	
	var tweets_ch = tweets.children();
	
	tweets_ch.hide().slice(0, _show_tweets).show();
	
	var _tw_options = {
		container: tweets, 
		tweets: tweets_ch, 
		tweets_per_page: _show_tweets,
		timeout: _tweet_timeout * 1000,
		pause_on_hover: true
	};
	
	var tweet_roller = new tweetRoller(_tw_options);
	tweet_roller.start();
	
	
	
	// Back to Top
	$("a.back_to_top").on('click', function(ev)
	{
		ev.preventDefault();
		
		$("html,body").animate({scrollTop: 0}, {duration: 800, easing: 'easeInOutQuad'});
	});
	
	
	// Clearer for Top
	$(".site_header .bar_top .container").append(_clearer);
	
	
	// Mark Expanded UL items
	$(".cblock ul:not(.bullet) li").each(function()
	{
		var $this = $(this);
		var has_sub_lists = $this.find('ul, ol').length;
		
		if(has_sub_lists > 0 )
		{
			$this.addClass('expanded');
		}
	});
	
	
	
	// Alert Messages
	var hide = $('<a />');
	hide.addClass('hide').attr('href', '#');
	
	$(".alert").each(function()
	{
		var $this = $(this);
		
		var _hide = hide.clone();
		
		$this.prepend(_hide);
		
		_hide.on('click', function(ev)
		{
			ev.preventDefault();
			
			$this.slideUp('medium');
		});
	});
	
	
	// Main Menu Active Marker
	am_motion_duration = 450; // ms
	am_easing_type = 'easeOutBack';
	
	main_menu = $(".main_menu");
	main_menu_items = main_menu.find('> li');
	active_marker = $('<div />').addClass('active_marker');
	active_item = main_menu.find('> li.active');
		
	main_menu.append(active_marker);
	
	setTimeout(function()
	{
		setupMainMenu();
		
	}, 200);
	
	
	// Outer Title Markup
	var outer_title_table = $('<table />');
	outer_title_table.addClass('outer_title_table').attr('width', '100%');
	
	var otb_row = $('<tr />');
	
	var left_border = $('<td />').addClass('left_border');
	var text_env = $('<td />').addClass('text_env');
	var right_border = $('<td />').addClass('right_border');
	
	otb_row.append(left_border).append(text_env).append(right_border);
	outer_title_table.append(otb_row);
	
	
	$("h1.title, h2.title, h3.title, h4.title").each(function()
	{
		var $this = $(this);
		var tag_name = $this.get(0).tagName;
		
		var html = $this.html().toString();
		var heading = $('<'+tag_name+' />').html(html);
		
		var table_ins = outer_title_table.clone();
		
		$this.after(table_ins).detach();
		
		table_ins.find('.text_env').html(heading);
		
	});
});


function setupMainMenu(animate_new_position)
{
	// Register Positions
	var mpos_left = 0;
	var marker_extra_width = 20;
	var mew_half = parseInt(marker_extra_width/2, 10);
	
	var zindexer = 35;
	
	main_menu_items.each(function()
	{
		var $this = $(this);
		var a_href = $this.find('> a');
				
		var sub_menu = $this.find('> ul');
		var has_sub = sub_menu.length > 0;
		
		if(has_sub)
		{
			a_href.addClass('has_sub');
			$this.data('disable_animation', 1);
					
			// Show Menu Sub
			$this.on('mouseenter', function()
			{
				$this.css({zIndex: zindexer});
				sub_menu.stop().css({zIndex: zindexer}).fadeTo(300, 1);
				zindexer++
			});
			
			$this.on('mouseleave', function()
			{	
				$this.css({zIndex: 25});
				
				sub_menu.stop().css({zIndex: 10}).fadeTo(300, 0, function()
				{
					sub_menu.hide();
				});
			});
			
			var third_level_sub = sub_menu.find('ul');
			
			if(third_level_sub.length > 0)
			{
				third_level_sub.hide();
				
				third_level_sub.parent().on('mouseenter', function()
				{
					third_level_sub.stop().css({zIndex: 11}).fadeTo(300, 1);
				});
				
				third_level_sub.parent().on('mouseleave', function()
				{
					third_level_sub.stop().css({zIndex: 10}).fadeTo(300, 0, function()
					{
						third_level_sub.hide();
					});
				});
			}
		}
		
		var width = $this.width();
		var left_margin = parseInt($this.css('margin-left'), 10);
		
		
		var marker_padding_left = parseInt(active_marker.css('padding-left'), 10);
		var marker_padding_right = parseInt(active_marker.css('padding-right'), 10);
		
		var marker_minus_padding = parseInt((marker_padding_left+marker_padding_right)/2, 10);
		
		
		var to_the_right = mpos_left + left_margin - mew_half;
				
		
		$this.data('left', to_the_right);
		$this.data('width', width + marker_extra_width);
		
		mpos_left += $this.outerWidth() + left_margin;
		
		// Bind Events
		var _width = $this.data('width');
		var _left = $this.data('left');
		
		var def_width = active_item.data('width');
		var def_left = active_item.data('left');
		
		$this.on('hover', function()
		{
			//if($this.data('disable_animation')) return;
			
			active_marker.stop().animate({left: _left, width: _width}, {duration: am_motion_duration, easing: am_easing_type});
		});
		
		main_menu.on('mouseleave', function()
		{
			active_marker.stop().animate({left: def_left, width: def_width}, {duration: am_motion_duration, easing: am_easing_type});
		});
	});
	
	
	// Fluid Active Menu Item Marker (Setup)
	if(active_item.length > 0)
	{		
		var def_width = active_item.data('width');
		var def_left = active_item.data('left');
		
		if(animate_new_position)
		{
			active_marker.animate({left: def_left, width: def_width}, {duration: am_motion_duration, easing: am_easing_type});
		}
		else
		{
			active_marker.css({left: def_left, width: def_width}).show();
		}
	}
	
	
}




/* Tweet Roller plugin by Arlind Nushi */
var tweetRoller = function(_options)
{
	var self = this;
	
	var options = {
		container: null,
		tweets: null,
		tweets_per_page: 2,
		timeout: 0,
		pause_on_hover: true,
		show_hide_speed: 500
	};
	
	$.extend(options, _options);
	
	// Define Variables
	var container = options.container;
	var tweets = options.tweets;
	var tweets_per_page = options.tweets_per_page;
	var timeout = options.timeout;
	var pause_on_hover = options.pause_on_hover;
	var show_hide_speed = options.show_hide_speed;
	
	var interval = null;
	
	container.css({
		position: 'relative'
	});
	
	// Class Variables
	this.index = 0;
	this.total = tweets.length;
	
	var move_px = 15;
	
	return {
		next: function()
		{
			var indexes = this.get_indexes();
			
			var to_hide = tweets.slice(indexes[0], indexes[1]);
			
			this.next_index();
			
			indexes = this.get_indexes();
			var to_show = tweets.slice(indexes[0], indexes[1]);
			
			to_hide.stop().css({position: 'relative'}).animate({top: move_px, opacity: 0}, {
				duration: show_hide_speed,
				complete: function()
				{
					to_hide.css({top: 0}).hide();
					
					to_show.fadeTo(0,0);
					
					to_show.stop().css({
						top: move_px,
						position: 'relative'
					}).animate({
						top: 0,
						opacity: 1
					}, {
						duration: show_hide_speed
					});
				}
			});
		},
		
		get_indexes: function()
		{
			var index_1 = self.index;
			var index_2 = self.index + tweets_per_page;
			index_2 %= self.total;
			
			if(index_2 < index_1)
			{
				var diff = index_1 - index_2 - tweets_per_page;
				
				index_1 -= index_2 - diff;
				index_2 = index_1 + tweets_per_page;
			}
			
			return [index_1, index_2];
		},
		
		next_index: function()
		{
			self.index += tweets_per_page;
			self.index = self.index % self.total;
		},
		
		start: function()
		{
			var _self = this;
			
			// Auto Scroller
			if(timeout > 0)
			{
				var auto_scroller = function()
				{
					_self.next();
				};
				
				interval = setInterval(auto_scroller, timeout);
				
				// Pause on Hove
				if(pause_on_hover)
				{
					container.hover(function()
					{
						window.clearInterval(interval);
						interval = null;
					},
					function()
					{
						interval = setInterval(auto_scroller, timeout);
					});
				}
			}
		}
	};
}



// Portfolio Items Sorting
var portfolio_items;

jQuery(document).ready(function($)
{
	/* Portfolio Sortable */
	
		// Isotope-Masonry
		portfolio_items = $('.portfolio_sortable');
		
		portfolio_items.find('.portfolio_item').each(function()
		{
			var $this = $(this);
			var _filter = $this.data('filter');
			$this.addClass(_filter);
			
			$this.hover(function(){
				$this.css({zIndex: 5});
			},
			function(){
				$this.css({zIndex: 4});
			});
		});
		
		if( ! $.isFunction(portfolio_items.imagesLoaded))
			return;
			
		portfolio_items.imagesLoaded(function()
		{
			//portfolio_items.css({marginRight: 0, marginLeft: 0}).fadeTo(0,0.5);

			portfolio_items.isotope({
				masonry: 
				{
					itemSelector: '.portfolio_item',
					gutterWidth: 40,
					columnWidth: 1/4
				},
				animationOptions: {
					duration: 750,
					easing: 'linear',
					queue: false
				}
			});
			
			if($.browser.mozilla)
			{
				portfolio_items.css('position', 'static');
			}
			
			// Infinite Scroll Setup
			var portfolio_more_results = $(".portfolio_more_results");
			var next_page = portfolio_more_results.find('> a');
			
			if(portfolio_more_results.size() == 1)
			{
				portfolio_items.infinitescroll({
					navSelector: portfolio_more_results,
					nextSelector: next_page,
					itemSelector: '.portfolio_item',
					loadingImg: '',
					bufferPx: 5,
					loading: {
						selector: $(".portfolio_loading"),
						msgText: 'Loading items…',
						finishedMsg: 'There are no more items to load.',
						img: 'images/loader.gif'
						
					}
				}, 
				function(newElements)
				{
					var new_items = $(newElements);
					
					// Assign Filter Classes
					new_items.each(function()
					{
						var $this = $(this);
						var _filter = $this.data('filter');
						$this.addClass(_filter);
					});
					
					new_items
						.hoverZoom({overlayColor: '#000', overlayOpacity: 0.3})
						.css({opacity: 0})
						.imagesLoaded(function()
						{
							portfolio_items.isotope('appended', new_items, function()
							{
								new_items.find('.zoom').prettyPhoto({social_tools: ''});
							});
														
							var infscr = portfolio_items.data('infinitescroll');
							portfolio_more_results.show();
						});
				});
				
				var loading_type = portfolio_items.data('automatic-loading');
				
				if(loading_type == 'false' || loading_type == '0' || loading_type == 'no')
				{
					// Unbind Automatic Pagination
					$(window).unbind('.infscr');
					
					
					var infscr = portfolio_items.data('infinitescroll');
					
						//infscr.retrieve();
					next_page.click(function(ev)
					{
						ev.preventDefault();
						infscr.retrieve();
						//infscr.retrieve();
					});
				}
			}
		});
});



// Accordion
jQuery(document).ready(function($)
{
	var accordion_env = $(".accordion");
	
	if($.isFunction(accordion_env.accordion))
	{
		accordion_env.accordion({
		});
	}
});



// WideSlider
jQuery(document).ready(function($)
{
	var wideslider_env = $(".wideslider ul");
	
	if($.isFunction(wideslider_env.wideslider))
	{
		wideslider_env.wideslider({
			delay: 800,
			nextPrev: $(".wideslider_nextprev"),
			prevNextOnKeyboard: true
		});
	}
});



// Responsive Slider
jQuery(document).ready(function($)
{
	var portfolio_slider = $(".portfolio_slider");
	
	if($.isFunction(portfolio_slider.responsiveSlides))
	{
		portfolio_slider.imagesLoaded(function(){
		
			portfolio_slider.responsiveSlides({
				nav: true,
				pause: true,
				timeout: 5000,
				controls: portfolio_slider
			});
			
			
		});
	}
});


// Select Box
jQuery(document).ready(function($)
{
	var opts = {
		classHolder: 'selectbox_env',
		classToggle: 'select_toggle',
		classSelector: 'select_open',
		classToggleOpen: 'select_is_opened',
		classOptions: 'select_options'
	};
	
	$("select.selectbox").each(function()
	{
		var $this = $(this);
		
		if($this.attr('id') == 'portfolio_filter')
		{
			opts.onChange = function(value)
			{
				var _filt = '.' + value;
				if(_filt == '.*')
					_filt = '*';
					
				portfolio_items.isotope({filter: _filt});
				isotopeFix();
				$this.parent().css({position: 'relative', zIndex: 50})
			}
		}
		
		$this.selectbox(opts);
	});
	
	
});


// Partners Carousel
jQuery(document).ready(function($)
{
	var partners_carousel = $(".partners_carousel");
	
	if($.isFunction(partners_carousel.anCarousel))
	{
		partners_carousel.anCarousel({
	        itemsPerRow: 5,
	        autoSlide: 3000,
	        pauseOnHover: true
	    });
	    
	    partnersCarouselFit();
    }
});

function partnersCarouselFit()
{
	var partners_carousel_instance = $(".partners_carousel").data('ancarouselinstance');;
	
	if(typeof partners_carousel_instance != 'undefined')
	{
		switch(test_device_type())
		{
			case "large_screen":
				partners_carousel_instance.updateItemsPerRowNumber(5);
				break;
				
			case "ipad":
				partners_carousel_instance.updateItemsPerRowNumber(4);
				break;
				
			case "iphone_landscape":
			case "iphone":
				partners_carousel_instance.updateItemsPerRowNumber(2);
				break;
		}
	}
}


// Apply Hover Zoom
jQuery(document).ready(function($)
{
	var elements = $('.zoom');
	elements.hoverZoom({overlayColor: '#000', overlayOpacity: 0.3});
	
	// Add Pretty Photo
	var pp_opts = {social_tools: ''};
	
	if($.isFunction(elements.prettyPhoto))
	{
		elements.prettyPhoto(pp_opts);
	}
});


// Features Tabs
jQuery(document).ready(function($)
{
	var features_tabs = $('.features_tabs');
	
	
	if($.isFunction(features_tabs.featuresTabs))
	{
		features_tabs.featuresTabs();
		features_tabs.wrap($('<div class="large_screen_only" />'));
	}
});

// AsynsSlider
jQuery(document).ready(function($)
{
	var asyncslider = $('.asyncslider');
	
	if($.isFunction(asyncslider.asyncSlider))
	{
		asyncslider.asyncSlider({
			prevNextNav: '.asyncslider .container',
			numbersNav: '.asyncslider .container'
		});
	}
});


// Staf Members
jQuery(function($)
{
	var staff_members = $(".staff_members .staf_member");
	
	if( ! $.isFunction(staff_members.imagesLoaded))
		return;

	staff_members.imagesLoaded(function()
	{
		staff_members.each(function()
		{
			var $this = $(this);
			
			var image = $this.find('.image');
			var connect = image.find('.connect');
			
			var padding_left = parseInt(image.css('padding-left'), 10);
			var padding_right = parseInt(image.css('padding-right'), 10);
			
			var padding_top = parseInt(image.css('padding-top'), 10);
			var padding_bottom = parseInt(image.css('padding-bottom'), 10);
			
			var hover_overlay = $('<div class="hover_overlay" />');
			
			hover_overlay.height(image.height() + padding_top + padding_bottom);
			
			image.append(hover_overlay);
			
			var ho_width = hover_overlay.width();
			var ho_height = hover_overlay.height();
			
			
			// Image Overlay Hidden CSS
			var ho_outer_height = ho_height + padding_top + padding_bottom;
			var ho_hide = {marginTop: -ho_outer_height};
			var ho_show = {marginTop: 0};
			
			var c_hide = {opacity: 0};
			var c_show = {opacity: 1};
			
			
			hover_overlay.css(ho_hide);
			connect.show().css(c_hide);
			
			image.hover(function()
			{
				hover_overlay.stop().animate(ho_show, {duration: 300, easing: 'easeOutExpo'});
				connect.stop().animate(c_show, {duration: 300, easing: 'easeInOutSine'});
			},
			function()
			{
				hover_overlay.stop().animate(ho_hide, {duration: 450, easing: 'easeOutExpo'});
				connect.stop().animate(c_hide, {duration: 150, easing: 'easeInOutSine'});
			});
			
			// Center .Connect
			connect.show().css({
				left: '50%',
				top: '50%',
				marginLeft: -parseInt(connect.width()/2, 10),
				marginTop: -parseInt(connect.height()/2, 10)
			});
			
			
		});
	});
});



// Featured Posts
jQuery(function($)
{
	$(".featured_post").addClass('clearfix');
	
	$(".tab_content").each(function()
	{
		$(this).find('.featured_post').last().addClass('last');
	});
	
	
	// Sidebar Tabs
	$(".tabs").each(function()
	{
		var $this = $(this);
		
		var tabs_titles = $this.find('.tabbed a');
		
		var tabbed = tabs_titles.parent();
		
		if(tabs_titles.size() == 2)
			tabbed.addClass('duo');
		
		if(tabs_titles.size() == 3)
			tabbed.addClass('treo');
		
		
		var tab_contents = $this.find('.tab_content');
		
		tab_contents.each(function()
		{
			var height = $(this).height();
			
			$(this).attr('data-height', height);
		});
		
		tabs_titles.click(function(ev)
		{
			ev.preventDefault();
			
			var id = $(this).attr('href');
			
			if($(this).hasClass('active'))
				return false;
			
			tabs_titles.removeClass('active');
			$(this).addClass('active');
			
			// To Hide
			var to_hide = tab_contents.filter(':visible');
			var to_show = tab_contents.filter(id);
			
			var to_show_height = parseInt(to_show.attr('data-height'), 10);
			
			to_hide.css({position: 'relative', zIndex: 9, overflow: 'hidden'}).stop().animate({height: 0, opacity: 0});
			to_show.show().css({position: 'relative', zIndex: 10, overflow: 'hidden', height: 0, opacity: 0}).stop().animate({height: to_show_height, opacity: 1});
		});
		
		tab_contents.hide();
		
		var active_tab = tabs_titles.filter('[class="active"]').attr('href');
		tab_contents.filter(active_tab).show();
		
	});
});



// Testimonials
jQuery(function($)
{
	var duration = 200;
	
	var testimonials = $("ul.testimonials, ul.home_testimonials");
	
	var testimonials_elements = testimonials.find('> li');
	var testimonials_nav = $('<div class="testimonials" />');
	
	if(testimonials_elements.length > 1)
	{
		testimonials_elements.hide();
		
		var prev = $('<a href="#" class="prev"></a>');
		var next = $('<a href="#" class="next"></a>');
		
		prev.data('direction', -1);
		next.data('direction', 1);
		
		var author = $('<div class="author" />');
		
		testimonials.data('total_elements', testimonials_elements.length);
		testimonials.data('current_index', 0);
		
		testimonials.after(testimonials_nav);
		
		testimonials_nav.append(prev).append(next).append(author).append(_clearer.clone());
		
		function testimonialsShowIndex(index, no_animation)
		{
			var to_hide = testimonials_elements.filter(':visible');
			var element = $(testimonials_elements.get(index));
			
			var _author = element.data('author');
			
			if(to_hide.size() == 0)
			{
				to_hide = element;
			}
			
			if( ! no_animation)
			{
				to_hide.stop().fadeTo(duration, 0, function()
				{
					to_hide.hide();
					element.stop().fadeTo(duration, 1);
					author.hide().text(_author).fadeTo(duration, 1);
				});
			}
			else
			{
				to_hide.hide();
				element.add(author.text(_author)).show();
			}
		}
		
		testimonialsShowIndex(0, true);
		
		
		// Get Next Index
		function getNextIndex()
		{
			var total_elements = testimonials.data('total_elements');
			var current_index = testimonials.data('current_index');
			
			var index = current_index + 1;
			index = index % total_elements;
			
			return index;
		}
		
		// Nav Setup
		prev.add(next).on('click', function(ev)
		{
			ev.preventDefault();
			var $this = $(this);
			
			// Stop Autoswitcher
			window.clearInterval(t_interval);
			t_interval = null;
			
			var direction = $this.data('direction')			
			var total_elements = testimonials.data('total_elements');
			var current_index = testimonials.data('current_index');
			
			var index = current_index + direction;
			
			if(index < 0)
				index = total_elements - 1;
			
			index = index % total_elements;
			
			testimonials.data('current_index', index);
			
			testimonialsShowIndex(index);
		});
		
		// AutoSwitch
		var t_interval;
		
		var autoswitch = testimonials.data('autoswitch');
		var timeout = testimonials.data('timeout');
		
		if(autoswitch == '1' || autoswitch == 'true')
		{
			t_interval = setInterval(function()
			{
				var next_index = getNextIndex();
				testimonialsShowIndex(next_index);
				testimonials.data('current_index', next_index);
				
			}, parseFloat(timeout, 10) * 1000);
		}
	}
});

// Photostream on Footer
jQuery(function($)
{
	var photostream = $(".photostream");
	
	setupPhotoStream(photostream, 6);
});

function setupPhotoStream(photostream_env, images_per_tab)
{
	if( ! images_per_tab)
		images_per_tab = 6;
	
	var images = photostream_env.find('a img');
	var images_count = images.length;
	
	// Setup Data
	photostream_env.data('images_per_tab', images_per_tab).data('current_tab', 1);
	
	
	if(images_count > images_per_tab)
	{
		var total_tabs = Math.ceil(images_count / images_per_tab);
		var first_tab = images.slice(0, images_per_tab);
		
		images.parent().hide();
		first_tab.parent().show();
		
		var tabs = $('<div class="photostream_tabs" />');
		
		
		for(var i=1; i<=total_tabs; i++)
		{
			var tab = $('<a href="#">'+i+'</a>');
			tab.data('index', i);
			
			if(i == 1)
				tab.addClass('active');
			
			tab.on('click', function(ev)
			{
				ev.preventDefault();
				var _tab = $(this);
				
				switchPhotostreamTab(photostream_env, _tab);
			});
			
			tabs.append(tab);
		}
		
		photostream_env.append(tabs);
		tabs.before('<div class="clear" />');
	}
}

function switchPhotostreamTab(photostream_env, tab)
{
	var _timeout = 80;
	var _delay = 500;
	
	var tabs = photostream_env.find('.photostream_tabs a');
	var index = tab.data('index');
	
	tabs.removeClass('active');
	tab.addClass('active');
	
	
	// Photostream
	var ps_images_per_tab = photostream_env.data('images_per_tab');
	var ps_current_tab = photostream_env.data('current_tab');
	
	var images = photostream_env.find('a img');
	
	// To Hide
	var to_hide_offset = (ps_current_tab - 1) * ps_images_per_tab;
	var to_hide_limit = to_hide_offset + ps_images_per_tab;
	
	var to_hide = images.slice(to_hide_offset, to_hide_limit);
	
	// To Show
	var to_show_offset = (index - 1) * ps_images_per_tab;
	var to_show_limit = to_show_offset + ps_images_per_tab;
	
	var to_show = images.slice(to_show_offset, to_show_limit);
	
	to_hide.parent().hide();
	to_show.parent().fadeIn(_delay);
	
	
	photostream_env.data('current_tab', index);
}