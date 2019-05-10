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
$annee1=2010;
$annee2=2013;
// $annee1=$_GET["annee1"];
// $annee2=$_GET["annee2"];

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

//Requête pour récupérer le nombre de béarnaise
$j=0;
for($i=$annee1;$i<=$annee2;$i++)
{
	//Requête pour récupérer l'effectifs de béarnaise
	$query= "SELECT nb_race(19,".$i.")";
	$result = mysqli_query ($link, $query);
	$tab = mysqli_fetch_all ($result);
	$datay1[$j] = $tab[0][0];

	$j=$j+1;
}

//Requête pour récupérer le nombre de bordelaise
$j=0;
for($i=$annee1;$i<=$annee2;$i++)
{
	//Requête pour récupérer l'effectifs de bordelaise
	$query= "SELECT nb_race(5,".$i.")";
	$result = mysqli_query ($link, $query);
	$tab = mysqli_fetch_all ($result);
	$datay2[$j] = $tab[0][0];

	$j=$j+1;
}

//Requête pour récupérer le nombre de marine
$j=0;
for($i=$annee1;$i<=$annee2;$i++)
{
	//Requête pour récupérer l'effectifs de marine
	$query= "SELECT nb_race(6,".$i.")";
	$result = mysqli_query ($link, $query);
	$tab = mysqli_fetch_all ($result);
	$datay3[$j] = $tab[0][0];

	$j=$j+1;
}

$listVal=array($datay1,$datay2,$datay3);

$counter=count($datay1);
$somme=array(0,0,0);

for($i=0;$i<$counter;$i++)
{
	$somme[$i]=$datay1[$i]+$datay2[$i]+$datay3[$i];
	
}


// **********************
// Création du graphique 
// **********************

	// Création du graphique conteneur
	$graph = new Graph(640,480,'auto');    
	$graph->SetScale('textlin', 0,maximum($somme));
	$graph->img->SetMargin(60,80,30,80);


	// Ajouter un onglet
	$graph->tabtitle->Set("Effectif du nombre de bovins par race");
	$graph->tabtitle->SetFont(FF_ARIAL,FS_BOLD,14);
	$graph->tabtitle->SetColor("black");
	$graph->tabtitle->SetFillColor("white");

	// Pimper les axes
	$graph->xaxis->setTickLabels($années);
	$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->xaxis->title->SetColor('black');
	$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
	$graph->xaxis->SetColor('black');

	$graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
	$graph->yaxis->SetColor('black');
	$graph->ygrid->SetColor('black@0.5');

	// Couleurs et transparence par histogramme A AUTOMATISER
	$aColor=array('#BCD0F0','#5F84BF','#14438F');
	$bNoms=array('Béarnaise','Bordelaise','Marine');
	
	$bplota = new BarPlot($listVal[0]);
	$bplot->SetFillColor($aColor[0]);
	
	$bplotb = new BarPlot($listVal[1]);
	$bplot->SetFillColor($aColor[1]);
	
	$bplotc = new BarPlot($listVal[2]);
	$bplot->SetFillColor($aColor[2]);
	
	
	

$i=0;
	// Chaque  histogramme est un élément du tableau:
	
	
	$aGroupBarPlot = array();

	foreach ($listVal as $key => $value) {
		$bplot = new BarPlot($listVal[$key]);
		$bplot->SetFillColor($aColor[$i]);
		$bplot->SetLegend($bNoms[$i]);
		$aGroupBarPlot[] = $bplot; 
		$i=$i+1;
	}

// ***********************
// Graphique courbe
// ***********************
	
	$courbe = new LinePlot($somme);
	
	// Echelle des Y que si je met pas ça ne fonctionne pas
	$graph->SetYScale(0,'lin', 0,maximum($somme));

	// $graph->xaxis->title->Set("Années");
	$graph->yaxis->title->Set("Nombre d'individus");
	$graph->yaxis->title->SetMargin(15);


	// Ajouter un axe Y supplémentaire
	$graph->AddY(0,$courbe);

	// Couleur de l'axe Y supplémentaire
	$graph->ynaxis[0]->SetColor('#2DA81C');
	$graph->ynaxis[0]->title->Set("Nombre total de bovins");
	$graph->ynaxis[0]->title->SetColor('#2DA81C');
	$graph->ynaxis[0]->title->SetMargin(20);
	
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
	
// Création de l'objet qui regroupe nos histogrammes
$gbarplot = new GroupBarPlot($aGroupBarPlot);
$gbarplot->SetWidth(0.8);

// Ajouter au graphique
$graph->Add($gbarplot);

// Afficher
$graph->legend->Pos(0.32,0.90);
$graph->Stroke();
?>