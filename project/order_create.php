<?php include "validatelogin.php"; ?>
<html>

<head>
    <title>Create Order</title>
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

        $customer_query = "SELECT * FROM customers order by customer_id ASC";
        $customer_stmt = $con->prepare($customer_query);
        $customer_stmt->execute();
        $customers = $customer_stmt->fetchAll(PDO::FETCH_ASSOC);

        $product_query = "SELECT * FROM products";
        $product_stmt = $con->prepare($product_query);
        $product_stmt->execute();
        $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

        $error = array();
        if ($_POST) {

            $product_id = $_POST["product"];
            $quantity = $_POST["quantity"];
            $customer_id = $_POST['customer'];

            $status_query = "SELECT * FROM customers WHERE customer_id=?";
            $status_stmt = $con->prepare($status_query);
            $status_stmt->bindParam(1, $customer_id);
            $status_stmt->execute();
            $statuss = $status_stmt->fetch(PDO::FETCH_ASSOC);
            if ($customer_id == "") {
                $error[] = "Please choose your user name.";
            } else if ($statuss['account_status'] == "Inactive") {
                $error[] = "Inactive account can't make a order";
            }

            $noduplicate = array_unique($product_id);

            if (sizeof($noduplicate) != sizeof($product_id)) {
                foreach ($product_id as $key => $val) {
                    if (!array_key_exists($key, $noduplicate)) {
                        $error[] = "Duplicated products not allowed.";
                        unset($quantity[$key]);
                    }
                }
            }
            $product_id = array_values($noduplicate);
            $quantity = array_values($quantity);

            $selected_product_count = isset($noduplicate) ? count($noduplicate) : count($_POST['product']);

            if (isset($selected_product_count)) {
                for ($i = 0; $i < $selected_product_count; $i++) {
                    if ($product_id[$i] == "") {
                        $error[] = " Please choose the product for NO " . $i + 1 . ".";
                    }

                    if ($quantity[$i] == 0 || empty($quantity[$i])) {
                        $error[] = "Quantity Can not be zero or empty.";
                    } else if ($quantity[$i] < 0) {
                        $error[] = "Quantity Can not be negative number.";
                    }
                }
            }

            try {
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
                    $total_amount = 0;
                    for ($x = 0; $x < $selected_product_count; $x++) {
                        $price_query = "SELECT * FROM products WHERE id=?";
                        $price_stmt = $con->prepare($price_query);
                        $price_stmt->bindParam(1, $product_id[$x]);
                        $price_stmt->execute();
                        $prices = $price_stmt->fetch(PDO::FETCH_ASSOC);

                        $amount =  ($prices['promotion_price'] != 0) ?  $prices['promotion_price'] * $quantity[$x] : $prices['price'] * $quantity[$x];

                        $total_amount += $amount;
                    }

                    $order_summary_query = "INSERT INTO order_summary SET customer_id=:customer_id, total_amount=:total_amount, order_date=:order_date";
                    $order_summary_stmt = $con->prepare($order_summary_query);
                    $order_summary_stmt->bindParam(":customer_id", $customer_id);
                    $order_summary_stmt->bindParam(":total_amount", $total_amount);
                    $order_summary_stmt->bindParam(":order_date", $order_date);
                    $order_summary_stmt->execute();

                    $order_id = $con->lastInsertId(); //Get the order_id from last inserted row.

                    for ($i = 0; $i < $selected_product_count; $i++) {
                        $order_detail_query = "INSERT INTO order_detail SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                        $order_detail_stmt = $con->prepare($order_detail_query);
                        $order_detail_stmt->bindParam(":order_id", $order_id);
                        $order_detail_stmt->bindParam(":product_id", $product_id[$i]);
                        $order_detail_stmt->bindParam(":quantity", $quantity[$i]);
                        $order_detail_stmt->execute();
                    }
                    header("Location: order_detail_read.php?order_id={$order_id}");
                    $_POST = array();
                }
            } catch (PDOException $exception) {
                echo '<div class="alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
            }
        }
        ?>
        <div>
            <form action="" method="post">
                <select name="customer" id="customer" class="form-select w-50 my-4">
                    <option value="">Choose your name</option>
                    <?php
                    for ($x = 0; $x < count($customers); $x++) {
                        $customer_selected = isset($_POST["customer"]) && $customers[$x]['customer_id'] == $_POST["customer"] ? "selected" : "";
                        echo "<option value='{$customers[$x]['customer_id']}' $customer_selected>{$customers[$x]['user_name']}</option>";
                    }
                    ?>
                </select>
                <table class="table table-hover table-responsive table-bordered" id="row_del">
                    <tr>
                        <th>NO.</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                    <?php

                    $product_loop = (!empty($error)) ? $selected_product_count : 1;
                    for ($x = 0; $x < $product_loop; $x++) {

                    ?>
                        <tr class="pRow">
                            <td class="col-1">
                                <?php echo $x + 1; ?>
                            </td>
                            <td>
                                <select name="product[]" id="product" class="form-select" value>
                                    <option value="">Choose a Product</option>
                                    <?php
                                    for ($i = 0; $i < count($products); $i++) {
                                        $product_selected = isset($_POST["product"]) && $products[$i]['id'] == $product_id[$x] ? "selected" : "";
                                        echo "<option value='{$products[$i]['id']}' $product_selected>{$products[$i]['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="quantity[]" id="quantity" value="<?php echo isset($_POST['quantity']) ? $quantity[$x] : 1; ?>">

                            </td>
                            <td>
                                <input href='#' onclick='deleteRow(this)' class='btn d-flex justify-content-center btn-danger mt-1' readonly value="Delete" />
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td>
                            <input type="button" value="Add More Product" class="btn btn-success add_one" />
                        </td>
                        <td></td>
                    </tr>
                </table>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Place Order</button>
                    <a href="order_read.php" class="btn btn-danger">Back to Read Order Summary</a>
                </div>
            </form>
            <script>
                document.addEventListener('click', function(event) {
                    if (event.target.matches('.add_one')) {
                        var rows = document.getElementsByClassName('pRow');
                        // Get the last row in the table
                        var lastRow = rows[rows.length - 1];
                        // Clone the last row
                        var clone = lastRow.cloneNode(true);
                        const [productsSelect, quantityInput] = clone.querySelectorAll('select[name="product[]"], input[name="quantity[]"]');
                        productsSelect.value = "";
                        quantityInput.value = 1;
                        // Insert the clone after the last row
                        lastRow.insertAdjacentElement('afterend', clone);

                        // Loop through the rows
                        for (var i = 0; i < rows.length; i++) {
                            // Set the inner HTML of the first cell to the current loop iteration number
                            rows[i].cells[0].innerHTML = i + 1;
                        }
                    }
                }, false);

                function deleteRow(r) {
                    var total = document.querySelectorAll('.pRow').length;
                    if (total > 1) {
                        var i = r.parentNode.parentNode.rowIndex;
                        document.getElementById("row_del").deleteRow(i);

                        var rows = document.getElementsByClassName('pRow');
                        for (var i = 0; i < rows.length; i++) {
                            // Set the inner HTML of the first cell to the current loop iteration number
                            rows[i].cells[0].innerHTML = i + 1;
                        }
                    } else {
                        alert("You need order at least one item.");
                    }
                }
            </script>
        </div>
    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>