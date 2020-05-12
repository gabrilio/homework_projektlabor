<?php include('../functions.php');
if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}
 ?>

<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> 
	<style>
		.header {
			
		}
		button[name=register_btn] {
			
		}
	</style>

	<div class="header">
		<h2>Új felhasználó hozzáadása</h2>
	</div>
	
	<form method="post" action="create_user.php">

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
			<label>Felhasználó típusa</label>
			<select name="user_type" id="user_type" >
				<option value=""></option>
				<option value="admin">Admin</option>
				<option value="user">User</option>
			</select>
		</div>
		<div class="input-group1">
			<label>Jelszó</label>
			<input type="password" name="password_1">
		</div>
		<div class="input-group1">
			<label>Jelszó ismét</label>
			<input type="password" name="password_2">
		</div>
		<div class="input-group">
			<button type="submit" class="btn btn btn-success" name="register_btn"> Felhasználó létrehozása</button>
		</div>
	</form>
