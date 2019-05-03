<?php

session_start();
//
// Problème de couleur de légende sa mère la pute
//


//Exemple
require_once ('./jpgraph-4.2.6/src/jpgraph.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_bar.php');

//Les datas pour l'exemple
$datax1=array(45,60,55,75,60,40);
$datax2=array(65,70,60,50,40,30);
$années=array("2014","2015","2016","2017","2018","2019");

/*
$datax=$_GET("-_Insérer le nom de vos données en abscisse_-");
$datay=$_GET("-_Insérer le nom de vos données en ordonnée_-");
*/

// *********************
// Création du graphique
// *********************

$graph = new Graph(640,480);    
$graph->SetScale("textlin");

$graph->SetMargin(50,65,20,40);

// Désactiver le cadre autour du graphique
$graph->SetFrame(false);

// Ajouter un onglet
$graph->tabtitle->Set("Effectif des femelles");
$graph->tabtitle->SetFont(FF_ARIAL,FS_BOLD,10);

// Apparence des grilles
$graph->ygrid->SetFill(true,'#DDDDDD@0.5','#BBBBBB@0.5');
$graph->ygrid->SetLineStyle('dashed');
$graph->ygrid->SetColor('gray');
$graph->xgrid->Show();
$graph->xgrid->SetLineStyle('dashed');
$graph->xgrid->SetColor('gray');
$graph->xaxis->setTickLabels($années);
$graph->xaxis->setLabelAngle(50);
$graph->legend->Pos(0.12,0.12,"right","top");

// *******************************
// Créer un histogramme
// *******************************

	////Premier histo////
	
	$histo_male = new barPlot($datax2);
	$histo_male->value->SetFormat('%d');
	$histo_male->SetFillGradient('#AFE0EC', '#AFE0EC', GRAD_LEFT_REFLECTION);
	$histo_male->SetLegend('Femelles vivantes');
	// Changer la taille//  $histo_male->SetWidth(valeur);
	$histo_male->SetWeight(0);
	
	
	////Second histo////
	
	$histo_fem = new BarPlot($datax1);
	$histo_fem->SetLegend('Femelles mortes');
	$histo_fem->value->Show();
	$histo_fem->SetFillGradient('#3F67DC', '#3F67DC', GRAD_LEFT_REFLECTION);
	$histo_fem->value->SetFormat('%d');
	$histo_fem->SetWeight(0);

	
	// Créer l'ensemble d'histogrammes accumulés
	$gbplot = new AccBarPlot(array( $histo_fem, $histo_male));
	
	// Afficher les valeurs de chaque histogramme groupé
	$gbplot->value->Show();
	$gbplot->value->SetFont(FF_COMIC,FS_NORMAL,8);
	$gbplot->value->SetFormat('%d');


// Position de la légende
$graph->legend->Pos(0.20,0.12,"left","top");
$graph->SetYScale(0,'lin', 0,0);

// Ajouter l'ensemble accumulé
$graph->Add($gbplot);
	

// Envoyer au navigateur
$graph->Stroke();
$graph->Stroke("Graphique.jpg");
?>