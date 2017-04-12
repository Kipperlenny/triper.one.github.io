var map;
var markers = {};
var markers_persons = {};
var markers_dates = {};
//var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/'
var iconBase = 'http://dev.triper.one/wp-content/themes/triperone/images/';
var autocomplete;
var autocomplete_street;
var weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
var autoCompleteData;

function initMap() {
	// Create a map object and specify the DOM element for display.
	map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 52.518335, lng: 13.406842},
		scrollwheel: true,
		zoom: 5
	});

	autocompleteFilter = new google.maps.places.Autocomplete((document.getElementById('search_city')), {
		types: ['(cities)']
	});
  
    autocompleteFilter.addListener('place_changed', function(){
        onPlaceChanged(getPlaceData);
    });
	
    

	
	initAutocomplete();
	showAllMarker();
}//initMap


setTimeout(function(){
    initMap();
},500);





//When the user selects a city, get the place details for the city and
//zoom the map in on the city.
function onPlaceChanged(place) {

	
    jQuery('.stat:first-child .count-title').text('Hosts in ' + place.name);
	switch(place.name) {
		case 'London': 
			jQuery('.stat:first-child').data('count', 212);
			jQuery('.stat:nth-child(2)').data('count', 78);
			jQuery('.stat:nth-child(3)').data('count', 3410);
			jQuery('.statistics').statsCounter();
			break;
		case 'Paris': 
			jQuery('.stat:first-child').data('count', 100);
			jQuery('.stat:nth-child(2)').data('count', 25);
			jQuery('.stat:nth-child(3)').data('count', 1410);
			jQuery('.statistics').statsCounter();
			break;
		case 'New York City': 
			jQuery('.stat:first-child').data('count', 510);
			jQuery('.stat:nth-child(2)').data('count', 125);
			jQuery('.stat:nth-child(3)').data('count', 2410);
			jQuery('.statistics').statsCounter();
			break;
	}
	if (place.geometry) {
		map.panTo(place.geometry.location);
		map.setZoom(12);
	} else {
		document.getElementById('search_city').placeholder = 'Stadt';
	}
}


function showAllMarker() {
	setMapOnAll(null);
	showCookingMarker();
	showArtMarker();
	showMusicMarker();
	showOutdoorMarker();
	showHistoryMarker();
}

function filterMarker(skipShow) {
	if(!skipShow)
		showAllMarker();
	
	if(jQuery('[name="personen"]').val() && jQuery('[name="personen"]').val() != 8) {
		jQuery.each(markers_persons, function(marker, persons) {
			if(persons != jQuery('[name="personen"]').val())
				markers[marker].setMap(null);
		});
	}

	if(jQuery('#search_from').val() && jQuery('#search_to').val()) {
		jQuery.each(markers_dates, function(marker, date) {
			if(jQuery.inArray(date, weekdays) > -1) {
				
				if((strtotime(jQuery('#search_to').val()) - strtotime(jQuery('#search_from').val())) <= 604800) {
					
					var start = jQuery("#search_from").datepicker("getDate"),
				    end = jQuery("#search_to").datepicker("getDate"),
				    currentDate = new Date(start.getTime()),
				    between = [],
				    daysOfWeek = [];
		
					while (currentDate <= end) {
						daysOfWeek.push(weekdays[currentDate.getUTCDay()]);
					    currentDate.setDate(currentDate.getDate() + 1);
					}
					
					if(jQuery.inArray(date, daysOfWeek) == -1) {
						markers[marker].setMap(null);
				    }
					
				}
				
			}
		});
	}
	
	if(jQuery('#search_from').val()) {
		jQuery.each(markers_dates, function(marker, date) {
			if(jQuery.inArray(date, weekdays) > -1) return true;
			
			if(strtotime(date) < strtotime(jQuery('#search_from').val()))
				markers[marker].setMap(null);
		});
	}
	if(jQuery('#search_to').val()) {
		jQuery.each(markers_dates, function(marker, date) {
			if(jQuery.inArray(date, weekdays) > -1) return true;
			
			if(strtotime(date) > strtotime(jQuery('#search_to').val()))
				markers[marker].setMap(null);
		});
	}
}

