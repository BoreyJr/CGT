<?php

include_once 'dbconnect.php';
session_start();

if($_SESSION['user_email']=="" OR $_SESSION['role'] !="admin"){
    header('location:index.php');
}
include_once 'header.php';

error_reporting(0);

$id=$_GET['id'];

$delete = $pdo->prepare("delete from tb_user where user_id=".$id);
if($delete->execute())
{
     echo '<script type="text/javascript"> jQuery(function validation(){
        swal({
  title: "Deleted",
  icon: "success",
   text: "Account has been deleted  🤣 ",
  
  button: "OK !",
});   
        });
        
        </script>';   
}
else
{
//      echo '<script type="text/javascript"> jQuery(function validation(){
//        swal({
//  title: "Error ",
//  icon: "warning",
//   text: "Something went wrong  🤣 ",
//  
//  button: "OK !",
//});   
//        });
//        
//        </script>';   
}

if(isset($_POST['btncreate']))
{
  
$username=$_POST['txtuname'];
$useremail=$_POST['txtemail'];
$pw = $_POST['txtpw'];
$role = $_POST['select_opt'];
//echo $username."-".$useremail."-".$pw."-".$role;
    $img = 'imageUrl: "https://media.tenor.com/images/17e91cf2991314dd78eecec4668476a0/tenor.gif",';
$select = $pdo->prepare("select user_email from tb_user where user_email='$useremail'");
    $select->execute();
    
    if($select->rowCount() > 0 ){
       echo '<script type="text/javascript"> jQuery(function validation(){
        swal({
  title: "This E-mail already exist ! ",
  icon: "warning",
   text: "Please Try Another Email  🤣 ",
  
  button: "OK !",
});   
        });
        
        </script>';   
    }
    else{
$insert = $pdo->prepare("insert into tb_user(username,user_email,password,role) values (:name,:email,:pw,:role)");
$insert->bindParam(':name',$username);
$insert->bindParam(':email',$useremail);
$insert->bindParam(':pw',$pw);
$insert->bindParam(':role',$role);   
        if($insert->execute()){
       echo '<script type="text/javascript"> jQuery(function validation(){
        swal({
  title: "Created !",
   text: "Account has been created !🤣",
  icon: "success",
  button: "OK !",
});   
        });
        
        </script>';
}
else{
          echo '<script type="text/javascript"> jQuery(function validation(){
        swal({
  title: "Something went wrong ! ",
   text: "Please Try Again  🤣",
  icon: "error",
  button: "OK !",
});   
        });
        
        </script>';   
}

    }
    

}
?>
  <!-- Content Wrapper. Contains page content -->
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
      <div class="row">
       <div class="col-md-4">
        <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Create a new account</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="" method="post">
                <div class="card-body">
                 <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter username" required name="txtuname">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" required name="txtemail" placeholder="Enter email">
                  </div>
                   <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" class="form-control" id="exampleInputEmail1" required name="txtpw" placeholder="Enter password">
                  </div>
                   <div class="form-group">
                    <label for="exampleInputEmail1">Role:</label>
                   <select class="form-control" name="select_opt">
                      <option value="" disabled selected>Select role of account</option>
                      <option>user</option>
                       <option>admin</option>
                       
                   </select>
                  </div>
                
                 
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="btncreate" class="btn btn-info btn-block">Create</button>
                </div>
                </div>
              </form>
            </div>
            </div>
            <div class="col-md-8">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $select=$pdo->prepare("select * from tb_user order by user_id desc");
                        
                        $select->execute();
                        
                        while($row=$select->fetch(PDO::FETCH_OBJ)){
                            echo '<tr>
                            <td>'.$row->user_id.'</td>
                            <td>'.$row->username.'</td>
                            <td>'.$row->user_email.'</td>
                            <td>'.$row->role.'</td>  
                            <td><a class="btn btn-danger" role="button" href="register.php?id='.$row->user_id.'"><i title="delete" class="fas fa-trash"></i></td>
                            </tr>';
                        }
                        
                        ?>
                    </tbody>
                </table>
            </div>
      </div><!-- /.container-fluid -->
      </div>
    </div>
</div>
<?php
@include_once 'footer.php';
?>

