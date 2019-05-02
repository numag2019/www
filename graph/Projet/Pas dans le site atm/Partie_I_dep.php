<?php

session_start();

?>

<html>
	<head>
	
	</head>
	ici c'est les deept
	<body>
	<?php 
	require "Mesfonctions.php";	
	$i=0;
	
	/*Cette page sera la page qui, apès avoir cliqué sur un lien observation,
	permettra à l'utilisateur de consulter les infos des enregistrements */
		$obs=$_GET["Observateur"];
		$_SESSION["Observateur"]=$obs;

		$link=mysqli_connect('piaf.agro-bordeaux.fr','root','','oiseaudb');
		mysqli_set_charset($link,"utf8mb4");
		
		$query="SELECT distinct Departements.id_dpt, Departements.nom_dpt
		FROM Departements, Communes, Observations, Observateurs
		WHERE departements.id_dpt=communes.id_dpt 
		AND communes.id_commune=observations.id_commune
		AND $obs=observations.id_observateur";
				
		$result= mysqli_query($link,$query);
		
		$tab=mysqli_fetch_all($result);
		$nblignes=mysqli_num_rows($result);
		$nbcol=mysqli_num_fields($result);
		echo "</br>";
		echo "<FORM action ='Partie_I_combi.php' method = 'GET' name = 'form1'>";
			echo "<select name= 'Departements'>";
				while($i<$nblignes)
				{
					echo "<option value=".$tab[$i][0]."> ".$tab[$i][1].  "</option>";
					$i++;
				}
			
			echo "</select>";

			
		echo "<input Type = 'submit' name ='bt_submit'value ='Valider'>";
		
		echo"</FORM>";
	?>
	là
	</body>

</html>