
<?php
require_once "../db_conn.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
// if ( !isset($_POST['username'], $_POST['password']) ) {
// 	// Could not get the data that should have been sent.
// 	exit('Please fill both the username and password fields!');
// }


if ($stmt = $con->prepare('SELECT id, firstname, middlename, surname, email, password, type FROM accounts WHERE email = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['email']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();


	// $stmt->close();
}


if ($stmt->num_rows > 0) {
	$stmt->bind_result($id, $firstname, $middlename, $surname, $email,  $password, $type);
	$stmt->fetch();
	
	// Account exists, now we verify the password.
	// Note: remember to use password_hash in your registration file to store the hashed passwords.
	if (password_verify($_POST['password'], $password)) {
		// Verification success! User has logged-in!
		// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $firstname;
		$_SESSION['id'] = $id;
		if($type='basic'){
			if ($stmt1 = $con->prepare('SELECT user_ref, votingstation, line1 ,	line2,	`post code`, state FROM voters WHERE user_ref = ?')) {
				// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
				if($stmt1!=[]){
					$stmt1->bind_param('s', $id);
					$stmt1->execute();
					$stmt1->bind_result($user_ref, $votingstation, $line1, $line2, $post_code,  $state);
					$stmt->fetch();
					// Store the result so we can check if the account exists in the database.
					$stmt1->store_result();
					$_SESSION['middlename'] = $middlename;
					$_SESSION['surname'] = $surname;
					$_SESSION['type'] = $type;
					$_SESSION['user_ref'] = $user_ref;
					$_SESSION['votingstation'] = $votingstation;
					$_SESSION['line1'] = $line1;
					$_SESSION['line2'] = $line2;
					$_SESSION['post_code'] = $post_code;
					$_SESSION['state'] = $state;
				}
				
				// $stmt->close();
			}
		}
		echo 'Welcome back, ' . htmlspecialchars($_SESSION['name'], ENT_QUOTES) . '!';
		header("Location: ../index.php");
	} else {
		// Incorrect password
		echo 'Incorrect username and/or password!';
	}
} else {
	// Incorrect username
	echo 'Incorrect username and/or password!';
}
}
?>



<!DOCTYPE html>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
		<div class="login">
			<h1>Login</h1>
			<form action="login.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="email" placeholder="email" id="email" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" value="Login">
			</form>
		</div>
	</body>
</html>