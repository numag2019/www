<!-- Récupération des trimestre, taille de groupe et département choisis
	Calcul du nombre d'oiseaux observés
	Affichage du bilan -->

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
				
				//Vérification que le champ taille est rempli et contient une valeur numérique
				if (isset ($_GET["taille"])and is_numeric ($_GET["taille"]))
				{
				if ($_GET ["taille"]!= "")
				{
					//Récupération du trimestre, de la taille de groupe et de l'id departement choisis
					$trim = $_GET["trimestre"];
					$taille = $_GET["taille"];
					$id_dep = $_GET["dep"];
					
					//Récupération des mois et du numéro du trimestre à partir du trimestre choisi
					$tab_trim=["janv/fév/mars", "avril/mai/juin", "juil/aout/sept", "oct/nov/déc"];
						if ($trim == $tab_trim[0])
						{
							$nb_trim = "1er";
							$mois=[1,2,3];
						}
						if ($trim == $tab_trim[1])
						{
							$nb_trim = "2ème";
							$mois=[4,5,6];
						}
						if ($trim == $tab_trim[2])
						{
							$nb_trim = "3ème";
							$mois=[7,8,9];
						}
						if ($trim == $tab_trim[3])
						{
							$nb_trim = "4ème";
							$mois=[10,11,12];
						}
							
					//Connection au serveur
					$link = mysqli_connect ("localhost","root", "", "oiseaudb");
					mysqli_set_charset ($link, "utf8mb4");
					
					//Choix de la BDD et message d'erreur si connexion impossible
					mysqli_select_db ($link, "oiseaudb") or die ("Impossible de sélectionner la BDD oiseaudb : ".mysqli_error($link));
					
					//Requête pour récupérer les observations par espèce d'oiseaux, commune et date (au format JJ/MM/AAAA)
					$query = "	SELECT 	DATE_FORMAT(observations.date,'%d/%m/%Y') as date_formate, month(date) as mois, oiseaux.nom_commun as oiseau, 
										nombre, nom_commune
								FROM oiseaux 	JOIN observations ON oiseaux.id_oiseau=observations.id_oiseau
												JOIN communes ON observations.id_commune=communes.id_commune
												JOIN departements ON communes.id_dpt=departements.id_dpt
								WHERE (month(date)= ".$mois[0]." or month(date)= ".$mois[1]." or month(date)= ".$mois[2].") and nombre >= ".$taille." and departements.id_dpt='".$id_dep."'
								GROUP BY date, oiseau, nom_commune, mois, nombre";
					$result = mysqli_query ($link, $query);
					
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
					if ($nbligne ==0)
					{
						echo "Il n'y a pas d'observation dans le département ".$id_dep." (".$nom_dep.") durant le ".$nb_trim." trimestre ayant une taille minimale du groupe de ".$taille."<br><br>";
					}
					else
					{
						//Affichage du bilan des observations
						echo "<b><i> Bilan des ".$nbligne." observations faites dans le département ".$id_dep." (".$nom_dep.") durant le ".$nb_trim." trimestre par groupe d'au moins ".$taille." individus.</i></b><br><br>";
						//Ajout d'une puce numérotée
						echo "<ol>";
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
							{
								$date = $row[0];
								$oiseau = $row["oiseau"];
								$nb = $row["nombre"];
								$commune = $row["nom_commune"];
								echo "<li>Le <u>".$date."</u>, ".$nb." individus de ".$oiseau." ont été observés à <i>".$commune."</i>.<br>";
								
							}
						echo "</ol>";
					}
				}
				else
				{
					echo "Il n'y a aucun résultat pour votre recherche";
				}
				}
				else
				{
					echo "Il n'y a aucun résultat pour votre recherche";
				}
				?>
		</div>
	
		<!-- DIV Pied de page -->		
		<?php include("DIVPied.html"); ?>
	</div>
	</body>
</head>