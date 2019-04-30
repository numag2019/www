<?php
//cette page � pour but de coder l'exportation en pdf de l'export Fiche Race. Cet export est compos� de 3 tableaux et de 2 graphiques
//�l�ve r�f�rent : Amaury Branthomme
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

// Chargement des donn�es
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
	// Modifie le style et s�lectionne la police correspondante
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

// Tableau color�
function FancyTable($header, $data)
{
	// Couleurs, �paisseur du trait et police grasse
	$this->SetFillColor(255,0,0);
	$this->SetTextColor(255);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
	// En-t�te
	$w = array(35, 35, 35, 35, 35); //d�fini la taille des cellules des entetes
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',true); //affiche les cellules des entetes
	$this->Ln();
	// Restauration des couleurs et de la police
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	$this->SetFont('');
	// Donn�es
	$fill = false;
	foreach($data as $row)
	{
		$this->Cell($w[0],6,$row[0],'LR',0,'C',$fill);
		$this->Cell($w[1],6,$row[1],'LR',0,'C',$fill);
		$this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
		$this->Cell($w[3],6,$row[3],'LR',0,'C',$fill);
        $this->Cell($w[4],6,$row[4],'LR',0,'C',$fill);
		$this->Ln();
		$fill = !$fill;
	}
	// Trait de terminaison
	$this->Cell(array_sum($w),0,'','T');
}


