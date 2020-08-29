<<<<<<< HEAD
<?php

try{
   $pdo = new PDO('mysql:host=localhost;dbname=cgt_pos_db','root','');

 
}catch(PDOException $f){
    echo $f->getmessage();
    
}

=======
<?php

try{
   $pdo = new PDO('mysql:host=localhost;dbname=cgt_pos_db','root','');

 
}catch(PDOException $f){
    echo $f->getmessage();
    
}

>>>>>>> a8fc3c8ecc2a11219ab40491787a313f97731dec
?>