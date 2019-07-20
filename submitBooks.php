<?php
	require('db.php');
	session_start();
	$uid = $_SESSION['id'];
	
	$res = trim($_REQUEST["res"]);
	$token = strtok($res, ",");
	while ($token !== false){
		$bid = (int)$token;
		$sql = "INSERT INTO history (Student_id, idBooks) VALUES ('$uid', '$bid')";
		$result = $db->query($sql);
		$token = strtok(",");
	} 	
	echo "ok";
	$db->close();
?>