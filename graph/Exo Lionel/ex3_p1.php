<html>
	<head>
		<script>
		function valider()
		{
				var nom=0;
				var prenom=0;
				var tel=0;
				var parfum=0;
				var ok=1;
				var i=0;
			
			
				if(document.formSaisi.Nom.value =="")
				{nom=1;ok=0;
				document.formSaisi.Nom.style.background='#FF0000';}
				else {document.formSaisi.Nom.style.background='#00FF00';}
			
				if(document.formSaisi.Prenom.value =="")
				{prenom=1;ok=0;
				document.formSaisi.Prenom.style.background='#FF0000';}
				else {document.formSaisi.Prenom.style.background='#00FF00';}
				
				if(document.formSaisi.Tel.value =="")
				{tel=1;ok=0;
				document.formSaisi.Tel.style.background='#FF0000';}
				else {document.formSaisi.Tel.style.background='#00FF00';}
				
				if(document.formSaisi.Parfum.value =="")
				{parfum=1;ok=0;
				document.formSaisi.Parfum.style.background='#FF0000';}
				else {document.formSaisi.Parfum.style.background='#00FF00';}
				
				var message="Veuillez saisir:\n";
			
				if (nom==1) 
				{message=message+"Nom\n";} 
				if (prenom==1) 
				{message=message+"Prénom\n";} 		
				if (tel==1) 
				{message=message+"Téléphone\n";} 	
				if (parfum==1) 
				{message=message+"Parfum\n";} 
			
				if (ok==1){return true;}
				else {alert(message);return false;}
			
		}
				
		</script>
	</head>
	
	<body>

	<FORM action ="ex1_p2.php" onsubmit= "return valider()"method = "GET" name = "formSaisi">
			
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