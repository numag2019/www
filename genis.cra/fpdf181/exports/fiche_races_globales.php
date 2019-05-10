<?php
//Page réalisé par l'équipe NumAg 2018-2019
//cette page à pour but de coder l'exportation en pdf de l'export Fiche Race globales. Cet export est composé d'un tableau et de 3 graphiques
//élève référent : Amaury Branthomme

/////////////////////////////////////////// Initialisation ///////////////////////////////////////////////////

session_start();

// Récupération des variables de session
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

// Appel du fichier traitant la création de pdf
require('../fpdf.php');

// Ajout de fonctions à la classe pdf déjà existante en php
class PDF extends FPDF
{
protected $B = 0;
protected $I = 0;
protected $U = 0;

/////////////////////////////////////////// Mise en page du PDF ///////////////////////////////////////////////////

// En-tête
function Header()
{
    $annee = $_SESSION['annee_glo'];
	//Logo
	$this->Image('logo.jpg',10,6,30,0,'','http://racesaquitaine.fr/');
	//Police Arial gras 15
	$this->SetFont('Arial','B',15);
	//Décalage à droite
	$this->Cell(80);
	//Titre
	$this->Cell(70,10,utf8_decode('Effectif des populations entre ').$annee[0].' et '.end($annee) ,0,0,'C');
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
	$this->Cell(110,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
    //date de création du pdf
    $this->Cell(80,10,date('d\/m\/Y'),0,0,'R');
}


/////////////////////////////////////////// début des fonctions de création des tableaux ///////////////////////////////////////////////////

//Fonction réalisant le tableau
function Tableau($header,$effectif,$largeur_col,$largeur_lgd)
{
    // Couleurs, épaisseur du trait et police grasse pour l'entete
	$this->SetFillColor(133,195,43);
	$this->SetTextColor(0);
	$this->SetDrawColor(0,0,0); //couleur des lignes du tableau
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
    
	// En-tête
	foreach($header as $col)
        if (is_null($col))
            $this->Cell($largeur_lgd,7,$col,1,0,'C',true);//Si la case est la légende, on applique un style particulier
        else
            $this->Cell($largeur_col,7,$col,1,0,'C',true); 
	$this->Ln();
    
    
	// Données
	foreach($effectif as $row)
	{
        foreach($row as $col)
        {
            if (is_numeric($col))
            {
                // Restauration des couleurs et de la police pour les données du tableau
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('');
                $this->SetFontSize(11);
                $this->Cell($largeur_col,6,utf8_decode($col),'LR',0,'C');
            }
            else//Si la case est la légende, on applique un style particulier
            {
                // Restauration des couleurs et de la police pour les données du tableau
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

///////////////////////////////////////////Modifications des données pour remplir les tableaux ///////////////////////////////////////////////////

//création de l'entete des années
$header = array();
array_push($header,NULL);       //ajout d'un champ NULL en début des années pour laisser place à la légende
for($i=0;$i<count($annee);$i++) 
    array_push($header,$annee[$i]);   



// Récupération des données des requetes SQL par les variables de session et création d'une unique variable pour la création du tableau
$effectif = array($bovin,$bearnaise,$bordelaise,$marine,$equin,$plandais,$ovin,$mlandais,$sasi);


///////////////////////////////////////////Affichage des pages PDF ///////////////////////////////////////////////////


//écriture des pages PDF
$pdf = new PDF();

//Taille des colonnes
$largeur_col = 150/(count($header)-1); //taille des colonnes des années adaptatives en fonction du nombre d'années
$largeur_lgd = 40;

//Page des tableaux
$pdf->AliasNbPages(); //nécessaire pour afficher le nombre de pages
$pdf->AddPage();
$pdf->SetFont('');

//Tableau d'évolution des effectifs inventories dans la race
$pdf->Tableau($header,$effectif,$largeur_col,$largeur_lgd);

//Espace entre les différents éléments de la page
$pdf->Ln(10);

// Page des graphiques
$pdf->AddPage();
//Graphique d'évolution des effectifs des races
$pdf->Image('../../graph/EvoEffBovins.png',20,60,-90);
$pdf->AddPage();
$pdf->Image('../../graph/EvoEffEquin.png',20,60,-90);
$pdf->AddPage();
$pdf->Image('../../graph/EvoEffovins.png',20,60,-90);

//Espace entre les différents éléments de la page
$pdf->Ln();

//affichage et sauvegarde du fichier en pdf

for($i=1;$i<=2;$i++)
	{
	    if($i==1)
	    {
		//sauvegarde du fichier
		$pdf->Output('../../exportation/pdf/fiche_race_globale.pdf','F');
	    }
	    else
	    {
		//affichage du fichier
		$pdf->Output();
	    }
    }

?>