function showMarker(key, latlong, img, msg, persons, date) {
	// Create a marker and set its position.
	markers[key] = new google.maps.Marker({
		map: map,
		position: latlong,
		icon: iconBase + img
	});
	markers_dates[key] = date;
	markers_persons[key] = persons;
	attachSecretMessage(markers[key], msg);
}

function attachSecretMessage(marker, secretMessage) {
	var infowindow = new google.maps.InfoWindow({
		content: secretMessage
	});

	marker.addListener('click', function() {
		infowindow.open(marker.get('map'), marker);
	});
}

function setMapOnAll(map) {
	jQuery.each(markers, function(name, marker) {
		marker.setMap(null);
	});
}

function showCookingMarker() {
	//showMarker('cooking1', {lat: 40.723054, lng: -74.045142}, 'button_cooking_small.png', '<h1>Cooking Event 1</h1><p>gaaaanz viel info</p>');

	// london
	showMarker(
		'cooking_london1', 
		{lat: 51.513105, lng: -0.100045}, 
		'button_cooking_small.png', 
		'<h1>Cooking Event 1</h1><p>gaaaanz viel info</p>', 
		1,
		'02.05.2016'
	);
	
	// new york
	showMarker(
		'cooking1', 
		{lat: 40.713187, lng: -73.991297}, 
		'button_cooking_small.png', 
		'<img src="/wp-content/themes/triperone/images/steven.png" alt="" class="map_popup_img"><h1 class="map_popup_h1">Steven says:</h1><p class="map_popup_p">I would like to invite you to my BBQ-Party tonite. (Offer for 2 persons, Harlem, Open End Event)</p>', 
		2,
		'25.04.2016'
	);
}

function showArtMarker() {
	
	// paris
	showMarker(
		'art_paris1', 
		{lat: 48.855343, lng: 2.344829}, 
		'button_art_small.png', 
		'<img src="/wp-content/themes/triperone/images/marie.png" alt="" class="map_popup_img"><h1 class="map_popup_h1">Marie says:</h1><p class="map_popup_p">Aurevoir mes amis, ….I am offering an unique vernissage of my latest art of pics and sculputers (Pantin, Paris. offer max. people)</p>', 
		4,
		'01.05.2016'
	);
	
	// london
	showMarker(
		'art_london1', 
		{lat: 51.488945, lng: -0.138445}, 
		'button_art_small.png', 
		'<h1>Kunst Event 1</h1><p>gaaaanz viel info</p>', 
		1,
		'28.04.2016'
	);
	showMarker(
		'art_london2', 
		{lat: 51.524945, lng: -0.131445}, 
		'button_art_small.png', 
		'<h1>Kunst Event 1</h1><p>gaaaanz viel info</p>', 
		1,
		'10.05.2016'
	);
	
	// new york
	showMarker(
		'art1', 
		{lat: 40.722794, lng: -73.992785}, 
		'button_art_small.png', 
		'<h1>Kunst Event 1</h1><p>gaaaanz viel info</p>', 
		3,
		'26.04.2016'
	);
}

function showMusicMarker() {
	
	// paris
	showMarker(
		'music1', 
		{lat: 48.835343, lng: 2.424829}, 
		'button_music_small.png', 
		'<h1>Musik Event 1</h1><p>gaaaanz viel info</p>', 
		2,
		'30.06.2016'
	);
	
	// new york
	showMarker(
		'music2', 
		{lat: 40.694529, lng: -73.992668}, 
		'button_music_small.png', 
		'<h1>Musik Event 2</h1><p>gaaaanz viel info</p>', 
		2,
		'12.05.2016'
	);
}

function showHistoryMarker() {
	
	// paris
	showMarker(
		'history_paris1', 
		{lat: 48.865140, lng: 2.433329}, 
		'button_architektur_small.png', 
		'<h1>History Event 1</h1><p>gaaaanz viel info</p>', 
		1,
		'30.04.2016'
	);
	
	// london
	showMarker(
		'history_london1', 
		{lat: 51.518945, lng: -0.158445}, 
		'button_architektur_small.png', 
		'<h1>History Event 1</h1><p>gaaaanz viel info</p>', 
		1,
		'05.05.2016'
	);
	
	// new york
	showMarker(
		'history2', 
		{lat: 40.699307, lng: -74.039735}, 
		'button_architektur_small.png', 
		'<h1>History Event 2</h1><p>gaaaanz viel info</p>', 
		6,
		'01.05.2016'
	);
}

