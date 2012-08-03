/* 
	Features Tabs jQuery Plugin dedicated to Crystal Theme
	Created by: Arlind Nushi 
	Date: Jun 5, 2012
*/

(function($)
{
	var self = this;
	
	var defaults = {
		resizeDuration: 300,
		fadeDuration: 100,
		pullTop: 25
	};
	
	var o = defaults;
	
	var showTab = function(container, tab_id, height, no_animation)
	{
		// If busy, stop animation
		if(container.data('featurestabs-isbusy') && ! no_animation)
			return;
		
		var all_tabs = container.find('.side_tab .features_tab');
		var tabs_nav = container.find('td.tabs_nav');
		
		var to_show = container.find('.side_tab .features_tab[data-id="'+tab_id+'"]');
		var to_hide = all_tabs.not(to_show);
		
		var to_show_items = to_show.find('.service_entry');
		var to_hide_items = to_hide.find('.service_entry');
		
		var to_show_total_items = to_show_items.length;
		var to_hide_total_items = to_hide_items.length;
		
		to_show_items.add(to_hide_items).css('position', 'relative');
		
		// Check If is current tab
		if(container.data('featurestabs-currenttab') == tab_id)
			return;
		
		// Set Current Tab
		container.data('featurestabs-currenttab', tab_id);
		
		// No Animation
		if(no_animation)
		{
			to_hide.hide();
			to_show.show();
			tabs_nav.css({height: height});
		}
		
		// Animation Allowed
		else
		{
			// Make it busy!
			container.data('featurestabs-isbusy', true);
			
			// Hide One By One
			
			to_hide_items.each(function(i)
			{
				var $this = $(this);
				
				setTimeout(function()
				{
					$this.transit({opacity: 0, top: o.pullTop}, o.resizeDuration);
					
				}, (i * o.fadeDuration));
			});
			
			tabs_nav.transit({height: height}, o.resizeDuration);
			
			setTimeout(function()
			{
				to_hide.hide();
				to_show.show();
				
				to_show_items.fadeTo(0,0);
				
				to_show_items.each(function(i)
				{
					var $this = $(this);
					
					setTimeout(function()
					{
						$this.css({top: -o.pullTop}).transit({opacity: 1, top: 0}, o.resizeDuration);
						
					}, (i * o.fadeDuration));
				});
				
				
				var finish_time = to_hide_total_items * o.fadeDuration + o.fadeDuration * to_show_total_items;
				
				setTimeout(function(){
					container.data('featurestabs-isbusy', false);	
				}, finish_time)
				
			}, o.fadeDuration * to_hide_total_items)
		}
		
	};
	
	var setTabHeights = function(container)
	{
		var all_tabs = container.find('.side_tab .features_tab');
		
		var tabs_nav = container.find('td.tabs_nav');
		var tab_links = container.find('td.tabs_nav a');
		
		tab_links.each(function()
		{
			var tab_link = $(this);
			var tab_id = tab_link.attr('rel');
			
			var related_tabs = all_tabs.filter('[data-id="'+tab_id+'"]');
			
			all_tabs.hide();
			related_tabs.show();
			
			var height = tabs_nav.height();
			tab_link.data('featurestabs-height', height);
		});
		
		var first = tab_links.first();
		showTab(container, first.attr('rel'), first.data('featurestabs-height'), true);
	};
	
	
	
	var showMiniTab = function(container, tab_id, no_animation) ///sssssssss
	{
		var all_tabs = container.find('.features_tab');
		var tabs_nav = container.find('.tabs_nav_small');
		
		var to_show = container.find('.features_tab[data-id="'+tab_id+'"]');
		var to_hide = all_tabs.not(to_show);
		
		// If tab is visible, don't fade it away
		if(container.data('featurestabs-currenttab') == tab_id)
			return;
		
		container.data('featurestabs-currenttab', tab_id);
		
		
		if(no_animation)
		{
			to_hide.hide();
			to_show.show();
		}
		else
		{
			to_hide.stop().fadeTo(o.fadeDuration * 2, 0, function()
			{
				to_hide.hide();
				to_show.stop().fadeTo(o.fadeDuration * 2, 1);
			});
		}
	}
	
	
	var generateForSmallScreens = function(container)
	{
		var small_screen_env = $('<div class="small_screen_only" />');
		
		var all_tabs = container.find('.side_tab .features_tab');
		
		var tabs_nav = container.find('td.tabs_nav').clone();
		var tab_links = tabs_nav.find('a');
		
		
		var new_tabs_nav = $('<div class="tabs_nav_small clearfix" />');
		
		// Setup Mini Tabs
		var active_tab_def = tab_links.filter('[class~=active]');
		
		var has_active_tab = active_tab_def.length > 0;
		
		tab_links.each(function(i)
		{
			var tab_link = $(this);
			var tab_id = tab_link.attr('rel');
			
			// Set First Last Tab Class
			if(i == 0)
				tab_link.addClass('first');
			else
			if(tab_links.length - 1 == i)
				tab_link.addClass('last');
			
			new_tabs_nav.append(tab_link);
			
			var related_tabs = all_tabs.filter('[data-id="'+tab_id+'"]');
			
			var tab_group = $('<div class="features_tab" data-id="'+tab_id+'" />');
			
			// Add Tab Items
			related_tabs.each(function(j)
			{
				var $cloned = $(this).clone();
				
				tab_group.append($cloned.find('.service_entry'));
			});
			
			// Hide Other Tabs (just one active)
	
			if( ! has_active_tab && i == 0)
			{
				tab_link.addClass('active');
				active_tab_def = tab_link;
			}
			
			// Add Tab Group
			small_screen_env.append(tab_group);
			
			// Set Click Event for Tab Link
			tab_link.click(function(ev)
			{
				ev.preventDefault();
				
				tab_links.removeClass('active');
				tab_link.addClass('active');
				
				showMiniTab(small_screen_env, tab_id);
			});
		});
		
		small_screen_env.prepend(new_tabs_nav);
		
		// Append After Features Tabs
		container.after(small_screen_env);
		
		
		// Show Active Tab
		showMiniTab(small_screen_env, active_tab_def.attr('rel'), true);
	};
	
	$.fn.featuresTabs = function(options)
	{	
		$.extend(defaults, options);
			
		this.each(function(i)
		{
			var container = $(this);
			var instance = {};
			
			generateForSmallScreens(container);
			setTabHeights(container);
			
			var tab_links = container.find('td.tabs_nav a');
			
			// Setup Tab Links
			var total_tabs = tab_links.length;
			var active_tab_def = tab_links.filter('[class~=active]');
			
			var has_active_tab = active_tab_def.length > 0;
			
			
			tab_links.each(function(i)
			{
				var tab_link = $(this);
				var class_to_add = '';
				
				if(i == 0)
				{
					class_to_add = 'first';
					
					if( ! has_active_tab)
					{
						class_to_add += ' active';
						active_tab_def = tab_link;
					}
				}
				else
				if(i+1 == total_tabs)
					class_to_add = 'last';
					
				
				tab_link.addClass(class_to_add);
				
				tab_link.click(function(ev)
				{
					ev.preventDefault();
					
					if(container.data('featurestabs-isbusy'))
						return false;
					
					tab_links.removeClass('active');
					tab_link.addClass('active');
					
					var tab_id = tab_link.attr('rel');
					showTab(container, tab_id, tab_link.data('featurestabs-height'));
				});
			});
			
			
			// Show Active Tab (At Start)
			showTab(container, active_tab_def.attr('rel'), active_tab_def.data('featurestabs-height'), true);
			
			
			container.data('featurestabsinstance', instance);
		});
	};
	
})(jQuery);

