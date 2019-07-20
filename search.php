<?php
	require('db.php');
	$search = trim($_REQUEST["sname"]);
	$option = trim($_REQUEST["opt"]);
	if($option == 1){
		$sql = "SELECT * FROM Books WHERE Title LIKE '$search%'";
	}
	else{
		$sql = "SELECT * FROM Books WHERE Author LIKE '$search%'";
	}
	$result = $db->query($sql);
	if($result->num_rows > 0) {
		$lines = $result->num_rows;
		$counter=1;
		while($lines > 0) {
			$row = $result->fetch_assoc();

			//find distributor
			$bid = $row["idBooks"];
			$sql2 = "SELECT * FROM Distributor_has_Book WHERE idBooks = '$bid'";
			$result2 = $db->query($sql2);
			$row2 = $result2->fetch_assoc();
			$did = $row2["idDistributor"];
			$sql3 = "SELECT * FROM Distributor WHERE idDistributor = '$did'";
			$result3 = $db->query($sql3);
			$row3 = $result3->fetch_assoc();

			echo '<li href="#" class="list-group-item list-group-item-action flex-column align-items-start">
			<div class="d-flex w-100 justify-content-between"> <h5 class="mb-1 text-primary">' . $counter . '. ' . $row["Title"] . '</h5></div>
			<p class="mb-2">Συγγραφέας: ' . $row["Author"] . '</p><p class="mb-2">Εκδόσεις: ' . $row["Publication"] . '</p><p class="mb-2">ISBN:
			 ' . $row["ISBN"] . '</p><p>Διανομέας: ' . $row3["Name"] . '</p><p>Σημείο Πώλησης: ' . $row3["Location"] . '</p></li>';
			$lines -= 1;
			$counter += 1;
		}
	}
	$db->close();
?>
