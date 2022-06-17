<!DOCTYPE html>

<?php 
  
include 'user.php';

$sqlccr = "select * from concours
JOIN boulodromes on concours.boulodromes_adresse = boulodromes.numero_boulodrome";

$sqlarb = "select * from arbitre
JOIN communes on arbitre.communes_code_insee = communes.code_insee";

$resultccr = $con->query($sqlccr);
$resultarb = $con->query($sqlarb);


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
		<link rel="stylesheet" type="text/css" media="screen" href="styles.css" />
		
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
<div id="checkAllTopicCheckBoxes"> </div>

<table>
	<thead>
	<tr>
	<th class="bordertab">Date</th>
	<th class="bordertab">Club Organisateur</th>
	<th class="bordertab">Dispositif</th>
	<th class="bordertab">Dotation</th>
	</tr>
	</thead>
    <tbody>
      <?php
	  if($resultccr->num_rows>0){
		  while($row = $resultccr->fetch_assoc()){
	$club_id = $row['club_numero_club'];
	$query_club = "SELECT * from club WHERE numero_club = $club_id";
	$club_result = mysqli_query($con,$query_club);
	$club_row = mysqli_fetch_assoc($club_result);
	  ?>
	  <tr>
	<td class="bordertab"><?php echo $row['date']; ?></td>
	<td class="bordertab"><?php echo $club_row['nom_club']; ?></td>
	<td class="bordertab"><?php echo $row['disposition_equipe']; ?></td>
	<td class="bordertab"><?php echo $row['dotation']; ?>
	<!--<button type=\"button\" onclick='routecalculating("parameter")'>Calculer trajets</button>--></td>
	</tr>
	  <?php
	  
		  }
	  }
	  ?>
	  
    </tbody>
  </table>
</section>

<div class="div-designation-container">
<div style="padding: 0 0 150px 100px; height: 300px;"><p>Lieu:</p>
<div id="map" style="width: 450px; height: 350px"></div>
</div>
<div style="padding: 0">
<table>
	<thead>
	<tr>
	<th class="bordertab">Nom</th>
	<th class="bordertab">Prénom</th>
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
	<td class="bordertab" id="arbitreno<?php echo $row['numero_license']; ?>"></td>
	</tr>
	  <?php
	  
		  }
	  }
	  
	  ?>
    </tbody>
  </table>
  </div>
<script>
window.addEventListener( "load", function( event ) {    
    var map = L.map( 'map' /* the id of the tag used for map injection */ );
    map.setView( [43.9446996 /*latitude*/, 4.1513764 /*longitude*/], 8	/*zoom*/ );
    
    
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
	
	//let marker = L.marker( [ 44.019629, 4.415236 ] , optionConcours)
    //              .bindPopup( "nom" )
    //              .addTo( map );
			  
	 <?php
	 $resultmap = $con->query($sqlccr);
	  if($resultmap->num_rows>0){
		  while($row = $resultmap->fetch_assoc()){
	  ?>
		var mark<?php echo $row['numero_concours']; ?> = L.marker( [ <?php echo $row['latitude_boulodrome']; ?>, <?php echo $row['longitude_boulodrome']; ?> ] , optionConcours)
                  .bindPopup( "<?php echo $row['nom_boulodrome']; ?> <br>"
					+ "<button type=\"button\" onclick='routecalculating()'>Calculer trajets</button> ")
                  .addTo( map );	
	  <?php
	  
		  }
	  }
	  $resultarm = $con->query($sqlarb);
	  if($resultarm->num_rows>0){
		  while($row = $resultarm->fetch_assoc()){
	  ?>
	  var mark<?php echo $row['numero_license']; ?> = L.marker( [ <?php echo $row['lat_commune']; ?>, <?php echo $row['long_commune']; ?> ])
                  .bindPopup( "<?php echo $row['nom_commune']; ?>" )
                  .addTo( map );
	  <?php
	  
		  }
	  }
	  ?>


function routecheck() {
 var routea = L.Routing.control({
    waypoints: [
        L.latLng(43.871476, 4.345952),
        L.latLng([ 43.710653, 4.265712])
    ],
    routeWhileDragging: false,
	addWaypoints: false,
	draggableWaypoints: false
}).addTo(map);
}

	
	
});
</script>

</div>
</main>
<footer>
<?php 
  echo '<script type="text/javascript">routecheck();</script>';
  
include 'copyright.php';

  ?>
</footer>
</body>

</html>