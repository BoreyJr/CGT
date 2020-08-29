<?php
include_once 'dbconnect.php';
session_start();
ob_start();
if ($_SESSION['user_email']=="")
{
  header('location:index.php');
}

function fill_product($pdo)
{
  $output='';

  $select = $pdo->prepare("select * from tb_product order by p_name asc");
  $select->execute();

  $result=$select->fetchAll();

  foreach ($result as $row){

    $output.='<option value="'.$row["p_id"].'">'.$row["p_name"].'</option>';
  }
  return $output;
}
//include_once 'header.php';

if(isset($_POST['btnsaveorder']))
{
    $customername = $_POST['txtcustomername'];
    $order_date=date('Y-m-d',strtotime($_POST['orderdate']));
    $subtotal = $_POST['txtsubtotal'];
    $tax = $_POST['txttax'];
    $discount = $_POST['txtdiscount'];
    $total = $_POST['txttotal'];
    $paid = $_POST['txtpaid'];
    $due = $_POST['txtdue'];
    $payment_type = $_POST['r1'];

    ///array value
        $arr_productid = $_POST['productid'];
        $arr_productname = $_POST['productname'];
        $arr_stock = $_POST['productstock'];
        $arr_qty = $_POST['qty'];
        $arr_price = $_POST['price'];
          $arr_total =  $_POST['total'];



    $insert = $pdo->prepare("insert into tb_invoice(customer_name,order_date,sub_total,tax,discount,total,paid,due,payment_type) VALUES (:cust,:orderdate,:subtotal,:tax,:disc,:total,:paid,:due,:paytype)");

    $insert->bindParam(':cust',$customername);
    $insert->bindParam(':orderdate',$order_date);
    $insert->bindParam(':subtotal',$subtotal);
    $insert->bindParam(':tax',$tax);
    $insert->bindParam(':disc',$discount);
    $insert->bindParam(':total',$total);
    $insert->bindParam(':paid',$paid);
    $insert->bindParam(':due',$due);
    $insert->bindParam(':paytype',$payment_type);

    $insert->execute();


    // 2nd insert query for tb_invoice_detail

  $invoice_id = $pdo->lastInsertId();
  if($invoice_id != null)
  {
    for($i=0; $i<count($arr_productid); $i++){
        $rem_qty = $arr_stock[$i] - $arr_qty[$i];
      if($rem_qty < 0)
      {
        return "Order is not Complete";
      }
        else{

          $update = $pdo->prepare("update tb_product set p_stock = '$rem_qty' where p_id ='".$arr_productid[$i]."'");

          $update->execute();
      }

      $insert = $pdo->prepare("insert into tb_invoice_detail(invoice_id,product_id,product_name,qty,price,order_date) VALUES (:invoiceid,:p_id,:p_name,:qty,:price,:orderdate)");

      $insert->bindParam(':invoiceid',$invoice_id);
      $insert->bindParam(':p_id',$arr_productid[$i]);
      $insert->bindParam(':p_name',$arr_productname[$i]);
      $insert->bindParam(':qty',$arr_qty[$i]);
      $insert->bindParam(':price',$arr_price[$i]);
      $insert->bindParam(':orderdate',$order_date);

      $insert->execute();
    }
    header('location:invoice.php');
//    $URL="orderlist.php";
//    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
//    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
  }
}
if($_SESSION['role']=="admin"){
  include_once'header.php';
}else if ($_SESSION['role']=="user"){
  include_once'headeruser.php';
}
?>
<!-- Content Wrapper. Contains page content -->
<!-- Content Header (Page header) -->
<div class="content-wrapper">
  <div class="content container-fluid">
    <div class="card card-primary">
      <form action="" method="post" name="">
        <div class="card-header with-border">
          <h3 class="card-title">New Order</h3>
        </div>

        <div class="card-body">   <!-- this is for customer and dete -->
          <div class="row">

            <div class="col-md-6">
              <div class="form-group">
                <label>Customer Name</label>
                <div class="input-group">
                  <div class="input-group-append">
                    <div class="input-group-text"> <i class="fa fa-user"></i></div>
                  </div>
                  <input required type="text" class="form-control"  name="txtcustomername" placeholder="Enter Customer Name"  >

                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Date:</label>
                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" name="orderdate" value="<?php echo date("m/d/y");?>" data-date-format="m/d/y" data-target="#reservationdate">
                  <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>


        <div class="card-body">  <!-- this is for Table -->
          <div class="col-md-12">
            <div style="overflow-x: auto;">
              <table class="table table-striped table-hover " id="tableproduct">
                <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Search Product</th>
                  <th scope="col">Stock Quantity</th>
                  <th scope="col">Price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Total</th>
                  <th><button name="add" class="btn btn-success btn-sm btnadd" ><i  class="fas fa-plus"></i></button></th>
                </tr>
                </thead>

              </table>
            </div>

          </div>
        </div>

        <div class="card-body">
          <div class="row ">
            <div class="col-md-6">

              <div class="form-group">
                <label>Sub Total</label>
                <div class="input-group">
                  <div class="input-group-append">
                    <div class="input-group-text"> <i class="fas fa-file-invoice-dollar"></i></div>
                  </div>
                  <input type="text" class="form-control-lg" style="border:none"  name="txtsubtotal" id="txtsubtotal"
                         readonly>
                </div>
              </div>

              <div class="form-group">
                <label style="font-family: 'Khmer Busra MOE';font-size: 1rem">លុយខ្មែរ (4100 ៛)</label>
                <div class="input-group">
                  <div class="input-group-append">
                    <div class="input-group-text"><img src="asset/riel.png">  </img></div>
                  </div>
                  <input type="text" class="form-control-lg"  name="txttax" id="txttax" readonly>
                </div>
              </div>

              <div class="form-group">
                <label>Discount</label>
                <div class="input-group">
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fas fa-percentage"></i></div>
                  </div>
                  <input type="text" class="form-control-lg"  name="txtdiscount" id="txtdiscount"
                  >
                </div>
              </div>
            </div>


            <div class="col-md-5">

              <div class="form-group">
                <label style="font-family: 'Khmer Busra MOE';font-size: 2rem">តម្លៃសរុប</label>
                <div class="input-group">
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                  </div>
                  <input type="text" style="border:none ;color: red;" class="form-control-lg font-weight-bold"  name="txttotal" id="txttotal" readonly>
                </div>
              </div>

              <div class="form-group">
                <label>Paid</label>
                <div class="input-group">
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                  </div>
                  <input type="text" class="form-control-lg"  name="txtpaid" id="txtpaid" >
                </div>
              </div>

              <div class="form-group">
                <label>Due</label>
                <div class="input-group">
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="far fa-calendar"></i></div>
                  </div>
                  <input type="text" style="color:blue;" class="form-control-lg"  name="txtdue" id="txtdue" readonly
                  >
                </div>
              </div>

              <br>

              <label>Payment method</label>
              <div class="form-group clearfix" aria-required="true">
                <div class="icheck-danger d-inline">
                  <input type="radio" id="radioPrimary4" value="OWING" name="r1" checked>
                  <label for="radioPrimary4 " class="text-danger">
                    OWING
                  </label>
                </div>
                <div class="icheck-danger d-inline">
                  <input type="radio" id="radioPrimary1" value="CASH" name="r1" >
                  <label for="radioPrimary1">
                    CASH
                  </label>
                </div>
                <div class="icheck-danger d-inline">
                  <input type="radio" id="radioPrimary2" VALUE="TRANSFER" name="r1">
                  <label for="radioPrimary2">  TRANSFER
                  </label>
                </div>
                <div class="icheck-danger d-inline">
                  <input type="radio" id="radioPrimary3" value="CHECK" name="r1" >
                  <label for="radioPrimary3">
                    CHECK
                  </label>
                </div>

              </div>

            </div>

          </div>   <!-- row -->

          <hr>
          <input type="submit" name="btnsaveorder" value="Save Order" class="btn btn-primary btn-block">
        </div>
      </form>
    </div>
  </div>
