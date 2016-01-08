<?php 
session_start();
require_once('db_connect.php');
session_unset();

if(!isset($_SESSION['user']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];

		// if(isset($username, $password)) 
		// {
		// 	$query = "SELECT fu.username, fu.group_id FROM fab_user fu WHERE fu.username = ? and fu.password = ?";
		// 	if($stmt = $conn->prepare($query))
		// 	{
		// 		$stmt->bind_param('ss', $username, $password);
		// 		$stmt->execute();
		// 		$stmt->store_result();
		// 		if($stmt->num_rows > 0)
		// 		{
		// 			$stmt->bind_result($username, $group);
		// 			// $_SESSION['user'] = $username;
		// 		}
		// 	}
		// }
		$query = "SELECT fu.username, fu.group_id as 'group' FROM fab_user fu WHERE fu.username = 'admin' and fu.password = 'admin'";
		$result = $conn->query($query);
		if($result->num_rows == 1)
		{
			$result = $result->fetch_assoc();
			$_SESSION['user'] = $result['username'];
			$_SESSION['group'] = $result['group'];
		}
	}
header('Location: ../index.php');