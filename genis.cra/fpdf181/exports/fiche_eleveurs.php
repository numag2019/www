<?php
//Page réalisé par l'équipe NumAg 2018-2019
// Cette page à pour but de coder l'exportation en pdf de l'export Fiche eleveurs contenant l'ensemble des informations 
// des eleveurs. Cet export est composé d'un unique tableau.
//élève référent : Amaury Branthomme

//Commentaires : J'ai du utiliser la fonction utf8_decode car cette page est en lien avec une page où les données sont en UTF8

/////////////////////////////////////////// Initialisation ///////////////////////////////////////////////////

session_start();

// Récupération des variables de session
$resultat = $_SESSION['resultat_ele'] ;
$resultat_req = $_SESSION['resultat2'] ;
$race = $_SESSION['race_ele'];
$annee_ele = $_SESSION['annee_ele'];

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
    $race = $_SESSION['race_ele'];
    $annee_ele = $_SESSION['annee_ele'];
	//Logo
	$this->Image('logo.jpg',10,6,30,0,'','http://racesaquitaine.fr/');
	//Police Arial gras 15
	$this->SetFont('Arial','B',15);
	//Décalage à droite
	$this->Cell(80);
	//Titre
	$this->Cell(120,10,utf8_decode('Liste des éleveurs de ').$race.' en '.$annee_ele,0,0,'L');
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

//Fonction réalisant le tableau des informations des eleveurs
function Tableau_ele($header,$effectif,$largeur_col)
{
    //Titre
    // Couleurs, épaisseur du trait et police pour le titre
	$this->SetFillColor(133,195,43);
	$this->SetTextColor(0);
	$this->SetDrawColor(0,0,0); //couleur des lignes du tableau
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
    $this->SetFontSize(12);
    
    $this->Cell($largeur_col,7,utf8_decode('Informations sur les éleveurs'));
    $this->Ln();
    
    // Couleurs, épaisseur du trait et police grasse pour l'entete
	$this->SetFillColor(133,195,43); //couleur du fond des cases
	$this->SetTextColor(0); //couleur du texte
	$this->SetDrawColor(0,0,0); //couleur des lignes du tableau
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
    $this->SetFontSize(7);    
    
	// En-tête
	foreach($header as $col)
        $this->Cell($largeur_col,7,utf8_decode($col),1,0,'C',true);
	$this->Ln();
    
    
	// Données
    
	foreach($effectif as $row)//on parcourt l'ensemble des lignes
	{
        foreach($row as $col)//on parcourt l'ensemble des elements de la ligne
        {

            if (strlen($col)>25) //modification de la taille de la police en fonction de la taille des chaines de caractère
            {
            // Restauration des couleurs et de la police pour les données du tableau
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('');
                $this->SetFontSize(5);
                $this->Cell($largeur_col,6,utf8_decode($col),'LR',0,'C');
            }
            elseif(strlen($col)>16 and strlen($col)<=25)
            {
            // Restauration des couleurs et de la police pour les données du tableau
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('');
                $this->SetFontSize(7);
                $this->Cell($largeur_col,6,utf8_decode($col),'LR',0,'C');  
            }
            else
            {
                // Restauration des couleurs et de la police pour les données du tableau
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('');
                $this->SetFontSize(10);
                $this->Cell($largeur_col,6,utf8_decode($col),'LR',0,'C');                 
            }
        }
		$this->Ln();
	}
    
        // Trait de terminaison
	$this->Cell(count($header)*$largeur_col,0,'','T'); //trait pour fermer le tableau

}
}

///////////////////////////////////////////Modifications des données pour remplir les tableaux ///////////////////////////////////////////////////

//création de l'entete
$header = array('N°','Nom','Prénom','Adresse','N° fixe','N° portable','Adresse mail','Département');


// Suppression de la colonne contenant la 2e adresse car elle n'est pas utilisée

$resultat_4 = array();

for($i=0;$i<count($resultat);$i++) 
{
    $k = 0;
    for($j=0;$j<count($resultat[0]);$j++)
    {
        if($j!=4)
        {
            $resultat_4[$i][$k] = $resultat[$i][$j];
            $k++;
        }
        
    }   
   
}

///////////////////////////////////////////Affichage des pages PDF ///////////////////////////////////////////////////
//Taille des colonnes
$largeur_col = 242/(count($header)-1); //taille des colonnes adaptatives en fonction du nombre d'informations.

//création des pages pdf
$pdf = new PDF();
$pdf->AliasNbPages(); //nécessaire pour afficher le nombre de pages
$pdf->AddPage('L');//pour afficher le pdf en paysage
$pdf->Tableau_ele($header,$resultat_4,$largeur_col);



//affichage et sauvegarde du fichier en pdf

for($i=1;$i<=2;$i++)
	{
	    if($i==1)
	    {
		//sauvegarde du fichier
		// $pdf->Output('../../pdf/fiche_eleveur_'.$race.'.pdf','F');
        $pdf->Output('../../pdf/fiche_eleveur_'.$race.'_'.$annee_ele.'.pdf','F'); //Pour afficher l'année dans le titre des pdf
	    }
	    else
	    {
		//affichage du fichier
		$pdf->Output();
	    }
    }

?>