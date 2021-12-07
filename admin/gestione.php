<?php
include('db.php');
// We need to use sessions, so you should always start sessions using the below code.
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

if (isset($_GET['edit'])) {
	$id = $_GET['edit'];
	$update = true;
	$record = mysqli_query($db, "SELECT * FROM concorsi WHERE id=$id");

	if (count(array($record)) == 1 ) {
		$n = mysqli_fetch_array($record);
		$denominazione = $n['denominazione'];
		$abilitato = $n['abilitato'];
	}
}


?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Gestione Concorsi</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
	<?php if (isset($_SESSION['message'])): ?>
	<div class="msg">
		<?php 
			echo $_SESSION['message']; 
			unset($_SESSION['message']);
		?>
	</div>
	<?php endif ?>
		<nav class="navtop">
			<div>
				<h1>Gestione Concorsi</h1>
				<a href="home.php"><i class="fas fa-home"></i>Home</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>


			</div>
		</nav>

	<form method="post" action="db.php" >
	<?php $results = mysqli_query($db, "SELECT * FROM concorsi"); ?>

<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Denominazione</th>
			<th>Abilitato</th>
			<th colspan="2">Azione</th>
		</tr>
	</thead>
	
	<?php while ($row = mysqli_fetch_array($results)) { ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['denominazione']; ?></td>
			<td><?php echo $row['abilitato']; ?></td>
			
			<td>
				<a href="gestione.php?edit=<?php echo $row['id']; ?>" class="edit_btn" >Modifica</a>
			</td>
			<td>
				<a href="db.php?del=<?php echo $row['id']; ?>" class="del_btn">Cancella</a>
			</td>
		</tr>
	<?php } ?>
</table>

		<link rel="stylesheet" type="text/css" href="gestione_style.css">
		<div><hr>
		<?php if ($update == true): ?>
			Modifica Concorso
		<?php else: ?>
			Aggiungi Concorso
			<?php endif ?>
		</div>
		<div class="input-group">
			<label>Denominazione</label>
			<input type="text" name="denominazione" value="<?php echo $denominazione; ?>">
			<label>Abilitato</label>
			<input type="text" name="abilitato" value="<?php echo $abilitato; ?>">
			<input type="hidden" name="id" value="<?php echo $id; ?>">

			</div>
		
		<div class="input-group">
		
		<?php if ($update == true): ?>
			<button class="btn" type="submit" name="update" style="background: #556B2F;" >update</button>
		<?php else: ?>
			<button class="btn" type="submit" name="save" >Aggiungi</button>
		<?php endif ?>
		</div>
	</form>
		
	</body>
</html>