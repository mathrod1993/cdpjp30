<?php 
  
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'pjp30user';

$con = mysqli_connect($host, $user, $pass, $db);

if (isset($_GET['id'])) {
	$id = $_GET['id'];
$sql="SELECT * FROM grille_tarif WHERE id='$id'";
$result=mysqli_query($con,$sql);
$row=mysqli_fetch_array($result);
	}
	else{
	header('Location: tarif.php');
	}






  ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Grille Tarifaire</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Lato&display=swap"
            rel="stylesheet"
        />
        <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
		<!--<script src="main.js"></script>-->

</head>

<body>
  <form method="POST">
    <label for="name">Nom de la compétition:</label>
    <input type="text" id="nom_competition" name="nom_competition" value="<?php echo $row['competition']; ?>" required>
    <label for="score">Montant en Euro:</label>
    <input type="number" id="montant" name="montant" value="<?php echo $row['montant']; ?>"  required>
	<input type="hidden" name="currentdata" value="<?php echo $row['id']; ?>" >
    <button type="submit" name="up">Update</button>
  </form>
  <button onclick="location.href='tarif.php'">Cancel</button>

<?php 
if (isset($_POST['currentdata'])) {
	$ident = $_POST['currentdata'];
	
	$nom = $_POST['nom_competition'];
	$montant = $_POST['montant'];
	
	
	$query="UPDATE grille_tarif SET competition = '$nom', montant = '$montant' WHERE id='$ident' ";
	$queryrun=mysqli_query($con,$query);
	if($query){
		echo "<p>Data updated.</p>";
		header('Location: tarif.php');}
		else{
		echo "<p>Failed to update data.</p>";
		header('Location: tarif.php');}
		
}

  ?>	
	
</body>

</html>