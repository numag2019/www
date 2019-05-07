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
			<div class="pull-left">Informations sur les éleveurs</div>
			<div class="widget-icons pull-right">
				<a href="../mac_bootstrap/macadmin/theme/#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
				<a href="../mac_bootstrap/macadmin/theme/#" class="wclose"><i class="fa fa-times"></i></a>
        </div>
        <div class="clearfix"></div>
		</div>
	<div class="widget-content">
        <div class="padd">
          <?php
//Récupération de la periode choisie
$code_race = $_GET["race"];
$annee = $_GET["annee"];


//Connection au serveur
$link = mysqli_connection(HOST_DB,DB_NAME,USER_DB,PW_DB);
mysqli_set_charset ($link, "utf8mb4");

$query = "	SELECT distinct elevage.no_elevage, nom, prenom, adresse, adresse2, tel, tel2, mail, lib_dpt 
			FROM contact left join commune on contact.id_commune=commune.id_commune 
						left join departement on commune.no_dpt=departement.no_dpt 
						left join elevage on contact.id_elevage=elevage.id_elevage 
						left join link_race_elevage on elevage.id_elevage=link_race_elevage.id_elevage 
						left join periode on elevage.id_elevage=periode.id_elevage 
			WHERE code_race=".$code_race."
			ORDER BY departement.no_dpt";
$result = mysqli_query ($link, $query);

//Récupération des données de la requete SQL dans une variable $resultat_ele
$resultat_ele = array();
foreach  ($result as $row) 
{
	$resultat_ele[] = $row;
}
$_SESSION['resultat_ele'] = $resultat_ele;
$_SESSION['resultat2'] = $result;
mysqli_data_seek($result,0);

            
$dep_prec='';
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
	{
		$id = $row[0];
		$nom = $row["nom"];
		$prenom = $row["prenom"];
		$adresse = $row["adresse"];
		$adresse2 = $row["adresse2"];
		$tel = $row["tel"];
		$tel2 = $row["tel2"];
		$mail = $row["mail"];
		$dep = $row["lib_dpt"];
		if ($dep_prec!=$dep)
		{	
		echo "<br><b>".$dep."</b><br>";
		}
		$dep_prec=$dep;
		echo "<p style='text-indent:20px'><b>".$id."</b> ".$nom." ".$prenom.", ".$adresse." ".$adresse2.", Tel : ".$tel."/".$tel2." Mail : ".$mail."</p>";
	}			
          ?>
		</div>

	</div>
</div>

    

<?php require BODY_END;?>


</body>
</html>