<?php

$datay3=array(60,70,60,50,80,30);
$i=0;
$années=array("2014","2015","2016","2017","2018","2019");

/*
$datay1=$_GET["-_Insérer les vaches nées et conservées en ordonnée issu des requêtes_-"];
$datay2=$_GET["-_Insérer les éleveurs issu des requêtes_-"];
$datay3=$_GET["-_Insérer le nombre total de vache en ordonnée issu des requêtes_-"];
$années=$_GET["-_Insérer les années_-"];
*/

$stock=0;
echo($stock);
while($i<count($datay3))
{
	if ($datay3[$i]>$stock)
		$stock=$datay3[$i];
	$i=$i+1;
}

?>