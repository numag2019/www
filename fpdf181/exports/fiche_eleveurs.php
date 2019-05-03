<?php

session_start();

require('../fpdf.php');

class PDF extends FPDF
{
protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

// En-tête
function Header()
{
	//Logo
	$this->Image('logo.jpg',10,6,30,0,'','http://racesaquitaine.fr/');
	//Police Arial gras 15
	$this->SetFont('Arial','B',15);
	//Décalage à droite
	$this->Cell(80);
	//Titre
	$this->Cell(70,10,'Voici le titre de mon entete',1,0,'C');
	//Saut de ligne
	$this->Ln(40);
}

// Pied de page
function Footer()
{

	// Positionnement à 1,5 cm du bas
	$this->SetY(-15);
	// Police Arial italique 8
	$this->SetFont('Arial','I',8);
	// Numéro de page
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

function WriteHTML($html)
{
	// Parseur HTML
	$html = str_replace("\n",' ',$html);
	$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
	foreach($a as $i=>$e)
	{
		if($i%2==0)
		{
			// Texte
			if($this->HREF)
				$this->PutLink($this->HREF,$e);
			else
				$this->Write(5,$e);
		}
		else
		{
			// Balise
			if($e[0]=='/')
				$this->CloseTag(strtoupper(substr($e,1)));
			else
			{
				// Extraction des attributs
				$a2 = explode(' ',$e);
				$tag = strtoupper(array_shift($a2));
				$attr = array();
				foreach($a2 as $v)
				{
					if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
						$attr[strtoupper($a3[1])] = $a3[2];
				}
				$this->OpenTag($tag,$attr);
			}
		}
	}
}

}

$departement = array('Ariège','Aveyron','Charente-Maritime','Côtes-Armor','Haute-Garonne','Gers','Gironde');
$nb_eleveurs = array(3,5,1,4,2,1,3);

$pdf = new PDF();

//création des pages pdf
$pdf->AliasNbPages(); //nécessaire pour afficher le nombre de pages
$pdf->AddPage();
for($i=1;$i<=count($departement);$i++)
{
    $pdf->SetFont('Arial','U',20); //police des départements
    $pdf->Cell(0,10,$departement[$i-1],0,1);
    $pdf->Ln(10);
    for($k=1;$k<=count($nb_eleveurs);$k++)
    {
        $pdf->SetFont('Times','',15); //police des eleveurs
        $pdf->Cell(0,10,'Eleveurs '.$nb_eleveurs[$k-1],0,1);
        $pdf->Ln(5);
    }
    $pdf->Ln();
}
$pdf->Cell($_SESSION['nb_femelle']);
$pdf->Output();
?>