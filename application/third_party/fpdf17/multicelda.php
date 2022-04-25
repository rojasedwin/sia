<?php
define('FPDF_ROOT', dirname(__FILE__) . '/');
require(APPPATH.'third_party/fpdf17/fpdf.php');



class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;

function Header()
{

$this->SetFont('Arial','',14);
if(file_exists('attachments/diplomas_resources/imagen_fondo_diploma.jpg'))
  $this->Image('attachments/diplomas_resources/imagen_fondo_diploma.jpg',0,0,300);
}

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
		if($data[$i][0]=="-")
		{
			$valor = substr ($data[$i], 1, strlen($data[$i]));
			$cont = 1;
			for($im=0;$im<$valor;$im++)
			{

			if($cont<5)
			$this->Image('../../gif/uncheck.png',(1+$this->GetX()+$im*5),$this->GetY()+1,5,5,null,null);
			else
			$this->Image('../../gif/uncheck.png',(1+$this->GetX()+$im*5 -20),$this->GetY()+7,5,5,null,null);
			$cont++;
			}
			//$this->MultiCell($w,5,$valor,0,$a);


		}	//$this->Image('../../gif/check.png',0,4,15);
		else
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function Row2($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=10*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
		$this->SetFillColor(255,255,255);
		if($i==2 and strpos( $data[$i], '%' ))
		{
			if($data[$i]>100)
				$this->SetFillColor(102,255,153);
			elseif($data[$i]>70)
				$this->SetFillColor(255,255,0);
			elseif($data[$i]>50)
				$this->SetFillColor(255,153,51);
			else
				$this->SetFillColor(255,0,0);
        $this->MultiCell($w,10,$data[$i],1,$a,true);
		}
		elseif($i==1 and $data[$i]!="Ritmo Semanal")
		{
		$this->SetFillColor(191,223,255);
		$this->MultiCell($w,10,$data[$i],1,$a,true);
		}
		else
		$this->MultiCell($w,10,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
		$this->SetFillColor(255,255,255);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
function Footer()
{
    /*// Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

	*/
}

}
?>