function showOutdoorMarker() {

	// london
	showMarker(
		'outdoor_london1', 
		{lat: 51.508945, lng: -0.128445}, 
		'button_outdoor_small.png', 
		'<img src="/wp-content/themes/triperone/images/gordon.png" alt="" class="map_popup_img"><h1 class="map_popup_h1">Gordon says:</h1><p class="map_popup_p">Hey everbody, on every monday I am jogging thru the Hyde Park – who likes to come with me? (Offer 1 Peron, Hyde Park Meeting Point)</p>', 
		1,
		'monday'
	);
	
	// new york
	showMarker(
		'outdoor1', 
		{lat: 40.694231, lng: -73.996390}, 
		'button_outdoor_small.png', 
		'<h1>Outdoor Event 1</h1><p>gaaaanz viel info</p>', 
		1,
		'01.05.2016'
	);
	showMarker(
		'outdoor2', 
		{lat: 40.737428, lng: -74.030808}, 
		'button_outdoor_small.png', 
		'<h1>Outdoor Event 2</h1><p>gaaaanz viel info</p>', 
		5,
		'15.05.2016'
	);
	
	//showMarker('outdoor2', {lat: 40.703667, lng: -74.011795}, 'button_outdoor_small.png', '<h1>Outdoor Event 2</h1><p>gaaaanz viel info</p>');
}

jQuery(document).ready(function() {
	//jQuery.datepicker.setDefaults($.datepicker.regional['de']);
	jQuery('.datum').datepicker({
		onSelect: function(dateText) {
			filterMarker();
		}
	});
	
	jQuery('#search_today').click(function() {
		jQuery("#search_from").datepicker().datepicker("setDate", new Date());
		jQuery("#search_to").datepicker().datepicker("setDate", new Date());
		filterMarker();
	});
	
	jQuery('#search_reset').click(function() {
		jQuery("#search_from").val('');
		jQuery("#search_to").val('');
		jQuery('[name="personen"]').val('');
		showAllMarker();
	});
	
	jQuery('[name="personen"]').change(function() {
		filterMarker();
	});
	
	jQuery('#search_random').click(function() {
		jQuery("#search_from").datepicker().datepicker("setDate", new Date());
		
		var myDate = new Date();
		var days = Math.floor((Math.random() * 10) + 1);
		var newDate = new Date(myDate.setTime( myDate.getTime() + days * 86400000 ));
		jQuery("#search_to").datepicker().datepicker("setDate", newDate);
		
		jQuery('[name="personen"]').val(Math.floor((Math.random() * 4) + 1));
		
		setMapOnAll(null);
		if(Math.floor((Math.random() * 4) + 1) > 2)
			showCookingMarker();
		if(Math.floor((Math.random() * 4) + 1) > 2)
			showArtMarker();
		if(Math.floor((Math.random() * 4) + 1) > 2)
			showMusicMarker();
		if(Math.floor((Math.random() * 4) + 1) > 2)
			showOutdoorMarker();
		if(Math.floor((Math.random() * 4) + 1) > 2)
			showHistoryMarker();
		
		filterMarker(true);
	});
	
	jQuery('#search_music').click(function() {
		setMapOnAll(null);
		showMusicMarker();
		filterMarker(true);
	});
	
	jQuery('#search_outdoor').click(function() {
		setMapOnAll(null);
		showOutdoorMarker();
		filterMarker(true);
	});
	
	jQuery('#search_art').click(function() {
		setMapOnAll(null);
		showArtMarker();
		filterMarker(true);
	});
	
	jQuery('#search_history').click(function() {
		setMapOnAll(null);
		showHistoryMarker();
		filterMarker(true);
	});
	
	jQuery('#search_cooking').click(function() {
		setMapOnAll(null);
		showCookingMarker();
		filterMarker(true);
	});
});