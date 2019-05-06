<?php

session_start();

?>

<!-- Page qui apparait lorsque l'utilisateur qui sur le lien "Observations" -->

<html>
	<head>
	
	</head>
	ici ce sont les deept
	<body>
	<?php 
				
	##On importe le dossier de fonctions pour pouvoir afficher le tableau ultérieurement
	require "Mesfonctions.php";
	
	
	/*Cette page unique permettera à l'utilsateur de selectionner un observateur
	et un département.
	Elle permet à l'utilisateur de consulter les infos des enregistrements */
	
	
	if (!isset($_GET["form_obs"]))
	
				################################################################
				#															   #
				#		Premier affichage et première rentrée dans la page     #
				#															   #
				################################################################
	
	{	
	##On 'interroge' la base de données oiseaudb
	
		$link1=mysqli_connect('piaf.agro-bordeaux.fr','root','','oiseaudb');
		mysqli_set_charset($link1,"utf8mb4");
		
	## On récupère la liste des observateurs ayant déjà fait une/des observations
	
		$query_obs="SELECT DISTINCT observateurs.id_observateur, observateurs.nom_observateur
		FROM observateurs 
		JOIN Observations
		ON observateurs.id_observateur=Observations.id_observateur";
	
	##On la traite
		$result_obs= mysqli_query($link1,$query_obs);
		
		$tab_obs=mysqli_fetch_all($result_obs);
		$nblignes_obs=mysqli_num_rows($result_obs);
		$nbcol_obs=mysqli_num_fields($result_obs);
	
	##On l'affiche dans un formulaire sous forme de liste déroulante
		echo "</br>";
		echo "<FORM action ='Partie_I_dep_test.php' method = 'GET' name = 'form_obs'>";
			echo "<select name= 'Observateur'>";
			$i=0;
				while($i<$nblignes_obs)
				{
					echo "<option value=".$tab_obs[$i][0]."> ".$tab_obs[$i][1].  "</option>";
					$i++;
				}
			
			echo "</select>";
		
		echo"</FORM>";
		
		
		$link=mysqli_connect('piaf.agro-bordeaux.fr','root','','oiseaudb');
		mysqli_set_charset($link,"utf8mb4");
	
	## On récupère la liste des départements ayant des observations	
	
		$query_dep="SELECT distinct Departements.id_dpt, Departements.nom_dpt
		FROM Departements, Communes, Observations
		WHERE departements.id_dpt=communes.id_dpt 
		AND communes.id_commune=observations.id_commune";
	
	##On la traite de la manière
	
		$result_dep= mysqli_query($link,$query_dep);
		
		$tab_dep=mysqli_fetch_all($result_dep);
		$nblignes_dep=mysqli_num_rows($result_dep);
		$nbcol_dep=mysqli_num_fields($result_dep);
		
	## On l'affiche sous forme de liste déroulante	
	
		echo "<FORM action ='Partie_I_dep_test.php' method = 'GET' name = 'form_dep'>";
			echo "<select name= 'Departements'>";
			$j=0;
				while($j<$nblignes_dep)
				{
					echo "<option value=".$tab_dep[$j][0]."> ".$tab_dep[$j][1].  "</option>";
					$j++;
				}
			
			echo "</select>";
			
		echo "<input Type = 'submit' name ='bt_submit' value ='Valider'>";
		
		echo"</FORM>";
	}
	/*Deuxième affichage (ou plus) comme le formulaire de saisie a été rentré au 
	moins une fois.
	C'est cette partie là qui affichera letableau des observation*/
	
	
				################################################################
				#															   #
	else		#			Deuxième affichage affichage dans la page     	   #
				#															   #
				################################################################
		
	
	{
		
		$link1=mysqli_connect('piaf.agro-bordeaux.fr','root','','oiseaudb');
		mysqli_set_charset($link1,"utf8mb4");
		
	## On récupère la liste des observateurs ayant déjà fait une/des observations
	
		$query_obs="SELECT DISTINCT observateurs.id_observateur, observateurs.nom_observateur
		FROM observateurs 
		JOIN Observations
		ON observateurs.id_observateur=Observations.id_observateur";
	
	##On la traite
		$result_obs= mysqli_query($link1,$query_obs);
		
		$tab_obs=mysqli_fetch_all($result_obs);
		$nblignes_obs=mysqli_num_rows($result_obs);
		$nbcol_obs=mysqli_num_fields($result_obs);
	
	##On l'affiche dans un formulaire sous forme de liste déroulante
		echo "</br>";
		echo "<FORM action ='Partie_I_dep_test.php' method = 'GET' name = 'form_obs'>";
			echo "<select name= 'Observateur'>";
			$i=0;
				while($i<$nblignes_obs)
				{
					echo "<option value=".$tab_obs[$i][0]."> ".$tab_obs[$i][1].  "</option>";
					$i++;
				}
			
			echo "</select>";
		
		echo"</FORM>";
		
		
		
		$link=mysqli_connect('piaf.agro-bordeaux.fr','root','','oiseaudb');
		mysqli_set_charset($link,"utf8mb4");
	
	## On récupère la liste des départements ayant des observations	
	
		$query_dep="SELECT distinct Departements.id_dpt, Departements.nom_dpt
		FROM Departements, Communes, Observations
		WHERE departements.id_dpt=communes.id_dpt 
		AND communes.id_commune=observations.id_commune";
	
	##On la traite de la manière
	
		$result_dep= mysqli_query($link,$query_dep);
		
		$tab_dep=mysqli_fetch_all($result_dep);
		$nblignes_dep=mysqli_num_rows($result_dep);
		$nbcol_dep=mysqli_num_fields($result_dep);
		
	##On affiche les departements dans un formulaire 
		echo "</br>";
		echo "Pour le département de ";
		echo "<FORM action ='Partie_I_dep_test.php' method = 'GET' name = 'form1'>";
		echo "<select name= 'Departements'>";
			while($i<$nblignes)
			{
				echo "<option value=".$tab_dep[$i][0]."> ".$tab[$i][1].  "</option>";
				$i++;
			}
			
		echo "</select>";

			
		echo "<input Type = 'submit' name ='bt_submit' value ='Valider'>";
		
		echo"</FORM>";
		
		##On GET le départements issu du bouton 'Valider' précédemment préssé
		##Petit + qui diffère de la partie d'avant: On affiche un tableau récapitulatif
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
			
		echo "Pour le département de ";
		tableau($tab,$nblignes,$nbcol);
			
			
		echo"</FORM>";
		$la=0;
	}
		
		
	?>
	là
	</body>

</html>