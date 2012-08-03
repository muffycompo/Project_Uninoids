// Contact page
jQuery(function($)
{
	var map_options = {
		lat: 37.4419,
		lon: -122.1419,
		container_id: 'map-canvas',
		set_marker: true,
		zoom: 15
	};
	
	initializeMap(map_options);
});


// Ajax Contact Form
jQuery(function($)
{
	var ajax_contact_form = $("form.ajax_contact_form");
	var ajax_contact_form_success = $(".ajax_contact_form_success");
	
	if(ajax_contact_form.length)
	{
		// Fields
		var name 	= ajax_contact_form.find('#name');
		var email 	= ajax_contact_form.find('#email');
		var message	= ajax_contact_form.find('#message');
		
		var submit	= ajax_contact_form.find('button[type="submit"]');
		
		
		// Ajax Contact Form
		ajax_contact_form.submit(function(ev)
		{
			ev.preventDefault();
			
			if( ajax_contact_form.data('email_sent'))
				return;
			
			var post_fields = {
				request_contact	: true,
				name			: name.val(),
				email			: email.val(),
				message			: message.val() 
			};
			
			var form_errors = 0;
			
			// Check Message
			if(post_fields.message.length == 0)
			{
				form_errors++;
				message.addClass('error').focus();
			}
			else
			{
				message.removeClass('error');
			}
			
			// Check Email
			if( ! valid_email(post_fields.email))
			{
				form_errors++;
				email.addClass('error').focus();
			}
			else
			{
				email.removeClass('error');
			}
			
			// Check Name
			if(post_fields.name.length == 0)
			{
				form_errors++;
				name.addClass('error').focus();
			}
			else
			{
				name.removeClass('error');
			}
			
			
			if(form_errors == 0)
			{
				submit.fadeTo(500, 0.3);
				
				$.post('ajax_contact.php', post_fields, function(resp)
				{					
					resp = parseInt(resp, 10);
					
					if(resp == 1)
					{
						ajax_contact_form_success.slideDown(500);
						submit.slideUp(500);
						ajax_contact_form.data('email_sent', true);
					}
					else
					if(resp == -1)
					{	
						alert('An error occurred and your message can not be send, try again later!');
						submit.fadeTo(500, 1);
					}
				});
			}
		});
	}
});

function initializeMap(options)
{
	var mapDiv = document.getElementById(options.container_id);
	var position = new google.maps.LatLng(options.lat, options.lon);
	
	var map = new google.maps.Map(mapDiv, {
		center: position,
		zoom: options.zoom,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		disableDefaultUI: true,
		panControl: true,
		zoomControl: true,
		mapTypeControl: true,
		zoomControlOptions: {
			style: google.maps.ZoomControlStyle.LARGE
		},
		mapTypeControlOptions: {
			style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
		}
	});
	
	// Set marker if allowed
	if(options.set_marker)
	{
		new google.maps.Marker({map: map, position: position});
	}
	
	// For Purpose of Responsivity
	$(window).bind('afterresize', function()
	{
		map.panTo(position);
	});
	
}

function valid_email(email) 
{ 
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

   return reg.test(email);
}