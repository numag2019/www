<!-- Cette page permet l'envoi des fichiers pdf vers cranet. Page appelé avec la page creationcsv.php-->


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
			$ftpTarget[]=$fichier;
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