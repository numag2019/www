<?php
//Page r�alis� par l'�quipe NumAg 2018-2019
//cette page � pour but de coder l'exportation en pdf de l'export Fiche Race globales. Cet export est compos� d'un tableau et de 3 graphiques
//�l�ve r�f�rent : Amaury Branthomme

//Commentaires : J'ai du utiliser la fonction utf8_decode car cette page est en lien avec une page o� les donn�es sont en UTF8

/////////////////////////////////////////// Initialisation ///////////////////////////////////////////////////

session_start();

// R�cup�ration des variables de session
$bovin = $_SESSION['bovin'];
$bearnaise = $_SESSION['bearnaise'];
$bordelaise = $_SESSION['bordelaise'];
$marine = $_SESSION['marine'];
$equin = $_SESSION['equin'];
$plandais = $_SESSION['plandais'];
$ovin = $_SESSION['ovin'];
$mlandais = $_SESSION['mlandais'];
$sasi = $_SESSION['sasi'];
$annee = $_SESSION['annee_glo'];

// Appel du fichier traitant la cr�ation de pdf
require('../fpdf.php');

// Ajout de fonctions � la classe pdf d�j� existante en php
class PDF extends FPDF
{
protected $B = 0;
protected $I = 0;
protected $U = 0;

/////////////////////////////////////////// Mise en page du PDF ///////////////////////////////////////////////////

// En-t�te
function Header()
{
    $annee = $_SESSION['annee_glo'];
	//Logo
	$this->Image('logo.jpg',10,6,30,0,'','http://racesaquitaine.fr/');
	//Police Arial gras 15
	$this->SetFont('Arial','B',15);
	//D�calage � droite
	$this->Cell(80);
	//Titre
	$this->Cell(70,10,utf8_decode('Effectif des populations entre ').$annee[0].' et '.end($annee) ,0,0,'C');
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
	$this->Cell(110,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
    //date de cr�ation du pdf
    $this->Cell(80,10,date('d\/m\/Y'),0,0,'R');
}


/////////////////////////////////////////// d�but des fonctions de cr�ation des tableaux ///////////////////////////////////////////////////

//Fonction r�alisant le tableau
function Tableau($header,$effectif,$largeur_col,$largeur_lgd)
{
    //Titre
    $annee = $_SESSION['annee_glo'];
    // Couleurs, �paisseur du trait et police pour le titre
	$this->SetFillColor(133,195,43);
	$this->SetTextColor(0);
	$this->SetDrawColor(0,0,0); //couleur des lignes du tableau
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
    $this->SetFontSize(12);
    
    $this->Cell($largeur_col,7,utf8_decode('Evolution des effectifs des races entre '.$annee[0].' et '.end($annee)));
    $this->Ln();
    
    // Couleurs, �paisseur du trait et police grasse pour l'entete
	$this->SetFillColor(133,195,43);
	$this->SetTextColor(0);
	$this->SetDrawColor(0,0,0); //couleur des lignes du tableau
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
    
	// En-t�te
	foreach($header as $col)
        if (is_null($col))
            $this->Cell($largeur_lgd,7,$col,1,0,'C',true);//Si la case est la l�gende, on applique un style particulier
        else
            $this->Cell($largeur_col,7,$col,1,0,'C',true); 
	$this->Ln();
    
    
	// Donn�es
	foreach($effectif as $row)//on parcourt l'ensemble des lignes
	{
        foreach($row as $col)//on parcourt l'ensemble des elements de la ligne
        {
            if (is_numeric($col))
            {
                // Restauration des couleurs et de la police pour les donn�es du tableau
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('');
                $this->SetFontSize(11);
                $this->Cell($largeur_col,6,utf8_decode($col),'LR',0,'C');
            }
            else//Si la case est la l�gende, on applique un style particulier
            {
                // Restauration des couleurs et de la police pour les donn�es du tableau
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('');
                $this->SetFontSize(12);
                $this->Cell($largeur_lgd,6,utf8_decode($col),'LR',0,'L'); 
            }
        }
		$this->Ln();
	}
    // Trait de terminaison
	$this->Cell($largeur_lgd+(count($header)-1)*$largeur_col,0,'','T'); //trait pour fermer le tableau
    

}

}

///////////////////////////////////////////Modifications des donn�es pour remplir les tableaux ///////////////////////////////////////////////////

//cr�ation de l'entete des ann�es
$header = array();
array_push($header,NULL);       //ajout d'un champ NULL en d�but des ann�es pour laisser place � la l�gende
for($i=0;$i<count($annee);$i++) 
    array_push($header,$annee[$i]);   



// R�cup�ration des donn�es des requetes SQL par les variables de session et cr�ation d'une unique variable pour la cr�ation du tableau
$effectif = array($bovin,$bearnaise,$bordelaise,$marine,$equin,$plandais,$ovin,$mlandais,$sasi);


///////////////////////////////////////////Affichage des pages PDF ///////////////////////////////////////////////////


//�criture des pages PDF
$pdf = new PDF();

//Taille des colonnes
$largeur_col = 150/(count($header)-1); //taille des colonnes des ann�es adaptatives en fonction du nombre d'ann�es
$largeur_lgd = 40;



//Page des effectifs inventories dans l'ensembles des races
$pdf->AliasNbPages(); //n�cessaire pour afficher le nombre de pages
$pdf->AddPage();
$pdf->SetFont('');

//Tableau d'�volution des effectifs dans l'ensemble des races
$pdf->Tableau($header,$effectif,$largeur_col,$largeur_lgd);



// Page des graphiques
$pdf->AddPage();
//Graphique d'�volution des effectifs des races
$pdf->Image('../../graph/EvoEffBovins.png',20,60,-90);
$pdf->AddPage();
$pdf->Image('../../graph/EvoEffEquin.png',20,60,-90);
$pdf->AddPage();
$pdf->Image('../../graph/EvoEffovins.png',20,60,-90);




//affichage et sauvegarde du fichier en pdf

for($i=1;$i<=2;$i++)
	{
	    if($i==1)
	    {
		//sauvegarde du fichier
		// $pdf->Output('../../pdf/fiche_globale.pdf','F');
        $pdf->Output('../../pdf/fiche_globale_'.$annee[0].'_'.end($annee).'.pdf','F'); //Pour afficher les ann�es dans le titre des pdf
	    }
	    else
	    {
		//affichage du fichier
		$pdf->Output();
	    }
    }

?>
