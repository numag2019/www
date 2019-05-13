<!--Cette fonction a deux variables, le chemin d'accès du fichier à 
envoyer créé par genis et le chemin où créer le fichier sur le serveur du site web-->

<?php
function export_vers_cranet($chemin , $ftpTarget)
{
/*
$chemin : chemin d'accès au fichier GeniS à envoyer sur Cranet
$ftpTarget : emplacement où le fichier va être envoyé */

// on établit la connexion au serveur
	$ftpServer = '194.199.251.99';

	// on se connecte en tant qu'utilisateur
	$ftpUser = 'cranet';
	$ftpPwd = 'numag2019';
	$connection = ftp_connect($ftpServer);
	
	//Si la connection a réussi, on continue
	if ($connection)
	{
		$login = ftp_login($connection, $ftpUser, $ftpPwd);
		// on active le mode passif 
		ftp_pasv($connection, true);
		
		// si on est connecté avec succès, on transfère le fichier
		if ($connection && $login) 
			{
			$upload = ftp_put($connection, $ftpTarget , $chemin, FTP_BINARY);
			if (!$upload) 
				{
				$error="échec de l'envoie ";
				}
			} 
		else 
		{
			$error= 'La tentative de connexion FTP a échoué !<br>';
		}
		// on clos la connexion
		ftp_close($connection);
	}
	else 
		echo 'Vous n\'êtes pas connecté au serveur de CRAnet';

 }
?>
