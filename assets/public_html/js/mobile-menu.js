// Mobile Menu
jQuery(function($)
{
	var mobmenu = new MobileMenu();
	
	// Main Menu
	var main_menu = $(".site_header .main_menu")
	var main_menu_title = main_menu.data('title');
	
	if( ! main_menu_title)
		main_menu_title = 'Main Menu';
	
	// Top Menu
	var top_menu = $(".site_header .top_menu");
	var top_menu_title = top_menu.data('title');
	
	if( ! top_menu_title)
		top_menu_title = 'Secondary Menu';
	
	mobmenu.addGroupFromDOM(main_menu_title, main_menu);
	mobmenu.addGroupFromDOM(top_menu_title, top_menu);
	
	/* Note: You can register as many menus as you want using the same logic of above registered menus */
	
	
	// Setup Menu Elements (types: Regular and Nested)
	var dropdown_dom = mobmenu.parseDropDown({name: 'menu_dropdown'})
	//var dropdown_dom = mobmenu.parseNestedDropDown({name: 'menu_dropdown_nested'})
	
	// Before Initializing, Setup Click Events (do not change)
	mobmenu.setupClickEvents();
	
	// Append Dropdown Menu DOM to Element
	$(".site_header #mobile_menu div").html( dropdown_dom );
});

var MobileMenu = function()
{
	var self = this;
	var menu_groups = [];
	var menu_dropdown_list;
	
	this._indenter = '–';
	
	// Register Menu Group
	this.addMenuGroup = function(id, label)
	{
		var menu_group; 
		
		if(typeof id == 'object')
		{
			menu_group = id;
		}
		else
		{
			menu_group = new MenuGroup(id, label);
		}
		
		menu_groups.push(menu_group);
	};
	
	
	// Add Menu Group From DOM
	this.addGroupFromDOM = function(group_name, dom_group)
	{
		var group = new MenuGroup(group_name, group_name);
		
		insertAllElementsFromDOM(group, dom_group);
		
		this.addMenuGroup(group);
	};
	
	
	// Get All Menu Groups
	this.getMenuGroups = function()
	{
		return menu_groups;
	};
	
	
	// Parse HTML Dropdown
	this.parseDropDown = function(options)
	{
		var id_name = 'menugroup';
				
		if(typeof options == 'object')
		{
			if(options.id)
				id_name = options.id;
			else if(options.name)
				id_name = options.name;
		}
		
		
		// Groups
		var groups = self.getMenuGroups();
		var parser_obj = $('<select />');
		
		parser_obj.attr('id', id_name).attr('name', id_name);
		
		// Loop
		for(var i in groups)
		{
			var group = groups[i];
			
			var opt_group = $('<optgroup />');
			opt_group.attr('label', group.label());
			
			putDropDownItems(opt_group, group.menu_items);
			
			parser_obj.append(opt_group);
		}
		
		menu_dropdown_list = parser_obj;
				
		// Remove other Selected Items
		var selected = parser_obj.find('[selected]');
		
		if(selected.length > 1)
		{
			var last = selected.last();
			selected.attr('selected', false);
			last.attr('selected', true);
		}
		
		return parser_obj;
	}
	
	
	// Parse Nested HTML Dropdown
	this.parseNestedDropDown = function(options)
	{
		var id_name = 'menugroup';
				
		if(typeof options == 'object')
		{		
			if(options.indenter)
				self._indenter = options.indenter;
			
			if(options.id)
				id_name = options.id;
			else if(options.name)
				id_name = options.name;
		}
		
		// Groups
		var groups = self.getMenuGroups();
		var parser_obj = $('<select />');
		
		parser_obj.attr('id', id_name).attr('name', id_name);
		
		// Loop
		for(var i in groups)
		{
			var group = groups[i];
			
			var opt_group = $('<optgroup />');
			opt_group.attr('label', group.label());
			
			putNestedDropDownItems(opt_group, group.menu_items);
			
			parser_obj.append(opt_group);
		}
		
		menu_dropdown_list = parser_obj;
		return parser_obj;
	}
	
	
	// Private Method
	var insertAllElementsFromDOM = function(group, dom_group, parent_id)
	{	
		dom_group.find(' > li').each(function(i)
		{
			var item = $(this);
			var item_a = item.find('> a');
			
			var _title = item_a.text();
			var _href = item_a.attr('href');
			var _is_selected = item.hasClass('active') || item.hasClass('current');
			
			// Add Menu Item
			group.addItem({title: _title, href: _href, selected: _is_selected}, parent_id);
			
			// Add Sub Items if Exists
			var item_sub_menu = item.find('> ul');
			
			if(item_sub_menu.length > 0)
			{
				insertAllElementsFromDOM(group, item_sub_menu, _title);
			}
		});
	};
	
	
	var putDropDownItems = function(opt_group, menu_items, level)
	{
		if( ! level)
			level = 1;
		
		for(var i in menu_items)
		{
			var menu_item = menu_items[i];
			
			var _title = menu_item.title;
			var _href = menu_item.href;
			var _selected = menu_item.selected;
			
			var _title_mult = repeatStr(self._indenter, level);
			
			if(_title_mult.length)
			{
				_title_mult += ' ' + _title;
			}
			else
			{
				_title_mult = _title;
			}
			
			var option = $('<option />');
			option.attr('value', _href).html(_title);
			
			if(_selected)
				option.attr('selected', true);
			
			var sub_menu_items = menu_item.menu_items;
			
			opt_group.append(option);
			
			if(sub_menu_items && sub_menu_items.length > 0)
			{
				option.html(option.html() + ' &raquo;');
				putDropDownItems(opt_group, sub_menu_items, level + 1);
			}
		}
	}
	
	
	var putNestedDropDownItems = function(opt_group, menu_items, level)
	{
		if( ! level)
			level = 1;
		
		for(var i in menu_items)
		{
			var menu_item = menu_items[i];
			
			var _title = menu_item.title;
			var _href = menu_item.href;
			var _selected = menu_item.selected;
			
			var _title_mult = repeatStr(self._indenter, level);
			
			if(_title_mult.length)
			{
				_title_mult += ' ' + _title;
			}
			else
			{
				_title_mult = _title;
			}
			
			var option = $('<option />');
			option.attr('value', _href).html(_title);
			
			if(_selected)
				option.attr('selected', true);
			
			var sub_menu_items = menu_item.menu_items;
			
			if(sub_menu_items && sub_menu_items.length > 0)
			{
				var _opt_group = $('<optgroup />');
				_opt_group.attr('label', _title_mult);
				
				opt_group.append(_opt_group);
				
				putNestedDropDownItems(_opt_group, sub_menu_items, level + 1);
			}
			else
			{
				opt_group.append(option);
			}
		}
	}
	
	
	this.setupClickEvents = function()
	{
		menu_dropdown_list.change(function()
		{
			var href = $(this).val();
			
			window.location.href = href;
		});
	}

	return self;
}

