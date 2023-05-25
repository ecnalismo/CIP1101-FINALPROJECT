<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
   $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_payment->execute([$payment_status, $order_id]);
   $message[] = 'payment status updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>placed orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<style>
table {
   font-family: Arial, Helvetica, sans-serif;
   border-collapse: collapse;
   width: 100%;
 }
 
td, th {
   border: 1px solid #ddd;
   padding: 8px;
 }
 
th {
   padding-top: 12px;
   padding-bottom: 12px;
   text-align: left;
   background-color: #212222e8;
   color: white;
 }

</style>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="orders">

<h1 class="heading">placed orders</h1>

<div >
<table>
  <tr>
    <th>Data of Order</th>
    <th>Name</th>
    <th>Number</th>
    <th>Address</th>
    <th>Total Product</th>
    <th>Total Price</th>
    <th>Payment Method</th>
    <th>Action</th>
  </tr>
   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders`");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
  



  <tr>
    <td><span><?= $fetch_orders['placed_on']; ?></span></td>
    <td><span><?= $fetch_orders['name']; ?></td>
    <td><span><?= $fetch_orders['number']; ?></span></td>
    <td><span><?= $fetch_orders['address']; ?></td>
    <td><span><?= $fetch_orders['total_products']; ?></td>
    <td><span>₱<?= $fetch_orders['total_price']; ?>.00</span></td>
    <td><span><?= $fetch_orders['method']; ?></span></td>
    <td> <form action="" method="post">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <select name="payment_status" class="select">
            <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
            <option value="pending">pending</option>
            <option value="completed">completed</option>
         </select>
        <div class="flex-btn">
         <input type="submit" value="update" class="option-btn" name="update_payment">
         <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
        </div>
      </form></td>
  </tr>





   </div>

   <?php
         }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
   ?>

</div>
</table>

<div>
                     <form action="extract.php" method="post"> 
                  <button  class="delete-btn" type="submit" name="export" value="Export to Excel">Extract Data</button>
                     </form>

                  </div>

</section>




</section>










<script src="../js/admin_script.js"></script>
   
</body>
</html>