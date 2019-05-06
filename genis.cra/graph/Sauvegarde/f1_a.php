<!-- Récupération des observateur et département choisis
	Calcul du nombre d'oiseaux observés
	Renvoi du tableau récapitulatif-->

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
				<?php
					//Récupération de l'id observateur choisi et de l'id departement choisi
					$id_obs = $_GET["name"];
					$id_dep = $_GET["dep"];
					
					//Connection au serveur
					$link = mysqli_connect ("localhost","root", "", "oiseaudb");
					mysqli_set_charset ($link, "utf8mb4");
					
					//Choix de la BDD et message d'erreur si connexion impossible
					mysqli_select_db ($link, "oiseaudb") or die ("Impossible de sélectionner la BDD oiseaudb : ".mysqli_error($link));
					
					//Requête pour récupérer les observations par espèce d'oiseaux
					$query = "	SELECT 	oiseaux.nom_commun as Oiseau, sum(observations.nombre) as Quantite
								FROM oiseaux 	JOIN observations ON oiseaux.id_oiseau=observations.id_oiseau
												JOIN observateurs ON observations.id_observateur = observateurs.id_observateur
												JOIN communes ON observations.id_commune=communes.id_commune
												JOIN departements ON communes.id_dpt=departements.id_dpt
								WHERE observateurs.id_observateur='".$id_obs."'AND departements.id_dpt='".$id_dep."'
								GROUP BY oiseaux.id_oiseau";
					$result = mysqli_query ($link, $query);
					
					//Requête pour récupérer le nom et le prenom de l'observateur choisi
					$query_nom = "	SELECT 	nom_observateur, prenom
									FROM observateurs
									WHERE id_observateur='".$id_obs."'";
					$result_nom = mysqli_query ($link, $query_nom);
					while ($row = mysqli_fetch_array($result_nom, MYSQLI_BOTH))
						{
							$nom_obs = $row[0];
							$prenom = $row["prenom"];
						}
					
					//Requête pour récupérer le nom du département choisi
					$query_dep = "	SELECT 	nom_dpt
									FROM departements
									WHERE id_dpt='".$id_dep."'";
					$result_dep = mysqli_query ($link, $query_dep);
					while ($row = mysqli_fetch_array($result_dep, MYSQLI_BOTH))
						{
							$nom_dep = $row[0];
						}
					
					//Vérification de la présence d'observation
					$nbligne = mysqli_num_rows($result);
					mysqli_data_seek($result,0);
					
					if ($nbligne ==0)
					{
						echo "Il n'y a pas d'observation pour l'observateur ".$nom_obs." ".$prenom." en ".$nom_dep."<br><br>";
					}
					else
					{
						//Affichage du tableau des observations avec la valeur maximale écrite en rouge
						echo "Répartition du nombre d'oiseaux observés par ".$nom_obs." ".$prenom." en ".$nom_dep."<br><br>";
						include "fonctions.php";
						echo "<center>";
						$max = max_tab ($result);
						creer_tab_HTML_max ($result,$max);
						echo "</center><br><br>";
						
						//Transmission des valeurs à la page pieplot.php pour afficher le graphique
						echo "<center><img src = 'pieplot.php?id_dep=".$id_dep."&nom_dep=".$nom_dep."&nom_obs=".$nom_obs."&prenom=".$prenom."&id_obs=".$id_obs."'></center>";
					}
					

				?>
		</div>
	
		<!-- DIV Pied de page -->		
		<?php include("DIVPied.html"); ?>
	</div>
	</body>
</head>