<?php
//Exemple


require_once ('./jpgraph-4.2.6/src/jpgraph.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_bar.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_line.php');

//Les datas pour l'exemple
$NbEleveurs=array(10,20,30,40,50,60);
$femDead=array(30,25,20,15,10,5);
$femViv=array(80,70,60,50,40,30);
$années=array("2014","2015","2016","2017","2018","2019");

/*
$datax=$_GET("-_Insérer votre donnée en abscisse_-");
$datay=$_GET("-_Insérer votre donnée en ordonnée_-");
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
	//Premier histo
	$histo_femViv = new barPlot($femViv);
	$histo_femViv->SetLegend('Femelles vivantes');
	$histo_femViv->value->SetFormat('%d');
	$histo_femViv->value->SetColor('blue');
	$histo_femViv->SetWidth(0.20);
	// Bordure autour de chaque histogramme
	$histo_femViv->SetWeight(0);
	
	
	//Second histo
	$histo_femDead = new BarPlot($femDead);
	$histo_femDead->SetLegend('Femelles mortes');
	$histo_femDead->value->Show();
	//$histo_femDead->value->SetFont(FF_ARIAL, FS_NORMAL,7);
	$histo_femDead->value->SetColor('blue');
	$histo_femDead->value->SetFormat('%d');
	
	$histo_femDead->SetWeight(0);

	// Pour chaque barre
	$histo_femViv->SetFillGradient('#1D8FEF', '#1D84EF', GRAD_LEFT_REFLECTION);
	$histo_femDead->SetFillGradient('#20D7DA', '#1DD3EF', GRAD_LEFT_REFLECTION);
	
	// Créer l'ensemble d'histogrammes accumulés
	$gbplot = new AccBarPlot(array($histo_femViv, $histo_femDead));
	
	// Afficher les valeurs de chaque histogramme groupé
	$gbplot->value->Show();
	$gbplot->value->SetFont(FF_COMIC,FS_NORMAL,8);
	$gbplot->value->SetFormat('%d');

	// Position de la légende
	$graph->legend->Pos(0.80,0.12,"left","top");
	
	// Ajouter l'ensemble accumulé
	$graph->Add($gbplot);
	

// ***********************
// Graphique courbe
// ***********************
	
	$courbe = new LinePlot($NbEleveurs);
	
	// Echelle des Y que si je met pas ça ne fonctionne pas
	$graph->SetYScale(0,'lin', 0,0);

	// $graph->xaxis->title->Set("Années");
	$graph->yaxis->title->Set("Nombre de femelle");

	// Ajouter un axe Y supplémentaire
	$graph->AddY(0,$courbe);

	// Couleur de l'axe Y supplémentaire
	$graph->ynaxis[0]->SetColor('lightgreen');
	$graph->ynaxis[0]->title->Set("Nombre d'éleveurs");
	
	// Apparence des points
	$courbe->mark->SetType(MARK_SQUARE);
	$courbe->mark->SetColor('green');
	$courbe->mark->SetSize(6);
	$courbe->mark->SetFillColor("green");
	$courbe->mark->SetWidth(6);
	$courbe->SetColor("blue");
	$courbe->SetCenter();
	$courbe->SetWeight(6);

	// Affichage des valeurs
	$courbe->SetBarCenter();
	$courbe->value->SetFormat('%d');
	// Envoyer au navigateur
	$graph->Stroke();
	$graph->Stroke("Graphique.jpg");
?>