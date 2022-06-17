<?php 
  
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'pjp30user';

$con = mysqli_connect($host, $user, $pass, $db);


if(isset($_POST['submit'])){
	
		$nom = $_POST['nom_competition'];
		$montant = $_POST['montant'];
		
		$query="insert into grille_tarif (competition,montant) values ('$nom','$montant')";
		
		$run=mysqli_query($con,$query);
		if($query){
		echo "<p>Data added.</p>";
		header('Location: tarif.php');
		}
		else{
		echo "<p>Failed to add data.</p>";
		header('Location: tarif.php');
		}
		

	
}
  ?>