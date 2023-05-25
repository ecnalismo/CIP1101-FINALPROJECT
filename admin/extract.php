<?php

include 'DBController.php';
$db_handle = new DBController();
$productResult = $db_handle->runQuery("SELECT * FROM orders");

if (isset($_POST["export"])){

    $filename = "Export_excel.xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $isPrintHeader = false;
    if (! empty($productResult)) {
        foreach ($productResult as $row) {
            if (! $isPrintHeader) {
                echo implode("\t", array_keys($row)) . "\n";
                $isPrintHeader = true;
            }
            echo implode("\t", array_values($row)) . "\n";
        }
    }
    exit();
}

?>


<div>

<table>
<thead>
    <tr>
    <th>Data of Order</th>
    <th>Name</th>
    <th>Number</th>
    <th>Address</th>
    <th>Total Product</th>
    <th>Total Price</th>
    <th>Payment Method</th>
    </tr>
</thead>
<tbody>
    <?php
    $query = $db_handle->runQuery("SELECT * FROM orders");
    if (! empty($productResult)) {
        foreach ($productResult as $key => $value){
            ?>
            <tr>
            <td><?php echo $productResult[$key]['placed_on']; ?></td>
            <td><?php echo $productResult[$key]['name']; ?></td>
            <td><?php echo $productResult[$key]['number']; ?></td>
            <td><?php echo $productResult[$key]['address']; ?></td>
            <td><?php echo $productResult[$key]['total_products']; ?></td>
            <td><?php echo $productResult[$key]['total_price']; ?></td>
            <td><?php echo $productResult[$key]['method']; ?></td>
        </tr>
            <?php
        }
    
    }
    ?>
                  </tbody>
                  </table>


</div>