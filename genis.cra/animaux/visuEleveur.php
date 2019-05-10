<!-- Page crée par les NumAg 2019
Cette page contient un formulaire permettant de récupérer la race choisie 
et la période choisie par l'utilisateur pour l'affichage de la liste des éleveurs
Etudiant référent : Marine Gautier---->

<!DOCTYPE html>
<html lang="en">
<head>

  <title>GenIS</title>

  <?php
  require_once '../libraries/constants.php';
  require_once HEAD_START;
  ?>

  <!--Optional sources start -->
  <script type="text/javascript" src="js/visu_elevage.js"></script>
  <!-- Optional sources end -->

</head>

<body>

<?php
session_start();
$_SESSION['current_page']='visu_elevage';

require BODY_START;

//Connection à la BDD

$link = mysqli_connection(HOST_DB,DB_NAME,USER_DB,PW_DB);
mysqli_set_charset ($link, "utf8mb4");

?>

<div class="row">
<div class="col-md-12">

    <div class="widget">
      <div class="widget-head">
        <div class="pull-left">Choisir la race et la période</div>
        <div class="clearfix"></div>
      </div>
      <div class="widget-content">
        <div class="padd">
  <?php

// *************************
// Sélection de la race
// *************************

//Requête pour récupérer toutes les races
$query_race = "SELECT code_race, lib_race FROM race";
$result_race = mysqli_query ($link, $query_race);
	
//Mise en forme dans un tableau pour aligner les listes déroulantes du formulaire
echo "<table>";
	
	//Choix d'un observateur dans une liste déroulante
	echo 	"<tr>
				<td>";
					echo "<label>Race</label> <br><br>";
		echo	"</td>
				<td></td>
				<td>";
					//Création d'un formulaire
					echo "<FORM action = 'eleveur_a.php' method = 'GET' name = 'forma'>";
					//Définition du nom de la liste déroulante
					echo "<select name = race>";
					//Enregistrement des id et affichage des noms des races dans la liste déroulante
					while ($row = mysqli_fetch_array($result_race, MYSQLI_BOTH))
						{
							$id_nom = $row[0];
							$nom = $row ["lib_race"];
							echo ("<option value =".$id_nom.">".$nom)."</option>";
						}
					echo "</select><br><br>";
		echo	"</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>";

// *************************
// Sélection de la période
// *************************

//Récupération des dates
$firstyear = 2010;
$currentyear = date('Y');

	//Choix d'une année dans une liste déroulante
	echo 	"<tr>
				<td>";
					echo "<label>Année</label><br>";
		echo	"</td>
				<td></td>
				<td>";
					//Définition du tableau contenant les valeur de la liste déroulante et du nom de cette liste
					$j=0;
					$tab_annee=array();
					for ($i=$firstyear;$i<=$currentyear;$i++){
						$tab_annee[$j]= $i;
						$j=$j+1;
					}
					$annee = "annee";
					//Création de la liste déroulante
					include "fonctions_php.php";
					creer_liste_HTML ($annee,$tab_annee);
		?>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td>
			<INPUT TYPE = 'SUBMIT' class='btn btn-sm btn-success' name = 'bt_submit' value = 'Rechercher' ><br><br>
		</td>
		<td></td>
		<td></td>
	</tr>
</FORM><br><br>
</table>

    </div>
    </div>

</div>
</div>

    

<?php require BODY_END;?>


</body>
</html>