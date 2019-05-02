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
	
	while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
	{
			$id = $row[0];
			$nom= $row[1];
			$prenom=$row[2];
			$site=$row[3];
			$mail=$row[4];
			echo $id." - ".$nom." ".$prenom." HYPER LIEN: ".$site." Adresse mail:  ".$mail."<br/>";
	}
	
	tableau($tab,$nblignes,$nbcol);
	echo "</br>";
		echo "<select name= 'Ma_liste'> <!-- liste deroulante -->";
		while ($i<$nblignes)
		{
			echo "<option value='".$tab[$i][0]."'>'" .$tab[$i][1]."' </option>";
			$i++;
		}
		echo "</select>";
	?>
	
	</body>

</html>