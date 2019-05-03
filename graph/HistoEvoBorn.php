<?php

session_start();

//Exemple
require_once ('./jpgraph-4.2.6/src/jpgraph.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_bar.php');

//Les datas pour l'exemple
$datax1=array(45,60,55,75,60,40);
$datax2=array(65,70,60,50,40,30);
$années=array("2014","2015","2016","2017","2018","2019");

/*
$datax1=$_GET["-_Insérer les naissances de mâles en ordonnée issu des requêtes_-"];
$datax2=$_GET["-_Insérer les naissances de femelles en ordonnée issu des requêtes_-"];
$années=$_GET["-_Insérer les vaches nées et conservées en ordonnée issu des requêtes_-"];
*/

// *********************
// Création du graphique
// *********************

$graph = new Graph(640,480);    
$graph->SetScale("textlin");

$graph->SetMargin(50,65,50,40);

// Désactiver le cadre autour du graphique
$graph->SetFrame(false);

// Ajouter un onglet
$graph->tabtitle->Set("Evolution des naissances");
$graph->tabtitle->SetFont(FF_ARIAL,FS_BOLD,14);
$graph->tabtitle->SetColor("black");
$graph->tabtitle->SetFillColor("#E9EBF3");

// Apparence des grilles
$graph->ygrid->SetFill(true,'#DDDDDD@0.5','#BBBBBB@0.5');
$graph->ygrid->SetLineStyle('dashed');
$graph->ygrid->SetColor('gray');
$graph->xgrid->Show();
$graph->xgrid->SetLineStyle('dashed');
$graph->xgrid->SetColor('gray');
$graph->xaxis->setTickLabels($années);
$graph->xaxis->setLabelAngle(50);

// *******************************
// Créer un histogramme
// *******************************

	////Premier histo////
	
	$histo_male = new barPlot($datax2);
	$histo_male->value->SetFormat('%d');
	$histo_male->SetLegend('Mâles nés');
	// Changer la taille//  $histo_male->SetWidth(valeur);
	$histo_male->SetWeight(0);
	
	
	////Second histo////
	
	$histo_fem = new BarPlot($datax1);
	$histo_fem->SetLegend('Femelles nées');
	$histo_fem->value->Show();

	$histo_fem->value->SetFormat('%d');
	$histo_fem->SetWeight(0);

	
	// Créer l'ensemble d'histogrammes accumulés
	$gbplot = new AccBarPlot(array( $histo_fem, $histo_male));
	
	// Afficher les valeurs de chaque histogramme groupé
	$gbplot->value->Show();
	$gbplot->value->SetFont(FF_COMIC,FS_NORMAL,8);
	$gbplot->value->SetFormat('%d');

	

//Nom des axes
$graph->yaxis->title->Set("Nombre de naissances");
$graph->xaxis->title->Set("Années");

// Position de la légende
$graph->legend->Pos(0.10,0.05);

// Ajouter l'ensemble accumulé
$graph->Add($gbplot);
	$histo_fem->SetFillColor('#6078E5');
	$histo_male->SetFillColor('#A5E4F2');

// Envoyer au navigateur
$graph->Stroke();
$graph->Stroke("EvoNaissances.png");
?>