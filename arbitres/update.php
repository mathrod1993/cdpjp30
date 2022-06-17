<?php 
  
include 'user.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
$sql="SELECT * FROM arbitre WHERE numero_license='$id'";
$result=mysqli_query($con,$sql);
$row=mysqli_fetch_array($result);
	}
	else{
	header('Location: page_arbitres.php');
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
    <label for="nom">Nom de l'arbitre:</label>
    <input type="text" id="nom" name="nom" value="<?php echo $row['nom_arbitre']; ?>"  required>
    <label for="prenom">Prénom de l'arbitre:</label>
    <input type="text" id="prenom" name="prenom" value="<?php echo $row['prenom_arbitre']; ?>"  required>
	<label for="commune">commune:</label>
    <input type="text" id="commune" name="commune" value="<?php echo $row['communes_code_insee']; ?>"  required>
	<label for="club">club:</label>
    <input type="text" id="club" name="club" value="<?php echo $row['club_numero_club']; ?>"  required>
	<label for="grade">Grade:</label>
  <select id="grade" name="grade">
  <option value="<?php echo $row['grade_arbitre_numero_grade']; ?>" selected hidden>Current Grade</option>
    <option value="1">Départemental</option>
    <option value="2">Régional</option>
    <option value="3">National</option>
    <option value="4">Européen</option>
	<option value="5">International</option>
	<option value="6">Pool Elite</option>
  </select>
  <input type="hidden" name="currentdata" value="<?php echo $row['numero_license']; ?>" >
    <button type="submit"  name="up">Update</button>
  </form>
  <button onclick="location.href='page_arbitres.php'">Cancel</button>

<?php 
if (isset($_POST['currentdata'])) {
	$ident = $_POST['currentdata'];
	
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$commune = $_POST['commune'];
	$club = $_POST['club'];
	$grade = $_POST['grade'];
	
	$query="UPDATE arbitre SET nom_arbitre = '$nom', prenom_arbitre = '$prenom'
	, communes_code_insee = '$commune', club_numero_club = '$club', grade_arbitre_numero_grade = '$grade'
	WHERE numero_license='$ident' ";
	$queryrun=mysqli_query($con,$query);
	if($query){
		echo "<p>Data updated.</p>";
		header('Location: page_arbitres.php');}
		else{
		echo "<p>Failed to update data.</p>";
		header('Location: page_arbitres.php');}
		
}

  ?>	
	
</body>

</html>