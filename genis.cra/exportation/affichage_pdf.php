<html>
<body>

<?php

// On prend tous les noms des fichiers présents dans le dosssier pdf
$nb_fichier = 0;   //variable nombre de fichier
$chemin=array();
$ftpTarget=array();
if($dossier = opendir('./pdf'))
{
	
	while(false !== ($fichier = readdir($dossier)))
	{
		if($fichier != '.' && $fichier != '..')
		{
			$chemin[]="pdf/".$fichier;
			$nb_fichier++; // On incrémente le compteur de 1
			

		} // On ferme le if (qui permet de ne pas afficher index.php, etc.)
	
	} // On termine la boucle

 
	closedir($dossier);
	 
	echo 'Noms des fichiers pdf mis à disposition : ';
	echo "<BR>";
	echo "Indications : vous pouvez mettre à disposition d'autres pdf en les créant dans les onglets 'animaux'";
	echo "<BR>";
	// transferts des fichiers pdf vers serveur CRAnet (fonction situé dans ftp.php)
	$i=0;
	while($i<$nb_fichier)
	{
		echo '<a href='.$chemin[$i].'>'.$chemin[$i].'</a>';
		echo "<BR>";
		$i++;
	}
}
else
     echo 'Le dossier n\' a pas pu être ouvert';
?>








</body>

</html>