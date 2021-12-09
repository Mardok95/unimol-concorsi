<?php
session_start();
require 'admin/config.php';
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

$path = PATH_ALLEGATI.'/'.$_SESSION['id_concorso'].'/';

$filename = $path.$_SESSION['cod_risposta'].'.pdf';

header("Content-type:application/pdf");

// It will be called downloaded.pdf
//header("Content-Disposition:attachment;filename=risposte.pdf");
return readfile($filename);

?>
