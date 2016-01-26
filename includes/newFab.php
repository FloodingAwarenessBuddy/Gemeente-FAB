<?php 
require_once('functions.php');
require_once('db_connect.php');

$fab = new fab();

if(isset($_POST['name'], 
	$_POST['id'], 
	$_POST['lat'],
	$_POST['lng'],
	$_POST['street'],
	$_POST['number'],
	$_POST['city'],
	$_POST['postalCode']) && !empty($_POST['name']) && !empty($_POST['lat']) && !empty($_POST['lng']))
	{
		foreach ($_POST as $value) 
		{
			if (empty($value)) 
			{
				$value = null;
			}
		}
		$address = ['location' => ['lat' => floatval($_POST['lat']), 'lng' => floatval($_POST['lng'])],
		'street' => htmlentities($_POST['street']), 'number' => htmlentities($_POST['number']), 'city'=> htmlentities($_POST['city']), 'postalCode' => htmlentities($_POST['postalCode'])];
		$fab->createFab($address, htmlentities($_POST['name']), $_POST['id'], $conn);
	}
	else {
		header('location: ../newFab.php');
	}