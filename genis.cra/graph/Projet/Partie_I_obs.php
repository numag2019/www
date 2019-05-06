<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

	<!-- Index.php -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
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
		<h2>Observations </h2>
		<p>
		Veuillez choisir l'un de nos observateurs.
		</p>	
		<p>
		Il vous sera ensuite possible de choisir le département sur une page ultérieure. 
		</p>
	<?php  ##Affiche le tableau (hopefully)
	require "Mesfonctions.php";
	
	
	/*Cette page sera la page qui, apès avoir cliqué sur un lien observation
	permettra à l'utilisateur de rentrer les infos nécessaires pour enregistrer 
	ses observations*/

		$link=mysqli_connect('piaf.agro-bordeaux.fr','root','','oiseaudb');
		mysqli_set_charset($link,"utf8mb4");
		
		$query="SELECT DISTINCT observateurs.id_observateur, observateurs.nom_observateur
		FROM observateurs 
		JOIN Observations
		ON observateurs.id_observateur=Observations.id_observateur";
				
		$result= mysqli_query($link,$query);
		
		$tab=mysqli_fetch_all($result);
		$nblignes=mysqli_num_rows($result);
		$nbcol=mysqli_num_fields($result);

		echo "</br>";
		echo "<FORM action ='Partie_I_dep_test.php' method = 'GET' name = 'form1'>";
			echo "<select name= 'Observateur'>";
			$i=0;
				while($i<$nblignes)
				{
					echo "<option value=".$tab[$i][0]."> ".$tab[$i][1].  "</option>";
					$i++;
				}
			
			echo "</select>";


		echo "<input Type = 'submit' name ='bt_submit'value ='Envoyer'>";
		
		echo"</FORM>";
	?>		
	</div><!-- #contenu -->

	<!-- DIV Pied de page -->		
	<?php include("DIVPied.html"); ?>	


</div><!-- #global -->
</body>
</html>