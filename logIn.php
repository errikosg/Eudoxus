<?php
	session_start();
	if(isset($_SESSION['id'])) {
		header("Location: index.php");
	}
?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="general.css">

	<title>Είσοδος</title>
</head>

<body>
	<!--NAVIGATION BAR -->
	<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top box">
		<div class="container">
			<a class="navbar-brand center" href="index.php">
				<img src="./imgs/eudoxus-logo.png" alt="Εύδοξος" title="Επιστροφή στην αρχική">
			</a>
		</div>
	</nav>

	<!-- MAIN AREA -->
	<div class="container">
		<div class="row main">
			<div class="col-md-3 col-sm-2 col-xs-12"></div>
			<div class="col-md-6 col-sm-8 col-xs-12 box" id="block">
				<h1>ΕΙΣΟΔΟΣ</h1>
				<div id="msg"></div>
				<form id="formIn" method="POST">
					<div class="form-group">
						<input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" id="psw" name="psw" placeholder="Κωδικός" required>
					</div>

					<button type="submit" id="login" name="login" class="btn btn-primary">Είσοδος</button>
				</form>

				<div class="fancy">
					<span>Ή</span>
				</div>
				<form action="signUp.php">
					<button type="submit" class='btn btn-primary green'>Εγγραφή</button>
				</form>
			</div>
			<div class="col-md-3 col-sm-2 col-xs-12"></div>
		</div>
	</div>

</body>
<!-- AJAX WITH JQUERY -->
<script>
$(function() {
	$("#formIn").submit(function() {
		event.preventDefault();
		$("#login").text("Αναμένετε...");

		var email = $("#email").val();
		var psw = $("#psw").val();
		var login = "login";
		$.post("connector.php", {email:email, psw:psw, login:login})
			.done(function(resp) {
				if(resp == 'ok') {
					window.location = "index.php";
				} else {
					$("#login").text("Είσοδος");
					$("#msg").html("<div class='alert alert-danger'>"+resp+"</div>");
				}
			});
	});
});
</script>

</html>
