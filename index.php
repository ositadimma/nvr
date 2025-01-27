<?php
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
		<?php
        include "./components/nav.php";
        ?>
		<div class="content">
			<h2>National Voter Register</h2>
			<?php
			if (isset($_SESSION['loggedin'])) {
					echo '<p>Welcome back,'.htmlspecialchars($_SESSION['name']).'</span>!</p>';
				}
			?>
			<div>Register to vote and make your voice heard</div>
			<button>Learn More</button>
		</div>
	</body>
</html>
