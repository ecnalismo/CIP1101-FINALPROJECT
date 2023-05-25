<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_user->execute([$delete_id]);
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_orders->execute([$delete_id]);
   $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE user_id = ?");
   $delete_messages->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users accounts</title>

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

<section class="accounts">

   <h1 class="heading">user accounts</h1>

   <div>

   <table>
  <tr>
    <th>ID</th>
    <th>USERNAME</th>
    <th>EMAIL</th>
    <th>ACTION</th>
  </tr>

   <?php
      $select_accounts = $conn->prepare("SELECT * FROM `users`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>

  <tr>
    <td><span><?= $fetch_accounts['id']; ?></span></td>
    <td><span><?= $fetch_accounts['name']; ?></span></td>
    <td><span><?= $fetch_accounts['email']; ?></span></td>
    <td><a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account? the user related information will also be delete!')" class="delete-btn">delete</a></td>
  </tr>

</table>
   <?php
         }
      }else{
         echo '<p class="empty">no accounts available!</p>';
      }
   ?>

   </div>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>