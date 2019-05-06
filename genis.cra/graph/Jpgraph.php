<?php
//Exemple


require_once ('./jpgraph-4.2.6/src/jpgraph.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_bar.php');

//Les datas pour l'exemple
$datay=array(0.13,0.25,0.21,.35,0.31,0.06);
$datax=array("jan","fev","mar","apr","may","june");

/*
$datax=$_GET("-_Insérer votre donnée en abscisse_-");
$datay=$_GET("-_Insérer votre donnée en ordonnée_-");
*/

//Setup
$graph= new Graph(400,200,"auto");

$graph->img->SetMargin(60,20,30,50);
$graph->SetScale("textlin");
$graph->SetMarginColor("lightblue");
$graph->SetShadow();

//Titres
$graph->title->set("Bar gradient(Left reflection)");
$graph->title->SetColor("darkred");

$graph->yscale->ticks->SupressZeroLabel(false);

//Axes
$graph->xaxis->setTickLabels($datax);
$graph->xaxis->setLabelAngle(50);

//Creation du barplot
$bplot= new BarPlot($datay);
$bplot->SetWidth(0.6);

//Coloration
$bplot->SetFillGradient("navy","#EEEEEE", GRAD_LEFT_REFLECTION);

//Color des barres
$bplot->SetColor("green");
$graph->add($bplot);

//Envoie du graphe
$graph->Stroke();

?>