</div>
<script>

  $(document).ready(function(){
    //Date range picker
    $('#reservationdate').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    $(document).on('click','.btnadd',function () {

      var html = '';
      html+='<tr>';
      html+='<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
      html+='<td><select class="form-control productid" style="width: 250px;" name="productid[]"><option value="">Select Product</option><?php echo fill_product($pdo); ?></select></td>';
      html+='<td><input type="text"  class="form-control productstock"  name="productstock[]" readonly></td>';
      html+='<td><input type="text" class="form-control price" name="price[]" readonly></td>';
      html+='<td><input type="number" min="1" class="form-control qty" name="qty[]" ></td>';
      html+='<td><input type="text"  class="form-control total" name="total[]" readonly></td>';
      html+='<td><button name="remove" class="btn btn-danger btn-sm  btnremove align-middle"><i  class="fas fa-times align-middle"></i></button></td>';

      $('#tableproduct').append(html);

      //select 2 element initi
      $('.productid').select2()

      $(".productid").on('change',function (e){

        var productid = this.value;
        var tr=$(this).parent().parent();

        $.ajax({
          url:"getproduct.php",
          method:"get",
          data:{id:productid},
          success:function (data)

          {
            console.log(data);
            tr.find(".pname").val(data["p_name"]);
            tr.find(".productstock").val(data["p_stock"]);
            tr.find(".price").val(data["p_price"]);
            tr.find(".qty").val(1);
            tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
            calculate(0,0);
          }
        })
      })

      })


    $(document).on('click','.btnremove',function(){

      $(this).closest('tr').remove();
      calculate(0,0);
      $("#txtpaid").val(0);

    }) // btnremove end here



    $("#tableproduct").delegate(".qty","keyup change" ,function(){

      let quantity = $(this);
      let tr=$(this).parent().parent();

      if( (quantity.val()-0) > (tr.find(".productstock").val()-0) )
      {
        swal("WARNING!", "Sorry ! this much of quantity is not available", "warning");

        quantity.val(1);

        tr.find(".total").val(quantity.val() * tr.find(".price").val());
        calculate(0,0);
        console.log("if");
      }
      else{
        tr.find(".total").val(quantity.val() * tr.find(".price").val());
        calculate(0,0);
        console.log("else");
      }


    })
      function calculate(dis,paid)
      {
        let subtotal = 0;
        let tax= 0;
        let discount = dis;  //input value discount from usser
        let net_total = 0;
        let paid_amt = paid ;
        let due = 0;

        $(".total").each(function (){

          subtotal = subtotal+($(this).val()*1);
      })
        tax = 4100 * subtotal;
        net_total = 0 + subtotal;
        net_total = net_total - discount;
        due = net_total - paid_amt;

        $("#txtsubtotal").val(subtotal.toFixed(2));
        $("#txttax").val(tax.toFixed(2));
        $("#txttotal").val(net_total.toFixed(2));
        $("#txtdiscount").val(discount);
        $("#txtdue").val(due.toFixed(2));
      } // calculate end

    $("#txtdiscount").keyup(function (){
      let discount = $(this).val();
      calculate(discount,0);
    })

    $("#txtpaid").keyup(function (){
      let paid = $(this).val();
      let discount = $("#txtdiscount").val();

      calculate(discount,paid);
    })

  });
</script>
<?php
include_once 'footer.php';
?>
