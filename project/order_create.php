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
        <div class="page-header">
            <h1>Create Order</h1>
        </div>
        <?php
        include 'config/database.php';

        $customer_query = "SELECT customer_id, user_name FROM customers";
        $customer_stmt = $con->prepare($customer_query);
        $customer_stmt->execute();

        $customers = $customer_stmt->fetchAll(PDO::FETCH_ASSOC);

        $product_query = "SELECT id, name FROM products";
        $product_stmt = $con->prepare($product_query);
        $product_stmt->execute();

        $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($_POST) {
            try {
                $error = array();

                for ($i = 1; $i <= 3; $i++) {
                    $product_id = $_POST["product{$i}"];
                    $quantity = $_POST["quantity{$i}"];
                    if (empty($quantity)) {
                        $quantity_err = $product_stmt->fetch(PDO::FETCH_ASSOC);
                        $error[] = "Please fill in the quantity for product " . $i . ".";
                    } else if ($quantity == 0) {
                        $error[] = "Quantity Can not be zero.";
                    }
                }

                if (!empty($error)) {
                    echo "<div class='alert alert-danger role='alert'>";
                    foreach ($error as $error_message) {
                        echo $error_message . "<br>";
                    }
                    echo "</div>";
                } else {
                    $customer_id = $_POST['customer'];
                    date_default_timezone_set('Asia/Kuala_Lumpur');
                    $order_date = date('Y-m-d H:i:s');

                    $order_sumary_query = "INSERT INTO order_sumary SET customer_id=:customer_id, order_date=:order_date";
                    $order_sumary_stmt = $con->prepare($order_sumary_query);
                    $order_sumary_stmt->bindParam(":customer_id", $customer_id);
                    $order_sumary_stmt->bindParam(":order_date", $order_date);
                    $order_sumary_stmt->execute();

                    $order_id = $con->lastInsertId();

                    for ($i = 1; $i <= 3; $i++) {
                        $product_id = $_POST["product{$i}"];
                        $quantity = $_POST["quantity{$i}"];

                        $order_detail_query = "INSERT INTO order_detail SET order_id=:order_id, customer_id=:customer_id, product_id=:product_id, quantity=:quantity";
                        $order_detail_stmt = $con->prepare($order_detail_query);
                        $order_detail_stmt->bindParam(":order_id", $order_id);
                        $order_detail_stmt->bindParam(":customer_id", $customer_id);

                        $order_detail_stmt->bindParam(":product_id", $product_id);
                        $order_detail_stmt->bindParam(":quantity", $quantity);
                        $order_detail_stmt->execute();
                    }
                    echo "<div class='alert alert-success' role='alert'>Order Placed Successfully.</div>";
                }
            } catch (PDOException $exception) {
                echo '<div class="alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
            }
        }
        ?>
        <div>
            <form action="" method="post">
                <select name="customer" id="customer" class="form-select w-50 my-4">
                    <?php
                    foreach ($customers as $customer) {
                        echo "<option value='{$customer['customer_id']}'>{$customer['user_name']}</option>";
                    }
                    ?>
                </select>
                <table class="table table-hover table-responsive table-bordered">
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                    </tr>
                    <?php for ($i = 1; $i <= 3; $i++) : ?>
                        <tr>
                            <td>
                                <select name="product<?php echo $i ?>" id="product" class="form-select">
                                    <?php
                                    foreach ($products as $product) {
                                        echo "<option value='{$product['id']}'>{$product['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="quantity<?php echo $i ?>" id="quantity" min="1">
                            </td>
                        </tr>
                    <?php endfor ?>
                </table>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Place Order</button>
                </div>
            </form>
        </div>
    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>