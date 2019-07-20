<?php
	session_start();
	require('db.php');
	$id = $_SESSION['id'];
	$team = $_SESSION['team'];
	if( $team == 1) {
		$email = trim($_POST['email']);
		$oldPass = md5(trim($_POST['oldPass']));
		$newPass = md5(trim($_POST['newPass']));
		$fname = trim($_POST['fname']);
		$lname = trim($_POST['lname']);
		$am = trim($_POST['am']);
		$sem = trim($_POST['sem']);

		$sql = "SELECT * FROM Users WHERE idUsers=$id";
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		if( $oldPass != md5("") && $row['password'] != $oldPass ) {
			echo "O κωδικός που πληκτρολογήσατε δεν είναι σωστός!";
			return;
		}

		if( $email != $row['email']) {
			$sql = "SELECT * FROM Users WHERE email='$email'";
			$result = $db->query($sql);
			if ($result->num_rows > 0) {
				echo "Το email που πληκτρολογήσατε υπάρχει είδη!";
				return;
			}
		}

		if( $oldPass == md5("") ) {
			$newPass = $row['password'];
		}
		$sql = "UPDATE users SET email='$email', password='$newPass' WHERE idUsers=$id";
		if( $db->query($sql) === TRUE) {
			$sql = "UPDATE student SET FirstName='$fname', LastName='$lname', AM='$am', CurSem=$sem WHERE idStudent=$id";
			if( $db->query($sql) === TRUE) {
				echo 'ok';
			} else {
				echo "Error updating record: " . $db->error;
			}
		}else {
			echo "Error updating record: " . $db->error;
		}
	}

	if( $team == 2) {
		$email = trim($_POST['email']);
		$oldPass = md5(trim($_POST['oldPass']));
		$newPass = md5(trim($_POST['newPass']));
		$name = trim($_POST['name']);
		$phone = trim($_POST['phone']);
		$loc = trim($_POST['loc']);

		$sql = "SELECT * FROM Users WHERE idUsers=$id";
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		if( $oldPass != md5("") && $row['password'] != $oldPass ) {
			echo "O κωδικός που πληκτρολογήσατε δεν είναι σωστός!";
			return;
		}

		if( $email != $row['email']) {
			$sql = "SELECT * FROM Users WHERE email='$email'";
			$result = $db->query($sql);
			if ($result->num_rows > 0) {
				echo "Το email που πληκτρολογήσατε υπάρχει είδη!";
				return;
			}
		}

		if( $oldPass == md5("") ) {
			$newPass = $row['password'];
		}
		$sql = "UPDATE users SET email='$email', password='$newPass' WHERE idUsers=$id";
		if( $db->query($sql) === TRUE) {
			$sql = "UPDATE distributor SET Name='$name', Phone='$phone', Location='$loc' WHERE idDistributor=$id";
			if( $db->query($sql) === TRUE) {
				echo 'ok';
			} else {
				echo "Error updating record: " . $db->error;
			}
		}else {
			echo "Error updating record: " . $db->error;
		}
	}
	$db->close();
?>
