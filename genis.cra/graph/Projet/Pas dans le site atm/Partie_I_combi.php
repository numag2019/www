<?php

session_start();

?>

<html>
	<head>
	
	</head>
	
	<body>

Liste de gens tabarnak: <br>	
	<?php require("Mesfonctions.php");
	$obs=$_SESSION["Observateur"];
	$dpt=$_GET["Departements"];
	$i=0;
	
	$link=mysqli_connect('piaf.agro-bordeaux.fr','root','','oiseaudb');
	mysqli_set_charset($link,"utf8mb4");
	$query="SELECT distinct oiseaux.nom_commun, SUM(observations.nombre)as 'Nombre'
		FROM observations
		JOIN oiseaux ON observations.id_oiseau=oiseaux.id_oiseau 	
		JOIN Communes ON observations.id_commune=communes.id_commune
		WHERE communes.id_dpt='$dpt'
		AND observations.id_observateur='$obs'
		GROUP BY oiseaux.nom_commun";
	
	$result= mysqli_query($link,$query);
	
	$tab=mysqli_fetch_all($result);
	$nblignes=mysqli_num_rows($result);
	$nbcol=mysqli_num_fields($result);
	
	tableau($tab,$nblignes,$nbcol);
	
	
	echo"</FORM>";
	?>
	
	</body>
Là
</html>