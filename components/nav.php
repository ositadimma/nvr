<?php
include 'db_conn.php';
// We need to use sessions, so you should always start sessions using the below code.

// if (!isset($_SESSION['loggedin'])) {
// 	header('Location: index.html');
// 	exit;
// }
?> 
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="./css/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>NVR</h1>
				
				<?php
				// authentication
				if (isset($_SESSION['loggedin'])) {
					echo '<a href="./views/profile.php"><i class="fas fa-user-circle"></i>Profile</a>';
				}
				if (isset($_SESSION['loggedin'])) {
					echo '<a href="./views/admin/accounts.php"><i class="fas fa-user-circle"></i>admin</a>';
				}
				?>    
				<a href="./views/admin/accounts.php"><i class="fas fa-user-circle"></i>info</a>
				<?php

				if (!isset($_SESSION['loggedin'])) {
					echo '<a href="./views/login.php"><i class="fas fa-user-circle"></i>Sign in</a>
					<a href="./views/signup.php"><i class="fas fa-user-circle"></i>Sign up</a>';
				}
				if (isset($_SESSION['loggedin'])) {
					echo '<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>';
				}
				?> 
			</div>
		</nav>
	</body>
</html>
