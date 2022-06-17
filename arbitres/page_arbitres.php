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
        <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
		<!--<script src="main.js"></script>-->

</head>

<body>
  <form action="create.php" method="POST">
    <label for="nom">Nom de l'arbitre:</label>
    <input type="text" id="nom" name="nom" required>
    <label for="prenom">Prénom de l'arbitre:</label>
    <input type="text" id="prenom" name="prenom" required>
	<label for="license">numéro de license:</label>
    <input type="number" id="license" name="license" required>
	<!--<label for="commune">commune:</label>
    <input type="text" id="commune" name="commune" required>-->
	
<label for="maCommune">Commune:</label>
<input list="communes" id="maCommune" name="maCommune"/>
<datalist id="communes">
<?php
  $sqlcom = "select * from communes";
$resultcom = $con->query($sqlcom);

if($resultcom->num_rows>0){
		  while($row = $resultcom->fetch_assoc()){
  ?>
  <option value="<?php echo $row['nom_commune']; ?> (<?php echo $row['code_postal']; ?>)">
   <?php
	  
		  }
	  }
	  ?>
</datalist>
<label for="club">Club:</label>
<input list="clubs" id="club" name="club"/>
<datalist id="clubs">
<?php
  $sqlcl = "select * from club";
$resultclub = $con->query($sqlcl);

if($resultclub->num_rows>0){
		  while($row = $resultclub->fetch_assoc()){
  ?>
  <option value="<?php echo $row['nom_club']; ?>">
   <?php
	  
		  }
	  }
	  ?>
</datalist>


	<label for="grade">Grade:</label>
  <select id="grade" name="grade">
<?php
  $sqlga = "select * from grade_arbitre";
$resultgrade = $con->query($sqlga);

if($resultgrade->num_rows>0){
		  while($row = $resultgrade->fetch_assoc()){
  ?>
  <option value="<?php echo $row['numero_grade']; ?>"><?php echo $row['nom_grade']; ?></option>
   <?php
	  
		  }
	  }
	  ?>
  </select>
    <button type="submit"  name="submit">Add</button>
  </form>

<section id="datalist">

<table>
	<thead>
	<tr>
	<th class="bordertab">License</th>
	<th class="bordertab">Nom</th>
	<th class="bordertab">Prénom</th>
	<th class="bordertab">Lieu</th>
	<th class="bordertab">Club</th>
	<th class="bordertab">Grade</th>
	<th></th>
	<th></th>
	</tr>
	</thead>
    <tbody>
      <?php
	  if($result->num_rows>0){
		  while($row = $result->fetch_assoc()){
	
	$commune_id = $row['communes_code_insee'];
	$query_commune = "SELECT * from communes WHERE code_insee = $commune_id";
	$commune_result = mysqli_query($con,$query_commune);
	$commune_row = mysqli_fetch_assoc($commune_result);
	
	$club_id = $row['club_numero_club'];
	$query_club = "SELECT * from club WHERE numero_club = $club_id";
	$club_result = mysqli_query($con,$query_club);
	$club_row = mysqli_fetch_assoc($club_result);
	
	$grade_id = $row['grade_arbitre_numero_grade'];
	$query_grade = "SELECT * from grade_arbitre WHERE numero_grade = $grade_id";
	$grade_result = mysqli_query($con,$query_grade);
	$grade_row = mysqli_fetch_assoc($grade_result);
	  ?>
	  <tr>
	<td class="bordertab"><?php echo $row['numero_license']; ?></td>
	<td class="bordertab"><?php echo $row['nom_arbitre']; ?></td>
	<td class="bordertab"><?php echo $row['prenom_arbitre']; ?></td>
	<td class="bordertab"><?php echo $commune_row['nom_commune']; ?></td>
	<td class="bordertab"><?php echo $club_row['nom_club']; ?></td>
	<td class="bordertab"><img src="logo/<?php echo $grade_row['logo_grade']; ?>" width="100px"></td>
	<td><a href="update.php?id=<?php echo $row['numero_license']; ?>" class="edit_btn" >Edit</a></td>
	<td><a href="delete.php?id=<?php echo $row['numero_license']; ?>" class="del_btn">Delete</a></td>
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