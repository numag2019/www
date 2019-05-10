<?php

session_start();

// On va chercher les biblios de jpgraph pour construire les graphiques
require_once ('./jpgraph-4.2.6/src/jpgraph.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_bar.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_line.php');

//Page crée par les NumAg 2019
//Cette page permet l'affichage de l'histogramme d'évolution de la population de bovins

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

// ******************************************************
// Récupération des données de la page race_globale_a.php
// ******************************************************

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

//Requête pour récupérer les effectifs de béarnaise pour chaque année dans une liste
$j=0;
for($i=$annee1;$i<=$annee2;$i++)
{
	$query= "SELECT nb_race(19,".$i.")"; //Le code race des béarnaise dans GENIS est 19
	$result = mysqli_query ($link, $query);
	$tab = mysqli_fetch_all ($result);
	$datay1[$j] = $tab[0][0];
	$j=$j+1;
}

//Requête pour récupérer les effectifs de bordelaises pour chaque année dans une liste
$j=0;
for($i=$annee1;$i<=$annee2;$i++)
{
	$query= "SELECT nb_race(5,".$i.")";//Le code race des béarnaise dans GENIS est 5
	$result = mysqli_query ($link, $query);
	$tab = mysqli_fetch_all ($result);
	$datay2[$j] = $tab[0][0];

	$j=$j+1;
}

//Requête pour récupérer les effectifs de marines pour chaque année dans une liste
$j=0;
for($i=$annee1;$i<=$annee2;$i++)
{
	$query= "SELECT nb_race(6,".$i.")";//Le code race des marines dans GENIS est 6
	$result = mysqli_query ($link, $query);
	$tab = mysqli_fetch_all ($result);
	$datay3[$j] = $tab[0][0];

	$j=$j+1;
}

//Regroupement des listes d'effectifs pour chaque race
$listVal=array($datay1,$datay2,$datay3);

$counter=count($datay1);

for($i=0;$i<$counter;$i++)
{
	$somme[$i]=$datay1[$i]+$datay2[$i]+$datay3[$i];	
}


// **********************
// Création du graphique 
// **********************

// Création du graphique conteneur
$graph = new Graph(640,480,'auto');

//Type d'échelle
$graph->SetScale('textlin', 0,(maximum($somme)+100));

//Fixer les marges
$graph->img->SetMargin(80,120,30,100);

// Ajouter un onglet
$graph->tabtitle->Set("Effectif du nombre de bovins par race");
$graph->tabtitle->SetFont(FF_ARIAL,FS_BOLD,14);
$graph->tabtitle->SetColor("black");
$graph->tabtitle->SetFillColor("white");

// Axe X
$graph->xaxis->setTickLabels($années);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetColor('black');
$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetColor('black');

//Axe Y
$graph->yaxis->SetFont(FF_FONT1);
$graph->yaxis->SetColor('black');

// Liste des noms par histogramme
$bNoms=array('Béarnaise','Bordelaise','Marine');

$i=0;
// Chaque  histogramme est un élément du tableau:
$aGroupBarPlot = array();

foreach ($listVal as $key => $value) {
	$bplot = new BarPlot($listVal[$key]);
	$bplot->SetLegend($bNoms[$i++]);
	$aGroupBarPlot[] = $bplot; 
}

// ***********************
// Graphique courbe
// ***********************
	
$courbe = new LinePlot($somme);

// Echelle des Y
$graph->SetYScale(0,'lin', 0,(maximum($somme)+150));
$graph->yaxis->title->Set("Nombre d'individus");
$graph->yaxis->title->SetMargin(20);

// Ajouter un axe Y supplémentaire
$graph->AddY(0,$courbe);

// Couleur de l'axe Y supplémentaire
$graph->ynaxis[0]->SetColor('black');
$graph->ynaxis[0]->SetFont(FF_FONT1);

// Apparence des points
$courbe->mark->SetType(MARK_SQUARE);
$courbe->mark->SetColor('black');
$courbe->mark->SetSize(6);
$courbe->mark->SetFillColor("black");
$courbe->mark->SetWidth(6);
$courbe->SetColor("black");
$courbe->SetCenter();
$courbe->SetWeight(6);
$courbe->SetLegend("Nombre total de bovins");

// Affichage des valeurs
$courbe->SetBarCenter();
$courbe->value->SetFormat('%d');

// ***********************
// Affichage
// ***********************
	
// Création de l'objet qui regroupe nos histogrammes
$gbarplot = new GroupBarPlot($aGroupBarPlot);
$gbarplot->SetWidth(0.8);

// Ajouter au graphique
$graph->Add($gbarplot);

//Positionner la légende
$graph->legend->Pos(0.25,0.85);

// Afficher et enregistrer l'image du graphique
$graph->Stroke();
$graph->Stroke("EvoEffBovins.png");
?>