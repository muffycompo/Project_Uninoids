/*
	AsyncSlider (Simplified Version)
	Created by: Arlind Nushi
	URL: http://arlindnushi.com/codecanyon/asyncslider/
	
*/
(function($)
{
	$.fn.asyncSlider = function(options)
	{
		var loadAllImages = function(slides, callback)
		{
			var images_array = [];
			var loaded_images = 0;
			
			slides.each(function()
			{
				var slide = $(this);
				
				var img_elements = slide.find('img');
				var div_elements = slide.find('div, a, span');
				
				img_elements.each(function()
				{
					images_array.push($(this).attr('src'));
				});
				
				div_elements.each(function()
				{
					var background_image = $(this).css('background-image');
					
					if(background_image.indexOf('url') >= 0)
					{
						var bg_url = background_image.substr(4, background_image.length - 1);
						bg_url = bg_url.substr(0, bg_url.length - 1);
						bg_url = bg_url.replace(/\"/g, '');
						
						images_array.push(bg_url);
					}
				});
			});
			
			// Remove Duplicate Elements
			images_array = jQuery.unique(images_array);
			
			// Start Loading Images
			for(var i in images_array)
			{
				var image_url = images_array[i];
				
				var image = new Image();
				image.src = image_url;
				image.onload = function()
				{
					loaded_images++;
					
					if(loaded_images == images_array.length)
					{
						if(callback)
							callback();
					}
				}
			}
		};
		
		return this.each(function()
		{
			var defaults = {
				fadeDelay: 800,
				slideItem: '.slide_item',
				prevNextNav: 'after',
				numbersNav: 'after',
				avoidElements: '.container, .columns, .x',
				delaySpan: 40,
				autoswitch: 0,
				props: {
					beforeHide	: {left: 0, opacity: 1},
					onHide		: {left: 50, opacity: 0},
					afterHide	: {left: 0},
					
					beforeShow	: {left: -50, opacity: 0},
					onShow		: {left: 0, opacity: 1},
					afterShow	: {}
				},
				keyboardArrows: true
			};
			
			
			$.extend(defaults, options);
			
			// abbr for options
			var o = defaults;
			
				// Navigations
				var prev_next_nav, numbers_nav;
			
			// Container
			var container = $(this);
				
				// Settings from Data
				if(container.data('autoswitch'))
				{
					defaults.autoswitch = parseInt(container.data('autoswitch'), 10);
				}
			
			// Slides
			var slides = container.find(o.slideItem);
			var total_slides = slides.length;
			
			
			// If there are less than 2 slides, stop this to be executed
			if(total_slides < 2)
				return;
			
			// Slide Options
			slides.addClass('clearfix');

			
			// Hide All Slides (only first show or current one)
			slides.hide();
			var current_slide = slides.filter('[data-current]');
			
			if(current_slide.length == 0)
			{
				current_slide = slides.first();
			}
			
			current_slide.show();
			
			
			
			// Setup Slider Function
			var setupSlider = function()
			{
				setSlideSettings();
				
				// Initialize Navigations
				
					// Prev Next Navigation
					if(o.prevNextNav)
					{
						prev_next_nav = $('<div class="slider_nextprev_nav" />');
						
						var prev = $('<a href="#" class="prev">Previous</a>');
						var next = $('<a href="#" class="next">Next</a>');
						
						prev.data('asyncslider-direction', -1);
						next.data('asyncslider-direction', 1);
						
						prev_next_nav.append(prev).append(next);
						
						// Setup Click Event
						prev.add(next).click(function(ev)
						{
							ev.preventDefault();
							var direction = $(this).data('asyncslider-direction');
							
							window.clearInterval(as_interval);
							as_interval = null;
							
							if(direction < 0)
								prevSlide();
							else
								nextSlide();
						});
						
						if(o.prevNextNav == 'after' || o.prevNextNav == 'before')
							container[o.prevNextNav](prev_next_nav);
						else
							$(o.prevNextNav).append(prev_next_nav);
					}
					
					// Numbers Navigation
					if(o.numbersNav)
					{
						numbers_nav = $('<ul class="slider_nav">');
						
						slides.each(function(i)
						{
							var slide_num_li = $('<li />');
							var slide_num_a = $('<a href="#">'+(i+1)+'</a>');
							
							slide_num_a.data('asyncslider-slideid', i);
							
							slide_num_li.append(slide_num_a);
							
							// Setup Click Event
							slide_num_a.on('click', function(ev)
							{
								ev.preventDefault();
								var slide_num = slide_num_a.data('asyncslider-slideid');
								
								switchSlide(slide_num);
							});
							
							numbers_nav.append(slide_num_li);
						});
						
						if(o.numbersNav == 'after' || o.numbersNav == 'before')
							container[o.numbersNav](numbers_nav);
						else
							$(o.numbersNav).append(numbers_nav);
					}
					
				
				// Set Active Slide Number
				var current_slide_id = getSlideID(current_slide);
				setActiveNavItem(current_slide_id);
				container.data('asyncslider-currentslide', current_slide_id);
				
				// Switch Slide
				switchSlide(current_slide_id, null, true);
				
				
				// Keyboard Arrows Assign
				if(o.keyboardArrows)
				{
					$(window).keyup(function(ev)
					{
						if(ev.keyCode == 37) // Prev
							prevSlide();
						else
						if(ev.keyCode == 39) // Next
							nextSlide();
					});
				}
				
				// Auto Switcher
				if(o.autoswitch)
				{
					autoSwitch(o.autoswitch);
				}
			}
			
			
			// Switch Slide
			var switchSlide = function(slide_id, options, no_animation)
			{
				// In case when slider is busy, hold on
				if( ! no_animation && container.data('asyncslider-isbusy') == true)
					return false;
				else
				// Prevent same slide to be animated again
				if(container.data('asyncslider-currentslide') == slide_id && ! no_animation)
					return false;
				
				
				var slide_to_hide_id = container.data('asyncslider-currentslide');
				
				var slide_to_show = getSlide(slide_id);
				var slide_to_hide = getSlide(slide_to_hide_id);
				
				var slide_to_show_height = getSlideHeight(slide_to_show);
				var slide_to_hide_height = getSlideHeight(slide_to_hide);

				// No Animation
				if(no_animation)
				{
					var old_height = container.height();
					container.height(old_height);
				
					//slide_to_show.show();
					//slide_to_hide.hide();
					return;
				}
				
				// Set Busy
				container.data('asyncslider-isbusy', true);
				
				
				// Offsets
				var sts_top = slide_to_show.offset().top;
				var sth_top = slide_to_hide.offset().top;
				
				var slide_to_hide_current_position = slide_to_hide.css('position');
				
				slide_to_hide.css({position: 'absolute', top: 0});
				slide_to_show.show();
				
				
				// Generate Container Height
				var old_height = container.height();
				container.height("auto");
				var new_height = container.height();
				container.height(old_height);
				
				container.animate({ height: new_height });
				// End: Generate Container Height
				
				
				
				//container.animate({height: generateContainerHeight(slide_to_show_height, slide_to_show)});
				
				
				// Slide Elements
				var slide_to_show_elements = getSlideElements(slide_id);
				var slide_to_hide_elements = getSlideElements(slide_to_hide_id);
				
				
				// Determine Natural Direction
				var _direction = slide_to_hide_id < slide_id ? 1 : -1; // Right - Left
				
				// Start Hidding
				slide_to_hide_elements.each(function(i)
				{
					var element = $(this);
					var delay = i * o.delaySpan;
					
					var set_position = 'absolute';
					var current_position = element.css('position');
					
					if(current_position != set_position)
						set_position = 'relative';
					
					var before_hide = o.props.beforeHide;
					var on_hide = o.props.onHide;
					var after_hide = o.props.afterHide;
					
					var pre_beforeHide = {position: set_position};
					
					var pre_onHide = {
						delay: i * o.delaySpan, 
						left: _direction * on_hide.left
					};
					
					var pre_afterHide = {position: current_position};
					
					$.extend(before_hide, pre_beforeHide);
					$.extend(on_hide, pre_onHide);
					$.extend(after_hide, pre_afterHide);
					
					element.css(before_hide).transit(on_hide, o.fadeDelay, function()
					{
						// After Finish Reset Element
						element.css(after_hide);
					});
				});
				
				var delay_to_show_elements = o.fadeDelay;// + (o.delaySpan * (slide_to_hide_elements.length - 1));
				
				// Start Showing
				slide_to_show_elements.css({opacity: 0});
				
				slide_to_show_elements.delay(delay_to_show_elements).each(function(i)
				{
					var element = $(this);
					var delay = i * o.delaySpan;
					
					var set_position = 'absolute';
					var current_position = element.css('position');
					
					if(current_position != set_position)
						set_position = 'relative';
					
					// Prop					
					var before_show = o.props.beforeShow;
					var on_show = o.props.onShow;
					var after_show = o.props.afterShow;
					
					var pre_beforeShow = {
						position: set_position,
						left: _direction * before_show.left
					};
					
					var pre_onShow = {
						delay: i * o.delaySpan
					};
					
					var pre_afterShow = {
						position: set_position
					};
					
					$.extend(before_show, pre_beforeShow);
					$.extend(on_show, pre_onShow);
					$.extend(after_show, pre_afterShow);
					
					element.css(pre_beforeShow).transit(on_show, o.fadeDelay, function()
					{
						element.css(after_show);
					});
				});
				
				// Animation Finished
				setTimeout(function()
				{
					slide_to_hide.css({
						position: slide_to_hide_current_position
					}).hide();
					
					// Set Status Ready
					container.data('asyncslider-isbusy', false);
					container.data('asyncslider-currentslide', slide_id);
					
				}, delay_to_show_elements * 2);
				
				setActiveNavItem(slide_id);
				
				return true;
			};
			
			
			// Setup Slider Height
			var setSlideSettings = function()
			{
				slides.each(function(i)
				{
					var slide = $(this);
					
					// Show This Slide and Get height
					slides.hide();
					slide.show();
					
					// Get Height and Hide It
					var height = slide.outerHeight();
					slide.hide();
					
					// Get Elements
					var slide_elements = slide.find('*').not(o.avoidElements);
					
					slide.data('asyncslider-slideid', i);
					slide.data('asyncslider-slide', slide);
					slide.data('asyncslider-elements', slide_elements);
					slide.data('asyncslider-height', height);
				});
				
				current_slide.show();
			};
			
			var getSlideHeight = function(slide)
			{
				return slide.data('asyncslider-height');
			};
			
			var getSlideID = function(slide)
			{
				return slide.data('asyncslider-slideid');
			};
			
			var getSlide = function(id)
			{
				var slide = $( slides.get(id % slides.length) );
				
				return slide;
			};
			
			var getSlideElements = function(slide_id)
			{
				var slide = getSlide(slide_id);
				
				return slide.data('asyncslider-elements');
			};
			
			var setActiveNavItem = function(slide_id)
			{
				if(o.numbersNav)
				{
					var number_item = $(numbers_nav.find('li').get(slide_id));
					
					numbers_nav.find('li').removeClass('active');
					number_item.addClass('active');
				}
			};
			
			var nextSlide = function()
			{
				var current_slide_id = container.data('asyncslider-currentslide');
				var total_slides = slides.length;
				
				var next_slide_id = (current_slide_id + 1) % total_slides;
				
				switchSlide(next_slide_id);
			};
			
			var prevSlide = function()
			{
				var current_slide_id = container.data('asyncslider-currentslide');
				var total_slides = slides.length;
				
				var prev_slide_id = current_slide_id - 1;
				
				if(prev_slide_id)
					prev_slide_id = total_slides - 1;
				
				switchSlide(prev_slide_id);
			}
			

			
			// Auto Switcher
			var as_interval = null;
				
			var stopAutoSwitch = function()
			{
				window.clearInterval(as_interval);
				as_interval = null;
			};
			
			var startAutoSwitch = function(timeout)
			{
				
				as_interval = setInterval(function()
				{
					nextSlide();
				}, timeout);
			};
			
			var autoSwitch = function(timeout)
			{
				startAutoSwitch(timeout);
				
				container
				.on('mouseenter', function()
				{
					stopAutoSwitch();
				})
				.on('mouseleave', function()
				{
					startAutoSwitch(timeout);
				});
			};
			
			
			// Before setup the slider, load all images
			loadAllImages(slides, setupSlider);
		});
	}
	
})(jQuery);