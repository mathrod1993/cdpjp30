<!DOCTYPE html>

<?php 
  
include 'user.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
$sql="SELECT * FROM arbitre
JOIN club on arbitre.club_numero_club = club.numero_club
JOIN communes on arbitre.communes_code_insee = communes.code_insee
JOIN grade_arbitre on arbitre.grade_arbitre_numero_grade = grade_arbitre.numero_grade
WHERE numero_license='$id'";
$result=mysqli_query($con,$sql);
$row=mysqli_fetch_array($result);
	
	
	}
	else{
	header('Location: arbitre_index.php');
	}



  ?>

<html>
<head>
	<meta charset = "UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Arbitres</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Lato&display=swap"
            rel="stylesheet"
        />
        
		<!--<script src="main.js"></script>-->
		
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
<div><p>Nom et Prénom:</p></div>
<div><p><?php echo $row['prenom_arbitre']; ?>&nbsp;<?php echo $row['nom_arbitre']; ?></p></div>
<div><p>Commune de Résidence:</p></div>
<div><p><?php echo $row['nom_commune']; ?></p></div>
<div><p>Grade:</p></div>
<div><p><?php echo $row['nom_grade']; ?></p><img src="logo/<?php echo $row['logo_grade']; ?>" width="20%"></div>
</div>
<div class="div-arbitre-container">
<div class="div-oneblock" id="concoursmapsquare"><p>Lieu:</p>
<div id="map"></div>
<!--
<iframe style="border: 0;" src="https://www.google.com/maps?q='<?php echo $row['nom_commune']; ?>
<?php echo $row['code_postal']; ?>''&output=embed" width="800" height="500" frameborder="500" allowfullscreen></iframe>-->
<script>
window.addEventListener( "load", function( event ) {    
    var map = L.map( 'map' /* the id of the tag used for map injection */ );
    map.setView( [<?php echo $row['lat_commune']; ?> /*latitude*/, <?php echo $row['long_commune']; ?> /*longitude*/], 12 /*zoom*/ );
    
    
    // --- We add a layer based on OpenStreetMap ---
    L.tileLayer( 'http://tile.openstreetmap.org/{z}/{x}/{y}.png' ).addTo(map);   // Base Map
    
    // --- We add a marker, with events, to the map ---
    var marker = L.marker( [ <?php echo $row['lat_commune']; ?>, <?php echo $row['long_commune']; ?> ] )
                  .bindPopup( "<?php echo $row['nom_commune']; ?>" )
                  .addTo( map );

    

});
</script>
</div>
</div>
<div class="div-arbitre-container">
<div class="div-oneblock"><p>Historique d'arbitrage:</p>
<table>
	<thead>
	<tr>
	<th class="bordertab">Date</th>
	<th class="bordertab">Club Organisateur</th>
	<th class="bordertab">Dispositif</th>
	<th class="bordertab">Dotation</th>
	<th class="bordertab">Arbitre Chef?</th>
	</tr>
	</thead>
    <tbody>
      <?php
	$joinquery="select * from arbitre_concours
	JOIN concours on arbitre_concours.concours_numero_concours = concours.numero_concours
	JOIN club on concours.club_numero_club = club.numero_club
	WHERE arbitre_numero_license='$id'";
	$join_result = $con->query($joinquery);
	  
	  if($join_result->num_rows>0){
		  while($queryrow = $join_result->fetch_assoc()){
	  ?>
	  <tr>
	<td class="bordertab"><?php echo $queryrow['date']; ?></td>
	<td class="bordertab"><?php echo $queryrow['nom_club']; ?></td>
	<td class="bordertab"><?php echo $queryrow['disposition_equipe']; ?></td>
	<td class="bordertab"><?php echo $queryrow['dotation']; ?></td>
	<td class="bordertab"><?php if ($queryrow['est_chef']==1){echo "OUI";}else{echo "NON";} ?></td>
	</tr>
	  <?php
	  
		  }
	  }
	  ?>
    </tbody>
  </table>


</div>
</div>
</section>

<div class="mainblock">
	
</div>
</main>
	
</body>

</html>