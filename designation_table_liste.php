<?php

include 'user.php';

$acid = $_SESSION['concourid'];

$sqlac = "select * from arbitre_concours
JOIN arbitre on arbitre_concours.arbitre_numero_license = arbitre.numero_license
JOIN grade_arbitre on arbitre.grade_arbitre_numero_grade = grade_arbitre.numero_grade
WHERE concours_numero_concours='$acid'";

$resultac = $con->query($sqlac);
$totalac = mysqli_num_rows ( $resultac );

if ($totalac < 1){echo "Il n'y a aucun arbitre pour ce concours.<br>";} else {
$checkchef = "select * from arbitre_concours
JOIN arbitre on arbitre_concours.arbitre_numero_license = arbitre.numero_license
JOIN grade_arbitre on arbitre.grade_arbitre_numero_grade = grade_arbitre.numero_grade
WHERE concours_numero_concours='$acid' AND est_chef=1";
$confirmchef = $con->query($checkchef);
$unchef = mysqli_num_rows ( $confirmchef );
if ($unchef == 1){?>
<table>
	<thead>
	<tr>
	<th class="bordertab">Nom & Prénom</th>
	<th class="bordertab">Grade</th>
	<th class="bordertab">Option</th>
	</tr>
	</thead>
    <tbody>
      <?php
	  if($resultac->num_rows>0){
		  while($row = $resultac->fetch_assoc()){
	  ?>
	  <tr>
	<td class="bordertab"><?php echo $row['nom_arbitre'] . " " . $row['prenom_arbitre']; ?>
	<?php 
if ($row['est_chef'] == 1)
{?><br>	<p>(Arbitre Chef)</p>
<?php } ?> </td>
	<td class="bordertab"><img src="logo/<?php echo $row['logo_grade']; ?>" width="100px"></td>
	<td class="bordertab">
	<form method="post">
	<input type="hidden" name="arbid" value="<?php echo $row['numero_license']; ?>">
	<input type="submit" name="retirearb" value="Retirer">
	</form>
	</td>
	</tr>
	  <?php
	  
		  }
	  }
	  
	  ?>
    </tbody>
  </table>	
	
	
<?php
}
elseif ($unchef == 0){echo "Merci de bien vouloir choisir un chef.<br>";
?>
<form method="post">
<select id="arbitrenonchef" name="arbitrenonchef">
<?php
if($resultac->num_rows>0){
		  while($row = $resultac->fetch_assoc()){
  ?>
  <option value="<?php echo $row['numero_license']; ?>"><?php echo $row['nom_arbitre'] . " ". $row['prenom_arbitre']; ?></option>
   <?php 
		  }
	  }
	  ?>
  </select>
<input type="submit" name="selectchef" value="Envoyer"><br>

</form>

<?php
}
elseif ($unchef > 1 ){echo "ATTENTION: Il y a plus d'un chef d'arbitre. Merci de bien vouloir en enlever.<br>";?>
<table>
	<thead>
	<tr>
	<th class="bordertab">Nom & Prénom</th>
	<th class="bordertab">Grade</th>
	<th class="bordertab">Option</th>
	</tr>
	</thead>
    <tbody>
      <?php
	  if($confirmchef->num_rows>0){
		  while($row = $confirmchef->fetch_assoc()){
	  ?>
	  <tr>
	<td class="bordertab"><?php echo $row['nom_arbitre'] . " " . $row['prenom_arbitre']; ?>
	<?php 
if ($row['est_chef'] == 1)
{?><br>	<p>(Arbitre Chef)</p>
<?php } ?> </td>
	<td class="bordertab"><img src="logo/<?php echo $row['logo_grade']; ?>" width="100px"></td>
	<td class="bordertab">
	<form method="post">
	<input type="hidden" name="arbid" value="<?php echo $row['numero_license']; ?>">
	<input type="submit" name="retirearb" value="Retirer">
	</form>
	</td>
	</tr>
	  <?php
	  
		  }
	  }
	  
	  ?>
    </tbody>
  </table>	
	
	
<?php
}
} 

if (isset($_POST['retirearb'])) {
	$id = $_POST['arbid'];
	$cid = $_SESSION['concourid'];
	
$query="DELETE FROM arbitre_concours WHERE arbitre_numero_license='$id' and concours_numero_concours='$cid'";


$run=mysqli_query($con,$query);
if($query){
		echo "<p>Data deleted.</p>";
		session_destroy();
		//header('Location: designation_arbitre.php');
		echo '<script language="JavaScript" type="text/javascript">window.location.replace("designation_arbitre.php");</script>';
		}
		else{
		echo "<p>Failed to delete data.</p>";
		session_destroy();
		//header('Location: designation_arbitre.php');
		echo '<script language="JavaScript" type="text/javascript">window.location.replace("designation_arbitre.php");</script>';
		}
		
		}

if(isset($_POST['selectchef'])){
	include 'user.php';

    $chef = $_POST["arbitrenonchef"];
	$idconcours = $_SESSION['concourid'];
    $i = 0;
	
	$query="UPDATE arbitre_concours SET est_chef = 1
	WHERE concours_numero_concours='$idconcours' AND arbitre_numero_license='$chef'";
		
	$run=mysqli_query($con,$query);
		if($query){
		echo "<p>Data updated.</p>";
		}
		else{
		echo "<p>Failed to update data.</p>";
		}	
		
	session_destroy();
	//header('Location: designation_arbitre.php');
	echo '<script language="JavaScript" type="text/javascript">window.location.replace("designation_arbitre.php");</script>';
    }		
		

?>