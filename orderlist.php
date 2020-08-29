<?php
include_once 'dbconnect.php';
session_start();
if ($_SESSION['user_email'] == "") {
  header('location:index.php');
}

if($_SESSION['role']=="admin"){
  include_once "header.php";
}
else
{
  include_once "headeruser.php";
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <h1 class="text-center font-weight-bold">INVOICES</h1>
    <div class="container-fluid">
      <div style="overflow: auto">
        <table class="table table-striped table-hover " id="orderlisttable">
          <thead>
          <tr>
            <th scope="col">Invoice ID</th>
            <th scope="col">Customer Name</th>
            <th scope="col">Order Date</th>
            <th scope="col">Total</th>
            <th scope="col">Paid</th>
            <th scope="col">Due</th>
            <th scope="col">Payment Type</th>
            <th scope="col">Print</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>

          </tr>
          </thead>
          <tbody>
          <?php
          $select=$pdo->prepare("select * from tb_invoice order by invoice_id desc");

          $select->execute();

          while($row=$select->fetch(PDO::FETCH_OBJ)){
            echo '<tr>
                            <td>'.$row->invoice_id.'</td>
                            <td>'.$row->customer_name.'</td>
                            <td>'.$row->order_date.'</td>
                            <td>'.$row->total.'</td>
                            <td>'.$row->paid.'</td>
                             <td>'.$row->due.'</td>
                              <td>'.$row->payment_type.'</td>
                         
                                  <td><a href="invoice_db.php?id='.$row->invoice_id.'" style="color:#ffffff" data-toggle="tooltip"  title="Print Invoice" role="button" class="btn btn-secondary" name="btnview" target="_blank"><i class="fas fa-print"></i></a></td>
                              <td><a href="editinvoice.php?id='.$row->invoice_id.'" style="color:#ffffff" data-toggle="tooltip"  title="Edit Invoice" role="button" value="'.$row->invoice_id.'" class="btn btn-warning" name="btnedit"><i class="fas fa-edit"></i></a></td>   
                            <td><button id='.$row->invoice_id.' class="btn btn-danger btndelete" style="color:#ffffff" ><i  data-toggle="tooltip"  title="Delete Invoice"  class="fas fa-trash"></i></button></td>
                            </tr>';
          }

          ?>
          </tbody>
        </table>
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
        title: "Are you sure to delete this invoice?",
        text: "Once deleted, you will not be able to recover this invoice !",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
        .then((willDelete) => {
          if (willDelete) {

            $.ajax({

              url:'orderdelete.php',
              type:'post',
              data:{
                piid:id
              },
              success:function (data) {
                tdh.parents('tr').hide();
              }

            });


            swal("Done ! Your invoice has been deleted!", {
              icon: "success",
            });
          } else {
            swal("Your invoice is safe!");
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
    $('#orderlisttable').DataTable({
      "order":[[0,"des"]]  /// desending order
    });
  } );
</script>

<?php
include_once 'footer.php';
?>
