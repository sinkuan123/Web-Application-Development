<?php include "validatelogin.php"; ?>
<html>

<head>
    <title>Home</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        body {
            background-image: url(img/login_bg.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <!-- container -->
    <div class="container p-0">
        <?php
        include 'menu.php';
        ?>
        <div class="font-monospace container col my-3">
            <h1>Welcome to SK Stationery Store</h1>
        </div>
        <?php
        include "config/database.php";

        $customer_query = "SELECT * FROM customers";
        $customer_stmt = $con->prepare($customer_query);
        $customer_stmt->execute();
        $customers = $customer_stmt->fetchAll(PDO::FETCH_ASSOC);

        $product_query = "SELECT * FROM products";
        $product_stmt = $con->prepare($product_query);
        $product_stmt->execute();
        $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

        $order_summary_query = "SELECT * FROM order_summary";
        $order_summary_stmt = $con->prepare($order_summary_query);
        $order_summary_stmt->execute();
        $order_summaries = $order_summary_stmt->fetchAll(PDO::FETCH_ASSOC);

        $order_detail_query = "SELECT * FROM order_detail";
        $order_detail_stmt = $con->prepare($order_detail_query);
        $order_detail_stmt->execute();
        $order_details = $order_detail_stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="container bg-dark bg-opacity-25 py-5">
            <h2 class="mx-5 text-black text-center">An Overview of Our Store.</h2>
            <div class="container row mt-5 justify-content-around">
                <div class="col-3 border border-3 shadow p-5 text-center bg-white">
                    <h3>Total Number of Customers</h3>
                    <p class="mt-3 fs-4"><?php echo count($customers); ?></p>
                </div>
                <div class="col-3 border border-3 shadow p-5 text-center bg-white">
                    <h3>Total Number of Products</h3>
                    <p class="mt-3 fs-4"><?php echo count($products); ?></p>
                </div>
                <div class="col-3 border border-3 shadow p-5 text-center bg-white">
                    <h3>Total Number of Orders</h3>
                    <p class="mt-3 fs-4"><?php echo count($order_summaries); ?></p>
                </div>
            </div>
        </div>
        <div class="container bg-dark bg-opacity-25">
            <h2 class="mx-5 text-black text-center">An Overview of Order</h2>
            <div class="container row mt-5 justify-content-around">
                <div class="col-4 border border-3 shadow p-5 text-center bg-white">
                    <h3>Latest Order ID and Summary</h3>
                    <p class="mt-3"><span>Customer Name :</span>
                        <?php
                        $latest_order_query = "SELECT * FROM order_summary WHERE order_id=(SELECT MAX(order_id) FROM order_summary)";
                        $latest_order_stmt = $con->prepare($latest_order_query);
                        $latest_order_stmt->execute();
                        $latest_order = $latest_order_stmt->fetch(PDO::FETCH_ASSOC);

                        $customer_id = $latest_order['customer_id'];

                        $latest_customer_name_query = "SELECT * FROM customers where customer_id=?";
                        $latest_customer_name_stmt = $con->prepare($latest_customer_name_query);
                        $latest_customer_name_stmt->bindParam(1, $customer_id);
                        $latest_customer_name_stmt->execute();
                        $latest_names = $latest_customer_name_stmt->fetch(PDO::FETCH_ASSOC);
                        echo $latest_names['first_name'] . " " . $latest_names['last_name'];
                        ?>
                    </p>
                    <p><span>Order Date :</span>
                        <?php echo $latest_order['order_date']; ?>
                    </p>
                    <p><span>Total Amount :</span>
                        <?php echo "RM " . number_format((float)$latest_order['total_amount'], 2, '.', ''); ?>
                    </p>
                </div>
                <div class="col-4 border border-3 shadow p-5 text-center bg-white">
                    <h3>Highest Purchased Amount Order</h3>
                    <p class="mt-3"><span>Customer Name :</span>
                        <?php
                        $highest_order_query = "SELECT * FROM order_summary WHERE total_amount=(SELECT MAX(total_amount) FROM order_summary)";
                        $highest_order_stmt = $con->prepare($highest_order_query);
                        $highest_order_stmt->execute();
                        $highest_order = $highest_order_stmt->fetch(PDO::FETCH_ASSOC);

                        $customer_id = $highest_order['customer_id'];

                        $highest_customer_name_query = "SELECT * FROM customers where customer_id=?";
                        $highest_customer_name_stmt = $con->prepare($highest_customer_name_query);
                        $highest_customer_name_stmt->bindParam(1, $customer_id);
                        $highest_customer_name_stmt->execute();
                        $highest_names = $highest_customer_name_stmt->fetch(PDO::FETCH_ASSOC);
                        echo $highest_names['first_name'] . " " . $highest_names['last_name'];
                        ?>
                    </p>
                    <p><span>Order Date :</span>
                        <?php echo $highest_order['order_date']; ?>
                    </p>
                    <p><span>Total Amount :</span>
                        <?php echo "RM " . number_format((float)$highest_order['total_amount'], 2, '.', ''); ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="container bg-dark bg-opacity-25 py-5">
            <h2 class="mx-5 text-black text-center">Top 5 Selling Products</h2>
            <div class="container my-5 row mx-auto">
                <?php
                $top_product_query = "SELECT product_id, SUM(quantity) AS total_quantity FROM order_detail GROUP BY product_id ORDER BY total_quantity DESC";
                $top_product_stmt = $con->prepare($top_product_query);
                $top_product_stmt->execute();
                $top_products = $top_product_stmt->fetchAll(PDO::FETCH_ASSOC);

                for ($i = 0; $i < 5; $i++) {
                    if (!empty($top_products[$i])) {
                        $top_product_id = $top_products[$i]['product_id'];
                        $top_product_name_query = "SELECT * FROM products WHERE id=?";
                        $top_product_name_stmt = $con->prepare($top_product_name_query);
                        $top_product_name_stmt->bindParam(1, $top_product_id);
                        $top_product_name_stmt->execute();
                        $top_product_details = $top_product_name_stmt->fetch(PDO::FETCH_ASSOC);
                        echo '<div class="col border border-3 rounded-3 mx-3 shadow p-2 text-center bg-white">';
                        echo "<div><img src='" . $top_product_details['image'] . "' width='100px'>";
                        echo "<p>" . $top_product_details['name'] . "<br>";
                        if ($top_product_details['promotion_price'] != 0) {
                            echo "<div class='d-flex justify-content-center'><p class='me-1 text-decoration-line-through''>" . number_format((float)$top_product_details['price'], 2, '.', '') . "</p><p >"  . number_format((float)$top_product_details['promotion_price'], 2, '.', '') .  "</p></div>(";
                        } else {
                            echo "<p>" . number_format((float)$top_product_details['price'], 2, '.', '') . "</p>(";
                        }
                        echo  $top_products[$i]['total_quantity'] . " SOLD)</div></div>";
                    } else {
                        echo "";
                    }
                }
                ?>
            </div>
            <h2 class="mx-5 text-black text-center">3 Products Never Purchased</h2>
            <div class="container my-5 row mx-auto">
                <?php
                $no_purchased_product_query = "SELECT id FROM products WHERE NOT EXISTS(SELECT product_id FROM order_detail WHERE order_detail.product_id=products.id)";
                $no_purchased_product_stmt = $con->prepare($no_purchased_product_query);
                $no_purchased_product_stmt->execute();
                $no_purchased_products = $no_purchased_product_stmt->fetchAll(PDO::FETCH_ASSOC);

                for ($i = 0; $i < 3; $i++) {
                    if (!empty($no_purchased_products[$i])) {
                        $no_purchased_product_id = $no_purchased_products[$i]['id'];
                        $no_purchased_product_name_query = "SELECT * FROM products WHERE id=?";
                        $no_purchased_product_name_stmt = $con->prepare($no_purchased_product_name_query);
                        $no_purchased_product_name_stmt->bindParam(1, $no_purchased_product_id);
                        $no_purchased_product_name_stmt->execute();
                        $no_purchased_product_details = $no_purchased_product_name_stmt->fetch(PDO::FETCH_ASSOC);
                        echo '<div class="col border border-3 rounded-3 mx-3 shadow p-2 text-center bg-white">';
                        echo "<div><img src='" . $no_purchased_product_details['image'] . "' width='100px'>";
                        echo "<p>" . $no_purchased_product_details['name'] . "<br>";
                        if ($no_purchased_product_details['promotion_price'] != 0) {
                            echo "<div class='d-flex justify-content-center'><p class='me-1 text-decoration-line-through''>" . number_format((float)$no_purchased_product_details['price'], 2, '.', '') . "</p><p >"  . number_format((float)$no_purchased_product_details['promotion_price'], 2, '.', '') .  "</p></div>(";
                        } else {
                            echo "<p>" . number_format((float)$no_purchased_product_details['price'], 2, '.', '') . "</p></div></div>";
                        }
                    } else {
                        echo "";
                    }
                }
                ?>
            </div>
        </div>
        <!-- end container -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>