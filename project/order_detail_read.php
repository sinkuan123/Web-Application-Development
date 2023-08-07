<?php include "validatelogin.php"; ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>

<body>
    <!-- container -->
    <div class="container">
        <?php include 'menu.php' ?>
        <div class="page-header p-3">
            <h1>Read Order Detail</h1>
        </div>
        <?php

        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

        include 'config/database.php';

        $customer_query = "SELECT * FROM customers";
        $customer_stmt = $con->prepare($customer_query);
        $customer_stmt->execute();
        $customers = $customer_stmt->fetchAll(PDO::FETCH_ASSOC);

        $product_query = "SELECT * FROM products";
        $product_stmt = $con->prepare($product_query);
        $product_stmt->execute();
        $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

        $order_summary_query = "SELECT * FROM order_summary WHERE order_id=:id";
        $order_summary_stmt = $con->prepare($order_summary_query);
        $order_summary_stmt->bindParam(":id", $order_id);
        $order_summary_stmt->execute();
        $order_summaries = $order_summary_stmt->fetch(PDO::FETCH_ASSOC);

        $order_detail_query = "SELECT * FROM order_detail WHERE order_id=:order_id";
        $order_detail_stmt = $con->prepare($order_detail_query);
        $order_detail_stmt->bindParam(":order_id", $order_id);
        $order_detail_stmt->execute();
        $order_details = $order_detail_stmt->fetchAll(PDO::FETCH_ASSOC);

        $total_amount = 0;
        ?>
        <div>
            <form action="" method="post">
                <div class="d-flex justify-content-between m-4">
                    <h5>Ordered By: <?php echo $customers[$order_summaries['customer_id'] - 1]['first_name'] . " " . $customers[$order_summaries['customer_id'] - 1]['last_name'] ?></h5>
                    <h5>Order Date and Time: <?php echo $order_summaries['order_date'] ?></h5>
                </div>

                <table class="table table-hover table-responsive table-bordered" id="row_del">
                    <tr>
                        <th>NO.</th>
                        <th class="col-8">Product</th>
                        <th>Price (RM/Unit)</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>
                    <?php

                    $product_loop = count($order_details);
                    for ($x = 0; $x < $product_loop; $x++) {

                    ?>
                        <tr class="pRow">
                            <td class="col-1">
                                <?php echo $x + 1; ?>
                            </td>
                            <td>
                                <?php echo $products[$order_details[$x]['product_id'] - 1]['name'] ?>
                            </td>
                            <?php
                            if ($products[$order_details[$x]['product_id'] - 1]['promotion_price'] != 0) {
                                echo "<td class='d-flex justify-content-end'><p class='me-1 text-decoration-line-through''> RM" . number_format((float)$products[$order_details[$x]['product_id'] - 1]['price'], 2, '.', '') . "</p><p > RM"  . number_format((float)$products[$order_details[$x]['product_id'] - 1]['promotion_price'], 2, '.', '') .  "</p></td>";
                            } else {
                                echo "<td class='text-end'> RM" . number_format((float)$products[$order_details[$x]['product_id'] - 1]['price'], 2, '.', '') . "</td>";
                            } ?>
                            <td>
                                <p class="text-end"><?php echo $order_details[$x]['quantity'] ?></p>
                            </td>
                            <td>
                                <?php $amount =  ($products[$order_details[$x]['product_id'] - 1]['promotion_price'] != 0) ?  $products[$order_details[$x]['product_id'] - 1]['promotion_price'] * $order_details[$x]['quantity'] : $products[$order_details[$x]['product_id'] - 1]['price'] * $order_details[$x]['quantity'];

                                $total_amount += $amount;
                                echo "<p class='text-end'>RM" . number_format((float)$amount, 2, '.', '') . "</p>" ?>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
                <h2 class="text-end">Total Amount: RM<?php echo number_format((float)$total_amount, 2, '.', ''); ?></h2>

                <div class="text-center">
                    <a href="order_read.php" class="btn btn-danger">Back to Read Order Summary</a>
                </div>
            </form>
        </div>
    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>