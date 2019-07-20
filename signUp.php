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
	
	<link rel="stylesheet" href="./css/general.css">
	
	<title>Εγγραφή</title>
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
				<h1>ΕΓΓΡΑΦΗ</h1>
				<div id='msg'></div>
				<form id='formUp' method='POST'>
					<div class='form-group'>
					<input type='email' class='form-control' id='email' name='email' placeholder='Email' required>
					</div>
					<div class='form-group'>
					<input type='password' class='form-control' id='psw' name='psw' placeholder='Κωδικός' required>
					</div>
					<div class='form-group'>
					<input type='password' class='form-control' id='repsw' name='repsw' placeholder='Επιβεβαίωση Κωδικού' required>
					</div>
					<select multiple class="form-control" id="team" name="team" required>
						<option value='0' disabled>Τι από τα παρακάτω είστε;</option>
						<option value='1'>Φοιτητής</option>
						<option value='2'>Σημείο Διανομής</option>
					</select>
					<button type='submit' id='signup' name='signup' class='btn btn-primary'>Εγγραφή</button>
					</form>
					
					<div class='fancy'><span>Ή</span></div>
					<form action="logIn.php">
						<button type="submit" class='btn btn-primary green'>Είσοδος</button>
					</form>
			</div>
			<div class="col-md-3 col-sm-2 col-xs-12"></div>
		</div>
	</div>

</body>
<!-- AJAX WITH JQUERY -->
<script>
$(function() {
	$("#formUp").submit(function() {
		event.preventDefault();
		$("#signup").text("Αναμένετε...");
		
		var email = $("#email").val();
		var psw = $("#psw").val();
		var repsw = $("#repsw").val();
		var team = $("#team").val();
		if (team == '1') {
			tm = 1;
		}else {
			tm = 2;
		}
		var signup = "signup";
		if( psw == repsw) {
			$.post("connector.php", {email:email, psw:psw, repsw:repsw, tm:tm, signup:signup})
				.done(function(resp) {
					if(resp == 'ok') {
						window.location = "signUp2.php";
					} else {
						$("#signup").text("Εγγραφή");
						$("#msg").html("<div class='alert alert-danger'>"+resp+"</div>");
					}
				});
		}else {
			$("#msg").html("<div class='alert alert-danger'>Ο κωδικός δεν ταιριάζει με αυτόν της επιβεβαίωσης</div>");
			$("#signup").text("Εγγραφή");
		}
	});
});
</script>

</html>