<?php

session_start();

//Exemple
require_once ('./jpgraph-4.2.6/src/jpgraph.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_bar.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_line.php');

//Les datas pour l'exemple

$datay3=array(260,255,301,230,250,222);
$i=0;
$années=array("2014","2015","2016","2017","2018","2019");

/*
$datay1=$_GET["-_Insérer les vaches nées et conservées en ordonnée issu des requêtes_-"];
$datay2=$_GET["-_Insérer les éleveurs issu des requêtes_-"];
$datay3=$_GET["-_Insérer le nombre total de vache en ordonnée issu des requêtes_-"];
$années=$_GET["-_Insérer les années_-"];
*/

$stock=0;
while($i<6)
{
	if ($datay3[$i]>$stock)
		$stock=$datay3[$i];
	$i=$i+1;
}

// *********************
// Création du graphique
// *********************

$graph = new Graph(640,480);    
$graph->SetScale('textlin', 0, $stock);

$graph->SetMargin(50,65,50,40);

// Désactiver le cadre autour du graphique
$graph->SetFrame(false);
$graph->SetShadow(5);

// Ajouter un onglet
$graph->tabtitle->Set("Effectif des Bovins");
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
$graph->xaxis->setTickLabels($années);
$graph->xaxis->setLabelAngle(50);

// *******************************
// Créer un histogramme
// *******************************
	////Premier histo////
	
	$histo_femTot = new barPlot($datay3);
	$histo_femTot->value->SetFormat('%d');
	$histo_femTot->SetLegend("Blonde d'Aquitaine");
	// Changer la taille//  $histo_femTot->SetWidth(valeur);
	$histo_femTot->SetWeight(0);
	
	// Ajouter l'ensemble accumulé
	$graph->Add($histo_femTot);

	$histo_femTot->SetFillColor('#A5E4F2');
// ***********************
// Graphique courbe
// ***********************
	
	$courbe = new LinePlot($datay3);
	
	// Echelle des Y que si je met pas ça ne fonctionne pas
	$graph->SetYScale(0,'lin', 0, $stock);

	// $graph->xaxis->title->Set("Années");
	$graph->yaxis->title->Set("Nombre d'individus bovins");

	// Ajouter un axe Y supplémentaire
	$graph->AddY(0,$courbe);

	// Couleur de l'axe Y supplémentaire
	$graph->ynaxis[0]->SetColor('lightgreen');
	$graph->ynaxis[0]->title->Set("Nombre total des bovins");
	
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
$graph->Stroke("EvoEffBovins.jpg");

?>