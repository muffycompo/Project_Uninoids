function device_type()
{
	return current_device_type;
}

function large_screen()
{
	// This function is triggered when screen width is larger than or equals to 960
	
	isotopeFix();
	partnersCarouselFit();
	setupMainMenu(true);
}

function ipad()
{
	// This function is triggered when screen width is [768,959]
	
	isotopeFix();
	partnersCarouselFit();
	setupMainMenu(true);
}

function iphone()
{
	// This function is triggered when screen width is [100,479]

	isotopeFix();
	partnersCarouselFit();
}


function iphone_landscape()
{
	// This function is triggered when screen width is [480,767]
	
	isotopeFix();
	partnersCarouselFit();
}



var win;
var current_device_type;
var last_device_type;

function test_device_type()
{
	if( !win)
		win = $(window);
		
	var win_width = win.width();
	
	var break_points = {
		iphone: [100, 479],
		iphone_landscape: [480, 767],
		ipad: [768, 959],
		large_screen: [960, 3840]
	};
	
	for(var device_type in break_points)
	{
		var device_width = break_points[device_type];
		
		if(win_width >= device_width[0] && win_width <= device_width[1])
		{
			current_device_type = device_type;
			return device_type;
		}
	}
}

jQuery(function($)
{
	win = $(window);
	
	test_device_type();
	
	win.bind('afterresize', function()
	{
		test_device_type();
		
		if(current_device_type != last_device_type)
		{
			eval(current_device_type + '()');
			last_device_type = current_device_type;
		}
		
		resetHoverZoomImages();
	});
});

function resetHoverZoomImages()
{
	$(".zoom").each(function()
	{
		var $this = $(this);
		var image = $this.find('img');
		
		image.css({height: 'auto'});
	});
}


// Isotope Fix;
var isotopeFix_interval, isotopeFix_count = 0, isotopeFix_maxtry = 10;

function isotopeFix()
{
	var fix_int = 500;
	
	if(isotopeFix_interval)
		return;
	
	if($('.portfolio_item').size() > 0)
	{	
		isotopeFix_interval = setInterval(function()
		{
			$(window).trigger('resize');
			isotopeFix_count++;
			
			if(isotopeFix_count >= isotopeFix_maxtry)
			{
				window.clearInterval(isotopeFix_interval);
				isotopeFix_interval = null;
				isotopeFix_count = 0;
			}
			
		}, fix_int);
	}
}