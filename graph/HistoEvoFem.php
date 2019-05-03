<?php

session_start();

//Exemple
require_once ('./jpgraph-4.2.6/src/jpgraph.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_bar.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_line.php');

//Les datas pour l'exemple
$effectif = $_SESSION["effectif"];
$annees = $_SESSION["annee"];

unset($annees[0]); //pour retirer la première valeur du tableau
$annees = array_values($annees);

$datay2 = $effectif[4];//nb d'eleveurs détenteurs
unset($datay2[0]); //pour retirer la première valeur du tableau
$datay2 = array_values($datay2);

$datay1 = $effectif[2];//femelles nées et conservées
unset($datay1[0]);
$datay1 = array_values($datay1);

$datay3 = $effectif[0];//femelles totales
unset($datay3[0]);
$datay3 = array_values($datay3);

//$annees=array("2014","2015","2016","2017","2018","2019"); //années

/*
$datay1=$_GET["-_Insérer les vaches nées et conservées en ordonnée issu des requêtes_-"];
$datay2=$_GET["-_Insérer les éleveurs issu des requêtes_-"];
$datay3=$_GET["-_Insérer le nombre total de vache en ordonnée issu des requêtes_-"];
$années=$_GET["-_Insérer les années_-"];
*/

// *********************
// Création du graphique
// *********************

$graph = new Graph(640,480);    
$graph->SetScale("textlin");

$graph->SetMargin(50,65,50,40);

// Désactiver le cadre autour du graphique
$graph->SetFrame(false);
$graph->SetShadow(5);

// Ajouter un onglet
$graph->tabtitle->Set("Effectif des femelles");
$graph->tabtitle->SetFont(FF_ARIAL,FS_BOLD,14);
$graph->tabtitle->SetColor("black");
$graph->tabtitle->SetFillColor("#E9EBF3");

// Apparence des grilles
$graph->ygrid->SetFill(true,'black','black');
$graph->ygrid->SetLineStyle('dashed');
$graph->ygrid->SetColor('gray');
$graph->xgrid->Show();
$graph->xgrid->SetLineStyle('dashed');
$graph->xgrid->SetColor('gray');
$graph->xaxis->setTickLabels($annees);
$graph->xaxis->setLabelAngle(50);

// *******************************
// Créer un histogramme
// *******************************
	////Premier histo////
	
	$histo_femTot = new barPlot($datay3);
	$histo_femTot->value->SetFormat('%d');
	$histo_femTot->SetLegend('Femelles totales');
	// Changer la taille//  $histo_femTot->SetWidth(valeur);
	$histo_femTot->SetWeight(0);
	
	
	////Second histo////
	
	$histo_femBornCons = new BarPlot($datay1);
	$histo_femBornCons->SetLegend('Femelles nées et conservées');
	$histo_femBornCons->value->Show();
	$histo_femBornCons->value->SetFormat('%d');
	$histo_femBornCons->SetWeight(0);

	
	// Créer l'ensemble d'histogrammes accumulés
	$gbplot = new AccBarPlot(array( $histo_femBornCons, $histo_femTot));
	
	// Afficher les valeurs de chaque histogramme groupé
	$gbplot->value->Show();
	$gbplot->value->SetFont(FF_COMIC,FS_NORMAL,8);
	$gbplot->value->SetFormat('%d');

	// Position de la légende
	$graph->legend->Pos(0.20,0.12,"left","top");
	
	// Ajouter l'ensemble accumulé
	$graph->Add($gbplot);

	$histo_femBornCons->SetFillColor('#6078E5');
	$histo_femTot->SetFillColor('#A5E4F2');
// ***********************
// Graphique courbe
// ***********************
	
	$courbe = new LinePlot($datay2);
	
	// Echelle des Y que si je met pas ça ne fonctionne pas
	$graph->SetYScale(0,'lin', 0,0);

	// $graph->xaxis->title->Set("Années");
	$graph->yaxis->title->Set("Nombre de femelle");

	// Ajouter un axe Y supplémentaire
	$graph->AddY(0,$courbe);

	// Couleur de l'axe Y supplémentaire
	$graph->ynaxis[0]->SetColor('lightgreen');
	$graph->ynaxis[0]->title->Set("Nombre de détenteurs");
	
	// Apparence des points
	$courbe->mark->SetType(MARK_SQUARE);
	$courbe->mark->SetColor('black');
	$courbe->mark->SetSize(6);
	$courbe->mark->SetFillColor("green");
	$courbe->mark->SetWidth(6);
	$courbe->SetColor("#23C336");
	$courbe->SetCenter();
	$courbe->SetWeight(6);

	// Affichage des valeurs
	$courbe->SetBarCenter();
	$courbe->value->SetFormat('%d');
	
// Envoyer au navigateur
$graph->SetShadow(5);
$graph->legend->Pos(0.10,0.05);
$graph->Stroke();
$graph->Stroke("EvoNbFem.png");
?>