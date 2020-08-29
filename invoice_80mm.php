<?php
//call the FPDF library
require ('f-PDF/fpdf.php');  //location
//Importing Font and it's variations
include_once 'dbconnect.php';

$id=$_GET['id'];

$select = $pdo->prepare("select * from tb_invoice where invoice_id=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$pdf = new FPDF('P','mm',array(80,200));

//Add new page

$pdf->AddPage();

$pdf->SetFont('Arial','B',12);

$pdf->cell(65,8,'CHORN GLORY Co,Ltd',1,1,'C',);

$pdf->SetFont('Arial','B',14);

$pdf->SetFont('Arial','B',10);
$pdf->cell(65,10,'Tel: +855 93 322 168',0,0,'C',);
$pdf->SetFont('Arial','B',12);
$pdf->cell(65,7,'Invoice No ',0,1,'C',);

$pdf->SetFont('Arial','B',10);
$pdf->cell(65,5,'Email: chtouch@yahoo.com',0,1,'C',);

$pdf->SetFont('Arial','B',10);
$pdf->cell(65,5,'Website:  www.Chornglory.com',0,1,'C',);

$pdf->line(6,38,75,38);
$pdf->Ln(5);  //line break

$pdf->SetFont('Arial','BI',10);
$pdf->cell(20,10,'Bill To : ',0,0,'L',);

$pdf->SetFont('courier','B',10);
$pdf->cell(40,10,$row->customer_name,0,1,'C',);

$pdf->SetFont('Arial','',9);
$pdf->cell(20,4,'Invoice No ',0,0,'L',);

$pdf->SetFont('Arial','',9);
$pdf->cell(40,4,$row->invoice_id,0,1,'L',);

$pdf->SetFont('Arial','',9);
$pdf->cell(20,4,'Date ',0,0,'L',);

$pdf->SetFont('Arial','',9);
$pdf->cell(40,4,$row->order_date,0,1,'L',);

$pdf->Ln(2);  //line break

$pdf->SetX(7);
$pdf->SetFont('Courier','B',8);

$pdf->cell(34,5,'Product',1,0,'C','');
$pdf->cell(11,5,'QTY',1,0,'C','');
$pdf->cell(8,5,'PRC',1,0,'C','');
$pdf->cell(12,5,'Total',1,1,'C','');

$select = $pdo->prepare("select * from tb_invoice_detail where invoice_id=$id");
$select->execute();
while($item = $select->fetch(PDO::FETCH_OBJ))
{

  $pdf->SetX(7);
  $pdf->SetFont('Courier','B',8);
  $pdf->cell(34,5,$item->product_name,1,0,'L',);
  $pdf->cell(11,5,$item->qty,1,0,'C',);
  $pdf->cell(8,5,$item->price,1,0,'C',);
  $pdf->cell(12,5,$item->price * $item->qty ,1,1,'C',);
}




$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->cell(25,5,'',0,0,'L',);
$pdf->cell(20,5,'Sub-Total',1,0,'C',);
$pdf->cell(20,5,$row->sub_total,1,1,'C',);

$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->cell(25,5,'',0,0,'L',);
$pdf->cell(20,5,'Tax',1,0,'C',);
$pdf->cell(20,5,$row->sub_total,1,1,'C',);

$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->cell(25,5,'',0,0,'L',);
$pdf->cell(20,5,'Discount',1,0,'C',);
$pdf->cell(20,5,$row->discount,1,1,'C',);

$pdf->SetX(7);
$pdf->SetFont('courier','B',10);
$pdf->cell(25,5,'',0,0,'L',);
$pdf->cell(20,5,'Total',1,0,'C',);
$pdf->cell(20,5,$row->total,1,1,'C',);

$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->cell(25,5,'',0,0,'L',);
$pdf->cell(20,5,'Paid',1,0,'C',);
$pdf->cell(20,5,$row->paid,1,1,'C',);

$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->cell(25,5,'',0,0,'L',);
$pdf->cell(20,5,'Due',1,0,'C',);
$pdf->cell(20,5,$row->due,1,1,'C',);

$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->cell(25,5,'',0,0,'L',);
$pdf->cell(20,5,'Payment',1,0,'C',);
$pdf->cell(20,5,$row->payment_type,1,1,'C',);

$pdf->SetFont('Arial','',8);
$pdf->cell(25,5,'',0,1,'',);
$pdf->cell(25,5,'IMPORTANT NOTICE',0,1,'',);
$pdf->SetFont('Arial','',5);
$pdf->cell(75,5,'No refunded',0,1,'',);

//$select = $pdo->prepare("select * from tb_invoice_detail where invoice_id=$id");
//$select->execute();
//while($item = $select->fetch(PDO::FETCH_OBJ))
//{
//  $pdf->SetFont('Arial','B',10);
//  $pdf->cell(100,10,$item->product_name,1,0,'L',);
//  $pdf->cell(30,10,$item->qty,1,0,'C',);
//  $pdf->cell(30,10,$item->price,1,0,'C',);
//  $pdf->cell(35,10,$item->price * $item->qty ,1,1,'C',);
//}
//

//Out-Put the result

$pdf->Output();
?>
