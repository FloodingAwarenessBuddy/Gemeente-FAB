<?php 
require_once('db_connect.php');

class fab
{
	function __construct()
	{

	}

	public function getLocation($address) 
	{
		$address = str_replace(' ', '+', $address);
		$url = 'https://maps.googleapis.com/maps/api/geocode/json';
		$results = file_get_contents($url.'?address='.$address.'&components=country:NL');
		$results = json_decode($results);
		$array = [];
		foreach ($results->results as $key => $value) 
		{
			array_push($array, [
				"fullName" => $value->address_components[0]->long_name,
				"location" => [
					'lng' => $value->geometry->location->lng,
					'lat' => $value->geometry->location->lat
				],
				"placeId" => $value->place_id,
				"fullAdress" => $value->formatted_address,
				]);
		}
		$array = json_encode($array);
		return $array;
	}

	public function getFabs($bounds) {
		
	}
}