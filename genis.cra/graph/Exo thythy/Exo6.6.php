<html>
	<head>
	
	</head>
	
	<body>

Liste de gens tabarnak: <br>	
	<?php require("Mesfonctions.php");
	$i=0;
	
	$link=mysqli_connect('localhost','root','','oiseaudb');
	$query="SELECT * from observateurs";
	$result= mysqli_query($link,$query);
	
	$tab=mysqli_fetch_all($result);
	$nblignes=mysqli_num_rows($result);
	$nbcol=mysqli_num_fields($result);

	echo "</br>";
	echo "<FORM action ='Exo6.6bis.php' method = 'GET' name = 'form1'>";
		echo "<select name= 'Ma_liste'> <!-- liste deroulante -->";
		while ($i<$nblignes)
		{
			echo "<option value='".$tab[$i][0]."'>'" .$tab[$i][1]."' </option>";
			$i++;
		}
		echo "</select>";
	
			
	echo "<input Type = 'submit' name ='bt_submit'value ='Envoie la sauce'>";
	
	echo"</FORM>";
	?>
	
	</body>

</html>