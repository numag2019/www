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

//Récupération des données
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

//Requête pour récupérer le nombre de poneys landais
$j=0;
for($i=$annee1;$i<=$annee2;$i++)
{
	//Requête pour récupérer l'effectifs de poneys landais
	$query= "SELECT nb_race(2,".$i.")";
	$result = mysqli_query ($link, $query);
	$tab = mysqli_fetch_all ($result);
	$datay1[$j] = $tab[0][0];

	$j=$j+1;
}

$listVal=array($datay1);

$counter=count($datay1);
$somme=array();

for($i=0;$i<$counter;$i++)
{
	$somme[$i]=$datay1[$i];
	
}


// **********************
// Création du graphique 
// **********************

	// Création du graphique conteneur
	$graph = new Graph(640,480,'auto');    
	$graph->SetScale('textlin', 0,maximum($somme));
	$graph->img->SetMargin(60,80,30,40);
	$graph->legend->Pos(0.02,0.05);

	// Couleur de l'ombre et du fond de la légende
	$graph->legend->SetShadow('darkgray@0.5');
	$graph->legend->SetFillColor('lightblue@0.3');

	// Pimper les axes
	$graph->xaxis->setTickLabels($années);
	$graph->xaxis->title->Set('Annees');
	$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->xaxis->title->SetColor('black');
	$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
	$graph->xaxis->SetColor('black');

	$graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
	$graph->yaxis->SetColor('black');
	$graph->ygrid->SetColor('black@0.5');


	$graph->title->Set("Effectif du nombre d'équins par race");
	$graph->title->SetMargin(6);
	$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);

// Liste des noms
$bNoms=array('Poney Landais');

$i=0;
	// Chaque  histogramme est un élément du tableau:
	$aGroupBarPlot = array();

	foreach ($listVal as $key => $value) {
		$bplot = new BarPlot($listVal[$key]);
		$bplot->SetLegend($bNoms[$i++]);
		$bplot->SetShadow('black@0.4');
		$aGroupBarPlot[] = $bplot; 
		
	}

// ***********************
// Graphique courbe
// ***********************
	
	$courbe = new LinePlot($somme);
	
	// Echelle des Y que si je met pas ça ne fonctionne pas
	$graph->SetYScale(0,'lin', 0,maximum($somme));

	// $graph->xaxis->title->Set("Années");
	$graph->yaxis->title->Set("Nombre d'individus");

	// Ajouter un axe Y supplémentaire
	$graph->AddY(0,$courbe);

	// Couleur de l'axe Y supplémentaire
	$graph->ynaxis[0]->SetColor('blue');
	$graph->ynaxis[0]->title->Set("Nombre total d'individus équins");
	
	// Apparence des points
	$courbe->mark->SetType(MARK_SQUARE);
	$courbe->mark->SetColor('black');
	$courbe->mark->SetSize(6);
	$courbe->mark->SetFillColor("blue");
	$courbe->mark->SetWidth(6);
	$courbe->SetColor("blue");
	$courbe->SetCenter();
	$courbe->SetWeight(6);

	// Affichage des valeurs
	$courbe->SetBarCenter();
	$courbe->value->SetFormat('%d');
	
// Création de l'objet qui regroupe nos histogrammes
$gbarplot = new GroupBarPlot($aGroupBarPlot);
$gbarplot->SetWidth(0.8);

// Ajouter au graphique
$graph->Add($gbarplot);

// Afficher
$graph->Stroke();
?>