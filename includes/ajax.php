<?php 
require_once('settings.php');
require_once('functions.php');

$fab = new fab();

switch($_POST['funct']) 
{
	case 'getLocation':
		echo($fab->getLocation($_POST['address']));
		break;
	case 'getFabs':
		echo($fab->getFabs($_POST['bounds']))
}