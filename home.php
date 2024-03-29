<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Unimol Concorsi</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Unimol Concorsi</h1>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Visualizza risultati</h2>
			<p>
				<button class="favorite styled" type="button">
					<a href='download.php'><i class="fas fa-file-pdf"> Visualizza risposte</i></a>
				</button>
			</p>
		</div>
	</body>
</html>
