<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
define('PATH','C:\wamp64\allegati_concorso\\');

$filename = PATH.$_SESSION['cod_risposta'].'.pdf';

header("Content-type:application/pdf");

// It will be called downloaded.pdf
//header("Content-Disposition:attachment;filename=risposte.pdf");
return readfile($filename);

?>
