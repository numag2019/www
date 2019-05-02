<?php
// ********************************************************************
// PARTIE : Includes et initialisation des variables
// ********************************************************************

// Inclusion de la librairie JpGraph
require_once ('../../jpgraph-4.2.6/src/jpgraph.php');
require_once ('../../jpgraph-4.2.6/src/jpgraph_pie.php');

// Constantes (connection mysql)
define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PASS', '');
define('MYSQL_DATABASE', 'tuto_jp_graph');

// Tableaux de données destinées à JpGraph
$tableauAnnees = array();
$tableauNombreVentes = array();

// ********************************************************************
// PARTIE : Production des données avec Mysql
// ********************************************************************

$sql = <<<EOF
	SELECT  
		YEAR(`DTHR_VENTE`) AS ANNEE,
		COUNT(ID) AS NBR_VENTES  
	FROM `ventes`
	GROUP BY YEAR(`DTHR_VENTE`)
EOF;

// Connexion à la BDD
$mysqlCnx = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS) or die('Pb de connxion mysql');

// Sélection de la base de données
@mysql_select_db(MYSQL_DATABASE) or die('Pb de sélection de la base');

// Requête
$mysqlQuery = @mysql_query($sql, $mysqlCnx) or die('Pb de requête');

// Fetch sur chaque enregistrement
while ($row = mysql_fetch_array($mysqlQuery,  MYSQL_ASSOC)) {
	// Alimentation des tableaux de données
	$tableauAnnees[] = 'Année ' . $row['ANNEE'];
	$tableauNombreVentes[] = $row['NBR_VENTES'];
}

// ********************************************************************
// PARTIE : Création du graphique 
// ********************************************************************

// On spécifie la largeur et la hauteur du graphique conteneur&#160;
$graph = new PieGraph(400,300);

// Titre du graphique
$graph->title->Set("Volume des ventes par années");

// Créer un graphique secteur (classe PiePlot)
$oPie = new PiePlot($tableauNombreVentes);

// Légendes qui accompagnent chaque secteur, ici chaque année
$oPie->SetLegends($tableauAnnees);

// position du graphique (légèrement à droite)
$oPie->SetCenter(0.4); 

$oPie->SetValueType(PIE_VALUE_ABS);

// Format des valeurs de type entier
$oPie->value->SetFormat('%d');

// Ajouter au graphique le graphique secteur
$graph->Add($oPie);

// Provoquer l'affichage (renvoie directement l'image au navigateur)
$graph->Stroke();
?>