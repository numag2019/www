<?php

session_start();

//Exemple
require_once ('./jpgraph-4.2.6/src/jpgraph.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_bar.php');


//Récupération des données
$code_race=$_GET["code_race"];
$annee1=$_GET["annee1"];
$annee2=$_GET["annee2"];

//Liste des années
$j=0;
for($i=$annee1;$i<=$annee2;$i++)
{
	$années[$j]=$i;
	$j=$j+1;
}

//Connection au serveur
$link = mysqli_connect('127.0.0.1','root','','genis_test');
mysqli_set_charset ($link, "utf8mb4");

//Requête pour récupérer les nombre de femelles
$j=0;
for($i=$annee1;$i<=$annee2;$i++)
{
	//Requête pour récupérer les effectifs de femelles
	$query= "SELECT nb_veau_m(".$i.",".$code_race.")";
	$result = mysqli_query ($link, $query);
	$tab = mysqli_fetch_all ($result);
	$datax1[$j] = $tab[0][0];

	$j=$j+1;
}

//Requête pour récupérer les nombre de femelles nees
$j=0;
for($i=$annee1;$i<=$annee2;$i++)
{
	//Requête pour récupérer les effectifs de femelles
	$query= "SELECT nb_veau_f(".$i.",".$code_race.")";
	$result = mysqli_query ($link, $query);
	$tab = mysqli_fetch_all ($result);
	$datax2[$j] = $tab[0][0];

	$j=$j+1;
}

// *********************
// Création du graphique
// *********************

$graph = new Graph(640,480);    
$graph->SetScale("textlin");

$graph->SetMargin(50,65,50,80);

// Désactiver le cadre autour du graphique
$graph->SetFrame(false);

// Ajouter un onglet
$graph->tabtitle->Set("Evolution des naissances");
$graph->tabtitle->SetFont(FF_ARIAL,FS_BOLD,14);
$graph->tabtitle->SetColor("black");
$graph->tabtitle->SetFillColor("#E9EBF3");

// Apparence des grilles
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
$graph->yaxis->title->SetMargin(13);
$graph->yaxis->scale->SetGrace(8);

// Position de la légende
$graph->legend->Pos(0.35,0.94);

// Ajouter l'ensemble accumulé
$graph->Add($gbplot);
	$histo_fem->SetFillColor('#6078E5');
	$histo_male->SetFillColor('#A5E4F2');

// Envoyer au navigateur
$graph->Stroke();
$graph->Stroke("EvoNaissances.png");
?>