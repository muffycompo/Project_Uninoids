(function($)
{
	var body = $("body");
	var css = $('<link />');
	var clear = $('<div class="clear" />');
	
	
	css.attr({type: 'text/css', rel: 'stylesheet', href: 'css/style-switcher.css'});
	
	body.append(css);
	
	
	// Switcher
	var switcher = $('<a href="#" class="switcher" />');
	
	body.append(switcher);
	
	var options = $('<div class="theme_options" />');
	
	body.append(options);
	
	
	
	// Patterns
	var patterns = $('<div class="patterns" />');
	var patterns_title = $('<h1>Patterns</h1>');
	patterns.append(patterns_title);
	
	for(var i=1; i<=30; i++)
	{
		var _i = i < 10 ? ('0' + i) : i;
		
		var patt = $('<a href="#" class="pattern" rel="'+_i+'" style="background-image:url(images/bg_pattern_'+_i+'.png)">'+_i+'</a>');
		
		patt.on('click', function(e)
		{
			e.preventDefault();
			
			body.attr('class', 'pat_'+$(this).attr('rel'));
			patterns.find('a').removeClass('active');
			$(this).addClass('active');
		});
		
		patterns.append(patt);
		
	}
	
	patterns.find('a:first').addClass('active');
	
	
	// Sliders
	var sliders = $('<div class="sliders" />)');
	var sliders_title = $('<h1>Slider</h1>');
	sliders.append(sliders_title);
	
	var _sliders = $('<select />');
	
	var _sitems = [{name: '', href: ''},{name: 'AsyncSlider', href: 'index.html'},{name: 'Wide Slider', href: 'index-wideslider.html'}];
	
	for(var i in _sitems)
	{
		var sitem = _sitems[i];
		
		var opt = $('<option />');
		opt.val(sitem.href).text(sitem.name);
		
		_sliders.append(opt);
	}
	
	if( $(".asyncslider").length > 0)
	{
		_sliders.find('option:nth-child(2n)').attr('selected', true);
	}
	
	if( $(".wideslider").length > 0)
	{
		_sliders.find('option:nth-child(3n)').attr('selected', true);
	}
	
	_sliders.change(function()
	{
		var href = $(this).val();
		
		if(href.length)
			window.location.href = href;
	});
	
	sliders.append(_sliders);
	
	
	// Header Type
	var header_type = $('<div class="sliders" />)');
	var header_type_title = $('<h1>Header Type</h1>');
	header_type.append(header_type_title);
	
	
	var _ht = $('<select />');
	
	var _ht_fluid = $('<option value="fluid">Fluid</option>');
	var _ht_tight = $('<option value="tight">Fixed</option>');
	
	_ht.append(_ht_fluid)
	_ht.append(_ht_tight)
	
	var site_header = $(".site_header");
	
	_ht.change(function()
	{
		if($(this).val() == 'tight')
		{
			site_header.addClass('tight');
		}
		else
		{
			site_header.removeClass('tight');
		}
	});
	
	if(site_header.hasClass('tight'))
		_ht_tight.attr('selected', true);
	
	header_type.append(_ht);
	
	
	// Add Options
	options.append(sliders);
	options.append(header_type);
	options.append(patterns);
	
	options.append(clear);
	
	// Hide Options
	options.data('hidden', true);
	
	options.css({left: -220});
	
	
	// Show Controls/Options
	switcher.click(function(ev)
	{
		ev.preventDefault();
		
		var is_hidden = options.data('hidden');
		
		if(is_hidden)
		{
			options.stop().animate({left: 25}, {easing: 'easeInOutExpo'});
			options.data('hidden', false);
		}
		else
		{
			options.stop().animate({left: -220}, {easing: 'easeInOutExpo'});
			options.data('hidden', true);
		}
	});
	
	var to_opacity = 0.4;
	
	switcher.fadeTo(0, to_opacity).hover(function()
	{
		switcher.stop().fadeTo(250, 1);
	},
	function()
	{
		switcher.stop().fadeTo(250, to_opacity);
	})
	
})(jQuery);




var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-28991003-1']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? '../../../https@ssl/' : '../../../www/') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();