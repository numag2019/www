<?php
//Exemple


require_once ('./jpgraph-4.2.6/src/jpgraph.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_bar.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_line.php');

//Les datas pour l'exemple
$NbEleveurs=array(1,2,3,3,2,1);
$femDead=array(30,25,20,15,10,5);
$femViv=array(1,2,3,4,5,6);
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
	
	// Bordure autour de chaque histogramme
	$histo_femViv->SetWeight(0);
	
	//Second histo
	$histo_femDead = new BarPlot($NbEleveurs);
	$histo_femDead->SetLegend('Femelles mortes');
	$histo_femDead->value->Show();
	//$histo_femDead->value->SetFont(FF_ARIAL, FS_NORMAL,7);
	$histo_femDead->value->SetColor('blue');
	$histo_femDead->value->SetFormat('%d');
	

	// Pour chaque barre
	$histo_femViv->SetFillGradient('#440000', '#FF0000', GRAD_LEFT_REFLECTION);
	$histo_femDead->SetFillGradient('#440000', '#FF0000', GRAD_LEFT_REFLECTION);
	
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
	
	// Ajouter au graphique
	$graph->Add($histo_femViv);

// ***********************
// Graphique courbe
// ***********************

	$oCourbe = new LinePlot($NbEleveurs);
	$oCourbe->value->Show();
	$oCourbe->SetBarCenter();

	// Apparence des points
	$oCourbe->mark->SetType(MARK_FILLEDCIRCLE);
	$oCourbe->mark->SetFillColor("blue");
	$oCourbe->mark->SetWidth(5);
	$oCourbe->SetColor("blue");
	$oCourbe->SetCenter();
	$oCourbe->SetWeight(0);
	
	// Affichage des valeurs
	
	$oCourbe->value->SetFormat('%d');

// Echelle des Y que si je met pas ça ne fonctionne pas
$graph->SetYScale(0,'lin', 0,0);

$graph->xaxis->title->Set("Années");
$graph->yaxis->title->Set("Nombre de femelle");

// Ajouter un axe Y supplémentaire
$graph->AddY(0,$oCourbe);
// Couleur de l'axe Y supplémentaire
$graph->ynaxis[0]->SetColor('blue');
$graph->ynaxis[0]->title->Set("Nombre d'éleveurs");

// Envoyer au navigateur
$graph->Stroke();
?>