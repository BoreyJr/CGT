<?php
include_once 'dbconnect.php';
session_start();
if ($_SESSION['user_email'] == "" or $_SESSION['role'] = "") {
  header('location:index.php');
}
function fill_product($pdo,$p_id)
{
  $output='';

  $select = $pdo->prepare("select * from tb_product order by p_name asc");
  $select->execute();

  $result=$select->fetchAll();

  foreach ($result as $row){

    $output.='<option value="'.$row["p_id"].'"';

    if($p_id == $row['p_id']){
      $output.='selected';

    }
    $output.='>'.$row["p_name"].'</option>';
  }
  return $output;
}
$id =$_GET['id'];
$select = $pdo->prepare("select * from tb_invoice where invoice_id=$id");
$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);

$customername = $row['customer_name'];
$order_date = date('Y-m-d',strtotime($row['order_date']));
$subtotal = $row['sub_total'];
$tax = $row['tax'];
$discount = $row['discount'];
$total = $row['total'];
$paid = $row['paid'];
$due = $row['due'];
$payment_type = $row['payment_type'];

$select = $pdo->prepare("select * from tb_invoice_detail where invoice_id=$id");
$select->execute();
$row_invoice_detail = $select->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['btnupdateorder']))
{
///GET THE VALUES FROM THE TEXT FIELDS //1
  $txt_customername = $_POST['txtcustomername'];
  $txt_order_date =date('Y-m-d',strtotime($_POST['orderdate']));
  $txt_subtotal = $_POST["txtsubtotal"];
  $txt_tax = $_POST['txttax'];
  $txt_discount = $_POST['txtdiscount'];
  $txt_total = $_POST['txttotal'];
  $txt_paid = $_POST['txtpaid'];
  $txt_due = $_POST['txtdue'];
  $txt_payment_type = $_POST['r1'];

  ///array value
  $arr_productid = $_POST['productid'];
  $arr_productname = $_POST['productname'];
  $arr_stock = $_POST['productstock'];
  $arr_qty = $_POST['qty'];
  $arr_price = $_POST['price'];
  $arr_total =  $_POST['total'];

  //Write update query for tb product stock  //2

  foreach($row_invoice_detail as $item_invoice_detail)
  {
    $updateproduct = $pdo->prepare("update tb_product set p_stock=p_stock+".$item_invoice_detail['qty']." where p_id='".$item_invoice_detail['product_id']."'");

    $updateproduct->execute();
  }

  //Write delete query for tb_invoice_detail table data where invoice_id = $id  3

  $delete_invoice_deltail = $pdo->prepare("delete from tb_invoice_detail where invoice_id=$id");
  $delete_invoice_deltail->execute();

  //Write Update query for tb_invoice table data  4

  $update_invoice = $pdo->prepare("update tb_invoice set customer_name=:cust,order_date=:orderdate,sub_total=:subtotal,tax=:tax,discount=:disc,total=:total,paid=:paid,due=:due,payment_type=:paytype where invoice_id=$id");

  $update_invoice->bindParam(':cust',$txt_customername);
  $update_invoice->bindParam(':orderdate',$txt_order_date);
  $update_invoice->bindParam(':subtotal',$txt_subtotal);
  $update_invoice->bindParam(':tax',$txt_tax);
  $update_invoice->bindParam(':disc',$txt_discount);
  $update_invoice->bindParam(':total',$txt_total);
  $update_invoice->bindParam(':paid',$txt_paid);
  $update_invoice->bindParam(':due',$txt_due);
  $update_invoice->bindParam(':paytype',$txt_payment_type);

  $update_invoice->execute();

  // 2nd insert query for tb_invoice_detail

  $invoice_id = $pdo->lastInsertId();
  if($invoice_id != null)
  {
    for($i=0; $i<count($arr_productid); $i++){

      // 5 write select query for tb_product table to get out stock value  5

      $selectpdt = $pdo->prepare("select * from tb_product where p_id='".$arr_productid[$i]."'");
      $selectpdt->execute();

      while($rowpdt = $selectpdt->fetch(PDO::FETCH_OBJ)){
          $db_stock[$i] = $rowpdt->p_stock;

        $rem_qty =$db_stock[$i] - $arr_qty[$i];
        if($rem_qty < 0)
        {
          return "Order is not Update";
        }
        else{
            /// write update query for tb product table to update stock value 6

          $update = $pdo->prepare("update tb_product set p_stock ='$rem_qty' where p_id ='".$arr_productid[$i]."'");

          $update->execute();
        }
      }
      /// write insert query for tb invoice for insert new record  7

      $insert = $pdo->prepare("insert into tb_invoice_detail(invoice_id,product_id,product_name,qty,price,order_date) VALUES (:invoiceid,:p_id,:p_name,:qty,:price,:orderdate)");

      $insert->bindParam(':invoiceid',$id);
      $insert->bindParam(':p_id',$arr_productid[$i]);
      $insert->bindParam(':p_name',$arr_productname[$i]);
      $insert->bindParam(':qty',$arr_qty[$i]);
      $insert->bindParam(':price',$arr_price[$i]);
      $insert->bindParam(':orderdate',$txt_order_date);

      $insert->execute();
    }
    $URL="orderlist.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
  }
}
if($_SESSION['role']=="admin"){
  include_once "header.php";
}
else
{
  include_once "headeruser.php";
}
?>
<div class="content-wrapper">
  <div class="content container-fluid">
    <div class="card card-info">
      <form action="" method="post" name="">
        <div class="card-header with-border bg-primary">
          <h3 class="card-title"><h3 class="text-center font-weight-bold"></h3>Edit Ordered Invoice ID :<?php echo $id;?></h3>
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
                  <input type="text" class="form-control" name="txtcustomername"  value="<?php echo $customername;?>" required>

                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label >Date:<?php  echo $order_date; ?></label>
                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" name="orderdate"  data-target="#reservationdate" value="<?php echo $order_date;?>">
                  <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>  <!-- this is for customer and dete -->

        <div class="card-body">  <!-- this is for Table -->
          <div class="col-md-12">
            <div style="overflow-x:auto;">
              <table class="table table-striped table-hover " id="tableproduct">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Search Product</th>
                  <th>Stock Quantity</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Total</th>
                  <th><button name="btnadd" class="btn btn-info btn-sm btnadd" ><i  class="fas fa-plus"></i></button></th>
                </tr>
                </thead>
                <?php
                foreach($row_invoice_detail as $item_invoice_detail)
                {
                  $select = $pdo->prepare("select * from tb_product where p_id = '{$item_invoice_detail['product_id']}'");
                  $select->execute();
                  $row_product = $select->fetch(PDO::FETCH_ASSOC);
                ?>
                <tr>
                <?php
                echo '<td><input type="hidden" class="form-control pname" name="productname[]" value="'.$row_product['p_name'].'" readonly></td>';
                echo '<td><select class="form-control producteditid" style="width: 250px"; name="productid[]"><option value="">Select Product</option>'.fill_product($pdo,$item_invoice_detail['product_id']).'</select></td>';
                echo '<td><input type="text"  class="form-control productstock"  name="productstock[]" value="'.$row_product['p_stock'].'" readonly></td>';
                echo '<td><input type="text" class="form-control price" name="price[]" value="'.$row_product['p_price'].'" readonly></td>';
                echo '<td><input type="number" min="1" class="form-control qty" name="qty[]" value="'.$item_invoice_detail['qty'].'" ></td>';
                echo '<td><input type="text"  class="form-control total" name="total[]" value="'.$row_product['p_price'] * $item_invoice_detail['qty'].'" readonly></td>';
                echo '<td><button name="remove" class="btn btn-danger btn-sm  btnremove align-middle"><i  class="fas fa-times align-middle"></i></button></td>';
                 ?>
                </tr>
                <?php } ?>
              </table>
            </div>

          </div>
        </div>   <!-- this for table -->
        <div class="card-body">
          <div class="row ">
            <div class="col-md-6">

              <div class="form-group">
                <label>Sub Total</label>
                <div class="input-group">
                  <div class="input-group-append">
                    <div class="input-group-text"> <i class="fas fa-file-invoice-dollar"></i></div>
                  </div>
                  <input type="text" class="form-control-lg" style="border:none" value="<?php echo $subtotal; ?>" name="txtsubtotal" id="txtsubtotal"
                         readonly>
                </div>
              </div>

              <div class="form-group">
                <label>Tax (0%)</label>
                <div class="input-group">
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fas fa-hand-holding-usd"></i></div>
                  </div>
                  <input type="text" class="form-control-lg"  value="<?php echo $tax; ?>"  name="txttax" id="txttax" readonly>
                </div>
              </div>

              <div class="form-group">
                <label>Discount</label>
                <div class="input-group">
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fas fa-percentage"></i></div>
                  </div>
                  <input type="text" class="form-control-lg"   value="<?php echo $discount; ?>" name="txtdiscount" id="txtdiscount"
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
                  <input type="text" style="border:none ;color: red;" class="form-control-lg font-weight-bold"  value="<?php echo $total;?>" name="txttotal" id="txttotal" readonly>
                </div>
              </div>

              <div class="form-group">
                <label>Paid</label>
                <div class="input-group">
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                  </div>
                  <input type="text" class="form-control-lg"  value="<?php echo $paid;?>" name="txtpaid" id="txtpaid" required>
                </div>
              </div>

              <div class="form-group">
                <label>Due</label>
                <div class="input-group">
                  <div class="input-group-append">
                    <div class="input-group-text"><i class="far fa-calendar"></i></div>
                  </div>
                  <input type="text" style="color:blue;" class="form-control-lg"  value="<?php echo $due; ?>"  name="txtdue" id="txtdue" readonly
                  >
                </div>
              </div>

              <br>

              <label>Payment method</label>
              <div class="form-group clearfix" aria-required="true">

                <div class="icheck-danger d-inline">
                  <input type="radio" id="radioPrimary1"  name="r1"   value="CASH"<?php echo ($payment_type=='CASH')?'checked':''?>>
                  <label for="radioPrimary1"> CASH
                  </label>
                </div>
                <div class="icheck-danger d-inline">
                  <input type="radio" id="radioPrimary2" VALUE="TRANSFER" name="r1"<?php echo ($payment_type=='TRANSFER')?'checked':''?>>
                  <label for="radioPrimary2">  TRANSFER
                  </label>
                </div>
                <div class="icheck-danger d-inline">
                  <input type="radio" id="radioPrimary3" value="CHECK" name="r1"<?php echo ($payment_type=='CHECK')?'checked':''?>>
                  <label for="radioPrimary3">
                    CHECK
                  </label>
                </div>
              </div>

            </div>

          </div>   <!-- row -->

          <hr>
          <input type="submit" name="btnupdateorder" value="Update" class="btn btn-warning btn-block text-danger font-weight-bold">
          <!--          <div class="row">-->
          <!--            <div class="col-md-5"></div>-->
          <!---->
          <!--            <div class="col-md-2">-->
          <!---->
          <!--            </div>-->
          <!--            <div class="col-md-5"></div>-->
          <!--          </div>-->

        </div>

      </form>
    </div>
  </div>
