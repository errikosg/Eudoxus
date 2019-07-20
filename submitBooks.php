<?php
	require('db.php');
	session_start();
	$uid = $_SESSION['id'];
	$_SESSION['declared_books'] = 1;

	$res = trim($_REQUEST["res"]);
	$token = strtok($res, ",");
	while ($token !== false){
		$bid = (int)$token;
		echo $bid;
		$sql = "INSERT INTO History (Student_id, idBooks) VALUES ('$uid', '$bid')";
		$result = $db->query($sql);
		$token = strtok(",");
	}
	echo "ok";
	$db->close();
?>
