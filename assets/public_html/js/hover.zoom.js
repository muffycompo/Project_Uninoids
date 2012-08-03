function getRGB(color) {
    // Function used to determine the RGB colour value that was passed as HEX
    var result;

    // Look for rgb(num,num,num)
    if (result = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color)) return [parseInt(result[1]), parseInt(result[2]), parseInt(result[3])];

    // Look for rgb(num%,num%,num%)
    if (result = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(color)) return [parseFloat(result[1]) * 2.55, parseFloat(result[2]) * 2.55, parseFloat(result[3]) * 2.55];

    // Look for #a0b1c2
    if (result = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(color)) return [parseInt(result[1], 16), parseInt(result[2], 16), parseInt(result[3], 16)];

    // Look for #fff
    if (result = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(color)) return [parseInt(result[1] + result[1], 16), parseInt(result[2] + result[2], 16), parseInt(result[3] + result[3], 16)];
}

(function($){

    $.fn.extend({ 

        hoverZoom: function(settings) {
 
            var defaults = {
                overlay: true,
                overlayColor: '#d86560',
                overlayOpacity: 0.5,
                zoom: 0,
                speed: 300,
                already_loaded: false,
                iconMove: -0.2
            };
            
             
            var settings = $.extend(defaults, settings);
         	
            var bgcolor = getRGB(settings.overlayColor);
            var r = bgcolor[0];
            var g = bgcolor[1];
            var b = bgcolor[2];
            
            
            return this.each(function() {
            
                var s = settings;
                var hz = $(this);
                var image = $('img', hz);
                
                
                var apply_hoverZoom = function() {
                	
                	var $this = $(this);
                	
                	$this.addClass('hasOverlay');
                    
                    if(s.overlay === true) {
                    	var zoomOverlay = $('<div class="zoomOverlay" />');
                    	var zoomIcon = $('<div class="zoomIcon" />');
                    	var iconMove = $this.height() * s.iconMove;
                    	
                    	zoomOverlay.css({
                    		display: 'block',
                    		backgroundColor: 'rgba('+r+','+g+','+b+','+s.overlayOpacity+')',
                    		opacity: 0
                    	});
                    	
                    	zoomOverlay.append(zoomIcon);
                    	
                        $this.parent().append(zoomOverlay);
                        /*$this.parent().find('.zoomOverlay').css({
                            opacity:0, 
                            display: 'block', 
                            backgroundColor: s.overlayColor
                        });*/ 
                    }
                
                    var width = $this.width();
                    var height = $this.height();
                
                    $this.fadeIn(1000, function() {
                        $this.parent().css('background-image', 'none');
                        hz.hover(function() {
                            $('img', this).stop().animate({
                                //height: height + s.zoom,
                                marginLeft: -(s.zoom),
                                marginTop: -(s.zoom)
                            }, s.speed);
                            if(s.overlay === true) {
                                zoomOverlay.stop().animate({
                                    opacity: 1//s.overlayOpacity
                                }, s.speed);
                                
                                zoomIcon.css({marginTop: iconMove}).stop().animate({marginTop: 0}, s.speed);
                            }
                        }, function() {
                            $('img', this).stop().animate({
                               // height: height,
                                marginLeft: 0,
                                marginTop: 0
                            }, s.speed);
                            if(s.overlay === true) {
                                zoomOverlay.stop().animate({
                                    opacity: 0
                                }, s.speed);
                                
                                zoomIcon.stop().animate({marginTop: iconMove}, s.speed);
                            }
                        });
                    });
                }
                
                if( s.already_loaded == false )
                {
                	image.load(apply_hoverZoom);
                	
                	image.error(function(){ $(this).hide(); })
                }
                else
                {
                	image.not('.hasOverlay').each(apply_hoverZoom);
                }
            });
        }
    });
})(jQuery);