<?php
//cette page à pour but de coder l'exportation en pdf de l'export Fiche Race globales. Cet export est composé d'un tableau et de 3 graphiques
//élève référent : Amaury Branthomme

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

// Chargement des données
function LoadData($file)
{
	// Lecture des lignes du fichier
	$lines = file($file);
	$data = array();
	foreach($lines as $line)
		$data[] = explode(';',trim($line));
	return $data;
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

function OpenTag($tag, $attr)
{
	// Balise ouvrante
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,true);
	if($tag=='A')
		$this->HREF = $attr['HREF'];
	if($tag=='BR')
		$this->Ln(5);
}

function CloseTag($tag)
{
	// Balise fermante
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,false);
	if($tag=='A')
		$this->HREF = '';
}

function SetStyle($tag, $enable)
{
	// Modifie le style et sélectionne la police correspondante
	$this->$tag += ($enable ? 1 : -1);
	$style = '';
	foreach(array('B', 'I', 'U') as $s)
	{
		if($this->$s>0)
			$style .= $s;
	}
	$this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
	// Place un hyperlien
	$this->SetTextColor(0,0,255);
	$this->SetStyle('U',true);
	$this->Write(5,$txt,$URL);
	$this->SetStyle('U',false);
	$this->SetTextColor(0);
}


//Fonction réalisant le tableau
function Tableau_inv($header,$effectif,$largeur_col,$largeur_lgd)
{
    // Couleurs, épaisseur du trait et police grasse pour l'entete
	$this->SetFillColor(133,195,43);
	$this->SetTextColor(0);
	$this->SetDrawColor(0,0,0); //couleur des lignes du tableau
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
    
	// En-tête
	foreach($header as $col)
        if (is_numeric($col))
            $this->Cell($largeur_col,7,$col,1,0,'C',true);
        else
            $this->Cell($largeur_lgd,7,$col,1,0,'C',true); //Si la case est la légende, on applique un style particulier
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
                $this->SetFontSize(13);
                $this->Cell($largeur_col,6,$col,'LR',0,'C');
            }
            else//Si la case est la légende, on applique un style particulier
            {
                // Restauration des couleurs et de la police pour les données du tableau
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('');
                $this->SetFontSize(8);
                $this->Cell($largeur_lgd,6,$col,'LR',0,'C'); 
            }
        }
		$this->Ln();
	}
    // Trait de terminaison
	$this->Cell($largeur_lgd+(count($header)-1)*$largeur_col,0,'','T'); //trait pour fermer le tableau

}

function Tableau_presence($header,$effectif,$largeur_col)
{
    // Couleurs, épaisseur du trait et police grasse pour l'entete
	$this->SetFillColor(133,195,43);
	$this->SetTextColor(0);
	$this->SetDrawColor(0,0,0); //couleur des lignes du tableau
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
    $this->SetFontSize(7);    
    
	// En-tête
	foreach($header as $col)
        $this->Cell($largeur_col,7,$col,1,0,'C',true);
	$this->Ln();
    
    
	// Données
	foreach($effectif as $row)
	{
        foreach($row as $col)
        {
            // Restauration des couleurs et de la police pour les données du tableau
            $this->SetFillColor(224,235,255);
            $this->SetTextColor(0);
            $this->SetFont('');
            $this->SetFontSize(7);
            $this->Cell($largeur_col,6,$col,'LR',0,'C');
            
            
        }
		$this->Ln();
	}
    // Trait de terminaison
	$this->Cell(count($header)*$largeur_col,0,'','T'); //trait pour fermer le tableau

}


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
                $this->SetFontSize(13);
                $this->Cell($largeur_col,6,utf8_decode($col),'LR',0,'C');
            }
            else//Si la case est la légende, on applique un style particulier
            {
                // Restauration des couleurs et de la police pour les données du tableau
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('');
                $this->SetFontSize(9);
                $this->Cell($largeur_lgd,6,utf8_decode($col),'LR',0,'L'); 
            }
        }
		$this->Ln();
	}
    // Trait de terminaison
	$this->Cell($largeur_lgd+(count($header)-1)*$largeur_col,0,'','T'); //trait pour fermer le tableau
    

}

}




///////////////////////////////////////////fin des fonctions ///////////////////////////////////////////////////

//écriture des pages PDF
$pdf = new PDF();

// Titres des colonnes des tableaux
//création de l'entete des années
$header = array();
array_push($header,NULL);       //ajout d'un champ NULL en début des années pour laisser place à la légende
for($i=0;$i<count($annee);$i++) 
    array_push($header,$annee[$i]);   



// Données des requetes SQL
$effectif = array($bovin,$bearnaise,$bordelaise,$marine,$equin,$plandais,$ovin,$mlandais,$sasi);


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
//$pdf->Image('../../graph/EvoEffBovins.png',7,100,-80);
//$pdf->Image('../../graph/EvoEffEquin.png',7,100,-80);
//$pdf->Image('../../graph/EvoEffovins.png',7,100,-80);

//Espace entre les différents éléments de la page
$pdf->Ln();

$pdf->Output();
?>
