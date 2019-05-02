<html>
	<head>
	
	</head>
	
	<body>

	<FORM action ="ex1_p2.php" method = "GET" name = "form1">
			
			(*)Nom :<input Type = "TEXT" name ="Nom" value =""><br>
			(*)Prenom :<input Type = "TEXT" name ="Prenom" value =""><br>
			(*)Numéro de tel :<input Type = "TEXT" name ="Tel" value =""><br>
			<?php
				$tab=array("","vanille", "chocolat","menthe","fraise");
				$i=0;
				$n_parfum=count($tab);
				
			echo "<select name= 'Parfum'>";
				while($i<$n_parfum)
				{
					echo "<option value=".$tab[$i]."> ".$tab[$i].  "</option>";
					$i++;
				}
			
			echo "</select>";
			?>

				<br><br>
		<input Type = "submit" name ="bt_submit" value = "Valider">
	
	</FORM>
	<br><br>	

	</body>

</html>