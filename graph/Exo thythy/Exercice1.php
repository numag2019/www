<html>
	<head>
	
	</head>
	
	<body>
		
		
		<?php
		$Valeur= $_GET ["zt_valeur"];
			$i=1;
			$somme=0;
			do
			{
				$somme=$somme+$i;
				$i++;

			}while ($Valeur>$i-1);
			echo "La somme vaut ".$somme
			?>
	</body>
</html>