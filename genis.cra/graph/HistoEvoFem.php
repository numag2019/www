<?php

session_start();

// On va chercher les biblios de jpgraph pour construire les graphiques
require_once ('./jpgraph-4.2.6/src/jpgraph.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_bar.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_line.php');
require_once '../libraries/constants.php';

//Page crée par les NumAg 2019
//Cette page permet l'affichage de l'histogramme d'évolution des effectifs de femelles et de détenteurs pour une race donnée

// *************************
// Fonctions
// *************************
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

// **********************************************
// Récupération des données de la page race_a.php
// **********************************************

$annee1=$_GET["annee1"];
$annee2=$_GET["annee2"];
$code_race=$_GET["code_race"];

//Liste des années
$j=0;
for($i=$annee1;$i<=$annee2;$i++)
{
	$annees[$j]=$i;
	$j=$j+1;
}

//Connection au serveur
$link = mysqli_connect('127.0.0.1','root','','genis_test');
mysqli_set_charset ($link, "utf8mb4");

//Requête pour récupérer les effectifs de femelles pour chaque année dans une liste
$j=0;
for($i=$annee1;$i<=$annee2;$i++)
{
	$query= "SELECT nb_femelle(".$i.",".$code_race.")";
	$result = mysqli_query ($link, $query);
	$tab = mysqli_fetch_all ($result);
	$datay3[$j] = $tab[0][0];
	$j=$j+1;
}

//Requête pour récupérer les effectifs de femelles nées dans l'année pour chaque année dans une liste
$j=0;
for($i=$annee1;$i<=$annee2;$i++)
{
	$query= "SELECT nb_femelle_nee(".$i.",".$code_race.")";
	$result = mysqli_query ($link, $query);
	$tab = mysqli_fetch_all ($result);
	$datay1[$j] = $tab[0][0];

	$j=$j+1;
}

//Requête pour récupérer les effectifs de détenteurs pour chaque année dans une liste
$j=0;
for($i=$annee1;$i<=$annee2;$i++)
{
	$query= "SELECT nb_detenteur(".$i.",".$code_race.")";
	$result = mysqli_query ($link, $query);
	$tab = mysqli_fetch_all ($result);
	$datay2[$j] = $tab[0][0];

	$j=$j+1;
}

// *********************
// Création du graphique
// *********************

// Création du graphique conteneur
$graph = new Graph(640,480);  

//Type d'échelle  
$graph->SetScale("textlin");

//Fixer les marges
$graph->SetMargin(65,65,50,80);

// Désactiver le cadre autour du graphique (assez inutile)
$graph->SetFrame(false);
$graph->SetShadow(5);

// Ajouter un onglet
$graph->tabtitle->Set("Effectif des femelles");
$graph->tabtitle->SetFont(FF_ARIAL,FS_BOLD,14);
$graph->tabtitle->SetColor("black");
$graph->tabtitle->SetFillColor("white");

// Apparence des grilles
$graph->xaxis->setTickLabels($annees);
$graph->xaxis->setLabelAngle(50);

// *******************************
// Créer les histogrammes
// *******************************

////Premier histo////

$histo_femTot = new barPlot($datay3);
$histo_femTot->value->SetFormat('%d');
$histo_femTot->SetLegend('Femelles totales');
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

// Ajouter l'ensemble accumulé
$graph->Add($gbplot);

$histo_femBornCons->SetFillColor('#6078E5');
$histo_femTot->SetFillColor('#A5E4F2');
	
// ***********************
// Graphique courbe
// ***********************
	
$courbe = new LinePlot($datay2);

// Echelle des Y 
$graph->SetYScale(0,'lin', 0,(maximum($datay2)+1));

// $graph->xaxis->title->Set("annees");
$graph->yaxis->title->Set("Nombre de femelle");
$graph->yaxis->title->SetMargin(13);
$graph->yaxis->scale->SetGrace(8);

// Ajouter un axe Y supplémentaire
$graph->AddY(0,$courbe);

// Couleur de l'axe Y supplémentaire
$graph->ynaxis[0]->SetColor('#2DA81C');
$graph->ynaxis[0]->title->Set("Nombre de détenteurs");
$graph->ynaxis[0]->title->SetMargin(13);

// Apparence des points
$courbe->mark->SetType(MARK_SQUARE);
$courbe->mark->SetColor('#2DA81C');
$courbe->mark->SetSize(6);
$courbe->mark->SetFillColor("#2DA81C");
$courbe->mark->SetWidth(6);
$courbe->SetColor("#2DA81C");
$courbe->SetCenter();
$courbe->SetWeight(6);

// Affichage des valeurs
$courbe->SetBarCenter();
$courbe->value->SetFormat('%d');

// ***********************
// Affichage
// ***********************

//Positionner la légende
$graph->legend->Pos(0.25,0.94);

// Envoyer au navigateur et enregistrer l'image du graphique
$graph->Stroke();
$graph->Stroke("EvoNbFem.png");
?>