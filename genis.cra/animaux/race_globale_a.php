<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.css"/>
	 
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.js"></script>

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
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>

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
//Récupération de la race choisie
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
						//Requête pour récupérer les effectifs de femelles nées
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
						//Requête pour récupérer les effectifs de taureaux
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
					echo "</tr>";
					
					//Affichage des effectifs de détenteurs dans l'année dans chaque case du tableau
					echo "<tr><td> Détenteurs </td>";
					$j=1;
					$nb_femelle_nee[0]="Détenteurs";
					for($i=$annee1;$i<=$annee2;$i++)
					{
						//Requête pour récupérer les effectifs de détenteurs
						$query= "SELECT nb_detenteur(".$i.",".$code_race.")";
						$result = mysqli_query ($link, $query);
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
							{
									echo "<td><center>";
									$nb_détenteur[$j]=$row[0];
									echo $nb_détenteur[$j]." ";
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