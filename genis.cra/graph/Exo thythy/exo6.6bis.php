<html>
	<head>
	
	</head>
	
	<body>

Liste de gens tabarnak: <br>	
	<?php require("Mesfonctions.php");
	$i=0;
	$obs=$_GET['Ma_liste'];
	
	$link=mysqli_connect('localhost','root','','oiseaudb');
	$query="SELECT observations.id_observation, DATE_FORMAT
			(date, '%W %D %M %Y') as 'date formatée',
			nom_commun as 'nom commun'
			FROM observations, oiseaux
			WHERE observations.id_oiseau = oiseaux.id_oiseau
			and id_observateur ='$obs'";
	$result= mysqli_query($link,$query);
	
	$tab=mysqli_fetch_all($result);
	$nblignes=mysqli_num_rows($result);
	$nbcol=mysqli_num_fields($result);
	
	
	tableau($tab,$nblignes, $nbcol);

	echo "</br>";
	echo "<FORM action ='Exo6.6bis.php' method = 'GET' name = 'form1'>";
		echo "<select name= 'Ma_liste'> <!-- liste deroulante -->";
		while ($i<$nblignes)
		{+
			echo "<option value='".$tab[$i][0]."'>'" .$tab[$i][1]."' </option>";
			$i++;
		}
		echo "</select>";
	
			
	echo "<input Type = 'submit' name ='bt_submit'value ='Envoie la sauce'>";
	
	echo"</FORM>";
	?>
	
	</body>

</html>*