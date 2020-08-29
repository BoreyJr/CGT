<?php

include_once 'dbconnect.php';
session_start();


if($_SESSION['user_email']==""){
    header('location:index.php');
}
//when click on update password btn, we got the values from the user into variable
if(isset($_POST['btnupdate'])){
    
    $oldpw_txt = $_POST['oldpw'];
    $newpw_txt = $_POST['newpw'];
    $confirmpw_txt = $_POST['confirmpw'];
    $new_username = $_POST['username'];
    
//    echo $oldpw_txt."-".$newpw_txt."-".$confirmpw_txt;
    

//using of select query to get out dtabase record according to user-email 
$email=$_SESSION['user_email'];
$select = $pdo->prepare("select * from tb_user where user_email='$email'");

$select->execute();
$row = $select->fetch(PDO::FETCH_ASSOC);

$user_email_db = $row['user_email'];
$password_db = $row['password'];
$username_db = $row['username'];
//echo $row['user_email'];
//echo $row['username'];

//we compare user input and database values
$empty = NULL;
if($password_db == $oldpw_txt)
{
    if($newpw_txt == $confirmpw_txt && $newpw_txt != $empty){
        $update = $pdo->prepare("update tb_user set password=:password where user_email=:email");
        
        $update->bindParam(':password',$confirmpw_txt);
//        $update->bindParam(':username',$new_username);
        $update->bindparam(':email',$email);
        if($update->execute())
         echo '<script type="text/javascript"> jQuery(function validation(){
        swal({
  title: "Password Updated",
   text: "Success !🤣",
  icon: "success",
  button: "OK !",
});   
        });
        
        </script>';
        else
        {
            echo '<script type="text/javascript"> jQuery(function validation(){
        swal({
  title: "Password Updated Fail Password",
   text: "Please Try Again  🤣",
  icon: "error",
  button: "OK !",
});   
        });
        
        </script>';
        }
            
    }
    else{
         echo '<script type="text/javascript"> jQuery(function validation(){
        swal({
  title: "Current Password incorrect",
   text: "Please Try Again  🤣",
  icon: "error",
  button: "OK !",
});   
        });
        
        </script>';
    }
}
else{
   echo '<script type="text/javascript"> jQuery(function validation(){
        swal({
  title: "Incorrect old Password",
   text: "Please Try Again  🤣",
  icon: "error",
  button: "OK !",
});   
        });
        
        </script>';
}
    

//if values matched then we run update query 
}
if($_SESSION['role']=="admin"){
  include_once'header.php';
}else if ($_SESSION['role']=="user"){
  include_once'headeruser.php';
}

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Account Setting</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="" method="post">
                <div class="card-body">
                 <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?php 
              echo $_SESSION['username'];
              ?>" name="username">
                  </div>
<!--
                  <div class="form-group">
                    <label for="exampleInputEmail1">Change Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                  </div>
-->
                 
                  <h4 class="text-center">Password</h4>
                  <div class="form-group">
                    <label for="exampleInputPassword1" >Old Password</label>
                    <input type="text" name="oldpw" required class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1" >New Password</label>
                    <input type="password" name="newpw" class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" name="confirmpw"  class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div>
                 
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="btnupdate" class="btn btn-primary btn-block">Submit</button>
                </div>
                </div>
              </form>
            </div>
      </div><!-- /.container-fluid -->
    </div>
</div>
    
<?php
include_once 'footer.php';
?>

