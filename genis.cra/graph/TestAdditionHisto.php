<?php

session_start();

// On va chercher les biblios de jpgraph pour construire les graphiques
require_once ('./jpgraph-4.2.6/src/jpgraph.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_bar.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_line.php');

/* Cas où plusieurs listes sortent les effectifs de chaque race 
pour un même groupe de bêtes (bovin, équin,ovins)
$datay1=$_GET["-_Insérer les vaches nées et conservées en ordonnée issu des requêtes_-"];
$datay2=$_GET["-_Insérer les éleveurs issu des requêtes_-"];
$datay3=$_GET["-_Insérer le nombre total de vache en ordonnée issu des requêtes_-"];
$années=$_GET["-_Insérer les années_-"];
*/

/* Cas où la sortie est une liste contenant les listes des effectifs de chaque race
d'un même groupe de bêtes (bovin, équin, ovins)
$listeVal=$_GET["-_Insérer la grosse liste contenant les listes_-"];
*/

//Les datas pour l'exemple, a mettre en commentaire pour les tests
$datay1=array(30,25,20);
$datay2=array(10,20,30);
$datay3=array(80,70,60);
$années=array("2014","2015","2016");


$listVal=array($datay1,$datay2,$datay3);

// **********************
// Création du graphique 
// **********************

// Création du graphique conteneur
$graph = new Graph(640,480,'auto');    
$graph->SetScale("textlin");
$graph->img->SetMargin(60,80,30,40);
$graph->legend->Pos(0.02,0.05);

// Couleur de l'ombre et du fond de la légende
$graph->legend->SetShadow('darkgray@0.5');
$graph->legend->SetFillColor('lightblue@0.3');

// Pimper les axes
$graph->xaxis->setTickLabels($années);
$graph->xaxis->title->Set('Annees');
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetColor('black');
$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetColor('black');

$graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->SetColor('black');
$graph->ygrid->SetColor('black@0.5');


$graph->title->Set("Nombre d'animaux");
$graph->title->SetMargin(6);
$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);

// Couleurs et transparence par histogramme A AUTOMATISER
$aColors=array('gray','red', 'blue@0.3','green@0.8','pink');

$i=0;
// Chaque  histogramme est un élément du tableau:
$aGroupBarPlot = array();

foreach ($listVal as $key => $value) {
	$bplot = new BarPlot($listVal[$key]);
	$bplot->SetFillColor($aColors[$i++]);
	$bplot->SetLegend($key);
	$bplot->SetShadow('black@0.4');
	$aGroupBarPlot[] = $bplot; 
}

// Création de l'objet qui regroupe nos histogrammes
$gbarplot = new GroupBarPlot($aGroupBarPlot);
$gbarplot->SetWidth(0.8);

// Ajouter au graphique
$graph->Add($gbarplot);

// Afficher
$graph->Stroke();
?>