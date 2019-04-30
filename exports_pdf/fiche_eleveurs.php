<?php
require('../fpdf.php');

class PDF extends FPDF
{
protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

// En-t�te
function Header()
{
	//Logo
	$this->Image('logo.jpg',10,6,30,0,'','http://racesaquitaine.fr/');
	//Police Arial gras 15
	$this->SetFont('Arial','B',15);
	//D�calage � droite
	$this->Cell(80);
	//Titre
	$this->Cell(70,10,'Voici le titre de mon entete',1,0,'C');
	//Saut de ligne
	$this->Ln(40);
}

// Pied de page
function Footer()
{
	// Positionnement � 1,5 cm du bas
	$this->SetY(-15);
	// Police Arial italique 8
	$this->SetFont('Arial','I',8);
	// Num�ro de page
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

$nb_departement = 10;
$nb_eleveurs = 3;

$pdf = new PDF();

//cr�ation des pages pdf
$pdf->AliasNbPages(); //n�cessaire pour afficher le nombre de pages
$pdf->AddPage();
for($i=1;$i<=$nb_departement;$i++)
{
    $pdf->SetFont('Arial','U',20); //police des d�partements
    $pdf->Cell(0,10,'D�partement '.$i,0,1);
    $pdf->Ln(10);
    for($k=1;$k<=$nb_eleveurs;$k++)
    {
        $pdf->SetFont('Times','',15); //police des eleveurs
        $pdf->Cell(0,10,'Eleveurs '.$k,0,1);
        $pdf->Ln(5);
    }
    $pdf->Ln();
}    
$pdf->Output();
?>