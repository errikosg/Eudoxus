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
							<a class='dropdown-item' href='bookDelivery.php'>ΠΑΡΑΔΟΣΗ ΣΥΓΓΡΑΜΜΑΤΟΣ</a>
							<a class='dropdown-item' href='bookReserve.php'>ΑΠΟΘΕΜΑ</a>
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
	<link rel="stylesheet" type="text/css" href="general.css" />

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
			<div class="col-md-6 col-sm-8 col-xs-12">
				<div class="panel panel-info">
					<div class="panel-heading" align="center">
						<h3 class="panel-title">ΙΣΤΟΡΙΚΟ ΔΗΛΩΣΕΩΝ</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class=" col-md-12 col-lg-12 " align="center">

								<?php
									$sql = "SELECT * from Books WHERE idBooks in (SELECT idBooks from History where Student_id=$id)";
									$result = $db->query($sql);
									if($result->num_rows > 0 ) {
										while($row=$result->fetch_assoc()) {
											$bid = $row['idBooks'];

											$sql2 = "SELECT * FROM Classes_has_Book WHERE idBooks='$bid'";
											$result2 = $db->query($sql2);
											$row2 = $result2->fetch_assoc();
											$cid = $row2['Classes_idClasses'];

											$sql2 = "SELECT * FROM Classes WHERE idClasses='$cid'";
											$result2 = $db->query($sql2);
											$row2 = $result2->fetch_assoc();
											$cname = $row2['Name'];
										?>
										<table class="table table-user-information pad">
										<tbody class="box">
											<tr class="br_bottom">
												<td class="td-left"><span style="font-size:110%;font-weight:bold">Μάθημα</span></td>
												<td class="td-right"><span class="text-primary" style="font-size:110%;font-weight:bold"><?php echo $cname?></span></td>
											</tr>
											<tr>
												<td class="td-left">Τίτλος</td>
												<td class="td-right"><?php echo $row['Title']?></td>
											</tr>
											<tr>
												<td class="td-left">Συγγραφέας</td>
												<td class="td-right"><?php echo $row['Author']?></td>
											</tr>
											<tr>
												<td class="td-left">Εκδόσεις</td>
												<td class="td-right"><?php echo $row['Publication']?></td>
											</tr>
											<tr>
												<td class="td-left">ISBN</td>
												<td class="td-right"><?php echo $row['ISBN']?></td>
											</tr>
										</tbody>
										</table>
										<?php }
									}else {	?>
									<table class="table table-user-information pad">
										<tbody class="box pad">
											<tr>
											<td>Δεν έχετε πραγματοποιήσει καποια δήλωση.</td>
											</tr>
										<tbody>
									</table>
									<?php }?>

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
