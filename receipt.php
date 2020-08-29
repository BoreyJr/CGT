<?php 
include_once 'dbconnect.php';
$id = $_GET["id"];

$select = $pdo->prepare("select * from tb_invoice where invoice_id=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$select_tb_invoice_detail = $pdo->prepare("select * from tb_invoice_detail where invoice_id=$id");
$select_tb_invoice_detail->execute();
$row_tb_invoice_detail = $select_tb_invoice_detail->fetch(PDO::FETCH_OBJ);

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt of Sale : <?php echo $id;?></title>
    <link type="text/css" rel="stylesheet" href="asset/receipt.css"
    media="all">
    <link type="text/css" rel="stylesheet" href="asset/no-print.css"
    media="print">
</head>
<body>
<div id="wrapper">
<div id="receipt-header">
<h2 >ក្រុមហ៊ុន ចន គ្លរ រី ត្រេតឌីង</H2>
<h3 id="resturant-name">CGT Co,LTD</h3>
<p>Address: street 271 #12c </p>
<p>Hengly Market, Phnom Penh</p>
<p>Tel: +855 93 322 168</p>
<p>Bill To Customer: <strong><u><?php echo $row->customer_name; ?> </u></strong></p>
<p>Rerference Receipt: <strong><?php echo $id;?></strong></p>
</div>
<div id="receipt-body"></div>
<table class="tb-sale-detail">
<thead>
<tr>
<th>#</th>
<th>Menu</th>
<th>Quantity</th>
<th>Price</th>
<th>Menu</th>
</tr>
</thead>
<tbody>

<tr>
<td width="30"><?php echo $row_tb_invoice_detail->invoice_id; ?></td>
<td width="180"><?php echo $row_tb_invoice_detail->product_name; ?></td>
<td width="50"><?php echo $row_tb_invoice_detail->qty; ?></td>
<td width="55"><?php echo $row_tb_invoice_detail->price; ?></td>
<td width="65"><?php echo $row_tb_invoice_detail->qty * $row_tb_invoice_detail->price; ?></td>
</tr>

</tbody>
</table>

<table class="tb-sale-total">
<tbody>
<tr>
<td>Total Quantity</td>
<td><?php echo $row_tb_invoice_detail->qty; ?> </td>
<td>Total</td>
<td>$ <?php echo $row->total; ?></td>
</tr>
<tr>
<td colspan="2">Discount</td>
<td colspan="2">$ <?php echo $row->discount; ?></td>
</tr>
</tr>
<tr>
<td colspan="2">Tax</td>
<td colspan="2">$ <?php echo $row->tax; ?></td>
</tr>
<tr>
<td colspan="2">Total Amount</td>
<td colspan="2">$ <?php echo $row->sub_total; ?></td>
</tr>
<tr>
<td colspan="2">Change</td>
<td colspan="2">$ <?php echo $row->due; ?></td>
</tr>
</tbody>

</table>
<div id="receipt-footer">
<p>THANK YOU </p>
<div id="receipt-buttons">
<a href="/cgt_inventory_pos/orderlist.php"><button class="btn btn-print">Back</button></a>
<button class="btn btn-back" type="button" onclick="window.print(); return false;">Print</button>
</div>
</div>
</div>
    
</body>
</html>