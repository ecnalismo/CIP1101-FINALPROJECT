<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
   $delete_admins->execute([$delete_id]);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin accounts</title>

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

   <h1 class="heading">admin accounts</h1>

   <div class="">

   
      <table>
<tr>
    <th>ID</th>
    <th>NAME</th>
    <th>ACTION</th>
  </tr>

   <?php
      $select_accounts = $conn->prepare("SELECT * FROM `admins`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>

  <tr>
    <td><span><?= $fetch_accounts['id']; ?></span></td>
    <td><span><?= $fetch_accounts['name']; ?></span></td>
    <td>      <div class="flex-btn">
         <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account?')" class="delete-btn">delete</a>
         <?php
            if($fetch_accounts['id'] == $admin_id){
            
            }
         ?>
      </div></td>
  </tr>
   <?php
         }
      }else{
         echo '<p class="empty">no accounts available!</p>';
      }
   ?>
  </table>
   </div>
   </div>
   <a href="register_admin.php" class="option-btn">Add Admin</a>
</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>