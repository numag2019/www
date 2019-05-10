<html>
<body>

<?php

include('ftp.php');						//page d'une fonction transferant les pdf au serveur distant


$nb_fichier = 0;   //variable nombre de fichier


if($dossier = opendir('./csv'))
{

	while(false !== ($fichier = readdir($dossier)))
	{
		if($fichier != '.' && $fichier != '..')
		{
			$chemin=array("exports/".$fichier);
			$ftpTarget=array($fichier);
			$nb_fichier++; // On incrémente le compteur de 1

		} // On ferme le if (qui permet de ne pas afficher index.php, etc.)
	
	} // On termine la boucle

 
closedir($dossier);
 

// transferts des fichiers pdf vers serveur CRAnet (fonction situé dans ftp.php)
$i=0;
while($i<$nb_fichier)
{
	$trsft=export_vers_cranet($chemin[$i], $ftpTarget[$i]);
	$i++;
}
}
else
     echo 'Le dossier n\' a pas pu être ouvert';
?>








</body>

</html>