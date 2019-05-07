<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.css"/>
	 
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
	<!-- Page crée par les NumAg 2019
		Réprésentant de la page : Marine Gautier
		Cette page contient l'export fiche race avec les tableaux et graphique des effectis, des naisances et des présences dan sla race ---->
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
                <a href="http://genis.cra/fpdf181/exports/fiche_race.php"><i>PDF</i></a>
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
                    $_SESSION['annee'] = $annee;
					
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
                    $_SESSION['nb_femelle'] = $nb_femelle;
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
                    $_SESSION['nb_femelle_2'] = $nb_femelle_2;
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
                    $_SESSION['nb_femelle_nee'] = $nb_femelle_nee;
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
                    $_SESSION['nb_taureau'] = $nb_taureau;
					echo "</tr>";
					
					//Affichage des effectifs de détenteurs dans l'année dans chaque case du tableau
					echo "<tr><td> Détenteurs </td>";
					$j=1;
					$nb_detenteur[0]="Détenteurs";
					for($i=$annee1;$i<=$annee2;$i++)
					{
						//Requête pour récupérer les effectifs de détenteurs
						$query= "SELECT nb_detenteur(".$i.",".$code_race.")";
						$result = mysqli_query ($link, $query);
						while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
							{
									echo "<td><center>";
									$nb_detenteur[$j]=$row[0];
									echo $nb_detenteur[$j]." ";
									echo"</center></td>";
							}
						$j=$j+1;
					}
                    $_SESSION['nb_detenteur'] = $nb_detenteur;
					echo "</tr></tbody>";
					
					echo "</table>";
					
          ?>
		</div>
	</div>
	
	<?php
		//Transmission des valeurs à la page HistoEvoFem pour afficher le graphique
		echo "<center><img src = 'HistoEvoFem.php?code_race=".$code_race."&annee1=".$annee1."&annee2=".$annee2."'></center>";
		?>
	

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
                    $_SESSION['nb_veau'] = $nb_veau;
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
                    $_SESSION['nb_veau_m'] = $nb_veau_m;
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
                    $_SESSION['nb_veau_f'] = $nb_veau_f;
					echo "</tr></tbody>";
					
					echo "</table>";
	
          ?>
        </div>
    </div>
		
		<div class="widget">
		<div class="widget-head">
		<?php
			echo "<div class='pull-left'>Présence dans la race en ".$annee2." </div>"
		?>
			<div class="widget-icons pull-right">
				  <a href="../mac_bootstrap/macadmin/theme/#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
				  <a href="../mac_bootstrap/macadmin/theme/#" class="wclose"><i class="fa fa-times"></i></a>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="widget-content">  
		<?php
			
			//Requête pour récupérer la liste des animaux et leurs informations
			$query = "	SELECT 	v_ani_mort.nom_animal as Nom, v_ani_mort.no_identification as No_Identification, elevage_actuel(v_ani_mort.id_animal,".$annee2.") as Elevage, v_ani_mort.sexe as Sexe, v_ani_mort.date_naiss as Date_Naissance, pere.nom_animal as Nom_Pere, pere.no_identification as No_Identification_Pere, mere.nom_animal as Nom_Mere, mere.no_identification as No_Identification_Mere, contact.nom as Naisseur
						FROM v_ani_mort left join animal as pere on v_ani_mort.id_pere=pere.id_animal 
										left join animal as mere on v_ani_mort.id_mere=mere.id_animal
                                        left join animal as ani on v_ani_mort.id_animal=ani.id_animal
                                        left join periode as naissance on ani.id_animal=naissance.id_animal
                                        left join elevage as lieu_naiss on naissance.id_elevage=lieu_naiss.id_elevage
                                        left join contact on lieu_naiss.id_elevage=contact.id_elevage
						WHERE v_ani_mort.code_race=".$code_race." and year(v_ani_mort.date_naiss)<".$annee2." and (v_ani_mort.id_type=NULL or year(v_ani_mort.date_sortie)>".$annee2.") and naissance.id_type =3";
			$result = mysqli_query ($link, $query);
		
			//Affichage du tableau des présences dans la race
			include "fonctions_php.php";
			echo "<center>";
			creer_tab_HTML ($result);
			echo "</center><br><br>";
			
	
          ?>
		</div>
    </div>

</div>
</div>

    

<?php require BODY_END;?>


</body>
</html>