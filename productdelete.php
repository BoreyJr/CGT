<?php

include_once 'dbconnect.php';
session_start();
if ($_SESSION['user_email'] == "" or $_SESSION['role'] != "admin") {
  header('location:index.php');
}

$id = $_POST['piid'];

$sql = "delete from tb_product where p_id = $id";

$delete = $pdo->prepare($sql);

if($delete->execute())
{

}
else{
  echo 'error in delete';
}
?>
