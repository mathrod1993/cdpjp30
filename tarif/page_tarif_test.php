<!DOCTYPE html>

<?php 
  
include 'user.php';


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
        <link rel="stylesheet" type="text/css" media="screen" href="tarif_style.css" />
		<!--<script src="main.js"></script>-->

</head>

<body>

<section id="datalist">
<div class="mainblock">
<div class="main_item">
  <form method="POST">
  <label for="competition">Type de compétition:</label>
  <select id="competition" name="competition">
    <option value="1"> Concours en 3 parties Jeu Provencal</option>
    <option value="2">Concours en 4 parties Petanque</option>
    <option value="3">Concours Départemental</option>
    <option value="4">CDC (2 Matchs)</option>
	<option value="5">Coupe de France (Tour Zonal / Tour Départemental)</option>
	<option value="6">Concours Régional</option>
	<option value="7">Championnat Départemental</option>
	<option value="8">Championnat Régional des Clubs</option>
	<option value="9">Championnat Régional</option>
	<option value="10">Concours Evenementiel</option>
	<option value="11">Concours National</option>
	<option value="12">Concours Supranational</option>
	<option value="13">Concours International</option>
	<option value="14">16eme et 8eme de Final (1 journee)</option>
	<option value="15">Coupe de France</option>
	<option value="16">Championnat National des Clubs 2 Matchs (1 journee)</option>
	<option value="17">Championnat National des Clubs 3	Matchs (1 journee)</option>
	<option value="18">Finale de Championnat National des Clubs</option>
	<option value="19">Finale de Coupe de France</option>
	<option value="20">Championnats de France</option>
  </select> <br>
	<label for="grade">Grade:</label>
  <select id="grade" name="grade">
    <option value="1">Départemental</option>
    <option value="2">Régional</option>
    <option value="3">National</option>
    <option value="4">Européen</option>
	<option value="5">International</option>
	<option value="6">Pool Elite</option>
  </select> <br>
    <button type="submit"  name="submit">Check</button>
  </form>
</div></div>

 <?php
 if(isset($_POST['submit'])){
	
		$competition = $_POST['competition'];
		$grade = $_POST['grade'];
		
		$sql = "select * from grille_tarif
		where type_competition_numero_competition = '$competition'
		and grade_arbitre_numero_grade = '$grade'";

		$result = $con->query($sql);	
 
 
	  if($result->num_rows>0){
		  while($row = $result->fetch_assoc()){
	
	$grade_id = $row['grade_arbitre_numero_grade'];
	$query_grade = "SELECT * from grade_arbitre WHERE numero_grade = $grade_id";
	$grade_result = mysqli_query($con,$query_grade);
	$grade_row = mysqli_fetch_assoc($grade_result);
	
	$competition_id = $row['type_competition_numero_competition'];
	$query_competition = "SELECT * from type_competition WHERE numero_competition = $competition_id";
	$competition_result = mysqli_query($con,$query_competition);
	$competition_row = mysqli_fetch_assoc($competition_result);
	  ?>
<div class="mainblock">
<div class="main_item">
	<h2><?php echo $competition_row['nom_competition']; ?></h2>
</div>
<div class="side_item">
	<p>Grade: <br>
	<?php echo $grade_row['nom_grade']; ?></p>
	<img src="logo/<?php echo $grade_row['logo_grade']; ?>"
	width="100px">
</div>
<div class="side_item">
	<p>Montant de<br>
	la rémunération: </p>
	<h2><?php echo $row['remuneration'] . " €"; ?></h2>
</div>
</div>
 <?php
	  
		  }
	  }
	  }
	  ?>
</section>


	
	
</body>

</html>