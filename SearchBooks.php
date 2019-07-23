<?php
	session_start();
	require('db.php');
	if (isset($_SESSION['id'])) {
		$id = trim($_SESSION['id']);
		$name = "ΧΡΗΣΤΗΣ";
		if ($_SESSION['team'] == 1) {
			$sql = "SELECT * FROM Student WHERE idStudent = $id";
			$result = $db->query($sql);
			$row = $result->fetch_assoc();
			if($row['FirstName'] != null) {
				$name = $row['FirstName'];
			} else {
				$name = $row['LastName'];
			}
			$tabs = "<li class='nav-item dropdown'>
						<a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='cursor:pointer;'>
							 $name
						</a>
						<div class='dropdown-menu' aria-labelledby='navbarDropdown'>
							<a class='dropdown-item' href='profile.php'>ΠΡΟΦΙΛ</a>
							<a class='dropdown-item' href='declare.php'>ΔΗΛΩΣΗ ΣΥΓΡΑΜΜΑΤΩΝ</a>
							<a class='dropdown-item' href='#'>ΙΣΤΟΡΙΚΟ ΔΗΛΩΣΕΩΝ</a>
							<div class='dropdown-divider'></div>
							<a class='dropdown-item' href='?logout==yes'>ΕΞΟΔΟΣ</a>
						</div>
				</li>";
		} else {
			$id = trim($_SESSION['id']);
			$sql = "SELECT * FROM Distributor WHERE idDistributor = $id";
			$result = $db->query($sql);
			$row = $result->fetch_assoc();
			$name = $row['Name'];
			$tabs = "<li class='nav-item dropdown'>
						<a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='cursor:pointer;'>
							$name
						</a>
						<div class='dropdown-menu' aria-labelledby='navbarDropdown'>
							<a class='dropdown-item' href='profile.php'>ΠΡΟΦΙΛ</a>
							<a class='dropdown-item' href='bookDelivery.php'>ΠΑΡΑΔΟΣΗ ΣΥΓΓΡΑΜΜΑΤΟΣ</a>
							<a class='dropdown-item' href='bookReserve.php'>ΑΠΟΘΕΜΑ</a>
							<a class='dropdown-item' href='#'></a>
							<div class='dropdown-divider'></div>
							<a class='dropdown-item' href='?logout==yes'>ΕΞΟΔΟΣ</a>
						</div>
				</li>";
		}
	} else {
		$tabs = "<li class=\"nav-item\">
					<a class=\"nav-link\" href=\"logIn.php\">ΕΙΣΟΔΟΣ/ΕΓΓΡΑΦΗ</a>
				</li>";
	}
	if(isset($_GET['logout'])=='yes') {
		session_destroy();
		header("Location: index.php");
	}
	$db->close();
?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="general.css">

	<title>Εύδοξος</title>
</head>

<body>
	<!--NAVIGATION BAR -->
	<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top box" style="overflow:visible">
		<div class="container-fluid">
			<a class="navbar-brand" href="index.php">
				<img src="./imgs/eudoxus-logo.png" alt="Εύδοξος" title="Επιστροφή στην αρχική">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto">
					<?php echo $tabs;?>
					<li class="nav-item">
						<a class="nav-link" id="news_link" href="News.php">ΑΝΑΚΟΙΝΩΣΕΙΣ<a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" id="search_link" href="SearchBooks.php">ΑΝΑΖΗΤΗΣΗ ΣΥΓΓΡΑΜΜΑΤΩΝ</a>
					</li
					<li class="nav-item">
						<a class="nav-link" id="about_link" href="About.php">ΧΡΗΣΙΜΑ</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container mt-5 mb-4" id="cont">
		<h4 class="text-dark text-center">AΝΑΖΗΤΗΣΗ ΣΥΓΓΡΑΜΜΑΤΩΝ</h4><br>
		<div class="form-group border rounded">
			<input type="text" onkeyup="showHint(this.value)" placeholder="Αναζήτηση..." class="form-control border rounded" id="sr">
		</div>


		<div class="container">
			<div class="row">
			<div class="col-sm-6 dropdown" style="padding-left:0px">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="width:150px;" id="changeBttn"> Τίτλος <span class="caret"></span></button>
				<span style="font-style:italic" class="text-muted ml-2" id="description">Αναζήτηση με βάση τον τίτλο </span>
				<ul class="dropdown-menu p-2">
					<li class="options" id="option1" onclick="changeSearch(this.id)" style="cursor:pointer"><a href="#" style="text-decoration:none">Συγγραφέας</a></li>
				</ul>
			</div>
			<div class="col-sm-6" style="padding-left:0px">
				<button class="btn btn-primary" type="button" onclick="gotoAll()" style="width:150px;position:absolute;right:0px;">Όλα τα βιβλία</button>
			</div>
		</div>

		<div class="container-fluid mt-5 p-2">
			<ul class="list-group border rounded" id="results" style="display:none">
			</ul>
		</div>
	</div><br><br><br><br>

	<script>
		function showHint(str){
			//ajax
			var xhttp = new XMLHttpRequest();
			//clear whitespace at the beginning
			while(str.indexOf(' ') == 0){
				str = str.replace(/\s/, '');
			}
			if(str == ""){
				var x = document.getElementById("results");
				x.innerHTML = "";
				x.style.display = "none";
				return;
			}
			/*else{
				var x = document.getElementById("results");
				x.style.display = "block";
			}*/
			//check search condition
			var check_opt = document.getElementsByClassName("options")[0]; var opt;
			if(check_opt.id == "option1"){
				opt=1;
			}
			else{
				opt=2;
			}
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					//document.getElementById("results").innerHTML = this.responseText;
					console.log(this.responseText + ".")
					if (this.responseText){
						var x = document.getElementById("results");
						x.style.display = "block";
						x.innerHTML = this.responseText;
					}
			    }
			};
			xhttp.open("POST", "search.php?sname=" + str + "&opt=" + opt, true);
			xhttp.send();
		}

		function changeSearch(option){
			//clear space
			var sr = document.getElementById("sr");
			sr.value = "";
			var res = document.getElementById("results");
			res.innerHTML = "";
			res.style.display = "none";

			if(option == "option1"){
				var bttn = document.getElementById("changeBttn");
				bttn.innerHTML = "Συγγραφέας";
				var des = document.getElementById("description");
				des.innerHTML = "Αναζήτηση με βάση τον συγγραφέα";
				var opt1 = document.getElementById("option1");
				opt1.innerHTML = '<a href="#" style="text-decoration:none">Τίτλος</a>';
				opt1.id = "option2";
			}
			else if(option == "option2"){
				var bttn = document.getElementById("changeBttn");
				bttn.innerHTML = "Τίτλος";
				var des = document.getElementById("description");
				des.innerHTML = "Αναζήτηση με βάση τον τίτλο";
				var opt2 = document.getElementById("option2");
				opt2.innerHTML = '<a href="#" style="text-decoration:none">Συγγραφέας</a>';
				opt2.id = "option1";
			}
		}

		function gotoAll(){
			window.location = "allBooks.php"
		}
	</script>
</body>
</html>
