/*
	Adds functionality to detect window finish resize event
	
	By: Arlind Nushi
*/
jQuery(function($)
{
	var win = $(window);	
	var win_timeout = null;
	var time_to_check = 300;
	
	win.on('resize', function()
	{
		var win_w = win.width();
		
		window.clearTimeout(win_timeout);
		win_timeout = null;
		
		win_timeout = setTimeout(function()
		{
			win.trigger('afterresize');
			
		}, time_to_check);
		
	});
});