<?php include "validatelogin.php"; ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Create Product</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container p-0 bg-light">
        <?php
        include 'menu.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Create Product Category</h1>
        </div>

        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';

            $category_name = $_POST['category_name'];
            $description = $_POST['description'];
            $formatted_name = ucwords(strtolower($category_name));

            try {

                // insert query
                $query = "INSERT INTO product_category SET category_name=:category_name, description=:description";
                // prepare query for execution
                $stmt = $con->prepare($query);
                // Bind the parameters
                $stmt->bindParam(':category_name', $formatted_name);
                $stmt->bindParam(':description', $description);

                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success m-3'>Record was saved.</div>";
                    $_POST = array();
                } else {
                    echo "<div class='alert alert-danger m-3'>Unable to save the record.</div>";
                }
            }

            // show error
            catch (PDOException $exception) {
                if ($exception->getMessage() == 23000) {
                    echo "<div class='alert alert-danger' role='alert'> The category has been exist.</div>";
                } else {
                    echo  "<div class='alert alert-danger' role='alert'>" . $exception->getMessage() . "</div>";
                }
            }
        }
        ?>

        <div class="p-3">
            <!-- html form here where the product information will be entered -->
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Name</td>
                        <td><input type='text' name='category_name' id='category_name' class='form-control' value="<?php echo isset($_POST['category_name']) ? $_POST['category_name'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><textarea name='description' id='description' class='form-control'><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save' class='btn btn-primary' />
                            <a href='product_category_read.php' class='btn btn-danger'>Back to read categories</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <!-- end container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>