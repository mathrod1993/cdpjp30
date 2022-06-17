<!DOCTYPE html>

<?php 
  
include 'user.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
$sql="SELECT * FROM concours
JOIN club on concours.club_numero_club = club.numero_club
JOIN periode on concours.periode_type_periode = periode.type_periode
JOIN boulodromes on concours.boulodromes_adresse = boulodromes.numero_boulodrome
JOIN type_jeu on concours.type_jeu_numero_type_jeu = type_jeu.numero_type_jeu
JOIN type_competition on concours.type_competition_numero_competition = type_competition.numero_competition
WHERE numero_concours='$id'";
$result=mysqli_query($con,$sql);
$row=mysqli_fetch_array($result);
	
	}
	else{
	header('Location: concours_index.php');
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
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
        
        <!-- On charge le code JavaScript de la librairie leaflet -->
        <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
		
        <!-- main CSS -->
		<link rel="stylesheet" type="text/css" media="screen" href="main.css" />

</head>

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
<?php echo $row['nom_boulodrome']; ?></p></div>
<div><p>Club organisateur:<br>
<?php echo $row['nom_club']; ?></p></div>
<div><p>Type du concours:<br>
<?php echo $row['nom_competition']; ?></p></div>
<div><p>Date du concours:<br>
<?php echo $row['date']; ?>&nbsp;à&nbsp;<?php echo $row['horaire_debut']; ?></p></div>
<div><p>Type de jeu:<br><?php echo $row['nom_type_jeu']; ?></p></div>
<div><p>Dotation:<br><?php echo $row['dotation']; ?></p></div>
<div><p>Disposition et Option d'équipe:<br><?php echo $row['disposition_equipe']; ?></p></div>
<?php 
if (!empty($row['commentaire']))
{?><div class="div-oneblock"><p>Commentaire:<br><?php echo $row['commentaire']; ?></p></div>	
<?php } ?>


</div>
<div class="div-arbitre-container">
<div class="div-oneblock" id="concoursmapsquare"><p>Lieu:</p>
<div id="map"></div>

<script>
window.addEventListener( "load", function( event ) {    
    var map = L.map( 'map' /* the id of the tag used for map injection */ );
    map.setView( [<?php echo $row['latitude_boulodrome']; ?> /*latitude*/, <?php echo $row['longitude_boulodrome']; ?> /*longitude*/], 12 /*zoom*/ );
    
    
    // --- We add a layer based on OpenStreetMap ---
    L.tileLayer( 'http://tile.openstreetmap.org/{z}/{x}/{y}.png' ).addTo(map);   // Base Map
    
	
	
	
	let customicon= {'marker-color': '#00FFFF'}
	let greenmark= {
		iconUrl:"marker/marker-icon-green.png"
	}
	let concoursMark = L.icon(greenmark);
	
	let optionConcours = {
		icon:concoursMark
		}
	
	//var marker = L.marker(new L.LatLng(a[0], a[1]), {icon: L.map.marker.icon({'marker-symbol': 'car', 'marker-color': '#00FFFF'}),title: title});
    // --- We add a marker, with events, to the map ---
    var marker<?php echo $row['numero_concours']; ?> = L.marker( [ <?php echo $row['latitude_boulodrome']; ?>, <?php echo $row['longitude_boulodrome']; ?> ] , optionConcours)
                  .bindPopup( "<?php echo $row['nom_boulodrome']; ?>" )
                  .addTo( map );

    

});
</script>
</div>
</div>


</section>

<div class="mainblock">
	
</div>
</main>
	
</body>

</html>