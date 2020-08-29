<?php
include_once 'dbconnect.php';
session_start();

if ($_SESSION['user_email'] == "" or $_SESSION['role'] != "admin") {
  header('location:index.php');
}
include_once 'header.php';

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header >

    <div class="container-fluid">
        <div class="card card-primary ">

          <div class="card-header with-border text-center">
            <div class="row align-items-center">
              <div class="col-md-2">
              <a href="productlists.php" class="btn btn-secondary" role="button"><i class="fas fa-long-arrow-alt-left"></i>
                Product List</a>   </div>
              <div class="col-md-8">
                <h5 >View Product</h5></div>
              <div class="col-md-2">
                <a href="add_product.php" class="btn btn-info" role="button"><i class="fas fa-plus"></i>
                  Add Product</a></div>
            </div>


        </div>
          </div>
          <div class="card-body">

            <?php
            $id = $_GET['id'];

            $select = $pdo->prepare("select * from tb_product where p_id = $id");
            $select->execute();

            while($row= $select->fetch(PDO::FETCH_OBJ))
            {
              echo '
                  
                    <div class="row ">
                    
                    <div class="col-md-6">
                    <ul class="list-group">
                    <p class="list-group-item list-group-item-success text-center"><b>Product Detail</b></p>
                        <li class="list-group-item d-flex justify-content-between align-items-center">ID<span class="badge badge-secondary badge-pill">'.$row->p_id.'</span></li>
                           <li class="list-group-item d-flex justify-content-between align-items-center">Product Name<span class="badge  badge-pill"><h4>'.$row->p_name.'</h4></span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">Category<span class="badge badge-primary badge-pill">'.$row->p_category.'</span></li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Purchase Price<span class="badge badge-warning badge-pill">'.$row->p_purchase.'</span></li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Sale Price<span class="badge badge-warning badge-pill">'.$row->p_price.'</span></li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Profit<span class="badge badge-success badge-pill">'.($row->p_price-$row->p_purchase).'</span></li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">Stock<span class="badge badge-danger badge-pill">'.$row->p_stock.'</span></li>
                      <li class="list-group-item  justify-content-between"><u class="text-center"><strong>Description:</strong></u><br><span class="">'.$row->p_description.'</span></li>
                      </ul>
                    </div>
                    <div class="col-md-6">
                    <ul class="list-group">
                    <p class="list-group-item list-group-item-success"><b>Product Image</b></p>
                        <img src="productimages/'.$row->p_image.'" class="img-responsive">
            
                       </ul>
                    </div>
                    </div>
              
              ';
            }


            ?>

          </div>

    </div><!-- /.container-fluid -->
  </div>
</div>
<?php
include_once 'footer.php';
?>
