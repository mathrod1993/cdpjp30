<form method="post">
<table>
	<thead>
	<tr>
	<th class="bordertab">Nom</th>
	<th class="bordertab">Prénom</th>
	<th class="bordertab">Ville</th>
	<th class="bordertab">Distance <br> AR </th>
	<th class="bordertab">Tarif</th>
	<th class="bordertab">Info</th>
	</tr>
	</thead>
    <tbody>
      <?php
	  if($resultarb->num_rows>0){
		  while($row = $resultarb->fetch_assoc()){
	  ?>
	  <tr>
	<td class="bordertab"><?php echo $row['nom_arbitre']; ?></td>
	<td class="bordertab"><?php echo $row['prenom_arbitre']; ?></td>
	<td class="bordertab"><?php echo $row['nom_commune']; ?></td>
	<td class="bordertab" id="trajet<?php echo $row['numero_license']; ?>"></td>
	<td class="bordertab" id="tarif<?php echo $row['numero_license']; ?>"></td>
	 <script>
let request<?php echo $row['numero_license']; ?> = new XMLHttpRequest();

request<?php echo $row['numero_license']; ?>.open('POST', "https://api.openrouteservice.org/v2/matrix/driving-car");

request<?php echo $row['numero_license']; ?>.setRequestHeader('Accept', 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8');
request<?php echo $row['numero_license']; ?>.setRequestHeader('Content-Type', 'application/json');
request<?php echo $row['numero_license']; ?>.setRequestHeader('Authorization', '5b3ce3597851110001cf6248fa8c3cbcf0ae4412ab06d851c4642ffe');

request<?php echo $row['numero_license']; ?>.onreadystatechange = function () {
  if (this.readyState === 4) {
    console.log('Status:', this.status);
    console.log('Headers:', this.getAllResponseHeaders());
    console.log('Body:', this.responseText);
	let calculdistance = JSON.parse(this.responseText);
	let distance = calculdistance.distances;
	let distancea = distance[1][0];
	let distanceb = distance[0][1];
	let distancesomme = distancea + distanceb;
	distancesomme = distancesomme.toFixed(2);
	trajet<?php echo $row['numero_license']; ?>.innerHTML = distancesomme;
	let coutdeplacement = distancesomme * 0.30;
<?php
	$setgrade = $row['grade_arbitre_numero_grade'];
	$settype = $concourrow['type_competition_numero_competition'];
	$fetchmontant="SELECT remuneration from grille_tarif where grade_arbitre_numero_grade='$setgrade' and type_competition_numero_competition='$settype'";
	$findmontant = $con->query($fetchmontant);
	if($findmontant->num_rows>0){
	while($grillemontant = $findmontant->fetch_assoc())
	{//$montantotal= $grillemontant['remuneration'];
	?>
	let forfait = <?php echo $grillemontant['remuneration']; ?>;
<?php }
}

?>
	let coutarbitre = coutdeplacement + forfait;
	tarif<?php echo $row['numero_license']; ?>.innerHTML = coutarbitre.toFixed(2) + " €";
  } 
};

const body<?php echo $row['numero_license']; ?> = '{"locations":[[<?php echo $row["long_commune"]; ?>,<?php echo $row["lat_commune"]; ?>],[<?php echo $concourrow["longitude_boulodrome"]; ?>,<?php echo $concourrow["latitude_boulodrome"]; ?>]],"metrics":["distance"],"resolve_locations":"true","units":"km"}';

request<?php echo $row['numero_license']; ?>.send(body<?php echo $row['numero_license']; ?>);


 </script>
	<td class="bordertab" id="arbitreno<?php echo $row['numero_license']; ?>"><input type="checkbox" name="choixarbitre[]" value="<?php echo $row['numero_license']; ?>"></td>
	</tr>
	  <?php
	  
		  }
	  }
	  
	  ?>
    </tbody>
  </table>
<input type="submit" name="listearbitre" value="Envoyer"><br>
</form>
<p></p>
<?php
include 'user.php';

if(isset($_POST['listearbitre'])){
$select = $_POST["choixarbitre"];
$idconcours = $_SESSION['concourid'];
$checklimit = "select * from arbitre_concours WHERE concours_numero_concours='$idconcours'";
$confirmlimit = $con->query($checklimit);
$limit = 3 - mysqli_num_rows ( $confirmlimit );

if (count($select) <= $limit and !empty($_POST['choixarbitre'])){
$_SESSION['arbitrechoisi'] = $select;
$checkchef = "select * from arbitre_concours WHERE concours_numero_concours='$idconcours' AND est_chef=1";
$confirmchef = $con->query($checkchef);
$unchef = mysqli_num_rows ( $confirmchef );
if ($unchef > 0){
    $i = 0;
	while($i < count($select)){
	$licencearbitre = $select[$i];
	$query="insert into arbitre_concours (arbitre_numero_license, concours_numero_concours, est_chef)
		values ('$licencearbitre','$idconcours',0)";
		
	$run=mysqli_query($con,$query);
		if($query){
		echo "<p>Data added.</p>";
		}
		else{
		echo "<p>Failed to add data.</p>";
		}	
$i++;
}
	session_unset();
}
else{
	
?>
<form method="post">    
<?php


$i = 0;
while($i < count($select)){
	include 'designation_sqlarbitresearch.php';
?>
<input type="radio" id="mainpick<?php echo $select[$i] ?>" name="arbitrechef" value="<?php echo $select[$i] ?>">
  <label for="mainpick<?php echo $select[$i] ?>"><?php echo $arbitrenom . " " . $arbitreprenom ?></label><br>
<?php
$i++;
}
?>
<input type="submit" name="pickchef" value="Envoyer"><br>

</form>
<?php
}
}
else{
    echo "Veuillez choisir " . $limit ." arbitres ou moins.";
}
}
if(isset($_POST['pickchef'])){
	include 'user.php';

    $chef = $_POST["arbitrechef"];
	$idconcours = $_SESSION['concourid'];
    $i = 0;
	while($i < count($_SESSION['arbitrechoisi'])){
	if ($_SESSION['arbitrechoisi'][$i] == $chef){$setchef = 1;} else {$setchef = 0;}
	$licencearbitre = $_SESSION['arbitrechoisi'][$i];
	
	$query="insert into arbitre_concours (arbitre_numero_license, concours_numero_concours, est_chef)
		values ('$licencearbitre','$idconcours','$setchef')";
		
	$run=mysqli_query($con,$query);
		if($query){
		echo "<p>Data added.</p>";
		}
		else{
		echo "<p>Failed to add data.</p>";
		}	
		
//while($i < count($_SESSION['arbitrechoisi'])){
//if ($_SESSION['arbitrechoisi'][$i] == $chef){echo "le numero " . $_SESSION['arbitrechoisi'][$i] . " est chef" . "<br>";}
//else {echo "le numero " . $_SESSION['arbitrechoisi'][$i] . " n'est pas chef" . "<br>";}
$i++;
}
	session_unset();
	header('Location: designation_arbitre.php');
    }
?>
