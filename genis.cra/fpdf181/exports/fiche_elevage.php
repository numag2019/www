<?php
//Page réalisé par l'équipe NumAg 2018-2019
// Cette page à pour but de coder l'exportation en pdf de l'export Fiche elevage contenant l'ensemble des informations 
// des animaux de l'élevage choisi. Cet export est composé d'un unique tableau.
//élève référent : Amaury Branthomme

//Commentaires : J'ai du utiliser la fonction utf8_decode car cette page est en lien avec une page où les données sont en UTF8

/////////////////////////////////////////// Initialisation ///////////////////////////////////////////////////

session_start();

// Récupération des variables de session
$header = $_SESSION["elevage_entetes"];
$data = $_SESSION['array_animals'];


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
    //Récupération des variables de session
    $id = $_SESSION["id_elevage"];
    
    //Connection à la base de donnée
    $link = mysqli_connect ('127.0.0.1','root','','genis_test');
    mysqli_set_charset ($link, 'utf8mb4');
    
    //Requête pour récupérer le nom de l'elevage
    $query = "  SELECT nom_elevage
                FROM elevage
                WHERE id_elevage =".$id."";
    $result = mysqli_query($link,$query);
    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
    {
        $nom = $row[0];
    }

    
    
    $annee_debut = $_SESSION["period_start"];
    $annee_fin = $_SESSION["period_end"];
	//Logo
	$this->Image('logo.jpg',10,6,30,0,'','http://racesaquitaine.fr/');
	//Police Arial gras 15
	$this->SetFont('Arial','B',12);
	//Décalage à droite
	$this->Cell(80);
	//Titre
	$this->Cell(50,10,utf8_decode('Liste des animaux du troupeau de '.$nom.' présent entre le '.$annee_debut.' et le '.$annee_fin),0,0,'L');
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
    
    $this->Cell($largeur_col,7,utf8_decode('Informations sur les animaux'));
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


// Suppression de la première valeur de chaque sous-liste de $data car elle est vide

for($i=0;$i<count($data);$i++)
{
    array_shift($data[$i]);   
}

///////////////////////////////////////////Affichage des pages PDF ///////////////////////////////////////////////////
//Taille des colonnes
$largeur_col = 242/(count($header)-1); //taille des colonnes adaptatives en fonction du nombre d'informations.

//création des pages pdf
$pdf = new PDF();
$pdf->AliasNbPages(); //nécessaire pour afficher le nombre de pages
$pdf->AddPage('L');//pour afficher le pdf en paysage
$pdf->Tableau_ele($header,$data,$largeur_col);


//Récupération du nom de l'éleveurs
//Récupération des variables de session
    $id = $_SESSION["id_elevage"];
    
//Connection à la base de donnée
$link = mysqli_connect ('127.0.0.1','root','','genis_test');
mysqli_set_charset ($link, 'utf8mb4');

//Requête pour récupérer le nom de l'elevage
$query = "  SELECT nom_elevage
            FROM elevage
            WHERE id_elevage =".$id."";
$result = mysqli_query($link,$query);
while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
{
    $nom = $row[0];
}


//affichage et sauvegarde du fichier en pdf

for($i=1;$i<=2;$i++)
	{
	    if($i==1)
	    {
		//sauvegarde du fichier
		// $pdf->Output('../../pdf/fiche_elevage.pdf','F');
        $pdf->Output('../../pdf/fiche_elevage_'.$nom.'.pdf','F'); //Pour afficher le nom des éleveurs dans le titre des pdf
	    }
	    else
	    {
		//affichage du fichier
		$pdf->Output();
	    }
    }

?>