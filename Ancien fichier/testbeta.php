

<!doctype html>
<html>
 <head>
<meta charset="utf-8">
  <title>TEAM DATA</title>
 
 
 </head>
 <body>
  <main>
 <div>
 <p id="distanceset"></p>
 <p id="distancetotal"></p>
 <script>
 /*
let request = new XMLHttpRequest();

request.open('POST', "https://api.openrouteservice.org/v2/matrix/driving-car");

request.setRequestHeader('Accept', 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8');
request.setRequestHeader('Content-Type', 'application/json');
request.setRequestHeader('Authorization', '5b3ce3597851110001cf6248fa8c3cbcf0ae4412ab06d851c4642ffe');

request.onreadystatechange = function () {
  if (this.readyState === 4) {
    console.log('Status:', this.status);
    console.log('Headers:', this.getAllResponseHeaders());
    console.log('Body:', this.responseText);
	var calculdistance = JSON.parse(this.responseText);
	var distance = calculdistance.distances;
	distanceset.innerHTML = distance;
	var distancea = distance[1][0];
	var distanceb = distance[0][1];
	var distancesomme = distancea + distanceb;
	distancetotal.innerHTML = distancesomme.toFixed(2);
	//distanceb.innerHTML = typeof distance;
  } 
};

const body = '{"locations":[[4.360054,43.836699],[4.083352,44.127204]],"metrics":["distance"],"resolve_locations":"true","units":"km"}';

request.send(body);

*/
 </script>
</div> 
  

<form method="post">
Type A: <input type="checkbox" name="selection[]" value="sel a"><br>
Type B: <input type="checkbox" name="selection[]" value="sel b"><br>
Type C: <input type="checkbox" name="selection[]" value="sel c"><br>
Type D: <input type="checkbox" name="selection[]" value="sel d"><br>
Type E: <input type="checkbox" name="selection[]" value="sel e"><br>
<input type="submit" name="sendvalue" value="Envoyer">
</form>

<?php
include 'user.php';

session_start();
$valstring="30dedans10";
$valstring=substr($valstring, 0, -2);
$numberget= preg_replace('/[^0-9]/', '', $valstring);
echo $numberget;

$heureconcours = "select * from concours
	JOIN periode on concours.periode_type_periode = periode.type_periode
	WHERE numero_concours=1";
	
	$resulthc = $con->query($heureconcours);
	$horairerow=mysqli_fetch_array($resulthc);
echo $horairerow['horaire_debut'];



if(isset($_POST['sendvalue'])){
$select = $_POST["selection"];
if (count($select) < 4){
$_SESSION['picklist'] = implode('<br>',$select);
$_SESSION['testvalue'] = $select;
//$b = implode('<br>',$select);
//echo $b;
?>
<form method="post">    
<?php
$fetchclub="select nom_club from club where numero_club=139";
$clubsearch = $con->query($fetchclub);
if($clubsearch->num_rows>0){while($row = $clubsearch->fetch_assoc()){$clubpick= $row['nom_club'];}}
$fetchtotal="select * from club";
$totalsearch = $con->query($fetchtotal);
$totalclub = mysqli_num_rows ( $totalsearch );
//if (count($select) > 1){echo "we recommend you to pick" . $_SESSION['testvalue'][1] . "<br>";}
if (count($select) > 1){echo "welcome to " . $clubpick . "<br>";
						echo "There is actually " . $totalclub . " clubs right currently.<br>";}
$i = 0;
while($i < count($select)){
?>
<input type="radio" id="mainpick<?php echo $select[$i] ?>" name="toppick" value="<?php echo $select[$i] ?>">
  <label for="mainpick<?php echo $select[$i] ?>"><?php echo $select[$i] ?></label><br>
<?php
$i++;
}
?>
<input type="submit" name="sendpick" value="Envoyer">
</form>
<?php
}
else{
    echo "Veuillez choisir 3 option ou moins.";
}
}
if(isset($_POST['sendpick'])){
    $pick = $_POST["toppick"];
    echo "Le choix final est:".  $pick;
    echo $_SESSION['picklist'];
	session_unset();
    }
?>
</main>
</body>
</html>
