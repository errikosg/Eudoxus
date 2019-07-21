<?php
	session_start();
	require('db.php');
    if($_SESSION['declared_books'] === 1)
        header("Location: declare.php");

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
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="general.css" />


	<title>Εύδοξος</title>
</head>

<body>
	<!--NAVIGATION BAR -->
    <?php

    ?>
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

	<div class="container mt-5 mb-4" id="cont">
        <h4 class="text-dark text-center">Επιβεβαίωση δήλωσης</h4>
        <p style="width:380px;font-style:italic;font-size:80%;margin:auto"> Ελέγξτε τα δηλωθέντα μαθήματα καθώς και τα συγγράμματά τους.</p><br><br>

        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <button class="btn btn-danger" title="Επανάληψη δήλωσης" style="width:200px"><i class="fas fa-arrow-left"></i>
                        <a href="declare.php" style="color:white;text-decoration:none;"> Διόρθωση </a>
                    </button>
                </div>
                <div class="col-sm-6">
                    <button class="btn btn-success" title="Επιβεβαίωση" onclick="submit()" style="width:200px;float:right">Επιβεβαίωση</button>
                </div>
            </div>
        </div><br><br>

        <ul class="list-group border rounded" id="results">
		<?php
            require('db.php');
            $uid = $_SESSION['id'];
            $res = trim($_REQUEST["res"]);
            $token = strtok($res, ",");
            $counter = 1;

            while ($token !== false){
        		$bid = (int)$token;
                $sql = "SELECT * FROM Books WHERE idBooks = '$bid'";
                $result = $db->query($sql);
                $row = $result->fetch_assoc();

                $sql2 = "SELECT * FROM Distributor_has_Book WHERE idBooks = '$bid'";
                $result2 = $db->query($sql2);
                $row2 = $result2->fetch_assoc();

                $did = $row2["idDistributor"];
                $sql3 = "SELECT * FROM Distributor WHERE idDistributor = '$did'";
                $result3 = $db->query($sql3);
                $row3 = $result3->fetch_assoc();

                echo '<li id=' . $bid . ' class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between"> <h5 class="mb-1 text-primary">' . $counter . '. ' . $row["Title"] . '</h5></div>
                <p class="mb-2">Συγγραφέας: ' . $row["Author"] . '</p><p class="mb-2">Εκδόσεις: ' . $row["Publication"] . '</p><p class="mb-2">ISBN:
                 ' . $row["ISBN"] . '</p><p>Διανομέας: ' . $row3["Name"] . '</p><p>Σημείο Πώλησης: ' . $row3["Location"] . '</p></li>';

                $counter += 1;
                $token = strtok(",");
            }
        ?>
        </ul>
	</div><br><br><br>
    <div id="snackbar">Η δήλωση έγινε με επιτυχία.</div>

    <script>
        function submit(){
            cl = document.getElementsByClassName('list-group-item');
            var out = [];
            for(var i=0; i<cl.length; i++){
                out.push(cl[i].id)
            }
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    x = document.getElementById('cont')
                    x.innerHTML = '<h4 class="text-dark text-center">Η δήλωση μαθημάτων ολοκληρώθηκε με επιτυχία!</h4><br>' +
                    '<div class="container"><div class="row">' +
                    '<div class="col-sm-6"><button class="btn btn-primary" title="Αρχική σελίδα" style="width:300px"><a href="index.php" style="color:white;text-decoration:none;"> Πήγαινε στην αρχική σελίδα </a></button></div>' +
                    '<div class="col-sm-6"><button class="btn btn-primary" title="Ιστορικό" style="width:300px;float:right"><a href="history.php" style="color:white;text-decoration:none;">Δες το ιστορικό δηλώσεων</a></button></div></div></div>'

                    var x = document.getElementById("snackbar");
                    x.className = "show";
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
                }
            };
            xhttp.open("POST", "submitBooks.php?res=" + out, true);
            xhttp.send();
        }
    </script>
</body>
</html>
