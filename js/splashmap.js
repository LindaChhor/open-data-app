$(document).ready(function() {
    
	var gmapOptions = {
		center : new google.maps.LatLng(45.423494,-75.697933)
		, zoom : 13
		, mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	var map = new google.maps.Map(document.getElementById('map'), gmapOptions);
	
	var infoWindow;
	
	$('.pools li').each(function (i, elem) {
		var pools = $(this).find('a').html();

		// Create some HTML content for the info window
		// Style the content in your CSS
		var info = '<div class="info-window">'
			+ '<strong>' + pools + '</strong>'
			+ '</div>'
		;

		// Determine this dino's latitude and longitude
		var latitude = $(this).find('meta[itemprop="latitude"]').attr('content');
		var longitude = $(this).find('meta[itemprop="longitude"]').attr('content');
		var pos = new google.maps.LatLng(latitude, longitude);
		console.log(marker);
		// Create a marker object for this dinosaur
		var marker = new google.maps.Marker({
			position : pos
			, map : map
			, icon : 'images/duck.png'
			, title : pools
			, animation: google.maps.Animation.DROP
		});

		// A function for showing this dinosaur's info window
		function showInfoWindow (ev) {
			if (ev.preventDefault) {
				ev.preventDefault();
			}

			// Close the previous info window first, if one already exists
			if (infoWindow) {
				infoWindow.close();
			}

			// Create an info window object and assign it the content
			infoWindow = new google.maps.InfoWindow({
				content : info
			});

			infoWindow.open(map, marker);
		}

		// Add a click event listener for the marker
		google.maps.event.addListener(marker, 'click', showInfoWindow);
		// Add a click event listener to the list item
		google.maps.event.addDomListener($(this).children('a').get(0), 'click', showInfoWindow);
	});

});