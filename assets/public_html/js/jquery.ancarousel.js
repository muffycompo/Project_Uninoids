/* 
	Simple jQuery Carousel plugin
	Created by: Arlind Nushi 
	Version: 0.1
	Date: Jun 4, 2012
*/

(function($){
    
    $.fn.anCarousel = function(options){
        
        var defaults = {
        	// Carousel Options
            itemsPerRow: 10,
            childSelector: '> li',
            
            // Automatic Switch
            autoSlide: 0,
            pauseOnHover: true,
            
            // Navigation Buttons
            nextPrevBtns: true,
            nextBtn: null,
            prevBtn: null,
            
            // Item Animation Options
            pullOut: 25,
            fadeOnly: false,
            fadeTimeout: 70,
            duration: 300,
            direction: 1,
            timespace: 400
        };
        
        var self = this;
        
        $.extend(defaults, options);
        var o = defaults;
     
        self.setClearer = function(container, items){
            var clearer = $('<div class="anclearer" />').css({clear: 'both'});
            
            container.find('.anclearer').remove();
            items.filter(':nth-child('+o.itemsPerRow+'n)').after(clearer.clone());
        }
        
            
        self.showPage = function(container, items, page, animate, direction){
            
            if(container.data('ancarousel-isbusy') == true && animate)
                return;                    
        
            if(animate)
                container.data('ancarousel-isbusy', true);            
        
            var total_items = items.length;
            var pages_count = Math.ceil(total_items/o.itemsPerRow);
            
            var to_show_offset = (page) * o.itemsPerRow;
            var to_show = items.slice(to_show_offset, to_show_offset+o.itemsPerRow);
            
            var to_hide = items.not(to_show);
        
            container.data('ancarousel-currentpage', page);
            
        
            if( ! animate){
                to_hide.fadeTo(0, 0).css({zIndex: 3});
                to_show.fadeTo(0, 1).css({zIndex: 4});
            }
            else {
                //var duration = parseInt(o.duration/o.itemsPerRow);
                to_hide.each(function(i){
                    var $this = $(this);
                    direction = direction ? direction : o.direction;
                    
                    var timeout_interval = (i + 0) * o.fadeTimeout;
                    
                    if(direction != 1)
                        timeout_interval = (to_hide.length - i + 0) * o.fadeTimeout;
                            
                    setTimeout(function(){
                        //$this.fadeTo(o.duration, 0).css({zIndex: 4});
                        //$this.transition({x: direction*o.pullOut, opacity: 0});
                        
                        $this.css({zIndex: 4});
                        
                        if(o.fadeOnly)
                        	$this.fadeTo(o.duration, 0)
                        else
                        	$this.stop().animate({marginLeft: direction*o.pullOut, opacity: 0}, o.duration);
                        	//$this.transition({x: direction*o.pullOut, opacity: 0});
                        	
                    }, timeout_interval);
                });
                
                to_show.each(function(i){
                    var $this = $(this);
                    direction = direction ? direction : o.direction;
                    
                    $this.data('ancarousel-index', i);
                    
                    var timeout_interval = (i + 1) * o.fadeTimeout;
                    
                    if(direction != 1)
                        timeout_interval = (to_show.length - i + 1) * o.fadeTimeout;
                        
                    setTimeout(function(){
                    	
                    	$this.css({zIndex: 5});
                    	
                        if(o.fadeOnly)
                        	$this.stop().fadeTo(o.duration, 1);
                        else
                        	$this.stop().animate({marginLeft: 0, opacity: 1}, o.duration);
                        //$this.css({x: -direction * o.pullOut}).transition({x: 0, opacity: 1});
                        
                        if($this.data('ancarousel-index') == to_show.length - 1)
                        {
                            container.data('ancarousel-isbusy', false);
                        }
                    }, timeout_interval + o.timespace);
                    
                });
            }
        }
        
        self.each(function(i){
            var instance = {};
    
            var container = $(this);
            container
                .css({position: 'relative', overflow: 'hidden'})
                .data('ancarousel-itemsperrow', o.itemsPerRow)
                .data('ancarousel-isbusy', false);
    
            var c_width = container.width();
            var c_height = container.height();
            
            var items = container.find(o.childSelector);
            
            self.setClearer(container, items);
        
            items.each(function(i){
                var item = $(this);
                
                var upper_margin = Math.floor(i/o.itemsPerRow) * c_height;
                
                item.height(c_height).css({position: 'relative', top: -upper_margin});
            });
        
            self.showPage(container, items, 0, false);
    
            // Next Page Index
            instance.getNextPage = function(){
                var items_per_row = container.data('ancarousel-itemsperrow');
                var current_page = container.data('ancarousel-currentpage');
                var max_pages = Math.ceil(items.length/items_per_row);
                
                var next_page = (current_page + 1) % max_pages;
                
                return next_page;
            }
                
            // Prev Page Index
            instance.getPrevPage = function(){
                var items_per_row = container.data('ancarousel-itemsperrow');
                var current_page = container.data('ancarousel-currentpage');
                var max_pages = Math.ceil(items.length/items_per_row);
                
                var prev_page = current_page - 1;
    
                if(prev_page < 0)
                    prev_page = max_pages - 1;
                
                return prev_page;
            }

            // Show Next Page (Animation)
            instance.showNextPage = function(){
                self.showPage(container, items, instance.getNextPage(), true, 1);
            } 

            // Show Prev Page (Animation)
            instance.showPrevPage = function(){
                self.showPage(container, items, instance.getPrevPage(), true, -1);
            }

            // Next Page Button
            if(o.nextPrevBtns && o.nextBtn){
                $(o.nextBtn).on('click', function(ev){
                    ev.preventDefault();
                    instance.stop();
                    instance.showNextPage();               
                });
            }
                
            // Prev Page Button
            if(o.nextPrevBtns && o.prevBtn){
                $(o.prevBtn).on('click', function(ev){
                    ev.preventDefault();
                    instance.stop();
                    
                    instance.showPrevPage();
                });
            }
    
            // Autoslide
            if(o.autoSlide){
                instance.autoSlideInterval = setInterval(function(){
                    instance.showNextPage();    
                }, o.autoSlide);
            }
            
            // Pause on Hover
            if(o.autoSlide && o.pauseOnHover)
            {
            	container.on('mouseenter', function()
            	{
            		instance.stop();
            	});
            	
            	container.on('mouseleave', function()
            	{
            		instance.play();
            	});
            }

            // Stop Autoslide
            instance.stop = function(){
                window.clearInterval(instance.autoSlideInterval);
                instance.autoSlideInterval = null;
            }
            
            // Set Autoslide
            instance.play = function(){
	            if(o.autoSlide){
	            	instance.stop();
	            	
	                instance.autoSlideInterval = setInterval(function(){
	                    instance.showNextPage();    
	                }, o.autoSlide);
	            }
            }
            
            // Reset the number of items per row
            instance.updateItemsPerRowNumber = function(columns)
            {
            	instance.stop();
            	
            	o.itemsPerRow = columns;
            	container.data('ancarousel-itemsperrow', o.itemsPerRow);
            	
            	self.setClearer(container, items);
            	
            	// Re-calculate Coords
            	var c_height = container.height();
            	
	            items.each(function(i){
	                var item = $(this);
	                
	                var upper_margin = Math.floor(i/o.itemsPerRow) * c_height;
	                
	                item.height(c_height).css({position: 'relative', top: -upper_margin});
	            });
            	
            	// Fix current page
            	var page_to_show = container.data('ancarousel-currentpage') % o.itemsPerRow;
            	container.data('ancarousel-isbusy', false);
            	self.showPage(container, items, page_to_show, false);
            	
            	// Continue the carousel slider
            	instance.play();
            }
    
            container.data('ancarouselinstance', instance);
        });
        
    };
    
})(jQuery);