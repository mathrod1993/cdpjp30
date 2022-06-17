<!DOCTYPE html>

<?php 
  
include 'user.php';

$sql = "select * from concours
JOIN boulodromes on concours.boulodromes_adresse = boulodromes.numero_boulodrome";


$result = $con->query($sql);


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
<div id="checkAllTopicCheckBoxes"> </div>

<table>
	<thead>
	<tr>
	<th class="bordertab">Date</th>
	<th class="bordertab">Club Organisateur</th>
	<th class="bordertab">Dispositif</th>
	<th class="bordertab">Dotation</th>
	<th class="bordertab">Détail</th>
	</tr>
	</thead>
    <tbody>
      <?php
	  if($result->num_rows>0){
		  while($row = $result->fetch_assoc()){
	$club_id = $row['club_numero_club'];
	$query_club = "SELECT * from club WHERE numero_club = $club_id";
	$club_result = mysqli_query($con,$query_club);
	$club_row = mysqli_fetch_assoc($club_result);
	  ?>
	  <tr>
	<td class="bordertab"><?php echo $row['date']; ?></td>
	<td class="bordertab"><?php echo $club_row['nom_club']; ?></td>
	<td class="bordertab"><?php echo $row['disposition_equipe']; ?></td>
	<td class="bordertab"><?php echo $row['dotation']; ?></td>
	<td class="bordertab"><a href="designation_info.php?id=<?php echo $row['numero_concours']; ?>" class="info_btn">Voir</a></td>
	</tr>
	  <?php
	  
		  }
	  }
	  ?>
	  
    </tbody>
  </table>
</section>

<div class="div-arbitre-container">
<div class="div-oneblock" id="concoursmapsquare"><p>Lieu:</p>
<div id="map"></div>
</div>
<script>
window.addEventListener( "load", function( event ) {    
    var map = L.map( 'map' /* the id of the tag used for map injection */ );
    map.setView( [43.9446996 /*latitude*/, 4.1513764 /*longitude*/], 8	/*zoom*/ );
    
    
    // --- We add a layer based on OpenStreetMap ---
    L.tileLayer( 'http://tile.openstreetmap.org/{z}/{x}/{y}.png' ).addTo(map);   // Base Map
    
	
	
	
	let customicon= {'marker-color': '#00FFFF'}
	let redmark= {
		iconUrl:"marker/marker-icon-red.png"
	}
	let concoursMark = L.icon(redmark);
	
	let optionConcours = {
		icon:concoursMark
		}
	
	//var marker = L.marker(new L.LatLng(a[0], a[1]), {icon: L.map.marker.icon({'marker-symbol': 'car', 'marker-color': '#00FFFF'}),title: title});
    // --- We add a marker, with events, to the map ---
	
	//let marker = L.marker( [ 44.019629, 4.415236 ] , optionConcours)
    //              .bindPopup( "nom" )
    //              .addTo( map );
			  
	 <?php
	 $resultmap = $con->query($sql);
	  if($resultmap->num_rows>0){
		  while($row = $resultmap->fetch_assoc()){
	  ?>
		var mark<?php echo $row['numero_concours']; ?> = L.marker( [ <?php echo $row['latitude_boulodrome']; ?>, <?php echo $row['longitude_boulodrome']; ?> ] , optionConcours)
                  .bindPopup( "<?php echo $row['nom_boulodrome']; ?> <br><br>"
					//+ "<a href=\"designation_info.php?id=<?php echo $row['numero_concours']; ?>\" class=\"check_btn\">Calculer trajet</a>")
					+ "<a href=\"designation_info.php?id=<?php echo $row['numero_concours']; ?>\"")
                  .addTo( map );	
	  <?php
	  
		  }
	  }
	  ?>

	
	
});
</script>

</div>
</main>
<footer>
<?php 

  
include 'copyright.php';

  ?>
</footer>
</body>

</html>