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


// Get status message
if(!empty($_GET['status'])){
    switch($_GET['status']){
        case 'succ':
            $statusType = 'alert-success';
            $statusMsg = 'I dati sono stati importati correttamente.';
            break;
        case 'err':
            $statusType = 'alert-danger';
            $statusMsg = 'Problema non previsto. Riprova.';
            break;
        case 'invalid_file':
            $statusType = 'alert-danger';
            $statusMsg = 'Per favore carica un file CSV valido.';
            break;
        default:
            $statusType = '';
            $statusMsg = '';
    }
}

?>


<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="utf-8">
	<title>Carica CSV</title>

    <!-- Bootstrap library -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    <!-- Display status message -->
    <?php if(!empty($statusMsg)){ ?>
        <div class="col-xs-12">
            <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
        </div>
    <?php } ?>

    <div class="row">
        <form action="import_data.php" method="post" enctype="multipart/form-data">
            <div class="col-md-12">

            <label for="concorsi">Scegli un conocrso</label>
            <!--Prendo dal db il nome dei concorsi -->
           


            <select name="select_concorso">
                <?php
                    $res_concorsi = $con->query("SELECT * FROM concorsi WHERE abilitato=1 ORDER BY id DESC");
                    while($row = $res_concorsi->fetch_object()){
                        $id_concorso=$row->id;
                        $denominazione_concorso=$row->denominazione;
                        echo "<option value='".$id_concorso."'>".$denominazione_concorso."</option>";
                    }
                ?> 
            </select>
            <!-- CSV file upload form -->
            <div class="col-md-12" id="importFrm" style="display: none;">
            
                <input type="file" name="file" />
                <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
        
            </div>
        </form>
    
    </div>

        <!-- Import link -->
        <div class="col-md-12 head">
            <div class="float-right">
                <a href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="plus"></i> Import</a>
            </div>
        </div>


        <!-- Data list table --> 
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Codice Anagrafica</th>
                    <th>Codice Risposte</th>
                </tr>
            </thead>

            <tbody>
                <?php
                // Get member rows
                $result = $con->query("SELECT * FROM accounts ORDER BY id DESC");
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                ?>
                <tr>
                    <td><?php echo $row['cod_anagrafica']; ?></td>
                    <td><?php echo $row['cod_risposte']; ?></td>
                </tr>
                <?php } }else{ ?>
                    <tr><td colspan="5">Nessun utente trovato!</td></tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</body>

<!-- Show/hide CSV upload form -->
<script>
function formToggle(ID){
    var element = document.getElementById(ID);
    if(element.style.display === "none"){
        element.style.display = "block";
    }else{
        element.style.display = "none";
    }
}
</script>

</html>