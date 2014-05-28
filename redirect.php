<?php
session_start();
require_once('config.php');
$mysqli= new mysqli($host,$db_user,$db_password,$db_name);
	
/* check connection */
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
$query="SELECT type FROM nodues_users WHERE username='$_REQUEST[user]' AND password='$_REQUEST[pass]'";
if (($result=$mysqli->query($query)) && ($row=$result->fetch_array())) {
	if ($row[type]=='h'){
		header('Location: hostel.php');
		$_SESSION["user"]='h';
	}
	else if ($row[type]=='l'){
		header('Location: library.php');
		$_SESSION["user"]='l';
	}
	else if ($row[type]=='r'){
		header('Location: registrar.php');
		$_SESSION["user"]='r';
	}
} else
	echo "<h1>Wrong username/password. <br>Please go back and try again...</h1><br><a href=\"index.php\">Back</a>";
?>