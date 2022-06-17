<!DOCTYPE html>

<?php 
  
include 'user.php';



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
		
        <!-- main CSS -->
		<link rel="stylesheet" type="text/css" media="screen" href="styles.css" />
		
		<!-- On charge le code JavaScript de la librairie leaflet -->
        <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
		
		<!-- Ces deux balises script sont à insérer entre les deux balises existantes -->
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

<style>
.leaflet-routing-container{
    display: block;
}
</style>
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
<div class="div-oneblock" style="padding: 0 300px 150px; height: 400px;"><p>Lieu:</p>
<div id="map"></div>

<script>
window.addEventListener( "load", function( event ) {    
    var map = L.map( 'map' /* the id of the tag used for map injection */ );
    map.setView( [43.871476 /*latitude*/, 4.345952 /*longitude*/], 12 /*zoom*/ );
    
    
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
    var marker = L.marker( [ 43.871476, 4.345952 ] , optionConcours)
                  .bindPopup( "name" )
                  .addTo( map );


    var routea = L.Routing.control({
    waypoints: [
        L.latLng(43.871476, 4.345952),
        L.latLng([ 43.710653, 4.265712])
    ],
    routeWhileDragging: false,
	addWaypoints: false,
	draggableWaypoints: false
}).addTo(map);
var routeb = L.Routing.control({
    waypoints: [
        L.latLng(43.988888, 3.607757),
        L.latLng([ 43.923228, 4.266060])
    ],
    routeWhileDragging: false,
	addWaypoints: false,
	draggableWaypoints: false
}).addTo(map);


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


