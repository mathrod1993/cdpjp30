<?php 
  
include 'user.php';

$fetcharbitre="SELECT nom_arbitre from arbitre where numero_license='$select[$i]'";
$arbitresearch = $con->query($fetcharbitre);
if($arbitresearch->num_rows>0){
	while($row = $arbitresearch->fetch_assoc())
	{$arbitrenom= $row['nom_arbitre'];}
}

$fetcharbitre="SELECT prenom_arbitre from arbitre where numero_license='$select[$i]'";
$arbitresearch = $con->query($fetcharbitre);
if($arbitresearch->num_rows>0){
	while($row = $arbitresearch->fetch_assoc())
	{$arbitreprenom= $row['prenom_arbitre'];}
}

  ?>