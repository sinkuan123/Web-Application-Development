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
            <h1>Create Product</h1>
        </div>

        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // insert query
                $name = $_POST['name'];
                $category_id = $_POST['category_id'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                // new 'image' field
                $image = !empty($_FILES["image"]["name"])
                    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                    : "";
                $image = htmlspecialchars(strip_tags($image));

                $promotion_price = $_POST['promotion_price'];
                $manufacture_date = $_POST['manufacture_date'];
                $expired_date = $_POST['expired_date'];


                //Datetime objects
                $dateStart = new DateTime($manufacture_date);
                $dateEnd = new DateTime($expired_date);

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
                    $query = "INSERT INTO products SET name=:name, category_id=:category_id, description=:description, price=:price, promotion_price=:promotion_price, manufacture_date=:manufacture_date, expired_date=:expired_date, image=:image, created=:created";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // Bind the parameters
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':category_id', $category_id);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':promotion_price', $promotion_price);
                    $stmt->bindParam(':manufacture_date', $manufacture_date);
                    $stmt->bindParam(':expired_date', $expired_date);
                    $stmt->bindParam(":image", $target_file);
                    $created = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':created', $created);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success m-3'>Record was saved.</div>";
                        // now, if image is not empty, try to upload the image
                        if ($image) {
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

                        $_POST = array();
                    } else {
                        echo "<div class='alert alert-danger m-3'>Unable to save the record.</div>";
                    }
                }
            }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <div class="p-3">
            <!-- html form here where the product information will be entered -->
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Name</td>
                        <td><input type='text' name='name' id='name' class='form-control' value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td>
                            <select name="category_id" id="category_id" class="form-select">
                                <?php
                                include "config/database.php";
                                $mysql = "SELECT id, category_name FROM product_category";
                                $stmt = $con->prepare($mysql);
                                $stmt->execute();
                                $num = $stmt->rowCount();

                                if ($num > 0) {
                                    $options = array();
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $options[$row['id']] = $row['category_name'];
                                    }
                                }

                                foreach ($options as $id => $category_name) {
                                    echo "<option value='" . $id . "'>" . $category_name . "</option>";
                                }


                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><textarea name='description' id='description' class='form-control'><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><input type='text' name='price' id='price' class='form-control' value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Promotion Price</td>
                        <td><input type='text' name='promotion_price' id='promotion_price' class='form-control' value="<?php echo isset($_POST['promotion_price']) ? $_POST['promotion_price'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Manufacture Date</td>
                        <td><input type='date' name='manufacture_date' class='form-control' value="<?php echo isset($_POST['manufacture_date']) ? $_POST['manufacture_date'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Expired Date</td>
                        <td><input type='date' name='expired_date' class='form-control' value="<?php echo isset($_POST['expired_date']) ? $_POST['expired_date'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Photo</td>
                        <td><input type="file" name="image" class="form-control" accept="image/*"></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save' class='btn btn-primary' />
                            <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
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