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

// $color='#7AC6EF';

/* Cas où plusieurs listes sortent les effectifs de chaque race 
pour un même groupe de bêtes (bovin, équin,ovins)
$datay1=$_GET["-_Insérer les vaches nées et conservées en ordonnée issu des requêtes_-"];
$datay2=$_GET["-_Insérer les éleveurs issu des requêtes_-"];
$datay3=$_GET["-_Insérer le nombre total de vache en ordonnée issu des requêtes_-"];
$années=$_GET["-_Insérer les années_-"];
*/

/* Cas où la sortie est une liste contenant les listes des effectifs de chaque race
d'un même groupe de bêtes (bovin, équin, ovins)
$listeVal=$_GET["-_Insérer la grosse liste contenant les listes_-"];
*/

//Les datas pour l'exemple, a mettre en commentaire pour la mise en commun
$datay1=array(20,25,20,50,68,90,25);
$datay2=array(10,20,15,25,69,86,58);
 
$années=array("2014","2015","2016","2017","2018","2019","2023");
$listVal=array($datay1,$datay2);


$counter=count($datay1);
$somme=array();

for($i=0;$i<$counter;$i++)
{
	$somme[$i]=$datay1[$i]+$datay2[$i];
	
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


	$graph->title->Set("Effectif du nombre d'ovins par race");
	$graph->title->SetMargin(6);
	$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);

// Couleurs (qui ne marchent pas) et les noms (qui marchent)
$aColors=array('pink','gray','blue', 'blue@0.3','green@0.8');
$bNoms=array('Sasi Aria','Landais');

$j=0;
	// Chaque  histogramme est un élément du tableau:
	$aGroupBarPlot = array();

	foreach ($listVal as $key => $value) {
		$bplot = new BarPlot($listVal[$key]);
		$bplot->SetLegend($bNoms[$j++]);
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
	$graph->ynaxis[0]->SetColor('#3A5ED9');
	$graph->ynaxis[0]->title->Set("Nombre total d'ovins");
	
	// Apparence des points
	$courbe->mark->SetType(MARK_SQUARE);
	$courbe->mark->SetColor('black');
	$courbe->mark->SetSize(6);
	$courbe->mark->SetFillColor('#3A5ED9');
	$courbe->mark->SetWidth(6);
	$courbe->SetColor('#7AC6EF');
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