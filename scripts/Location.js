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
			leftUpperBounds		: {"lat" : bounds.R.R, "lng" : bounds.j.R},
			rightLowerBounds	: {"lat" : bounds.R.j, "lng" : bounds.j.j},
			funct		: 'getFabs'	
		},
		dataType: 'json'
	})
	.done(function(output) {
		$.each(output, function(k,v) {
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

setInterval(function () {
		if(fabs.length > 0)
		{
			$.each(fabs, function (k,v) {
				v.liveInfo();
			})
		}
	}, 3000)

