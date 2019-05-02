<!-- Choix du trimestre et du département sur des listes déroulantes et choix de la valeur minimale d'un groupe 
qui sont ensuite récupérés sur la page f2_a.php pour le calcul du nombre d'observations par département -->

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
					//Connection au serveur
					$link = mysqli_connect ("localhost","root", "", "oiseaudb");
					mysqli_set_charset ($link, "utf8mb4");
					
					//Choix de la BDD et message d'erreur si connexion impossible
					mysqli_select_db ($link, "oiseaudb") or die ("Impossible de sélectionner la BDD oiseaudb : ".mysqli_error($link));
					
					//Mise en forme dans un tableau pour aligner le formulaire
					echo "<table>";
					//Choix d'un trimestre dans une liste déroulante
					echo "<tr>
						<td>";
							echo "Choisissez un trimestre : <br>";
						echo"</td>
						<td>";
							//Création d'un formulaire pour le choix du trimestre, de la valeur minimale du groupe et du département
							echo "<FORM action = 'f2_a.php' method = 'GET' name = 'formb'>";
							//Définition du tableau contenant les valeur de la liste déroulante et du nom de cette liste
							$tab_trim=["janv/fév/mars", "avril/mai/juin", "juil/aout/sept", "oct/nov/déc"];
							$trim = "trimestre";
							//Création de la liste déroulante
							include "fonctions.php";
							creer_liste_HTML ($trim,$tab_trim);
						echo"</td>
					</tr><tr><td></td><td></td></tr>";

					// Choix de la taille minimale du groupe d'oiseaux
					echo"<tr>
						<td>";
							echo "Choisissez la taille minimale des groupes d'oiseaux : <br>";
						echo"</td>
						<td>
							<INPUT TYPE = 'TEXT' name = 'taille' value = '' id = 'taille'>
						</td>
					</tr><tr><td></td><td></td></tr>";
					
					//Requête pour récupérer tous les départements
					$query_dep = "SELECT id_dpt, nom_dpt FROM departements";
					$result_dep = mysqli_query ($link, $query_dep);
					
					//Choix d'un département dans une liste déroulante
					echo"<tr>
						<td>";
							echo "Choisissez un département : <br>";
						echo"</td>
						<td>";
							//Définition du nom de la liste déroulante
							echo "<select name = dep>";
							//Enregistrement des id et affichage des noms des départements dans la liste déroulante
							while ($row = mysqli_fetch_array($result_dep, MYSQLI_BOTH))
								{
									$id_dep = $row[0];
									$dep = $row ["nom_dpt"];	
									echo ("<option value =".$id_dep.">".$dep)."</option>";
								}
							echo "</select>";
						echo"</td>
					</tr>
					</table><br>";
					//Création d'un bouton "Soumettre"
					echo "<center><INPUT TYPE = 'SUBMIT' name = 'bt_submit' value = 'Soumettre' ></center>";
					echo "</FORM><br>";
				?>
		</div>
	
		<!-- DIV Pied de page -->		
		<?php include("DIVPied.html"); ?>
	</div>
	</body>
</head>