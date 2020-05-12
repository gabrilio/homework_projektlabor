<?php include('functions.php') ?>
<?php include "header.php"; ?>



	
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> 



	<div class="header" text-align="center">
		<h2>Bejelentkezés</h2>
	</div>
	
	<form method="post" action="login.php">

		<?php echo display_error(); ?>

		<div class="input-group1">
			<label>Név</label>
			<input type="text" name="username" >
		</div>
		<div class="input-group1">
			<label>Jelszó</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn btn btn-success" name="login_btn">Bejelentkezés</button>
		</div>
		<p>
			Nincs jelszava? <a href="register.php">Regisztráció</a>
		</p>
	</form>



<?php include "footer.php"; ?>
