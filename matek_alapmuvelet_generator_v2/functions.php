<?php 
	session_start();

	// connect to database
	$db = mysqli_connect('mysql.omega:3306', 'szorgalmi', 'Projektlabor2020', 'szorgalmi');

	// variable declaration
	$username = "";
	$email    = "";
	$errors   = array(); 

	// call the register() function if register_btn is clicked
	if (isset($_POST['register_btn'])) {
		register();
	}

	// call the login() function if register_btn is clicked
	if (isset($_POST['login_btn'])) {
		login();
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: ../login.php");
	}
	
	// REGISTER USER
	function register(){
		global $db, $errors;

		// receive all input values from the form
		$username    =  e($_POST['username']);
		$email       =  e($_POST['email']);
		$password_1  =  e($_POST['password_1']);
		$password_2  =  e($_POST['password_2']);
		$email = ($_POST["email"]);
		// check if e-mail address is well-formed
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				array_push($errors, "Az email cím még mindig nem megfelelő!");
			}
		// form validation: ensure that the form is correctly filled
		if (empty($username)) { 
			array_push($errors, "A név megadása kötelező!"); 
		}

		
		if (empty($email)) { 
			array_push($errors, "Email kötelező"); 
		}
		if (empty($password_1)) { 
			array_push($errors, "Jelszó kötelező"); 
		}
		if ($password_1 != $password_2) {
			array_push($errors, "A két jelszó nem egyezik!");
		}
		$query = "SELECT * FROM users WHERE username='$username'  LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1){
			array_push($errors,"Ezzel a névvel már regisztráltak!");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database

			if (isset($_POST['user_type'])) {
				$user_type = e($_POST['user_type']);
				$query = "INSERT INTO users (username, email, user_type, password) 
						  VALUES('$username', '$email', '$user_type', '$password')";
				mysqli_query($db, $query);
				$_SESSION['success']  = "Az új felhasználó sikeresen létrehozva!!";
				header('location: home.php');
			}else{
				$query = "INSERT INTO users (username, email, user_type, password) 
						  VALUES('$username', '$email', 'user', '$password')";
				mysqli_query($db, $query);

				// get id of the created user
				$logged_in_user_id = mysqli_insert_id($db);

				$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
				$_SESSION['success']  = "Sikeres regisztráció!";
				header('location: uhome.php');				
			}

		}

	}


	// return user array from their id
	function getUserById($id){
		global $db;
		$query = "SELECT * FROM users WHERE id=" . $id;
		$result = mysqli_query($db, $query);

		$user = mysqli_fetch_assoc($result);
		return $user;
	}

	// LOGIN USER
	function login(){
		global $db, $username, $errors;

		// grap form values
		$username = e($_POST['username']);
		$password = e($_POST['password']);

		// make sure form is filled properly
		if (empty($username)) {
			array_push($errors, "A név megadása kötelező!");
		}
		if (empty($password)) {
			array_push($errors, "Jelszó kötelező!");
		}

		// attempt login if no errors on form
		if (count($errors) == 0) {
			$password = md5($password);
			



			$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) { // user found
				// check if user is admin or user
				$logged_in_user = mysqli_fetch_assoc($results);
				if ($logged_in_user['user_type'] == 'admin') {

					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "Helló kedves admin!";
					header('location: admin/home.php');		  
				}else{
					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "Üdvözöllek felhasználó!";

					header('location: uhome.php');
				}
			}else {
				array_push($errors, "Rossz név/jelszó kombináció!");
			}
		}
	}

	function isLoggedIn()
	{
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
	}

	function isAdmin()
	{
		if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
			return true;
		}else{
			return false;
		}
	}

	// escape string
	function e($val){
		global $db;
		return mysqli_real_escape_string($db, trim($val));
	}

	function display_error() {
		global $errors;

		if (count($errors) > 0){
			echo '<div class="error">';
				foreach ($errors as $error){
					echo $error .'<br>';
				}
			echo '</div>';
		}
	}

?>