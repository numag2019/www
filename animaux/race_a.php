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
					
					//Liste des années
					$j=0;
					for($i=$annee1;$i<=$annee2;$i++)
					{
						$annee[$j]=$i;
						$j=$j+1;
					}
					
					//Connection au serveur
					$link = mysqli_connection(HOST_DB,DB_NAME,USER_DB,PW_DB);
					mysqli_set_charset ($link, "utf8mb4");
					
					
					//Requête pour récupérer le nom de la race choisie
					$query_race = "	SELECT 	lib_race
									FROM race
									WHERE code_race='".$code_race."'";
					$result_race = mysqli_query ($link, $query_race);
					while ($row = mysqli_fetch_array($result_race, MYSQLI_BOTH))
						{
							$race = $row[0];
						}
		?>
					
		<div class="widget">
			  <div class="widget-head">
				<div class="pull-left">Evolution des effectifs inventoriés</div>
				<div class="widget-icons pull-right">
				  <a href="../mac_bootstrap/macadmin/theme/#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
				  <a href="../mac_bootstrap/macadmin/theme/#" class="wclose"><i class="fa fa-times"></i></a>
				</div>
				<div class="clearfix"></div>
			  </div>
			  <div class="widget-content">
			  
		<?php
					//Création du tableau
					echo "<table border ='1', class = 'table table-striped table-bordered table-hover'>";
					
					//Affichage des titres dans la 1ère ligne du tableau
						echo "<thead><tr><td></td>";
						for($i=$annee1;$i<=$annee2;$i++)
						{
							echo "<td>";
							echo "<b><center>".$i." </center></b>";
							echo"</td>";
						}
						echo "</tr></thead>";
					
					// Affichage des effectif de femelles dans chaque case du tableau
					echo "<tbody><tr><td> Totale femelles inventoriées </td>";
					$j=1;
					$nb_femelle[0]="Totale femelles inventoriées";
					for($i=$annee1;$i<=$annee2;$i++)
					{
						//Requête pour récupérer les effectifs de femelles
						$query= "SELECT nb_femelle(".$i.",".$code_race.")";
						$result = mysqli_query ($link, $query);
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
							{
									echo "<td><center>";
									$nb_femelle[$j]=$row[0];
									echo $nb_femelle[$j]." ";
									echo"</center></td>";
							}
						$j=$j+1;
					}
					echo "</tr>";
					
					//Affichage des effectifs de femelles de plus de 2 ans dans chaque case du tableau
					echo "<tr><td> Femelles de plus de 2 ans  </td>";
					$j=1;
					$nb_femelle_2[0]="Femelles de plus de 2 ans";
					for($i=$annee1;$i<=$annee2;$i++)
					{
						//Requête pour récupérer les effectifs de femelles de plus de 2ans 
						$query= "SELECT nb_femelle_2(".$i.",".$code_race.")";
						$result = mysqli_query ($link, $query);
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
							{
									echo "<td><center>";
									$nb_femelle_2[$j]=$row[0];
									echo $nb_femelle_2[$j]." ";
									echo"</center></td>";
							}
						$j=$j+1;
					}
					echo "</tr>";
					
					//Affichage des effectifs de femelles née dans l'année dans chaque case du tableau
					echo "<tr><td> Femelles nées dans l'année </td>";
					$j=1;
					$nb_femelle_nee[0]="Femelles nées dans l'année";
					for($i=$annee1;$i<=$annee2;$i++)
					{
						//Requête pour récupérer les effectifs de femelles
						$query= "SELECT nb_femelle_nee(".$i.",".$code_race.")";
						$result = mysqli_query ($link, $query);
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
							{
									echo "<td><center>";
									$nb_femelle_nee[$j]=$row[0];
									echo $nb_femelle_nee[$j]." ";
									echo"</center></td>";
							}
						$j=$j+1;
					}
					echo "</tr>";
					
					//Affichage des effectifs de taureaux dans chaque case du tableau
					echo "<tr><td> Taureaux </td>";
					$j=1;
					$nb_taureau[0]="Taureaux";
					for($i=$annee1;$i<=$annee2;$i++)
					{
						//Requête pour récupérer les effectifs de femelles
						$query= "SELECT nb_taureau(".$i.",".$code_race.")";
						$result = mysqli_query ($link, $query);
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
							{
									echo "<td><center>";
									$nb_taureau[$j]=$row[0];
									echo $nb_taureau[$j]." ";
									echo"</center></td>";
							}
						$j=$j+1;
					}
					echo "</tr></tbody>";
					
					echo "</table>";
	
          ?>
