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
            <h1>Read Order Detail</h1>
        </div>

        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // select all data
        $query = "SELECT order_detail.order_detail_id, order_detail.order_id, products.name, order_detail.quantity FROM order_detail INNER JOIN products ON products.id=order_detail.product_id";
        if (!empty($search)) {
            $query .= " WHERE order_id LIKE :search OR order_detail_id LIKE :search OR quantity LIKE :search OR name LIKE :search";
            $search = "%{$search}%";
        }

        $query .= " ORDER BY order_detail_id ASC";

        $stmt = $con->prepare($query);

        if (!empty($search)) {
            $stmt->bindParam(':search', $search);
        }

        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        ?><div class="d-flex justify-content-between align-items-center">
            <div><a href='order_create.php' class='btn btn-primary m-b-1em'>Create New Order</a></div>
            <div class="w-50">
                <form method="GET" action="" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by name" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <?php //check if more than 0 record found
        if ($num > 0) {
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th class='col-1'>Order Detail ID</th>";
            echo "<th class='col-1'>Order ID</th>";
            echo "<th>Product Name</th>";
            echo "<th>Quantity</th>";
            echo "</tr>";

            // table body will be here
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<tr>";
                echo "<td>{$order_detail_id}</td>";
                echo "<td>{$order_id}</td>";
                echo "<td>{$name}</td>";
                echo "<td>{$quantity}</td>";
            }
            // end table
            echo "</table>";

            // data from database will be here

        } else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>
        <!-- PHP code to read records will be here -->

    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>