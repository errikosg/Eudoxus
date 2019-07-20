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
			$tabs = "<li class='nav-item dropdown active'>
						<a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'  style='cursor:pointer;'>
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
			$tabs = "<li class='nav-item dropdown active'>
						<a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
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
		header("Location: index.php");
	}
	if(isset($_GET['logout'])=='yes') {
		session_destroy();
		header("Location: index.php");
	}

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

	<title>Προφίλ</title>
</head>

<body>
	<!--NAVIGATION BAR -->
	<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top box-nav">
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

	<div class="container">
		<div class="row main">
			<div class="col-md-3 col-sm-2 col-xs-12"></div>
			<div class="col-md-6 col-sm-8 col-xs-12 box">
				<div class="panel panel-info">
					<div class="panel-heading" align="center">
						<h3 class="panel-title">Επεξεργασία Προφίλ</h3>
						<div id="msg"></div>
					</div>
					<div class="panel-body">
					<form method="POST" id="editForm">
						<div class="row">
							<div class=" col-md-12 col-lg-12" align="center">
								<table class="table table-user-information">
										<?php if ($_SESSION['team'] == 1) { ?>
											<?php
												$sql = "SELECT * FROM Users WHERE idUsers = $id";
												$result = $db->query($sql);
												$info = $result->fetch_assoc();
												$did = trim($row['Departments_id']);
												$sql = "SELECT * FROM Departments WHERE idDepartments = $did";
												$result = $db->query($sql);
												$info2 = $result->fetch_assoc();
												$uid = trim($info2['University']);
												$sql = "SELECT * FROM University WHERE idUniversity = $uid";
												$result = $db->query($sql);
												$info3 = $result->fetch_assoc();
											?>
											<tbody>
												<tr>
												<td>E-Mail</td>
												<td><input type="email" id="email" name="email" value="<?php echo $info['email']?>" required></td>
												</tr>
												<tr>
												<td>Τωρινός Κωδικός*</td>
												<td><a><input type="password" id="oldPass" name="oldPass" value=""></a></td>
												</tr>
												<tr>
												<td>Νέος Κωδικός*</td>
												<td><a><input type="password" id="newPass" name="newPass" value=""></a></td>
												</tr>
												<tr>
												<td>Επιβεβαίωση Νέου Κωδικού*</td>
												<td><a><input type="password" id="rePass" name="rePass" value=""></a></td>
												</tr>
												<tr>
												<td>Όνομα</td>
												<td><a><input type="text" id="fname" name="fname" value="<?php echo $row['FirstName']?>"></a></td>
												</tr>
												<tr>
												<td>Επώνυμο</td>
												<td><a><input type="text" id="lname" name="lname" value="<?php echo $row['LastName']?>"></a></td>
												</tr>
												<td>Αριθμός Μητρώου</td>
												<td><a><input type="text" id="am" name="am" value="<?php echo $row['AM']?>"required></a></td>
												</tr>
												<td>Τρέχoν Εξάμηνο</td>
												<td><a><input type="text" id="sem" name="sem" value="<?php echo $row['CurSem']?>"required></a></td>
												</tr>
											</tbody>

										<?php }else { ?>
											<?php
												$sql = "SELECT * FROM Users WHERE idUsers = $id";
												$result = $db->query($sql);
												$info = $result->fetch_assoc();
											?>
											<tbody>
												<tr>
												<td>E-Mail</td>
												<td><input type="email" id="email" name="email" value="<?php echo $info['email']?>"required></td>
												</tr>
												<tr>
												<td>Τωρινός Κωδικός*</td>
												<td><a><input type="password" id="oldPass" name="oldPass" value=""></a></td>
												</tr>
												<tr>
												<td>Νέος Κωδικός*</td>
												<td><a><input type="password" id="newPass" name="newPass" value=""></a></td>
												</tr>
												<tr>
												<td>Επιβεβαίωση Νέου Κωδικού*</td>
												<td><a><input type="password" id="rePass" name="rePass" value=""></a></td>
												</tr>
												<tr>
												<td>Όνομα</td>
												<td><a><input type="text" id="name" name="name" value="<?php echo $row['Name']?>"required></a></td>
												</tr>
												<tr>
												<td>Τηλέφωνο</td>
												<td><a><input type="text" id="phone" name="phone" value="<?php echo $row['Phone']?>"required></a></td>
												</tr>
												<tr>
												<td>Τοποθεσία</td>
												<td><a><input type="text" id="loc" name="loc" value="<?php echo $row['Location']?>"required></a></td>
												</tr>
											</tbody>
										<?php } ?>

								</table>
							</div>
						</div>
						<small>Αλλάξτε μόνο όσα πεδία θέλετε.</small><br>
						<small>*Για την αλλαγή κωδικού συμπληρώστε και τα 3 κενά πεδία.</small>
						<button type="submit" id="edit" name="edit" class="btn btn-primary">Επεξεργασία</button>
						</form>
						<div class="fancy">
							<span>Ή</span>
						</div>
						<form action="profile.php">
							<button type="submit" class='btn btn-danger red'>Άκυρο</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-2 col-xs-12"></div>
		</div>
	</div>
</body>
<!-- AJAX WITH JQUERY -->
<script>
$(function() {
	$("#editForm").submit(function() {
		event.preventDefault();
		$("#edit").text("Αναμένετε...");
		<?php if ($_SESSION['team'] == 1) { ?>

		var email = $("#email").val();
		var oldPass = $("#oldPass").val();
		var newPass = $("#newPass").val();
		var rePass = $("#rePass").val();
		var fname = $("#fname").val();
		var lname = $("#lname").val();
		var am = $("#am").val();
		var sem = $("#sem").val();

		var data = {email:email, oldPass:oldPass, newPass:newPass, fname:fname, lname:lname, am:am, sem:sem};
		if( fname == "" && lname == "") {
			$("#edit").text("Επεξεργασία");
			$("#msg").html("<div class='alert alert-danger'>Είτε το όνομα είτε το εμώνυμο πρέπει να είναι συπληρωμένο</div>");
			return;
		}
		<?php }else { ?>
		var email = $("#email").val();
		var oldPass = $("#oldPass").val();
		var newPass = $("#newPass").val();
		var rePass = $("#rePass").val();
		var name = $("#name").val();
		var phone = $("#phone").val();
		var loc = $("#loc").val();

		var data = {email:email, oldPass:oldPass, newPass:newPass, name:name, phone:phone, loc:loc};
		<?php } ?>

		if(oldPass == "" && (newPass !="" || rePass !="")) {
			$("#edit").text("Επεξεργασία");
			$("#msg").html("<div class='alert alert-danger'>Δώστε τον παλίο κωδικό</div>");
			return;
		}
		if(oldPass != "" && ((newPass != rePass) || newPass == "" || rePass == "")) {
			$("#edit").text("Επεξεργασία");
			$("#msg").html("<div class='alert alert-danger'>O νέος κωδικός και η επιβεβαίωση πρέπει να ταιριάζουν και να μην είναι κανοί</div>");
			return;
		}
		$.post("save.php", data)
		.done(function(resp) {
				if(resp == 'ok') {
					window.location = "profile.php";
				} else {
					$("#edit").text("Επεξεργασία");
					$("#msg").html("<div class='alert alert-danger'>"+resp+"</div>");
				}
		});
	});
});
</script>
</html>
<?php $db->close();?>
