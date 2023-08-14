<?php include "validatelogin.php"; ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Home</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container p-0">
        <?php
        include 'menu.php';
        ?>
        <div class="font-monospace container col mt-3">
            <h1>Welcome to E-Commerce Website</h1>
        </div>
        <?php
        include "config/database.php";

        $customer_query = "SELECT * FROM customers ORDER BY customer_id ASC";
        $customer_stmt = $con->prepare($customer_query);
        $customer_stmt->execute();
        $customers = $customer_stmt->fetchAll(PDO::FETCH_ASSOC);

        $product_query = "SELECT * FROM products ORDER BY id ASC";
        $product_stmt = $con->prepare($product_query);
        $product_stmt->execute();
        $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

        $order_summary_query = "SELECT * FROM order_summary ORDER BY order_id ASC";
        $order_summary_stmt = $con->prepare($order_summary_query);
        $order_summary_stmt->execute();
        $order_summaries = $order_summary_stmt->fetchAll(PDO::FETCH_ASSOC);

        $order_detail_query = "SELECT * FROM order_detail ORDER BY order_id ASC";
        $order_detail_stmt = $con->prepare($order_detail_query);
        $order_detail_stmt->execute();
        $order_details = $order_detail_stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div>

            <div class="container row my-5 justify-content-around">
                <div class="col-3 border border-3 shadow p-5 text-center">
                    <h2>Total Number of Customers</h2>
                    <p class="mt-3 fs-4"><?php echo count($customers); ?></p>
                </div>
                <div class="col-3 border border-3 shadow p-5 text-center">
                    <h2>Total Number of Products</h2>
                    <p class="mt-3 fs-4"><?php echo count($products); ?></p>
                </div>
                <div class="col-3 border border-3 shadow p-5 text-center">
                    <h2>Total Number of Orders</h2>
                    <p class="mt-3 fs-4"><?php echo count($order_summaries); ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- end container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>