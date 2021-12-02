<?php

session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

$db = mysqli_connect('localhost', 'root', '', 'unimol_concorsi');

	// initialize variables
	$denominazione = "";
	$abilitato = "";
	$id = 0;
	$update = false;

	if (isset($_POST['save'])) {
		$denominazione = $_POST['denominazione'];
		$abilitato = $_POST['abilitato'];

		mysqli_query($db, "INSERT INTO concorsi (denominazione, abilitato) VALUES ('$denominazione', '$abilitato')"); 
		$_SESSION['message'] = "Concorso salvato"; 
		header('location: gestione.php');
  }

  if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $denominazione = $_POST['denominazione'];
		$abilitato = $_POST['abilitato'];
  
    mysqli_query($db, "UPDATE concorsi SET denominazione='$denominazione', abilitato='$abilitato' WHERE id=$id");
    $_SESSION['message'] = "Concorso modificato"; 
    header('location: gestione.php');
  }

  if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($db, "UPDATE concorsi SET abilitato=0 WHERE id=$id");
    $_SESSION['message'] = "Concorso disabilitato"; 
    header('location: gestione.php');
  }
?>