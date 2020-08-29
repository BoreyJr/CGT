<?php
include_once 'dbconnect.php';
session_start();
if ($_SESSION['user_email'] == "" or $_SESSION['role'] != "admin") {
  header('location:index.php');
}

error_reporting(0);
include_once 'header.php';

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
<div class="card card-secondary">

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
    <?php
            $select=$pdo->prepare("select order_date, sum(total) as price from tb_invoice where order_date between :fromdate AND :todate group by order_date");

            $select->bindParam(':fromdate',$_POST['date_1']);
            $select->bindParam(':todate',$_POST['date_2']);
            $select->execute();
            
            $total = [];
            $date = [];
            
            while ($row=$select->fetch(PDO::FETCH_ASSOC))
            {
              extract($row);

              $total[] = $price;
              $date[] = $order_date;

            }
//            echo json_encode($total);

              ?>

    <div class="chart"> <canvas id="myChart"></canvas></div>
    <?php
    $select=$pdo->prepare("select product_name, sum(qty) as q from tb_invoice_detail where order_date between :fromdate AND :todate group by product_id");

    $select->bindParam(':fromdate',$_POST['date_1']);
    $select->bindParam(':todate',$_POST['date_2']);
    $select->execute();

    $pname = [];
    $qty = [];

    while ($row=$select->fetch(PDO::FETCH_ASSOC))
    {
      extract($row);

      $pname[] = $product_name;
      $qty[] = $q;

    }
    //            echo json_encode($total);

    ?>
    <div class="chart"> <canvas id="bestsellingproduct"></canvas></div>

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

  var ctx = document.getElementById('myChart').getContext('2d');
  var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
      labels: <?php echo json_encode($date); ?>,
      datasets: [{
        label: 'Total Earning',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: <?php echo json_encode($total); ?>
      }]
    },

    // Configuration options go here
    options: {}
  });
</script>
<script>

  var ctx = document.getElementById('bestsellingproduct').getContext('2d');
  var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
      labels: <?php echo json_encode($pname); ?>,
      datasets: [{
        label: 'Total Sold',
        backgroundColor: 'rgb(11,66,176)',
        borderColor: 'rgb(245,0,46)',
        data: <?php echo json_encode($qty); ?>
      }]
    },

    // Configuration options go here
    options: {}
  });
</script>
<?php
include_once 'footer.php';
?>