//Fonction r�alisant le tableau
function Tableau_inv($header,$effectif,$largeur_col,$largeur_lgd)
{
    // Couleurs, �paisseur du trait et police grasse pour l'entete
	$this->SetFillColor(255,0,0);
	$this->SetTextColor(0);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
    
	// En-t�te
	foreach($header as $col)
        if (is_numeric($col))
            $this->Cell($largeur_col,7,$col,1,0,'C',true);
        else
            $this->Cell($largeur_lgd,7,$col,1,0,'C',true); //Si la case est la l�gende, on applique un style particulier
	$this->Ln();
    
    
	// Donn�es
	foreach($effectif as $row)
	{
        foreach($row as $col)
        {
            if (is_numeric($col))
            {
                // Restauration des couleurs et de la police pour les donn�es du tableau
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('');
                $this->SetFontSize(13);
                $this->Cell($largeur_col,6,$col,'LR',0,'C');
            }
            else//Si la case est la l�gende, on applique un style particulier
            {
                // Restauration des couleurs et de la police pour les donn�es du tableau
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
    // Couleurs, �paisseur du trait et police grasse pour l'entete
	$this->SetFillColor(255,0,0);
	$this->SetTextColor(0);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
    $this->SetFontSize(7);    
    
	// En-t�te
	foreach($header as $col)
        $this->Cell($largeur_col,7,$col,1,0,'C',true);
	$this->Ln();
    
    
	// Donn�es
	foreach($effectif as $row)
	{
        foreach($row as $col)
        {
            // Restauration des couleurs et de la police pour les donn�es du tableau
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



//Fonction r�alisant le tableau
function Tableau_nais($header,$effectif,$largeur_col,$largeur_lgd)
{
    // Couleurs, �paisseur du trait et police grasse pour l'entete
	$this->SetFillColor(255,0,0);
	$this->SetTextColor(0);
	$this->SetDrawColor(128,0,0);
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
	foreach($effectif as $row)
	{
        foreach($row as $col)
        {
            if (is_numeric($col))
            {
                // Restauration des couleurs et de la police pour les donn�es du tableau
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('');
                $this->SetFontSize(13);
                $this->Cell($largeur_col,6,$col,'LR',0,'C');
            }
            else//Si la case est la l�gende, on applique un style particulier
            {
                // Restauration des couleurs et de la police pour les donn�es du tableau
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('');
                $this->SetFontSize(8);
                $this->Cell($largeur_lgd,6,$col,'LR',0,'C'); 
            }
        }
		$this->Ln();
	}
    

}

//Fonction r�alisant le tableau
function Tableau_nais_2($header,$effectif,$largeur_col,$largeur_lgd)
{
    // Couleurs, �paisseur du trait et police grasse pour l'entete
	$this->SetFillColor(255,0,0);
	$this->SetTextColor(0);
	$this->SetDrawColor(128,0,0);
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
	foreach($effectif as $row)
	{
        foreach($row as $col)
        {
            if (is_numeric($col))
            {
                // Restauration des couleurs et de la police pour les donn�es du tableau
                $this->SetFillColor(224,235,255);
                $this->SetTextColor(0);
                $this->SetFont('');
                $this->SetFontSize(13);
                $this->Cell($largeur_col,6,$col,'LR',0,'C');
            }
            else//Si la case est la l�gende, on applique un style particulier
            {
                // Restauration des couleurs et de la police pour les donn�es du tableau
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
}




///////////////////////////////////////////fin des fonctions ///////////////////////////////////////////////////

//�criture des pages PDF
$pdf = new PDF();

// Titres des colonnes
$header_inv_nais = array(NULL,2013,2014,2015,2016,2017);
$header_pre = array('Nom','N� id','Elevage','Sexe','Date naissance','Nom du p�re','N� id p�re','Nom de la m�re','N� id m�re','Naisseur');
$header_nais2 = array(NULL,'Nb','%','Nb','%','Nb','%','Nb','%','Nb','%');

// Donn�es des requetes SQL
$effectif = array(array('Total des femelles inventori�es',252,286,318,352,375),array('Femelles de plus de 2ans',193,209,234,253,264),array('Femelles n�es et conserv�es',38,38,42,59,56),array('Taureaux (MN)',5,8,10,12,8),array('D�tenteurs',65,75,75,82,92));
$presence = array(array('Idole',1234567890,'Pierre','F','2013-0-22','Arcachon',1234567890,'Cascaille',1234567890,'Pierre'),array('Julie',1234567890,'Pierre','F','2013-0-22','Arcachon',1234567890,'Cascaille',1234567890,'Pierre'),array('Justine',1234567890,'Pierre','F','2013-0-22','Arcachon',1234567890,'Cascaille',1234567890,'Pierre'),array('Hilda',1234567890,'Pierre','F','2013-0-22','Arcachon',1234567890,'Cascaille',1234567890,'Pierre'),array('Hermine',1234567890,'Pierre','F','2013-0-22','Arcachon',1234567890,'Cascaille',1234567890,'Pierre'));
$naissance1 = array(array('nombre de veaux n�s',118,130,141,159,164));
$naissance2 = array(array('Veaux m�les','55','46','73','56','70','50','81','51','84','51'),array('Veaux femelles','63','54','57','44','71','50','78','49','80','49'));

//Page des tableaux
$pdf->AliasNbPages(); //n�cessaire pour afficher le nombre de pages
$pdf->AddPage();
$pdf->SetFont('');

//Tableau d'�volution des effectifs inventories dans la race
$pdf->Tableau_inv($header_inv_nais,$effectif,30,40);

//Espace entre les diff�rents �l�ments de la page
$pdf->Ln(10);

//Tableau d'�volution des naissances
$pdf->Tableau_nais($header_inv_nais,$naissance1,30,40);
$pdf->Tableau_nais_2($header_nais2,$naissance2,15,40);

//Espace entre les diff�rents �l�ments de la page
$pdf->Ln(10);

//Tableau d'�volution de la pr�sence dans la race
$pdf->Tableau_presence($header_pre,$presence,19);

// Page des graphiques
$pdf->AddPage();

//Graphique d'�volution des effectifs
$pdf->Cell(70,120,'Graphique',1,0,'C');

//Graphique d'�volution des naissances
$pdf->Cell(70,120,'Graphique',1,0,'C');

$pdf->Output();
?>