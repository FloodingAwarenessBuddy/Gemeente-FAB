var fab = function (data) {
	this.id			= parseInt(data.id);
	this.lng 		= parseFloat(data.location.lng);
	this.lat 		= parseFloat(data.location.lat);
	this.address 	= data.address;
	this.status 	= data.status.reverse();
	this.name 		= data.name
	this.results 	= $('#results');
	this.height		= data.status[data.status.length-1].height;
	this.message	= ['Het water heeft een normale stand.', 'De waterstand staat redelijk hoog, kan in de toekomst overstromen', 'Put is overstroomd.'];
	this.marker;
	this.customMarker = ["image/marker-green.png", "image/marker-yellow.png", "image/marker-red.png"];
	this.myLineChart = null;
}

fab.prototype.placeMarker = function () {
		var locationMarker = {lat: this.lat, lng: this.lng};
		var fab = this;

		if(fab.status.length > 0)
		{
			var length = fab.status.length;
			fab.height = parseInt(fab.status[length-1].height);
		}

		fab.marker = new google.maps.Marker({
			position: locationMarker,
			map: map,
			title: fab.name,
			icon: fab.customMarker[fab.height-1]
		})

		fab.marker.addListener('click', function() {
			toggleOpen('open');
			clearResults();
			fab.createInfo();
		})
	}

fab.prototype.createInfo = function () {
	var fab = this;
	var html = "<div id=\"results\"><div class=\"fab\"><h2 class=\"title\">"+fab.name+"</h2><div><div id=\"address\"><h3>Adres</h3><p>";
							if(fab.address.street != null) {
								html += "<strong>Straat:</strong> "+fab.address.street+" <br>";
							}
							if(fab.address.city != null) {
								html += "<strong>Stad:</strong> "+fab.address.city+" <br>";
							}
							if(fab.address.postalCode != null) {
								html += "<strong>Postcode:</strong> "+fab.address.postalCode+" <br>";
							}
							if(fab.address.country != null) {
								html += "<strong>Land:</strong> "+fab.address.country+" <br>";
							}
						html += "</p></div><div id=\"status\">";
						if(typeof fab.status[0] != 'undefined') {
							html += '<h3>Status</h3><p>'+fab.message[fab.height]+'</p>';
						}
						html +="</div><canvas id=\"chart\"></canvas></div></div>"
	fab.results.html(html);
	var date = [];
	$.each(fab.status, function(k,v) {
		date.push(v.date.fullDate);
	});
	var height = [];
	$.each(fab.status, function(k,v) {
		height.push(parseInt(v.height));
	});
	fab.createChart(height, date);
}

fab.prototype.createChart = function(height, date)
{
	var fab = this;
	if(fab.myLineChart != null) {
		fab.myLineChart.destroy();
	}

	var ctx = $("#chart").get(0).getContext("2d");
	var myNewChart = new Chart(ctx);

	var data = {
	    labels: date,
	    datasets: [
	        {
	            label: "My First dataset",
	            fillColor: "rgba(220,220,220,0.2)",
	            strokeColor: "rgba(220,220,220,1)",
	            pointColor: "rgba(220,220,220,1)",
	            pointStrokeColor: "#fff",
	            pointHighlightFill: "#fff",
	            pointHighlightStroke: "rgba(220,220,220,1)",
	            data: height
	        },
	    ],
	};

	var options = {
		scaleLabel : "<%= value.replace('1', 'Laag').replace('2', 'Middel').replace('3', 'Hoog')%>",
		tooltipTemplate: "<% if(value == 1) {%><%= 'Laag' %><%}%><% if(value == 2) {%><%= 'Gemiddeld' %><%}%><% if(value == 3) {%><%= 'Hoog' %><%}%>"
	}

	fab.myLineChart = new Chart(ctx).Line(data, options);
}

fab.prototype.liveInfo = function () {
	var fab = this;
	$.ajax({
		url: 'includes/ajax.php',
		method: 'POST',
		dataType: 'json',
		data: {
			funct: 'getStatus',
			id: fab.id
		}
	}).done(function(output) {
		output = output.reverse();
		var height = [];
		$.each(output, function(k,v) {
			height.push(parseInt(v.height));
		});
		var date = [];
		$.each(output, function(k,v) {
			date.push(v.date.fullDate);
		});
		if(fab.status[fab.status.length-1].date.fullDate != date[date.length-1]) {
			fab.status = output;
			fab.createChart(height, date);
		}
		fab.marker.setIcon(fab.customMarker[parseInt(output[output.length-1].height-1)]);
	}).fail(function(output) {
		console.log(output);
	})
}

fab.prototype.zoom = function () {
		var location = new google.maps.LatLng(lat, lng);
		map.setCenter(location);
	}
