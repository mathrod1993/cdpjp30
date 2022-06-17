<!DOCTYPE html>

<?php 
  
include 'user.php';

$sql = "select * from concours";

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
        <link rel="stylesheet" href="main.css" />
		
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

<table>
	<thead>
	<tr>
	<th class="bordertab">Date</th>
	<th class="bordertab">Club Organisateur</th>
	<th class="bordertab">Dispositif</th>
	<th class="bordertab">Dotation</th>
	<th class="bordertab">Info</th>
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
	<td class="bordertab"><a href="concours_info.php?id=<?php echo $row['numero_concours']; ?>" class="info_btn">Voir</a></td>
	</tr>
	  <?php
	  
		  }
	  }
	  ?>
    </tbody>
  </table>
</section>

<div class="mainblock">
	
</div>
</main>
<footer>
<?php 
  
include 'copyright.php';

  ?>
</footer>
</body>

</html>