var MenuGroup = function(_id, _label)
{
	var self = this;
	
	// Meta Info
	var id = 'group';
	var label = 'Menu Group';
	
	// Initialze Class
	if(_id)
		id = _id;
	
	if(_label)
		label = _label;
	
	// Menu Items
	this.menu_items = []
	
	// Get Set
	this.id = function(new_id)
	{
		if( ! new_id)
			return id;
			
		id = new_id;
	}
	
	this.label = function(new_label)
	{
		if( ! new_label)
			return label;
			
		label = new_label;
	}
	
	// Meta
	this.meta = {id: this.id(), label: this.label()};
	
	
	// Add Menu Item
	this.addItem = function(options, parent_id, _third)
	{
		// Process Vars
		if(typeof options != 'object')
		{
			options = {title: options, href: parent_id};
			parent_id = _third;
		}
		
		var menu_item = new MenuItem(options);
		
		if(typeof parent_id == 'undefined')
		{
			// Add Item
			this.menu_items.push(menu_item);
		}
		else
		{
			// Add Sub Item
			addSubItem(self.menu_items, menu_item, parent_id);
		}
	}
	
	var addSubItem = function(menu_items, menu_item, parent_id)
	{
		for(var i in menu_items)
		{
			var _menu_item = menu_items[i];
			
			if(parent_id == _menu_item.id)
			{
				_menu_item.addItem(menu_item);
				return;
			}
			
			addSubItem(_menu_item.menu_items, menu_item, parent_id);
		}
	}
	
	return self;
}


var MenuItem = function(options)
{
	var self = this;
	
	this.id = '';
	this.title = '';
	this.href = '';
	this.selected = false;
	this.menu_items = [];
	
	// Initialize
	if(typeof options == 'object')
	{		
		if(options.title)
			this.title = options.title;
			
		if(options.href)
			this.href = options.href;
		
		if(options.id)
			this.id = options.id;
		else
			this.id = this.title;
		
		if(options.selected)
			this.selected = options.selected;
	}
	
	// Add Submenu Item
	this.addItem = function(options)
	{
		var menu_item = new MenuItem(options);
		
		this.menu_items.push(menu_item);
		
		return menu_item;
	}
	
	return self;
}

var repeatStr = function(str, mult)
{
	var concat = '';
	
	for(var i=1; i<=mult; i++)
	{
		concat += str;
	}
	
	return concat;
}