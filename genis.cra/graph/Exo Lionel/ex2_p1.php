<html>
	<head>
	
	</head>
	
	<body>

	<FORM action ="ex2_p2.php" method = "GET" name = "form1">
			
			(*)Nom :<input Type = "TEXT" name ="Nom" value =""><br>
			(*)Prenom :<input Type = "TEXT" name ="Prenom" value =""><br>
			(*)Numéro de tel :<input Type = "TEXT" name ="Tel" value =""><br>
			(*)
			<?php 
			
			require 'Mesfonctions.php';
			
				$tab=array("","vanille", "chocolat","menthe","fraise","citron","goyave","framboise");
				$n_tab=count($tab);
				procedure($tab,$n_tab,4);
			
			
			echo "</select>";
			?>

				<br><br>
		<input Type = "submit" name ="bt_submit" value = "Valider">
	
	</FORM>
	<br><br>	

	</body>

</html>