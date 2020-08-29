<?php
include_once'dbconnect.php';
$id = $_GET["id"];
$select = $pdo->prepare("select * from tb_product where p_id = :ppid");
$select->bindParam(":ppid",$id);
$select->execute();
$row = $select->fetch(PDO::FETCH_ASSOC);
$respone=$row;
header('Content-Type: application/json');
echo json_encode($respone);
?>
