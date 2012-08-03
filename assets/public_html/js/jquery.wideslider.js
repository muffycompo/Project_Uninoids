(function($, window, undefined)
{
	
	var body = $("body");
	var win = $(window);
	var doc = $(document);
	
	
	$.fn.wideslider = function(options)
	{
		var o = {
			delay: 1000,
			autoSwitch: 0,
			onFinish: function(){},
			prevNextOnKeyboard: false
		};
		
		$.extend(o, options);
		
		this.each(function()
		{
			var self = this;
			
			var $container = $(this);
			
			
			// Per container options
			var pco = {
				items: null,
				images_container: null,
				images: null,
				
				// Index
				index: 0,
				total_items: 0,
				last_slide: $(null),
				
				// Next Prev Nav
				next: $(null),
				prev: $(null),
				
				// Slide Options
				inactiveIndex: 1,
				activeIndex: 2
			};
			
			// Images Container
			pco.images_container = $('<div class="ws_images_container" />');
			
			// Get Items
			pco.items = $container.children();
			pco.total_items = pco.items.size();
			
				
			
			// Get Item Images
			pco.items.each(function(i)
			{
				var $item = $(this);
				
				var image = $item.find('> img:first');
				
				$item.data('itemImage', image);
				image.detach();
				
				image.data('itemEl', $item);
				
				$item.data('index', i);
				image.data('index', i);
				
				pco.images_container.append(image);
			});
			
			// Initialize pco.images
			pco.images = pco.images_container.find('img');
			
			// Append to the document
			body.prepend(pco.images_container);
			
			// Hide Items
			pco.items.hide();
			
			
			/* FUNCTIONS */
			
				// Get Slide by Index
				var getSlide = function(index)
				{
					var slide = $(null);
					
					pco.items.each(function(i)
					{
						if(i == index)
						{
							slide = $(this);
						}
					});
					
					return slide;
				};		
				
				// Get Previous Index
				var getPreviousIndex = function()
				{
					var index = pco.index - 1;
					
					if(index < 0)
						index = pco.total_items - 1;
					
					return index;
				};
				
				// Get Next Index
				var getNextIndex = function()
				{
					var index = (pco.index + 1) % pco.total_items;
					
					
					return index;
				};
				
				// Generate Next Prev Navigation
				var generateNextPrevNav = function()
				{
					var container = typeof o.nextPrev == 'string' ? $(o.nextPrev) : o.nextPrev;
					
					var prev_slide = $('<a href="#" class="prev">Previous</a>');
					var next_slide = $('<a href="#" class="next">Next</a>');
					
					prev_slide.data('direction', -1);
					next_slide.data('direction', 1);
					
					container.append(prev_slide);
					container.append(next_slide);
					
					// Add Events
					prev_slide.add(next_slide).on('click', function(ev)
					{
						ev.preventDefault();
						
						var direction = $(this).data('direction');
						
						var to_index = direction == -1 ? getPreviousIndex() : getNextIndex();
						stopAutoSwitch();
						
						showSlide(to_index);
					});
				};
				
				// Show Slide Without Animation
				var showSlideNoAnimation = function(index)
				{
					var item = getSlide(index);
					
					if(item.length)
					{
						// Switch Indexes
						if(pco.last_slide.size())
						{
							pco.last_slide.data('itemImage').css({zIndex: pco.inactiveIndex});
							pco.last_slide.hide();
						}
							
						item.data('itemImage').css({zIndex: pco.activeIndex});
						
						item.show();
						
						pco.index = index;
						pco.last_slide = item;
					}
				};
				
				// Show Slide With Animation
				var showSlide = function(index)
				{
					var item = getSlide(index);
					
					if(item.length)
					{
						var fade_delay = parseInt(o.delay/2, 10);
						 
						var to_show = item,
							to_show_image = item.data('itemImage');
						
						var to_hide = pco.last_slide,
							to_hide_image = pco.last_slide.data('itemImage');
						
						// Switch Indexes
						to_show_image.css({zIndex: pco.activeIndex});
						to_hide_image.css({zIndex: pco.inactiveIndex});
						
						// Switch Image
						to_show_image.stop().fadeTo(0, 0).animate({opacity: 1}, {duration: o.delay, easing: 'easeInOutQuad'});
						to_hide_image.stop().animate({opacity: 0}, {duration: o.delay, easing: 'easeInOutQuad', complete: o.onFinish});
						
							
						
						// Switch Text
						to_hide.stop().animate({opacity: 0}, {duration: fade_delay / 3, easing: 'easeInOutSine', complete: 
							function()
							{
								to_hide.hide();
								
								to_show.show().fadeTo(0,0).animate({opacity: 1}, {duration: fade_delay / 2, easing: 'easeInOutSine'});
							}
						});
						
						
						pco.index = index;
						pco.last_slide = to_show;
					}
				};
				
				
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
						showSlide( getNextIndex() );
					}, timeout);
				};
				
				var autoSwitch = function(timeout)
				{
					startAutoSwitch(timeout);
					
					pco.images_container.add($container)
					.on('mouseenter', function()
					{
						stopAutoSwitch();
					})
					.on('mouseleave', function()
					{
						startAutoSwitch(timeout);
					});
				};
			
			
			/* SETUP SLIDER */
			
			
			// Show First Slide
			generateNextPrevNav();
			
			// Generate Navigation
			showSlideNoAnimation(0);
			
			
			// Check for autoswitch
			pco.images_container.imagesLoaded(function()
			{
				var as = 0;
				
				if(as = $container.data('autoswitch'))
				{
					autoSwitch(as);
				}
			});
			
			
			// Prev Next On KeyBoard
			if(o.prevNextOnKeyboard)
			{
				win.on('keyup', function(e)
				{
					if(e.keyCode == 37)
					{
						showSlide( getPreviousIndex() );
						stopAutoSwitch();
					}
					else
					if(e.keyCode == 39)
					{
						showSlide( getNextIndex() );
						stopAutoSwitch();
					}
				});
			}
		});
		
	}
	
})(jQuery, window);