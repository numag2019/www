<html>
	<head>
	
	</head>
	
	<body>
	<?php
		function tableau($tab,$nblignes,$nbcolonnes) 
		##Pour appeler mon tableau en html tablo(montableau.php);
		{
			echo "<table	border=1>";	
			$i=0; 
			
			while ($i<$nblignes)
			{
				echo "<tr>";
				$j=0;
				while($j<$nbcolonnes)
				{
					echo"<td>".$tab[$i][$j]."</td>";
					$j++;
				}
				$i++;
				echo"</tr> ";
			}
				
			echo "</table>";
		}
		
		
		function procedure($tab,$tab_nom,$n_list_aff)
		{
			
				$i=0;
				$n_tab=count($tab);
				
			echo "<select name= 'Parfum' size= $n_list_aff>";
				while($i<$n_tab)
				{
					echo "<option value=".$tab[$i]."> ".$tab[$i].  "</option>";
					$i++;
				}
			
			echo "</select>";
			
			
		}

	
	?>
	</body>

</html>