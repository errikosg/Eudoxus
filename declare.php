<?php
	session_start();
	require('db.php');
	$_SESSION['declared_books'] = 0;
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
			$tabs = "<li class='nav-item dropdown active'>
						<a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='cursor:pointer;'>
							 $name
						</a>
						<div class='dropdown-menu' aria-labelledby='navbarDropdown'>
							<a class='dropdown-item' href='profile.php'>ΠΡΟΦΙΛ</a>
							<a class='dropdown-item' href='declare.php'>ΔΗΛΩΣΗ ΣΥΓΡΑΜΜΑΤΩΝ</a>
							<a class='dropdown-item' href='history.php'>ΙΣΤΟΡΙΚΟ ΔΗΛΩΣΕΩΝ</a>
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
					<li class="nav-item">
						<a class="nav-link" id="search_link" href="SearchBooks.php">ΑΝΑΖΗΤΗΣΗ ΣΥΓΓΡΑΜΜΑΤΩΝ</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="about_link" href="About.php">ΧΡΗΣΙΜΑ</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- main -->
	<div class="container mt-4 mb-4 border p-3" id="cont" style="min-height:255px">
		<div class="dropdown">
			<button class="btn btn-primary dropdown-toggle text-light" type="button" data-toggle="dropdown" style="width:180px" id="changeBttn">Επιλέξτε εξάμηνο <span class="caret"></span></button>
			<button type="submit" class="btn btn-primary" onclick="checkValid()" style="width:100px;float:right">Επόμενο</button>
			<span style="font-style:italic;padding-left:15px;" class="text-muted" id="description"></span><br>
			<small id="small" class="text-danger" style="display:none;float:right">Επιλέξτε πρώτα κάποιο σύγγραμμα!</small>
			<ul class="dropdown-menu p-2">
				<li><a href="#" class="options text-muted" id="opt1" onclick="changeDes(this.id)">- 1ο Εξάμηνο -</a></li>
				<li><a href="#" class="options text-muted" id="opt2" onclick="changeDes(this.id)">- 2ο Εξάμηνο -</a></li>
				<li><a href="#" class="options text-muted" id="opt3" onclick="changeDes(this.id)">- 3ο Εξάμηνο -</a></li>
				<li><a href="#" class="options text-muted" id="opt4" onclick="changeDes(this.id)">- 4ο Εξάμηνο -</a></li>
			</ul>
		</div>

		<div class="container-fluid mt-5 p-2"><form id="myform" action="showSelectedBooks.php" method="post">
			<div class="list-group" id="results" style="display:none"></div>

		</form></div>
	</div>

	<script>
		function changeDes(opt){
			var x = document.getElementById("description");
			if(opt == "opt1"){
				x.innerHTML = "Μαθήματα 1ου Εξαμήνου"
			}
			else if(opt == "opt2"){
				x.innerHTML = "Μαθήματα 2ου Εξαμήνου"
			}
			else if(opt == "opt3"){
				x.innerHTML = "Μαθήματα 3ου Εξαμήνου"
			}
			else{
				x.innerHTML = "Μαθήματα 4ου Εξαμήνου"
			}
			var num = opt.slice(3,4);
			showResults(num);
		}

		function showResults(num){
			//ajax
			var xhttp = new XMLHttpRequest();
			var res = document.getElementById("results");
			res.style.display = "block";

			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					res.innerHTML = this.responseText;

					cl = document.getElementsByClassName("check1");
					for(i=0; i<cl.length; i++){
						if(fixOther.out.has(cl[i].value))
							cl[i].checked = true;
					}
					cl = document.getElementsByClassName("check2");
					for(i=0; i<cl.length; i++){
						if(fixOther.out.has(cl[i].value))
							cl[i].checked = true;
					}
			    }
			};
			xhttp.open("POST", "showClasses.php?opt=" + num, true);
			xhttp.send();
		}

		function showInner(x){
			y = document.getElementById("res_div" + x);
			y.style.display = "block";
		}

		fixOther.out = new Set([]);
		function fixOther(cl, id){
			var x = document.getElementsByClassName(cl);
			var i=0;
			for(i=0; i<x.length; i++){
				if(x[i].id != id){
					x[i].checked = false;
					fixOther.out.delete(x[i].value);
				}
				else
					fixOther.out.add(x[i].value);
			}
			var sm = document.getElementById("small");
			sm.style.display = "none";
		}

		function checkValid(){
			var sm = document.getElementById("small");
			var x = document.getElementsByClassName("check1");
			var y = document.getElementsByClassName("check2");
			var flag=0;
			var out = [];

			for(var i=0; i<x.length; i++){
				if(x[i].checked == true || y[i].checked == true){
					flag=1;
					break;
				}
			}
			if(flag == 0){
				sm.style.display = "inline";
			}
			else{
				sm.style.display = "none";
				window.location = "showSelectedBooks.php?res="+Array.from(fixOther.out);
				/*var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						console.log(this.responseText);
						console.log(fixOther.out);
						window.location = "showSelectedBooks.php?res="+Array.from(fixOther.out);
					}
				};
				var num=5;
				xhttp.open("POST", "submitBooks.php?res=" + Array.from(fixOther.out), true);
				xhttp.send();*/
			}
		}
	</script>
</body>
</html>
