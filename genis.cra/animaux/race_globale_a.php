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

//supression des graphiques pour ne pas les corrompres s'ils existents déjà
if (is_readable('../graph/EvoEffBovins.png') == TRUE)
    unlink('../graph/EvoEffBovins.png');
if (is_readable('../graph/EvoEffEquin.png') == TRUE)
    unlink('../graph/EvoEffEquin.png');
if (is_readable('../graph/EvoEffovins.png') == TRUE)
    unlink('../graph/EvoEffovins.png');

?>

<div class="row">
<div class="col-md-12">

    <div class="widget">
		<div class="widget-head">
			<div class="pull-left">Informations sur les races</div>
			<div class="widget-icons pull-right">
                <a href="http://genis.cra/fpdf181/exports/fiche_races_globales.php"><i>PDF</i></a>
				<a href="../mac_bootstrap/macadmin/theme/#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
				<a href="../mac_bootstrap/macadmin/theme/#" class="wclose"><i class="fa fa-times"></i></a>
        </div>
        <div class="clearfix"></div>
		</div>
	<div class="widget-content">
        <div class="padd">
          <?php
//Récupération de la periode choisie
					$annee1 = $_GET["annee1"];
					$annee2 = $_GET["annee2"];
					
					//Liste des années
					$j=0;
					for($i=$annee1;$i<=$annee2;$i++)
					{
						$annee[$j]=$i;
						$j=$j+1;
					}
                    $_SESSION['annee_glo'] = $annee;
					
					//Connection au serveur
					$link = mysqli_connection(HOST_DB,DB_NAME,USER_DB,PW_DB);
					mysqli_set_charset ($link, "utf8mb4");
					
		?>
					
	<div class="widget">
		<div class="widget-head">
			<div class="pull-left">Evolution des effectifs des races</div>
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
					
					// Affichage des effectifs de bovins chaque case du tableau
					echo "<tbody><tr><td><b>Bovins</b></td>";
					$j=1;
					$bovin[0]="Bovins";
					for($i=$annee1;$i<=$annee2;$i++)
					{
						//Requête pour récupérer les effectifs de bovins
						$query= "SELECT nb_espece(3,".$i.")";
						$result = mysqli_query ($link, $query);
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
							{
								echo "<td><center>";
								$bovin[$j]=$row[0];
								echo "<b>".$bovin[$j]."<b> ";
								echo"</center></td>";
							}
						$j=$j+1;
					}
					$_SESSION['bovin'] = $bovin;
					echo "</tr>";
					
							// Affichage des effectifs de béarnaises chaque case du tableau
							echo "<tbody><tr><td><p style='text-indent:30px'>Béarnaises</td>";
							$j=1;
							$bearnaise[0]="Béarnaises";
							for($i=$annee1;$i<=$annee2;$i++)
							{
								//Requête pour récupérer les effectifs de béarnaises
								$query= "SELECT nb_race(19,".$i.")";
								$result = mysqli_query ($link, $query);
								while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
									{
										echo "<td><center>";
										$bearnaise[$j]=$row[0];
										echo $bearnaise[$j]." ";
										echo"</center></td>";
									}
								$j=$j+1;
							}
							$_SESSION['bearnaise'] = $bearnaise;
							echo "</tr>";
							
							// Affichage des effectifs de bordelaises chaque case du tableau
							echo "<tr><td><p style='text-indent:30px'>Bordelaises</td>";
							$j=1;
							$bordelaise[0]="Bordelaises";
							for($i=$annee1;$i<=$annee2;$i++)
							{
								//Requête pour récupérer les effectifs de bordelaises
								$query= "SELECT nb_race(5,".$i.")";
								$result = mysqli_query ($link, $query);
								while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
									{
										echo "<td><center>";
										$bordelaise[$j]=$row[0];
										echo $bordelaise[$j]." ";
										echo"</center></td>";
									}
								$j=$j+1;
							}
							$_SESSION['bordelaise'] = $bordelaise;
							echo "</tr>";
							
							// Affichage des effectifs de marines chaque case du tableau
							echo "<tr><td><p style='text-indent:30px'>Marines</td>";
							$j=1;
							$marine[0]="Marines";
							for($i=$annee1;$i<=$annee2;$i++)
							{
								//Requête pour récupérer les effectifs de marines
								$query= "SELECT nb_race(6,".$i.")";
								$result = mysqli_query ($link, $query);
								while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
									{
										echo "<td><center>";
										$marine[$j]=$row[0];
										echo $marine[$j]." ";
										echo"</center></td>";
									}
								$j=$j+1;
							}
							$_SESSION['marine'] = $marine;
							echo "</tr>";
					
						
					// Affichage des effectifs d'equins chaque case du tableau
					echo "<b><tr><td><b>Equins</b></td>";
					$j=1;
					$equin[0]="Equins";
					for($i=$annee1;$i<=$annee2;$i++)
					{
						//Requête pour récupérer les effectifs d'equins
						$query= "SELECT nb_espece(2,".$i.")";
						$result = mysqli_query ($link, $query);
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
							{
								echo "<td><center>";
								$equin[$j]=$row[0];
								echo "<b>".$equin[$j]."<b> ";
								echo"</center></td>";
							}
						$j=$j+1;
					}
					$_SESSION['equin'] = $equin;
					echo "</tr></b>";
					
							// Affichage des effectifs de poneys landais chaque case du tableau
							echo "<tr><td><p style='text-indent:30px'>Poneys Landais</td>";
							$j=1;
							$plandais[0]="Poneys Landais";
							for($i=$annee1;$i<=$annee2;$i++)
							{
								//Requête pour récupérer les effectifs de poneys landais
								$query= "SELECT nb_race(2,".$i.")";
								$result = mysqli_query ($link, $query);
								while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
									{
										echo "<td><center>";
										$plandais[$j]=$row[0];
										echo $plandais[$j]." ";
										echo"</center></td>";
									}
								$j=$j+1;
							}
							$_SESSION['plandais'] = $plandais;
							echo "</tr>";
					
					// Affichage des effectifs d'ovins chaque case du tableau
					echo "<tr><td><b>Ovins</b></td>";
					$j=1;
					$ovin[0]="Ovins";
					for($i=$annee1;$i<=$annee2;$i++)
					{
						//Requête pour récupérer les effectifs d'ovins
						$query= "SELECT nb_espece(4,".$i.")";
						$result = mysqli_query ($link, $query);
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
							{
								echo "<td><center>";
								$ovin[$j]=$row[0];
								echo "<b>".$ovin[$j]."<b> ";
								echo"</center></td>";
							}
						$j=$j+1;
					}
					$_SESSION['ovin'] = $ovin;
					echo "</tr>";
					
							// Affichage des effectifs de moutons landais chaque case du tableau
							echo "<tr><td><p style='text-indent:30px'>Moutons Landais</td>";
							$j=1;
							$mlandais[0]="Moutons Landais";
							for($i=$annee1;$i<=$annee2;$i++)
							{
								//Requête pour récupérer les effectifs de moutons landais
								$query= "SELECT nb_race(9,".$i.")";
								$result = mysqli_query ($link, $query);
								while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
									{
										echo "<td><center>";
										$mlandais[$j]=$row[0];
										echo $mlandais[$j]." ";
										echo"</center></td>";
									}
								$j=$j+1;
							}
							$_SESSION['mlandais'] = $mlandais;
							echo "</tr>";
							
							// Affichage des effectifs de sasi ardia chaque case du tableau
							echo "<tr><td><p style='text-indent:30px'>Sasi Ardia</td>";
							$j=1;
							$sasi[0]="Sasi Ardia";
							for($i=$annee1;$i<=$annee2;$i++)
							{
								//Requête pour récupérer les effectifs de marines
								$query= "SELECT nb_race(10,".$i.")";
								$result = mysqli_query ($link, $query);
								while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
									{
										echo "<td><center>";
										$sasi[$j]=$row[0];
										echo $sasi[$j]." ";
										echo"</center></td>";
									}
								$j=$j+1;
							}
							$_SESSION['sasi'] = $sasi;
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