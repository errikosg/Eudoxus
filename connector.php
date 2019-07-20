<?php
	session_start();
	require('db.php');
	if(isset($_POST['login'])) {
		$email = trim($_POST['email']);
		$psw = md5(trim($_POST['psw']));
		$sql = "SELECT * FROM Users WHERE email= '$email'";
		$result = $db->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			if ($row['password'] == $psw) {
				$_SESSION['id'] = $row['idUsers'];
				$_SESSION['team'] = $row['teamFlag'];
				echo "ok";
			}else {
				echo "O κωδικός που πληκτρολογήσατε δεν είναι σωστός!";
			}
		}else {
			echo "Το email που πληκτρολογήσατε δεν είναι σωστό!";
		}
	}

	if(isset($_POST['signup'])) {
		$email = trim($_POST['email']);
		$psw = md5(trim($_POST['psw']));
		$tm = $_POST['tm'];
		$sql = "SELECT * FROM Users WHERE email= '$email'";
		$result = $db->query($sql);
		if ($result->num_rows > 0) {
			echo "Το e-mail υπάρχει είδη";
		}else {
			$sql = "SELECT max(idUsers) as id FROM Users";
			$result = $db->query($sql);
			$row = $result->fetch_assoc();
			$id = $row['id'] + 1;

			$sql = "INSERT INTO users (idUsers, email, password, teamFlag)
			VALUES ($id,'$email', '$psw', $tm)";
			echo "ok";
			$_SESSION['team'] = $tm;
			$_SESSION['sql'] = $sql;
			$_SESSION['idd'] = $id;
		}
	}

	if(isset($_POST['signup2'])) {
		$sql = $_SESSION['sql'];
		$id = $_SESSION['idd'];
		if($_SESSION['team'] == 1) {
			$fname = trim($_POST['fname']);
			$lname = trim($_POST['lname']);
			$am = trim($_POST['am']);
			$sem = trim($_POST['sem']);
			$dep = trim($_POST['dep']);

			if( $db->query($sql) === TRUE) {
				$sql = "INSERT INTO student (idStudent, FirstName, LastName, AM, CurSem, Departments_id)
						VALUES ($id, '$fname', '$lname', '$am', $sem, $dep)";
				if( $db->query($sql) === TRUE) {
					echo 'ok';
				} else {
					echo "Error updating record: " . $db->error;
				}
			}else {
				echo "Error updating record: " . $db->error;
			}

		}else {
			$name = trim($_POST['name']);
			$phone = trim($_POST['phone']);
			$loc = trim($_POST['loc']);
			$sql2 = "SELECT * FROM Distributor WHERE Name='$name'";
			$result = $db->query($sql2);
			if ($result->num_rows > 0) {
				echo "Το όνομα υπάρχει είδη";
			}else {
				if( $db->query($sql) === TRUE) {
					$sql = "INSERT INTO distributor (idDistributor, Name, Phone, Location)
							VALUES ($id, '$name', '$phone', '$loc')";
					if( $db->query($sql) === TRUE) {
						echo 'ok';
					} else {
						echo "Error updating record: " . $db->error;
					}
				}else {
					echo "Error updating record: " . $db->error;
				}
			}
		}

		$_SESSION['id'] = $id;
	}
	$db->close();
?>
