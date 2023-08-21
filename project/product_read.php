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
        <div class="page-header">
            <h1>Read Products</h1>
        </div>

        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }

        if ($action == 'failed') {
            echo "<div class='alert alert-danger'>The Product has been ordered.</div>";
        }

        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // select all data
        //inner join method to make query that combine two tables
        $query = "SELECT products.id, products.name, products.description, products.promotion_price, products.price, products.image, product_category.category_name FROM products INNER JOIN product_category  ON products.category_id = product_category.id";
        if (!empty($search)) {
            $query .= " WHERE name LIKE :search";
            $search = "%{$search}%";
        }

        $query .= " ORDER BY id ASC";

        $stmt = $con->prepare($query);

        if (!empty($search)) {
            $stmt->bindParam(':search', $search);
        }

        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        ?><div class="d-flex justify-content-between align-items-center">
            <div><a href='product_create.php' class='btn btn-primary m-b-1em'>Create New Product</a></div>
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
            echo "<th>ID</th>";
            echo "<th>Name</th>";
            echo "<th>Category</th>";
            echo "<th>Description</th>";
            echo "<th>Price</th>";
            echo "<th>Image</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            // table body will be here
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$name}</td>";
                echo "<td>{$category_name}</td>";
                echo "<td class='col-6'>{$description}</td>";
                if ($promotion_price != 0) {
                    echo "<td class='d-flex justify-content-end'><p class='me-1 text-decoration-line-through''>" . number_format((float)$price, 2, '.', '') . "</p><p >"  . number_format((float)$promotion_price, 2, '.', '') .  "</p></td>";
                } else {
                    echo "<td class='text-end'>" . number_format((float)$price, 2, '.', '') . "</td>";
                }
                if ($image == "") {
                    echo '<td><img src="img/productpicture.png" height="100px" alt=""></td>';
                } else {
                    echo '<td><img src="' . $image . '" height="100px" alt=""></td>';
                }
                echo "<td class='col-3 text-center'>";
                // read one record
                echo "<a href='product_read_one.php?id={$id}' class='btn btn-info m-r-1em mx-2'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='product_update.php?id={$id}' class='btn btn-primary m-r-1em mx-2'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_product({$id});'  class='btn btn-danger mx-2'>Delete</a>";
                echo "</td>";
                echo "</tr>";
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
    <script type='text/javascript'>
        // confirm record deletion
        function delete_product(id) {

            if (confirm('Are you sure?')) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'product_delete.php?id=' + id;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>