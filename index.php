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

	<div class="container mt-5 mb-4" id="cont">
		<h3 class="text-dark">ΗΛΕΚΤΡΟΝΙΚΗ ΥΠΗΡΕΣΙΑ ΟΛΟΚΛΗΡΩΜΕΝΗΣ ΔΙΑΧΕΙΡΙΣΗΣ ΣΥΓΓΡΑΜΜΑΤΩΝ</h3><br>
		<p> Πρόκειται για μία πρωτοποριακή υπηρεσία για την άμεση και ολοκληρωμένη παροχή των Συγγραμμάτων των προπτυχιακών φοιτητών των Πανεπιστημίων (Α.Ε.Ι.),
		των Τεχνολογικών Εκπαιδευτικών Ιδρυμάτων (Τ.Ε.Ι.) από τα εγκεκριμένα σημεία διανομής μέσω πλήρων αυτοματοποιημένων διαδικασιών.</p><br>

		<h5 class="text-primary" style="font-weight:bold"> Περιγραφή ομάδων χρηστών / διαδικασιών</h5>
		<p>
		Η διεπαφή απευθύνεται σε φοιτητές και σημεία διανομής παρέχοντας εύκολη παροχή ή διαχείριση συγγραμμάτων. Ο κάθε χρήστης για να μπορεί να εισέλθει στην σελίδα
		και να αξιοποιήση την λειτουργικότητα της πρέπει να δημιουργήσει λογαριασμό, ενώ διαφορετικά μπορεί να περιηγηθεί στην αρχική σελίδα έχοντας πρόσβαση μόνο στις
		Ανακοινώσεις, στα Χρήσιμα και την Αναζήτηση Συγγραμμάτων.<br>
		Κατόπιν δημιουργίας λογαριασμού ο κάθε χρήστης οδηγείται αντίστοιχα στην σελίδα Φοιτητή ή Σημείου Διανομής όπου μπορεί και να εκτελέσει τις αντίστοιχες
		διεργασίες.</p>
		<p>Συγκεκριμένα, ο κάθε φοιτητής έχει:</p>
		<ul>
			<li> Πλήρη ενημέρωση για τα παρεχόμενα συγγράμματα σε κάθε μάθημα</li>
			<li> Δυνατότητα εύκολης δήλωσης και παραλαβής συγγραμμάτων</li>
			<li> Έλεγχος του πλήρους ιστορικού δηλώσεών του</li>
		</ul>
		<p>Αντίστοιχα, το κάθε σημείο διανομής:</p>
		<ul>
			<li> Δυνατότητα προβολής των διαθέσιμων συγγραμμάτων του αποθέματος</li>
			<li> Δυνατότητα προβολής των λεπτομερειών του εκάστοτε συγγράμματος</li>
			<li> Εύκολη παράδοση συγγραμμάτων στους φοιτητές</li>
		</ul>
	</div><br><br><br>

</body>
</html>
