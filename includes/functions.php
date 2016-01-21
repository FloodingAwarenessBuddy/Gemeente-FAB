<?php 
session_start();

class fab
{
	function __construct()
	{

	}

	public function getFabs($leftUpperBounds, $rightLowerBounds, $conn) 
	{
		$array =[];
		$query = "	SELECT f.id, f.name, f.imgURL as image, fa.street, fa.number, fa.city, fa.postalCode, fa.city, fa.country, fl.lat, fl.lng FROM fab_fab f
						INNER JOIN (".PREFIX."address fa
							INNER JOIN ".PREFIX."location fl
					        ON fl.id = fa.location_id)
						ON f.address_id = fa.id
					WHERE (fl.lat BETWEEN ".$leftUpperBounds['lat']." and ".$rightLowerBounds['lat'].") and (fl.lng BETWEEN ".$rightLowerBounds['lng']." and ".$leftUpperBounds['lng'].")";
		$result = $conn->query($query);
		if($result->num_rows == 1)
		{
			$result = [$result->fetch_assoc()];
		}
		foreach ($result as $val)
		{
			$query = "SELECT 
					fr.id, fr.date, fr.height, group_CONCAT(fs.name) as name FROM fab_result fr
						INNER JOIN (fab_fab_has_result fhr
							INNER JOIN fab_fab f
					        ON f.id = fhr.fab_id)
						ON fhr.results_id = fr.id
						INNER JOIN (fab_result_has_status fhs
							INNER JOIN fab_status fs
					        ON fs.id = fhs.status_id)
						ON fr.id = fhs.result_id
					    WHERE f.id = ".$val['id']."
					    group by fr.id
					    ORDER BY fr.date DESC
					    LIMIT 8";
			$fabResults = $conn->query($query);
			$fabResultsArray = [];
			if($fabResults->num_rows > 0) {
				foreach($fabResults as $v) 
				{
					$s = $v['date'];
					$dt = new DateTime($s);

					$date = $dt->format('m/d/Y');
					$time = $dt->format('H:i:s');
					$status = explode(',', $v['name']);
					array_push($fabResultsArray, [
						'date' => [
							'fullDate' => $v['date'],
							'date' => $date,
							'time' => $time],
						'height' => $v['height'],
						'status' => $status]);
				}

				array_push($array, [
					'id' => $val['id'],
					'name' => $val['name'],
					'location' => [
						'lng' => $val['lng'],
						'lat' => $val['lat']],
					'address' => [
						'city' => $val['city'],
						'number' => $val['number'],
						'street' => $val['street'],
						'postalCode' => $val['postalCode'],
						'country' => $val['country']],
					'image' => $val['image'],
					'status' => $fabResultsArray]);
				}
			}
		$array = json_encode($array);
		return $array;
	}

	public function createFab($address, $location, $name, $imgURL, $group) 
	{
		$query = "INSERT INTO ".PREFIX."user (username, email, password, firstName, lastName, adress_id, group_id)
				VALUES (?, ?, ?, ?, ?, ?, ?)"; 
	}

	private function addAddress ($street, $city, $number, $postalCode, $country, $location) 
	{

	}

	public function getStatus($id, $conn) 
	{
		$query = "SELECT 
					fr.id, fr.date, fr.height, group_CONCAT(fs.name) as name FROM fab_result fr
						INNER JOIN (fab_fab_has_result fhr
							INNER JOIN fab_fab f
					        ON f.id = fhr.fab_id)
						ON fhr.results_id = fr.id
						INNER JOIN (fab_result_has_status fhs
							INNER JOIN fab_status fs
					        ON fs.id = fhs.status_id)
						ON fr.id = fhs.result_id
					    WHERE f.id = ".$id."
					    group by fr.id
					    ORDER BY fr.date DESC
					    LIMIT 8";
		$result = $conn->query($query);
		$fabResultsArray = [];
		if($result->num_rows == 1)
		{
			$result = [$result->fetch_assoc()];
		}
		foreach($result as $v) 
		{
			$s = $v['date'];
			$dt = new DateTime($s);

			$date = $dt->format('m/d/Y');
			$time = $dt->format('H:i:s');
			$status = explode(',', $v['name']);
			array_push($fabResultsArray, [
				'date' => [
					'fullDate' => $v['date'],
					'date' => $date,
					'time' => $time],
				'height' => $v['height'],
				'status' => $status]);
		}
		return json_encode($fabResultsArray);
	}
}

function search($address)
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