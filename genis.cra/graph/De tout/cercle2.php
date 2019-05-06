<html>
	<head>
	
	</head>
	
	<body>
		Surface du cercle <br><br>
		
	<?php 
	$d_rayon= $_GET ["zt_rayon"];
	define ("PI", 3.1415);
	$d_Surface = PI * $d_rayon*$d_rayon;
	echo "Pour un rayon de ".$d_rayon. " <BR/>";
	echo "La surface du cercle vaut=" .$d_Surface;
	?>
	<br><br>
	</body>
</html>