</div>
</div>

<div class="widget">
			  <div class="widget-head">
				<div class="pull-left">Evolution du nombre de naissance</div>
				<div class="widget-icons pull-right">
				  <a href="../mac_bootstrap/macadmin/theme/#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
				  <a href="../mac_bootstrap/macadmin/theme/#" class="wclose"><i class="fa fa-times"></i></a>
				</div>
				<div class="clearfix"></div>
			  </div>
			  <div class="widget-content">
			  
		<?php
					//Création du tableau
					echo "<table border ='1', class = 'table table-striped table-bordered table-hover'>";
					
					//Affichage des titres dans la 1ère ligne du tableau
						echo "<thead><tr><td></td>";
						for($i=$annee1;$i<=$annee2;$i++)
						{
							echo "<td>";
							echo "<b><center>".$i." </center></b>";
							echo"</td>";
						}
						echo "</tr></thead>";
					
					// Affichage des effectifs de veaux dans chaque case du tableau
					echo "<tbody><tr><td> Nombre de veaux nés </td>";
					$j=1;
					$nb_veau[0]="Nombre de veaux nés";
					for($i=$annee1;$i<=$annee2;$i++)
					{
						//Requête pour récupérer les effectifs de veaux
						$query= "SELECT nb_veau_tot(".$i.",".$code_race.")";
						$result = mysqli_query ($link, $query);
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
							{
									echo "<td><center>";
									$nb_veau[$j]=$row[0];
									echo $nb_veau[$j]." ";
									echo"</center></td>";
							}
						$j=$j+1;
					}
					echo "</tr></tbody>";
					
					//Affichage des sous-titre nb et %
					echo "<thead><tr><td></td>";
						for($i=$annee1;$i<=$annee2;$i++)
						{
							echo "<td>";
							echo "<b><center> Nombre (%) </center></b>";
							echo"</td>";
						}
						echo "</tr></thead>";
						
						
					// Affichage des effectifs de veaux mâles dans chaque case du tableau
					echo "<tbody><tr><td> Veaux mâles </td>";
					$j=1;
					$nb_veau_m[0]="Veaux mâles";
					for($i=$annee1;$i<=$annee2;$i++)
					{
						//Requête pour récupérer les effectifs de veaux
						$query= "SELECT nb_veau_m(".$i.",".$code_race.")";
						$result = mysqli_query ($link, $query);
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
							{
									echo "<td><center>";
									$nb_veau_m[$j]=$row[0];
									echo $nb_veau_m[$j]." (".intval(($nb_veau_m[$j]/$nb_veau[$j])*100).")";
									echo"</center></td>";
							}
						$j=$j+1;
					}
					echo "</tr>";
					
					// Affichage des effectifs de veaux dans chaque case du tableau
					echo "<tbody><tr><td> Veaux femelles </td>";
					$j=1;
					$nb_veau_f[0]="Veaux femelles";
					for($i=$annee1;$i<=$annee2;$i++)
					{
						//Requête pour récupérer les effectifs de veaux
						$query= "SELECT nb_veau_f(".$i.",".$code_race.")";
						$result = mysqli_query ($link, $query);
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
							{
									echo "<td><center>";
									$nb_veau_f[$j]=$row[0];
									echo $nb_veau_f[$j]." (".intval(($nb_veau_f[$j]/$nb_veau[$j])*100).")";
									echo"</center></td>";
							}
						$j=$j+1;
					}
					echo "</tr></tbody>";
					
					echo "</table>";
	
          ?>
        </div>
      </div>

</div>
</div>

    

<?php require BODY_END;?>


</body>
</html>