var fabs = [];

function search (search) {
	$.ajax({
		url: 'includes/ajax.php',
		method: 'POST',
		data: {
			search		: search,
			funct		: 'search'	
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
					getFabs();
					toggleOpen('close');}));
		})
	})
	.fail(function(output) {
		console.log(output)
	})
}

function zoom(lng, lat) {
	var location = new google.maps.LatLng(lat, lng);
	map.setCenter(location);
}

function getFabs() {
	var bounds = map.getBounds();
	$.ajax({
		url: 'includes/ajax.php',
		method: 'POST',
		data: {
			leftUpperBounds		: {"lat" : bounds.N.N, "lng" : bounds.j.N},
			rightLowerBounds	: {"lat" : bounds.N.j, "lng" : bounds.j.j},
			funct		: 'getFabs'	
		},
		dataType: 'json'
	})
	.done(function(output) {
		$.each(output, function(k,v) {
			console.log(v);
			var fabOutput = new fab(v);
			fabOutput.placeMarker();
			fabs.push(fabOutput);
		})
	})
	.fail(function(output) {
		console.log(output);
	})
}

function clearResults() {
	var results = $('#results');
	results.empty();
}

function placeMarker(data) {
	var results = $('#results');
	var locationMarker = {lat: parseFloat(data.location.lat), lng: parseFloat(data.location.lng)};

	var marker = new google.maps.Marker({
		position: locationMarker,
		map: map,
		title: data.name
	})

	marker.addListener('click', function() {
		toggleOpen('open');
		clearResults();
		results.append($('<p>', {text: "Alles is in orde"}))
		results.append($('<p>', {text: "Adres: " + data.address.city + ' - ' + data.address.street + ' - ' + data.address.number}))
	})
}

