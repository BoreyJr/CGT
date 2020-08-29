<?php
include_once 'dbconnect.php';

session_start();


if ($_SESSION['user_email'] == "" or $_SESSION['role'] != "admin") {
  header('location:index.php');
}
include_once 'header.php';

if (isset($_POST['btnaddproduct'])) {

    $productname = $_POST['txtpname'];

    $category = $_POST['txtselect_option'];  // $_POST[''];

    $purchaseprice = $_POST['txtpprice'];

    $saleprice = $_POST['txtsaleprice'];

    $stock = $_POST['txtstock'];

    $description = $_POST['txtdescription'];


    $f_name = $_FILES['myfile']['name'];


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

                $productimage = $f_newfile;
                if (!isset($errorr)) {

                    $insert = $pdo->prepare("insert into tb_product(p_name,p_category,p_purchase,p_price,p_stock,p_description,p_image) values(:pname,:pcategory,:purchaseprice,:saleprice,:pstock,:pdescription,:pimage)");
													
                    $insert->bindParam(':pname', $productname);
                    $insert->bindParam(':pcategory', $category);
                    $insert->bindParam(':purchaseprice', $purchaseprice);
                    $insert->bindParam(':saleprice', $saleprice);
                    $insert->bindParam(':pstock', $stock);
                    $insert->bindParam(':pdescription', $description);
                    $insert->bindParam(':pimage', $productimage);


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
		

        <!-- Main content -->
        <section class="content container-fluid">

            <!--------------------------
              | Your Page Content Here |
              -------------------------->

            <div class="card card-info">
                <div class="card-header with-border">
                    <h1 class="card-title "><a href="productlists.php" class="btn btn-secondary btn-block" role="button"><i class="fas fa-long-arrow-alt-left"></i> Back To
                            Product List</a><h1 class="text-center font-weight-bold">ADD PRODUCT</h1></h1>				
                </div>
                <!-- /.box-header -->
                <!-- form start -->
				
                <form action="" method="post" name="formproduct" enctype="multipart/form-data">

				
                    <div class="card-body">
						
						<div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" class="form-control" name="txtpname" placeholder="Enter Name"
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
                                        <option><?php echo $row['category']; ?></option>

                                        <?php

                                    }


                                    ?>


                                </select>
                            </div>


                            <div class="form-group">
                                <label>Purchase price</label>
                                <input type="number" min="1" step="1" class="form-control" name="txtpprice"
                                       placeholder="Enter..." required>
                            </div>

                            <div class="form-group">
                                <label>Sale price</label>
                                <input type="number" min="1" step="1" class="form-control" name="txtsaleprice"
                                       placeholder="Enter..." required>
                            </div>


                        </div>


                        <div class="col-md-6">


                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" min="1" step="1" class="form-control" name="txtstock"
                                       placeholder="Enter..." required>
                            </div>


                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="txtdescription" placeholder="Enter..."
                                          rows="1"></textarea>
                            </div>

 
                        
							 <label class="">Product Image</label>
							<div class="input-group">
							 
                      <div class="custom-file">
						
                        <input type="file" class="custom-file-input" name="myfile" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>


                        </div>


                    </div>


                    <div class="box-footer">
					<button type="submit" class="btn btn-info btn-block" name="btnaddproduct">Add Product</button>

                    </div>
                    </div>
                </form>


            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

<?php

include_once 'footer.php';

?>
