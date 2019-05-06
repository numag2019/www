<html>
	<head>
	
	</head>
	
	<body>
		
	<FORM action ="Exo2tab.php" method = "GET" name = "form1">
		<?php
			$ligne= $_GET ["Ligne"];
			echo $ligne[0]."<br>";
			$i=0;
			while($i<$ligne)
			{
				echo '<input  name ="Ligne1[]" value ="0"><br>';
				
				
				
				$i++;
			}
			
	
			
			

		?>
		<input Type = "submit" name ="bt_submit" value = "Envoyer">;
	</FORM>
	
	</body>
</html>