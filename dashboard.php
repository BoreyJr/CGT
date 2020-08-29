<?php
include_once 'dbconnect.php';

session_start();
error_reporting(0);
if($_SESSION['user_email']=="" OR $_SESSION['role']=="user"){
    header('location:index.php');
}
echo $_SESSION['role'];
 include_once 'header.php';


$select = $pdo->prepare("select sum(total) as t, count(invoice_id) as inv from tb_invoice");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$total_order = $row->inv;
$net_total = $row->t;
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark" style="font-family: 'Khmer Busra MOE';font-size: 2rem">ទំព័រដើម</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="card card-info">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php echo $total_order ?></h3>

                    <p>ការបញ្ជារទិញសរុប</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="orderlist.php" class="small-box-footer"​>លម្អិតបន្ថែម<i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3><?php echo "$".number_format($net_total,2);?><sup style="font-size: 20px"></sup></h3>
                    <p>ចំនូលសរុប</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="orderlist.php" class="small-box-footer">លម្អិតបន្ថែម <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->

              <?php $select = $pdo->prepare("select count(p_name) as p from tb_product");
              $select->execute();

              $row= $select->fetch(PDO::FETCH_OBJ);

              $total_product = $row->p;


              $select = $pdo->prepare("select order_date, total from tb_invoice group by order_date");

              //              $select->bindParam(':fromdate', $_POST['date_1']);
              //              $select->bindParam(':todate', $_POST['date_2']);
              $select->execute();

              $ttl = [];
              $date = [];

              while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $ttl[] = $total;
                $date[] = $order_date;

              }
              //            echo json_encode($total);


              ?>
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3><?php echo $total_product; ?></h3>

                    <p>ចំនួនផលិតផលទាំងអស់</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="#" class="small-box-footer"> លម្អិតបន្ថែម <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <?php $select = $pdo->prepare("select count(category) as c from tb_category limit 30");
              $select->execute();

              $row= $select->fetch(PDO::FETCH_OBJ);

              $total_category = $row->c;

              ?>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><?php echo $total_category; ?></h3>
                    <p>ប្រភេទនៃផលិតផល</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="#" class="small-box-footer">លម្អិតបន្ថែម <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
            </div>
          </div>
        </div>
        <div class="card card-primary">
          <div class="card card-header"><strong><h3 class="card-title font-weight-bold">ចំនូលប្រចាំថ្ងៃ</h3></strong></div>
          <div class="card-body">
            <form action="" method="post">

                <div class="chart"> <canvas id="myChart" style="height:100px"></canvas></div>

            </form>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
          <div class="card card-danger">
            <div class="card card-header"><strong><h3 class="card-title font-weight-bold">ផលិតផលដែលលក់ដាច់បំផុត</h3></strong></div>

              <div class="card-body">
              <form action="" method="post">

                  <table style="overflow:auto" class="table table-striped table-hover table-bordered " id="orderlisttable">
                    <thead>
                    <tr>
                      <th scope="col">Product ID</th>
                      <th scope="col">Product Name</th>
                      <th scope="col">Quantity</th>
                      <th scope="col">Price</th>
                      <th scope="col">Total</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $select=$pdo->prepare("select product_id,product_name,price,sum(qty) as q, sum(qty*price) as total from tb_invoice_detail group by product_id, product_name, price order by sum(qty) desc limit 30");

                    $select->execute();

                    while($row=$select->fetch(PDO::FETCH_OBJ)){
                      echo '<tr class="align-items-center">
                            <td>'.$row->product_id.'</td>
                            <td>'.$row->product_name.'</td>
                            <td><h5><span class="badge bg-danger">'.$row->q.'</span></h5></td>
                            <td><span class="badge bg-info">'."$ ".$row->price.'</span></td>
                            <td><h5><span class="badge bg-warning">'."$ ".$row->total.'</span></h5></td>
                          
                         
                                </tr>';
                    }

                    ?>
                    </tbody>
                  </table>

              </form>

            </div>
          </div>
          </div>
          <div class="col-md-6">

                <div class="card card-warning">
                  <div class="card card-header"><strong><h3 class="card-title font-weight-bold">ការបញ្ជារទិញថ្មីៗនេះ</h3></strong></div>
                  <div class="card-body">
                    <table class="table table-striped table-hover " id="recentorder">
                      <thead>
                      <tr>
                        <th scope="col">Invoice ID</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Total</th>
                        <th scope="col">Payment Type</th>


                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      $select=$pdo->prepare("select * from tb_invoice order by invoice_id desc limit 20");

                      $select->execute();

                      while($row=$select->fetch(PDO::FETCH_OBJ)){
                        echo '<tr>
                            <td><a href="editinvoice.php?id='.$row->invoice_id.'">'.$row->invoice_id.'</a></td>
                            <td>'.$row->customer_name.'</td>
                            <td>'.$row->order_date.'</td>
                            <td><span class="badge bg-danger">'.$row->total.'</span></td>';


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

                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<script>
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
        data: <?php echo json_encode($ttl); ?>
      }]
    },

    // Configuration options go here
    options: {}
  });
</script>
<script>
  $(document).ready(function (){
    $('#orderlisttable').DataTable({
      "order":[[4,"desc"]]
    });
  });
</script>
<script>
  $(document).ready(function (){
    $('#recentorder').DataTable({
      "order":[[0,"desc"]]
    });
  });
</script>

<?php
include_once 'footer.php';
?>


