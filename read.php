<?php 
session_start();
require 'sql.php'; 
$connect = $pdo->query('SELECT * FROM hiking ORDER BY id DESC');
if (isset($_GET["status"])) {
	if ($_GET["status"] == "success") {
		$messageReturn = "Votre ajout a bien été envoyé !";
	} elseif ($_GET["status"] == "failed") {
		$messageReturn = "Votre ajout n'a pas pu être envoyé";	      		
	} elseif ($_GET["status"] == "notenoughpermissions") {
		$messageReturn = "Vous n'avez pas les permissions néccesaires !";	      		
	}
	else {
		$messageReturn = "Erreur inconnue !";
	}
}
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Reunion Island</title>
 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
 	<script>
 		function $_GET(param) {
			var vars = {};
			window.location.href.replace( location.hash, '' ).replace( 
				/[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
				function( m, key, value ) { // callback
					vars[key] = value !== undefined ? value : '';
				}
			);

			if ( param ) {
				return vars[param] ? vars[param] : null;	
			}
			return vars;
		}
 	</script>
 </head>
 <body>
 	<?php include 'includes/navbar.php' ?>
 	<?php 
 	if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
 		echo 'Vous êtes connecté en tant que '. $_SESSION['username'] . '<br> Votre mot de passe crypté est : '. $_SESSION['password'].'<br>';
 		echo '<a href="logout.php">Cliquez ici pour vous déconnnectez !</a>';
 	} else {
 		echo '<a href="index.php">Cliquez ici pour vous connectez !</a>';
 	}
 	 ?>
 	<h1>Liste des randonnées</h1>
 	<table class="table table-dark ">
	  <thead>
	    <tr>
	      <th scope="col">Nom</th>
	      <th scope="col">Difficulté</th>
	      <th scope="col">Distance</th>
	      <th scope="col">Durée</th>
	      <th scope="col">Dénivelé</th>
	      <th scope="col">Disponible</th>
	      <th colspan="2" class="text-center">Modification</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php 
	  	while ($row = $connect->fetch()) {
		    echo "<tr>
		    		<td>".$row['name']."</td>
		    		<td>".$row['difficulty']."</td>
		    		<td>".$row['distance']."km </td>
		    		<td>".$row['duration']."</td>
		    		<td>".$row['height_difference']."m </td>
		    		<td>".$row['available']."</td>
		    		<td>
		    			<a href='update.php?id=".$row['id']."'>EDIT</a>
		    		</td>
		    		<td>
		    			<a href='delete.php?id=".$row['id']."'>DELETE</a>
		    		</td>
		    	</tr>";
		} 
		?>
	  </tbody>
	</table>	
	<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
	    	<?php echo $messageReturn; ?>
	    </div>
	  </div>
	</div>
	<script>
		var $_GET = $_GET(),
		    status = $_GET['status'];
		if (status != "undefined") {
			$('.bd-example-modal-sm').modal();
		}
	</script>
 </body>
 </html>