<html>
	<head>
	
	</head>
	
	<body>
	
		<?php
		
		if (isset($_GET["Nom"]))	
		{
			$nom= $_GET ["Nom"];
			if ($_GET["Nom"]== "" or is_numeric($_GET["Nom"]) )
			{$nom="-";}
		}
		else	
		{
			$nom="-";
		}
			
		if (isset($_GET["Prenom"]))	
		{
			$prenom= $_GET ["Prenom"];
			if ($_GET["Prenom"]== ""or is_numeric($_GET["Prenom"]))
			{$prenom="-";}
		}	
		else	
		{
			$prenom="-";
		}
		
		if (isset($_GET["Tel"]) and is_numeric ($_GET["Tel"]))	{$tel=$_GET ["Tel"];}
		else	{$tel="-";}
		if (isset($_GET["Parfum"]))	{$parfum_pref=$_GET ["Parfum"];}
		else	{$parfum_pref="-";}
		
		
		
		
		echo "Nom: ".$nom."</br>";
		echo "Prenom: ".$prenom."</br>";
		echo "Numero de tel: ".$tel."</br>";
		echo "Parfum  préféré: ".$parfum_pref."</br>";
		$i=0;	

			?>
	</body>
</html>