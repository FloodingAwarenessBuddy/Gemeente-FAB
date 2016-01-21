<?php 
require_once('functions.php');
require_once('db_connect.php');

$fab = new fab();
// $search = new search();

switch($_POST['funct']) 
{
	case 'search':
		if (isset($_POST['search']) && !empty($_POST['search'])) {
			echo(search($_POST['search']));		
		}
		break;
	case 'getFabs':
		if(isset($_POST['leftUpperBounds'], $_POST['rightLowerBounds']) && !empty($_POST['leftUpperBounds']) && !empty($_POST['rightLowerBounds'])) {
			echo($fab->getFabs($_POST['leftUpperBounds'], $_POST['rightLowerBounds'], $conn));
		}
		break;
	case 'createFab':
		if (
			isset(	$_POST['address'],
					$_POST['location'],
					$_POST['name'],
					$_POST['imageURL'])
			&& 
			!empty($_POST['address']) &&
			!empty($_POST['location']) &&
			!empty($_POST['name']) &&
			!empty($_POST['imageURL'])) {
			$fab->createFab($_POST['address'], $_POST['location'], $_POST['name'],$_POST['imageURL'], $_SESSION['group']);
		}
		break;
	case 'getStatus':
		echo($fab->getStatus($_POST['id'], $conn));
	break;
}

function error($msg) {
	// error handling
}

function Validation($type, $msg) {

}