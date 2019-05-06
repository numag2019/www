<html>
	<head>
	
	</head>
	
	<body>
		
		<?php	
	
	
			$ligne= $_GET ["Ligne1"];
			var_dump($ligne);
			$n=count ($ligne);
			$i=0;
			$somme=0;
			$moyenne=0;
			do
			{
				$somme=$somme+$ligne[$i];
				$i++;;

			}while ($i<$n);
			$moyenne=$somme/$n;
			echo $somme."<br>";
			echo $n."<br>";
			echo $moyenne."<br>";
			
			$tableau(2,4);
		?>

	</FORM>
	
	</body>
</html>