<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

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



if(isset($_POST['importSubmit'])){

    $id_concorso_sel = $_POST['select_concorso'];
    
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
        
        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            $first_line = true;
           
            
            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile,1000,";")) !== FALSE){
                
                if($first_line){
                    $first_line = false;
                    continue;
                } 
                // Get row data
                $cod_anagrafica = $line[0];
                $cod_risposte  = $line[1];

                $con->query("DELETE * FROM accounts WHERE id_concorso = $id_concorso_sel");
                $con->query("INSERT INTO accounts (cod_anagrafica,cod_risposte,id_concorso) VALUES('".$cod_anagrafica."','".$cod_risposte."','".$id_concorso_sel."')");
            }
            
            // Close opened CSV file
            fclose($csvFile);
            
            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

// Redirect to the listing page
header("Location: upload_csv.php".$qstring);