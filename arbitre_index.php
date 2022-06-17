<!DOCTYPE html>

<?php 
  
include 'user.php';

$sql = "select * from arbitre";

$result = $con->query($sql);


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
        <link rel="stylesheet" href="main.css" />
		
		</head>







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
	<th class="bordertab">Nom</th>
	<th class="bordertab">Prénom</th>
	<th class="bordertab">Info</th>
	</tr>
	</thead>
    <tbody>
      <?php
	  if($result->num_rows>0){
		  while($row = $result->fetch_assoc()){
	  ?>
	  <tr>
	<td class="bordertab"><?php echo $row['nom_arbitre']; ?></td>
	<td class="bordertab"><?php echo $row['prenom_arbitre']; ?></td>
	<td class="bordertab"><a href="arbitre_info.php?id=<?php echo $row['numero_license']; ?>" class="info_btn">Voir Profil</a></td>
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