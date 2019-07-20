<?php
	$file = fopen("myinfo.txt", "r") or die("Unable to open info file!");
	$servername = trim(fgets($file));
	$username = trim(fgets($file));
	$dbname = trim(fgets($file));
	$password = trim(fgets($file));

	//Create connection
	$db = new mysqli($servername, $username, $password, $dbname);
	mysqli_set_charset($db, "utf8");

	//Check connection
	if($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	}
?>
