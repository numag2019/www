<?php // content="text/plain; charset=utf-8"
// Connection au fichiers JpGraph,
require_once ('../../jpgraph-4.2.6/src/jpgraph.php');
require_once ('../../jpgraph-4.2.6/src/jpgraph_pie.php');

// Récupération des données
$id_dep = $_GET["id_dep"];
$nom_dep = $_GET["nom_dep"];
$nom_obs = $_GET["nom_obs"];
$prenom = $_GET["prenom"];
$id_obs = $_GET["id_obs"];

//Connection au serveur
$link = mysqli_connect ("localhost","root", "", "oiseaudb");
mysqli_set_charset ($link, "utf8mb4");

//Choix de la BDD et message d'erreur si connexion impossible
mysqli_select_db ($link, "oiseaudb") or die ("Impossible de sélectionner la BDD oiseaudb : ".mysqli_error($link));

//Requête pour récupérer les observations par espèce d'oiseaux
$query = "	SELECT 	oiseaux.nom_commun as Oiseau, sum(observations.nombre) as Quantite
			FROM oiseaux 	JOIN observations ON oiseaux.id_oiseau=observations.id_oiseau
							JOIN observateurs ON observations.id_observateur = observateurs.id_observateur
							JOIN communes ON observations.id_commune=communes.id_commune
							JOIN departements ON communes.id_dpt=departements.id_dpt
			WHERE observateurs.id_observateur='".$id_obs."'AND departements.id_dpt='".$id_dep."'
			GROUP BY oiseaux.id_oiseau";
$result = mysqli_query ($link, $query);

//Récupération des données utilisées (nombre d'oiseaux observés) et des noms d'oiseau pour la légende 
$tab = mysqli_fetch_all ($result);
$nbligne = mysqli_num_rows($result);

for ($i=0;$i<$nbligne;$i++)
{
	$legend[$i] = $tab[$i][0];
}

for ($i=0;$i<$nbligne;$i++)
{
	$data[$i] = $tab[$i][1];
}
		
//Création du graphique
$graph = new PieGraph(650,300);
$graph->SetShadow();

//Création du titre du graphique
$graph->title->Set("Répartition des observations d'oiseaux de ".$nom_obs." ".$prenom." 
dans le département ".$id_dep." (".$nom_dep.") "); 

//Création du diagramme
$p1 = new PiePlot($data);

//Création de la légende
$p1->SetLegends($legend);

// Envoi du graphique sur la page
$graph->Add($p1);
$graph->Stroke();

?>
