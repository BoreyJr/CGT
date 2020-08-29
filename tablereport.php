<?php
include_once 'dbconnect.php';
error_reporting(0);
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

    <h1 class="text-center">Table Report</h1>
    <div class="container-fluid">
      <div class="card card-primary">
        <div class="card card-header"><strong><h3 class="card-title font-weight-bold"><?php echo 'From : '.$_POST['date_1'].' To : '.$_POST['date_1']; ?></h3></strong></div>
        <form action="" method="post">

        <div class="card-body">
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
<!--                <label >From:</label>-->
                <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                  <input type="text"  class="form-control datetimepicker-input" name="date_1"  data-target="#reservationdate1" data-date-format="yyyy-mm-dd" >
                  <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>

              </div>

            </div>
            <div class="col-md-5">
              <div class="form-group">
<!--                <label >To:</label>-->
                <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                  <input type="text" data-date-format="yyyy-mm-dd" class="form-control datetimepicker-input" name="date_2"  data-target="#reservationdate2" >
                  <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>

              </div>
            </div>

            <div class="col-md-2">
              <div class="form-group float-left align-items-buttom" >
<!--              <label>Filter Date </label>-->
              <input type="submit" name="btndatefilter"  value="Filter By Dater" class="form-control btn btn-primary ">
              </div>
            </div>

          </div>
        <br>
          <br>

           <?php
            $select=$pdo->prepare("select sum(total) as total, sum(sub_total) as stotal, count(invoice_id) as invoice from tb_invoice where order_date between :fromdate AND :todate ");

            $select->bindParam(':fromdate',$_POST['date_1']);
            $select->bindParam(':todate',$_POST['date_2']);
            $select->execute();

            $row=$select->fetch(PDO::FETCH_OBJ);

            $net_total = $row->total;
            $stotal = $row->stotal;
            $invoice = $row->invoice;

            ?>
<!--          //2nd row-->
          <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-dollar-sign"></i></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total</span>
                <span class="info-box-number">
                <?php echo number_format($net_total,2);?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Sub Total</span>
                <span class="info-box-number"><?php echo number_format($stotal,2); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Invoices</span>
                <span class="info-box-number"><?php echo $invoice;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
          <br>
          <br>

          <table class="table table-striped table-hover " id="salereporttable">
            <thead>
            <tr>
              <th scope="col">Invoice ID</th>
              <th scope="col">Customer Name</th>
              <th scope="col">Sub Total</th>
              <th scope="col">Total</th>
              <th scope="col">Paid</th>
              <th scope="col">Due</th>
              <th scope="col">Order Date</th>
              <th scope="col">Payment</th>

            </tr>
            </thead>
            <tbody>
            <?php
            $select=$pdo->prepare("select * from tb_invoice where order_date between :fromdate AND :todate ");

            $select->bindParam(':fromdate',$_POST['date_1']);
            $select->bindParam(':todate',$_POST['date_2']);
            $select->execute();

            while($row=$select->fetch(PDO::FETCH_OBJ)){
              echo '
                            <tr>
                            <td>'.$row->invoice_id.'</td>
                            <td>'.$row->customer_name.'</td>                         
                            <td >'.$row->sub_total.'</td> 
                            <td ><span class="badge bg-info font-weight-bold">'.$row->total.'</span></td> 
                            <td>'.$row->paid.'</td>
                             <td>'.$row->due.'</td>
                             <td>'.$row->order_date.'</td>

                          
                            ';
              if($row->payment_type == "CASH")
              {
                echo '<td><span class="badge bg-primary">'.$row->payment_type.'</span></td>';
              }else if($row->payment_type == "TRANSFER")
              {
                echo '<td><span class="badge bg-warning">'.$row->payment_type.'</span></td>';
              }
              else if($row->payment_type == "CHECK"){
                echo '<td><span class="badge bg-secondary">'.$row->payment_type.'</span></td>';
              }
              else
              {
                echo '<td><span class="badge bg-danger">'.$row->payment_type.'</span></td>';
              }
            }
            echo 'From : ';
        echo $_POST['date_1'];
            echo ' To : ';
            echo $_POST['date_2'];
//            ?>
            </tbody>
          </table>


        </div>
        </form>
      </div>

    </div><!-- /.container-fluid -->
  </div>
</div>
<script>
  //Date range picker
  $('#reservationdate1').datetimepicker({
    // format: 'L'
    format: 'YYYY-MM-DD'
  })

  //Date range picker
  $('#reservationdate2').datetimepicker({
    format: 'YYYY-MM-DD'
  })


  $('#salereporttable').DataTable({

    "order":[[0,"desc"]]

  });
</script>
<?php
include_once 'footer.php';
?>
