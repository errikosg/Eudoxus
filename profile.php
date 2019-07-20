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
			$tabs = "<li class='nav-item dropdown active'>
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
		<?php if ($_SESSION['team'] == 1) { ?>
							<h3 class="panel-title"><?php echo $row['FirstName'],' ',$row['LastName'];?></h3>
						</div>
						<div class="panel-body">
							<div class="row">
									<div class=" col-md-12 col-lg-12 " align="center">
										<table class="table table-user-information">
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
												<td><?php echo $info['email']?></td>
												</tr>
												<tr>
												<td>Αριθμός Μητρώου</td>
												<td><a><?php echo $row['AM']?></a></td>
												</tr>
												<td>Τρέχoν Εξάμηνο</td>
												<td><a><?php echo $row['CurSem']?></a></td>
												</tr>
												<td>Σχολή</td>
												<td><a><?php echo $info2['Name']?></a></td>
												</tr>
												<td>Τμήμα</td>
												<td><a><?php echo $info3['Name']?></a></td>
												</tr>
		<?php }else { ?>
							<h3 class="panel-title"><?php echo $row['Name'];?></h3>
						</div>
						<div class="panel-body">
							<div class="row">
									<div class=" col-md-12 col-lg-12 " align="center">
										<table class="table table-user-information">
										<?php
											$sql = "SELECT * FROM Users WHERE idUsers = $id";
											$result = $db->query($sql);
											$info = $result->fetch_assoc();
										?>
											<tbody>
												<tr>
												<td>E-Mail</td>
												<td><?php echo $info['email']?></td>
												</tr>
												<tr>
												<td>Τηλέφωνο</td>
												<td><a><?php echo $row['Phone']?></a></td>
												</tr>
												<td>Τοποθεσία</td>
												<td><a><?php echo $row['Location']?></a></td>
												</tr>
							<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
								<form action="edit.php">
									<button type="submit" class='btn btn-primary'>Επεξεργασία Προφίλ</button>
								</form>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

</body>
</html>
<?php $db->close();?>