</div>
<script>
  //Date range picker
  $('#reservationdate').datetimepicker({
    format: 'YYYY-MM-DD'
  })

  $(document).ready(function(){

    //select 2 element initi
    $('.producteditid').select2()

    $(".producteditid").on('change',function (e){

      var productid = this.value;
      var tr=$(this).parent().parent();

      $.ajax({
        url:"getproduct.php",
        method:"get",
        data:{id:productid},
        success:function (data)

        {
          // console.log(data);
          tr.find(".pname").val(data["p_name"]);
          tr.find(".productstock").val(data["p_stock"]);
          tr.find(".price").val(data["p_price"]);
          tr.find(".qty").val(1);
          tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());

          calculate(0,0);
          $("#txtpaid").val("");
        }
      })
    })

    $(document).on('click','.btnadd',function () {
      console.log('btn add ');
      var html = '';
      html+='<tr>';
      html+='<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
      html+='<td><select class="form-control productid" style="width: 250px"; name="productid[]"><option value="">Select Product</option><?php echo fill_product($pdo,''); ?></select></td>';
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
            // console.log(data);
            tr.find(".pname").val(data["p_name"]);
            tr.find(".productstock").val(data["p_stock"]);
            tr.find(".price").val(data["p_price"]);
            tr.find(".qty").val(1);
            tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
            calculate(0,0);
            $("#txtpaid").val("");

          }
        })
      })

    })


    $(document).on('click','.btnremove',function(){

      $(this).closest('tr').remove();
      calculate(0,0);
      $("#txtpaid").val("");

    }) // btnremove end here



    $("#tableproduct").delegate(".qty","keyup change" ,function(){

      let quantity = $(this);
      let tr=$(this).parent().parent();
      $("#txtpaid").val("");

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
      tax = 0.05 * subtotal;
      net_total = tax + subtotal;
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
