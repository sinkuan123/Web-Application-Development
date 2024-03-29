<?php include "validatelogin.php"; ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Update Customer</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <?php include 'menu.php' ?>
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <?php
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        include 'config/database.php';

        try {
            $query = "SELECT customer_id, user_name, user_password, first_name, last_name, gender, date_of_birth, email, account_status, image FROM customers WHERE customer_id = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            $stmt->bindParam(1, $id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $user_name = $row['user_name'];
            $password = $row['user_password'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $gender = $row['gender'];
            $date_of_birth = $row['date_of_birth'];
            $email = $row['email'];
            $account_status = $row['account_status'];
            $image = $row['image'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        if ($_POST) {
            try {
                if (isset($_POST['delete_image'])) {
                    $empty = "";
                    $delete_query = "UPDATE customers SET image=:image WHERE customer_id = :id";
                    $delete_stmt = $con->prepare($delete_query);
                    $delete_stmt->bindParam(":image", $empty);
                    $delete_stmt->bindParam(":id", $id);
                    $delete_stmt->execute();
                    unlink($image);
                    header("Location: customer_read_one.php?id={$id}");
                } else {
                    $query = "UPDATE customers
                SET first_name=:first_name, last_name=:last_name, gender=:gender, date_of_birth=:date_of_birth, email=:email,
                account_status=:account_status, image=:image";
                    // prepare query for excecution

                    // posted values
                    $user_name = htmlspecialchars(strip_tags($_POST['user_name']));
                    $old_password = $_POST['old_password'];
                    $new_password = $_POST['new_password'];
                    $confirm_password = $_POST['confirm_password'];
                    $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                    $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                    $gender = htmlspecialchars(strip_tags($_POST['gender']));
                    $date_of_birth = htmlspecialchars(strip_tags($_POST['date_of_birth']));
                    $email = htmlspecialchars(strip_tags($_POST['email']));
                    $account_status = htmlspecialchars(strip_tags($_POST['account_status']));
                    $image = !empty($_FILES["image"]["name"])
                        ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                        : "";
                    $image = htmlspecialchars(strip_tags($image));
                    $usernamePattern = "/^[A-Za-z][A-Za-z0-9_-]{5,}$/";
                    $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/";
                    // upload to file to folder
                    $target_directory = "uploads/";
                    $target_file = $target_directory . $image;
                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
                    $error = array();

                    if ($image) {
                        //Check whether the size of image isn't square
                        $image_check = getimagesize($_FILES['image']['tmp_name']);

                        // make sure submitted file is not too large, can't be larger than 1 MB
                        if ($_FILES['image']['size'] > (524288)) {
                            $error[] = "Image must be less than 512 KB in size.";
                        }
                        // make sure that file is a real image
                        if ($image_check == false) {
                            $error[] = "Submitted file is not an image.";
                        }
                        // make sure certain file types are allowed
                        $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                        if (!in_array($file_type, $allowed_file_types)) {
                            $error[] = "Only JPG, JPEG, PNG, GIF files are allowed.";
                        } else {
                            $image_width = $image_check[0];
                            $image_height = $image_check[1];
                            if ($image_width != $image_height) {
                                $error[] = "Only square size image allowed.";
                            }
                        }
                        // make sure file does not exist
                        if (file_exists($target_file)) {
                            $error[] = "<div>Image already exists. Try to change file name.</div>";
                        }
                    }

                    if (!empty($old_password) && !empty($new_password) && !empty($confirm_password)) {
                        if ($new_password == $confirm_password) {
                            if ($old_password == $password) {
                                if ($old_password == $new_password) {
                                    $error[] = "New Password can't be same with Old Password";
                                } else {
                                    $formatted_password = $new_password;
                                }
                            } else {
                                $error[] = "Wrong password entered in old password column";
                            }
                        } else {
                            $error[] = "The confirm password doesn't match with new password.";
                        }
                    } else if (!empty($old_password)) {
                        if (empty($new_password) || empty($confirm_password)) {
                            $error[] = "Fill all three password field to update password.";
                        }
                    } else if (!empty($new_password)) {
                        if (empty($old_password) || empty($confirm_password)) {
                            $error[] = "Fill all three password field to update password.";
                        }
                    } else if (!empty($confirm_password)) {
                        if (empty($new_password) || empty($old_password)) {
                            $error[] = "Fill all three password field to update password.";
                        }
                    }

                    if (empty($first_name)) {
                        $error[] = "First Name field is empty.";
                    }
                    if (empty($last_name)) {
                        $error[] = "Last Name field is empty.";
                    }

                    if (empty($email)) {
                        $error[] = "Email field is empty.";
                    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $error[] = "Invalid Email format.";
                    }

                    if (empty($date_of_birth)) {
                        $error[] = "Date of Birth field is empty.";
                    } elseif ($date_of_birth > date('Y-m-d')) {
                        $error[] = "Date of Birth can't be latest than today.";
                    }

                    if (!empty($error)) {
                        echo "<div class='alert alert-danger m-3'>";
                        foreach ($error as $errorMessage) {
                            echo $errorMessage . "<br>";
                        }
                        echo "</div>";
                    } else {
                        if (isset($formatted_password)) {
                            $query .= ", user_password=:user_password";
                        }

                        $query .= " WHERE customer_id=:id";
                        $stmt = $con->prepare($query);
                        $stmt->bindParam(":id", $id);
                        if (isset($formatted_password)) {
                            $stmt->bindParam(':user_password', $formatted_password);
                        }
                        $stmt->bindParam(':first_name', $first_name);
                        $stmt->bindParam(':last_name', $last_name);
                        $stmt->bindParam(':gender', $gender);
                        $stmt->bindParam(':date_of_birth', $date_of_birth);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':account_status', $account_status);
                        if ($image == "") {
                            $stmt->bindParam(":image", $row['image']);
                        } else {
                            $stmt->bindParam(':image', $target_file);
                        }
                        // Execute the query
                        if ($stmt->execute()) {
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
                            header("Location: customer_read_one.php?id={$id}");
                        } else {
                            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                        }
                    }
                }
            }
            // show errors
            catch (PDOException $exception) {
                if ($exception->getCode() == 23000) {
                    echo '<div class="alert alert-danger role=alert">' . 'Email has been taken.' . '</div>';
                } else {
                    echo '<div class="alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
                }
            }
        } ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>User Name</td>
                    <td><input type='text' name='user_name' readonly value="<?php echo htmlspecialchars($user_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <input type="password" name="old_password" class="form-control" placeholder="Old Password" value="<?php isset($_POST['old_password']) ? $_POST['old_password'] : '' ?>">
                        <input type="password" name="new_password" class="form-control" placeholder="New Password" value="<?php isset($_POST['new_password']) ? $_POST['new_password'] : '' ?>">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" value="<?php isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '' ?>">
                    </td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='first_name' value="<?php echo htmlspecialchars($first_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='last_name' value="<?php echo htmlspecialchars($last_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>

                    <td><input type="radio" id="male" name="gender" value="Male" <?php if ($row['gender'] == "Male") {
                                                                                        echo 'checked';
                                                                                    } ?>>

                        <label for="male">Male</label><br>
                        <input type="radio" id="female" name="gender" value="Female" <?php if ($row['gender'] == "Female") {
                                                                                            echo 'checked';
                                                                                        } ?>>
                        <label for="female">Female</label><br>
                        <input type="radio" id="others" name="gender" value="Others" <?php if ($row['gender'] == "Others") {
                                                                                            echo 'checked';
                                                                                        } ?>>
                        <label for="others">Others</label>
                    </td>
                </tr>
                <tr>
                    <td>Date Of Birth</td>
                    <td><input type='date' name='date_of_birth' value="<?php echo htmlspecialchars($date_of_birth, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type='email' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td><input type="radio" id="active" name="account_status" value="Active" <?php if ($row['account_status'] == "Active") {
                                                                                                    echo 'checked';
                                                                                                } ?>>

                        <label for="active">Active</label><br>
                        <input type="radio" id="inactive" name="account_status" value="Inactive" <?php if ($row['account_status'] == "Inactive") {
                                                                                                        echo 'checked';
                                                                                                    } ?>>
                        <label for="inactive">Inactive</label>
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
                        <?php if ($image != "") { ?>
                            <input type="submit" value="Delete Image" class="btn btn-danger" name="delete_image">
                        <?php } ?>
                        <a href='customer_read.php' class='btn btn-info'>Back to read customers</a>
                    </td>
                </tr>
            </table>
        </form>

    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>