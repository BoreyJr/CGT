<?php
include_once 'dbconnect.php';
session_start();

if ($_SESSION['user_email'] == "" or $_SESSION['role'] != "admin") {
  header('location:index.php');
}
include_once 'header.php';

$id = $_GET['id'];

$select=$pdo->prepare("select *from tb_product where p_id = $id");
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);
$id_db = $row['p_id'];
$pname_db = $row['p_name'];
$pcategory_db = $row['p_category'];
$ppurchase_db = $row['p_purchase'];
$pprice_db = $row['p_price'];
$pstock_db = $row['p_stock'];
$pdedscription_db = $row['p_description'];
$pimage_db = $row['p_image'];

//echo '-------------------------->'.$id_db.$pname_db.$pcategory_db.$ppurchase_db.$pprice_db.$pstock_db.$pdedscription_db.$pimage_db;

if (isset($_POST['btnsaveproduct'])) {

  $productname_txt = $_POST['txtpname'];

  $category_txt = $_POST['txtselect_option'];  // $_POST[''];

  $purchaseprice_txt = $_POST['txtpprice'];

  $saleprice_txt = $_POST['txtsaleprice'];

  $stock_txt = $_POST['txtstock'];

  $description_txt = $_POST['txtdescription'];

  $f_name = $_FILES['myfile']['name'];

//  echo '-------------------------->'.$productname_txt.$category_txt.$purchaseprice_txt.$saleprice_txt.$stock_txt.$description_txt.$f_name.$pimage_db;

  if(!empty($f_name)){    /// if user choose any images

    $f_tmp = $_FILES['myfile']['tmp_name'];
    $f_size = $_FILES['myfile']['size'];

    $f_extension = explode('.', $f_name);
    $f_extension = strtolower(end($f_extension));

    $f_newfile = uniqid() . '.' . $f_extension;

    $store = "productimages/" . $f_newfile;


    if ($f_extension == 'jpg' || $f_extension == 'jpeg' || $f_extension == 'png' || $f_extension == 'gif') {

      if ($f_size >= 2000000) {


        $error = '<script type="text/javascript">
                    jQuery(function validation(){
                    swal({
                    title: "Error!",
                    text: "Max file should be 1MB!",
                    icon: "warning",
                    button: "Ok",
                    });           
                    });

                  </script>';

                            echo $error;


      } else {

        if (move_uploaded_file($f_tmp, $store)) {

          $f_newfile;
          if (!isset($errorr)) {

            $update=$pdo->prepare("update tb_product set p_name=:pname , p_category=:pcategory , p_purchase=:ppurchase , p_price=:pprice , p_stock=:pstock , p_description=:pdescription , p_image=:pimage where p_id=$id");

            $update->bindParam(':pname',$productname_txt);
            $update->bindParam(':pcategory',$category_txt);
            $update->bindParam(':ppurchase',$purchaseprice_txt);
            $update->bindParam(':pprice',$saleprice_txt);
            $update->bindParam(':pstock',$stock_txt);
            $update->bindParam(':pdescription',$description_txt);

            $update->bindParam(':pimage',$f_newfile);



            if ($update->execute()) {

              echo '<script type="text/javascript">
                                jQuery(function validation(){
                                swal({
                                        title: "Update product Successfull! if ",
                              text: "Product Updated",
                              icon: "success",
                              button: "Ok",
                            });


                      });
                      
                      </script>';


            } else {

              echo '<script type="text/javascript">
                      jQuery(function validation(){
                      
                      
                      swal({
                      title: "ERROR!",
                      text: "Add product Fail",
                      icon: "error",
                      button: "Ok",
                      });
                      
                      
                      });

                    </script>';

            }


          }


        }


      }


    } else {


      $error = '<script type="text/javascript">
jQuery(function validation(){


swal({
  title: "Warning!",
  text: "only jpg ,jpeg, png and gif can be upload!",
  icon: "error",
  button: "Ok",
});


});

</script>';

      echo $error;


    }




  }   /// if user doesn't choose any images
  else{
    $update=$pdo->prepare("update tb_product set p_name=:pname , p_category=:pcategory , p_purchase=:ppurchase , p_price=:pprice , p_stock=:pstock , p_description=:pdescription , p_image=:pimage where p_id=$id");
    $update->bindParam(':pname',$productname_txt);
    $update->bindParam(':pcategory',$category_txt);
    $update->bindParam(':ppurchase',$purchaseprice_txt);
    $update->bindParam(':pprice',$saleprice_txt);
    $update->bindParam(':pstock',$stock_txt);
    $update->bindParam(':pdescription',$description_txt);
    $update->bindParam(':pimage',$pimage_db);   // auto choose current image if user doesn't choose any images

    if($update->execute())
    {
      echo '<script type="text/javascript">
                                jQuery(function validation(){
                                swal({
                                        title: "Update product Successfull! ELSE",
                              text: "Product Updated",
                              icon: "success",
                              button: "Ok",
                            });
                                
                });

</script>';

    }
    else
    {
      echo '<script type="text/javascript">
            jQuery(function validation(){


              swal({
                  title: "ERROR!",
                  text: "Update product Fail",
                  icon: "error",
                  button: "Ok",
                  });


              });

              </script>';

    }
  }
}
// update after updatedd
$select=$pdo->prepare("select *from tb_product where p_id = $id");
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);
$id_db = $row['p_id'];
$pname_db = $row['p_name'];
$pcategory_db = $row['p_category'];
$ppurchase_db = $row['p_purchase'];
$pprice_db = $row['p_price'];
$pstock_db = $row['p_stock'];
$pdedscription_db = $row['p_description'];
$pimage_db = $row['p_image'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
<div class="card card-warning">
  <div class="card-header">
<!--    <div clas="card card-title"><h4>Product Update</h4></div>-->
    <h1 class="card-title"><a href="productlists.php" class="btn btn-secondary btn-block text-light" role="button"><i class="fas fa-long-arrow-alt-left"></i> Back To
          Product List</a><h1 class="text-center font-weight-bold ">Update PRODUCT</h1></h1>
  </div>
<form  action="" method="post" name="formproduct" enctype="multipart/form-data">
      <div class="card-body">

        <div class="row">
          <div class="col-md-6">

            <div class="form-group">
              <label>Product Name</label>
              <input type="text" class="form-control" value="<?php echo $pname_db; ?>" name="txtpname" placeholder="Enter Name"
                     required>
            </div>


            <div class="form-group">
              <label>Category</label>
              <select class="form-control" name="txtselect_option" required>
                <option value="" disabled selected>Select Category</option>
                <?php
                $select = $pdo->prepare("select * from tb_category order by cat_id desc");
                $select->execute();
                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  ?>
                  <option <?php if($row['category'] == $pcategory_db) { ?>
                        selected = "selected"
                    <?php }?> >


                    <?php echo $row['category']; ?></option>

                  <?php

                }


                ?>


              </select>
            </div>


            <div class="form-group">
              <label>Purchase price</label>
              <input type="number" min="1" step="1" class="form-control" value="<?php echo $ppurchase_db; ?>" name="txtpprice"
                     placeholder="Enter..." required>
            </div>

            <div class="form-group">
              <label>Sale price</label>
              <input type="number" min="1" step="1" class="form-control" value="<?php echo $pprice_db; ?>" name="txtsaleprice"
                     placeholder="Enter..." required>
            </div>

            <div class="form-group">
              <label>Stock</label>
              <input type="number" min="1" step="1" class="form-control" value="<?php echo $pstock_db; ?>" name="txtstock"
                     placeholder="Enter..." required>
            </div>


            <div class="form-group">
              <label>Description</label>
              <textarea class="form-control " name="txtdescription"  placeholder="Enter..."
                        rows="6"><?php echo $pdedscription_db; ?></textarea>
            </div>


          </div>


          <div class="col-md-6">

            <p class="text-center font-weight-bold">Product Image</p>
            <img class="img-fluid" src="productimages/<?php echo $pimage_db?>"/>
            <div class="input-group">

              <div class="custom-file">

                <input type="file" class="custom-file-input" name="myfile" id="exampleInputFile">
                <label class="custom-file-label" for="exampleInputFile"><strong>Choose New Image</strong></label>
              </div>
              <div class="input-group-append">
                <span class="input-group-text" id="">Upload</span>
              </div>
            </div>


          </div>


        </div>


        <div class="box-footer mt-2">
          <button type="submit" class="btn btn-warning btn-block" name="btnsaveproduct">Save</button>

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
