<!DOCTYPE html>

<?php 
  
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'pjp30user';

$con = mysqli_connect($host, $user, $pass, $db);

$sql = "select * from grille_tarif";

$result = $con->query($sql);


  ?>

<html>
<head>
	<meta charset = "UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Grille Tarifaire</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Lato&display=swap"
            rel="stylesheet"
        />
        <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
		<!--<script src="main.js"></script>-->

</head>

<body>
  <form action="create.php" method="POST">
    <label for="name">Nom de la compétition:</label>
    <input type="text" id="nom_competition" name="nom_competition" required>
    <label for="score">Montant en Euro:</label>
    <input type="number" id="montant" name="montant" required>
    <button type="submit"  name="submit">Add</button>
  </form>

<section id="datalist">

<table>
	<thead>
	<tr>
	<th class="bordertab">Compétition</th>
	<th class="bordertab">montant</th>
	<th></th>
	<th></th>
	</tr>
	</thead>
    <tbody>
      <?php
	  if($result->num_rows>0){
		  while($row = $result->fetch_assoc()){
	  ?>
	  <tr>
	<td class="bordertab"><?php echo $row['competition']; ?></td>
	<td class="bordertab"><?php echo $row['montant'] . " €"; ?></td>
	<td><a href="update.php?id=<?php echo $row['id']; ?>" class="edit_btn" >Edit</a></td>
	<td><a href="delete.php?id=<?php echo $row['id']; ?>" class="del_btn">Delete</a></td>
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
	
	
</body>

</html>