<?php
	session_start();
	if(isset($_SESSION['id'])) {
		header("Location: index.php");
	}
	if(isset($_SESSION['team'])) {
		$team = $_SESSION['team'];
	}else {
		header("Location: signUp.php");
	}
	require('db.php');
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
					<?php if($team == 1) { ?>
					<div class='form-group'>
					<input type='text' class='form-control' id='fname' name='fname' placeholder='Όνομα'>
					</div>
					<div class='form-group'>
					<input type='text' class='form-control' id='lname' name='lname' placeholder='Επώνυμο'>
					</div>
					<div class='form-group'>
					<input type='text' class='form-control' id='am' name='am' placeholder='Αριθμός Μητρώου' required>
					</div>
					<select class="form-control" id="sem" name="sem" value="0" required>
						<option value='0' hidden>Σε ποιό εξάμηνο είστε;</option>
						<option value='1'>1</option>
						<option value='2'>2</option>
						<option value='3'>3</option>
						<option value='4'>4</option>
						<option value='5'>5</option>
						<option value='6'>6</option>
						<option value='7'>7</option>
						<option value='8'>8</option>
					</select>
					<select class="form-control" id="dep" name="dep" value="0" required>
						<option value='0' hidden>Σε ποιό τμήμα είστε;</option>
						<?php	$sql = "SELECT * FROM Departments";
								$result = $db->query($sql);
								while($row=$result->fetch_assoc()) { ?>
								<option value='<?php echo $row['idDepartments'];?>'><?php echo $row['Name'];?></option>
						<?php }	?>
					</select>

					<?php }else { ?>
					<div class='form-group'>
					<input type='text' class='form-control' id='name' name='name' placeholder='Όνομα' required>
					</div>
					<div class='form-group'>
					<input type='text' class='form-control' id='phone' name='phone' placeholder='Τηλέφωνο' required>
					</div>
					<div class='form-group'>
					<input type='text' class='form-control' id='loc' name='loc' placeholder='Τοποθεσία' required>
					</div>
					<?php } ?>
					<button type='submit' id='signup2' name='signup2' class='btn btn-primary'>Εγγραφή</button>
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
		$("#signup2").text("Αναμένετε...");

		<?php if($team == 1) { ?>
		var fname = $("#fname").val();
		var lname = $("#lname").val();
		var am = $("#am").val();
		var sem = $("#sem").val();
		var dep = $("#dep").val();

		if(fname == "" && lname == "") {
			$("#signup2").text("Εγγραφή");
			$("#msg").html("<div class='alert alert-danger'>Είτε το όνομα είτε το επώνυμο πρέπει να είναι συπληρωμένο</div>");
			return;
		}
		var signup2 = "signup2";

		var data = {fname:fname, lname:lname, am:am, sem:sem, dep:dep, signup2:signup2};
		<?php }else {?>
		var name = $("#name").val();
		var phone = $("#phone").val();
		var loc = $("#loc").val();
		var signup2 = "signup2";

		var data = {name:name, phone:phone, loc:loc, signup2:signup2};
		<?php } ?>
		$.post("connector.php", data)
		.done(function(resp) {
			if(resp == 'ok') {
				window.location = "index.php";
			} else {
				$("#signup2").text("Εγγραφή");
				$("#msg").html("<div class='alert alert-danger'>"+resp+"</div>");
			}
		});
	});
});
</script>

</html>
<?php $db->close()?>
