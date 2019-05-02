<!-- Définition des différentes fonctions utilisées sur l'ensemble des pages crées pour ce projet -->

<html>

	<head>
		<meta charset = "UTF-8">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.css"/>
	 
		<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.js"></script>

	</head>
	
	<body>
	<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable();
	} );
	</script>
<?php

//Fonction qui crée et met en page un tableau pour afficher les données contenues dans le résultat d'une requête
		function creer_tab_HTML ($result)
		{
			//Création du tableau
			echo "<table id='example' class='display'>";
				$nbcol = mysqli_num_fields ($result);
				mysqli_data_seek ($result, 0);
				
					//Affichage des titres dans la 1ère ligne du tableau
					echo "<tr>";
					for ($i=0;$i<$nbcol;$i++)
					{
						echo "<td>";
						$titre = mysqli_fetch_field_direct ($result, $i);
						$t[$i] =$titre -> name;
						echo "<b>".$t[$i]."</b>";
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