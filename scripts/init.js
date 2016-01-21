var map;
var timer;

function initMap() {
	var myLatlng = new google.maps.LatLng(50.9301535, 4.5777053);

	var mapOptions = {
		zoom: 14,
		minZoom: 11,
		maxZoom: 17,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		disableDefaultUI: true,
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
		search(address);
	});
	$('#address').keypress(function (e) {
		if (e.which == 13) {
	    	search($(this).val());
	  	}
	});
	$('#searchButton').click(function (e) {
    	search($('#address').val());
	});
	$('#delete').click(function (e) {
		$('#address').val('');
		clearResults();
	})
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
	} else {
		aside.removeClass();
		aside.addClass('asideOpen');
	}
}