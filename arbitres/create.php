<?php 
  
include 'user.php';






if(isset($_POST['submit'])){
	
		$license = $_POST['license'];
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$commune = mb_strimwidth($_POST['maCommune'], 0, -8, null);
		$codepost = substr($_POST['maCommune'], -6, 5);
		$clubnom = $_POST['club'];
		$grade = $_POST['grade'];
		 
		$communesql="select code_insee from communes where nom_commune='$commune' AND code_postal='$codepost'";
		$resultcommune = $con->query($communesql);
			if($resultcommune->num_rows>0){while($row = $resultcommune->fetch_assoc()){
			$communeresult= $row['code_insee'];}}
		$clubsql="select numero_club from club where nom_club='$clubnom'";
		$resultclub = $con->query($clubsql);
			if($resultclub->num_rows>0){while($row = $resultclub->fetch_assoc()){
			$club= $row['numero_club'];}}
		
		$query="insert into arbitre (numero_license, nom_arbitre, prenom_arbitre, communes_code_insee, club_numero_club, grade_arbitre_numero_grade)
		values ('$license','$nom','$prenom','$communeresult','$club','$grade')";
		
		$run=mysqli_query($con,$query);
		if($query){
		echo "<p>Data added.</p>";
		header('Location: page_arbitres.php');
		}
		else{
		echo "<p>Failed to add data.</p>";
		header('Location: page_arbitres.php');
		}
		

	
}
  ?>