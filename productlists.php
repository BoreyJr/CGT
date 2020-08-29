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
  <div class="content-header">
    <div class="container-fluid">
    <div class="card card-warning">
    <div class="card-header with-border"><h1 class="card-title">Product List</h1></div>
    <card class="card-body">
      <div style="overflow-x: auto">
      <table class="table table-striped table-hover " id="tableproduct">
        <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Product Name</th>
          <th scope="col">Category</th>
          <th scope="col">Purchase Price</th>
          <th scope="col">Sale Price</th>
          <th scope="col">Stock Quantity</th>
          <th scope="col">Description</th>
          <th scope="col">Product Image</th>
          <th scope="col">View</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $select=$pdo->prepare("select * from tb_product order by p_id desc");

        $select->execute();

        while($row=$select->fetch(PDO::FETCH_OBJ)){
          echo '<tr>
                            <td>'.$row->p_id.'</td>
                            <td>'.$row->p_name.'</td>
                            <td>'.$row->p_category.'</td>
                            <td>'.$row->p_purchase.'</td>
                            <td>'.$row->p_price.'</td>
                             <td>'.$row->p_stock.'</td>
                              <td>'.$row->p_description.'</td>
                              <td><img src="productimages/'.$row->p_image.'" class="img-rounded" width="100px" height="100px" /></td>
                                  <td><a href="viewproduct.php?id='.$row->p_id.'" style="color:#ffffff" data-toggle="tooltip"  title="View product" role="button" class="btn btn-primary" name="btnview"><i class="fas fa-eye"></i></a></td>
                              <td><a href="editproduct.php?id='.$row->p_id.'" style="color:#ffffff" data-toggle="tooltip"  title="Edit product" role="button" value="'.$row->p_id.'" class="btn btn-warning" name="btnedit"><i class="fas fa-edit"></i></a></td>   
                            <td><button id='.$row->p_id.' class="btn btn-danger btndelete" style="color:#ffffff" ><i  data-toggle="tooltip"  title="Delete product"  class="fas fa-trash"></i></button></td>
                            </tr>';
        }

        ?>
        </tbody>
      </table>
      </div>
    </card>

    </div>
    </div><!-- /.container-fluid -->
  </div>
</div>


<script>
  $(document).ready( function (){

    $('.btndelete').click(function () {
      var tdh = $(this);
      var id = $(this).attr("id");
      // alert (id);

      swal({
        title: "Are you sure to delete this product?",
        text: "Once deleted, you will not be able to recover this product !",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
        .then((willDelete) => {
          if (willDelete) {

            $.ajax({

              url:'productdelete.php',
              type:'post',
              data:{
                piid:id
              },
              success:function (data) {
                tdh.parents('tr').hide();
              }

            });


            swal("Done ! Your product has been deleted!", {
              icon: "success",
            });
          } else {
            swal("Your product is safe!");
          }
        });

    });

  });
</script>

<script>$(document).ready( function () {
    $('[data-toggle="tooltip"]').tooltip();;
  } );
</script>

<!--      calling function-->

<script>$(document).ready( function () {
    $('#tableproduct').DataTable({
      "order":[[0,"des"]]  /// desending order
    });
  } );
</script>


<!--<script>-->
<!--  $(document).ready( function (){-->
<!---->
<!--    $('.btndelete').click(function () {-->
<!--      var tdh = $(this);-->
<!--      var id = $(this).attr("id");-->
<!--      // alert (id);-->
<!---->
<!--      $.ajax({-->
<!---->
<!--        url:'productdelete.php',-->
<!--        type:'post',-->
<!--        data:{-->
<!--          piid:id-->
<!--        },-->
<!--        success:function (data) {-->
<!--          tdh.parents('tr').hide();-->
<!--        }-->
<!---->
<!--      });-->
<!--    });-->
<!---->
<!--  });-->
<!--</script>-->
<?php
include_once 'footer.php';
?>
