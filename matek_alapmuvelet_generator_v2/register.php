<?php include('functions.php');
include 'header.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Registráció</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> 
</head>
<body>
	<div class="header">
		<h2>Regisztráció</h2>
	</div>
	
	<form method="post" action="register.php">

		<?php echo display_error(); ?>

		<div class="input-group1">
			<label>Név</label>
			<input type="text" name="username" value="<?php echo $username; ?>">
		</div>
		<div class="input-group1">
			<label>Email</label>
			<input type="email" name="email" value="<?php echo $email; ?>">
		</div>
		<div class="input-group1">
			<label>Jelszó</label>
			<input type="password" name="password_1">
		</div>
		<div class="input-group1">
			<label>Jelszó ismét</label>
			<input type="password" name="password_2">
		</div>
		<div class="input-group1">
			<button type="submit" class="btn btn btn-success" name="register_btn">Regisztráció</button>
		</div>
		<p>
			Már regisztrált? <a href="login.php">Jelentkezen be!</a>
		</p>
	</form>
	
</body>
</html>
<?php include 'footer.php';
?>