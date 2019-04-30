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


?>

<div class="row">
<div class="col-md-12">

    <div class="widget">
      <div class="widget-head">
        <div class="pull-left">Informations sur la race</div>
        <div class="widget-icons pull-right">
          <a href="../mac_bootstrap/macadmin/theme/#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
          <a href="../mac_bootstrap/macadmin/theme/#" class="wclose"><i class="fa fa-times"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="widget-content">
        <div class="padd">
          <?php
//Récupération de la race et de la période choisies
					$code_race = $_GET["race"];
					$annee1 = $_GET["annee1"];
					$annee2 = $_GET["annee2"];
					
					//Connection au serveur
					$link = mysqli_connection(HOST_DB,DB_NAME,USER_DB,PW_DB);
					mysqli_set_charset ($link, "utf8mb4");
					
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
					

          ?>

        </div>
      </div>

</div>
</div>

    

<?php require BODY_END;?>


</body>
</html>