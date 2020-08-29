 <!-- jQuery -->
     <script src="plugins/jquery/jquery.min.js"></script>
     <!-- Bootstrap 4 -->
     <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
     <!-- AdminLTE App -->
     <script src="dist/js/adminlte.min.js"></script>
    <script src="plugins/swwetalert/sweetalert.min.js"></script> 
 
 <?php
include_once'dbconnect.php';
session_start();

error_reporting(0);
if(isset($_POST['btn_login']))   /// if we click the btn it will get the data from input  
{
    $useremail = $_POST['txt_email'];
    $password = $_POST['txt_password'];
    
//    echo $useremail.' '.$pasword;
    
    $select = $pdo->prepare("select * from tb_user where user_email='$useremail' AND password='$password'");
    
    $select->execute();
    
    $row = $select->fetch(PDO::FETCH_ASSOC);
    
    if($row['user_email']==$useremail AND $row['password']==$password AND $row['role'] == "admin")
    {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_email'] = $row['user_email'];
        $_SESSION['role'] = $row['role'];
//        echo $success =  'Login Success ! ';
        echo '<script type="text/javascript"> jQuery(function validation(){
        
        swal({
  title: "Login successful!",
   text: "Welcome '.$_SESSION['username'].'",
  icon: "success",
  button: "OK !",
});
        
        });
        
        </script>';
        
        header('refresh:0;dashboard.php'); //redirect to dashboard page 
        
    }
    else if($row['user_email']==$useremail AND $row['password']==$password AND $row['role'] == "user")
    {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_email'] = $row['user_email'];
        $_SESSION['role'] = $row['role'];
        
        echo '<script type="text/javascript"> jQuery(function validation(){
        
        swal({
  title: "Login successful!",
  text: "Welcome '.$_SESSION['username'].'",
  icon: "success",

});
        
        });
        
        </script>';
        
    header('refresh:2;user.php'); //redirect to user page 
    }
    else
    {
         echo '<script type="text/javascript"> jQuery(function validation(){
        
        swal({
  title: "Login Fail!",
  text: "Your username or passowrd are incorrect ",
  icon: "error",
  button: "OK",
});
        
        });
        
        </script>';
    }
}
?>
 <!DOCTYPE html>
 <html>

 <head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title>Chorn Glory | Log in</title>
     
     
 
     <!-- Tell the browser to be responsive to screen width -->
     <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- Font Awesome -->
     <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
     <!-- Ionicons -->
     <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
     <!-- icheck bootstrap -->
     <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
     <!-- Theme style -->
     <link rel="stylesheet" href="dist/css/adminlte.min.css">
     <!-- Google Font: Source Sans Pro -->
     <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
 </head>

 <body class="hold-transition login-page">
     <div class="login-box">
         <div class="login-logo">
             <a href="#"><b>Inventroy</b> CGT</a>
         </div>
         <!-- /.login-logo -->
         <div class="card">
             <div class="card-body login-card-body">
                 <p class="login-box-msg">Sign in to start your session</p>

                 <form action="#" method="post">
                     <div class="input-group mb-3">
                         <input type="email" name="txt_email" class="form-control" placeholder="Email" required>
                         <div class="input-group-append">
                             <div class="input-group-text">
                                 <span class="fas fa-envelope"></span>
                             </div>
                         </div>
                     </div>
                     <div class="input-group mb-3">
                         <input type="password" name="txt_password" class="form-control" placeholder="Password" required>
                         <div class="input-group-append">
                             <div class="input-group-text">
                                 <span class="fas fa-lock"></span>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <!-- /.col -->
                         <div class="col-12">
                             <button type="submit" name="btn_login" class="btn btn-primary btn-block">Sign In</button>
                         </div>
                         <p class="m-1">
                             <a href="#" onclick="swal('Reset Password','Please contact to Admin','error')">I forgot my password</a>
                         </p>
                         <!-- /.col -->
                     </div>
                 </form>


             </div>
             <!-- /.login-card-body -->
         </div>
     </div>
     <!-- /.login-box -->

    
 </body>

 </html>