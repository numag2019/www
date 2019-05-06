<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

	<!-- Index.php -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>
		Oiseaux - Projet Techno. Web
	</title>
	<!-- Déclaration de la feuille de style -->
	<link rel="stylesheet" type="text/css" href="styles/maFeuilleDeStyle.css" media="all" />
</head>

<body>

<div id="global">
	
	<!-- DIV Entête -->
	<?php include("DIVEntete.html"); ?>
	<!-- DIV Navigation (Menus) -->
	<?php include("DIVNavigationGui.html"); ?>

	<!-- Section Contenu : on définit ici le contenu central de la page -->
	<div id="contenu">
		<h2>Recherche d'un <I>Oiseau</I> !</h2>
		<p>
		Cette page permet de selectionner un type d'oiseau selon une période et un 
		nombre.
		</p>	
		<p>
		Autant dire que ce ne sera pas une mince affaire. 
		</p>		
	</div><!-- #contenu -->
	<?php
	
	/*Premièrement, on va chercher à afficher les disponibilités de l'ulisateur
	A savoir: Le département, le trimestre et pourra rentrer un seuil*/
	
	####On présente les départements sous forme d'une liste déroulante:####
			$link=mysqli_connect('piaf.agro-bordeaux.fr','root','','oiseaudb');
		mysqli_set_charset($link,"utf8mb4");
	
	# On récupère la liste des départements ayant des observations	
	
		$query_dep="SELECT distinct Departements.id_dpt, Departements.nom_dpt
		FROM Departements, Communes, Observations
		WHERE departements.id_dpt=communes.id_dpt 
		AND communes.id_commune=observations.id_commune";
	
	#On la traite de la manière
	
		$result_dep= mysqli_query($link,$query_dep);
		
		$tab_dep=mysqli_fetch_all($result_dep);
		$nblignes_dep=mysqli_num_rows($result_dep);
		$nbcol_dep=mysqli_num_fields($result_dep);
		
	#On affiche les departements dans un formulaire 
		echo "</br>";
		echo "Pour le département de ";
		echo "<FORM action ='Repart.php' method = 'GET' name = 'form_dep'>";
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
		
	####On affiche desormais les trimestres disponibles (4 en tout):####
	echo "</br>";

		echo "<FORM action ='Repart.php' method = 'GET' name = 'form_tri'>";
			echo "<select name= 'Trimestres'>";
			echo "<option value=" .'1'. ">" ."1er trimestre".  "</option>";
			echo "<option value=" .'2'. ">" ."2eme trimestre".  "</option>";
			echo "<option value=" .'3'. ">" ."3eme trimestre".  "</option>";
			echo "<option value=" .'4'. ">" ."4eme trimestre".  "</option>";
			echo "</select>";
	
		echo "<input Type = 'submit' name ='bt_submit' value ='Valider'>";
		
		echo"</FORM>";
	?>
	<!-- DIV Pied de page -->		
	<?php include("DIVPied.html"); ?>	


</div><!-- #global -->
	</body>
</html>