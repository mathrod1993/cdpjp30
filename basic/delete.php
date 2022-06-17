<?php 
  
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'pjp30user';

$con = mysqli_connect($host, $user, $pass, $db);


if (isset($_GET['id'])) {
	$id = $_GET['id'];
$query="DELETE FROM grille_tarif WHERE id='$id'";
	}

$run=mysqli_query($con,$query);
if($query){
		echo "<p>Data deleted.</p>";
		header('Location: tarif.php');
		}
		else{
		echo "<p>Failed to delete data.</p>";
		header('Location: tarif.php');
		}

?>