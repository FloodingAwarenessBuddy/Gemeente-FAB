function getLocation (address) {
	$.ajax({
		url: 'includes/ajax.php',
		method: 'POST',
		data: {
			address		: address,
			funct		: 'getLocation'	
		},
	})
	.done(function(output) {
		output = $.parseJSON(output)
		var results = $('#results');
		console.log(output);
		clearResults();
		toggleOpen('open');
		$.each(output, function(k,v){
			results.append($('<li>', {class: 'place'})
				.attr('data-lng', v.location.lng)
				.attr('data-lat', v.location.lat)
				.append($('<h2>', {class: 'placeTitle', text: v.fullName}))
				.append($('<p>', {class: 'placeAddress', text: v.fullAdress}))
				.on('click', function (e){
					zoom($(this).data('lng'), $(this).data('lat'));
					getFabs();}));
		})
	})
	.fail(function(output) {
		console.log(output)
	})
}

function zoom(lng, lat) {
	var location = new google.maps.LatLng(lat, lng);
	map.setCenter(location);
	$.getJSON("data/fab.json", function(data) {
			placeMarker(data);
		})
}

function getFabs() {
	var bounds = map.getBounds();
	$.ajax({
		url: 'includes/ajax.php',
		method: 'POST',
		data: {
			bounds		: bounds,
			funct		: 'getFabs'	
		},
	})
	.done(function(output) {
		output = $.parseJSON(output);
	})
}

function clearResults() {
	var results = $('#results');
	results.empty();
}

function fab(data) {
	this.lng 		= data.location.lng;
	this.lat 		= data.location.lat;
	this.address 	= data.address;
	this.status 	= data.status;
	this.name 		= data.name
	this.results 	= $('#results');

	this.placeMarker = function () {
		var locationMarker = {lat: data.location.lat, lng: data.location.lng};
		var marker = new google.maps.Marker({
			position: locationMarker,
			map: map,
			title: "Fab-1234"
		})

		marker.addListener('click', function() {
			toggleOpen('open');
			clearResults();
			results.append($('<p>', {text: this.status}))
			results.append($('<p>', {text: "Adres: " + this.address.City + ' - ' + this.address.Street + ' - ' + this.address.Number}))
		})
	}

	this.zoom = function () {
		var location = new google.maps.LatLng(lat, lng);
		map.setCenter(location);
	}
}














function placeMarker(data) {
	var results = $('#results');
	var locationMarker = {lat: data.location.lat, lng: data.location.lng};

	var marker = new google.maps.Marker({
		position: locationMarker,
		map: map,
		title: "Fab-1234"
	})

	marker.addListener('click', function() {
		toggleOpen('open');
		clearResults();
		results.append($('<p>', {text: "Alles is in orde"}))
		results.append($('<p>', {text: "Adres: " + data.address.City + ' - ' + data.address.Street + ' - ' + data.address.Number}))
	})
}

