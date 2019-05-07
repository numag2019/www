<?php
//cette page à pour but de coder l'exportation en pdf de l'export Fiche Race. Cet export est composé de 3 tableaux et de 2 graphiques
//élève référent : Amaury Branthomme

session_start();


//récupération des variables de session
$nb_femelle = $_SESSION['nb_femelle'];
$nb_femelle_2 =$_SESSION['nb_femelle_2'];
$nb_femelle_nee = $_SESSION['nb_femelle_nee'];
$nb_taureau = $_SESSION['nb_taureau'];
$nb_detenteur = $_SESSION['nb_detenteur'];
$annee = $_SESSION['annee'];
$nb_veau = $_SESSION['nb_veau'];
$nb_veau_m = $_SESSION['nb_veau_m'];
$nb_veau_f = $_SESSION['nb_veau_f'];
$resultat = $_SESSION['resultat'];

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
                $this->Cell($largeur_lgd,6,utf8_decode($col),'LR',0,'C'); 
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
        $this->Cell($largeur_col,7,utf8_decode($col),1,0,'C',true);
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
            $this->Cell($largeur_col,6,utf8_decode($col),'LR',0,'C');
            
            
        }
		$this->Ln();
	}
    // Trait de terminaison
	$this->Cell(count($header)*$largeur_col,0,'','T'); //trait pour fermer le tableau

}


//Fonction réalisant le tableau
function Tableau_nais($header,$effectif,$largeur_col,$largeur_lgd)
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
                $this->Cell($largeur_col,6,$col,'LR',0,'C');
            }
            else//Si la case est la légende, on applique un style particulier
            {
                // Restauration des couleurs et de la police pour les données du tableau
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('');
                $this->SetFontSize(8);
                $this->Cell($largeur_lgd,6,utf8_decode($col),'LR',0,'C'); 
            }
        }
		$this->Ln();
	}
    

}

//Fonction réalisant le tableau
function Tableau_nais_2($header,$effectif,$largeur_col,$largeur_lgd)
{
    // Couleurs, épaisseur du trait et police grasse pour l'entete
	$this->SetFillColor(133,195,43);
	$this->SetTextColor(0);
	$this->SetDrawColor(0,0,0);
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
                $this->Cell($largeur_col,6,$col,'LR',0,'C');
            }
            else//Si la case est la légende, on applique un style particulier
            {
                // Restauration des couleurs et de la police pour les données du tableau
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('');
                $this->SetFontSize(8);
                $this->Cell($largeur_lgd,6,utf8_decode($col),'LR',0,'C'); 
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
$header_inv_nais = array();
array_push($header_inv_nais,NULL);
for($i=0;$i<count($annee);$i++) 
    array_push($header_inv_nais,$annee[$i]);


$header_pre = array('Nom','N° id','Elevage','Sexe','Date naissance','Nom du père','N° id père','Nom de la mère','N° id mère','Naisseur');

//création de l'entete Nb et %
$header_nais2 = array();
array_push($header_nais2,NULL);
for($i=0;$i<count($header_inv_nais)-1;$i++) 
    array_push($header_nais2,"Nb","%");


// Données des requetes SQL

$effectif = array($nb_femelle, $nb_femelle_2, $nb_femelle_nee, $nb_taureau, $nb_detenteur);
$_SESSION['effectif'] = $effectif;



$naissance1 = array($nb_veau);

//Modification de la variable nb_veau_m et nb_veau_f pour ajouter les pourcentages

//création des variables contenant les pourcentages
$pourcent_veaux_m = array();
$pourcent_veaux_f = array();

for($i=1;$i<count($nb_veau);$i++)
{
    $pourcent_veaux_m[$i-1] = intval(($nb_veau_m[$i]/$nb_veau[$i])*100);
    $pourcent_veaux_f[$i-1] = intval(($nb_veau_f[$i]/$nb_veau[$i])*100);
}

//création d'une variable contenant le nombre et le pourcentage des veaux

$veaux_m =array($nb_veau_m[0]); //ajout des titres des lignes en premier element de la liste
$veaux_f =array($nb_veau_f[0]);

$j=1;

for($i=1;$i<count($nb_veau);$i++) //remplissage de la variable
{
    $veaux_m[$j] = $nb_veau_m[$i];
    $veaux_f[$j] = $nb_veau_f[$i];
    $j++;
    $veaux_m[$j] = $pourcent_veaux_m[$i-1];
    $veaux_f[$j] = $pourcent_veaux_f[$i-1];
    $j++;    
    
}

$naissance2 = array($veaux_m,$veaux_f);


// Création des variables pour la présence des animaux


$presence = array(array('Idole',1234567890,'Pierre','F','2013-0-22','Arcachon',1234567890,'Cascaille',1234567890,'Pierre'),array('Julie',1234567890,'Pierre','F','2013-0-22','Arcachon',1234567890,'Cascaille',1234567890,'Pierre'),array('Justine',1234567890,'Pierre','F','2013-0-22','Arcachon',1234567890,'Cascaille',1234567890,'Pierre'),array('Hilda',1234567890,'Pierre','F','2013-0-22','Arcachon',1234567890,'Cascaille',1234567890,'Pierre'),array('Hermine',1234567890,'Pierre','F','2013-0-22','Arcachon',1234567890,'Cascaille',1234567890,'Pierre'));


//Page des tableaux
$pdf->AliasNbPages(); //nécessaire pour afficher le nombre de pages
$pdf->AddPage();
$pdf->SetFont('');

//Taille des colonnes
$largeur_col = 150/(count($header_inv_nais)-1); //taille des colonnes des années adaptatives en fonction du nombre d'années
$largeur_lgd = 40;

//Tableau d'évolution des effectifs inventories dans la race
$pdf->Tableau_inv($header_inv_nais,$effectif,$largeur_col,$largeur_lgd);


//Graphique d'évolution des effectifs
//$pdf->Image('../../graph/EvoNbFem.png',7,100,-80);

//Page des naissances
$pdf->AddPage();
//Tableau d'évolution des naissances

$pdf->Tableau_nais($header_inv_nais,$naissance1,$largeur_col,$largeur_lgd);
$pdf->Tableau_nais_2($header_nais2,$naissance2,$largeur_col/2,$largeur_lgd);

//Graphique d'évolution des naissances
//$pdf->Image('../../graph/EvoNaissances.png',7,100,-80);


// Page d'évolution des présences dans la race
$pdf->AddPage();
//Tableau d'évolution de la présence dans la race
$pdf->Tableau_presence($header_pre,$presence,19);




$pdf->Output();
?>
