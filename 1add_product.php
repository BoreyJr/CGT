<?php
include_once 'dbconnect.php';
session_start();
include_once 'header.php';
if ($_SESSION['user_email'] == "" or $_SESSION['role'] != "admin") {
  header('location:index.php');
}
if (isset($_POST['btnaddproduct'])) {
  $product_name = $_POST['txtpname'];
  $category = $_POST['category'];
  $purchase = $_POST['txtpurchaseprice'];
  $price = $_POST['txtsaleprice'];
  $stock = $_POST['txtstock'];
  $description = $_POST['txtdescription'];

  //upload images

  $f_name = $_FILES['myfile']['name'];


  $f_tmp = $_FILES['myfile']['tmp_name'];


  $f_size = $_FILES['myfile']['size'];

  $f_extension = explode('.', $f_name);
  $f_extension = strtolower(end($f_extension));

  $f_newfile = uniqid() . '.' . $f_extension;

  $store = "images/" . $f_newfile;


  //to strict user upload only 1MB

  if ($f_extension == 'jpg' || $f_extension == 'jpeg' || $f_extension == 'png' || $f_extension == 'gif') {

    if ($f_size >= 1000000) {
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

        $product_image = $f_newfile; ///success move image
        if (!isset($error)) {
          $insert = $pdo->prepare("insert into tb_product(p_name,p_category,p_purchase,p_price,p_stock,p_description,p_image) values(:pname,:pcategory,:ppurchase,:pprice,:pstock:,pdescription,:pimage)");

          $insert->bindParam(':pname', $product_name);
          $insert->bindParam(':pcategory', $category);
          $insert->bindParam(':ppurchase', $purchase);
          $insert->bindParam(':pprice', $price);
          $insert->bindParam(':pstock', $stock);
          $insert->bindParam(':pdescription', $description);
          $insert->bindParam(':pimage', $product_image);

          echo $product_image . $category . $purchase . $price . $stock . $description . $product_name;


          if ($insert->execute()) {

            echo '<script type="text/javascript">
                                    jQuery(function validation(){


                                    swal({
                                    title: "Add product Successfull!",
                                    text: "Product Added",
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

}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <!--    <div class="content-header">-->
  <div class="content container-fluid">
    <div class="card card-success">
      <div class="card-header with-border">
        <h3 class="card-title">Products Form</h3>
      </div>
      <div class="card-body">
        <form action="" method="post" name="formproduct" enctype="multipart/form-data">

          <a href="productlist.php" class="btn btn-primary" role="button"><i class="fas fa-chevron-left"></i> Back to
            Product List</a>

          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                <label>Product Name</label>
                <input type="text" class="form-control" name="txtpname" placeholder="Enter Product Name ..." required>
              </div>
              <div class="form-group">
                <label>Category</label>
                <select class="form-control" name="category" required>
                  <option value="" disabled selected>Select Category</option>
                  <?php
                  $select = $pdo->prepare("select * from tb_category order by cat_id desc");
                  $select->execute();
                  while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    ?>
                    <option><?php echo $row['category']; ?></option>

                    <?php

                  }


                  ?>


                </select>
              </div>

              <div class="form-group">
                <label>Purchase Price</label>
                <input type="number" min="1" step="1" class="form-control" name="txtpurchaseprice"
                       placeholder="Enter Product Purchase Price ..." required>
              </div>
              <div class="form-group">
                <label>Product Price</label>
                <input type="number" min="1" step="1" class="form-control" name="txtsaleprice"
                       placeholder="Enter Product price ..." required>
              </div>

            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Stock</label>
                <input type="number" min="1" step="1" class="form-control" name="txtstock"
                       placeholder="Enter Product stock ..." required>
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea type="text" class="form-control" name="txtdescription" placeholder="Enter description"
                          rows="5">
                    </textarea>
              </div>
              <div class="form-group">
                <label>Image</label>
                <input type="file" class="input-group" name="myfile">
                <p>Upload Image</p>
              </div>
            </div>
          </div>


          <div class="card-footer">
            <button class="btn btn-success btn-block" name="btnaddproduct">Add Product</button>
          </div>
        </form>
      </div>

    </div>
  </div><!-- /.container-fluid -->
  <!--    </div>-->
</div>
<?php
@include_once 'footer.php';
?>
