<?php

session_start();

// On va chercher les biblios de jpgraph pour construire les graphiques
require_once ('./jpgraph-4.2.6/src/jpgraph.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_bar.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_line.php');


function maximum($liste) //Pour liste unique
{
	$stock=0;
	$counter=3;
	for($i=0;$i<$counter;$i++)
	{
		if (max($liste)>$stock)
			$stock=max($liste);
		
	}
	return $stock;
}



//Les datas pour l'exemple

// $datay1=array(30,25,20);
// $datay2=array(10,20,30);
// $datay3=array(80,70,60);
// $annees=array("2014","2015","2016");


//Récupération des données
$nb_femelle=$_GET["nb_femelle"];
$nb_detenteur=$_GET["nb_detenteur"];
$nb_femelle_nee=$_GET["nb_femelle_nee"];
$annee=$_GET["annee"];

// *********************
// Création du graphique
// *********************

$graph = new Graph(640,480);    
$graph->SetScale("textlin");

//Taille du graphique
$graph->SetMargin(50,65,50,40);

// Désactiver le cadre autour du graphique (assez inutile)
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
	
	$histo_femTot = new barPlot($nb_femelle);
	$histo_femTot->value->SetFormat('%d');
	$histo_femTot->SetLegend('Femelles totales');
	// Changer la taille//  $histo_femTot->SetWidth(valeur);
	$histo_femTot->SetWeight(0);
	
	
	////Second histo////
	
	$histo_femBornCons = new BarPlot($nb_femelle_nee);
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

	// Ajouter l'ensemble accumulé
	$graph->Add($gbplot);

	$histo_femBornCons->SetFillColor('#6078E5');
	$histo_femTot->SetFillColor('#A5E4F2');
	
// ***********************
// Graphique courbe
// ***********************
	
	$courbe = new LinePlot($nb_detenteur);
	
	// Echelle des Y que si je met pas ça ne fonctionne pas
	$graph->SetYScale(0,'lin', 0,maximum($datay2));

	// $graph->xaxis->title->Set("annees");
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