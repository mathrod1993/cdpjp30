<?php 
  
include 'user.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
$query="DELETE FROM arbitre WHERE numero_license='$id'";
	}

$run=mysqli_query($con,$query);
if($query){
		echo "<p>Data deleted.</p>";
		header('Location: page_arbitres.php');
		}
		else{
		echo "<p>Failed to delete data.</p>";
		header('Location: page_arbitres.php');
		}
?>