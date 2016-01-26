$(init);

function init () {
	$('#geolocation').click(function () {
		if(navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function (position) {
				$('#lat').val(position.coords.latitude);
				$('#lng').val(position.coords.longitude);
			});
		}
	});
}