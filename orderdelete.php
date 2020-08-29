<?php

include_once 'dbconnect.php';
session_start();
if ($_SESSION['user_email'] == "" or $_SESSION['role'] != "admin") {
  header('location:index.php');
}

$id = $_POST['piid'];

//$sql = "delete from tb_invoice where invoice_id = $id";
$sql = "delete tb_invoice , tb_invoice_detail FROM tb_invoice INNER JOIN tb_invoice_detail ON tb_invoice.invoice_id = tb_invoice_detail.invoice_id where tb_invoice.invoice_id = $id";

$delete = $pdo->prepare($sql);

if($delete->execute())
{

}
else{
  echo 'error in delete';
}
?>
