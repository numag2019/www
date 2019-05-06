<?php
//Exemple
require_once ('./jpgraph-4.2.6/src/jpgraph.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_bar.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_line.php');


//Les datas pour l'exemple
$femViv=array(10,15,20,25,30,35);
$femDead=array(30,25,20,15,10,5);
$forEx=array(1,1,1,1,1,1);
$années=array("2014","2015","2016","2017","2018","2019");

/*
$datax=$_GET("-_Insérer votre donnée en abscisse_-");
$datay=$_GET("-_Insérer votre donnée en ordonnée_-");
*/

//Setup du graphique
$graph = new Graph(640,480,"auto");    
$graph->SetScale("textlin");
$graph->SetShadow();
$graph->img->SetMargin(60,40,50,40);
$graph->SetMarginColor('#CCCCFF');
$graph->title->Set("Répartition du chiffre d'affaires 2006 par type de vente");
$graph->title->SetMargin(20);
$graph->title->SetFont(FF_COMIC,FS_BOLD,12);

//Ensembles des histogrammes
$histo_femViv = new BarPlot($femViv);
$histo_femViv->SetFillGradient('blue', '#9090FF', GRAD_VER);
$histo_femViv->SetLegend('Femelles vivantes');
$histo_femViv->value->Show();
$histo_femViv->value->SetFont(FF_ARIAL, FS_NORMAL,7);
$histo_femViv->value->SetColor('black');
$histo_femViv->value->SetFormat('%d');


$histo_femDead = new BarPlot($femDead);
$histo_femDead->SetFillGradient('red', '#FF9090', GRAD_VER);
$histo_femDead->SetLegend('Femelles mortes');
$histo_femDead->value->Show();
$histo_femDead->value->SetFont(FF_ARIAL, FS_NORMAL,7);
$histo_femDead->value->SetColor('black');
$histo_femDead->value->SetFormat('%d');


// Créer l'ensemble d'histogrammes accumulés
$gbplot = new AccBarPlot(array($histo_femViv, $histo_femDead));

// Afficher les valeurs de chaque histogramme groupé
$gbplot->value->Show();
$gbplot->value->SetFont(FF_COMIC,FS_NORMAL,8);
$gbplot->value->SetFormat('%d');

// Position de la légende
$graph->legend->Pos(0.12,0.12,"left","top");

// Ajouter l'ensemble accumulé
$graph->Add($gbplot);

// Paramétrer les axes X et Y
$graph->yaxis->title->Set("Effectif");
$graph->yaxis->title->SetMargin(20);
$graph->yaxis->title->SetFont(FF_COMIC,FS_BOLD);

$graph->xaxis->title->Set("Année");
$graph->xaxis->SetTickLabels($années);
$graph->xaxis->title->SetMargin(4);
$graph->xaxis->title->SetFont(FF_COMIC,FS_BOLD);

// ***********************
// Graphique courbe rempli
// ***********************

$oCourbe = new LinePlot($forEx);

// Couleur de remplissage avec transparence
$oCourbe->SetFillColor('skyblue@0.5');

// Couleur de la courbe
$oCourbe->SetColor('navy@0.7');
$oCourbe->SetBarCenter();

// Apparence des points
$oCourbe->mark->SetType(MARK_SQUARE);
$oCourbe->mark->SetColor('blue@0.5');
$oCourbe->mark->SetFillColor('lightblue');
$oCourbe->mark->SetSize(6);

// Affichage des valeurs
$oCourbe->value->Show();
$oCourbe->value->SetFormat('%d');

$graph->xaxis->title->Set("Mois 2006");
$graph->yaxis->title->Set("Chiffre d'affaire");

// Ajouter un axe Y supplémentaire
$graph->AddY(0,$oCourbe);

// Couleur de l'axe Y supplémentaire
$graph->ynaxis[0]->SetColor('red');
$graph->ynaxis[0]->title->Set("Nombre de ventes");

// Afficher l'image générée
$graph->Stroke();

?>
