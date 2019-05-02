<!-- Page crée par les NumAg 2019
Réprésentant de la page : Marine Gautier
Cette page contient un formulaire permettant de récupérer la race choisie 
et la période choisie par l'utilisateur pour le calcul des effectifs par race et l'affichage du catalogue ---->

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

/*
 * Starting connection to database
 */
$link = mysqli_connection(HOST_DB,DB_NAME,USER_DB,PW_DB);
mysqli_set_charset ($link, "utf8mb4");

?>

<div class="row">
<div class="col-md-12">

    <div class="widget">
      <div class="widget-head">
        <div class="pull-left">Choisir la période</div>
        <div class="widget-icons pull-right">
          <a href="../mac_bootstrap/macadmin/theme/#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
          <a href="../mac_bootstrap/macadmin/theme/#" class="wclose"><i class="fa fa-times"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="widget-content">
        <div class="padd">
          <?php

              
				//Récupération des dates
					$firstyear = 2010;
					$currentyear = date('Y');
					
					//Choix d'une année dans une liste déroulante
					echo "<table><tr>
						<td><br>";
							echo "<label>Année</label>";
						echo"</td><td> </td>
						<td><br> De ";
							//Définition du tableau contenant les valeur de la liste déroulante et du nom de cette liste
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
							//Définition du tableau contenant les valeur de la liste déroulante et du nom de cette liste
							$j=0;
							$tab_annee2=array();
							for ($i=($firstyear+1);$i<($currentyear+1);$i++){
								$tab_annee2[$j]= $i;
								$j=$j+1;
							}
							$annee2 = "annee2";
							//Création de la liste déroulante
							creer_liste_HTML ($annee2,$tab_annee2);
						
						echo"
						</tr><tr><td></td><td></td></tr>
						<tr><td><br>
						<INPUT TYPE = 'SUBMIT' class='btn btn-sm btn-success' name = 'bt_submit' value = 'Rechercher' ><br><br>
						</td><td></td><td></td></tr>
						</FORM></td>
						
					</table>"
					

          ?>

        </div>
      </div>

</div>
</div>

    

<?php require BODY_END;?>


</body>
</html>