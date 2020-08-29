<?php
//call the FPDF library
require ('f-PDF/fpdf.php');  //location
//Importing Font and it's variations

//$fpdf->AddFont('Gotham','B','Gotham-Book-bold.php'); //Bold
//$fpdf->AddFont('Gotham','I','Gotham-Book-italic.php'); //Italic
//$fpdf->AddFont('Gotham','BI','Gotham-Book-bold-italic.php'); //Bold_Italic

//A4 with : 219 mm

//default margin : 10 mm each side

//writable horizontal : 219-(10*2)

//create PDF object

$pdf = new FPDF('P','mm','A4');
//$pdf->AddFont('KhmerOS Siemreap','B','KhmerOSSiemreap.php'); //Bold
//$fpdf->AddFont('Gotham','B','Gotham-Book-bold.php'); //Bold
//$fpdf->AddFont('Gotham','I','Gotham-Book-italic.php'); //Italic
//$fpdf->AddFont('Gotham','BI','Gotham-Book-bold-italic.php'); //Bold_Italic
// String orientation (P or L) - P for portrait / L for landscape

//String unit (pt,mm,cm and in)

//Mixed format (A3, A4 , A5 , Letter


//Add new page

$pdf->AddPage();
//$pdf->SetFillColor(123,255,235);
$pdf->SetFont('Arial','B',16);

$pdf->cell(80,10,'CHORN GLORY Co,Ltd',0,0,'l',);

$pdf->SetFont('Arial','B',14);
$pdf->cell(80,9,'INVOICE',0,1,'R',);


$pdf->SetFont('Arial','',10);
$pdf->cell(80,5,'Tel: +855 93 322 168',0,0,'',);
$pdf->SetFont('Arial','',12);
$pdf->cell(140,5,'Invoice No #928',0,1,'C',);

$pdf->SetFont('Arial','',10);
$pdf->cell(80,5,'Email: chtouch@yahoo.com',0,0,'',);
$pdf->SetFont('Arial','',12);
$pdf->cell(140,5,'Date : 27/08/2000',0,1,'C',);
$pdf->SetFont('Arial','',10);
$pdf->cell(80,5,'Website:  www.Chornglory.com',0,1,'',);

$pdf->SetFont('Arial','',12);

$pdf->line(5,45,205,45);
$pdf->line(5,46,205,46);

$pdf->Ln(15);  //line break

$pdf->SetFont('Arial','BI',12);
$pdf->cell(20,10,'Bill To : ',0,0,'C',);

$pdf->SetFont('Arial','B',12);
$pdf->cell(50,10,'Customer Name',0,1,'C',);

$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(208,208,208);
$pdf->cell(100,10,'Product',1,0,'C','true');
$pdf->cell(30,10,'Quantity',1,0,'C','true');
$pdf->cell(30,10,'Price',1,0,'C','true');
$pdf->cell(35,10,'Total',1,1,'C','true');

$pdf->SetFont('Arial','B',10);
$pdf->cell(100,10,'APA Doxy',1,0,'L',);
$pdf->cell(30,10,'100',1,0,'C',);
$pdf->cell(30,10,'20',1,0,'C',);
$pdf->cell(35,10,'200',1,1,'C',);


$pdf->cell(100,10,'',0,0,'L',);
$pdf->cell(30,10,'',0,0,'C',);
$pdf->cell(30,10,'Subtotal',1,0,'C',);
$pdf->cell(35,10,'',1,1,'C',);

$pdf->cell(100,10,'',0,0,'L',);
$pdf->cell(30,10,'',0,0,'C',);
$pdf->cell(30,10,'Tax',1,0,'C',);
$pdf->cell(35,10,'',1,1,'C',);

$pdf->cell(100,10,'',0,0,'L',);
$pdf->cell(30,10,'',0,0,'C',);
$pdf->cell(30,10,'Discount',1,0,'C',);
$pdf->cell(35,10,'',1,1,'C',);

$pdf->cell(100,10,'',0,0,'L',);
$pdf->cell(30,10,'',0,0,'C',);
$pdf->cell(30,10,'Grand-Total',1,0,'C',);
$pdf->cell(35,10,'',1,1,'C',);

$pdf->cell(100,10,'',0,0,'L',);
$pdf->cell(30,10,'',0,0,'C',);
$pdf->cell(30,10,'Piad',1,0,'C',);
$pdf->cell(35,10,'',1,1,'C',);

$pdf->cell(100,10,'',0,0,'L',);
$pdf->cell(30,10,'',0,0,'C',);
$pdf->cell(30,10,'Due',1,0,'C',);
$pdf->cell(35,10,'',1,1,'C',);

$pdf->cell(100,10,'',0,0,'L',);
$pdf->cell(30,10,'',0,0,'C',);
$pdf->cell(30,10,'Payment',1,0,'C',);
$pdf->cell(35,10,'',1,1,'C',);

$pdf->SetFont('Arial','',8);

$pdf->cell(37,10,'IMPORTANT NOTICE',0,0,'',);

$pdf->cell(35,10,'No refunded',0,1,'C',);

//Out-Put the result

$pdf->Output();
?>
