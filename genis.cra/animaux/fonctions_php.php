<?php

//Fonction qui crée et met en page un tableau pour afficher les données contenues dans le résultat d'une requête
		function creer_tab_HTML ($result)
		{
			//Création du tableau
			echo "<table id='example' class='display'>";
				$nbcol = mysqli_num_fields ($result);
				mysqli_data_seek ($result, 0);
				
					//Affichage des titres dans la 1ère ligne du tableau
					echo "<thead><tr>";
					for ($i=0;$i<$nbcol;$i++)
					{
						echo "<td>";
						$titre = mysqli_fetch_field_direct ($result, $i);
						$t[$i] =$titre -> name;
						echo "<b>".$t[$i]."</b>";
						echo"</td>";
					}
					echo "</tr></thead><tbody>";
			
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
			echo "</tbody></table>";
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