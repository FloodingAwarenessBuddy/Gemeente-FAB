var fab = function (data) {
	this.lng 		= parseFloat(data.location.lng);
	this.lat 		= parseFloat(data.location.lat);
	this.address 	= data.address;
	this.status 	= data.status;
	this.name 		= data.name
	this.results 	= $('#results');
	this.height		= 1;
	this.message	= ['Het water is op een heel laag niveau.', 'het water staat gemiddeld hoog.', 'Het water staat gevaarlijk hoog.']
}

fab.prototype.placeMarker = function () {
		var locationMarker = {lat: this.lat, lng: this.lng};
		var fab = this;

		var customMarker = ["image/marker-green.png", "image/marker-yellow.png", "image/marker-red.png"]

		if(fab.status.length > 0)
		{
			fab.height = parseInt(fab.status[0].height);
		}

		var marker = new google.maps.Marker({
			position: locationMarker,
			map: map,
			title: fab.name,
			icon: customMarker[fab.height-1]
		})

		marker.addListener('click', function() {
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
							html += '<h3>Status</h3><p>'+fab.message[fab.height-1]+'</p>';
						}
						html +="</div><canvas id=\"chart\"></canvas></div></div>"
	fab.results.html(html);
	var ctx = $("#chart").get(0).getContext("2d");
	var myNewChart = new Chart(ctx);

	var date = [];
	$.each(fab.status, function(k,v) {
		date.push(v.date.fullDate);
	});
	console.log(date);
	var height = [];
	$.each(fab.status, function(k,v) {
		height.push(parseInt(v.height));
	});
	console.log(height);
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

	var myLineChart = new Chart(ctx).Line(data, options);
}

fab.prototype.zoom = function () {
		var location = new google.maps.LatLng(lat, lng);
		map.setCenter(location);
	}
