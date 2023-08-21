<?php include "validatelogin.php"; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <?php include 'menu.php' ?>
        <div class="page-header">
            <h1>Update Product</h1>
        </div>
        <!-- PHP read record by ID will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT products.id, products.name, products.category_id, products.description, products.promotion_price, products.price, products.manufacture_date, products.expired_date, products.image, product_category.category_name FROM products INNER JOIN product_category  ON products.category_id = product_category.id WHERE products.id = ? LIMIT 0,1";

            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['name'];
            $description = $row['description'];
            $category_id = $row['category_id'];
            $price = $row['price'];
            $promotion_price = $row['promotion_price'];
            $manufacture_date = $row['manufacture_date'];
            $expired_date = $row['expired_date'];
            $image = $row['image'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <!-- HTML form to update record will be here -->
        <?php
        // check if form was submitted
        if ($_POST) {
            try {
                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                $query = "UPDATE products
                SET name=:name, description=:description, category_id=:category_id,
                price=:price, promotion_price=:promotion_price,manufacture_date=:manufacture_date, expired_date=:expired_date, image=:image  WHERE products.id = :id";
                // prepare query for excecution
                $stmt = $con->prepare($query);
                // posted values
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
                $category_id = $_POST['category_id'];
                $price = htmlspecialchars(strip_tags($_POST['price']));
                $promotion_price = htmlspecialchars(strip_tags($_POST['promotion_price']));
                $manufacture_date = htmlspecialchars($_POST['manufacture_date']);
                $expired_date = htmlspecialchars($_POST['expired_date']);
                $image = !empty($_FILES["image"]["name"])
                    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                    : "";
                $image = htmlspecialchars(strip_tags($image));
                // upload to file to folder
                $target_directory = "uploads/";
                $target_file = $target_directory . $image;
                $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                $errorMessage = array();

                if ($image) {
                    //Check whether the size of image isn't square
                    $image_check = getimagesize($_FILES['image']['tmp_name']);
                    $image_width = $image_check[0];
                    $image_height = $image_check[1];
                    if ($image_width != $image_height) {
                        $errorMessage[] = "Only square size image allowed.";
                    }
                    // make sure submitted file is not too large, can't be larger than 1 MB
                    if ($_FILES['image']['size'] > (524288)) {
                        $errorMessage[] = "<div>Image must be less than 512 KB in size.</div>";
                    }
                    // make sure that file is a real image
                    if ($image_check == false) {
                        $errorMessage[] = "<div>Submitted file is not an image.</div>";
                    }
                    // make sure certain file types are allowed
                    $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                    if (!in_array($file_type, $allowed_file_types)) {
                        $errorMessage[] = "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                    }
                    // make sure file does not exist
                    if (file_exists($target_file)) {
                        $errorMessage[] = "<div>Image already exists. Try to change file name.</div>";
                    }
                }

                if (empty($name)) {
                    $errorMessage[] = "Name field is empty.";
                }
                if (empty($description)) {
                    $errorMessage[] = "Description field is empty.";
                }
                if (empty($price)) {
                    $errorMessage[] = "Price field is empty.";
                } else if (!is_numeric($price)) {
                    $errorMessage[] = "Prices can only be numbers.";
                }
                if (!is_numeric($promotion_price)) {
                    $errorMessage[] = "Promotion prices can only be numbers.";
                }
                if (empty($manufacture_date)) {
                    $errorMessage[] = "Manufacture date field is empty.";
                }
                if (empty($expired_date)) {
                    $errorMessage[] = "Expired date field is empty.";
                }
                if ($promotion_price >= $price) {
                    $errorMessage[] = "Promotion price must be cheaper than the original price.";
                }
                if ($expired_date <= $manufacture_date) {
                    $errorMessage[] = "Expired date must be later than the manufacture date.";
                }



                if (!empty($errorMessage)) {
                    echo "<div class='alert alert-danger m-3'>";
                    foreach ($errorMessage as $displayErrorMessage) {
                        echo $displayErrorMessage . "<br>";
                    }
                    echo "</div>";
                } else {
                    // bind the parameters
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(":category_id", $category_id);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':promotion_price', $promotion_price);
                    $stmt->bindParam(":manufacture_date", $manufacture_date);
                    $stmt->bindParam(":expired_date", $expired_date);
                    if ($image == "") {
                        $stmt->bindParam(":image", $row['image']);
                    } else {
                        $stmt->bindParam(':image', $target_file);
                    }
                    $stmt->bindParam(':id', $id);
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was updated.</div>";
                        if ($image) {
                            if ($target_file != $row['image'] && $row['image'] != "") {
                                unlink($row['image']);
                            }
                            // make sure the 'uploads' folder exists
                            // if not, create it
                            if (!is_dir($target_directory)) {
                                mkdir($target_directory, 0777, true);
                            }
                            // if $file_upload_error_messages is still empty
                            if (empty($file_upload_error_messages)) {
                                // it means there are no errors, so try to upload the file
                                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                    // it means photo was uploaded
                                } else {
                                    echo "<div class='alert alert-danger'>";
                                    echo "<div>Unable to upload photo.</div>";
                                    echo "<div>Update the record to upload photo.</div>";
                                    echo "</div>";
                                }
                            }

                            // if $file_upload_error_messages is NOT empty
                            else {
                                // it means there are some errors, so show them to user
                                echo "<div class='alert alert-danger'>";
                                echo "<div>{$file_upload_error_messages}</div>";
                                echo "<div>Update the record to upload photo.</div>";
                                echo "</div>";
                            }
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
            }
            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        } ?><!-- PHP post to update record will be here -->

        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea></td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td><select name='category_id' class='form-select'>
                            <?php
                            include "config/database.php";
                            $category_sql = "SELECT id, category_name FROM product_category";
                            $category_stmt = $con->prepare($category_sql);
                            $category_stmt->execute();

                            while ($category_row = $category_stmt->fetch(PDO::FETCH_ASSOC)) {
                                $all_category = $category_row['id'];
                                $category_name = $category_row['category_name'];

                                $selected = ($all_category == $row['category_id']) ? "selected" : "";
                                echo "<option value='" . $all_category . "' $selected>" . htmlspecialchars($category_name) . "</option>";
                            }


                            ?></select></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>promotion_price</td>
                    <td><input type='text' name='promotion_price' value="<?php echo htmlspecialchars($promotion_price, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td><input type='date' name='manufacture_date' value="<?php echo htmlspecialchars($manufacture_date, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Expired Date</td>
                    <td><input type='date' name='expired_date' value="<?php echo htmlspecialchars($expired_date, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Image</td>
                    <td>
                        <?php if ($image == "") { ?>
                            <img src="img/productpicture.png" width="200px" alt="">
                        <?php } else { ?>
                            <img src="<?php echo htmlspecialchars($image, ENT_QUOTES); ?>" width="200px" alt="">
                        <?php } ?><br><br>
                        <input type='file' name='image' accept="image/*" class='form-control' />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>