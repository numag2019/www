<!-- Page crée par les NumAg 2019
Cette page contient un formulaire permettant de récupérer la période choisie l'utilisateur pour le calcul des effectifs par espèce et par race
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
        <div class="pull-left">Choisir la période</div>
        <div class="clearfix"></div>
      </div>
      <div class="widget-content">
        <div class="padd">
          <?php

// *************************
// Sélection de la période
// *************************

//Récupération des dates
$firstyear = 2010;
$currentyear = date('Y');

//Création d'un formulaire
echo "<FORM action = 'race_globale_a.php' method = 'GET' name = 'forma'>";

//Choix d'une année dans une liste déroulante
echo 	"<table>
			<tr>
				<td><br>";
					echo "<label>Année</label>";
	echo		"</td>
				<td></td>
				<td><br> De ";
					//Définition du tableau contenant les valeur de la liste déroulante et du nom de cette liste pour le choix de la 1ère année
					$j=0;
					$tab_annee1=array();
					for ($i=$firstyear;$i<$currentyear;$i++){
						$tab_annee1[$j]= $i;
						$j=$j+1;
					}
					$annee1 = "annee1";
					
					//Création de la liste déroulante
					include "fonctions_php.php";
					creer_liste_HTML ($annee1,$tab_annee1);
					
				echo " à ";
					//Définition du tableau contenant les valeur de la liste déroulante et du nom de cette liste pour le choix de la 2ème année
					$j=0;
					$tab_annee2=array();
					for ($i=($firstyear+1);$i<($currentyear+1);$i++){
						$tab_annee2[$j]= $i;
						$j=$j+1;
					}
					$annee2 = "annee2";
					
					//Création de la liste déroulante
					creer_liste_HTML ($annee2,$tab_annee2);
	?>
	
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td><br>
			<INPUT TYPE = 'SUBMIT' class='btn btn-sm btn-success' name = 'bt_submit' value = 'Rechercher' ><br><br>
		</td>
		<td></td>
		<td></td>
	</tr>
</table>
</FORM>

    </div>
    </div>

</div>
</div>

    

<?php require BODY_END;?>


</body>
</html>