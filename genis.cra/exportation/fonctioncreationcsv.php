<!--fonction créant les csv, variables: deux requêtes sql possibles et le nom du fichier à créer-->
<?php
// page contenant la variable DB NAME
include("../libraries/constants.php");

// Fonction créant un csv ayant comme variable deux requetes et le nom du fichier (appelé par la page creationcsv.php)
function creationcsv($requete1, $requete2, $nom_fichier)
{
	$link=mysqli_connect('localhost','root','','genis_test');
	mysqli_set_charset($link,"utf8mb4");

	// Recuperation de la requete 		
	$obs1=mysqli_query($link,$requete1);
	if ($requete2!=NULL)
	{
		$obs2=mysqli_query($link,$requete2);
	}
	
	// Transformation donnees en tableau 
	$tab=mysqli_fetch_all($obs1);
	if ($requete2!=NULL)
	{
		$tab2=mysqli_fetch_all($obs2);
	}
	
	// Recuperation lignes et colonnes du tableau
	$nbligne=mysqli_num_rows($obs1);
	if ($requete2!=NULL)
	{
		$nbligne=mysqli_num_rows($obs2) + mysqli_num_rows($obs1);
	}
	$nbcol=mysqli_num_fields($obs1);

	//Concaténation tableaux
	if ($requete2!=NULL)
	{
		$tab=array_merge($tab,$tab2);
	}
	
	//chemin du fichier texte
	$chemin = 'csv/'.$nom_fichier.'.csv';

	// Creation du fichier csv (le fichier est vide pour le moment)
	$fichier_csv = fopen($chemin, 'w+');

	//Pour éviter les problemes avec des caracteres speciaux sur le fichier texte
	fprintf($fichier_csv, chr(0xEF).chr(0xBB).chr(0xBF));
	
	// Creation de l'ecrit destine au csv
	$i=0;
	$ecrit='';
	while ($i<$nbligne)
	{	
		$ecrit.='/"'.$tab[$i][0];
		$j=1;
		while ($j<$nbcol-1)
		{
			$ecrit.='";"'. $tab[$i][$j];
			$j++;
		}
		$ecrit.='";"'.$tab[$i][$nbcol-1].'"/'."\r\n";
		$i++;
	}
	
		
	//ecriture dans le csv
	fwrite($fichier_csv,$ecrit);
	
	// fermeture du fichier csv
	fclose($fichier_csv);
	
}

?>

