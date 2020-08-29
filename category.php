<?php
include_once 'dbconnect.php';
session_start();

if($_SESSION['user_email']=="" OR $_SESSION['role'] !="admin"){
    header('location:index.php');
}
include_once 'header.php';
//error_reporting(0);
//$id=$_GET['id'];
//

if(isset($_POST['btncreate']))
{
    $category = $_POST['txtcategory']; ///what user input 
    if(empty($category))
    {
    $error = '<script type="text/javascript"> jQuery(function validation(){
        swal({
                title: "Field is Empty ! ",             
                text: "Fail to create  🤣 ",
                icon: "error",
                timer : 200s,
        });   
        });
        </script>';   
        echo $error;
    }
    
    if(!isset($error)){
        
        $insert = $pdo->prepare("insert into tb_category(category) values(:category)");
        
        $insert->bindParam(':category',$category);
        
        if($insert->execute())
        {
            $success = '<script type="text/javascript"> jQuery(function validation(){
        swal({
                title: "Created",             
                text: "Category has been created !  🤣 ",
                icon: "success",
                button: "OK !",
        });   
        });
        </script>';   
        echo $success;
        }
    }

}
if(isset($_POST['btnupdate'])){
    $category = $_POST['txtcategory'];
    $id = $_POST['txtid'];
    
    if(empty($category))
    {
    $errorupdate = '<script type="text/javascript"> jQuery(function validation(){
        swal({
                title: "Field is Empty ! ",             
                text: "Fail to create  🤣 ",
                icon: "error",
                button:"OK",
        });   
        });
        </script>';   
        echo $errorupdate;
    }                                                         
    if(!isset($errorupdate)){
        $update = $pdo->prepare("update tb_category set category=:category where cat_id=".$id);
        $update->bindParam(':category',$category);
        
        if($update->execute()){
             $successupdate = '<script type="text/javascript"> jQuery(function validation(){
        swal({
                title: "Updated",             
                text: "Category has been updated !  🤣 ",
                icon: "success",
                button: "OK !",
        });   
        });
        </script>';   
        echo $successupdate;
        }
        else{
          $error_update = '<script type="text/javascript"> jQuery(function validation(){
        swal({
                title: "Update Fail",             
                text: "Category is not update !  🤣 ",
                icon: "error",
                button: "OK !",
        });   
        });
        </script>';   
        echo $error_update;
        }
    
    
    }
     }
if(isset($_POST['btndelete']))
{   
$delete = $pdo->prepare("delete from tb_category where cat_id=".$_POST['btndelete']);
if($delete->execute())
{
     echo '<script type="text/javascript"> jQuery(function validation(){
        swal({
        title: "Deleted",
        icon: "success",
        text: "Category has been deleted  🤣 ",
        
        });   
        });
        
        </script>';   
}
    else{
        $error_delete = '<script type="text/javascript"> jQuery(function validation(){
        swal({
                title: "Delete Fail",             
                text: "Category is not delete !  🤣 ",
                icon: "error",
                button: "OK !",
        });   
        });
        </script>';   
        echo $error_delete;
    }

}

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        
       
        <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title ">Category</h3>
              </div>          
                <div class="card-body">
                 <form class="form" role="form" action="" method="post">
                   
                   <div class="row">
                 <?php
                     if(isset($_POST['btnedit']))
                     {
                         $select= $pdo->prepare("select * from tb_category where cat_id=".$_POST['btnedit']);
                         $select->execute();
                         
                         if($select){
                             $row = $select->fetch(PDO::FETCH_OBJ);
                             echo '                 
                             <div class="col-md-4">
                 <div class="form-group">
                    <label for="exampleInputEmail1">Category</label>
                     <input type="hidden" class="form-control" id="exampleInputEmail1" name="txtid" value="'.$row->cat_id.'" placeholder="Enter Category" name="txtcategory">
                    <input type="text" class="form-control" id="exampleInputEmail1" value="'.$row->category.'" placeholder="Enter Category" name="txtcategory">
                     <button type="submit" name="btnupdate" class="btn btn-info btn-block mt-2">Update</button>
                  </div>               
                  </div>';
                             

                             
                     }
                         }
                         
                     else{
                         echo '                 <div class="col-md-4">
                 <div class="form-group">
                    <label for="exampleInputEmail1">Category</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Category"  name="txtcategory">
                     <button type="submit" name="btncreate" class="btn btn-info btn-block mt-2">Create</button>
                  </div>               
                  </div>';
                     }
                   
                     
                     ?>
            <div class="col-md-8">
                <table class="table table-striped" id="tablecategory">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $select=$pdo->prepare("select * from tb_category order by cat_id desc");
                        
                        $select->execute();
                        
                        while($row=$select->fetch(PDO::FETCH_OBJ)){
                            echo '<tr>
                            <td>'.$row->cat_id.'</td>
                            <td>'.$row->category.'</td>    
                            <td><button type="submit" value="'.$row->cat_id.'" class="btn btn-warning" name="btnedit">Edit</button></td>       
                            <td><button type="submit" value="'.$row->cat_id.'" class="btn btn-danger" name="btndelete">Delete</button></td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
                        </div>
                      </form>
                  
   
      </div><!-- /.container-fluid -->
    </div>
    </div>
     </div>
      </div>
<!--      calling function-->
      <script>$(document).ready( function () {
    $('#tablecategory').DataTable();
} );
</script>
<?php
 include_once 'footer.php';
?>
