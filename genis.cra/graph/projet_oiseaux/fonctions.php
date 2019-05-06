<!-- Définition des différentes fonctions utilisées sur l'ensemble des pages crées pour ce projet -->

<html>

	<head>
		<meta charset = "UTF-8">
	</head>
	
	<body>
<?php

//Fonction qui crée et met en page un tableau pour afficher les données contenues dans le résultat d'une requête
		function creer_tab_HTML ($result)
		{
			//Création du tableau
			echo "<table border ='1'>";
				$nbcol = mysqli_num_fields ($result);
				mysqli_data_seek ($result, 0);
				
					//Affichage des titres dans la 1ère ligne du tableau
					echo "<tr>";
					for ($i=0;$i<$nbcol;$i++)
					{
						echo "<td>";
						$titre = mysqli_fetch_field_direct ($result, $i);
						$t[$i] =$titre -> name;
						echo "<b><center>".$t[$i]."</center></b>";
						echo"</td>";
					}
					echo "</tr>";
			
			// Affichage des valeurs dans chaque case du tableau			
			while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
			{
				echo"<tr>";
				for ($i=0;$i<$nbcol;$i++)
				{
					echo "<td>";
					echo $row[$i]." ";
					echo"</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
		}

//Fonction qui récupère la valeur maximum des données contenues dans le résultat d'une requête
		function max_tab ($result)
		{
			$max = 0;
			
			//Pour chaque valeur de la 2ème colonne du résultat, comparaison avec la valeur max enregistrée, si elle est supérieure, enregistrement comme nouvelle valeur max
			while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
			{
				if ($row[1]>$max)
				{
					$max = $row[1];
				}
			}
			mysqli_data_seek($result,0);
			return $max;
		}
				
//Fonction qui crée et met en page un tableau pour afficher les données contenues dans le résultat d'une requête
//La valeur maximum est affichée en rouge
				
		function creer_tab_HTML_max ($result, $max)
		{
			//Création du tableau
			echo "<table border ='1'>";
				$nbcol = mysqli_num_fields ($result);
				mysqli_data_seek ($result, 0);
				
					//Affichage des titres dans la 1ère ligne du tableau
					echo "<tr>";
					for ($i=0;$i<$nbcol;$i++)
					{
						echo "<td>";
						$titre = mysqli_fetch_field_direct ($result, $i);
						$t[$i] =$titre -> name;
						echo "<b><center>".$t[$i]."</center></b>";
						echo"</td>";
					}
					echo "</tr>";
			
			// Affichage des valeurs dans chaque case du tableau
			while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
			{
				echo"<tr>";
				for ($i=0;$i<$nbcol;$i++)
				{
					//Choix de la couleur de l'affichage : rouge si la valeur observée est la valeur maximum, noir sinon
					if ($row[$i]==$max)
					{
						echo "<td>";
						echo "<font color = 'red'>".$row[$i]."</font> ";
						echo"</td>";
					}
					else
					{
						echo "<td>";
						echo $row[$i];
						echo"</td>";
					}
					
				}
				echo "</tr>";
			}
			mysqli_data_seek ($result, 0);
			echo "</table>";
		}		
		
//Fonction qui crée une liste déroulante à partir d'un tableau à une colonne et du nom que l'on souhaite donner à cette liste	
		function creer_liste_HTML ($name,$tab)
		{
			//Choix du nom de la liste
			echo "<select name = ".$name.">";
			
			//Récupération et affichage des valeurs du tableau dans la liste
			for ($i=0;$i<count($tab);$i++)
			{
				echo ("<option value = ".$tab[$i].">".$tab[$i])."</option>";
			}
			echo "</select>";
		}
		
		?>
			
	</body>
	
</html>