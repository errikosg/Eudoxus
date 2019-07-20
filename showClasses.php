<?php
	require('db.php');
	session_start();
	$uid = $_SESSION['id'];
	$sem = trim($_REQUEST["opt"]);
	//find department
	$init = "SELECT * FROM Student WHERE idStudent = '$uid'";
	$res = $db->query($init);
	$user = $res->fetch_assoc();
	$dep_id = $user["Departments_id"];
	$uni = 1;

	$sql = "SELECT * FROM Classes WHERE Semester = '$sem'";
	$result = $db->query($sql);
	if($result->num_rows > 0) {
		$lines = $result->num_rows;
		$index = 1;

		while($lines > 0) {
			$row = $result->fetch_assoc();
			echo '<li href="#" class="list-group-item flex-column align-items-start">
			<p class="mb-2"><span class="font-weight-bold">Μάθημα</span>: ' . $row["Name"] . '</p><p class="mb-2">Εξάμηνο: ' . $sem . '</p>
			<button class="btn btn-success dropdown-toggle text-light" type="button" onclick="showInner(' . $index . ')"
			style="width:150px;font-size:80%display:block" id="changeBttn">Συγγράμματα <span class="caret"></span></button>
			</div><br><br><hr><div id="res_div' . $index . '" style="display:none;"><ul>';

			$cid = $row["idClasses"];
			$sql2 = "SELECT * FROM Classes_has_Book WHERE Classes_idClasses = '$cid'";
			$result2 = $db->query($sql2);
			$lines2 = $result2->num_rows;
			$index2 = 1;
			while($lines2 > 0){
				$row2 = $result2->fetch_assoc();
				$bid = $row2["idBooks"];
				$sql3 = "SELECT * FROM Books WHERE idBooks = '$bid'";
				$result3 = $db->query($sql3);
				$row3 = $result3->fetch_assoc();

				echo '<li><span class="checkbox" style="font-size:400%;float:right">
				<label><input type="checkbox" name="check" value="' . $row3["idBooks"] . '"class="check' . $index . '" id="check' . $index2 . '" onclick="fixOther(this.className, this.id)"></label>
				</span><p class="mb-2"><span class="text-primary">Σύγγραμμα ' . $index2 . '</span>: ' . $row3["Title"] . ' </p>
				<p class="mb-2">Συγγραφέας: ' . $row3["Author"] . '</p><p class="mb-2">Εκδόσεις: ' . $row3["Publication"] . '</p><p class="mb-2">ISBN:
				' . $row3["ISBN"] . '</p></li><hr>';

				$index2 += 1;
				$uni += 1;
				$lines2 -= 1;
			}
			echo "</ul></div></li>";
			$index += 1;
			$lines -= 1;
		}
	}

	$db->close();
	return;
?>
