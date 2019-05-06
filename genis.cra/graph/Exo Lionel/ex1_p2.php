<html>
	<head>
	
	</head>
	
	<body>
	
		<?php
		$nom= $_GET ["Nom"];
		$prenom= $_GET ["Prenom"];
		$tel=$_GET ["Tel"];
		$parfum_pref=$_GET ["Parfum"];
		$tab=array("","vanille", "chocolat","menthe","fraise");

		echo "Nom: ".$nom ."</br>";
		echo "Prenom: ".$prenom ."</br>";
		echo "Numero de tel: ".$tel ."</br>";
		echo "Parfum  préféré: ".$parfum_pref."</br>";
		$i=0;	

			?>
	</body>
</html>