<?php

require_once ('./jpgraph-4.2.6/src/jpgraph.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_bar.php');
require_once ('./jpgraph-4.2.6/src/jpgraph_line.php');

$donnees = array(12,23,9,58,23,26,57,48,12);

$largeur = 500;
$hauteur = 450;

// Initialisation du graphique
$graphe = new Graph($largeur, $hauteur);
$graphe->img->SetAntiAliasing(false);
// Echelle lineaire ('lin') en ordonnee et pas de valeur en abscisse ('text')
// Valeurs min et max seront determinees automatiquement
$graphe->setScale("textlin");

// Creation de la courbe
$courbe = new LinePlot($donnees);

// $courbe->mark->SetType(MARK_SQUARE);
// $courbe->mark->SetColor('blue');
// $courbe->mark->SetSize(6);
// Ajout de la courbe au graphique
$graphe->add($courbe);
$courbe->SetColor("#FF00FF");
// Ajout du titre du graphique
$graphe->title->set("Courbe");

// Affichage du graphique
$graphe->stroke();
?>