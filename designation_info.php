<!DOCTYPE html>

<?php 
session_start();
  
include 'user.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$_SESSION['concourid'] = $id;
$sqlccr = "select * from concours
JOIN club on concours.club_numero_club = club.numero_club
JOIN periode on concours.periode_type_periode = periode.type_periode
JOIN boulodromes on concours.boulodromes_adresse = boulodromes.numero_boulodrome
JOIN type_jeu on concours.type_jeu_numero_type_jeu = type_jeu.numero_type_jeu
JOIN type_competition on concours.type_competition_numero_competition = type_competition.numero_competition
WHERE numero_concours='$id'";

$sqlarb = "select * from arbitre
JOIN communes on arbitre.communes_code_insee = communes.code_insee";

$resultccr = $con->query($sqlccr);
$concourrow=mysqli_fetch_array($resultccr);

$_SESSION['totalarbitre'] = $con->query($sqlarb);
}
else{
header('Location: designation_arbitre.php');
}

  ?>

<html>

<head>
	<meta charset = "UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Concours</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Lato&display=swap"
            rel="stylesheet"
        />
        <!-- On charge la CSS leaflet -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" />
		
		<!-- Ces deux balises link sont à insérer entre les deux balises existantes -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

        
        		<!-- On charge le code JavaScript de la librairie leaflet -->
        <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
		
		<!-- Ces deux balises script sont à insérer entre les deux balises existantes -->
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
		
        <!-- main CSS -->
		<link rel="stylesheet" type="text/css" media="screen" href="main.css" />
		
		</head>

<!--<script src="main.js"></script>-->





<body>
<header>
<?php 
  
include 'navigation.php';

  ?>
</header>
<main>

<section id="datalist">
<div class="div-arbitre-container">
<div class="div-oneblock"><p>Lieu:<br>
<?php echo $concourrow['nom_boulodrome']; ?></p></div>
<div><p>Club organisateur:<br>
<?php echo $concourrow['nom_club']; ?></p></div>
<div><p>Type du concours:<br>
<?php echo $concourrow['nom_competition']; ?></p></div>
<div><p>Date du concours:<br>
<?php echo $concourrow['date']; ?>&nbsp;à&nbsp;<?php echo $concourrow['horaire_debut']; ?></p></div>
<div><p>Type de jeu:<br><?php echo $concourrow['nom_type_jeu']; ?></p></div>
<div><p>Dotation:<br><?php echo $concourrow['dotation']; ?></p></div>
<div><p>Disposition et Option d'équipe:<br><?php echo $concourrow['disposition_equipe']; ?></p></div>
<?php 
if (!empty($concourrow['commentaire']))
{?><div class="div-oneblock"><p>Commentaire:<br><?php echo $concourrow['commentaire']; ?></p></div>	
<?php } ?>


</div>

<div class="div-designation-container">
<div id="designationmapsquare"><p>Lieu:</p>
<div id="map" class="divmap"></div>
</div>
<div style="padding: 0">
<?php include 'designation_table_liste.php';  ?>

  </div> 

</div>
<div class="div-designation-container">
<div class="div-oneblock">
<?php include 'designation_table_choix.php';  ?>
</div>
</div>

</main>
<script>
window.addEventListener( "load", function( event ) {    
    var map = L.map( 'map' /* the id of the tag used for map injection */ );
    map.setView( [43.9446996 /*latitude*/, 4.1513764 /*longitude*/], 8	/*zoom*/ );
    
    
    // --- We add a layer based on OpenStreetMap ---
    L.tileLayer( 'http://tile.openstreetmap.org/{z}/{x}/{y}.png' ).addTo(map);   // Base Map
    
	
	
	
	let customicon= {'marker-color': '#00FFFF'}
	let greenmark= {
		iconUrl:"marker/marker-icon-red.png"
	}
	let concoursMark = L.icon(greenmark);
	
	let optionConcours = {
		icon:concoursMark
		}
		
	let redmark= {
		iconUrl:"marker/marker-icon-blue.png"
	}
	let arbitreMark = L.icon(redmark);
	
	let optionarbitre = {
		icon:arbitreMark
		}
	
	//var marker = L.marker(new L.LatLng(a[0], a[1]), {icon: L.map.marker.icon({'marker-symbol': 'car', 'marker-color': '#00FFFF'}),title: title});
    // --- We add a marker, with events, to the map ---
	
	//let marker = L.marker( [ 44.019629, 4.415236 ] , optionConcours)
    //              .bindPopup( "nom" )
    //              .addTo( map );
			  
	
var marker = L.marker( [ <?php echo $concourrow['latitude_boulodrome']; ?>, <?php echo $concourrow['longitude_boulodrome']; ?>] , optionConcours)
                  .bindPopup( "<?php echo $concourrow['nom_boulodrome']; ?>" )
                  .addTo( map );	
	
	  <?php
	  $resultarm = $con->query($sqlarb);
	  if($resultarm->num_rows>0){
		  while($row = $resultarm->fetch_assoc()){
	  ?>
	  
		var route<?php echo $row['numero_license']; ?> = L.Routing.control({
		waypoints: [
        L.latLng(<?php echo $row['lat_commune']; ?>, <?php echo $row['long_commune']; ?>),
        L.latLng(<?php echo $concourrow['latitude_boulodrome']; ?>, <?php echo $concourrow['longitude_boulodrome']; ?>)
		],
		createMarker: function() { return null; },
		routeWhileDragging: false,
		addWaypoints: false,
		show: false,
		draggableWaypoints: false
		}).addTo(map);

		var mark<?php echo $row['numero_license']; ?> = L.marker( [ <?php echo $row['lat_commune']; ?>, <?php echo $row['long_commune']; ?> ], optionarbitre)
                  .bindPopup( "<?php echo $row['nom_commune']; ?>" )
                  .addTo( map );
	  <?php
	  
		  }
	  }
	  ?>


	
	
});
</script>
<footer>
<?php 
echo '<script type="text/javascript">routecheck();</script>';
  
include 'copyright.php';

  ?>
</footer>
</body>

</html>