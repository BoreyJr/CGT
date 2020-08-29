<?php

try{
   $pdo = new PDO('mysql:host=localhost;dbname=cgt_pos_db','root','');

 
}catch(PDOException $f){
    echo $f->getmessage();
    
}

?>