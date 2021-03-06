<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Page crée par les NumAg 2019
		Cette page contient l'export fiche eleveur avec la liste des éleveurs de la race
		Etudiant référent : Marine Gautier---->
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

?>

<div class="row">
<div class="col-md-12">

    <div class="widget">
		<div class="widget-head">
			<div class="pull-left">Informations sur les éleveurs</div>
			<div class="widget-icons pull-right">
                <a href="http://genis.cra/fpdf181/exports/fiche_eleveurs.php"><i>PDF</i></a>
				<a href="../mac_bootstrap/macadmin/theme/#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
				<a href="../mac_bootstrap/macadmin/theme/#" class="wclose"><i class="fa fa-times"></i></a>
        </div>
        <div class="clearfix"></div>
		</div>
	<div class="widget-content">
        <div class="padd">
          <?php
// *********************************************************************
// Récupération des informations à partir de la page visuEleveur.php
// *********************************************************************

//Récupération de la race choisie
$code_race = $_GET["race"];

//Vérification la race "Inconnue" n'a pas été choisie
if ($code_race==1)
{
	echo "Aucune race n'a été selectionnée";
}
else{
	
//Récupération de l'année choisie
$annee = $_GET["annee"];
$_SESSION['annee_ele'] = $annee;

//Connection au serveur
$link = mysqli_connection(HOST_DB,DB_NAME,USER_DB,PW_DB);
mysqli_set_charset ($link, "utf8mb4");

//Récupération du nom de la race
$query_race = "	SELECT lib_race
			FROM race
			WHERE code_race=".$code_race;
$result_race = mysqli_query ($link, $query_race);
while ($row = mysqli_fetch_array($result_race, MYSQLI_NUM))
	{
		$race = $row[0];
	}
    
$_SESSION['race_ele'] = $race;

// ********************************************************
// Création de la liste des éleveurs de la race
// *******************************************************

//Récupération des informations sur l'eleveur
$query = "	SELECT distinct elevage.no_elevage, nom, prenom, adresse, adresse2, tel, tel2, mail, lib_dpt 
			FROM contact left join commune on contact.id_commune=commune.id_commune 
						left join departement on commune.no_dpt=departement.no_dpt 
						left join elevage on contact.id_elevage=elevage.id_elevage 
						left join link_race_elevage on elevage.id_elevage=link_race_elevage.id_elevage 
						left join periode on elevage.id_elevage=periode.id_elevage 
			WHERE code_race=".$code_race." and contact.Consentement='Oui'
			ORDER BY departement.no_dpt";
$result = mysqli_query ($link, $query);

//Récupération des données de la requete SQL dans une variable $resultat_ele
$resultat_ele = array();


while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
	{
		$resultat_ele[] = $row;
	}

mysqli_data_seek($result,0);
$_SESSION['resultat_ele'] = $resultat_ele;
$_SESSION['resultat2'] = $result;
 
//Affichage de la liste 
$dep_prec='';
while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
	{
		$id = $row[0];
		$nom = $row[1];
		$prenom = $row[2];
		$adresse = $row[3];
		$adresse2 = $row[4];
		$tel = $row[5];
		$tel2 = $row[6];
		$mail = $row[7];
		$dep = $row[8];
		if ($dep_prec!=$dep)
		{	
		echo "<br><b>".$dep."</b><br>";
		}
		$dep_prec=$dep;
		echo "<p style='text-indent:20px'><b>".$id."</b> ".$nom." ".$prenom.", ".$adresse." ".$adresse2.", Tel : ".$tel."/".$tel2." Mail : ".$mail."</p>";
	}
}	
          ?>
		</div>

	</div>
</div>

    

<?php require BODY_END;?>


</body>
</html>