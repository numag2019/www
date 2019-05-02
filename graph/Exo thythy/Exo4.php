<html>
	<head>
	
	</head>
	
	<body>
	
		<?php
		$ville= $_GET ["tab1"];
		$temp= $_GET ["tab2"];
		
		$i=0;
		$somme=0;
		$temp_h=0;
		$ville_corr=0;
		
		$n1=count($ville);
		$n2=count($temp);
		
		echo "<br>".$n1;
		echo "<br>".$n2;
		
			do
			{
				
				if ($temp[$i]>$temp_h)
				{
					$temp_h=$temp[$i];
					$ville_corr=$ville[$i];
				}
					echo "<br><br>Ville : ".$ville[$i];
					echo "<br>Temperature testee :".$temp[$i];
					echo "<br>Temperature retenue :".$temp_h;
					echo "<br>Ville : ".$ville_corr;
				$i++;
				
			}while ($i<$n2);
			
		echo "<br><br> <br>La plus haute temperature est: ".$temp_h;
		echo "<br> <br><br>Qui correspond a la ville de : " .$ville_corr;
			?>
	</body>
</html>