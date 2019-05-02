<html>
	<head>
	
	</head>
	
	<body>
	
		<?php
		$tableau= $_GET["tab"];
		$plancher=$_GET["plancher1"];
		$seuil=$_GET["seuil1"];
		//echo $tableau."<br>";
		$somme=0;
		$n=count($tableau);
		$i=0;

			do
			{
				if ($tableau[$i]>$seuil)
					$somme=$somme+$tableau[$i];
				$i++;

			}while ($i<$n);
			
			if ($somme>=$seuil)
				echo "  Félicitation, vous avez une pyrale! "; 
			else
				echo "  Pas assez chaud, navre  ";
			
			?>
	</body>
</html>