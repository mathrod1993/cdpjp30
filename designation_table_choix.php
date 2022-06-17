<?php
include 'user.php';

$idconcours = $_SESSION['concourid'];
$checklimit = "select * from arbitre_concours WHERE concours_numero_concours='$idconcours'";
$confirmlimit = $con->query($checklimit);
$limit = 3 - mysqli_num_rows ( $confirmlimit );

$fetchconcours="SELECT date from concours where numero_concours='$idconcours'";
$concourssearch = $con->query($fetchconcours);
if($concourssearch->num_rows>0){
	while($row = $concourssearch->fetch_assoc())
	{$concoursno= $row['date'];}
}


if ($limit == 0){
	echo "Le concours contient 3 arbitres. Il n'est plus possible d'en ajouter.";
}else{
$resultarb = $_SESSION['totalarbitre'];
	?>
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
		$arbitreno = $row['numero_license'];
		/*$checkarbitre = "select * from arbitre_concours WHERE arbitre_numero_license='$arbitreno' and concours_numero_concours='$idconcours'";
		$checkdone = $con->query($checkarbitre);
		$checkcounta = mysqli_num_rows ( $checkdone );
		$checkavailable = "select * from arbitre_concours
		JOIN concours on arbitre_concours.concours_numero_concours = concours.numero_concours
		WHERE date='$concoursno'";
		$availabledone = $con->query($checkavailable);
		$checkcountb = mysqli_num_rows ( $availabledone );
		if($checkcounta == 0 and $checkcountb >= 1)*/
		$checkavailable = "select * from arbitre_concours
		JOIN concours on arbitre_concours.concours_numero_concours = concours.numero_concours
		WHERE date='$concoursno' and arbitre_numero_license='$arbitreno'";
		$availabledone = $con->query($checkavailable);
		$checkcount = mysqli_num_rows ( $availabledone );
		if($checkcount == 0)
		{
	  ?>
	  <tr>
	<td class="bordertab"><?php echo $row['nom_arbitre']; ?></td>
	<td class="bordertab"><?php echo $row['prenom_arbitre']; ?></td>
	<td class="bordertab"><?php echo $row['nom_commune']; ?></td>
	<td class="bordertab" id="trajet<?php echo $row['numero_license']; ?>"></td>
	<td class="bordertab" id="tarif<?php echo $row['numero_license']; ?>"></td>
	<td class="bordertab" id="arbitreno<?php echo $row['numero_license']; ?>"><input type="checkbox" name="choixarbitre[]" value="<?php echo $row['numero_license']; ?>"></td>
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

$setheure = $concourrow['periode_type_periode'];
$heureconcours = "select horaire_debut from periode WHERE type_periode='$setheure'";
$resultheure = $con->query($heureconcours);
if($resultheure->num_rows>0){
	while($findhour = $resultheure->fetch_assoc())
	{$horaireentier= $findhour['horaire_debut'];}
	$horaireentier=substr($horaireentier, 0, -2);}
?>
	let horaire = "<?php echo $horaireentier; ?>";
	let horairematin = 0;
	horaire = horaire.match(/\d+/g);
	if (horaire < 13) {
    horairematin = 16;
	} else {
    horairematin = 0;
	}
	
	let coutarbitre = coutdeplacement + forfait + horairematin;
	tarif<?php echo $row['numero_license']; ?>.innerHTML = coutarbitre.toFixed(2) + " €";
  } 
};

const body<?php echo $row['numero_license']; ?> = '{"locations":[[<?php echo $row["long_commune"]; ?>,<?php echo $row["lat_commune"]; ?>],[<?php echo $concourrow["longitude_boulodrome"]; ?>,<?php echo $concourrow["latitude_boulodrome"]; ?>]],"metrics":["distance"],"resolve_locations":"true","units":"km"}';

request<?php echo $row['numero_license']; ?>.send(body<?php echo $row['numero_license']; ?>);


 </script>
	</tr>
	  <?php
	  }
		  }
	  }
	  
	  ?>
    </tbody>
  </table>
<input type="submit" name="listearbitre" value="Envoyer"><br>
</form>

<?php
}	
//header('Location: designation_arbitre.php');

if(isset($_POST['listearbitre'])){
$select = $_POST["choixarbitre"];
$idconcours = $_SESSION['concourid'];
$checklimit = "select * from arbitre_concours WHERE concours_numero_concours='$idconcours'";
$confirmlimit = $con->query($checklimit);
$limit = 3 - mysqli_num_rows ( $confirmlimit );

if (count($select) <= $limit){
	$_SESSION['arbitrechoisi'] = $select;
$checkchef = "select * from arbitre_concours WHERE concours_numero_concours='$idconcours' AND est_chef=1";
$confirmchef = $con->query($checkchef);
$unchef = mysqli_num_rows ( $confirmchef );
	if ($unchef > 0){
	echo "On ajoute les arbitres choisis.";
	
	include 'user.php';

	$idconcours = $_SESSION['concourid'];
    $i = 0;
	while($i < count($_SESSION['arbitrechoisi'])){
	$licencearbitre = $_SESSION['arbitrechoisi'][$i];
	
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
	
	
	session_destroy();
	//header('Location: designation_arbitre.php');
	echo '<script language="JavaScript" type="text/javascript">window.location.replace("designation_arbitre.php");</script>';
}
else{
	if (count($select) == 1){
		 echo "Le seul arbitre choisis est chef.";
		 include 'user.php';

	$idconcours = $_SESSION['concourid'];
    $i = 0;
	while($i < count($_SESSION['arbitrechoisi'])){
	$licencearbitre = $_SESSION['arbitrechoisi'][$i];
	
	$query="insert into arbitre_concours (arbitre_numero_license, concours_numero_concours, est_chef)
		values ('$licencearbitre','$idconcours',1)";
		
	$run=mysqli_query($con,$query);
		if($query){
		echo "<p>Data added.</p>";
		}
		else{
		echo "<p>Failed to add data.</p>";
		}	
		
$i++;
}
	session_destroy();
	echo '<script language="JavaScript" type="text/javascript">window.location.replace("designation_arbitre.php");</script>';
	//header('Location: designation_arbitre.php');	 
	} else{ //CHOIX DU CHEF DES ARBITRES
?>
<form method="post">
<select id="mainpick" name="arbitrechef">
<?php
		$i = 0;
while($i < count($select)){
	include 'designation_sqlarbitresearch.php';
?>
<option value="<?php echo $select[$i] ?>"><?php echo $arbitrenom . " " . $arbitreprenom ?></option>
<?php
$i++;
}
?>
<input type="submit" name="pickchef" value="Envoyer"><br>

</form>
<?php
		 echo "Veuillez choisir un Chef.";
	} 
}
	//FIN SELECTION ARBITRE
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
		
$i++;
}
	session_destroy();
	//header('Location: designation_arbitre.php');
	echo '<script language="JavaScript" type="text/javascript">window.location.replace("designation_arbitre.php");</script>';
    }
	
?>