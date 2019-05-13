
﻿<html>
<body>
<?php

//*****************************************************************************************************************************************************************************************************************************************\\

// CETTE PAGE PERMET DE GÉNÉRER 4 FICHIERS .CSV À PARTIR DE LA BDD GENIS (ELEVEURS, ANIMAL, RACE, COEFFICIENTS).
//CEUX-CI VONT ALIMENTER LES 4 TABLES INTERMÉDIAIRES DE LA BDD DATACRANET (eleveurs_intermediaire, bovins_intermediaire, races_intermediaire, coefficients_intermediaire).  //
// ALIMENTE EN PDF ET EN CSV LE DOSSIER DE CRANET VIA FTP
//******************************************************************************************************************************************************************************************************************************************\\

// Page necessaire
// include("exportCRAnet.php");        // page export de GeniS
include('fonctioncreationcsv.php');			//page d'une fonction créant les csv
include('ftp.php');						//page d'une fonction transferant les csv au serveur distant

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// REQUETE ELEVEURS : 
//on sélectionne seulement les éleveurs dont l'elevage possède la/les race(s) Bearnaise, Bordelaise, Marine et dont le consentement est positif.
//(Bearnaise : 19, Bordelaise : 6, Marine : 6)

$requeteEleveurs="
SELECT id_contact,nom,prenom,mail FROM contact
JOIN link_race_elevage ON contact.id_elevage = link_race_elevage.id_elevage
WHERE link_race_elevage.code_race=19 OR link_race_elevage.code_race=6  OR link_race_elevage.code_race=5";

//Fonction creant le csv
$csv=creationcsv($requeteEleveurs,NULL,"tableauEleveurs");


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// REQUETE ANIMAL : 
//on sélectionne seulement les animaux dont la race est Bearnaise, Bordelaise, Marine et dont l'éleveur consent à partager ses données.
//
//(Bearnaise : 19, Bordelaise : 6, Marine : 6)

 $requeteAnimal1= "
select a.no_identification, a.nom_animal, a.sexe, if (p.id_type=1,true,false), a.code_race, c.id_contact
from periode p join elevage e on p.id_elevage=e.id_elevage join contact c on e.id_elevage=c.id_elevage 
join animal a on a.id_animal=p.id_animal 
join (select id_animal, max(id_periode) as idmax from periode p join elevage e 
on p.id_elevage=e.id_elevage 
join contact c on e.id_elevage=c.id_elevage group by id_animal order by id_animal) v 
on p.id_animal=v.id_animal and p.id_periode=v.idmax 
where a.code_race=19 OR a.code_race=5 OR a.code_race=6";

$requeteAnimal2="select a.no_identification, a.nom_animal, a.sexe, if (p.id_type=1,true,false), a.code_race,NULL 
from periode p 
JOIN animal a on a.id_animal=p.id_animal and a.sexe=1 join (select id_animal, max(id_periode) 
as idmax from periode group by id_animal) v on p.id_animal=v.id_animal 
and p.id_periode=v.idmax where a.code_race=19 OR a.code_race=5 OR a.code_race=6 and p.id_elevage=NULL";



//Fonction creant le csv
$csv=creationcsv($requeteAnimal1,$requeteAnimal2,"tableauAnimal");



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// REQUETE RACES : 
//on sélectionne seulement les races Bearnaise, Bordelaise, Marine.
//
//(Bearnaise : 19, Bordelaise : 6, Marine : 6)

$requeteRace= "SELECT code_race, lib_race FROM race
WHERE code_race=19 OR code_race=5 OR code_race=6";

//Fonction creant le csv
$csv=creationcsv($requeteRace,NULL,"tableauRace");


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// REQUETE COEFFICIENTS : 
//on sélectionne seulement les races Bearnaise, Bordelaise, Marine.
//
//(Bearnaise : 19, Bordelaise : 6, Marine : 6)

$requeteCoeff= "SELECT c.id_coeff, c.valeur_coeff, 
(SELECT a.no_identification from animal a where c.id_vache=a.id_animal), 
(SELECT a.no_identification from animal a where c.id_taureau=a.id_animal) 
FROM coefficients c JOIN periode p ON p.id_animal=c.id_vache and 
p.id_elevage IS NOT NULL JOIN animal a on a.id_animal=p.id_animal 
WHERE a.code_race=19 OR a.code_race=5 OR a.code_race=6 GROUP BY c.id_coeff";

//Fonction creant le csv
$csv=creationcsv($requeteCoeff,NULL,"tableauCoeff");


?>

<?php 
// transferts des fichiers csv vers serveur CRAnet via un protocol ftp (fonction situé dans ftp.php)
$chemin=array('csv/tableauEleveurs.csv','csv/tableauAnimal.csv','csv/tableauRace.csv','csv/tableauCoeff.csv');
$ftpTarget=array('tableauEleveurs.csv','tableauAnimal.csv','tableauRace.csv','tableauCoeff.csv');

$i=0;
while($i<count($chemin))
{
	$trsft=export_vers_cranet($chemin[$i], $ftpTarget[$i]);
	$i++;
}

//envoi des pdf du dossier pdf
include('envoi_pdf.php'); 

//Lancer la page php de mise à jour à distance après que les nouveaux csv aient été créé 
header('location:http://cranet/site_web_paillette/importexportCSV/inserercsv.php');
exit;

?>



</body>

</html>