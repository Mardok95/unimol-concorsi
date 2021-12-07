<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

require 'config.php';
?>


<?php 

// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'unimol_concorsi';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}




function rmdir_recursive($dir) {
    foreach(scandir($dir) as $file) {
       if ('.' === $file || '..' === $file) continue;
       if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
       else unlink("$dir/$file");
   }

   rmdir($dir);
}

if($_FILES["zip_file"]["name"]) {
    $filename = $_FILES["zip_file"]["name"];
    $source = $_FILES["zip_file"]["tmp_name"];
    $type = $_FILES["zip_file"]["type"];

    $name = explode(".", $filename);
    $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
    foreach($accepted_types as $mime_type) {
        if($mime_type == $type) {
            $okay = true;
            break;
        } 
    }

    $continue = strtolower($name[1]) == 'zip' ? true : false;
    if(!$continue) {
        $message = "Il file scelto non è un ZIP. Riprova!";
    }

  /* PHP current path */
  $path = PATH_ALLEGATI.'/';

  $files = glob($path.'*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file)) {
                unlink($file); // delete file
            }
        }

  //$path = dirname(__FILE__).'/';  // absolute path to the directory where zipper.php is in
  $filenoext = basename ($filename, '.zip');  // absolute path to the directory where zipper.php is in (lowercase)
  $filenoext = basename ($filenoext, '.ZIP');  // absolute path to the directory where zipper.php is in (when uppercase)

  $targetdir = $path;
  //$targetdir = $path . $filenoext; // target directory
  $targetzip = $path . $filename; // target zip file

  /* create directory if not exists', otherwise overwrite */
  /* target directory is same as filename without extension */

  //if (is_dir($targetdir))  rmdir_recursive ( $targetdir);


  //mkdir($targetdir, 0777);


  /* here it is really happening */

    if(move_uploaded_file($source, $targetzip)) {
        $zip = new ZipArchive();
        $x = $zip->open($targetzip);  // open the zip file to extract
        if ($x === true) {
            $zip->extractTo($targetdir); // place in the directory with same name  
            $zip->close();

            unlink($targetzip);
        }
        $message = "Il tuo file zip è stato caricato ed estratto con successo!";
    } else {    
        $message = "Problema in upload. Prova di nuovo!";
    }
}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<title>Upload ZIP</title>
		<link href="style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>

    <body>
        <?php if($message) echo "<p>$message</p>"; ?>
        <nav class="navtop">
			<div>
				<h1>Upload ZIP</h1>
				<a href="home.php"><i class="fas fa-home"></i>Home</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
        <hr></hr>
        <form enctype="multipart/form-data" method="post" action="">
            <div class="d-flex justify-content-center">
            <label for="formFileLg" class="form-label">Scegli un concorso: </label>
            <select name="select_concorso">
                    <?php
                        $res_concorsi = $con->query("SELECT * FROM concorsi WHERE abilitato=1 ORDER BY denominazione");
                        while($row = $res_concorsi->fetch_object()){
                            $id_concorso=$row->id;
                            $denominazione_concorso=$row->denominazione;
                            echo "<option value='".$id_concorso."'>".$denominazione_concorso."</option>";
                        }
                    ?> 
                </select>
            </div>
            <hr></hr>
            <div class="d-flex justify-content-center">
                <label for="formFileLg" class="form-label">Scegli un file zip: <input type="file" name="zip_file" /></label>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
        <hr></hr>
    </body>
</html>


