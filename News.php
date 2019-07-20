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

	<link rel="stylesheet" href="./css/general.css">

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
					<li class="nav-item active">
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

	<div class="container mt-4 mb5" id="cont">
		<h4 class="text-center"> ΑΝΑΚΟΙΝΩΣΕΙΣ </h4><br>
		<ul class="list-group">
			<li href="#" class="list-group-item list-group-item-action flex-column align-items-start">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1 text-primary">Παράταση Περιόδου Δηλώσεων και Διανομής Συγγραμμάτων</h5>
					<small class="text-muted">12/1/2019</small>
				</div>
				<p class="mb-1">Σας ενημερώνουμε ότι παρατείνεται η προθεσμία δηλώσεων διδακτικών συγγράμματων από τους φοιτητές για το τρέχον
				χειμερινό εξάμηνο έως και την Παρασκευή 11 Ιανουαρίου 2019. Επίσης, ως νέα καταληκτική ημερομηνία για τη διανομή των συγγραμμάτων
				στους φοιτητές ορίζεται η Παρασκευή 25 Ιανουαρίου 2019</p>
			</li>
			<li href="#" class="list-group-item list-group-item-action flex-column align-items-start">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1 text-primary">Έναρξη Δήλωσης και Διανομής Συγγραμμάτων Χειμερινής Περιόδου 2018-19</h5>
					<small class="text-muted">20/12/2018</small>
				</div>
				<p class="mb-1">Σχετικά με τις δηλώσεις διδακτικών συγγραμμάτων και τη διανομή αυτών στους φοιτητές για το χειμερινό εξάμηνο του
				ακαδημαϊκού έτους 2018-2019, σας ενημερώνουμε ότι οι δηλώσεις διδακτικών συγγραμμάτων από τους φοιτητές θα ξεκινήσουν
				την Τετάρτη 24 Οκτωβρίου 2018 και θα πρέπει να έχουν ολοκληρωθεί έως την Παρασκευή 21 Δεκεμβρίου 2018</p>
			</li>
			<li href="#" class="list-group-item list-group-item-action flex-column align-items-start">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1 text-primary">Aνάρτηση διδακτικών συγγραμμάτων ακαδημαϊκού έτους 2018-2019</h5>
					<small class="text-muted">12/12/2018</small>
				</div>
				<p class="mb-1">Το Υπουργείο Παιδείας, Έρευνας και Θρησκευμάτων καλεί τους ενδιαφερόμενους εκδοτικούς οίκους που έχουν δικαίωμα διανομής
				ή άδεια εκμετάλλευσης συγγραμμάτων να προβούν σε νέα εγγραφή ή επιβεβαίωση της συμμετοχής τους στη διανομή συγγραμμάτων για το επόμενο
				ακαδημαϊκό έτος (2018-2019) και να καταχωρίσουν τα συγγράμματα της επιλογής τους στο Π.Σ. «Εύδοξος» από την Πέμπτη, 21/6/2018 έως την Παρασκευή, 27-7-2018</p>
			</li>
		</ul>
	</div><br><br><br><br><br>

</body>
</html>
