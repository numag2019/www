<!-- Choix de la statistique à calculer entre "Répartition du nombre d'oiseaux observés" et 
"Répartition des observations de groupes d'oiseaux par département"-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

	<!-- Index.php -->
	
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>
			Oiseaux - Projet Techno. Web
		</title>
		<!-- DÃ©claration de la feuille de style -->
		<link rel="stylesheet" type="text/css" href="styles/maFeuilleDeStyle.css" media="all" />
	</head>

	<body>
	<!-- On définit ici une section 'global' -->
	<div id="global">
		
		<!-- DIV Entête -->
		<?php include("DIVEntete.html"); ?>
		<!-- DIV Navigation (Menus) -->
		<?php include("DIVNavigation.html"); ?>

		<!-- Section Contenu : on définit ici le contenu central de la page -->
		<div id="contenu">
		
			<!-- Choix de la statistique à calculer, les deux formulaires renvoient l'utilisateur sur une page différente  : 
			f1.php pour la 1ère statistique et f2.php pour la seconde-->
			Choisissez votre statistique : <br><br>
				<FORM action = "f1.php" method = "GET" name = "form1">
					<p><center><INPUT TYPE = "SUBMIT" name = "bt_submit" value = "Répartition du nombre d'oiseaux observés" ><center></p>
				</FORM><br>
				<FORM action = "f2.php" method = "GET" name = "form2">
					<p><center><INPUT TYPE = "SUBMIT" name = "bt_submit" value = "Répartition des observations de groupes d'oiseaux par département" ><center></p><br>
				</FORM>
		</div>
		
		<!-- DIV Pied de page -->		
		<?php include("DIVPied.html"); ?>
	</div>

	</body>
</head>
