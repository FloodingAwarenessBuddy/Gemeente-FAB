var map;

function initMap() {
	var myLatlng = new google.maps.LatLng(51.9301505, 4.5777053);

	var mapOptions = {
		zoom: 14,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		disableDefaultUI: true,
		scrollwheel: false,
	    navigationControl: false,
	    mapTypeControl: false,
	    scaleControl: false,
	};
	map = new google.maps.Map(document.getElementById("map"), mapOptions);
}

$(init);

function init() {
	$('#opener').on('click', function () { toggleOpen('')});
	$('#searchButton').on('click', function (){
		var address = $('#address').val();
		getLocation(address);
	});
	$('#address').keypress(function (e) {
		if (e.which == 13) {
			console.log('test')
	    	getLocation($(this).val());
	  	}
	});
}

function toggleOpen (condition) {
	var aside = $('#menu');
	if (condition == "close") {
		aside.removeClass('asideOpen');
		aside.addClass('asideClose');
	} else if (condition == "open") {
		aside.removeClass('asideClose');
		aside.addClass('asideOpen');
	} else if(aside.hasClass('asideOpen')) {
		aside.removeClass('asideOpen');
		aside.addClass('asideClose');
	} else if (aside.hasClass('asideClose')) {
		aside.removeClass('asideClose');
		aside.addClass('asideOpen');
	}
}